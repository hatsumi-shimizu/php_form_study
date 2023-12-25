<?php

$mailObj = new StdClass();

// Mailtrapの設定
$mailObj->host = "sandbox.smtp.mailtrap.io";
$mailObj->port = 2525;
$mailObj->charset = "iso-2022-jp";
$mailObj->encoding = "7bit";
$mailObj->username = "e2ba3386777cac";
$mailObj->password = "2c95f2c3110219";

// 差出人のメールアドレス（管理者側・自動返信メール）
$mailObj->from = "hatsumi-shimizu@cuebic.co.jp";

// 管理者の受取メールアドレス
$mailObj->to = "hatsumi-shimizu@cuebic.co.jp";

// 管理者用の件名
$mailObj->mySubject = "一般のお問い合わせフォームからお問い合わせがありました";

// 管理者用のBodyヘッダー
$mailObj->myBodyHeader =
"以下の内容でお問い合わせがありました。

◼︎お問い合わせ内容
--------------------------\n\n";

// 管理者用のBodyフッター
$mailObj->myBodyFooter = "";

// 相手先の件名
$mailObj->replySubject = "一般のお問い合わせフォーム（自動返信メール）";

// 相手先のBodyヘッダー
$mailObj->replyBodyHeader =
"様
お問い合わせいただきありがとうございます。
以下の内容で送信されました。

◼︎お問い合わせ内容
--------------------------\n\n";

// 相手先のBodyフッター
$mailObj->replyBodyFooter =
"--------------------------

本メールは配信専用のアドレスで配信されています。
本メールに返信しても、返信内容の確認及びご返信ができません。あらかじめご了承ください。";