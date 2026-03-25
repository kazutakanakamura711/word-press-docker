.PHONY: up down install copy-images build watch dev

# Docker起動
up:
	docker compose up -d

# Docker停止
down:
	docker compose down

# npm install（初回セットアップ時に実行）
install:
	cd src/wp-content/themes/my-theme && npm install

# src/images/ を assets/images/ にコピー
copy-images:
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
