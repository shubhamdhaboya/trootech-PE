# SET UP PROJECT

- git clone https://github.com/shubhamdhaboya/trootech-PE.git
- cd trootech-PE
- composer install
- create blank database and config .env file
- php artisan migrate
- php artisan serve (open http://localhost:8000)

## Product ENDPOINTS

#### GET PRODUCT LIST
- GET - "/api/products"
	- param 
		- page | int (default 1)

#### GET SINGLE PRODUCT
- GET - "/api/products/{id}"
	- param 
		- page | int (default 1)

#### CREATE PRODUCT
- POST - "/api/products"
	- request body
		-  name | string, required
		- price | numeric, required
		- categories | array, optional

#### UPDATE PRODUCT
- PUT/PATCH - "/api/products/{id}"
	- param
		1) id | required
	- request body
		- name | string, required
		- price | numeric, required
		- add_categories | array, optional ([category_id_1, category_id_2 .... category_id_n])
		- remove_categories | array, optional ([category_id_1, category_id_2 .... category_id_n])

#### DELETE PRODUCT
- DELETE - "/api/products/{id}"
	- param
		- id | required

## CATEGORY ENDPOINTS

#### GET CATEGORY LIST
- GET - "/api/category"
	- param 
		- page | int (default 1)

#### GET SINGLE CATEGORY
- GET - "/api/category/{id}"
	- param 
		- page | int (default 1)

#### CREATE CATEGORY
- POST - "/api/category"
	- request body
		- name | string, required
		- parent_id | numeric, optional

#### UPDATE CATEGORY
- PUT/PATCH - "/api/category/{id}"
	- param
		- id | required
	- request body
		- name | string, required
		- parent_id | numeric, optional

#### DELETE CATEGORY
- DELETE - "/api/category/{id}"
	- param
		- id | required
