<?php

class MysqlPdo {
    private $host = "";
    private $database = "";
    private $user = "";
    private $password = "";
    private $sth = null;
    private $pdo = null;
    private $queryArr = array();
    public $recordQueryMode = false;
    public $raiseErrorMode = DEBUG_MODE;

    public function __construct($database = DB_NAME, $host = DB_HOST, $user = DB_USER, $password = DB_PASS, $socket = DB_SOCKET) {
        $this->host = $host;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
        $this->socket = $socket;
        $this->connect();
    }

    public function connect() {
        if (!empty($this->socket) && ($this->host == 'localhost' || $this->host == '127.0.0.1')) {
            $pdo = 'mysql:unix_socket=' . $this->socket . ';host=' . $this->host . ';dbname=' . $this->database;
        } else {
            $pdo = 'mysql:host=' . $this->host . ';dbname=' . $this->database;
        }

        try {
            $this->pdo = new PDO($pdo, $this->user, $this->password);
            $this->setLog('connected to ' . $this->host . ' ' . $this->user . ' ' . $this->database);
        } catch (PDOException $e) {
            self::raiseError('Connect failed, ' . $this->host . ', ' . $e->getMessage(), __FILE__, __LINE__);
        }

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (defined('TIME_ZONE')) {
            $this->pdo->exec("SET time_zone = '" . TIME_ZONE . "'");
        }
        if (defined('DB_ENCODING')) {
            $this->pdo->exec("SET NAMES '" . DB_ENCODING . "'");
        } else {
            $this->pdo->exec('SET NAMES UTF8');
        }
    }

    public function query($sql) {
        if ($this->switchToWriteDBBySql($sql) == 'writetofile')
            return null;
        if ($this->recordQueryMode) {
            $result = array();
            $result['sql'] = $sql;
            $result['start'] = microtime(true);
            $this->sth = $this->pdo->query($sql);
            $result['end'] = microtime(true);
            $result['time'] = number_format($result['end'] - $result['start'], 3, '.', ' ');
            $result['backtrace'] = self::getDebugBacktrace("\t");
            $this->setLog($result);
        } else {
            try {
                $this->sth = $this->pdo->query($sql);
            } catch (PDOException $e) {
                self::raiseError('Query failed, ' . $sql . ', ' . $e->getMessage(), __FILE__, __LINE__);
            }
        }
        return $this->sth;
    }

    public function getRow(&$sth, $fetchType = PDO::FETCH_ASSOC) {
        return $sth->fetch($fetchType);
    }

    public function getLastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function getFirstRow($sql) {
        $sth = $this->query($sql);
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        if (is_array($row) && count($row) > 0)
            return $row;
        return array();
    }

    public function getFirstRowColumn($sql, $column_number = 0) {
        $sth = $this->query($sql);
        return $sth->fetchColumn($column_number);
    }

    function switchToWriteDB() {
        $sql = 'USE ' . $this->database;
        $this->switchToWriteDBBySql($sql);
    }

    function close() {
        $this->pdo = null;
    }

    function switchToWriteDBBySql(&$sql) {
        $this->switch_to_write_db = true;
        //is start with select or set
        list($sql_cmd) = preg_split('/[^a-z]/', strtolower(substr(ltrim($sql), 0, 10)));
        if ($sql_cmd == 'select' || $sql_cmd == 'set')
            return "skip";

        if (defined('INCLUDE_LOG_ROOT')) {
            $write_log_dir = INCLUDE_LOG_ROOT . 'mysql_write/';
        } else  {
            $write_log_dir = dirname(__FILE__) . '/mysql_write/';
        }
        $write_log_file = $write_log_dir . DB_NAME . '_' . gmdate('YmdH');
        if (file_exists($write_log_file)) {
            $line = date('Y-m-d H:i:s') . "\t" . DB_NAME . "\t" . str_replace(array("\r", "\n"), ' ', $sql) . ";\n";
            error_log($line, 3, $write_log_file);
            return 'writetofile';
        } else {
            $this->host = DB_WHOST;
            $this->close();
            if ($this->connect(false) === false) {
                //switch it back
                $this->host = DB_HOST;
                $this->connect();

                if (!is_dir($write_log_dir)) {
                    mkdir($write_log_dir, 0777, true);
                    chmod($write_log_dir, 0777);
                }
                $line = date('Y-m-d H:i:s') . "\t" . DB_NAME . "\t" . str_replace(array("\r", "\n"), " ", $sql) . ";\n";
                error_log($line, 3, $write_log_file);
                chmod($write_log_file, 0775);
                return 'writetofile';
            } else {
                $this->switch_to_write_db_result = true;
                return 'switched';
            }
        }
        return 'keepon';
    }

    public function getRows(&$sql, $keyname = '', $foundrows = false) {
        if ($foundrows && strpos(substr($sql, 0, 30), 'SQL_CALC_FOUND_ROWS') === false) {
            if (stripos($sql, 'select') === 0) {
                $sql = 'select SQL_CALC_FOUND_ROWS' . substr($sql, 6);
            }
        }
        $sth = $this->query($sql);
        $arr_return = array();
        if ($keyname) {
            $keys = explode(',', $keyname);
        }

        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            if ($keyname) {
                $arr_temp = array();
                foreach ($keys as $key) {
                    $arr_temp[] = $row[$key];
                }
                $key_value = implode('_', $arr_temp);
                $arr_return[$key_value] = $row;
            } else {
                $arr_return[] = $row;
            }
        }
        $sth->closeCursor();
        return $arr_return;
    }

    public function freeResult(&$sth) {
        $sth->closeCursor();
    }

    public function getFoundRows() {
        $this->FOUND_ROWS = $this->getFirstRowColumn('SELECT FOUND_ROWS()');
        if (!is_numeric($this->FOUND_ROWS)) {
            $this->FOUND_ROWS = 0;
        }
        return $this->FOUND_ROWS;
    }

    public function getAffectedRows() {
        return @$this->sth->rowCount();
    }

    public function recordQuery($result) {
        $this->queryArr[] = $result;
        $this->setLog($result);
    }

    function setLog($result) {
        if (!defined('INCLUDE_LOG_ROOT')) {
            return;
        }
        if (!is_dir(INCLUDE_LOG_ROOT)) {
            return;
        }

        $log_file = LOG_LOCATION . 'sqllog.txt';

        $status = 'good';
        $time = 0;
        if (is_array($result)) {
            $time = $result['time'];
            if ($time > 0.1) {
                $status = 'normal';
            } else {
                if ($time > 1) {
                    $status = 'slow';
                } else if ($time > 2)
                    $status = 'very slow';
            }

            $sql = $result['sql'];
            $sql = str_replace("\n", ' ', $sql);

            $backtrace = '';
            if (isset($result['backtrace'][0])) {
                $backtrace = end(explode('/', $result['backtrace'][0]));
            }
            $logline = date('Y-m-d H:i:s') . "\t$status\t$time\t$sql\t$backtrace\n";
        } else {
            $logline = date('Y-m-d H:i:s') . "\t$status\t$time\t$result\n";
        }

        @error_log($logline, 3, $log_file);
    }

    public function outputQuerys() {
        print_r($this->queryArr);
    }

    public function raiseError($errorMsg = '', $scripts = __FILE__, $line = __LINE__) {
        $this->errorMsg = $errorMsg;
        $this->time = date('Y-m-d H:i:s');
        $this->scriptName = $scripts;
        $this->line = $line;
        self::setErrorLog();

        if ($this->raiseErrorMode) {
            echo "ErrorMsg: {$this->errorMsg}\n";
            echo "Time: {$this->time}\n";
            echo "ScriptName: {$this->scriptName}\n";
            echo "BackTrace: \n" . implode("\n", self::getDebugBacktrace("\t"));
            exit;
        } else {
            echo '<b>500 Internal Error</b>';
            exit;
        }
    }

    public function setErrorLog() {
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        $req = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

        $logString = "{$this->time}\t{$this->scriptName}\t{$this->line}\t$ip\t$req\t$ref\t{$this->errorMsg}\n";
        if (defined('INCLUDE_LOG_ROOT') && defined('ERROR_LOG_NAME')) {
            @error_log($logString, 3, INCLUDE_LOG_ROOT . ERROR_LOG_NAME);
        }
    }

    public function getDebugBacktrace($prefix = "") {
        $debug_backtrace = debug_backtrace();
        krsort($debug_backtrace);
        foreach ($debug_backtrace as $k => $v) {
            if ($v['function'] != __FUNCTION__) {
                $result[] = $prefix . $v['file'] . ' => ' . $v['class'] . ' => ' . $v['function'] . ' => ' . $v['line'];
            }
        }
        return $result;
    }
}

?>