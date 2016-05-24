<?php
function loadClass($class) {
    if (class_exists($class, false) || interface_exists($class, false)) {
        return;
    }
    $file = INCLUDE_ROOT . "lib/{$class}.class.php";
    if (file_exists($file)) {
        include_once $file;
        return;
    }
    $file = INCLUDE_ROOT . "lib/{$class}.php";
    if (file_exists($file)) {
        include_once $file;
        return;
    }
}