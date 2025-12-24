# Railway 500エラーの解決方法

## 500エラーの一般的な原因

### 1. APP_KEYが設定されていない

**確認方法**:
- Railwayダッシュボードの「Variables」タブで`APP_KEY`が設定されているか確認

**解決方法**:
1. Railwayダッシュボードのターミナルで以下を実行：
   ```bash
   php artisan key:generate --show
   ```
2. 出力されたキーをコピー
3. 「Variables」タブで`APP_KEY`に設定

### 2. データベース接続エラー

**確認方法**:
- ログでデータベース接続エラーがないか確認

**解決方法**:
- 環境変数`DB_HOST`、`DB_PORT`、`DB_DATABASE`、`DB_USERNAME`、`DB_PASSWORD`が正しく設定されているか確認

### 3. ストレージリンクの問題

**確認方法**:
- ログで`storage:link`のエラーがないか確認

**解決方法**:
- `startCommand`で`php artisan storage:link`が実行されているか確認

### 4. 権限の問題

**確認方法**:
- ログで権限エラーがないか確認

**解決方法**:
- `startCommand`で`chmod -R 775 bootstrap/cache storage`が実行されているか確認

### 5. 設定ファイルのキャッシュの問題

**解決方法**:
Railwayダッシュボードのターミナルで以下を実行：

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## デバッグ手順

### ステップ1: ログを確認

Railwayダッシュボードの「Logs」タブで、エラーメッセージの詳細を確認してください。

### ステップ2: APP_DEBUGを一時的に有効化

デバッグのために、一時的に`APP_DEBUG=true`に設定：

1. 「Variables」タブで`APP_DEBUG`を`true`に変更
2. アプリケーションが再起動
3. エラーページで詳細なエラーメッセージを確認
4. 問題を修正後、`APP_DEBUG`を`false`に戻す

### ステップ3: 環境変数を確認

以下の環境変数がすべて設定されているか確認：

```
APP_NAME=Liberaspace
APP_ENV=production
APP_KEY=base64:...（必須）
APP_DEBUG=false
APP_URL=https://your-app.railway.app（必須）
APP_TIMEZONE=Asia/Tokyo

DB_CONNECTION=mysql
DB_HOST=mysql.railway.internal（または実際のホスト名）
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your_password

ADMIN_PASSWORD=your_password
```

## よくあるエラーと解決方法

### エラー: "No application encryption key has been specified"

**解決**: `APP_KEY`を生成して設定

### エラー: "SQLSTATE[HY000] [2002] Connection refused"

**解決**: データベース接続情報を確認

### エラー: "The stream or file could not be opened"

**解決**: ストレージディレクトリの権限を確認

### エラー: "Class 'App\\Http\\Controllers\\...' not found"

**解決**: `composer dump-autoload`を実行

