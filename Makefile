.PHONY: up down install install-medical composer-install copy-images build watch dev

# Docker起動
up:
	docker compose up -d

# Docker停止
down:
	docker compose down

# npm install（my-theme）
install:
	cd src/wp-content/themes/my-theme && npm install

# npm install（medical-theme）
install-medical:
	cd src/wp-content/themes/medical-theme && npm install

# Composer install（医療テーマのPHP依存パッケージ。Dockerコンテナが起動している必要あり）
composer-install:
	docker exec -w /var/www/html/wp-content/themes/medical-theme wordpress_app composer install

# src/images/ を assets/images/ にコピー
copy-images:
	rm -rf src/wp-content/themes/my-theme/assets/images
	mkdir -p src/wp-content/themes/my-theme/assets/images
	cp -r src/wp-content/themes/my-theme/src/images/. src/wp-content/themes/my-theme/assets/images/

# CSSビルド + 画像コピー
build: copy-images
	cd src/wp-content/themes/my-theme && npm run build

# SCSSの変更を監視してビルド
watch:
	cd src/wp-content/themes/my-theme && npm run watch

# 開発開始（Docker起動 + npm watch）
dev:
	docker compose up -d && cd src/wp-content/themes/my-theme && npm run watch
