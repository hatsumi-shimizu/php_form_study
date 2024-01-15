<?php

  session_start();

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
  <title>メール受信一覧</title>
</head>
<body class="bg-light d-flex bd-highlight">
  <div class="align-self-start p-5 flex-shrink-0 bd-highlight border-end">
    <div class="p-2">
      <a href="../dashboard/index.php" style="text-decoration: none; color: inherit;">ダッシュボード</a>
    </div>
    <div class="p-2">
      <a href="index.php" class="fw-bold" style="text-decoration: none; color: inherit">メール受信</a>
    </div>
    <div class="p-2">
      <p id="logout" style="text-decoration: none; color: inherit; cursor: pointer;">ログアウト</p>
    </div>
  </div>
  <div class="p-5 w-100 bd-highlight">
    <h3>メール受信一覧</h3>
    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <th scope="col">既読・未読</th>
          <th scope="col">送信日時</th>
          <th scope="col">名前</th>
          <th scope="col">メールアドレス</th>
          <th scope="col">電話番号</th>
          <th scope="col">詳細</th>
        </tr>
      </thead>
      <tbody>

      <?php
        $dsn = 'mysql:dbname=form_study;host=localhost;charset=utf8';
        $user = 'root';
        $password = 'root';

        try {
          $dbh = new PDO($dsn, $user, $password);
          $sql = "SELECT * FROM mails ORDER BY created_at DESC";
          $stmt = $dbh->prepare($sql);
          $stmt->execute();

          foreach($stmt as $record) {

            if($record['status'] == 0) { ?>
              <tr>
                <td>
                  <div class="d-grid gap-2 d-md-block">
                    <a class="btn btn-danger text-white" type="button">未読</a>
                  </div>
                </td>
            <?php } else { ?>
              <tr>
                <td>
                  <div class="d-grid gap-2 d-md-block">
                    <a class="btn btn-secondary text-white" type="button">既読</a>
                  </div>
                </td>
            <?php } 

                echo "<td>{$record['created_at']}</td><td>{$record['name']}</td><td>{$record['email']}</td><td>{$record['tel']}</td>" ?>

                <td>
                  <div class="d-grid gap-2 d-md-block">
                    <!-- $record['id']はint型で出力されるため、string型に変換してからhtmlに埋め込む -->
                    <a href="../email_show/index.php?id=<?php echo (string) $record['id'] ?>" type='button' class='btn btn-warning text-white'>詳細ページ</a>
                  </div>
                </td>
              <?php "</tr>";  
          }
        } catch (PDOException $e) {
          $msg = $e->getMessage();
        }
      ?>
      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  <script src="../js/function.js"></script>
</body>
</html>