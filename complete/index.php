<?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  require 'vendor/autoload.php';

  // $name = $_POST['name'];
  // $kana = $_POST['kana'];
  // $email = $_POST['email'];
  // $tel = $_POST['tel'];
  // $postal_code_1 = $_POST['postal_code_1'];
  // $postal_code_2 = $_POST['postal_code_2'];
  // $address = $_POST['address'];
  // $gender = $_POST['gender'];
  // $content = $_POST['content'];
  // $message = $_POST['message'];

  // $mail_body = "<p><b>お名前</b>：".$name."</p>";
  // $mail_body = "<p><b>フリガナ</b>：".$kana."</p>";
  // $mail_body = "<p><b>メールアドレス</b>：".$email."</p>";
  // $mail_body = "<p><b>電話番号</b>：".$tel."</p>";
  // $mail_body = "<p><b>ご住所</b>：".$postal_code_1."-".$postal_code_2. $address."</p>";
  // $mail_body = "<p><b>応募内容</b>：".$content."</p>";
  // $mail_body = "<p><b>その他ご質問などありましたらご記入ください</b>：".$message."</p>";

  $mail = new PHPMailer();

  try {

    //基本のセッティング
    $mail->CharSet = "iso-2022-jp";
    $mail->Encoding = "7bit";
    $mail->isSMTP();
    $mail->Host = "sandbox.smtp.mailtrap.io";
    $mail->SMTPAuth = true;
    $mail->Username = $mailObj->"e2ba3386777cac";
    $mail->Password = $mailObj->"2c95f2c3110219";
    $mail->Port = 2525;

    // 管理者へのメール
    $mail->setFrom($mailObj->from);
    $mail->addAddress($mailObj->to);
    $mail->Subject = $mailObj->mySubject;
    $mail->Body = $mailObj->myBodyHeader . $body . $mailObj->myBodyFooter;
    $mail->send();

    echo '送信は無事完了いたしました。';
    
} catch (Exception $e) {

    echo "送信できませんでした。{$mail->ErrorInfo}";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>完了ページ</title>
</head>
<body class="bg-light">
  <p class="text-center shadow-sm p-3 mb-5 bg-white rounded">送信は無事完了いたしました。</p>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>