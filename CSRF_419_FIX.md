# CSRF 419エラー修正ガイド

## 問題
POSTリクエストで419エラー（CSRFトークンエラー）が発生する

## 原因
HTTPS環境でセッションクッキーが正しく設定されていない

## 修正内容

### 1. セッション設定の修正

`config/session.php`を以下のように修正しました：

- `secure`: 本番環境では`true`に自動設定（HTTPS必須）
- `same_site`: 本番環境では`none`に設定（クロスサイトリクエスト対応）
- `lifetime`: デフォルトを120分から480分（8時間）に延長

### 2. 環境変数の設定（Railway）

Railwayダッシュボードで以下の環境変数を設定してください：

```env
APP_ENV=production
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=none
SESSION_LIFETIME=480
```

**注意**: `SESSION_SAME_SITE=none`を使用する場合、`SESSION_SECURE_COOKIE=true`が必須です。

## 確認手順

1. 環境変数を設定
2. Railwayでアプリケーションを再起動
3. 管理画面にログイン
4. 画像をアップロードしてテスト
5. 419エラーが解消されているか確認

## 追加の確認事項

### セッションテーブルの確認

データベースに`sessions`テーブルが存在するか確認：

```sql
SHOW TABLES LIKE 'sessions';
```

存在しない場合は、マイグレーションを実行：

```bash
php artisan session:table
php artisan migrate
```

### セッションクッキーの確認

ブラウザの開発者ツールでセッションクッキーを確認：

1. 開発者ツールを開く（F12）
2. 「Application」タブ → 「Cookies」を選択
3. セッションクッキーが以下のように設定されているか確認：
   - `Secure`: ✓（チェック済み）
   - `SameSite`: None
   - `HttpOnly`: ✓（チェック済み）

## トラブルシューティング

### まだ419エラーが発生する場合

1. **ブラウザのキャッシュをクリア**
   - ブラウザのキャッシュとCookieをクリア
   - 再度ログインしてテスト

2. **セッションテーブルを確認**
   - データベースに`sessions`テーブルが存在するか確認
   - テーブルが存在しない場合は、マイグレーションを実行

3. **環境変数を再確認**
   - `APP_ENV=production`が設定されているか
   - `SESSION_SECURE_COOKIE=true`が設定されているか
   - `SESSION_SAME_SITE=none`が設定されているか

4. **アプリケーションを再起動**
   - 環境変数を変更した後、Railwayでアプリケーションを再起動

