**Create Dockerfile**:
Please use the PHP image with Apache.
Install necessary PHP extensions (pdo, pdo_mysql) and Composer.
Set the working directory and copy the application code.
Install dependencies with Composer.
Expose port 80.


**Create docker-compose.yml**:
Define services for php-apache and mysql (or your preferred database).
Configure environment variables for the database.
Set up volume mappings for persistent data.


**Write the API Code**:
Implement endpoints for listing, creating, reading, updating, deleting, searching, and rating recipes following REST practices.
Ensure the API returns valid JSON.

**Follow Best Security Practices**:
Validate and sanitize all inputs.
Use prepared statements to prevent SQL injection.
Secure sensitive data such as database credentials using environment variables.

**Follow SOLID Principles**:
Structure your code into classes and interfaces.
Ensure each class has a single responsibility.
Utilize dependency injection.

**Setup Instructions**:
Build the Docker images with docker-compose build.
Start the containers with docker-compose up -d
Make sure that all Docker containers are running properly docker-compose ps
Run on browser  eg. http://localhost:8080

**Content negotiation**:
If a client sends a request with the header Accept: application/json, the server should respond with JSON data.

**Using any kind of Database Access Abstraction**

*Database Independence*:
PDO supports multiple database systems (MySQL, PostgreSQL, SQLite, etc.).
we can switch databases by changing the DSN (Data Source Name) without modifying the code.

*Prepared Statements*:
Protects against SQL injection attacks.
Separates SQL code from data, allowing for safe data handling.


LIMITATION OF THIS PROJECT:
I DON'T ADD A HOME BUTTON TO GO BACK ,SO WE GO BACK BROWSER BACK BUTTON AND LOOK THEIR WHICH OPERATION I WANT TO DO.
