<?php

  session_start();

  try {
    // データベース接続を1回にまとめる
    $dsn = 'mysql:dbname=form_study;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $dbh = new PDO($dsn, $user, $password);

    function isUnread($id) {
        global $dbh;
        $sql = "SELECT status FROM mails WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch()['status'] == 0;
    }

    function changeToReadButton($id) {
        global $dbh;
        $sql = "UPDATE mails SET status = 1 WHERE id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $isUnread = isUnread($id);
        if ($isUnread) {
            changeToReadButton($id);
        }
    }
  } catch (PDOException $e) {
    $msg = $e->getMessage();
    echo "エラー：" . $msg;
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script>
    $(function() {
      $("#logout").click(function() {
        var result = confirm('本当にログアウトしますか？');
        if(result) {
          $.ajax({
            url: '../logout/index.php',
            success: function() {
              window.location.href = '../input/index.php';
            }
          });
        }
      });
    });
  </script>
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
      <p id="logout" style="text-decoration: none; color: inherit; cursor: pointer;">ログアウト</p>
    </div>
  </div>
  <div class="p-5 w-100 bd-highlight">
    <h3>メール受信詳細</h3>
    <table class="table table-bordered">
      <tbody>
        <?php
          try {
            global $dbh;
            $dbh = new PDO($dsn, $user, $password);
            // sql文は文字列なので、$_GET['id']は「.」で連結
            $sql = "SELECT * FROM mails WHERE id =" .$_GET['id'];
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
            echo "エラー：" . $msg;
          }
        ?>
      </tbody>
    </table>
    <button type="button" class="btn btn-secondary" onclick="history.back()">戻る</button>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>