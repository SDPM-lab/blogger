# Blogger
The simple CodeIgniter4 project of TCSE 2023 workshop.

## How to Run

### Prerequisites
1. docker

### 1. Start the development environment.
Command: `docker-compose up`

### 2. Install the dependency package with composer.
Command: `docker-compose exec ci4_service composer install`

### 3. Copy the `env` file to `.env` file and modify it.
From `env` file
```
# database.default.hostname = localhost
# database.default.database = ci4
# database.default.username = root
# database.default.password = root
# database.default.DBDriver = MySQLi
# database.default.DBPrefix =
# database.default.port = 3306
```

To `.env` file
```
database.default.hostname = ci4_DB
database.default.database = example
database.default.username = root
database.default.password = root
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306
```

### 4. Database Migration.
Command: `docker-compose exec ci4_service php spark migrate`

### 5. Database seed the default data.
Command: `docker-compose exec ci4_service php spark db:seed Members`

Command: `docker-compose exec ci4_service php spark db:seed TodoLists`

### 6. Enjoy
Enter the `http://localhost:8080/`
