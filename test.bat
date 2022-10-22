echo off
set arg1=%1
shift
shift
php artisan test --filter %arg1%
