# Railwayキャッシュエラーの解決方法

## 問題

`php artisan cache:clear`実行時に、データベース接続エラーが発生しています。

**エラー**: `SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for mysql.railway.internal failed`

**原因**: キャッシュドライバーが`database`に設定されているため、データベース接続が必要になっています。

## 解決方法

### 環境変数`CACHE_STORE`を設定

Railwayダッシュボードのアプリケーションサービスの「Variables」タブで、以下を追加：

```
CACHE_STORE=file
```

これにより、キャッシュがファイルシステムに保存され、データベース接続を必要としなくなります。

## 設定手順

1. Railwayダッシュボードでアプリケーションサービスを開く
2. 「Variables」タブを開く
3. 「+ New Variable」をクリック
4. 以下を設定：
   - Variable: `CACHE_STORE`
   - Value: `file`
   - 「Add」をクリック
5. アプリケーションが自動的に再起動されます

## 確認

環境変数を設定後、アプリケーションが正常に起動するか確認してください。

## その他の環境変数（推奨）

同様に、セッションもファイルベースに設定することを推奨します：

```
SESSION_DRIVER=file
```

これにより、セッションもデータベース接続を必要としなくなります。

