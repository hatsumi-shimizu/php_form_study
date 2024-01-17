<?php 

  session_start();
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    if (empty($_POST["name"])) {
      $errors[] = '『お名前』は必須項目です。';
    }

    if (empty($_POST["kana"]) || !preg_match("/\A[ァ-ヿ]+\z/u", $_POST["kana"])) {
      $errors[] = '『フリガナ』は必須項目です。';
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
      $errors[] = '『メールアドレス』は必須項目です。';
    }

    if (empty($_POST["tel"]) || !preg_match('/^0[0-9]{9,10}\z/', $_POST["tel"])) {
      $errors[] = '『電話番号』は必須項目（ハイフン無し）です。';
    }

    if (empty($_POST["postal_code_1"]) || !preg_match("/\A\d{3}\z/", $_POST["postal_code_1"])) {
      $errors[] = '『郵便番号』は必須項目（3桁）です。';
    } 

    if (empty($_POST["postal_code_2"]) || !preg_match("/\A\d{4}\z/", $_POST["postal_code_2"])) {
      $errors[] = '『郵便番号』は必須項目（4桁）です。';
    } 
  
    if ($_POST["content"] == "") {
      $errors[] = '『応募内容』は必須項目です。';
    }

    if (!empty($errors)) {
      $_SESSION["errors"] = $errors;
      $_SESSION["POST"] = $_POST;
      header("Location: ../input/index.php");
    } 
  }

  ini_set('display_errors', 0);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>確認ページ</title>
</head>
<body class="bg-light">
  <p class="text-center">以下の内容でよろしければ「送信」ボタンをクリックしてください。</p>

  <!-- 入力内容確認画面 -->
  <form action="../complete/index.php" method="post">
    <table class="table table-striped-columns shadow-sm p-3 mb-5 bg-body-tertiary rounded">
      <tbody>
        <tr>
          <th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">お名前</th>
          <td><?php echo $_POST['name']; ?></td>
          <input type="hidden" name="name" value="<?php echo $_POST['name']; ?>">
        </tr>
        <tr>
          <th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">フリガナ</th>
          <td><?php echo $_POST['kana']; ?></td>
          <input type="hidden" name="kana" value="<?php echo $_POST['kana']; ?>">
        </tr>
        <tr>
          <th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">メールアドレス</th>
          <td><?php echo $_POST['email']; ?></td>
          <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
        </tr>
        <tr>
          <th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">電話番号</th>
          <td><?php echo $_POST['tel']; ?></td>
          <input type="hidden" name="tel" value="<?php echo $_POST['tel']; ?>">
        </tr>
        <tr>
          <th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">ご住所</th>  
          <td>
            <span>〒</span>
            <?php echo $_POST['postal_code_1']; ?>
            <input type="hidden" name="postal_code_1" value="<?php echo $_POST['postal_code_1']; ?>">
            <span>-</span>
            <?php echo $_POST['postal_code_2']; ?><br>
            <input type="hidden" name="postal_code_2" value="<?php echo $_POST['postal_code_2']; ?>">
            <?php echo $_POST['address']; ?></td>
            <input type="hidden" name="address" value="<?php echo $_POST['address']; ?>">
        </tr>
        <tr>
          <th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">性別</th>
          <td><?php echo $_POST['gender']; ?></td>
          <input type="hidden" name="gender" value="<?php echo $_POST['gender']; ?>">
        </tr>
        <tr>
          <th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">応募内容</th>
          <td><?php echo $_POST['content']; ?></td>
          <input type="hidden" name="content" value="<?php echo $_POST['content']; ?>">
        </tr>
        <tr>
          <th scope="row" class="table-secondary col-xs-3 col-ms-3 col-md-4 col-lg-4">その他ご質問などありましたらご記入ください</th>
          <td><?php echo nl2br($_POST['message']); ?></td>
          <input type="hidden" name="message" value="<?php echo $_POST['message']; ?>">
        </tr>
      </tbody>
    </table>

    <!-- 入力画面に戻す -->
    <button type="button" class="btn btn-secondary" onclick="history.back()">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
      </svg>
      戻る
    </button>
    <div class="d-grid gap-2 col-6 mx-auto">
      <input type="submit" name="complete" value="送信" class="btn btn-secondary">
    </div>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>




