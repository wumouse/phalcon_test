<?php
if (!file_exists(__DIR__ . '/' . $_SERVER['PATH_INFO'])) {
    $_GET['_url'] = $_SERVER['PATH_INFO'];
}
return false;
