<?php

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB', 'donor');

$koneksi = mysqli_connect(HOST, USER, PASS, DB) OR DIE ("Koneksi Tidak Berhasil: " . mysqli_connect_error());

?>