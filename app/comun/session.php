<?php
require_once 'config.php';

session_name(SESSION_NAME);
session_start();

session_cache_expire(18000);
ini_set("session.gc_maxlifetime", "18000");
?>