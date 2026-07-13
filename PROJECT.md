# e-nail サイト保守プロジェクト

妻のネイルサロン「e-nail」の WordPress サイト（e-nail-fukuoka.com）を、この Mac 上で AI 支援のもと保守・改修するための作業リポジトリ。

## 目的

- FTP 直編集をやめ、Git ベースのワークフローへ移行する（変更履歴・巻き戻し・レビュー可能に）。
- コード修正・Git 操作・デプロイを Claude Code に任せられる状態にする。
- 本番サイトを壊さないこと最優先（編集前バックアップ・ローカル検証を徹底）。

## サイト概要

- URL: e-nail-fukuoka.com（WordPress / エックスサーバー運用）
- 屋号: e-nail（ネイルサロン）。福岡・薬院 → 鹿児島県姶良市へ移転、姶良向けに継続運用。
- ドメインは変更せず維持（SEO 資産の保護）。
- リポジトリ: github.com/shohezo/e-nail（オリジナルテーマ）

## 環境構築の状態（2026-07-13）

| 項目 | 状態 |
|---|---|
| OS | macOS 26.5 (Apple Silicon / arm64) |
| Git | ✓ 2.50.1 |
| Node.js / npm | ✓ v24.13.1 / 11.8.0 |
| Claude Code | ✓ 2.1.207 |
| VSCode | ✓ インストール済（`code` CLI を PATH に追加済） |
| GitHub 認証 | ✓ gh CLI / osxkeychain（ユーザー: shohezo） |
| リポジトリ取得 | ✓ ~/e-nail にクローン済 |

## 本番との同期（2026-07-13 完了）

- リポジトリの最終コミットは 2022-07-02 だったが、本番は 2024-01 に FTP で編集されており乖離していた。
- 本番テーマ一式を FTPS で取得し、**リポジトリを本番の現行状態に同期してコミット・プッシュ済み**（commit `74aa5b1`）。これ以降が Git 管理のベースライン。
- 取り込んだ 2024-01 の本番変更:
  - 予約導線を公式 LINE(LIFF) に変更、予約フォームリンクはコメントアウト温存
  - メニュー料金改定（ワンカラー 4,300 / シンプル 4,500 ほか値上げ）
  - Instagram フィード feed=1 → feed=3
  - LINE ボタン用スタイル追加、img/line.png 追加

## 接続情報

- FTPS ホスト: `sv8633.xserver.jp` / ユーザー: `shohezo`（メイン=初期FTP、サーバーパスワードと同値）
- パスワードは **macOS ログインキーチェーン**に保存（service: `xserver-ftp-e-nail` / account: `shohezo`）。取得: `security find-generic-password -w -s xserver-ftp-e-nail -a shohezo`
- 本番テーマパス: `/e-nail-fukuoka.com/public_html/wp-content/themes/e-nail/`
- lftp 接続時は**証明書検証を有効のまま**（`*.xserver.jp` で有効。`ssl:verify-certificate no` は使わない）

## デプロイ運用（2026-07-13 構築）

方式: **ローカル同期スクリプト `deploy.sh`**（GitHub Actions 自動デプロイは、公開リポジトリに認証情報を置く必要がある点と本番事故リスクから不採用）。

- 判断基準は **Git 差分**（前回デプロイ commit → 現在）。サイズ/時刻比較に依存しないため、同じ文字数の修正も取りこぼさない。
- `./deploy.sh preview` … 反映される変更ファイルを表示（無変更）
- `./deploy.sh backup` … 本番テーマを `_backups/` に退避のみ
- `./deploy.sh push` … 未コミットがあれば中止 → 自動バックアップ → 変更ファイルのみ本番へ反映
- 前回デプロイ地点は `_backups/.last-deployed`（gitignore）に記録。
- **push は本番反映。実行前に必ず preview で確認し、都度承認を得てから行う。**

改修フロー: `~/e-nail` で編集 → commit → push（GitHub）→ `./deploy.sh preview` → 問題なければ `./deploy.sh push`。

## 未完了・次のアクション

1. テーマ改修時は**子テーマ**の利用を検討（本体テーマ更新での上書き回避）
2. ローカル検証環境（Local by Flywheel / wp-env / Docker 等）の要否を判断
3. 本番の `.git/`（2022 年の残骸）と `.DS_Store` の掃除を検討

## 秘匿情報の扱い

FTP パスワード・API トークン等は本ファイルや Git に直書きしない。キーチェーン保管、参照方法のみ記載する。
