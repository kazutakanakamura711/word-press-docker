#!/bin/bash
# php-cs-fixer Docker ラッパー（VS Code format on save / npm run format 兼用）
#
# 使い方:
#   引数なし           → medical-theme 全体を整形（npm run format 用）
#   fix <file> [opts]  → 指定ファイルを整形（VS Code junstyle.php-cs-fixer 拡張が呼び出す）
#   <file> [file...]   → 指定ファイルを整形（lint-staged が呼び出す）
#
# ホスト上のファイルパスをコンテナ内パスに自動変換します。
# 事前に docker compose up -d でコンテナが起動していることが必要です。

set -e

SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
# .vscode/ の一つ上がプロジェクトルート、その下の src/ がコンテナの /var/www/html にマウントされている
HOST_SRC="${SCRIPT_DIR}/../src"
HOST_SRC="$(cd "$HOST_SRC" && pwd)"
CONTAINER_SRC="/var/www/html"

CONTAINER_THEME="${CONTAINER_SRC}/wp-content/themes/medical-theme"
FIXER="${CONTAINER_THEME}/vendor/bin/php-cs-fixer"
CONFIG="${CONTAINER_THEME}/.php-cs-fixer.dist.php"

# ホストパスをコンテナパスに変換する関数
translate() {
    local path="$1"
    echo "${path/#$HOST_SRC/$CONTAINER_SRC}"
}

# 引数をパース: subcommand と ファイルパス を分離
SUBCOMMAND="fix"
FILES=()
SKIP_NEXT=false

for ARG in "$@"; do
    if [ "$SKIP_NEXT" = true ]; then
        SKIP_NEXT=false
        continue
    fi

    case "$ARG" in
        fix | check | list-files | describe)
            SUBCOMMAND="$ARG"
            ;;
        --config)
            # VS Code 拡張が渡す --config <path> は無視（コンテナ内の設定を使う）
            SKIP_NEXT=true
            ;;
        --config=*)
            # --config=<path> 形式も無視
            ;;
        /*)
            # 絶対パスはすべてコンテナパスに変換
            FILES+=("$(translate "$ARG")")
            ;;
        *)
            # サブコマンド以外のフラグはそのまま渡す
            FILES+=("$ARG")
            ;;
    esac
done

# ファイル指定がない場合はテーマ全体を対象にする
if [ "${#FILES[@]}" -eq 0 ]; then
    FILES=("${CONTAINER_THEME}")
fi

exec docker exec wordpress_app php "${FIXER}" "${SUBCOMMAND}" "${FILES[@]}" \
    --config="${CONFIG}"
