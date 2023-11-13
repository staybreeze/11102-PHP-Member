<?php
$dsn="mysql:host=localhost;charset=utf8;dbname=member";
$pdo=new PDO($dsn,'root','');

$sql="insert into `users`(`acc`,`pw`,`name`,`address`,`email`)
                    values('{$_POST['acc']}','{$_POST['pw']}','{$_POST['name']}','{$_POST['address']}','{$_POST['email']}')";


$pdo->exec($sql);

header("Location:index.php");