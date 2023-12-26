<?php

require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/mail_config.php');
require_once(__DIR__ . '/../lib/functions/utils.php');

session_start();

ini_set('display_errors', 0);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $posts = [
    0 => [
      'label' => '名前',
      'value' => h($_POST['name']),
    ],
    1 => [
      'label' => 'フリガナ',
      'value' => h($_POST['kana']),
    ],
    2 => [
      'label' => 'メールアドレス',
      'value' => h($_POST['email']),
    ],
    3 => [
      'label' => '電話番号',
      'value' => h($_POST['tel']),
    ],
    4 => [
      'label' => '住所',
      'value' => h('〒' . $_POST['postal_code_1'] . '-' . $_POST['postal_code_2'] . ' ' . $_POST['address']),
    ],
    5 => [
      'label' => '性別',
      'value' => h($_POST['gender']),
    ],
    6 => [
      'label' => '応募内容',
      'value' => h($_POST['content']),
    ],
    
    7 => [
      'label' => '質問内容',
      'value' => h($_POST['message']),
    ],
  ];

  $body = "";
  foreach ( $posts as $post ) {
    $body .= $post['label'] . "：\n" . $post['value'] . "\n\n";
  }

  $mail = new PHPMailer();
  
  try {

    //基本のセッティング
    $mail->CharSet = $mailObj->charset;
    $mail->Encoding = $mailObj->encoding;
    $mail->isSMTP();
    $mail->Host = $mailObj->host;
    $mail->SMTPAuth = true;
    $mail->Username = $mailObj->username;
    $mail->Password = $mailObj->password;
    $mail->Port = $mailObj->port;
  
    // 管理者へのメール
    $mail->setFrom($mailObj->from);
    $mail->addAddress($mailObj->to);
    $mail->Subject = $mailObj->mySubject;
    $mail->Body = $_POST['name'] . $mailObj->replyBodyHeader . $body . $mailObj->replyBodyFooter;
    $mail->send();

    // 自動返信メール
    $mail->setFrom($mailObj->from);
    $mail->ClearAddresses(); // 一旦リセット
    $mail->addAddress($_POST['email']);
    $mail->Subject = $mailObj->replySubject;
    $mail->Body = $_POST['name'] . $mailObj->replyBodyHeader . $body . $mailObj->replyBodyFooter;
    $mail->send();
    
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

try {

  // DB接続・PDO設定
  $dsn = 'mysql:dbname=form_study;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'root';

  $conn = new PDO($dsn, $user, $password);

  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // var_dump()したときに$postal_code以外NULLになっているが、なぜだかわからない
  $name = $POST['name'];
  $kana = $POST['kana'];
  $email = $POST['email'];
  $tel = $POST['tel'];
  $postal_code = $_POST['postal_code_1'] . $_POST['postal_code_2'];
  $address = $POST['address'];
  $gender = $POST['gender'];
  $content = $POST['content'];
  $question = $POST['message'];

  $stmt = $conn->prepare("INSERT INTO mails (name, kana, email, tel, postal_code, address, gender, content, question) VALUES (:name, :kana, :email, :tel, :postal_code, :address, :gender, :content, :question)");

  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':kana', $kana);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':tel', $tel);
  $stmt->bindParam(':postal_code', $postal_code);
  $stmt->bindParam(':address', $address);
  $stmt->bindParam(':gender', $gender);
  $stmt->bindParam(':content', $content);
  $stmt->bindParam(':question', $question);

  var_dump($name, $kana, $email, $tel, $postal_code, $address, $gender, $content, $question);

  // この処理でエラーが出る
  $stmt->execute();

  echo "データが追加されました。";
} catch (PDOException $e) {
  echo "エラー: " . $e->getMessage();
}

$conn = null;

// セッション情報削除
session_destroy();

// 完了画面に遷移
header("Location: thanks.html");