<?php

  session_start();

?>

<!-- 作成中 -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <title>メール受信詳細</title>
</head>
<body class="bg-light d-flex bd-highlight">
  <div class="align-self-start p-5 flex-shrink-0 bd-highlight border-end">
    <div class="p-2">
      <a href="../dashboard/index.php" style="text-decoration: none; color: inherit;">ダッシュボード</a>
    </div>
    <div class="p-2">
      <a href="../email_index/index.php" class="fw-bold" style="text-decoration: none; color: inherit">メール受信</a>
    </div>
    <div class="p-2">
      <a href="../logout/index.php" id="logout" style="text-decoration: none; color: inherit;">ログアウト</a>
    </div>
  </div>
  <div class="p-5 w-100 bd-highlight">
    <h3>メール受信詳細</h3>
    <table class="table table-bordered">
      <tbody>
        <?php
          $dsn = 'mysql:dbname=form_study;host=localhost;charset=utf8';
          $user = 'root';
          $password = 'root';

          try {
            $dbh = new PDO($dsn, $user, $password);
            // sql文は文字列だからidを文字列に変換
            $sql = "SELECT * FROM mails WHERE id = " .$_GET["id"];
            $stmt = $dbh->prepare($sql);
            $stmt->execute();

            foreach($stmt as $record) {
            echo 
              "<tr>
                <td>名前</td>
                <td>{$record['name']}</td>
              <tr>
                <td>メールアドレス</td>
                <td>{$record['email']}</td>
              </tr>
              <tr>
                <td>電話番号</td>
                <td>{$record['tel']}</td>
              </tr>
              <tr>
                <td>郵便番号</td>
                <td>{$record['postal_code']}</td>
              </tr>
              <tr>
                <td>住所</td>
                <td>{$record['address']}</td>
              </tr>
              <tr>
                <td>性別</td>
                <td>{$record['gender']}</td>
              </tr>
              <tr>
                <td>応募内容</td>
                <td>{$record['content']}</td>
              </tr>
              <tr>
                <td>質問</td>
                <td>{$record['question']}</td>
              </tr>
              <tr>
                <td>送信日時</td>
                <td>{$record['created_at']}</td>
              </tr>";
            }
          } catch(PDOException $e) {
            $msg = $e->getMessage();
          }
        ?>
      </tbody>
    </table>
    <button type="button" class="btn btn-secondary" onclick="history.back()">戻る</button>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>