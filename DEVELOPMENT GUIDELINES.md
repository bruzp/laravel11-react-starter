
# Development Guidelines

## Common Practices

1. **Function Duplication**:
   - Before creating a function, verify it doesn't already exist. If it does, collaborate with the original author to enhance its versatility.

2. **Data Types**:
   - Utilize native data types when creating functions for greater flexibility. Example: `function getUser(int $user_id)`.

3. **Code Formatting**:
   - Always format code post-typing.

4. **Import Sorting**:
   - Organize imports neatly.

5. **SOLID Principles**:
   - Adhere to SOLID principles with emphasis on:
     - **S**: Single Responsibility Principle
     - **I**: Interface Segregation Principle

## Backend Development

1. **Controller Naming**:
   - Resource controllers should be plural (e.g., `UsersController`).
   - Generic controllers should be singular (e.g., `PaymentController`).
   - Apply this rule to view folders as well.

2. **Variable Naming**:
   - Service names: `userService`
   - Regular variables: `$regular_var`

3. **Naming Conventions**:
   - Helpers, Services, and related naming should be based on singular Models. For practical examples, review the naming in this repository's directories and files.

4. **Resource Function Naming**:
   - Align custom method names with resource function names for clarity, e.g., login -> `create()`, authenticate -> `store()`. Use comments for clarity, avoiding docblocks.

5. **Function Signatures**:
   - Specify data types and return types in functions.

6. **Routing**:
   - Employ consistent routing patterns for IDE recognition, e.g., `Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');`

7. **Proper Use Cases**:
   - Properly utilize helpers, services, traits, repositories, and interfaces according to their intended use.

## Specific Backend Structures

- **Services**: Encapsulate core business logic separate from UI and database interactions.
- **Traits**: Provide reusable methods for multiple classes without inheriting functionality.
- **Helpers**: Offer utility functions for tasks like date formatting, remaining lightweight.
- **Repositories**: Abstract data access, controlled via interfaces for maintainability.
- **Interfaces**: Define contracts for functionalities, ensuring consistency and structure.

## Laravel Specific Guidelines

- **Eager Loading**: Manage through repositories, using a relations parameter.
- **Route Model Binding**: Custom logic via `resolveRouteBinding` using the repository pattern.
- **Form Requests**: Use for validation and pre-processing of data for insert or update operations.
- **API Resources**: Utilize for data transformation post-query to standardize API responses.
- **Laravel Jobs and Queues**: Manage multiple emails and heavy jobs via Laravel jobs and queues.
- **Events and Listeners**: Implement for tasks post-business logic execution to maintain clean code.
- **Policies and Gates**: Use consistently for function access checks.

## Frontend Practices

1. **Standard Components**:
   - Develop standard components within a designated folder.
2. **Indentation**:
   - Maintain 2 spaces for indentation.
3. **Component-Based Development**:
   - Emphasize readability and brevity through component-based development.
4. **Frontend Folder Structure**

- **Users**
  - create.blade.php
  - edit.blade.php
  - index.blade.php

5. **Frontend Folder Structure**

- **Users**
  - **Create**
    - index.blade.php
    - confirm.blade.php
    - complete.blade.php

## Testing

1. **Function Testing**:
   - Ensure main processes are thoroughly tested.
2. **Scenario Testing**:
   - Include tests for complex scenarios.
3. **Database Factories**:
   - Utilize database factories and states for testing.

## Naming Conventions

- **Blade Files**: Use underscores (e.g., `user_profile.blade.php`).
- **React Files**: Use PascalCase (e.g., `UserProfile.jsx`).
