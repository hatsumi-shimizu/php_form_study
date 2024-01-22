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
    $(function () {
        $("#logout").click(function () {
            var result = window.confirm('本当にログアウトしますか？');
            if (result) {
                $.ajax({
                    url: '../logout/index.php',
                    success: function () {
                        window.location.href = '../input/index.php';
                    }
                });
            }
        });
    });
  </script>
  <title>検索結果</title>
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
    <h3>検索結果</h3>
    <div>
      <form action="search.php" method="GET">
        <label for="search">フリーワード検索：</label>
        <input type="text" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" placeholder="キーワードを入力">
        <input type="submit" value="検索">
      </form>
    </div>
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
          // DB接続
          $dsn = 'mysql:dbname=form_study;host=localhost;charset=utf8';
          $user = 'root';
          $password = 'root';
          $dbh = new PDO($dsn, $user, $password);

          // ページング
          $page = isset($_GET['page']) ? $_GET['page'] : 1;
          $page_size = 3;

          $search_term = isset($_GET['search']) ? $_GET['search'] : '';
          $search_condition = empty($search_term) ? '' : " WHERE (name LIKE '%$search_term%' OR email LIKE '%$search_term%' OR tel LIKE '%$search_term%')";

          $count_sql = "SELECT COUNT(*) FROM mails $search_condition";
          $count_stmt = $dbh->query($count_sql);
          $total = $count_stmt->fetchColumn();

          $total_pages = ceil($total / $page_size);
          $start = ($page - 1) * $page_size;

          $sort_order = isset($_GET['order']) ? $_GET['order'] : 'desc';
          $sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';

          $sql = "SELECT * FROM mails $search_condition ORDER BY $sort_column $sort_order LIMIT $start, $page_size";
          $stmt = $dbh->prepare($sql);
          $stmt->execute();

          foreach ($stmt as $record) {
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
        } catch (PDOException $e) {
            $msg = $e->getMessage();
            echo "エラー：" . $msg;
        }
        ?>
      </tbody>
    </table>
    <div class="text-center">
      <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a style='color: #6c757d;' href='?page=$i&sort=$sort_column&order=$sort_order&search=$search_term'>$i</a>";
            echo "<spec>　</spec>";
        }

        $next_sort_order = ($sort_order == 'asc') ? 'desc' : 'asc';
        echo "<a href='?page=$page&sort=created_at&order=$next_sort_order&search=$search_term' style='text-decoration: none; color: #6c757d;'>";
        echo "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-sort-down' viewBox='0 0 16 16'>";
        echo "<path d='M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293V2.5zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z'/>";
        echo "</svg>";
        echo "並び替え";
        echo "</a>";
      ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
