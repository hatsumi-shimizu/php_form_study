<?php

  session_start();

  $contents = [
    '選択肢1',
    '選択肢2',
    '選択肢3',
  ];

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
  <title>お問合せフォーム</title>
</head>
<body class="bg-light">
  <form action="../confirm/index.php" method="post" class="h-adr">
  <span class="p-country-name" style="display:none;">Japan</span>
    <p><span class="text-danger">[必須]</span>の項目は入力必須項目です。必ず入力または選択してください。</p>

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

    <table class="table table-borderless bg-white shadow-sm p-3 md-5 bg-body-tertiary rounded">
      <tbody>
      <div class="form-group">
        <tr>
          <th scope="row"><span class="text-danger">[必須]</span>お名前</th>
          <td><input type="text" class="form-control" name="name" value="<?php echo $_SESSION["POST"]["name"] ?>"></td>
        </tr>
      </div>
      <div class="form-group">
        <tr>
          <th scope="row"><span class="text-danger">[必須]</span>フリガナ</th>
          <td><input type="text" class="form-control" name="kana" value="<?php echo $_SESSION["POST"]["kana"] ?>"></td>
        </tr>
      </div>
      <div class="form-group">
        <tr>
          <th scope="row"><span class="text-danger">[必須]</span>メールアドレス</th>
          <td><input type="text" class="form-control" name="email" value="<?php echo $_SESSION["POST"]["email"] ?>"></td>
        </tr>
      </div>
      <div class="form-group">
        <tr>
          <th scope="row"><span class="text-danger">[必須]</span>電話番号</th>
          <td><input type="text" class="form-control" name="tel" value="<?php echo $_SESSION["POST"]["tel"] ?>"></td>
        </tr>
      </div>
      <div class="form-group">
        <tr>
          <th scope="row"><span class="text-danger">[必須]</span>ご住所</th>
          <td>
            <div class="input-group mb-3"> 
              <span class="input-group-text">〒</span>
              <input type="text" class="form-control p-postal-code" name="postal_code_1" size="3" max-length="3" placeholder="000" value="<?php echo $_SESSION["POST"]['postal_code_1'] ?>">
              <span class="input-group-text bg-white">-</span>
              <input type="text" class="form-control p-postal-code" name="postal_code_2" size="4" max-length="4" placeholder="0000" value="<?php echo $_SESSION["POST"]['postal_code_2'] ?>">
            </div>
          </td>
        </tr>
      </div>
      <div class="form-group">
        <tr>
          <th></th>
          <td><input type="text" class="form-control p-region p-locality p-street-address p-extended-address" name="address" placeholder="住所" value="<?php echo $_SESSION["POST"]['address'] ?>"></td>
        </tr>
      </div>
      <div class="form-group">
        <tr>
          <th scope="row">性別</th>
          <td>
            <div class="input-group-text bg-white shadow-sm p-3 md-5 bg-body-tertiary rounded">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="男性" <?php if (isset($_SESSION["POST"]["gender"]) && $_SESSION["POST"]["gender"] == "男性") echo 'checked'; ?>>
                <label class="form-check-label" for="gender1">男性</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="女性" <?php if (isset($_SESSION["POST"]["gender"]) && $_SESSION["POST"]["gender"] == "女性") echo 'checked'; ?>>
                <label class="form-check-label" for="gender2">女性</label>
              </div>
            </div>
          </td>
        </tr>
      </div>
      <div class="form-group">
        <tr>
          <th scope="row"><span class="text-danger">[必須]</span>応募内容</th>
          <td>
            <select class="form-control" name="content">
              <option value="">--以下からご選択ください--</option>

              <?php 
                foreach ($contents as $content) {
                  if($content == $_SESSION["POST"]["content"]) {
                    echo "<option value='$content' selected>" . $content . "</option>";
                  } else {
                    echo "<option value='$content'>" . $content . "</option>";
                  }
                }
              ?>

            </select>
          </td>
        </tr>
      </div>
      <div class="form-group">
        <tr>
          <th scope="row">その他ご質問などありましたらご記入ください</th>
          <td><textarea class="form-control" name="message"><?php echo $_SESSION["POST"]["message"] ?></textarea></td>
        </tr>
      </div>
      </tbody>
    </table>
    <div class="d-grid gap-2 col-6 mx-auto">
      <input type="submit" name="confirm" value="内容確認ページへ" class="btn btn-secondary shadow-sm">
    </div>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>