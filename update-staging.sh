#\bin\bash

php artisan down

git reset --hard
git pull origin master

composer install --prefer-dist --no-interaction
npm install

php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan clear
php artisan release:update
php artisan webpush:vapid
php artisan system updateReward

php artisan up

