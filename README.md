<h1>AJRLI BACKEND</h1>

```bash
cp .env.example .env

composer install

php artisan key:generate

php artisan migrate:fresh

php artisan db:seed --class=EquipmentCategoriesSeeder

php artisan db:seed --class=EquipmentSubCategoriesSeeder

php artisan db:seed --class=VehicleCategoriesSeeder

php artisan db:seed --class=VehicleSubCategoriesSeeder

php artisan db:seed --class=UsersSeeder

php artisan db:seed --class=VehiclesSeeder

php artisan db:seed --class=EquipmentsSeeder

php artisan db:seed --class=AttachmentsSeeder

php artisan storage:link

php artisan serve
```
