# Liberaspace Portfolio Site (Laravel)

Liberaspaceのポートフォリオサイトです。制作実績を独自CMSで管理できるLaravelアプリケーションです。

## 特徴

- **Laravel 12** ベースのWEBアプリケーション
- **制作実績CMS**: 管理画面から制作実績を追加・編集・削除可能
- **画像アップロード**: 制作実績の画像をアップロードして管理
- **モダンなデザイン**: モダンでクリーンなUI/UX

## 技術スタック

- **Backend**: Laravel 12, PHP 8.2+
- **Frontend**: HTML5, SCSS, JavaScript
- **Database**: MySQL / SQLite
- **Storage**: Laravel Storage (画像ファイル)
  - ローカル環境: ローカルストレージ (`public` disk)
  - 本番環境: Cloudflare R2 (`r2` disk)

## セットアップ

### 1. 依存関係のインストール

```bash
composer install
npm install
```

### 2. 環境変数の設定

`.env`ファイルをコピーして設定します：

```bash
cp .env.example .env
php artisan key:generate
```

`.env`ファイルでデータベース設定を変更：

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=liberaspace
DB_USERNAME=root
DB_PASSWORD=

# 管理画面のパスワードを設定（任意）
ADMIN_PASSWORD=your_password_here

# ストレージ設定
# ローカル環境では 'public' を使用
FILESYSTEM_DISK=public
```

### 3. データベースのセットアップ

```bash
php artisan migrate
```

### 4. ストレージリンクの作成（ローカル環境のみ）

ローカル環境で`FILESYSTEM_DISK=public`を使用する場合：

```bash
php artisan storage:link
```

**注意**: 本番環境でR2を使用する場合は、このコマンドは不要です。

### 5. 開発サーバーの起動

```bash
php artisan serve
```

ブラウザで `http://localhost:8000` にアクセスしてください。

### 6. SCSSのコンパイル（開発時）

別のターミナルで：

```bash
npm run dev
```

## 使用方法

### 管理画面へのアクセス

1. `http://localhost:8000/admin/login` にアクセス
2. `.env`ファイルで設定した`ADMIN_PASSWORD`（デフォルト: `admin123`）でログイン
3. 制作実績の追加・編集・削除が可能

### 制作実績の追加

1. 管理画面の「新規追加」ボタンをクリック
2. タイトル、カテゴリ、画像、URLなどを入力
3. 「保存」ボタンをクリック

### フロントエンドでの表示

フロントエンド（`/`）では、公開設定が有効な制作実績が自動的に表示されます。

## ストレージ設定

### ローカル環境

ローカル環境では、デフォルトでローカルストレージ（`public` disk）を使用します：

```env
FILESYSTEM_DISK=public
```

### 本番環境（Cloudflare R2）

本番環境でCloudflare R2を使用する場合、以下の環境変数を設定してください：

```env
# ストレージディスクをR2に設定
FILESYSTEM_DISK=r2

# Cloudflare R2の認証情報
R2_ACCESS_KEY_ID=your_access_key_id
R2_SECRET_ACCESS_KEY=your_secret_access_key
R2_BUCKET=your_bucket_name
R2_ENDPOINT=https://<account-id>.r2.cloudflarestorage.com
R2_URL=https://<your-custom-domain>.com
R2_REGION=auto
R2_USE_PATH_STYLE_ENDPOINT=true
```

#### R2の設定手順

1. **Cloudflare R2でバケットを作成**
   - Cloudflareダッシュボードで「R2 Object Storage」を選択
   - 「Create Bucket」をクリックしてバケットを作成

2. **APIキーを生成**
   - 「Manage R2 API Tokens」をクリック
   - 「Create API Token」をクリック
   - 必要な権限を設定してトークンを作成
   - `Access Key ID`と`Secret Access Key`をコピー

3. **カスタムドメインを設定（オプション）**
   - バケットの設定で「Public Access」を有効化
   - カスタムドメインを設定（`R2_URL`に使用）

4. **環境変数を設定**
   - Railwayダッシュボードで上記の環境変数を設定
   - `FILESYSTEM_DISK=r2`を設定することで、自動的にR2が使用されます

## Railwayへのデプロイ

詳細なデプロイ手順は [`DEPLOY.md`](./DEPLOY.md) を参照してください。

## プロジェクト構造

```
mycompany/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── HomeController.php
│   │       └── Admin/
│   │           └── AdminPortfolioController.php
│   └── Models/
│       └── Portfolio.php
├── database/
│   └── migrations/
│       └── *_create_portfolios_table.php
├── public/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── storage/ -> storage/app/public
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── home.blade.php
│       └── admin/
│           ├── login.blade.php
│           ├── dashboard.blade.php
│           └── portfolios/
│               ├── create.blade.php
│               └── edit.blade.php
└── routes/
    └── web.php
```

## データベース構造

### portfolios テーブル

- `id`: 主キー
- `title`: タイトル
- `category`: カテゴリ
- `description`: 説明（nullable）
- `image_path`: 画像パス
- `url`: URL（nullable）
- `display_order`: 表示順
- `is_published`: 公開フラグ
- `created_at`, `updated_at`: タイムスタンプ

## トラブルシューティング

詳細なトラブルシューティングガイドは [`TROUBLESHOOTING.md`](./TROUBLESHOOTING.md) を参照してください。

### よくある問題

#### 画像が表示されない

```bash
php artisan storage:link
```

を実行して、ストレージリンクが正しく作成されているか確認してください。

#### データベースエラー

`.env`ファイルのデータベース設定を確認し、データベースが作成されているか確認してください。

#### パーミッションエラー

`storage`と`bootstrap/cache`ディレクトリに書き込み権限があるか確認してください：

```bash
chmod -R 775 storage bootstrap/cache
```

## Railwayへのデプロイ

このアプリケーションをRailwayにデプロイする手順は、[`DEPLOY.md`](./DEPLOY.md)を参照してください。

### クイックスタート

1. Railwayアカウントを作成: https://railway.app/
2. GitHubリポジトリを接続
3. MySQLデータベースを追加
4. 環境変数を設定（`DEPLOY.md`を参照）
5. デプロイが自動的に開始されます

詳細な手順は [`DEPLOY.md`](./DEPLOY.md) を参照してください。

## ライセンス

MIT
