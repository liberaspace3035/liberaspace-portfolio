# R2環境変数チェックリスト

## 必須環境変数

Railwayダッシュボードで以下の環境変数が正しく設定されているか確認してください：

### 1. ストレージディスク設定
```env
FILESYSTEM_DISK=r2
```

### 2. R2認証情報（Account API Tokenから取得）
```env
AWS_ACCESS_KEY_ID=<TokenのAccess Key ID>
AWS_SECRET_ACCESS_KEY=<TokenのSecret Access Key>
```

**重要**: Account API Tokenを作成した際に表示された：
- **Access Key ID** → `AWS_ACCESS_KEY_ID`に設定
- **Secret Access Key** → `AWS_SECRET_ACCESS_KEY`に設定

### 3. R2バケット設定
```env
AWS_BUCKET=liberaspace
AWS_DEFAULT_REGION=auto
```

### 4. R2エンドポイント設定
```env
AWS_ENDPOINT=https://78813fe09807c5e2e691a2d75724ad45.r2.cloudflarestorage.com
```

**重要**: エンドポイントURLからバケット名（`/liberaspace`）を削除してください。

### 5. R2公開URL設定
```env
AWS_URL=https://pub-150989a197044c1d98298caf9648c541.r2.dev
```

### 6. パス形式エンドポイント設定
```env
AWS_USE_PATH_STYLE_ENDPOINT=true
```

## 確認手順

1. Railwayダッシュボードでアプリケーションサービスを開く
2. 「Variables」タブを開く
3. 上記の環境変数がすべて設定されているか確認
4. 特に`AWS_ENDPOINT`が`https://78813fe09807c5e2e691a2d75724ad45.r2.cloudflarestorage.com`（バケット名なし）になっているか確認

## よくある問題

### 問題1: Access Key IDとSecret Access Keyが間違っている
- Account API Tokenを作成した際に表示された値を正確にコピーしてください
- トークンは一度しか表示されないため、再生成が必要な場合は新しいトークンを作成してください

### 問題2: エンドポイントURLにバケット名が含まれている
- `AWS_ENDPOINT`から`/liberaspace`を削除してください
- 正しい形式: `https://78813fe09807c5e2e691a2d75724ad45.r2.cloudflarestorage.com`

### 問題3: FILESYSTEM_DISKが設定されていない
- `FILESYSTEM_DISK=r2`を設定してください
- 設定されていない場合、デフォルトで`public`（ローカルストレージ）が使用されます

## テスト方法

1. 環境変数を設定後、Railwayでアプリケーションを再起動
2. 管理画面にログイン
3. 制作実績を新規追加
4. 画像をアップロード
5. エラーメッセージまたは成功メッセージを確認
6. Railwayのログで詳細を確認

