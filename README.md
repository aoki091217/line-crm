# 概要

LaravelとLINEを用いて顧客情報の管理を計ることを想定したシステムです。


## テーブル定義

![LINE CRM スプレッドシート](https://docs.google.com/spreadsheets/d/1gR_mEkXzcfw867ERzBMxq2U8zyPAfomV/edit?usp=sharing&ouid=114694619383528347947&rtpof=true&sd=true)


## 開発環境

* Laravel Framework 9.39.0
* PHP 8.1.10
* Windows 10
* MySQL


## 機能実装

![進捗GIF](./storage/readme/progress.gif)

### 実装済み機能

* 友達追加のアクションをするとニックネームを聞く
* ニックネームの入力に対する確認メッセージの応答をする
* 「いいえ」を押すと、再度入力を促す応答をする
* 「はい」を押すと、入力されたニックネームで会員登録を終了する

### 実装予定機能

#### LINE側

* どうやって知ったかの選択肢応答メッセージ
* リッチメニューコンテンツ

#### 管理側

* ログイン認証
* 店舗、従業員、顧客情報の管理
* 利用情報のグラフ化


## 注意事項

1カ月前から着手しましたので、目標とする機能の実装には至っておりません。
ご理解いただけますと幸いです。


## 参考文献

* ![LINE Developers 公式ドキュメント](https://developers.line.biz/ja/docs/messaging-api/)

* ![LINEBotとLaravelの連携](https://biz.addisteria.com/laravel_line_message_api/)

* ![応答メッセージ形式](https://tech.012grp.co.jp/entry/linebot-message-format)
