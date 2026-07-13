#!/usr/bin/env bash
#
# e-nail テーマ デプロイスクリプト（ローカル Git → エックスサーバー本番）
#
# 「何を反映するか」は Git で判定する（前回デプロイ時点からの変更ファイルのみ）。
# サイズ/時刻ではなく Git の内容差分が基準なので、同じ文字数の修正も取りこぼさない。
#
# 使い方:
#   ./deploy.sh preview   … 前回デプロイからの変更ファイルを表示（何も変更しない・デフォルト）
#   ./deploy.sh backup    … 本番の現行テーマを _backups/ に退避のみ
#   ./deploy.sh push      … バックアップ → 変更ファイルのみ本番へ反映
#
# 前提: push は作業ツリーがクリーン（全部コミット済み）であること。
# パスワードは macOS キーチェーンから読み出す（平文で保持しない）。
#
set -euo pipefail

# ---- 設定 --------------------------------------------------------------
HOST="sv8633.xserver.jp"
USER="shohezo"
KEYCHAIN_SERVICE="xserver-ftp-e-nail"
REMOTE_DIR="/e-nail-fukuoka.com/public_html/wp-content/themes/e-nail"
LOCAL_DIR="$(cd "$(dirname "$0")" && pwd)"
STATE_FILE="$LOCAL_DIR/_backups/.last-deployed"
LFTP_OPTS="set ftp:ssl-force true; set ftp:ssl-protect-data true; set net:timeout 20; set net:max-retries 2"

# 本番に送らない（リポジトリ運用ファイル）。Git 差分から除外する。
EXCLUDE_PATHSPEC=(':(exclude)PROJECT.md' ':(exclude)README.md' ':(exclude).gitignore' ':(exclude)deploy.sh')

MODE="${1:-preview}"
cd "$LOCAL_DIR"

# ---- パスワード取得 ----------------------------------------------------
get_pass() {
  security find-generic-password -w -s "$KEYCHAIN_SERVICE" -a "$USER" 2>/dev/null || true
}

run_lftp() {
  local pass; pass="$(get_pass)"
  [ -z "$pass" ] && { echo "エラー: キーチェーンにパスワードなし ($KEYCHAIN_SERVICE/$USER)" >&2; exit 1; }
  lftp -u "$USER,$pass" -e "$LFTP_OPTS; $1; bye" "ftp://$HOST"
}

# 前回デプロイ時点 → 現在(HEAD) の変更ファイル（運用ファイル除外）
changed_files() {
  local from="$1"
  git diff --name-status "$from" HEAD -- . "${EXCLUDE_PATHSPEC[@]}"
}

backup() {
  mkdir -p "$LOCAL_DIR/_backups"
  local stamp dest
  stamp="$(date +%Y%m%d-%H%M%S)"
  dest="$LOCAL_DIR/_backups/e-nail-$stamp"
  mkdir -p "$dest"
  echo "▶ 本番テーマを退避: _backups/e-nail-$stamp/"
  run_lftp "mirror --parallel=3 --exclude-glob .git/ --exclude-glob .DS_Store '$REMOTE_DIR/' '$dest/'"
  echo "✓ バックアップ完了"
}

require_clean() {
  if [ -n "$(git status --porcelain -- . "${EXCLUDE_PATHSPEC[@]}")" ]; then
    echo "エラー: 未コミットの変更があります。先に commit してから push してください。" >&2
    git status --short -- . "${EXCLUDE_PATHSPEC[@]}" >&2
    exit 1
  fi
}

case "$MODE" in
  preview)
    if [ ! -f "$STATE_FILE" ]; then
      echo "▶ 前回デプロイ記録なし（初回）。本番はリポジトリと同期済みの想定。"
      echo "  現在の HEAD: $(git rev-parse --short HEAD) — $(git log -1 --format=%s)"
      echo "  未コミットの変更:"; git status --short -- . "${EXCLUDE_PATHSPEC[@]}" | sed 's/^/    /' || true
    else
      local_from="$(cat "$STATE_FILE")"
      echo "▶ 前回デプロイ ($(git rev-parse --short "$local_from")) → 現在 の変更ファイル:"
      changed_files "$local_from" | sed 's/^/    /'
      [ -z "$(changed_files "$local_from")" ] && echo "    （コミット済みの変更なし）"
      echo "  未コミットの変更:"; git status --short -- . "${EXCLUDE_PATHSPEC[@]}" | sed 's/^/    /' || true
    fi
    echo "反映するには: ./deploy.sh push"
    ;;

  backup)
    backup
    ;;

  push)
    require_clean
    HEAD_SHA="$(git rev-parse HEAD)"
    # 反映対象の算出（bash 3.2 互換: while read で配列化）
    LINES=()
    if [ -f "$STATE_FILE" ]; then
      FROM="$(cat "$STATE_FILE")"
      while IFS= read -r line; do [ -n "$line" ] && LINES+=("$line"); done < <(changed_files "$FROM")
    else
      # 初回: 追跡中のテーマ全ファイルを対象
      while IFS= read -r line; do [ -n "$line" ] && LINES+=("$line"); done < <(git ls-files -- . "${EXCLUDE_PATHSPEC[@]}" | sed 's/^/A\t/')
    fi

    if [ "${#LINES[@]}" -eq 0 ]; then
      echo "反映すべき変更はありません。"; exit 0
    fi

    echo "▶ 本番へ反映する変更:"; printf '    %s\n' "${LINES[@]}"
    backup

    # lftp コマンド列を組み立て
    CMDS="mkdir -f -p '$REMOTE_DIR'"
    for line in "${LINES[@]}"; do
      status="${line%%$'\t'*}"; rest="${line#*$'\t'}"
      case "$status" in
        D)  CMDS="$CMDS; rm -f '$REMOTE_DIR/$rest'";;
        R*) old="${rest%%$'\t'*}"; new="${rest#*$'\t'}"
            CMDS="$CMDS; rm -f '$REMOTE_DIR/$old'"
            dir="$(dirname "$new")"; tgt="$REMOTE_DIR"
            [ "$dir" != "." ] && { CMDS="$CMDS; mkdir -f -p '$REMOTE_DIR/$dir'"; tgt="$REMOTE_DIR/$dir"; }
            CMDS="$CMDS; put -O '$tgt' '$LOCAL_DIR/$new'";;
        *)  f="$rest"; dir="$(dirname "$f")"; tgt="$REMOTE_DIR"
            [ "$dir" != "." ] && { CMDS="$CMDS; mkdir -f -p '$REMOTE_DIR/$dir'"; tgt="$REMOTE_DIR/$dir"; }
            CMDS="$CMDS; put -O '$tgt' '$LOCAL_DIR/$f'";;
      esac
    done

    echo "▶ アップロード中…"
    run_lftp "$CMDS"
    echo "$HEAD_SHA" > "$STATE_FILE"
    echo "✓ デプロイ完了（記録: $(git rev-parse --short "$HEAD_SHA")）"
    ;;

  *)
    echo "使い方: ./deploy.sh [preview|backup|push]" >&2; exit 1;;
esac
