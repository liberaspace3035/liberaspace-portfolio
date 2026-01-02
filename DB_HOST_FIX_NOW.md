# DB_HOSTエラーを今すぐ修正する方法

## 現在のエラー

```
SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for ${MYSQLHOST} failed
```

これは、`DB_HOST`環境変数に`${MYSQLHOST}`という**文字列そのまま**が設定されていることを示しています。

## 今すぐやること（ステップバイステップ）

### ステップ1: データベースサービスの値を確認

1. Railwayダッシュボード（https://railway.app）にログイン
2. プロジェクトを選択
3. **データベースサービス（MySQL）**をクリック
4. 「Variables」タブを開く
5. 以下の値を**メモまたはコピー**：
   ```
   MYSQLHOST: mysql.railway.internal（例）
   MYSQLPORT: 3306（例）
   MYSQLDATABASE: railway（例）
   MYSQLUSER: root（例）
   MYSQLPASSWORD: （実際のパスワード）
   ```

### ステップ2: アプリケーションサービスの環境変数を修正

1. 同じプロジェクトで**アプリケーションサービス**をクリック
2. 「Variables」タブを開く
3. `DB_HOST`を探してクリック

### ステップ3: DB_HOSTを修正

1. `DB_HOST`の値を確認
2. もし`${MYSQLHOST}`や`${{MySQL.MYSQLHOST}}`のような文字列になっていたら：
   - 「Edit」または「Delete」をクリック
   - 新しい値として、ステップ1で確認した`MYSQLHOST`の値を**直接入力**
   - 例: `mysql.railway.internal`
   - 「Save」をクリック

### ステップ4: 他のデータベース接続情報も確認

以下の環境変数がすべて**直接値**で設定されているか確認：

| 環境変数 | 値の例 | 確認ポイント |
|---------|--------|------------|
| `DB_HOST` | `mysql.railway.internal` | `${MYSQLHOST}`ではない |
| `DB_PORT` | `3306` | `${MYSQLPORT}`ではない |
| `DB_DATABASE` | `railway` | `${MYSQLDATABASE}`ではない |
| `DB_USERNAME` | `root` | `${MYSQLUSER}`ではない |
| `DB_PASSWORD` | （実際のパスワード） | `${MYSQLPASSWORD}`ではない |

### ステップ5: 確認

1. すべての環境変数が**直接値**で設定されているか確認
2. 環境変数を更新すると、アプリケーションが自動的に再起動されます
3. 数分待ってから、アプリケーションにアクセスしてエラーが解消されたか確認

## 重要な注意事項

### ❌ やってはいけないこと

- 自動変数参照（`${{MySQL.MYSQLHOST}}`）を使う
- 環境変数名（`${MYSQLHOST}`）をそのまま使う
- 値に余分なスペースや改行を含める

### ✅ 正しい設定方法

- データベースサービスの「Variables」タブで確認した値を**そのままコピー＆ペースト**
- すべての環境変数を**1つずつ個別に**設定
- 値は**直接入力**する

## まだエラーが発生する場合

1. 環境変数を**削除して再作成**する
2. データベースサービスが**起動している**か確認
3. データベースサービスとアプリケーションサービスが**同じプロジェクト内**にあるか確認
4. Railwayダッシュボードの「Logs」タブで、最新のエラーメッセージを確認



