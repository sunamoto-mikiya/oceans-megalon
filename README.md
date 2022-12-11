# セットアップ
## クローン
```
git clone git@github.com:sunamoto-mikiya/oceans-megalon.git
```
## ディレクトリ移動
```
cd oceans-megalon
```

### ビルド
```
docker compose up -d
```

### envファイルコピー
```
cp .env.example .env
```

### コンテナに入る
```
docker compose exec php bash
```

### Composerインストール
```
composer install
```

### 認証キー作成
```
php artisan key:generate
```

### マイグレーション
```
php artisan migrate
php artisan migrate --env=testing # テスト用DB
```

### シード
```
php artisan db:seed
```

## Viteセットアップ
### npmインストール
```
npm install
```

### ビルド
```
#開発環境用
npm run dev

#本番環境用
npm run build
```

### MinIO
http://localhost:9000 にアクセスして確認できる．
ユーザ名とパスワードは以下．

- ユーザ名：`root`
- パスワード：`password`


