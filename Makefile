.PHONY: up down install watch dev

# Docker起動
up:
	docker compose up -d

# Docker停止
down:
	docker compose down

# npm install（初回セットアップ時に実行）
install:
	cd src/wp-content/themes/my-theme && npm install

# SCSSの変更を監視してビルド
watch:
	cd src/wp-content/themes/my-theme && npm run watch

# 開発開始（Docker起動 + npm watch）
dev:
	docker compose up -d && cd src/wp-content/themes/my-theme && npm run watch
