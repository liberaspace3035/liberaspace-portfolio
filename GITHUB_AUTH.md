# GitHub認証手順

## 認証エラーが発生した場合

GitHubにプッシュする際、認証が必要です。以下の方法で認証できます。

## 方法1: Personal Access Token (PAT) を使用（推奨）

### 1. GitHubでPersonal Access Tokenを作成

1. https://github.com/settings/tokens にアクセス
2. 「Generate new token」→「Generate new token (classic)」をクリック
3. トークン名を入力（例: `railway-deploy`）
4. 有効期限を設定（推奨: 90日または無期限）
5. スコープで以下を選択：
   - ✅ `repo` (Full control of private repositories)
6. 「Generate token」をクリック
7. **トークンをコピー**（この画面でしか表示されません）

### 2. トークンを使用してプッシュ

```bash
# プッシュ時に認証を求められたら：
# Username: あなたのGitHubユーザー名（liberaspace3035）
# Password: コピーしたPersonal Access Token

git push -u origin main
```

### 3. 認証情報を保存（オプション）

初回認証後、認証情報が保存されます。次回からは自動的に認証されます。

## 方法2: SSHキーを使用

### 1. SSHキーを生成（まだの場合）

```bash
ssh-keygen -t ed25519 -C "your_email@example.com"
```

### 2. SSHキーをGitHubに追加

```bash
# 公開鍵をコピー
cat ~/.ssh/id_ed25519.pub

# コピーした内容を以下に追加：
# https://github.com/settings/keys
```

### 3. SSH URLに変更

```bash
git remote set-url origin git@github.com:liberaspace3035/liberaspace-portfolio.git
git push -u origin main
```

## 方法3: GitHub CLIを使用

```bash
# GitHub CLIをインストール
brew install gh

# ログイン
gh auth login

# その後、通常通りプッシュ
git push -u origin main
```

## 現在のリモート設定

現在のリモートURL: `https://github.com/liberaspace3035/liberaspace-portfolio.git`

認証後、以下のコマンドでプッシュできます：

```bash
git push -u origin main
```

