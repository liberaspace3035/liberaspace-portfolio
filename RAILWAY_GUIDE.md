# Railway デプロイガイド

このドキュメントは、LaravelアプリケーションをRailwayにデプロイするための完全なガイドです。

## 目次

1. [初回デプロイ手順](#初回デプロイ手順)
2. [環境変数の設定](#環境変数の設定)
3. [データベースの設定](#データベースの設定)
4. [よくある問題と解決方法](#よくある問題と解決方法)
5. [ローカル環境からの操作](#ローカル環境からの操作)

---

## 初回デプロイ手順

### 1. Railwayプロジェクトの作成

1. [Railway](https://railway.app)にログイン
2. 「New Project」をクリック
3. 「Deploy from GitHub repo」を選択
4. GitHubリポジトリを選択して接続

### 2. データベースサービスの追加

1. プロジェクト内で「+ New」をクリック
2. 「Database」→「Add MySQL」を選択
3. データベースサービスが作成されるまで待つ

### 3. アプリケーションサービスの設定

1. アプリケーションサービスを開く
2. 「Settings」タブで以下を確認：
   - **Root Directory**: （空欄のまま）
   - **Build Command**: （自動検出）
   - **Start Command**: （自動検出）

---

## 環境変数の設定

### 重要な注意事項

**`.env`ファイルはGitにコミットされません**。本番環境の環境変数は、Railwayダッシュボードの「Variables」タブで**手動で設定**する必要があります。

### 必須環境変数

アプリケーションサービスの「Variables」タブで、以下を1つずつ設定してください：

#### アプリケーション設定

```
APP_NAME=Liberaspace
APP_ENV=production
APP_KEY=base64:...（生成したキー）
APP_DEBUG=false
APP_URL=https://your-app.railway.app
APP_TIMEZONE=Asia/Tokyo
```

#### データベース接続設定

データベースサービスの「Variables」タブで以下を確認し、アプリケーションサービスの「Variables」タブで設定：

```
DB_CONNECTION=mysql
DB_HOST=mysql.railway.internal
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=root
DB_PASSWORD=your_password（データベースサービスのMYSQLPASSWORD）
```

#### キャッシュとセッション設定

```
CACHE_STORE=file
SESSION_DRIVER=file
```

#### 管理画面パスワード

```
ADMIN_PASSWORD=your_secure_password
```

### APP_KEYの生成方法

1. Railwayダッシュボードでアプリケーションサービスのターミナルを開く
2. 以下のコマンドを実行：

```bash
php artisan key:generate --show
```

3. 出力されたキーをコピー
4. 「Variables」タブで`APP_KEY`に設定

### 環境変数の設定方法

1. アプリケーションサービスの「Variables」タブを開く
2. 「+ New Variable」をクリック
3. **Variable**欄に環境変数名を入力
4. **Value**欄に値を入力
5. 「Add」をクリック

**注意**: 環境変数は1つずつ個別に設定してください。まとめて設定するとエラーが発生する可能性があります。

---

## データベースの設定

### データベース接続情報の取得

1. データベースサービスの「Variables」タブを開く
2. 以下の値を確認：
   - `MYSQLHOST` → `DB_HOST`に設定
   - `MYSQLPORT` → `DB_PORT`に設定
   - `MYSQLDATABASE` → `DB_DATABASE`に設定
   - `MYSQLUSER` → `DB_USERNAME`に設定
   - `MYSQLPASSWORD` → `DB_PASSWORD`に設定

### マイグレーションの実行

アプリケーションが起動したら、Railwayダッシュボードのターミナルで：

```bash
php artisan migrate --force
```

---

## よくある問題と解決方法

### 1. 500エラー

#### 原因1: APP_KEYが設定されていない

**解決方法**:
1. `APP_KEY`を生成して設定（上記参照）

#### 原因2: データベース接続エラー

**エラーメッセージ**: `php_network_getaddresses: getaddrinfo for mysql.railway.internal failed`

**解決方法**:
1. データベースサービスが起動しているか確認
2. 環境変数`DB_HOST`、`DB_PORT`、`DB_DATABASE`、`DB_USERNAME`、`DB_PASSWORD`が正しく設定されているか確認
3. データベースサービスとアプリケーションサービスが同じプロジェクト内にあるか確認

#### 原因3: キャッシュドライバーの問題

**エラーメッセージ**: `SQLSTATE[HY000] [2002] ... delete from cache`

**解決方法**:
1. 環境変数`CACHE_STORE=file`を設定
2. 環境変数`SESSION_DRIVER=file`を設定

### 2. CSS/JSが読み込まれない

#### 原因: Mixed Contentエラー

**エラーメッセージ**: `Mixed Content: The page at 'https://...' was loaded over HTTPS, but requested an insecure stylesheet 'http://...'`

**解決方法**:
- レイアウトファイルで`{{ asset('css/main.css') }}`を`/css/main.css`に変更（既に修正済み）
- 環境変数`APP_URL`が`https://`で始まっているか確認

### 3. ヘルスチェック失敗

**解決方法**:
1. Railwayダッシュボードの「Logs」タブでエラーメッセージを確認
2. アプリケーションが正常に起動しているか確認
3. 環境変数が正しく設定されているか確認

### 4. ビルドエラー

#### エラー: `bootstrap/cache directory must be present`

**解決方法**:
- `railway.json`と`railway.toml`で`mkdir -p bootstrap/cache`が実行されているか確認（既に修正済み）

---

## ローカル環境からの操作

### マイグレーションの実行

ローカル環境から`railway run php artisan migrate`を実行すると、`mysql.railway.internal`が解決できないエラーが発生します。

**解決方法**: Railwayダッシュボードのターミナルから実行してください。

1. Railwayダッシュボードでアプリケーションサービスを開く
2. 「Deployments」タブを開く
3. 最新のデプロイメントをクリック
4. 「View Logs」またはターミナルアイコンをクリック
5. 以下のコマンドを実行：

```bash
php artisan migrate --force
```

### 環境変数の更新

ローカルの`.env`ファイルを更新しても、本番環境には反映されません。

**解決方法**: Railwayダッシュボードの「Variables」タブで手動で設定してください（上記「環境変数の設定」を参照）。

---

## チェックリスト

デプロイ前に以下を確認：

- [ ] データベースサービスが起動している
- [ ] アプリケーションサービスの環境変数がすべて設定されている
- [ ] `APP_KEY`が生成されて設定されている
- [ ] `APP_URL`が`https://`で始まっている
- [ ] データベース接続情報が正しく設定されている
- [ ] `CACHE_STORE=file`が設定されている
- [ ] `SESSION_DRIVER=file`が設定されている
- [ ] マイグレーションが実行されている

---

## 参考リンク

- [Railway公式ドキュメント](https://docs.railway.app)
- [Laravel公式ドキュメント](https://laravel.com/docs)

---

## トラブルシューティング

問題が解決しない場合：

1. Railwayダッシュボードの「Logs」タブでエラーメッセージを確認
2. 環境変数が正しく設定されているか再確認
3. アプリケーションを再起動（環境変数を変更すると自動的に再起動されます）

