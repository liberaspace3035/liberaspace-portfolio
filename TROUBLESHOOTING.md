# GitHub認証トラブルシューティング

## 現在の状況

- リモートリポジトリ: 設定済み ✅
- Personal Access Token: 提供済み ✅
- プッシュ: 403エラー ❌

## 考えられる原因

1. **トークンの権限不足**: `repo`スコープが正しく設定されていない可能性
2. **トークンの有効期限**: トークンが期限切れの可能性
3. **リポジトリへのアクセス権限**: トークンにリポジトリへの書き込み権限がない

## 解決方法

### 方法1: トークンの権限を確認・再作成

1. https://github.com/settings/tokens にアクセス
2. 作成したトークンを確認
3. 以下のスコープが有効になっているか確認：
   - ✅ `repo` (Full control of private repositories)
   - ✅ `workflow` (Update GitHub Action workflows) - 必要に応じて

4. 権限が不足している場合は、新しいトークンを作成：
   - 「Generate new token (classic)」
   - スコープで `repo` を選択
   - トークンをコピー

### 方法2: GitHub CLIを使用（推奨）

```bash
# GitHub CLIをインストール
brew install gh

# ログイン（ブラウザで認証）
gh auth login

# リポジトリを確認
gh repo view liberaspace3035/liberaspace-portfolio

# プッシュ
git push -u origin main
```

### 方法3: SSHキーを使用

```bash
# SSHキーを生成（まだの場合）
ssh-keygen -t ed25519 -C "info@liberaspace.com"

# 公開鍵をコピー
cat ~/.ssh/id_ed25519.pub

# GitHubにSSHキーを追加
# https://github.com/settings/keys にアクセス
# 「New SSH key」をクリック
# コピーした公開鍵を貼り付け

# SSH URLに変更
git remote set-url origin git@github.com:liberaspace3035/liberaspace-portfolio.git

# プッシュ
git push -u origin main
```

### 方法4: トークンを環境変数として使用

```bash
# 環境変数に設定（実際のトークンに置き換えてください）
export GITHUB_TOKEN=your_personal_access_token_here

# URLを通常の形式に戻す
git remote set-url origin https://github.com/liberaspace3035/liberaspace-portfolio.git

# 認証ヘルパーを設定
git config --global credential.helper '!f() { echo "username=liberaspace3035"; echo "password=$GITHUB_TOKEN"; }; f'

# プッシュ
git push -u origin main
```

## 次のステップ

1. トークンの権限を確認
2. GitHub CLIをインストールして認証（最も簡単）
3. または、SSHキーを使用

GitHub CLIを使用することをお勧めします。ブラウザで認証できるため、最も簡単で安全です。

