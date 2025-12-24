#!/bin/bash
# コミット履歴からトークンを削除するスクリプト

# 問題のあるコミットを修正
git filter-branch --force --index-filter \
  "git rm --cached --ignore-unmatch TROUBLESHOOTING.md push-to-github.sh 2>/dev/null || true" \
  --prune-empty --tag-name-filter cat -- --all

# または、より簡単な方法：問題のあるコミットを修正
git filter-branch -f --tree-filter '
  if [ -f TROUBLESHOOTING.md ]; then
    sed -i "" "s/github_pat_[A-Za-z0-9_]*/YOUR_TOKEN_HERE/g" TROUBLESHOOTING.md 2>/dev/null || true
  fi
  if [ -f push-to-github.sh ]; then
    sed -i "" "s/github_pat_[A-Za-z0-9_]*/YOUR_TOKEN_HERE/g" push-to-github.sh 2>/dev/null || true
  fi
' --prune-empty --tag-name-filter cat -- --all

