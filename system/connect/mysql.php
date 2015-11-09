<?php
define('DB_HOST', "localhost");
define('DB_NAME', "system");
define('DB_USER', "root"); 
define('DB_PASS', "");

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS) or die("<div class='msgBox1'>MYSQL ERROR!</div>");
mysqli_select_db($conn, DB_NAME) or die("<div class='msgBox1'>MYSQL ERROR!</div>");
mysqli_set_charset($conn, 'utf8') or die("<div class='msgBox1'>No se puede contactar con la base de datos!</div>");
?>