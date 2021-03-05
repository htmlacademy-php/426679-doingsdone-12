<?php
/**
*Очистка сессии
*
*/
session_start();

$_SESSION = [];
header("Location: index.php");
