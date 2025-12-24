# GitHub接続手順

## 1. GitHubリポジトリの作成

1. https://github.com にアクセスしてログイン
2. 右上の「+」→「New repository」をクリック
3. リポジトリ名を入力（例: `liberaspace-portfolio`）
4. 「Public」または「Private」を選択
5. 「Initialize this repository with a README」は**チェックしない**（既にREADMEがあります）
6. 「Create repository」をクリック

## 2. ローカルリポジトリをGitHubに接続

GitHubでリポジトリを作成したら、以下のコマンドを実行してください：

```bash
# GitHubリポジトリのURLを設定（yourusernameとリポジトリ名を変更してください）
git remote add origin https://github.com/yourusername/liberaspace-portfolio.git

# リモートリポジトリを確認
git remote -v

# コードをプッシュ
git push -u origin main
```

## 3. SSHキーを使用する場合

SSHキーを設定している場合は、以下のように接続できます：

```bash
git remote add origin git@github.com:yourusername/liberaspace-portfolio.git
git push -u origin main
```

## 4. 認証が必要な場合

GitHubにプッシュする際、認証が求められる場合があります：

- **Personal Access Token (PAT)** を使用する方法（推奨）
  1. GitHub → Settings → Developer settings → Personal access tokens → Tokens (classic)
  2. 「Generate new token」をクリック
  3. 必要な権限を選択（`repo`）
  4. トークンをコピー
  5. パスワードの代わりにトークンを入力

- **GitHub CLI** を使用する方法
  ```bash
  # GitHub CLIをインストール（未インストールの場合）
  brew install gh
  
  # ログイン
  gh auth login
  
  # その後、通常通りプッシュ
  git push -u origin main
  ```

## 5. 確認

プッシュが成功したら、GitHubのリポジトリページでファイルが表示されることを確認してください。

## 次のステップ

GitHubリポジトリに接続したら、Railwayで「Deploy from GitHub repo」を選択してデプロイできます。

