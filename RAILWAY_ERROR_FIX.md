# Railway環境変数エラーの解決方法

## エラーの原因

エラーメッセージに「=環境変数=」が含まれていることから、RailwayのUIでVariable名に間違った値が設定されている可能性があります。

## 解決方法

### 方法1: 既存の環境変数を削除して再設定

1. Railwayダッシュボードでアプリケーションサービスを開く
2. 「Variables」タブを開く
3. **すべての環境変数を削除**（各変数の右側にある削除ボタンをクリック）
4. 再度、1つずつ正しく追加

### 方法2: Variable名とValueを確認

各環境変数を追加する際、以下を確認してください：

- **Variable名**: スペースや特殊文字を含まない（例: `APP_NAME`）
- **Value**: 値のみ（例: `Liberaspace`）

**❌ 間違いの例:**
- Variable: `=環境変数=APP_NAME`
- Variable: `APP_NAME=` 
- Variable: ` APP_NAME`（先頭にスペース）

**✅ 正しい例:**
- Variable: `APP_NAME`
- Value: `Liberaspace`

### 方法3: 自動変数参照の構文を確認

自動変数参照（`${{MySQL.MYSQLHOST}}`）が動作しない場合、以下の点を確認：

1. **データベースサービスの名前を確認**
   - Railwayダッシュボードでデータベースサービスをクリック
   - サービス名を確認（例: `MySQL`、`Postgres`など）
   - 自動変数参照では、このサービス名を使用します

2. **正しい構文**
   ```
   ${{サービス名.変数名}}
   ```
   
   例:
   - `${{MySQL.MYSQLHOST}}`
   - `${{Postgres.PGHOST}}`

3. **サービス名が異なる場合**
   - データベースサービスの名前が`MySQL`でない場合（例: `mysql`、`database`など）
   - そのサービス名を使用してください

### 方法4: 手動で値を設定（確実な方法）

自動変数参照が動作しない場合は、手動で値を設定してください：

1. データベースサービスの「Variables」タブで値を確認
2. アプリケーションサービスの「Variables」タブで以下を設定：

```
DB_HOST = mysql.railway.internal
DB_PORT = 3306
DB_DATABASE = railway
DB_USERNAME = root
DB_PASSWORD = eUBGyXhSYxtwLbksUMDLfTYDHzdNIXpX
```

## ステップバイステップ: 正しい設定方法

### 1. 既存の環境変数をすべて削除

1. 「Variables」タブを開く
2. 各環境変数の右側にある「削除」ボタン（ゴミ箱アイコン）をクリック
3. すべて削除する

### 2. 環境変数を1つずつ追加

各環境変数を追加する際、以下を厳密に守ってください：

#### APP_NAME
- 「+ New Variable」をクリック
- **Variable**: `APP_NAME`（コピー&ペースト推奨）
- **Value**: `Liberaspace`
- 「Add」をクリック

#### APP_ENV
- 「+ New Variable」をクリック
- **Variable**: `APP_ENV`
- **Value**: `production`
- 「Add」をクリック

#### APP_DEBUG
- 「+ New Variable」をクリック
- **Variable**: `APP_DEBUG`
- **Value**: `false`
- 「Add」をクリック

#### APP_TIMEZONE
- 「+ New Variable」をクリック
- **Variable**: `APP_TIMEZONE`
- **Value**: `Asia/Tokyo`
- 「Add」をクリック

#### DB_CONNECTION
- 「+ New Variable」をクリック
- **Variable**: `DB_CONNECTION`
- **Value**: `mysql`
- 「Add」をクリック

#### DB_HOST（手動設定推奨）
- 「+ New Variable」をクリック
- **Variable**: `DB_HOST`
- **Value**: `mysql.railway.internal`（自動変数参照を使わず、直接値を入力）
- 「Add」をクリック

#### DB_PORT（手動設定推奨）
- 「+ New Variable」をクリック
- **Variable**: `DB_PORT`
- **Value**: `3306`
- 「Add」をクリック

#### DB_DATABASE（手動設定推奨）
- 「+ New Variable」をクリック
- **Variable**: `DB_DATABASE`
- **Value**: `railway`
- 「Add」をクリック

#### DB_USERNAME（手動設定推奨）
- 「+ New Variable」をクリック
- **Variable**: `DB_USERNAME`
- **Value**: `root`
- 「Add」をクリック

#### DB_PASSWORD（手動設定推奨）
- 「+ New Variable」をクリック
- **Variable**: `DB_PASSWORD`
- **Value**: `eUBGyXhSYxtwLbksUMDLfTYDHzdNIXpX`（データベースのパスワード）
- 「Add」をクリック

#### ADMIN_PASSWORD
- 「+ New Variable」をクリック
- **Variable**: `ADMIN_PASSWORD`
- **Value**: `your_secure_password_here`（実際のパスワードに変更）
- 「Add」をクリック

## 確認事項

設定後、「Variables」タブで以下を確認：

1. Variable名に余分な文字（`=`、スペースなど）が含まれていない
2. Valueが正しく設定されている
3. 自動変数参照を使っている場合、構文が正しい（`${{サービス名.変数名}}`）

## それでもエラーが出る場合

1. **Railwayダッシュボードをリロード**
2. **ブラウザのキャッシュをクリア**
3. **別のブラウザで試す**
4. **Railwayのサポートに問い合わせ**

## 一時的な回避策

環境変数の設定に問題がある場合、`railway.toml`に直接環境変数を設定することはできませんが、デプロイ後にRailway CLIを使用して設定することもできます：

```bash
# Railway CLIをインストール
npm i -g @railway/cli

# ログイン
railway login

# プロジェクトに接続
railway link

# 環境変数を設定
railway variables set APP_NAME=Liberaspace
railway variables set APP_ENV=production
# ... 以下同様
```

