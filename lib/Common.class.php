<?php

class Common {
    /**
     * debug and die
     *
     * @param $data
     */
    public static function debug($data) {
        echo '<pre>';
        print_r($data);
        exit;
    }

    /**
     * debug and no die
     *
     * @param $data
     */
    public static function debugNoDie($data) {
        echo '<pre>';
        print_r($data);
    }

    /**
     * 字符串加解密
     *
     * @param string $dataString 待加解密字符串
     * @param bool $isEncryption 是否加密
     * @return string 处理后结果
     */
    public static function stringChange($dataString = '', $isEncryption = true) {
        $charCodeTop = 126;
        $charCodeBottom = 33;
        $stepTop = 33;
        $stepBottom = 1;
        $charCodeArray = array();
        if (true === $isEncryption) {
            for ($cnt = $charCodeBottom; $cnt < $charCodeTop ; $cnt++) {
                $charCodeArray[$cnt]['f'] = $cnt - 1;
                $charCodeArray[$cnt]['b'] = $cnt + 1;
            }
            $charCodeArray[$charCodeBottom]['f'] = $charCodeTop;
            $charCodeArray[$charCodeTop]['f'] = $charCodeTop - 1;
            $charCodeArray[$charCodeTop]['b'] = $charCodeBottom;
        } else {
            for ($cnt = $charCodeBottom; $cnt < $charCodeTop ; $cnt++) {
                $charCodeArray[$cnt]['f'] = $cnt + 1;
                $charCodeArray[$cnt]['b'] = $cnt - 1;
            }
            $charCodeArray[$charCodeBottom]['b'] = $charCodeTop;
            $charCodeArray[$charCodeTop]['b'] = $charCodeTop - 1;
            $charCodeArray[$charCodeTop]['f'] = $charCodeBottom;
        }
        $supportDirectionArray = array(
            'f' => 'front',
            'b' => 'back',
        );
        $tmpDataString = trim($dataString);
        $returnStr = $tmpDataString;
        $tmpDataArray = str_split($tmpDataString, 1);
        if (empty($tmpDataArray) || 3 >= count($tmpDataArray)) {
            return $returnStr;
        } else {
            $step = intval($tmpDataArray[1]);
            if ($step < $stepBottom || $step > $stepTop) {
                return $returnStr;
            }
            $directTag = $tmpDataArray[2];
            if (!isset($supportDirectionArray[$directTag])) {
                return $returnStr;
            }
            $tmpArray = array();
            foreach ($tmpDataArray as $key => $char) {
                if (0 == $key || 1 == $key || 2 == $key) {
                    $tmpArray[$key] = $char;
                } else {
                    $tmpCharCode = ord($char);
                    if (!isset($charCodeArray[$tmpCharCode])) {
                        $tmpArray[$key] = $char;
                    } else {
                        $resultCharCode = $tmpCharCode;
                        for ($i = 1; $i <= $step; $i++) {
                            $resultCharCode = $charCodeArray[$resultCharCode][$directTag];
                        }
                        $tmpArray[$key] = chr($resultCharCode);
                    }
                }
            }
            $returnStr = implode('', $tmpArray);
            return $returnStr;
        }
    }

    public static function encryptString($dataString = '') {
        $returnStr = trim($dataString);
        if (empty($returnStr)) {
            return $returnStr;
        } else {
            $cnt = intval(substr($returnStr, 0, 1));
            for ($i = 1; $i <= $cnt; $i++) {
                $returnStr = self::stringChange($returnStr, true);
            }
            return $returnStr;
        }
    }

    public static function decryptString($dataString = '') {
        $returnStr = trim($dataString);
        if (empty($returnStr)) {
            return $returnStr;
        } else {
            $cnt = intval(substr($returnStr, 0, 1));
            for ($i = 1; $i <= $cnt; $i++) {
                $returnStr = self::stringChange($returnStr, false);
            }
            if (strlen($returnStr) > 3) {
                $returnStr = substr($returnStr, 3);
            } else {
                // do nothing
            }
            return $returnStr;
        }
    }
}