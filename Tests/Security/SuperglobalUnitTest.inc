<?php

class TestSuperglobal
{
    protected $_server;
    protected $_get;
    protected $_request;
    protected $globals;

    public function go()
    {
        $a = $_GET;
        $b = $_get;
        $c = $this->_get;
        $d = $GLOBALS;
        $e = $_SERVER;
        $f = $_POST;
        $g = $_FILES['upload'];
        $h = $_COOKIE['sid'];
        $_SESSION = null;
        unset($_REQUEST);
    }
}
