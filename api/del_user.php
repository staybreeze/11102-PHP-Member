<?php

include_once "../inc/connect.php";

$sql="delete from `users` where `id`='{$_GET['id']}'";


$pdo->exec($sql);

unset($_SESSION['user']);

header("location:../index.php");