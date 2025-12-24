# Railway デプロイ手順

このドキュメントでは、LiberaspaceポートフォリオサイトをRailwayにデプロイする手順を説明します。

## 前提条件

- Railwayアカウント（https://railway.app/ で無料登録可能）
- GitHubアカウント（推奨）またはGitリポジトリ

## デプロイ手順

### 1. GitHubリポジトリの作成（推奨）

```bash
# Gitリポジトリを初期化（まだの場合）
git init
git add .
git commit -m "Initial commit"

# GitHubにリポジトリを作成し、プッシュ
git remote add origin https://github.com/yourusername/liberaspace.git
git push -u origin main
```

### 2. Railwayプロジェクトの作成

1. [Railway](https://railway.app/) にアクセスしてログイン
2. 「New Project」をクリック
3. 「Deploy from GitHub repo」を選択（GitHubを使用する場合）
   - または「Empty Project」を選択して後でGitリポジトリを接続
4. リポジトリを選択して接続

### 3. データベースの追加

1. Railwayダッシュボードで「+ New」をクリック
2. 「Database」→「Add MySQL」または「Add PostgreSQL」を選択
3. データベースが作成されたら、接続情報を確認：
   - データベースサービスをクリック
   - 「Variables」タブを開く
   - 接続情報が自動生成されています（`MYSQLHOST`, `MYSQLDATABASE`など）
   - 詳細は `RAILWAY_DATABASE.md` を参照

### 4. 環境変数の設定

Railwayダッシュボードの「Variables」タブで以下の環境変数を設定：

#### 必須の環境変数

```
APP_NAME=Liberaspace
APP_ENV=production
APP_KEY=                    # 後で生成（手順5を参照）
APP_DEBUG=false
APP_URL=                    # Railwayが自動生成するURL（後で設定）
APP_TIMEZONE=Asia/Tokyo

DB_CONNECTION=mysql          # または pgsql
DB_HOST=                    # Railwayデータベースのホスト
DB_PORT=3306                # MySQLの場合、PostgreSQLの場合は5432
DB_DATABASE=                # Railwayデータベース名
DB_USERNAME=                # Railwayデータベースユーザー名
DB_PASSWORD=                # Railwayデータベースパスワード

ADMIN_PASSWORD=your_secure_password_here
```

**重要**: `APP_KEY`は最初のデプロイ後に生成する必要があります（手順7を参照）。

#### Railwayが自動設定する変数

- `PORT` - アプリケーションのポート番号（自動）
- `RAILWAY_ENVIRONMENT` - 環境名（自動）

#### データベース接続情報の設定方法

**方法1: Railway自動変数参照を使用（推奨）**

アプリケーションサービスの「Variables」タブで、以下のように設定：

```
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

**方法2: 手動で値を設定**

データベースサービスの「Variables」タブで値を確認し、手動で設定：

```
DB_CONNECTION=mysql
DB_HOST=mysql.railway.internal
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your_password
```

詳細は `RAILWAY_ENV_VARS.md` を参照してください。

### 5. ビルド設定の確認

Railwayは自動的に以下のファイルを検出します：
- `railway.json` - Railway設定ファイル
- `Procfile` - 起動コマンド
- `nixpacks.toml` - Nixpacks設定（オプション）

### 6. デプロイの実行

1. Railwayダッシュボードで「Deploy」をクリック
2. ビルドとデプロイが自動的に開始されます
3. ログを確認してエラーがないか確認

### 7. APP_KEYの生成

最初のデプロイ後、`APP_KEY`を生成する必要があります：

#### Railway CLIを使用する場合

```bash
railway run php artisan key:generate --show
```

出力されたキーをコピーして、Railwayダッシュボードの「Variables」で`APP_KEY`に設定します。

#### Railwayダッシュボードから実行する場合

1. サービスをクリック
2. 「Deployments」タブを開く
3. 最新のデプロイメントをクリック
4. 「View Logs」でターミナルにアクセス
5. 以下のコマンドを実行：

```bash
php artisan key:generate --show
```

出力されたキーをコピーして、Railwayダッシュボードの「Variables」で`APP_KEY`に設定します。

### 8. デプロイ後の設定

デプロイが完了し、`APP_KEY`を設定したら、以下のコマンドを実行する必要があります：

#### Railway CLIを使用する場合

```bash
# Railway CLIをインストール
npm i -g @railway/cli

# ログイン
railway login

# プロジェクトに接続
railway link

# マイグレーション実行
railway run php artisan migrate --force

# ストレージリンク作成
railway run php artisan storage:link

# 設定キャッシュ
railway run php artisan config:cache
railway run php artisan route:cache
railway run php artisan view:cache
```

#### Railwayダッシュボードから実行する場合

1. サービスをクリック
2. 「Deployments」タブを開く
3. 「View Logs」でターミナルにアクセス
4. 以下のコマンドを実行：

```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 9. APP_URLの設定

Railwayが生成したURLを`APP_URL`環境変数に設定します：

1. Railwayダッシュボードでサービスをクリック
2. 「Settings」→「Networking」を開く
3. 「Generate Domain」で生成されたURLをコピー（例: `https://your-app.up.railway.app`）
4. 「Variables」タブで`APP_URL`に設定

### 10. カスタムドメインの設定（オプション）

1. Railwayダッシュボードで「Settings」→「Networking」を開く
2. 「Custom Domain」でドメインを追加
3. DNS設定を更新

## トラブルシューティング

### ビルドエラー

- `composer install`が失敗する場合：
  - `composer.json`の依存関係を確認
  - Railwayのログで詳細なエラーを確認

### データベース接続エラー

- 環境変数が正しく設定されているか確認
- データベースサービスが起動しているか確認
- 接続情報を再確認

### ストレージエラー

- `storage:link`コマンドが実行されているか確認
- `storage/app/public`ディレクトリの権限を確認

### 500エラー

- `APP_DEBUG=true`に一時的に設定してエラー詳細を確認
- ログファイル（`storage/logs/laravel.log`）を確認
- 環境変数がすべて設定されているか確認

## 環境変数の自動設定（Railwayデータベース）

Railwayのデータベースサービスを使用する場合、以下のように環境変数を設定できます：

```
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}
```

またはPostgreSQLの場合：

```
DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}
```

## 継続的デプロイ（CI/CD）

GitHubリポジトリと接続している場合、`main`ブランチへのプッシュで自動的にデプロイされます。

## 参考リンク

- [Railway Documentation](https://docs.railway.app/)
- [Laravel Deployment Guide](https://laravel.com/docs/deployment)

