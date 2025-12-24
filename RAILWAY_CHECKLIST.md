# Railway環境変数設定チェックリスト

## 各環境変数の設定を確認

以下のチェックリストで、各環境変数が正しく設定されているか確認してください。

### ✅ チェックポイント

各環境変数を追加する際、以下を確認：

1. **Variable名に余分な文字がないか**
   - ❌ `=APP_NAME`
   - ❌ `APP_NAME=`
   - ❌ ` APP_NAME`（先頭にスペース）
   - ❌ `APP_NAME `（末尾にスペース）
   - ✅ `APP_NAME`（正しい）

2. **Valueに余分な文字がないか**
   - ❌ `=Liberaspace`
   - ❌ `Liberaspace=`
   - ❌ ` Liberaspace`（先頭にスペース）
   - ❌ `Liberaspace `（末尾にスペース）
   - ✅ `Liberaspace`（正しい）

3. **自動変数参照の構文**
   - ❌ `{{MySQL.MYSQLHOST}}`（$がない）
   - ❌ `$MySQL.MYSQLHOST`（{{}}がない）
   - ❌ `${{MySQL.MYSQLHOST}} `（末尾にスペース）
   - ✅ `${{MySQL.MYSQLHOST}}`（正しい）

## 推奨: 手動で値を設定

自動変数参照が問題を引き起こしている可能性があるため、**手動で値を設定することを強く推奨**します。

### 正しい設定値

以下の値を**そのままコピー&ペースト**して使用してください：

#### 1. APP_NAME
- Variable: `APP_NAME`
- Value: `Liberaspace`

#### 2. APP_ENV
- Variable: `APP_ENV`
- Value: `production`

#### 3. APP_DEBUG
- Variable: `APP_DEBUG`
- Value: `false`

#### 4. APP_TIMEZONE
- Variable: `APP_TIMEZONE`
- Value: `Asia/Tokyo`

#### 5. DB_CONNECTION
- Variable: `DB_CONNECTION`
- Value: `mysql`

#### 6. DB_HOST
- Variable: `DB_HOST`
- Value: `mysql.railway.internal`

#### 7. DB_PORT
- Variable: `DB_PORT`
- Value: `3306`

#### 8. DB_DATABASE
- Variable: `DB_DATABASE`
- Value: `railway`

#### 9. DB_USERNAME
- Variable: `DB_USERNAME`
- Value: `root`

#### 10. DB_PASSWORD
- Variable: `DB_PASSWORD`
- Value: `eUBGyXhSYxtwLbksUMDLfTYDHzdNIXpX`

#### 11. ADMIN_PASSWORD
- Variable: `ADMIN_PASSWORD`
- Value: `your_secure_password_here`（実際のパスワードに変更）

## 設定手順（再確認）

1. **既存の環境変数をすべて削除**
   - 「Variables」タブで各変数の削除ボタンをクリック

2. **1つずつ追加**
   - 「+ New Variable」をクリック
   - Variable名を**コピー&ペースト**（手入力しない）
   - Valueを**コピー&ペースト**（手入力しない）
   - 「Add」をクリック

3. **次の環境変数を追加**
   - 再度「+ New Variable」をクリック
   - 上記の手順を繰り返す

## エラーが続く場合の対処法

### 1. Railwayダッシュボードをリロード
- ブラウザを完全にリロード（Cmd+Shift+R / Ctrl+Shift+R）
- または、別のブラウザで試す

### 2. ブラウザの開発者ツールで確認
- F12キーを押して開発者ツールを開く
- 「Network」タブを開く
- 環境変数を追加する際のリクエストを確認
- エラーレスポンスの詳細を確認

### 3. Railway CLIを使用（代替方法）

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
railway variables set APP_DEBUG=false
railway variables set APP_TIMEZONE=Asia/Tokyo
railway variables set DB_CONNECTION=mysql
railway variables set DB_HOST=mysql.railway.internal
railway variables set DB_PORT=3306
railway variables set DB_DATABASE=railway
railway variables set DB_USERNAME=root
railway variables set DB_PASSWORD=eUBGyXhSYxtwLbksUMDLfTYDHzdNIXpX
railway variables set ADMIN_PASSWORD=your_secure_password_here
```

## 現在の設定を確認

Railwayダッシュボードの「Variables」タブで、各環境変数を確認してください：

- Variable名に余分な文字がないか
- Valueが正しく設定されているか
- 自動変数参照を使っている場合、構文が正しいか

問題がある環境変数を見つけたら、削除して再設定してください。

