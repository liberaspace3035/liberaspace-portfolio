# 500エラーのデバッグ手順

## 即座に確認すべきこと

### 1. Railwayダッシュボードの「Logs」タブを確認

エラーメッセージの詳細を確認してください。以下のようなエラーが表示される可能性があります：

- `No application encryption key has been specified` → `APP_KEY`が設定されていない
- `SQLSTATE[HY000]` → データベース接続エラー
- `Class not found` → オートロードの問題
- `Permission denied` → 権限の問題

### 2. 環境変数の確認

Railwayダッシュボードの「Variables」タブで、以下が設定されているか確認：

#### 必須の環境変数

```
APP_NAME=Liberaspace
APP_ENV=production
APP_KEY=base64:...（これが最も重要！）
APP_DEBUG=false
APP_URL=https://your-app.railway.app
APP_TIMEZONE=Asia/Tokyo

DB_CONNECTION=mysql
DB_HOST=mysql.railway.internal
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=eUBGyXhSYxtwLbksUMDLfTYDHzdNIXpX

ADMIN_PASSWORD=your_password
```

### 3. APP_KEYの生成と設定（最も重要）

`APP_KEY`が設定されていない場合、500エラーが発生します。

**手順**:
1. Railwayダッシュボードでアプリケーションサービスを開く
2. 「Deployments」タブを開く
3. 最新のデプロイメントをクリック
4. 「View Logs」またはターミナルアイコンをクリック
5. 以下のコマンドを実行：

```bash
php artisan key:generate --show
```

6. 出力されたキー（`base64:...`で始まる）をコピー
7. 「Variables」タブで`APP_KEY`に設定
8. アプリケーションが自動的に再起動されます

### 4. APP_DEBUGを一時的に有効化

詳細なエラーメッセージを確認するため：

1. 「Variables」タブで`APP_DEBUG`を`true`に変更
2. アプリケーションが再起動
3. ブラウザでページをリロード
4. 詳細なエラーメッセージを確認
5. 問題を修正後、`APP_DEBUG`を`false`に戻す

### 5. ログファイルを確認

Railwayダッシュボードのターミナルで：

```bash
tail -n 100 storage/logs/laravel.log
```

最新のエラーログを確認できます。

## よくある500エラーの原因と解決方法

### 原因1: APP_KEYが設定されていない（最も多い）

**エラーメッセージ**: `No application encryption key has been specified`

**解決**: 上記の手順3を実行

### 原因2: データベース接続エラー

**エラーメッセージ**: `SQLSTATE[HY000]`

**解決**: 
- 環境変数`DB_HOST`、`DB_PORT`、`DB_DATABASE`、`DB_USERNAME`、`DB_PASSWORD`を確認
- データベースサービスが起動しているか確認

### 原因3: ストレージリンクの問題

**エラーメッセージ**: `The stream or file could not be opened`

**解決**: 
- `startCommand`で`php artisan storage:link`が実行されているか確認
- ストレージディレクトリの権限を確認

### 原因4: ビューファイルが見つからない

**エラーメッセージ**: `View [home] not found`

**解決**: 
- `php artisan view:clear`を実行
- ビューファイルが存在するか確認

## 次のステップ

1. **ログを確認**してエラーメッセージを特定
2. **APP_KEYを生成**して設定（最も重要）
3. **APP_DEBUG=true**に設定して詳細なエラーを確認
4. エラーメッセージに基づいて修正

ログに表示されているエラーメッセージを共有していただければ、より具体的な解決方法を提案できます。

