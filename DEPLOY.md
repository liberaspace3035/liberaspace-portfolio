# Railway デプロイガイド

このドキュメントでは、LiberaspaceポートフォリオサイトをRailwayにデプロイする手順を説明します。

## 目次

1. [初回デプロイ手順](#初回デプロイ手順)
2. [環境変数の設定](#環境変数の設定)
3. [データベースの設定](#データベースの設定)
4. [よくある問題と解決方法](#よくある問題と解決方法)

---

## 初回デプロイ手順

### 1. Railwayプロジェクトの作成

1. [Railway](https://railway.app/) にアクセスしてログイン
2. 「New Project」をクリック
3. 「Deploy from GitHub repo」を選択
4. GitHubリポジトリを選択して接続

### 2. データベースサービスの追加

1. プロジェクト内で「+ New」をクリック
2. 「Database」→「Add MySQL」を選択
3. データベースサービスが作成されるまで待つ

### 3. 環境変数の設定

アプリケーションサービスの「Variables」タブで、以下の環境変数を**1つずつ**設定してください。

---

## 環境変数の設定

### 重要な注意事項

**`.env`ファイルはGitにコミットされません**。本番環境の環境変数は、Railwayダッシュボードの「Variables」タブで**手動で設定**する必要があります。

### 必須環境変数

#### アプリケーション設定

| 変数名 | 値 | 説明 |
|--------|-----|------|
| `APP_NAME` | `Liberaspace` | アプリケーション名 |
| `APP_ENV` | `production` | 環境（本番環境） |
| `APP_KEY` | `base64:...` | 暗号化キー（後で生成） |
| `APP_DEBUG` | `false` | デバッグモード（本番ではfalse） |
| `APP_URL` | `https://your-app.railway.app` | アプリケーションのURL |
| `APP_TIMEZONE` | `Asia/Tokyo` | タイムゾーン |

#### データベース接続設定

データベースサービスの「Variables」タブで確認した値を設定：

| 変数名 | 値の取得元 | 説明 |
|--------|-----------|------|
| `DB_CONNECTION` | - | `mysql` |
| `DB_HOST` | データベースサービスの`MYSQLHOST` | データベースホスト |
| `DB_PORT` | データベースサービスの`MYSQLPORT` | データベースポート（通常3306） |
| `DB_DATABASE` | データベースサービスの`MYSQLDATABASE` | データベース名 |
| `DB_USERNAME` | データベースサービスの`MYSQLUSER` | データベースユーザー名 |
| `DB_PASSWORD` | データベースサービスの`MYSQLPASSWORD` | データベースパスワード |

#### キャッシュ・セッション設定

| 変数名 | 値 | 説明 |
|--------|-----|------|
| `CACHE_STORE` | `file` | キャッシュドライバー（データベース接続不要） |
| `SESSION_DRIVER` | `file` | セッションドライバー（データベース接続不要） |

#### 管理画面設定

| 変数名 | 値 | 説明 |
|--------|-----|------|
| `ADMIN_PASSWORD` | 任意のパスワード | 管理画面のログインパスワード |

#### ストレージ設定（Cloudflare R2）

**方法1: `r2`ディスクを使用（推奨）**

| 変数名 | 値 | 説明 |
|--------|-----|------|
| `FILESYSTEM_DISK` | `r2` | **重要**: R2を使用する場合は`r2`を設定 |
| `R2_ACCESS_KEY_ID` | R2のAccess Key ID | Cloudflare R2の認証情報 |
| `R2_SECRET_ACCESS_KEY` | R2のSecret Access Key | Cloudflare R2の認証情報 |
| `R2_BUCKET` | R2のバケット名 | 例: `liberaspace` |
| `R2_ENDPOINT` | R2のエンドポイントURL | 例: `https://xxxxx.r2.cloudflarestorage.com`（バケット名は含めない） |
| `R2_URL` | R2の公開URL | 例: `https://pub-xxxxx.r2.dev` |

**方法2: `s3`ディスクを使用**

| 変数名 | 値 | 説明 |
|--------|-----|------|
| `FILESYSTEM_DISK` | `s3` | **重要**: R2を使用する場合は`s3`を設定 |
| `AWS_ACCESS_KEY_ID` | R2のAccess Key ID | Cloudflare R2の認証情報 |
| `AWS_SECRET_ACCESS_KEY` | R2のSecret Access Key | Cloudflare R2の認証情報 |
| `AWS_DEFAULT_REGION` | `auto` | R2のリージョン（通常は`auto`） |
| `AWS_BUCKET` | R2のバケット名 | 例: `liberaspace` |
| `AWS_ENDPOINT` | R2のエンドポイントURL | 例: `https://xxxxx.r2.cloudflarestorage.com`（バケット名は含めない） |
| `AWS_URL` | R2の公開URL | 例: `https://pub-xxxxx.r2.dev` |
| `AWS_USE_PATH_STYLE_ENDPOINT` | `true` | R2用に`true`を設定 |

**重要**: 
- `FILESYSTEM_DISK=r2`または`FILESYSTEM_DISK=s3`を設定しないと、ローカルの`public`ディスクが使用されます
- `R2_ENDPOINT`または`AWS_ENDPOINT`にはバケット名を含めないでください（例: `https://xxxxx.r2.cloudflarestorage.com`）

#### PHP設定（**重要** - 画像アップロードが失敗する場合）

画像アップロードで`error: 1`（UPLOAD_ERR_INI_SIZE）が発生する場合、PHPのファイルサイズ制限が原因です。

**必須設定**（画像アップロードを有効にするため）:

| 変数名 | 値 | 説明 |
|--------|-----|------|
| `PHP_INI_UPLOAD_MAX_FILESIZE` | `10M` | **必須**: 最大アップロードファイルサイズ（デフォルト: 2M） |
| `PHP_INI_POST_MAX_SIZE` | `12M` | **必須**: 最大POSTデータサイズ（upload_max_filesizeより大きく設定） |
| `PHP_INI_MEMORY_LIMIT` | `256M` | PHPメモリ制限（推奨） |

**注意**:
- `PHP_INI_POST_MAX_SIZE`は`PHP_INI_UPLOAD_MAX_FILESIZE`より大きく設定してください
- スクリーンショットや大きな画像をアップロードする場合は、`10M`以上を推奨
- 設定後は**Railwayでサービスを再起動**してください

**エラーの確認方法**:
- アップロード失敗時に「ファイルサイズがPHPの設定（upload_max_filesize: 2M）を超えています」というメッセージが表示される
- Railwayのログで`File upload error (PHP level)`を確認

### 環境変数の設定手順

1. Railwayダッシュボードでアプリケーションサービスを開く
2. 「Variables」タブを開く
3. 「+ New Variable」をクリック
4. **Variable**欄に環境変数名を入力
5. **Value**欄に値を入力
6. 「Add」をクリック
7. すべての環境変数を1つずつ設定

### APP_KEYの生成

`APP_KEY`は最初のデプロイ後に生成する必要があります：

1. Railwayダッシュボードでアプリケーションサービスのターミナルを開く
2. 以下のコマンドを実行：

```bash
php artisan key:generate --show
```

3. 出力されたキー（`base64:...`で始まる）をコピー
4. 「Variables」タブで`APP_KEY`に設定

---

## データベースの設定

### データベース接続情報の確認

1. Railwayダッシュボードでデータベースサービスを開く
2. 「Variables」タブで以下を確認：
   - `MYSQLHOST` → `DB_HOST`に設定
   - `MYSQLPORT` → `DB_PORT`に設定
   - `MYSQLDATABASE` → `DB_DATABASE`に設定
   - `MYSQLUSER` → `DB_USERNAME`に設定
   - `MYSQLPASSWORD` → `DB_PASSWORD`に設定

### マイグレーションの実行

アプリケーションが起動したら、Railwayダッシュボードのターミナルで以下を実行：

```bash
php artisan migrate --force
```

---

## よくある問題と解決方法

### 1. 500エラーが発生する

#### APP_KEYが設定されていない

**症状**: `No application encryption key has been specified`

**解決方法**:
1. Railwayダッシュボードのターミナルで以下を実行：
   ```bash
   php artisan key:generate --show
   ```
2. 出力されたキーを「Variables」タブで`APP_KEY`に設定

#### データベース接続エラー

**症状**: `SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for mysql.railway.internal failed`

**解決方法**:
1. データベースサービスが起動しているか確認
2. データベースサービスとアプリケーションサービスが同じプロジェクト内にあるか確認
3. 環境変数`DB_HOST`、`DB_PORT`、`DB_DATABASE`、`DB_USERNAME`、`DB_PASSWORD`が正しく設定されているか確認

### 2. CSSが読み込まれない（Mixed Contentエラー）

**症状**: `Mixed Content: The page at 'https://...' was loaded over HTTPS, but requested an insecure stylesheet 'http://...'`

**解決方法**:
- この問題は既に修正済みです（相対パスを使用）
- まだ発生する場合は、`APP_URL`環境変数が`https://`で始まっているか確認

### 3. キャッシュエラー

**症状**: `SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for mysql.railway.internal failed (Connection: mysql, SQL: delete from cache)`

**解決方法**:
- 環境変数`CACHE_STORE=file`を設定
- 環境変数`SESSION_DRIVER=file`を設定

### 4. ヘルスチェックが失敗する

**症状**: Healthcheck failed with "service unavailable"

**解決方法**:
1. アプリケーションが正常に起動しているか確認（「Logs」タブで確認）
2. エラーログを確認
3. 環境変数が正しく設定されているか確認

### 5. ローカル環境からマイグレーションを実行できない

**症状**: `php_network_getaddresses: getaddrinfo for mysql.railway.internal failed`

**原因**: `mysql.railway.internal`はRailwayの内部ネットワークでのみ使用可能

**解決方法**:
- Railwayダッシュボードのターミナルから実行する（推奨）
- または、ローカル環境の`.env`で公開URL（`metro.proxy.rlwy.net`など）を使用

---

## デプロイ後の確認事項

1. ✅ アプリケーションが正常に起動しているか（「Deployments」タブで確認）
2. ✅ エラーログがないか（「Logs」タブで確認）
3. ✅ ブラウザでアプリケーションにアクセスできるか
4. ✅ 管理画面にログインできるか（`/admin/login`）
5. ✅ データベースマイグレーションが実行されているか
6. ✅ **R2ストレージの確認**（R2を使用する場合）:
   - 管理画面で画像をアップロード
   - Cloudflare R2ダッシュボードで`portfolios/`フォルダに画像が保存されているか確認
   - 画像URLがR2の公開URL（`https://pub-xxxxx.r2.dev/...`）になっているか確認
   - 画像URLを直接ブラウザで開いて表示できるか確認
7. ✅ **PHP設定の確認**（画像アップロードが失敗する場合）:
   - Railwayダッシュボードのターミナルで以下を実行：
     ```bash
     php -i | grep 'upload_max_filesize\|post_max_size'
     ```
   - ログで`PHP Configuration:`セクションを確認
   - 必要に応じて`PHP_INI_UPLOAD_MAX_FILESIZE`と`PHP_INI_POST_MAX_SIZE`を設定

---

## 参考資料

- [Railway公式ドキュメント](https://docs.railway.app/)
- [Laravel公式ドキュメント](https://laravel.com/docs)
