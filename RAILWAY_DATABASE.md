# Railwayデータベース接続情報の取得方法

## データベース接続情報を取得する手順

### 1. Railwayダッシュボードでデータベースサービスを開く

1. Railwayダッシュボード（https://railway.app/）にログイン
2. プロジェクトを選択
3. データベースサービス（MySQLまたはPostgreSQL）をクリック

### 2. 接続情報を確認する方法

#### 方法1: Variablesタブから確認（推奨）

1. データベースサービスをクリック
2. 上部のタブから「**Variables**」をクリック
3. 以下の環境変数が自動生成されています：

**MySQLの場合:**
- `MYSQLHOST` - データベースホスト
- `MYSQLPORT` - ポート番号（通常3306）
- `MYSQLDATABASE` - データベース名
- `MYSQLUSER` - ユーザー名
- `MYSQLPASSWORD` - パスワード

**PostgreSQLの場合:**
- `PGHOST` - データベースホスト
- `PGPORT` - ポート番号（通常5432）
- `PGDATABASE` - データベース名
- `PGUSER` - ユーザー名
- `PGPASSWORD` - パスワード

#### 方法2: Connectタブから確認

1. データベースサービスをクリック
2. 上部のタブから「**Connect**」をクリック
3. 「**Connection Info**」セクションに接続情報が表示されます

### 3. 接続情報をコピーする

各変数の値をクリックするとコピーできます。または、変数名の横にあるコピーボタン（📋）をクリックします。

## 環境変数への設定方法

### アプリケーションサービスで環境変数を設定

1. **アプリケーションサービス**（Webサービス）をクリック
2. 「**Variables**」タブを開く
3. 「**+ New Variable**」をクリック
4. 以下の環境変数を設定：

#### MySQLを使用する場合

```
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

**重要**: `${{MySQL.MYSQLHOST}}` のように、`${{サービス名.変数名}}` の形式で参照すると、Railwayが自動的に値を設定します。

#### PostgreSQLを使用する場合

```
DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}
```

### 手動で値を設定する場合

自動参照を使わず、手動で値を設定する場合：

1. データベースサービスの「Variables」タブで各値をコピー
2. アプリケーションサービスの「Variables」タブで以下を設定：

```
DB_CONNECTION=mysql
DB_HOST=your_host_value
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 接続情報の例

### MySQL接続情報の例

```
DB_CONNECTION=mysql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### PostgreSQL接続情報の例

```
DB_CONNECTION=pgsql
DB_HOST=containers-us-west-xxx.railway.app
DB_PORT=5432
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=your_password_here
```

## 注意事項

⚠️ **重要**: 
- データベースの接続情報は機密情報です。GitHubにコミットしないでください
- Railwayの自動変数参照（`${{サービス名.変数名}}`）を使用することを推奨します
- これにより、データベースの接続情報が変更されても自動的に更新されます

## トラブルシューティング

### 接続情報が表示されない場合

1. データベースサービスが完全にデプロイされているか確認
2. 数分待ってから再度確認
3. Railwayダッシュボードをリロード

### 接続エラーが発生する場合

1. 環境変数が正しく設定されているか確認
2. データベースサービスが起動しているか確認
3. 接続情報（ホスト、ポート、データベース名、ユーザー名、パスワード）を再確認

