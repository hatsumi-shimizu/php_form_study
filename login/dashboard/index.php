<?php

// 作成中

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $errors = [];

  if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ) {
    $errors[] = 'メールアドレスを入力してください。';
  }

  if(empty($datas["password"])){
    $errors[]  = "パスワードを入力してください。";
  }else if(!preg_match('/\A[a-z\d]{8,100}+\z/i',$datas["password"])){
    $errors[] = "パスワードは8文字で入力してください。";
  }

  if (!empty($errors)) {
    $_SESSION["errors"] = $errors;
    $_SESSION["POST"] = $_POST;
    header("Location: ../input/index.php");
  } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ダッシュボード</title>
</head>
<body>
  <p>ダッシュボード</p>
  <p>メール受信</p>
  <p>ログアウト</p>
</body>
</html>


