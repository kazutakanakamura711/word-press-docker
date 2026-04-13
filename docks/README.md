# WordPress Docker 環境

## 環境情報

| 項目         | バージョン   |
| ------------ | ------------ |
| Web サーバー | Apache       |
| PHP          | 8.2.29       |
| データベース | MySQL 8.0.35 |
| WordPress    | 6.9.4        |

---

## ローカル環境の起動・停止

```bash
# 起動
docker compose up -d

# 停止
docker compose down
```

起動後、以下の URL でアクセスできます。

| 画面                  | URL                            |
| --------------------- | ------------------------------ |
| サイト                | http://localhost:8080          |
| 管理画面              | http://localhost:8080/wp-admin |
| MailHog（メール確認） | http://localhost:8025          |

---

## MailHog（ローカルメール確認ツール）

ローカル環境ではメールを実際に送信せず、MailHog で受信内容を確認できます。

- CF7 などのフォームで「送信」すると http://localhost:8025 の受信ボックスに届きます
- `src/wp-content/mu-plugins/local-smtp.php` が SMTP を MailHog に向けています
- このファイルは `WP_ENVIRONMENT_TYPE=local` の環境のみで動作し、本番には git / デプロイ除外されています

---

## セットアップ・開発コマンド（Makefile）

プロジェクトルートで `make` コマンドを使って操作します。

| コマンド                | 内容                                                                 |
| ----------------------- | -------------------------------------------------------------------- |
| `make up`               | Docker を起動する                                                    |
| `make down`             | Docker を停止する                                                    |
| `make install`          | my-theme の npm install を実行する（初回のみ）                       |
| `make install-medical`  | medical-theme の npm install を実行する（初回のみ）                  |
| `make composer-install` | Docker 経由で medical-theme の Composer パッケージをインストールする |
| `make watch`            | SCSS の変更を監視してビルドする                                      |
| `make dev`              | Docker 起動 + SCSS 監視を同時に開始する                              |

### 初回セットアップ

```bash
make up                  # Docker起動
make install             # my-theme: npm install
make install-medical     # medical-theme: npm install
make composer-install    # medical-theme: composer install（php-cs-fixer 等）
make watch               # SCSS監視開始
```

### 2回目以降の開発

```bash
make dev  # Docker起動 + SCSS監視を一括実行
```

> SCSS を編集すると自動で `assets/css/style.css` がビルドされ、`http://localhost:8080` に反映されます。

---

## medical-theme の開発コマンド

`medical-theme/` は Vite + Tailwind CSS v4 を使用しています。

```bash
cd src/wp-content/themes/medical-theme

npm install       # 初回のみ
npm run dev       # 開発サーバー起動（ウォッチモード）
npm run build     # 本番用ビルド（assets/ に出力）
```

> ビルド後の `assets/css/style.css` と `assets/js/main.js` がWordPressで読み込まれます。

---

## medical-theme の ACF（Advanced Custom Fields）設計

`medical-theme` では ACF 無料版を使用し、固定ページをデータの管理場所（SSOT）として活用しています。

### フィールドグループとページの対応

| フィールドグループ | 表示される固定ページ（スラッグ）   | 主なフィールド                                           |
| ------------------ | ---------------------------------- | -------------------------------------------------------- |
| ページ設定         | 全固定ページ（フロントページ除く） | ページヘッダー背景画像                                   |
| トップページ設定   | フロントページ（トップ）           | ヒーロー背景画像 / About セクション画像                  |
| 院長情報           | `about`                            | 院長画像 / 院長氏名 / 院長挨拶文                         |
| クリニック基本情報 | `access`                           | 住所 / 電話番号 / 最寄り駅                               |
| 診療時間           | `access`                           | 月〜日・祝 の午前・午後の開始/終了時間（計28フィールド） |
| 診療案内           | `services`                         | 科目01〜16 ごとのタイトル / 説明文 / 画像                |

### データ参照の方針

- クリニック基本情報・診療時間は `access` ページを唯一のマスタとして管理します
- `page-about.php` / `page-access.php` / `home-access.php` / `footer.php` はすべて `get_page_id_by_slug('access')` 経由でデータを取得します
- 診療案内データは `services` ページを唯一のマスタとして管理します
- トップページの診療案内（`home-services.php`）も `get_page_id_by_slug('services')` からタイトルを取得します

### 初回データ入力の順番

WordPress 管理画面でデータを入力する際は以下の順番を推奨します。

1. **診療時間・アクセス**（スラッグ: `access`）→ クリニック基本情報 + 診療時間28フィールド
2. **診療案内**（スラッグ: `services`）→ service_01〜16 のタイトル / 説明文 / 画像
3. **トップ**（フロントページ）→ ヒーロー背景画像 / About セクション画像
4. **医院について**（スラッグ: `about`）→ 院長画像 / 氏名 / 挨拶文

> 各固定ページのスラッグ（`access` / `services` / `about`）は `get_page_id_by_slug()` の引数と一致している必要があります。スラッグを変更した場合はコードの対応箇所も合わせて変更してください。

---

## コード品質（ESLint / Prettier / Husky）

`my-theme/` と `medical-theme/` でそれぞれ以下のツールを使用します。

### my-theme のコマンド

| コマンド           | 内容                                           |
| ------------------ | ---------------------------------------------- |
| `npm run lint`     | TypeScript のLintチェック（ESLint）            |
| `npm run lint:fix` | TypeScript のLint自動修正                      |
| `npm run format`   | TS / SCSS / PHP ファイルを Prettier で一括整形 |

```bash
cd src/wp-content/themes/my-theme

npm run lint        # Lintチェック
npm run lint:fix    # 自動修正
npm run format      # 全ファイル整形
```

### medical-theme のコマンド

| コマンド           | 内容                                                |
| ------------------ | --------------------------------------------------- |
| `npm run lint`     | TypeScript のLintチェック（ESLint）                 |
| `npm run lint:fix` | TypeScript のLint自動修正                           |
| `npm run format`   | TS / CSS / PHP ファイルを Prettier で一括整形       |

```bash
cd src/wp-content/themes/medical-theme

npm run lint        # Lintチェック
npm run lint:fix    # 自動修正
npm run format      # 全ファイル整形
```

### 各ツールの役割

**ESLint**
TypeScript（`src/ts/`）の構文エラーやコード品質をチェックします。設定ファイル: `eslint.config.js`

**Prettier**
TS / SCSS / CSS のコードスタイルを統一します。設定ファイル: `.prettierrc`

| テーマ        | 対象 | インデント | クォート |
| ------------- | ---- | ---------- | -------- |
| my-theme      | TS   | 2スペース  | ダブル   |
| my-theme      | SCSS | 2スペース  | ダブル   |
| my-theme      | PHP  | 4スペース  | シングル |
| medical-theme | TS   | 2スペース  | ダブル   |
| medical-theme | CSS  | 2スペース  | ダブル   |
| medical-theme | PHP  | 4スペース  | シングル |

**Husky + lint-staged**
`git commit` 時にステージングされたファイルに対して自動で Lint / フォーマットを実行します。問題があればコミットがブロックされます。git hooks は **リポジトリルートの `.husky/`** で一元管理されています。

```
コミット時の自動処理（my-theme）:
  *.ts   → ESLint --fix + Prettier
  *.scss → Prettier
  *.php  → Prettier

コミット時の自動処理（medical-theme）:
  *.ts   → ESLint --fix + Prettier
  *.css  → Prettier
  *.php  → Prettier
```

> `npm install` 実行時に `prepare` スクリプトで Git の hooksPath が自動設定されます。
> 別マシンで clone した場合も `make install` または `make install-medical` を実行すれば有効になります。

---

## VS Code PHP format on save

`medical-theme/` と `my-theme/` の PHP ファイルを保存した際に Prettier が自動実行されます。

### 必要拡張機能

- [esbenp.prettier-vscode](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode) をインストールしてください

### 設定

`.vscode/settings.json` にプロジェクト専用の設定が含まれています。PHP ファイルを保存すると `@prettier/plugin-php` が自動で整形します。

---

## ディレクトリ構成

```
word-press-docker/
├── src/                        ← WordPress ファイル（直接編集可）
│   ├── wp-admin/
│   ├── wp-content/
│   │   ├── themes/             ← オリジナルテーマはここに作成
│   │   │   ├── my-theme/
│   │   │   └── medical-theme/
│   │   ├── mu-plugins/         ← 必須プラグイン（Git・デプロイ管理外）
│   │   │   └── local-smtp.php  ← MailHog SMTP設定（ローカルのみ有効）
│   │   └── plugins/
│   ├── wp-includes/
│   └── wp-config.php
├── docker/
│   └── php/
│       └── custom.ini          ← PHP 設定
├── Dockerfile
├── docker-compose.yaml
└── .env                        ← DB 接続情報（Git 管理外）
```

---

## CI/CD（GitHub Actions による自動デプロイ）

`main` ブランチへの push をトリガーに、GitHub Actions が自動でビルド＆ロリポップへデプロイします。

### デプロイの流れ

**my-theme**（`src/wp-content/themes/my-theme/**` に変更があった場合）

```
main ブランチへ push
  └→ deploy.yml 起動
       ├─ npm ci
       ├─ npm run build
       └─ FTPS で my-theme/ をロリポップへ転送
```

**medical-theme**（`src/wp-content/themes/medical-theme/**` に変更があった場合）

```
main ブランチへ push
  └→ deploy-medical-theme.yml 起動
       ├─ npm ci
       ├─ npm run build（Vite + Tailwind CSS v4）
       └─ FTPS で medical-theme/ をロリポップへ転送
```

> `mu-plugins/` はどちらのワークフローでもデプロイ除外されます。

### 初回セットアップ

#### 1. ロリポップ側で FTP 情報を確認する

ロリポップの管理画面 → 「サーバーの管理・設定」→「FTP 情報」からホスト名・ユーザー名・パスワードを確認してください。

#### 2. GitHub Secrets を設定する

リポジトリの「Settings」→「Secrets and variables」→「Actions」に以下を登録します。

| Secret 名                | 値の例                                                | 説明                                                |
| ------------------------ | ----------------------------------------------------- | --------------------------------------------------- |
| `FTP_SERVER`             | `ftp.lolipop.jp`                                      | FTP サーバーのホスト名                              |
| `FTP_USERNAME`           | `your-username`                                       | FTP ユーザー名                                      |
| `FTP_PASSWORD`           | `your-password`                                       | FTP パスワード                                      |
| `FTP_REMOTE_DIR`         | `/your-account/html/wp-content/themes/my-theme/`      | my-theme のアップロード先（末尾に `/` が必要）      |
| `FTP_REMOTE_DIR_MEDICAL` | `/your-account/html/wp-content/themes/medical-theme/` | medical-theme のアップロード先（末尾に `/` が必要） |

> `FTP_REMOTE_DIR` はロリポップ管理画面の「ホームディレクトリ」を基準に設定してください。
> 例: `/your-account/html/wp-content/themes/my-theme/`

#### 3. 動作確認

`main` ブランチへ push すると、GitHub の「Actions」タブでワークフローの実行状況を確認できます。

---

## オリジナルテーマの本番反映手順（手動アップロード）

> CI/CD を設定済みの場合、この手順は不要です。`main` ブランチへの push で自動デプロイされます。

### 前提

- レンタルサーバーに WordPress の本番環境がすでに存在している
- FileZilla でレンタルサーバーに接続できる状態である

### 手順

**① ビルドを実行する**

```bash
make build
```

SCSS のコンパイルと画像のコピーが行われ、`assets/` が最新の状態になります。

**② アップロード対象のファイルを確認する**

`src/wp-content/themes/my-theme/` の中で以下のみをアップロードします。

```
my-theme/
├── assets/          ← ビルド済みCSS・画像
├── inc/             ← PHP設定ファイル
├── template-parts/  ← テンプレートパーツ
├── *.php            ← テーマのPHPファイル
└── style.css        ← テーマ認識用（必須）
```

> 以下はアップロード**不要**です。
>
> - `src/`（SCSSなどのソースファイル）
> - `node_modules/`（npmパッケージ）
> - `package.json`, `vite.config.js` 等のビルド設定

**③ FileZilla でテーマフォルダをアップロード**

アップロード先（レンタルサーバー）:

```
public_html/wp-content/themes/my-theme/
```

※ `public_html` はレンタルサーバーによって `www/` や `htdocs/` の場合もあります。

**④ 本番の WordPress 管理画面でテーマを有効化**

1. `本番ドメイン/wp-admin` にログイン
2. 「外観」→「テーマ」を開く
3. アップロードしたテーマを「有効化」する

以上で本番に反映されます。

---

## Docker コンテナ操作

### コンテナの状態確認

```bash
# 起動中のコンテナ一覧を表示
docker ps
```

実行中であれば `wordpress_app`（WordPress）と `wordpress_db`（MySQL）が表示されます。

### コンテナの中に入る

```bash
# WordPress コンテナ（PHP/Apache）に入る
docker exec -it wordpress_app bash

# MySQL コンテナに入る
docker exec -it wordpress_db bash
```

コンテナ内から抜けるときは `exit` と入力します。

### コンテナ内でコマンドを1回だけ実行する

コンテナに入らず、外から直接コマンドを実行する方法です。

```bash
docker exec wordpress_app bash -c "実行したいコマンド"
```

---

## WP-CLI（WordPress コマンドラインツール）

WP-CLI を使うと、管理画面を開かずにターミナルからWordPressを操作できます。

> WP-CLI は `Dockerfile` に記述済みのため、コンテナ再作成後も使えます。

### 基本の使い方

```bash
docker exec wordpress_app bash -c "cd /var/www/html && wp <コマンド> --allow-root"
```

以下、すべてのコマンドは `docker exec wordpress_app bash -c "cd /var/www/html && ... --allow-root"` の形式で実行します。

### よく使うコマンド一覧

#### 固定ページ

```bash
# 固定ページの一覧を表示（ID・タイトル・URLが確認できる）
wp post list --post_type=page --fields=ID,post_title,post_status

# 固定ページをゴミ箱に移動
wp post delete <ID>

# 固定ページを完全削除（ゴミ箱を経由せず）
wp post delete <ID> --force
```

#### メニュー

```bash
# メニューの一覧を表示
wp menu list

# メニューに登録されている項目を表示（<メニュー名> は menu list で確認）
wp menu item list <メニュー名>

# メニュー項目を削除（<db-id> は item list の db_id 列の値）
wp menu item delete <db-id>
```

#### パーマリンク

```bash
# パーマリンクのキャッシュをリセット（設定変更後に実行）
wp rewrite flush
```

#### オプション設定

```bash
# フロントページの表示設定を確認（posts = 最新の投稿 / page = 固定ページ）
wp option get show_on_front

# フロントページに設定されている固定ページのIDを確認
wp option get page_on_front
```

### 使用例：メニュー項目「ホーム」を削除する

```bash
# 1. メニュー一覧を確認
docker exec wordpress_app bash -c "cd /var/www/html && wp menu list --allow-root"

# 2. メニュー項目の一覧を確認（例: メニュー名が medical-menu の場合）
docker exec wordpress_app bash -c "cd /var/www/html && wp menu item list medical-menu --allow-root"

# 3. 削除したい項目の db_id を確認して削除
docker exec wordpress_app bash -c "cd /var/www/html && wp menu item delete 118 --allow-root"
```

---

## Git 管理方針

**自作テーマのみを Git 管理し、WordPress 本体は管理しない。**

### 管理する対象

```
src/wp-content/themes/my-theme/   ← 自分で書いたコードのみ
```

### WordPress 本体を Git 管理しない理由

**① ファイル数が膨大**
WP 本体は数千ファイルあります。自分で編集しないファイルを Git で管理しても意味がありません。

**② アップデートで上書きされる**
WP 本体はバージョンアップで中身が変わります。Git 管理していると差分が大量に出て混乱します。

**③ 本番環境への反映方法が変わる**
自分が書いたコード（テーマ）だけを Git 管理して、WP 本体は本番サーバーに直接インストールするのが一般的な運用です。

### .gitignore の構成

| 対象                                          | 方針                                                 |
| --------------------------------------------- | ---------------------------------------------------- |
| `.env`                                        | Git 管理外（認証情報のため）                         |
| `src/wp-admin/`, `src/wp-includes/`           | Git 管理外（WP 本体）                                |
| `src/wp-*.php`, `src/index.php` 等            | Git 管理外（WP 本体）                                |
| `src/wp-content/uploads/`                     | Git 管理外（メディアファイル）                       |
| `src/wp-content/plugins/`                     | Git 管理外（公式プラグインは本番で直接インストール） |
| `src/wp-content/cache/`                       | Git 管理外（自動生成ファイル）                       |
| `src/wp-content/mu-plugins/`                  | Git 管理外（ローカル専用設定のため）                 |
| `src/wp-content/themes/*/node_modules/`       | Git 管理外（npm パッケージ）                         |
| `src/wp-content/themes/*/vendor/`             | Git 管理外（Composer パッケージ）                    |
| `src/wp-content/themes/*/assets/`             | Git 管理外（ビルド成果物）                           |
| `src/wp-content/themes/*/.php-cs-fixer.cache` | Git 管理外（php-cs-fixer キャッシュ）                |
| `src/wp-content/themes/my-theme/`             | **Git 管理対象**（自作テーマ）                       |
| `src/wp-content/themes/medical-theme/`        | **Git 管理対象**（自作テーマ）                       |

---

## 管理するファイル

Git で管理するファイルのみを以下に示します。

```
WORD-PRESS-DOCKER/
├── docker/
├── Docks/
├── docker-compose.yaml
├── Dockerfile
├── .env.example      ← .envのサンプル（パスワードなし）
└── src/
    └── wp-content/
        └── themes/
            └── my-theme/  ← ここだけ管理
```

> `.env` は Git 管理外です。初回セットアップ時は `.env.example` をコピーして `.env` を作成してください。
>
> ```bash
> cp .env.example .env
> ```

---

## CSS 設計方針（FLOCSS + BEM）

**FLOCSS のプレフィックスでファイルと役割を分類し、BEM で Block\_\_Element--Modifier を命名する。**

### プレフィックスと対応ディレクトリ

| プレフィックス | 役割                            | SCSSファイル          |
| -------------- | ------------------------------- | --------------------- |
| `l-`           | Layout：ページ全体のレイアウト  | `src/scss/layout/`    |
| `c-`           | Component：汎用的な UI パーツ   | `src/scss/component/` |
| `p-`           | Project：ページ固有のスタイル   | `src/scss/project/`   |
| `u-`           | Utility：単機能のユーティリティ | `src/scss/utility/`   |

### 各プレフィックスの役割

**`l-`（Layout）：サイト全体の骨格を作るもの**

```scss
.l-header {
} // ヘッダー全体
.l-footer {
} // フッター全体
.l-container {
} // 幅制限のコンテナ
.l-main {
} // メインコンテンツ
```

**`c-`（Component）：再利用できる部品**

```scss
.c-button {
} // どのページでも使えるボタン
.c-card {
} // どのページでも使えるカード
.c-title {
} // どのページでも使える見出し
```

**`p-`（Project）：特定のページだけで使うもの**

```scss
.p-home {
} // トップページだけ
.p-home__hero {
} // トップページのヒーロー
.p-doctor {
} // 医師紹介ページだけ
```

**`u-`（Utility）：単一の目的を持つ補助クラス**

```scss
.u-hidden {
} // 非表示
.u-text-center {
} // テキスト中央揃え
.u-mt-10 {
} // margin-top: 10px
```

### 命名例

```scss
// l-（Layout）+ BEM
.l-header {
}
.l-header__inner {
}
.l-header__logo {
}

// c-（Component）+ BEM
.c-button {
}
.c-button--primary {
}
.c-button--small {
}

// p-（Project）+ BEM
.p-home {
}
.p-home__hero {
}
.p-home__hero--large {
}
```

### BEM の命名規則

| 記法              | 意味                                  | 例                   |
| ----------------- | ------------------------------------- | -------------------- |
| `Block`           | 独立したコンポーネント                | `.c-button`          |
| `Block__Element`  | Block を構成する要素（`__` 区切り）   | `.c-button__icon`    |
| `Block--Modifier` | Block のバリエーション（`--` 区切り） | `.c-button--primary` |
