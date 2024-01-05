<?php

ini_set('display_errors', 0);

?>

<!-- 作成中 -->

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <title>ログインページ</title>
</head>
<body class="text-bg-light p-3">

  <!-- エラーメッセージ -->
  <?php if ($_SESSION["errors"]) { 
      foreach ($_SESSION["errors"] as $error) { ?>
        <div class="bg-danger text-white w-50 shadow-sm">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
          </svg>
          <?php echo $error; ?>
        </div>
    <?php } ?>  
  <?php } ?>

  <form action="../dashboard/index.php" method="POST">
    <table class="table table-borderless">
      <tbody>
        <div class="form-group">
          <tr class="table-light">
            <th scope="row">メールアドレス</th>
            <td>
              <input class="form-control" id="sign-in-email" name="username" type="text">
            </td>
          </tr>
        </div>
        <div class="form-group">
          <tr class="table-light">
            <th scope="row">パスワード</th>
            <td>
              <input class="form-control" id="sign-in-password" name="password" type="text">
            </td>
          </tr>
        </div>
      </tbody>
    </table>
  </form>
  <div class="d-grid gap-2 col-6 mx-auto">
    <button name="login" class="btn btn-secondary" type="button">ログイン</button>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>