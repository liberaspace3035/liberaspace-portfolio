#!/bin/bash
# Railwayデプロイ後のセットアップスクリプト

echo "🚀 Railwayデプロイ後のセットアップを開始します..."

# マイグレーション実行
echo "📊 データベースマイグレーションを実行中..."
php artisan migrate --force

# ストレージリンク作成
echo "🔗 ストレージリンクを作成中..."
php artisan storage:link

# キャッシュクリア
echo "🧹 キャッシュをクリア中..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# キャッシュ生成（本番環境用）
echo "⚡ キャッシュを生成中..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# APP_KEYが設定されていない場合、生成
if [ -z "$APP_KEY" ]; then
    echo "🔑 APP_KEYが設定されていません。生成します..."
    php artisan key:generate --force
fi

echo "✅ セットアップが完了しました！"

