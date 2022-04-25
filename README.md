# Rental-admin-service

# Postman collection
https://go.postman.co/workspace/My-Workspace~b36c6ee1-c692-409d-886d-ac2cbaf2690c/collection/10661735-73b26ca0-3b85-4ec6-a4b9-8af88c3895ba?action=share&creator=10661735

# ERD
https://dbdiagram.io/d/625ec5e31072ae0b6aac8e28

# Start Application Normally

- Start the application with the comman: php -S localhost:8000 -t public

- Run migration and seed with php artisan migrate:fresh --seed

# Start Application Using Docker
- Run docker-compose up

- In terminal, exec into the pod with sh and run migration and seed 

** Docker exec -it [containerID] sh **
