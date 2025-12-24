# Railway環境変数設定ガイド

## あなたのデータベース接続情報

以下の接続情報が確認できました：

```
MYSQLHOST: mysql.railway.internal
MYSQLPORT: 3306
MYSQLDATABASE: railway
MYSQLUSER: root
MYSQLPASSWORD: eUBGyXhSYxtwLbksUMDLfTYDHzdNIXpX
```

## アプリケーションサービスで設定する環境変数

Railwayダッシュボードで、**アプリケーションサービス（Webサービス）**の「Variables」タブで以下を設定してください。

### 方法1: Railway自動変数参照を使用（推奨）

以下の形式で設定すると、データベースの接続情報が変更されても自動的に更新されます：

```
APP_NAME=Liberaspace
APP_ENV=production
APP_DEBUG=false
APP_TIMEZONE=Asia/Tokyo

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

ADMIN_PASSWORD=your_secure_password_here
```

**注意**: `APP_KEY`と`APP_URL`は最初のデプロイ後に設定します。

### 方法2: 手動で値を設定

自動変数参照が動作しない場合、以下のように手動で値を設定できます：

```
APP_NAME=Liberaspace
APP_ENV=production
APP_DEBUG=false
APP_TIMEZONE=Asia/Tokyo

DB_CONNECTION=mysql
DB_HOST=mysql.railway.internal
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=eUBGyXhSYxtwLbksUMDLfTYDHzdNIXpX

ADMIN_PASSWORD=your_secure_password_here
```

## ⚠️ 重要な注意事項

**Railwayでは環境変数をまとめて貼り付けることはできません。各環境変数を1つずつ個別に追加する必要があります。**

## 設定手順（詳細）

1. Railwayダッシュボードで**アプリケーションサービス**をクリック
2. 「**Variables**」タブを開く
3. 「**+ New Variable**」をクリック
4. **各環境変数を1つずつ追加**：
   - Variable: `APP_NAME`
   - Value: `Liberaspace`
   - 「Add」をクリック
5. 次の環境変数を追加するには、再度「+ New Variable」をクリック
6. すべての環境変数を1つずつ追加

**❌ 間違い**: 複数の環境変数をまとめて貼り付け
**✅ 正しい**: 各環境変数を1つずつ個別に追加

詳細な手順は `RAILWAY_ENV_SETUP.md` を参照してください。

## デプロイ後の設定

デプロイが完了したら、以下を設定します：

### APP_KEYの生成

1. アプリケーションサービスの「Deployments」タブを開く
2. 最新のデプロイメントをクリック
3. 「View Logs」でターミナルにアクセス
4. 以下のコマンドを実行：

```bash
php artisan key:generate --show
```

5. 出力されたキーをコピー
6. 「Variables」タブで`APP_KEY`に設定

### APP_URLの設定

1. Railwayダッシュボードでアプリケーションサービスをクリック
2. 「Settings」→「Networking」を開く
3. 「Generate Domain」で生成されたURLをコピー（例: `https://your-app.up.railway.app`）
4. 「Variables」タブで`APP_URL`に設定

## 環境変数の一覧（完全版）

デプロイ後に設定するものを含めた完全なリスト：

```
APP_NAME=Liberaspace
APP_ENV=production
APP_KEY=base64:...（デプロイ後に生成）
APP_DEBUG=false
APP_URL=https://your-app.up.railway.app（Railwayが生成するURL）
APP_TIMEZONE=Asia/Tokyo

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

ADMIN_PASSWORD=your_secure_password_here
```

## トラブルシューティング

### データベース接続エラーが発生する場合

1. 環境変数が正しく設定されているか確認
2. データベースサービスが起動しているか確認
3. `DB_HOST`が`mysql.railway.internal`になっているか確認（内部ネットワーク経由）

### 自動変数参照が動作しない場合

`${{MySQL.MYSQLHOST}}`の形式が動作しない場合は、手動で値を設定してください。

