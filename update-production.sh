#\bin\bash

php artisan down

git reset --hard
git pull origin production
git checkout $(git describe --tags `git rev-list --tags --max-count=1`)

composer install --prefer-dist --no-interaction
npm install
npm run build

php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan clear
php artisan release:update
php artisan webpush:vapid
php artisan system updateReward

php artisan up

