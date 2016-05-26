<?php
/*func start*/
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

function is_magic_open(){
    if(@get_magic_quotes_gpc())	return true;
    return false;
}

function get_post_var($name){
    if (!$name || !isset($_POST[$name])) return "";
    if(is_magic_open())	return stripslashes($_POST[$name]);
    return $_POST[$name];
}

function get_get_var($name){
    if (!$name || !isset($_GET[$name])) return "";
    if(is_magic_open()) return stripslashes($_GET[$name]);
    return $_GET[$name];
}

function get_request_var($name){
    if (!$name || !isset($_REQUEST[$name])) return "";
    if(is_magic_open()) return stripslashes($_REQUEST[$name]);
    return $_REQUEST[$name];
}

function get_cookie_var($name){
    if (!$name || !isset($_COOKIE[$name])) return "";
    if(is_magic_open()) return stripslashes($_COOKIE[$name]);
    return $_COOKIE[$name];
}
/*func end*/

/*js start*/
function alert($str)
{
    echo "<script language =\"javascript\"> alert(\"".$str."\")</script>\r\n";
}

function set_url($url)
{
    echo "<script language =\"javascript\">window.location = \"".$url."\"</script>\r\n";
    echo "<br>Page not auto-refreshed? <a href='$url'>click here</a> to manual refresh.<br>";
}

function set_top_url($url)
{
    echo "<script language =\"javascript\">top.location = \"".$url."\"</script>\r\n";
}

function top_url_refresh()
{
    echo "<script language =\"javascript\">top.location.refresh()</script>\r\n";
}

function url_refresh()
{
    echo "<script language =\"javascript\">window.location.refresh()</script>\r\n";
}

function opener_refresh()
{
    echo "<script language =\"javascript\">  if(window.opener) window.opener.location.reload();</script>\r\n";
}

function back()
{
    echo "<script language =\"javascript\">history.back(-1)</script>\r\n";
}

function close_window()
{
    echo "<script language =\"javascript\">window.close()</script>\r\n";
}
/* js end*/