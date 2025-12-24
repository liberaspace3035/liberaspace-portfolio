# Railway環境変数の正しい設定方法

## ❌ 間違った設定方法

環境変数をまとめて貼り付けるとエラーになります：

```
ERROR: invalid key-value pair
```

## ✅ 正しい設定方法

Railwayでは、**各環境変数を1つずつ個別に追加**する必要があります。

## ステップバイステップ手順

### 1. アプリケーションサービスを開く

1. Railwayダッシュボードで**アプリケーションサービス**（Webサービス）をクリック
2. 上部のタブから「**Variables**」をクリック

### 2. 環境変数を1つずつ追加

「**+ New Variable**」ボタンをクリックして、以下の環境変数を**1つずつ**追加してください：

#### 基本設定

1. **APP_NAME**
   - Variable: `APP_NAME`
   - Value: `Liberaspace`
   - 「Add」をクリック

2. **APP_ENV**
   - Variable: `APP_ENV`
   - Value: `production`
   - 「Add」をクリック

3. **APP_DEBUG**
   - Variable: `APP_DEBUG`
   - Value: `false`
   - 「Add」をクリック

4. **APP_TIMEZONE**
   - Variable: `APP_TIMEZONE`
   - Value: `Asia/Tokyo`
   - 「Add」をクリック

#### データベース設定（自動変数参照を使用）

5. **DB_CONNECTION**
   - Variable: `DB_CONNECTION`
   - Value: `mysql`
   - 「Add」をクリック

6. **DB_HOST**
   - Variable: `DB_HOST`
   - Value: `${{MySQL.MYSQLHOST}}`
   - 「Add」をクリック

7. **DB_PORT**
   - Variable: `DB_PORT`
   - Value: `${{MySQL.MYSQLPORT}}`
   - 「Add」をクリック

8. **DB_DATABASE**
   - Variable: `DB_DATABASE`
   - Value: `${{MySQL.MYSQLDATABASE}}`
   - 「Add」をクリック

9. **DB_USERNAME**
   - Variable: `DB_USERNAME`
   - Value: `${{MySQL.MYSQLUSER}}`
   - 「Add」をクリック

10. **DB_PASSWORD**
    - Variable: `DB_PASSWORD`
    - Value: `${{MySQL.MYSQLPASSWORD}}`
    - 「Add」をクリック

#### 管理画面パスワード

11. **ADMIN_PASSWORD**
    - Variable: `ADMIN_PASSWORD`
    - Value: `your_secure_password_here`（実際のパスワードに変更）
    - 「Add」をクリック

## 自動変数参照が動作しない場合

`${{MySQL.MYSQLHOST}}`の形式が動作しない場合は、データベースサービスの「Variables」タブから値をコピーして手動で設定：

6. **DB_HOST**
   - Variable: `DB_HOST`
   - Value: `mysql.railway.internal`
   - 「Add」をクリック

7. **DB_PORT**
   - Variable: `DB_PORT`
   - Value: `3306`
   - 「Add」をクリック

8. **DB_DATABASE**
   - Variable: `DB_DATABASE`
   - Value: `railway`
   - 「Add」をクリック

9. **DB_USERNAME**
   - Variable: `DB_USERNAME`
   - Value: `root`
   - 「Add」をクリック

10. **DB_PASSWORD**
    - Variable: `DB_PASSWORD`
    - Value: `eUBGyXhSYxtwLbksUMDLfTYDHzdNIXpX`（データベースのパスワード）
    - 「Add」をクリック

## 設定後の確認

すべての環境変数を追加したら、「Variables」タブで以下のように表示されているはずです：

```
APP_NAME = Liberaspace
APP_ENV = production
APP_DEBUG = false
APP_TIMEZONE = Asia/Tokyo
DB_CONNECTION = mysql
DB_HOST = ${{MySQL.MYSQLHOST}} または mysql.railway.internal
DB_PORT = ${{MySQL.MYSQLPORT}} または 3306
DB_DATABASE = ${{MySQL.MYSQLDATABASE}} または railway
DB_USERNAME = ${{MySQL.MYSQLUSER}} または root
DB_PASSWORD = ${{MySQL.MYSQLPASSWORD}} または パスワード
ADMIN_PASSWORD = your_secure_password_here
```

## デプロイ後に設定する環境変数

デプロイが完了したら、以下も追加してください：

### APP_KEY

1. アプリケーションサービスの「Deployments」タブを開く
2. 最新のデプロイメントをクリック
3. 「View Logs」でターミナルにアクセス
4. 以下のコマンドを実行：

```bash
php artisan key:generate --show
```

5. 出力されたキーをコピー
6. 「Variables」タブで以下を追加：
   - Variable: `APP_KEY`
   - Value: `base64:...`（生成されたキー）

### APP_URL

1. Railwayダッシュボードでアプリケーションサービスをクリック
2. 「Settings」→「Networking」を開く
3. 「Generate Domain」で生成されたURLをコピー
4. 「Variables」タブで以下を追加：
   - Variable: `APP_URL`
   - Value: `https://your-app.up.railway.app`（実際のURL）

## トラブルシューティング

### エラー: "invalid key-value pair"

- 原因: 複数の環境変数をまとめて貼り付けている
- 解決: 各環境変数を1つずつ個別に追加してください

### エラー: "empty key"

- 原因: Variable名が空、または改行が含まれている
- 解決: Variable名とValueを正しく入力し、改行がないことを確認してください

### データベース接続エラー

- 環境変数が正しく設定されているか確認
- `DB_HOST`が`mysql.railway.internal`になっているか確認
- データベースサービスが起動しているか確認

