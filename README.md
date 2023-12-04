
# payway_analytics_rest_api


# Instructions:

### 1. Clone the Repository
-> Clone the repository from https://github.com/Crawford30/payway_analytics_rest_api.git into the .htdocs folder.

### 2. Install Server Software:
-> Make sure you have XAMPP or WAMP installed for Windows, MAMP for Mac, or LAMP for Linux.

### 3. Install Composer Dependencies
-> Run composer install in the project directory via the command line to install composer first.

### 4. Move Web Application to Root
-> The "Web Application" folder should be placed in the root directory (inside .htdocs for XAMPP or WAMP).

### 5. Create Database
-> Create a database of your choice (e.g., PayWayDB).

### 6. Copy Environment File:
-> Copy .env.example to .env.

### 7. Update Database Configuration:
-> Open .env and update the database name to the one you created.

### 8. Navigate to Project Directory
-> Open a terminal or command prompt and navigate to the project directory.

### 9. Ensure Server is Running
-> Make sure the server is running (XAMPP, WAMP, or any server environment you are using).

### 10. Generate Application Key
-> Run _php artisan key:generate_ to generate the application key.

### 11. Create Database Tables
-> Run _php artisan migrate_ to create the necessary database tables.

### 12. Seed Database (Very Important Step)
-> Run _php artisan db:seed_ to seed the database with the CSV file.

### 13. Clear Configuration (if necessary)
-> _php artisan config:clear_
-> _php artisan config:cache_

### 14. Start Development Server
-> Run _php artisan serve_ to start the development server.

### 15. Copy Base URL
-> Copy the URL provided by the development server and use it as the base URL in the Android app(In the android project located in Util/Contants)

### 16. Mock the api
-> You can mock the api by running it in POSTMAN and then copy the mocked URL as the base URL as in the Util/Contants file now in the android app.


## Note:
The project uses the latest Laravel and PHP 8.


