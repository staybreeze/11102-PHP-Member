<?php

include_once "./inc/connect.php";

$sql="update `users` set `acc`='{$_POST['acc']}',
                         `pw`='{$_POST['pw']}',
                         `name`='{$_POST['name']}',
                         `email`='{$_POST['email']}',
                         `address`='{$_POST['address']}' 
    where `id`='{$_POST['id']}'";


    if($pdo->exec($sql)>0){
// 自定義$_SESSION讓頁面回到member.php時，可以判斷資料有無更新成功
        $_SESSION['msg']="更新成功";
      }else{
        $_SESSION['msg']="資料無異動";
      }


header("location:member.php");