
# Laravel11 Inertia React JS - Quiz App (Project Template)

This Quiz Application is built using Laravel with Inertia.js and React. It enables the administration of quizzes and allows users to take exams. The application differentiates between two types of entities: admins and users.

## Version Compatibility

- **Laravel:** 11
- **PHP:** 8.3.6
- **MySQL:** 8.0.30

## Features

### Admin Side

- **Dashboard:** Upon login, the admin is presented with the top 10 highest-scoring users across all exams.
- **Management Tools:** Admins can manage questionnaires, answers, and user accounts.

### User Side

- **Dashboard:** Users are shown their overall standings upon login.
- **Exam Access:** Users have access to their previously answered questionnaires but can take any exam only once.

## Local Setup Instructions

Follow these steps to get the application running on your local machine:

1. Clone the repository:

   ```
   git clone <repository-url>
   ```

2. Install PHP dependencies:

   ```
   composer install
   ```

3. Install NPM packages:

   ```
   npm install
   ```

4. Generate application key:

   ```
   php artisan key:generate
   ```

5. Set up database credentials in your `.env` file.
6. Run migrations and seed the database:

   ```
   php artisan migrate --seed
   ```

7. Start the Laravel server:

   ```
   php artisan serve
   ```

8. Compile React components and watch for changes:

   ```
   npm run dev
   ```

## Access Credentials

- **Admin Access:**
  - Email: <admin@test.com>
  - Password: password

- **User Access:**
  - Email: Check the users table in your database for user credentials.
  - Password: password

## Testing Notes

- **Test all**

  ```
  php artisan test
  ```

- **File Test**

  ```
  php artisan test tests\Feature\Admin\QuestionnaireTest.php
  ```

- **Specific Test**

  ```
  php artisan test tests\Feature\Admin\QuestionnaireTest.php --filter="admin can update questions priority"
  ```

## Project Background

- **Development Timeline:** Completed within two weeks, showcasing the efficiency and capabilities of the Laravel + Inertia + React stack.

## Conclusion

This README file provides all the necessary instructions and information to get started with the Laravel Inertia React JS Quiz App. For more information or if you encounter issues, please refer to the official documentation of Laravel, Inertia, and React, or submit an issue in this repository.
