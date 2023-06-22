## Instructions for backend


- Run git clone https://github.com/marianDdev/codeoftalent-php-auth.git
- Run composer install
- Run cp .env.example .env
- Replace the values from env DATABASE_URL variable with your own database credentials
- seed your database by importing the users.sql file provided in database directory
- start the builtin server by running php -S localhost:8888 (or any other port)
- test the login with dummy credentials email: marian@gmail.com and password: aaaaaaaa


## Instructions for frontend
- Run git clone https://github.com/marianDdev/code-of-talent-auth-frontend.git
- npm install 
- npm run build
- npm run dev
- visit "/login" page for login form