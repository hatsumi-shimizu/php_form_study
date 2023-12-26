<?php

// 作成途中
session_start();

$error_message = "";

if(isset($POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  try {
    $db = new PDO('mysql:host=localhost; dbname=データベース名','root', 'root');
    $sql = 'select count(*) from users(認証するテーブル名) where username=root and password=root';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($username, $password));
    $result = $stmt->fetch();
    $stmt = null;
    $db = null;

    if ($result[0] != 0){
      header('Location: http://localhost/login.php');
      exit;
    } else {
      $error_message = "入力情報が間違っています。";
    }  

  } catch(PDOException $e) {
    echo $e->getMessage();
    exit;
  }
}

session_destroy();