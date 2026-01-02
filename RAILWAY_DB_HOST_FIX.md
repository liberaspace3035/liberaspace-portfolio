# データベース接続エラー: ${MYSQLHOST} の解決方法

## エラーの意味

```
SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for ${MYSQLHOST} failed
```

このエラーは、環境変数`DB_HOST`に`${MYSQLHOST}`という**文字列そのまま**が設定されていることを示しています。

環境変数の参照（`${{MySQL.MYSQLHOST}}`など）が正しく展開されず、文字列としてそのまま使われているため、データベース接続に失敗しています。

## 解決方法

### 方法1: 直接値を設定する（推奨）

1. Railwayダッシュボードで**データベースサービス**を開く
2. 「Variables」タブで`MYSQLHOST`の値を確認（例: `mysql.railway.internal`）
3. **アプリケーションサービス**の「Variables」タブを開く
4. `DB_HOST`を探す（または新規作成）
5. **Variable**: `DB_HOST`
6. **Value**: データベースサービスの`MYSQLHOST`の値を**直接入力**（例: `mysql.railway.internal`）
7. 「Save」をクリック

**重要**: 自動変数参照（`${{MySQL.MYSQLHOST}}`）は使わず、**直接値を入力**してください。

### 方法2: すべてのデータベース接続情報を確認

以下の環境変数がすべて**直接値**で設定されているか確認してください：

| 環境変数 | データベースサービスの変数 | 例 |
|---------|------------------------|-----|
| `DB_HOST` | `MYSQLHOST` | `mysql.railway.internal` |
| `DB_PORT` | `MYSQLPORT` | `3306` |
| `DB_DATABASE` | `MYSQLDATABASE` | `railway` |
| `DB_USERNAME` | `MYSQLUSER` | `root` |
| `DB_PASSWORD` | `MYSQLPASSWORD` | `your_password` |

### 確認手順

1. **データベースサービス**の「Variables」タブで以下を確認：
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`

2. **アプリケーションサービス**の「Variables」タブで以下を確認：
   - `DB_HOST` = データベースサービスの`MYSQLHOST`の値（直接入力）
   - `DB_PORT` = データベースサービスの`MYSQLPORT`の値（直接入力）
   - `DB_DATABASE` = データベースサービスの`MYSQLDATABASE`の値（直接入力）
   - `DB_USERNAME` = データベースサービスの`MYSQLUSER`の値（直接入力）
   - `DB_PASSWORD` = データベースサービスの`MYSQLPASSWORD`の値（直接入力）

3. **環境変数を更新したら**、アプリケーションが自動的に再起動されます

## よくある間違い

### ❌ 間違い: 自動変数参照を使用

```
DB_HOST=${{MySQL.MYSQLHOST}}
```

これが正しく展開されない場合、`${MYSQLHOST}`という文字列がそのまま使われます。

### ✅ 正しい: 直接値を設定

```
DB_HOST=mysql.railway.internal
```

データベースサービスの「Variables」タブで確認した値を、そのまま入力してください。

## トラブルシューティング

### まだエラーが発生する場合

1. 環境変数を削除して再作成する
2. 値に余分なスペースや改行がないか確認
3. データベースサービスが起動しているか確認
4. データベースサービスとアプリケーションサービスが同じプロジェクト内にあるか確認

