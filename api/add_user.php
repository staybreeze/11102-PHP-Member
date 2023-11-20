<?php

// 避免重複導入，因此once就好
include_once "../inc/connect.php";

// 資料清洗
// 先把acc資料存在變數裡
// trim — 去除字元串首尾處的空白字元（或者其他字元）
// htmlspecialchars — 將特殊字元轉換為 HTML 實體(也就是變成字串，就像&nbsp;)
//     & (& 符號) 變成	&amp;
//     " (雙引號) 變成	&quot;，除非設定了 ENT_NOQUOTES
//     ' (單引號) 變成	設定了 ENT_QUOTES 後， &#039; (如果是 ENT_HTML401) ，或者 &apos; (如果是 ENT_XML1、 ENT_XHTML 或 ENT_HTML5)。
//     < (小於)	  變成  &lt;
//     > (大於)   變成	&gt;
$acc=htmlspecialchars(trim($_POST['acc']));



// 導入FUNCTION後不需要了
// $sql="insert into `users`(`acc`,`pw`,`name`,`address`,`email`)
//                     values('{$_POST['acc']}','{$_POST['pw']}','{$_POST['name']}','{$_POST['address']}','{$_POST['email']}')";


// $pdo->exec($sql);


insert("users",['acc'=>"{$acc}",
                 'pw'=>"{$_POST['pw']}",
                 'name'=>"{$_POST['name']}",
                 'email'=>"{$_POST['email']}",
                 'address'=>"{$_POST['address']}"]);


header("Location:../index.php");

