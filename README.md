# SIDE PROJECT

> 練習 TDD 的項目，從發想到實踐。 有機會的話會透過該項目學習乾淨架構。

## tests/TestCase.php
增加 `DatabaseMigrations`, `DatabaseTruncation`, `WithFaker` trait

## phpunit 單元測試

```shell
XDEBUG_MODE=coverage php -dxdebug.mode=coverage artisan test --env=test --coverage-text --coverage-html reports
```

## phpstan 靜態分析 -> `composer require phpstan/phpstan --dev`

### 新增 `phpstan.neon`

```yaml
parameters:
    # level 越高檢查越嚴謹
    level: 1
    paths:
        - app
        - tests
```

```shell
./vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=1G
```

## JWT Token
- vendor publish
```shell
php artisan vendor:publish # 選擇 JWT
php artisan jwt:secret
```
- 設定 config/auth.php
- 設定 app/Http/Kernel.php 增加 jwt 中間件

