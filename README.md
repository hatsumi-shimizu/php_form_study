# お問合せフォーム
PHPで作ったお問合せフォーム。
フォーム入力、入力内容のDB保存、メール送信、DB保存内容の管理ができる。

## セットアップ
1. リポジトリのクローン
```
git clone https://github.com/hatsumi-shimizu/php_form_study.git
```
2. DB

- `mails`テーブルの構造 
```
CREATE TABLE `mails` (
  `id` int(11) NOT NULL COMMENT 'id',
  `name` varchar(20) NOT NULL COMMENT '名前',
  `kana` varchar(20) NOT NULL COMMENT 'フリガナ',
  `email` varchar(50) NOT NULL COMMENT 'メールアドレス',
  `tel` varchar(11) NOT NULL COMMENT '電話番号',
  `postal_code` int(11) NOT NULL COMMENT '郵便番号',
  `address` varchar(50) NOT NULL COMMENT '住所',
  `gender` varchar(2) NOT NULL COMMENT '性別',
  `content` varchar(4) NOT NULL COMMENT '応募内容',
  `question` varchar(100) NOT NULL COMMENT '質問',
  `status` int(11) DEFAULT '0' COMMENT 'ステータス',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '作成日時',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

- `users`テーブルの構造
```
CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'id',
  `email` varchar(50) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(8) NOT NULL COMMENT 'パスワード',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'ログイン日時',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```
