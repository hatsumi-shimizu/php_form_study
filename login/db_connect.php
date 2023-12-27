<?php

session_start();

try {
  $dsn = "mysql:host=localhost; dbname=form_study; charset=utf8";
  $username = "root";
  $password = "root";

  $dbh = new PDO($dsn, $username, $password);

  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  echo 'DB接続完了！';
} catch (PDOException $e) {
  echo 'DB接続できませんでした。エラー：' . $e->getMessage();
  exit();
}


