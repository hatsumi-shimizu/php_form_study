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
        var result = window.confirm('本当にログアウトしますか？');
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
        try {
          $dsn = 'mysql:dbname=form_study;host=localhost;charset=utf8';
          $user = 'root';
          $password = 'root';
          $dbh = new PDO($dsn, $user, $password);

          $page = isset($_GET['page']) ? $_GET['page'] : 1;

          $page_size = 3;

          $count_sql = "SELECT COUNT(*) FROM mails";
          $count_stmt = $dbh->query($count_sql);
          $total = $count_stmt->fetchColumn();

          $total_pages = ceil($total / $page_size);

          $start = ($page - 1) * $page_size;

          $sql = "SELECT * FROM mails ORDER BY created_at DESC LIMIT $start, $page_size";
          $stmt = $dbh->prepare($sql);
          $stmt->execute();

          foreach($stmt as $record) {
            $statusButtonClass = ($record['status'] == 0) ? 'btn-danger' : 'btn-secondary';
            $statusButtonText = ($record['status'] == 0) ? '未読' : '既読';
        
            echo "<tr>";
            echo "<td>";
            echo "<div class='d-grid gap-2 d-md-block'>";
            echo "<a id='button' class='btn text-white {$statusButtonClass}' type='button'>{$statusButtonText}</a>";
            echo "</div>";
            echo "</td>";
            echo "<td>{$record['created_at']}</td><td>{$record['name']}</td><td>{$record['email']}</td><td>{$record['tel']}</td>";
            echo "<td>";
            echo "<div class='d-grid gap-2 d-md-block'>";
            echo "<a href='../email_show/index.php?id={$record['id']}' id='access' type='button' class='btn btn-warning text-white'>詳細ページ</a>";
            echo "</div>";
            echo "</td>";
            echo "</tr>";
          } 
        } catch(PDOException $e) {
          $msg = $e->getMessage();
        }
      ?>
      </tbody>
    </table>
    <div class="text-center">
      <?php
        for ($i = 1; $i <= $total_pages; $i++) {
          echo "<a class='color: #FF6699;' href='?page=$i'>$i</a>";
          echo "<spec>　</spec>";
        } 
      ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>