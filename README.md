
## How to deploy
This task manager allows user to create projects, tasks and assign task to the projects.
  
- Create a new Laravel application or download repository from the link below. 
- [Github repository](https://github.com/estebangallego/task-manager).

### Installation
- composer create-project --prefer-dist laravel/laravel TaskManager
- npm install
- composer install
- php artisan key:generate
#### IMPORTANT -> Make sure the app is connected to a MySql database using the .env file
- php artisan migrate
- php artisan optimize 
- npm run dev
- DONE - App should be live now
