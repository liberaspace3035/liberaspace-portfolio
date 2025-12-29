# トラブルシューティングガイド

このドキュメントでは、よくある問題とその解決方法を説明します。

## 目次

1. [デプロイ関連の問題](#デプロイ関連の問題)
2. [データベース関連の問題](#データベース関連の問題)
3. [環境変数関連の問題](#環境変数関連の問題)
4. [アセット（CSS/JS）関連の問題](#アセットcssjs関連の問題)
5. [その他の問題](#その他の問題)

---

## デプロイ関連の問題

### Dockerビルドが失敗する

#### エラー: `The /app/bootstrap/cache directory must be present and writable`

**解決方法**:
- `railway.json`と`railway.toml`で、ビルドコマンドに`mkdir -p bootstrap/cache`が含まれているか確認
- この問題は既に修正済みです

#### エラー: `chmod: cannot access 'storage': No such file or directory`

**解決方法**:
- `railway.json`と`railway.toml`で、ビルドコマンドに`mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs`が含まれているか確認
- この問題は既に修正済みです

---

## データベース関連の問題

### データベース接続エラー

#### エラー: `SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for mysql.railway.internal failed`

**原因**:
- `mysql.railway.internal`はRailwayの内部ネットワークでのみ使用可能
- ローカル環境から接続しようとしている
- または、本番環境で環境変数`DB_HOST`が正しく設定されていない

**解決方法**:

**本番環境の場合**:
1. Railwayダッシュボードでデータベースサービスを開く
2. 「Variables」タブで`MYSQLHOST`の値を確認
3. アプリケーションサービスの「Variables」タブで`DB_HOST`に設定
4. データベースサービスが起動しているか確認

**ローカル環境の場合**:
- Railwayダッシュボードのターミナルからマイグレーションを実行する（推奨）
- または、ローカル環境の`.env`で公開URL（`metro.proxy.rlwy.net`など）を使用

### マイグレーションが実行できない

**症状**: ローカル環境から`railway run php artisan migrate --force`を実行するとエラーが発生

**解決方法**:
1. Railwayダッシュボードでアプリケーションサービスのターミナルを開く
2. 以下のコマンドを実行：
   ```bash
   php artisan migrate --force
   ```

---

## 環境変数関連の問題

### 環境変数が反映されない

**原因**:
- `.env`ファイルはGitにコミットされないため、本番環境には反映されない
- 環境変数はRailwayダッシュボードの「Variables」タブで手動で設定する必要がある

**解決方法**:
1. Railwayダッシュボードでアプリケーションサービスを開く
2. 「Variables」タブで環境変数を1つずつ設定
3. 環境変数を設定すると、アプリケーションが自動的に再起動されます

### APP_KEYが設定されていない

**症状**: 500エラー、`No application encryption key has been specified`

**解決方法**:
1. Railwayダッシュボードでアプリケーションサービスのターミナルを開く
2. 以下のコマンドを実行：
   ```bash
   php artisan key:generate --show
   ```
3. 出力されたキーをコピー
4. 「Variables」タブで`APP_KEY`に設定

### 環境変数の設定方法がわからない

**手順**:
1. Railwayダッシュボードでアプリケーションサービスを開く
2. 「Variables」タブを開く
3. 「+ New Variable」をクリック
4. **Variable**欄に環境変数名を入力（例: `APP_KEY`）
5. **Value**欄に値を入力
6. 「Add」をクリック
7. すべての環境変数を1つずつ設定

---

## アセット（CSS/JS）関連の問題

### CSSが読み込まれない

#### Mixed Contentエラー

**症状**: `Mixed Content: The page at 'https://...' was loaded over HTTPS, but requested an insecure stylesheet 'http://...'`

**原因**: `asset()`ヘルパーがHTTPのURLを生成している

**解決方法**:
- この問題は既に修正済みです（相対パス`/css/main.css`を使用）
- まだ発生する場合は、`APP_URL`環境変数が`https://`で始まっているか確認

#### CSSファイルが見つからない

**症状**: 404エラー、CSSファイルが読み込まれない

**解決方法**:
1. `public/css/main.css`が存在するか確認
2. Gitにコミットされているか確認：
   ```bash
   git ls-files public/css/main.css
   ```
3. Railwayダッシュボードのターミナルで確認：
   ```bash
   ls -la public/css/
   ```

---

## その他の問題

### ヘルスチェックが失敗する

**症状**: Healthcheck failed with "service unavailable"

**解決方法**:
1. アプリケーションが正常に起動しているか確認（「Logs」タブで確認）
2. エラーログを確認
3. 環境変数が正しく設定されているか確認
4. データベース接続エラーがないか確認

### キャッシュエラー

**症状**: `SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for mysql.railway.internal failed (Connection: mysql, SQL: delete from cache)`

**原因**: キャッシュドライバーが`database`に設定されているため、データベース接続が必要

**解決方法**:
- 環境変数`CACHE_STORE=file`を設定
- 環境変数`SESSION_DRIVER=file`を設定

### ストレージリンクの問題

**症状**: 画像が表示されない

**解決方法**:
1. Railwayダッシュボードのターミナルで以下を実行：
   ```bash
   php artisan storage:link
   ```
2. `public/storage`が`storage/app/public`へのシンボリックリンクになっているか確認

### パーミッションエラー

**症状**: `Permission denied`、ファイルが書き込めない

**解決方法**:
- `railway.toml`の`startCommand`で`chmod -R 775 bootstrap/cache storage`が実行されているか確認
- この問題は既に修正済みです

---

## ログの確認方法

### Railwayダッシュボードでログを確認

1. Railwayダッシュボードでアプリケーションサービスを開く
2. 「Logs」タブを開く
3. エラーメッセージを確認

### アプリケーションログを確認

Railwayダッシュボードのターミナルで：

```bash
tail -n 100 storage/logs/laravel.log
```

---

## デバッグモードの有効化

一時的にデバッグモードを有効にして、詳細なエラーメッセージを確認：

1. Railwayダッシュボードでアプリケーションサービスの「Variables」タブを開く
2. `APP_DEBUG`を`true`に変更
3. アプリケーションが再起動
4. ブラウザでページをリロード
5. 詳細なエラーメッセージを確認
6. 問題を修正後、`APP_DEBUG`を`false`に戻す

---

## サポート

問題が解決しない場合は、以下を確認してください：

1. Railwayダッシュボードの「Logs」タブでエラーメッセージを確認
2. 環境変数が正しく設定されているか確認
3. データベースサービスが起動しているか確認
4. アプリケーションサービスが正常にデプロイされているか確認
