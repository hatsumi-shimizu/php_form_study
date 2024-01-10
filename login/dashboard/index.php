<?php

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $errors = [];
  
  if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ) {
    $errors[] = 'メールアドレスを入力してください。';
  }

  if(empty($_POST["password"])){
    $errors[]  = "パスワードを入力してください。";
  }  else if(!preg_match('/\A[a-z\d]{8,100}+\z/i', $_POST["password"])){
    $errors[] = "パスワードは8桁で入力してください。";
  }

  $email = $_POST['email'];
  $pw = $_POST['password'];

  $dsn = 'mysql:dbname=form_study;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';

  try {
    $dbh = new PDO($dsn, $user, $password);
  } catch (PDOException $e) {
    $msg = $e->getMessage();
  }

  $sql = "SELECT * FROM users WHERE email = :email";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':email', $email);
  $stmt->execute();
  $member = $stmt->fetch();
  if ($pw != $member['password']) {
    $errors[] = 'メールアドレスもしくはパスワードが間違っています。';
  } else {
    $_SESSION['id'] = $member['id'];
    $_SESSION['email'] = $member['email'];
  }

  if(!empty($errors)) {
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <title>ダッシュボード</title>
</head>
<body class="bg-light d-flex bd-highlight">
  <div class="align-self-start p-5 flex-shrink-0 bd-highlight border-end">
    <div class="p-2">
      <a href="index.php" class="fw-bold" style="text-decoration: none; color: inherit;">ダッシュボード</a>
    </div>
    <div class="p-2">
      <a href="../email_index/index.php" style="text-decoration: none; color: inherit">メール受信</a>
    </div>
    <div class="p-2">
      <a href="../logout/index.php" id="logout" style="text-decoration: none; color: inherit;">ログアウト</a>
    </div>
  </div>
  <div class="p-5 w-100 bd-highlight">
    <h3>最新メール情報</h3>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>


