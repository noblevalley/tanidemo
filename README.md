# 技術課題

## 内容

特定の画像ファイルPathを画面から入力

別のURLへPOSTリクエスト

レスポンス内容と画像ファイルPathをDBへ保存



## 必須アプリケーション

Webサーバー：Apache 2.4.x

DBサーバー：MariaDB 15.1

言語：PHP 7.3.x

ライブラリ：Composer 2.1.x

フレームワーク：Laravel 6.0



## 導入方法

前提条件

Web/DBサーバーとPHP/Composerはインストール済み/起動済みであること




### 1.GitHubプロジェクトをPHPが動作するパスへクローン

### 2.composerをインストール

```
composer install
```

### 3.APP_KEYを取得

.env.example ファイルをコピーしてファイル名を .env に変更する。

以下のコマンドを実行し、出力されたbase64の値を .env ファイルを開いてAPP_KEYに張り付ける。

```
php artisan key:generate
```

### 4.DBへ接続し、以下のSQLを実行

```
CREATE DATABASE IF NOT EXISTS tanidemo DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE `ai_analysis_log` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `image_path` varchar(255) DEFAULT NULL,
 `success` varchar(255) DEFAULT NULL,
 `message` varchar(255) DEFAULT NULL,
 `class` int(11) DEFAULT NULL,
 `confidence` decimal(5,4) DEFAULT NULL,
 `request_timestamp` int(10) unsigned DEFAULT NULL,
 `response_timestamp` int(10) unsigned DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

```

(APIサーバーが用意できない場合のみ)

以下のファイルを開き、38行目のコメントを外し、39行目をコメントにする。

app/Http/Controllers/EditController.php

変更前

        //$server = 'localhost/api/mockup';	// ローカルテスト用
        $server = 'example.com';	// リモート用

変更後

        $server = 'localhost/api/mockup';	// ローカルテスト用
        //$server = 'example.com';	// リモート用

APIサーバーをローカルで使用する。



## 操作方法

### 1.ブラウザを起動して以下のURLへ接続

http://localhost/add

画像パスを入力する画面が出るのを確認する。



### 2.拡張子が.jpgになっているファイルパスを入力して「送信」ボタンをクリック

.jpgファイルであれば、Successと出る。

それ以外のファイルであれば、エラー内容が出る。

再度入力したい場合はブラウザのバックで戻る。



### 3.DBのai_analysis_logテーブルに送信した分データ登録されていくのを確認

