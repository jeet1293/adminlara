# About Project
web application with Admin Panel and APIs

## Admin Panel

##### Dasboard
- Categories Counts
- Products Counts

##### Users
- Users List
- User Detail

##### Categories
- Categories List
- Add Category
- Edit Category
- Delete Category

##### Products
- Products List
- Add Product
- Edit Product
- Delete Product

## Project Setup Steps
#### DB Setup
- create **adminlara** database.
- change username and password in .env (if requried)

#### Please run following commands

```sh
$ composer install
$ npm install && npm run dev
$ php artisan migrate:fresh --seed
$ php artisan passport:install --force
$ php artisan serve
```

##### You can login with following credentials
- email    : admin@test.com
- password : Admin@2020
	
##### Postman
- collection : https://www.getpostman.com/collections/885829b4f738e7bf6057
- baseurl    : http://localhost:8000/api

## License
----
MIT