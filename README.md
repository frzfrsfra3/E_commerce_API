E-Commerce API
This project is a Laravel-based RESTful API for managing a simple e-commerce system. The API provides endpoints for user registration and authentication, CRUD operations for products, and order management. This README.md provides an overview of the API, database setup, code review, and documentation.
Table of Contents
1.	Project Overview
2.	Installation and Setup
3.	Database Setup
4.	API Endpoints
5.	Code Review Report
6.	API Documentation
Project Overview
The e-commerce API includes the following features:
•	User Registration and Authentication: Secure user registration and JWT-based authentication.
•	Product Management: CRUD operations for products.
•	Order Management: Ability to place orders with one or multiple products.
Installation and Setup
Follow these steps to set up and run the project locally:
1.	Clone the Repository:
bash
Copy code
git clone https://github.com/your-username/e-commerce-api.git
cd e-commerce-api
2.	Install Dependencies:
bash
Copy code
composer install
3.	Set Up Environment File:
Copy the example environment file and update the configuration:
bash
Copy code
cp .env.example .env
Generate the application key:
bash
Copy code
php artisan key:generate
4.	Set Up JWT Secret:
Generate the JWT secret key:
bash
Copy code
php artisan jwt:secret
5.	Run Migrations and Seed the Database:
bash
Copy code
php artisan migrate
php artisan db:seed
6.	Start the Laravel Development Server:
bash
Copy code
php artisan serve
The API will be accessible at http://localhost:8000/api.
Database Setup
To create the database tables, use the provided SQL commands:
sql
Copy code
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(8, 2) NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE order_product (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id BIGINT UNSIGNED,
    product_id BIGINT UNSIGNED,
    quantity INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
API Endpoints
User Registration and Authentication
•	Register User
o	POST /api/register
o	Request Body: { "name": "John Doe", "email": "john@example.com", "password": "password" }
o	Response: 200 OK with user details.
•	Login
o	POST /api/login
o	Request Body: { "email": "john@example.com", "password": "password" }
o	Response: 200 OK with JWT token.
•	Get User Details
o	GET /api/user
o	Headers: Authorization: Bearer {token}
o	Response: 200 OK with user details.
•	Logout
o	POST /api/logout
o	Headers: Authorization: Bearer {token}
o	Response: 200 OK with success message.
Product Management
•	List Products
o	GET /api/products
o	Response: 200 OK with list of products.
•	Create Product
o	POST /api/products
o	Request Body: { "name": "Product Name", "description": "Product Description", "price": 100.00, "quantity": 10 }
o	Response: 201 Created with product details.
•	Get Product Details
o	GET /api/products/{id}
o	Response: 200 OK with product details.
•	Update Product
o	PUT /api/products/{id}
o	Request Body: { "name": "Updated Name", "description": "Updated Description", "price": 150.00, "quantity": 20 }
o	Response: 200 OK with updated product details.
•	Delete Product
o	DELETE /api/products/{id}
o	Response: 204 No Content.
Order Management
•	Place Order
o	POST /api/orders
o	Request Body: { "products": [{ "id": 1, "quantity": 2 }, { "id": 2, "quantity": 1 }] }
o	Headers: Authorization: Bearer {token}
o	Response: 201 Created with order details.
Code Review Report
The code review identified several issues with explanations and recommendations:
1.	Hardcoded Secrets:
o	Issue: Hardcoded JWT secret keys.
o	Recommendation: Use environment variables to manage secrets securely.
2.	Missing Validation Rules:
o	Issue: Insufficient validation for product creation and update.
o	Recommendation: Implement comprehensive validation rules in the controller.
3.	Inefficient Database Queries:
o	Issue: N+1 query problem.
o	Recommendation: Use eager loading to optimize database queries.
4.	Inconsistent Error Handling:
o	Issue: Inconsistent error handling for authentication failures.
o	Recommendation: Standardize error responses.
5.	Lack of Unit Tests:
o	Issue: Missing unit tests for key functionalities.
o	Recommendation: Add unit tests to cover authentication and order management.
API Documentation
The API documentation is available in OpenAPI format. It describes all available endpoints, request/response formats, and authentication details. You can find it in the docs folder under openapi.yaml.

