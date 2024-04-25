
# Sharing Guide: Naming and Structuring Conventions

## 1. Naming Convention

### Controller
- **Resource Controllers:** Should have plural names as they manage multiple instances of a model and cover all CRUD (Create, Read, Update, Delete) operations.
- **Generic Controllers:** Used for specific, non-CRUD operations and can be singular. They handle specialized or aggregated tasks across various models.

## 2. Definitions

### Services
- Encapsulate the core business logic of an application, separate from the user interface and data access layers.
- Handle computations, processing, and application rules, but do not manage database operations directly.
- Manage connections and interactions with third-party applications, acting as a bridge to external APIs.

### Traits
- Provide reusable methods that can be included in multiple classes.
- Promote DRY (Don't Repeat Yourself) principles without inheritance.
- Should not substitute the functionality of services or helpers; they add supplementary methods to classes.

### Helpers
- Utility functions that handle tasks not tied to the core business logic or database interactions.
- Common uses include formatting dates and transforming data.
- Should remain lightweight and avoid excessive logic.

### Repositories
- Abstract the logic needed to access data sources.
- Offer a collection of operations for a data source, used by the rest of the application.
- Controlled via interfaces, ensuring a contract for operations and easier testing and maintenance.

### Interfaces
- Define contract outlines for sets of functionalities.
- Enforce a structure for implementing classes, promoting coding standards and consistency in method signatures and return types.

### Resources (Laravel)
- Transformation layers that convert models and model collections into JSON.
- Uniformly present and format API responses to the client.

## 3. Database

### Migrations
- Act like version control for your database, modifying and sharing the database schema definition.
- Keep track of changes to the database structure over time, useful in team environments and across development stages.

### Seeders
- Populate database tables with sample data for testing and development.
- Useful for testing with production-mimicking data or loading essential application data.

### View Table
- Typically refers to database views or viewing table data in the application.
- Database views are SQL queries stored as virtual tables, simplifying complex queries and enhancing manageability.

### Factories
- Create models with random or specified data for testing.
- Integral to Laravel's testing suite, generating test objects with dummy data formatted correctly for the application’s schema.

## 4. Testing (PESTS)
- Details practices and tools for using the PEST framework, focusing on streamlined, human-readable testing syntax.
- Covers test organization, mocking, and CI/CD pipeline integration.

## 5. React

### useState
- A Hook that allows adding state to function components.
- Tracks state in a function component, used for declaring state variables.

### useEffect
- A Hook that manages side-effects in function components.
- Used for data fetching, subscriptions, or manually changing the DOM, replacing lifecycle methods like componentDidMount, componentDidUpdate, and componentWillUnmount.

## 6. Inertia Form

### setData
- `setData` is a method used in Inertia forms to dynamically set form data. It's particularly useful for updating the form state based on user input or when an initial value needs to be set based on props or external data. This method facilitates reactive form handling, ensuring that the form's visual state remains in sync with the underlying data model.
