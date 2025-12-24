#!/bin/bash
# GitHubにプッシュするスクリプト

# リモートURLを設定
git remote set-url origin https://github.com/liberaspace3035/liberaspace-portfolio.git

# 認証情報を設定（トークンを使用）
# Username: liberaspace3035
# Password: Personal Access Token

echo "GitHubにプッシュします..."
echo "認証が求められたら、以下を入力してください："
echo "Username: liberaspace3035"
echo "Password: Personal Access Token (github_pat_...)"
echo ""
echo "または、以下のコマンドを実行してください："
echo ""
echo "GIT_ASKPASS=echo git -c credential.helper='!f() { echo username=liberaspace3035; echo password=YOUR_TOKEN_HERE; }; f' push -u origin main"

