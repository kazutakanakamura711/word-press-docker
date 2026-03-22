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

| 画面     | URL                            |
| -------- | ------------------------------ |
| サイト   | http://localhost:8080          |
| 管理画面 | http://localhost:8080/wp-admin |

---

## セットアップ・開発コマンド（Makefile）

プロジェクトルートで `make` コマンドを使って操作します。

| コマンド       | 内容                                    |
| -------------- | --------------------------------------- |
| `make up`      | Docker を起動する                       |
| `make down`    | Docker を停止する                       |
| `make install` | npm install を実行する（初回のみ）      |
| `make watch`   | SCSS の変更を監視してビルドする         |
| `make dev`     | Docker 起動 + SCSS 監視を同時に開始する |

### 初回セットアップ

```bash
make up       # Docker起動
make install  # npm install
make watch    # SCSS監視開始
```

### 2回目以降の開発

```bash
make dev  # Docker起動 + SCSS監視を一括実行
```

> SCSS を編集すると自動で `assets/css/style.css` がビルドされ、`http://localhost:8080` に反映されます。

---

## ディレクトリ構成

```
word-press-docker/
├── src/                        ← WordPress ファイル（直接編集可）
│   ├── wp-admin/
│   ├── wp-content/
│   │   ├── themes/             ← オリジナルテーマはここに作成
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

## オリジナルテーマの本番反映手順（テーマのみアップロード）

### 前提

- レンタルサーバーに WordPress の本番環境がすでに存在している
- FileZilla でレンタルサーバーに接続できる状態である

### 手順

**① ローカルでテーマを作成・編集**

`src/wp-content/themes/` 以下にオリジナルテーマのフォルダを作成して開発します。

**② FileZilla でテーマフォルダをアップロード**

ローカルのテーマフォルダ:

```
src/wp-content/themes/オリジナルテーマ名/
```

アップロード先（レンタルサーバー）:

```
public_html/wp-content/themes/オリジナルテーマ名/
```

※ `public_html` はレンタルサーバーによって `www/` や `htdocs/` の場合もあります。

**③ 本番の WordPress 管理画面でテーマを有効化**

1. `本番ドメイン/wp-admin` にログイン
2. 「外観」→「テーマ」を開く
3. アップロードしたテーマを「有効化」する

以上で本番に反映されます。

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

| 対象                                | 方針                                                 |
| ----------------------------------- | ---------------------------------------------------- |
| `.env`                              | Git 管理外（認証情報のため）                         |
| `src/wp-admin/`, `src/wp-includes/` | Git 管理外（WP 本体）                                |
| `src/wp-*.php`, `src/index.php` 等  | Git 管理外（WP 本体）                                |
| `src/wp-content/uploads/`           | Git 管理外（メディアファイル）                       |
| `src/wp-content/plugins/`           | Git 管理外（公式プラグインは本番で直接インストール） |
| `src/wp-content/cache/`             | Git 管理外（自動生成ファイル）                       |
| `src/wp-content/themes/my-theme/`   | **Git 管理対象**（自作テーマ）                       |

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
