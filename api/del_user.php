<?php

include_once "../inc/db.php";

// $sql="delete from `users` where `id`='{$_GET['id']}'";


// $pdo->exec($sql);

$User->del($_GET['id']);

unset($_SESSION['user']);

header("location:../index.php");