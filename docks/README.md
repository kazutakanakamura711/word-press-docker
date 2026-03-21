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
