<?php

session_start();

require_once(__DIR__ . 'db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $errors = [];

  if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ) {
    $errors[] = 'メールアドレスを入力してください。';
  }

  if(empty($datas["password"])){
    $errors['password']  = "パスワードを入力してください。";
  }else if(!preg_match('/\A[a-z\d]{8,100}+\z/i',$datas["password"])){
    $errors['password'] = "パスワードは8文字で入力してください。";
  }
}




