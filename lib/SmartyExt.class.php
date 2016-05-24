<?php
require_once INCLUDE_ROOT . 'lib/smarty/Smarty.class.php';

class SmartyExt extends Smarty {
    public function __construct($project = '', $tplDir = '', $configDir = '') {
        parent::__construct();
        if (!empty($tplDir) && substr($tplDir, 0, 1) != ''/'') {
            $tplDir = INCLUDE_DATA_ROOT . $tplDir;
        }
        $templateDir = $tplDir ? $tplDir : INCLUDE_DATA_ROOT . 'tpl';
        $compileDir = INCLUDE_DATA_ROOT . 'smarty/smarty_c/' . $project;
        $cacheDir = INCLUDE_DATA_ROOT . 'smarty/smarty_cache/' . $project;
        $configDir = $configDir ? $configDir : $this->template_dir;
        $this->setTemplateDir($templateDir)->setCompileDir($compileDir)->setCacheDir($cacheDir)->setConfigDir($configDir);

        $this->config_booleanize = false;
        $this->left_delimiter = '{';
        $this->right_delimiter = '}';
        $this->compile_check = defined('DEBUG_MODE') && DEBUG_MODE == false ? false : true;
    }
}

?>