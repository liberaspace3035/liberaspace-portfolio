# R2アップロード問題のデバッグガイド

## 問題
画像をアップロードしてもR2側にストレージが作成されない

## 確認事項

### 1. 環境変数の確認

Railwayダッシュボードで以下の環境変数が正しく設定されているか確認してください：

```env
FILESYSTEM_DISK=r2
AWS_ACCESS_KEY_ID=21afe94eb4420a5310ecaf42846afb24
AWS_SECRET_ACCESS_KEY=0fb13a5d82e5e38f99a09c7051634253a8a91fcd4f5bc3e4cd3d7c223416398d
AWS_BUCKET=liberaspace
AWS_DEFAULT_REGION=auto
AWS_ENDPOINT=https://78813fe09807c5e2e691a2d75724ad45.r2.cloudflarestorage.com
AWS_URL=https://pub-150989a197044c1d98298caf9648c541.r2.dev
AWS_USE_PATH_STYLE_ENDPOINT=true
```

**重要**: `AWS_ENDPOINT`の値は、**バケット名を含まない**エンドポイントURLである必要があります。

- ❌ 間違い: `https://78813fe09807c5e2e691a2d75724ad45.r2.cloudflarestorage.com/liberaspace`
- ✅ 正しい: `https://78813fe09807c5e2e691a2d75724ad45.r2.cloudflarestorage.com`

### 2. ログの確認

アップロードを試みた後、Railwayのログを確認してください：

1. Railwayダッシュボードでサービスを開く
2. 「Deployments」タブを開く
3. 最新のデプロイメントのログを確認
4. 以下のようなログメッセージを探してください：
   - `Uploading image to disk: r2`
   - `R2 Config Check:`
   - `Image uploaded successfully:` または `Image upload failed:`

### 3. エラーメッセージの確認

アップロード時にエラーメッセージが表示される場合は、その内容を確認してください。

## よくある問題と解決方法

### 問題1: エンドポイントURLにバケット名が含まれている

**症状**: アップロードが失敗する

**解決方法**: 
- `AWS_ENDPOINT`からバケット名（`/liberaspace`）を削除
- エンドポイントは `https://<account-id>.r2.cloudflarestorage.com` の形式である必要があります

### 問題2: FILESYSTEM_DISKが設定されていない

**症状**: ローカルストレージに保存される

**解決方法**: 
- `FILESYSTEM_DISK=r2` を設定してください

### 問題3: 認証情報が間違っている

**症状**: 認証エラーが発生する

**解決方法**: 
- Cloudflare R2ダッシュボードでAPIキーを再生成
- 新しい認証情報を環境変数に設定

### 問題4: バケット名が間違っている

**症状**: バケットが見つからないエラー

**解決方法**: 
- `AWS_BUCKET=liberaspace` が正しく設定されているか確認

## テスト方法

1. 管理画面にログイン
2. 制作実績を新規追加
3. 画像をアップロード
4. Railwayのログを確認
5. Cloudflare R2ダッシュボードでバケットの内容を確認

## 次のステップ

ログにエラーメッセージが表示されている場合は、その内容を確認して問題を特定してください。

