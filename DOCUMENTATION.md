# PHP User Authentication System - Documentation

## Project Overview

This is a complete PHP user authentication system with registration, login, and dashboard functionality. The system uses PDO for database interactions, implements secure password hashing, and follows a modular architecture with separation of concerns.

## Features

- User Registration with validation
- User Login with session management
- Secure password hashing using bcrypt
- Input sanitization and validation
- Flash message system for user feedback
- Protected dashboard area
- Session-based authentication
- Admin user support
- Responsive CSS styling
- CSRF protection through session regeneration

## System Requirements

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Apache web server with mod_rewrite
- PDO MySQL extension enabled

## Directory Structure

```
php/
├── config/
│   └── database.php          # Database configuration and constants
├── public/
│   ├── css/
│   │   ├── style.css         # Main stylesheet
│   │   └── dashboard.css     # Dashboard-specific styles
│   ├── index.php             # Home page
│   ├── login.php             # Login page
│   ├── register.php          # Registration page
│   ├── dashboard.php         # User dashboard
│   └── logout.php            # Logout handler
├── src/
│   ├── bootstrap.php         # Application bootstrap file
│   ├── login.php             # Login logic
│   ├── register.php          # Registration logic
│   ├── inc/
│   │   ├── auth.php          # Authentication functions
│   │   ├── header.php        # Standard page header
│   │   ├── dashboard_header.php  # Dashboard header with navigation
│   │   └── footer.php        # Page footer
│   └── libs/
│       ├── connection.php    # Database connection
│       ├── filter.php        # Input filtering
│       ├── flash.php         # Flash message system
│       ├── helpers.php       # Helper functions
│       ├── sanitization.php  # Input sanitization
│       └── validation.php    # Input validation
├── index.php                 # Root index (legacy)
└── logout.php                # Root logout (legacy)
```

## Database Setup

### Create Database

```sql
CREATE DATABASE user_auth_db;
USE user_auth_db;
```

### Create Users Table

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(25) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Configure Database Connection

Edit `config/database.php` and update the following constants:

```php
const DB_HOST = 'localhost';
const DB_NAME = 'user_auth_db';
const DB_USER = 'root';
const DB_PASSWORD = '';
```

## Installation

1. Copy the project files to your web server directory (e.g., `c:\xampp\htdocs\php`)

2. Create the database and users table using the SQL commands above

3. Update database credentials in `config/database.php`

4. Access the application at `http://localhost/php/public/`

5. Register a new account or login if you already have one

## Core Components

### Bootstrap File (src/bootstrap.php)

The bootstrap file initializes the application by:
- Starting the session (if not already started)
- Loading database configuration
- Including all required library files
- Including authentication functions

### Authentication System (src/inc/auth.php)

**Functions:**

- `register_user($email, $username, $password, $is_admin = false)`
  - Registers a new user in the database
  - Hashes password using bcrypt
  - Returns boolean for success/failure

- `find_user_by_username($username)`
  - Retrieves user data from database by username
  - Returns user array or false

- `login($username, $password)`
  - Authenticates user credentials
  - Regenerates session ID to prevent fixation attacks
  - Sets session variables: username, user_id, is_admin
  - Returns boolean for success/failure

- `is_user_logged_in()`
  - Checks if user is currently logged in
  - Returns boolean

- `require_login()`
  - Redirects to login page if user is not authenticated
  - Used to protect pages

- `logout()`
  - Destroys session and redirects to login page

### Database Connection (src/libs/connection.php)

**Function:**

- `db()`
  - Returns PDO database connection instance
  - Uses singleton pattern to maintain single connection
  - Configured for UTF-8 charset

### Input Sanitization (src/libs/sanitization.php)

**Constants:**

- `FILTERS` - Array mapping field types to PHP filter constants

**Functions:**

- `array_trim($items)`
  - Recursively trims strings in an array
  - Returns trimmed array

- `sanitize($inputs, $fields, $default_filter, $filters, $trim)`
  - Sanitizes input data based on field types
  - Returns sanitized data array

### Input Validation (src/libs/validation.php)

**Constants:**

- `DEFAULT_VALIDATION_ERRORS` - Default error messages for validation rules

**Functions:**

- `validate($data, $fields, $messages)`
  - Validates data against specified rules
  - Returns array of errors

- `is_required($data, $field)`
  - Validates required fields
  - Returns boolean

- `is_email($data, $field)`
  - Validates email format
  - Returns boolean

- `is_min($data, $field, $min)`
  - Validates minimum string length
  - Returns boolean

- `is_max($data, $field, $max)`
  - Validates maximum string length
  - Returns boolean

- `is_between($data, $field, $min, $max)`
  - Validates length is between min and max
  - Returns boolean

- `is_alphanumeric($data, $field)`
  - Validates alphanumeric characters only
  - Returns boolean

- `is_same($data, $field, $other)`
  - Validates two fields match
  - Returns boolean

- `is_secure($data, $field)`
  - Validates password security requirements
  - Requires: 8-64 chars, uppercase, lowercase, number, special char
  - Returns boolean

- `is_unique($data, $field, $table, $column)`
  - Validates uniqueness in database
  - Returns boolean

### Filter System (src/libs/filter.php)

**Function:**

- `filter($inputs, $fields, $messages)`
  - Combines sanitization and validation
  - Returns array containing sanitized inputs and errors
  - Format: `[$inputs, $errors]`

### Flash Message System (src/libs/flash.php)

**Constants:**

- `FLASH` - Session key for flash messages
- `FLASH_ERROR`, `FLASH_WARNING`, `FLASH_SUCCESS`, `FLASH_INFO` - Message types

**Functions:**

- `create_flash_message($name, $message, $type)`
  - Creates a flash message in session
  - Overwrites existing message with same name

- `format_flash_message($flash_message)`
  - Formats message as HTML with CSS classes
  - Returns HTML string

- `display_flash_message($name)`
  - Displays and removes specific flash message
  - Outputs formatted HTML

- `display_all_flash_messages()`
  - Displays all flash messages
  - Clears all messages from session

- `flash($name, $message, $type)`
  - Multi-purpose flash function
  - Can create, display specific, or display all messages
  - Usage varies based on parameters provided

### Helper Functions (src/libs/helpers.php)

**Functions:**

- `view($filename, $data)`
  - Renders a view file from src/inc/
  - Extracts data array to variables
  - Includes the specified PHP file

- `error_class($errors, $field)`
  - Returns 'error' class if field has error
  - Used for form input styling

- `is_post_request()`
  - Returns true if request method is POST

- `is_get_request()`
  - Returns true if request method is GET

- `redirect_to($url)`
  - Redirects to specified URL
  - Terminates script execution

- `redirect_with($url, $items)`
  - Redirects with data stored in session
  - Used to pass errors and inputs between requests

- `redirect_with_message($url, $message, $type)`
  - Redirects with flash message
  - Default type is FLASH_SUCCESS

- `session_flash(...$keys)`
  - Retrieves and removes multiple session keys
  - Returns array of values (empty array if key not found)
  - Used to retrieve flashed data after redirect

## User Registration Flow

1. User accesses `public/register.php`
2. Form displayed with fields: username, email, password, password confirmation, terms agreement
3. On form submission (POST):
   - Data passes through filter system
   - Sanitization applied based on field types
   - Validation rules checked:
     - Username: required, alphanumeric, 3-25 chars, unique
     - Email: required, valid email, unique
     - Password: required, secure (8+ chars, mixed case, number, special char)
     - Password2: required, matches password
     - Agree: required checkbox
4. If validation fails:
   - Redirects back with errors and inputs
   - Displays error messages on form
5. If validation passes:
   - User registered in database
   - Password hashed with bcrypt
   - Redirects to login page with success message

## User Login Flow

1. User accesses `public/login.php`
2. Form displayed with username and password fields
3. On form submission (POST):
   - Inputs sanitized and validated
   - Username and password checked against database
   - Password verified using `password_verify()`
4. If credentials invalid:
   - Redirects back with error message
   - Form redisplayed with error
5. If credentials valid:
   - Session ID regenerated for security
   - User data stored in session
   - Redirects to dashboard

## Dashboard Access

1. User must be logged in to access dashboard
2. `require_login()` function checks authentication
3. If not logged in, redirects to login page
4. Dashboard displays:
   - Header with navigation links
   - Current username in header
   - User information card
   - Logout button

## Session Management

### Session Variables

- `$_SESSION['username']` - Current user's username
- `$_SESSION['user_id']` - Current user's username (duplicate of username)
- `$_SESSION['is_admin']` - Boolean flag for admin status
- `$_SESSION['FLASH_MESSAGES']` - Array of flash messages
- `$_SESSION['inputs']` - Temporary storage for form inputs after validation failure
- `$_SESSION['errors']` - Temporary storage for validation errors

### Session Security

- Session ID regenerated on login to prevent session fixation
- Session checked before starting to avoid duplicate sessions
- Session destroyed completely on logout

## Validation Rules

Rules are defined as pipe-separated strings in field definitions:

```php
'username' => 'string | required | alphanumeric | between: 3, 25 | unique: users, username'
```

### Available Rules

- `required` - Field must not be empty
- `email` - Must be valid email format
- `min: X` - Minimum length of X characters
- `max: X` - Maximum length of X characters
- `between: X, Y` - Length between X and Y characters
- `alphanumeric` - Only letters and numbers allowed
- `same: field` - Must match another field
- `secure` - Strong password requirements
- `unique: table, column` - Must be unique in database

### Sanitization Types

- `string` - Sanitize as string (HTML special chars)
- `email` - Sanitize email address
- `int` - Sanitize as integer
- `float` - Sanitize as float
- `url` - Sanitize URL
- Array variants: `string[]`, `int[]`, `float[]`

## Security Features

### Password Security

- Passwords hashed using `password_hash()` with bcrypt algorithm
- Password verification uses `password_verify()`
- Minimum 8 characters required
- Must contain uppercase, lowercase, number, and special character

### SQL Injection Prevention

- All database queries use prepared statements
- Parameters bound with appropriate types
- PDO configured to use exceptions

### XSS Prevention

- All user output escaped with `htmlspecialchars()`
- Input sanitization applied before storage
- Flash messages formatted with proper escaping

### Session Security

- Session ID regenerated on login
- Session status checked before starting
- Sessions destroyed completely on logout

## Error Handling

### Validation Errors

Displayed inline on forms below each field using:
```php
<small><?= $errors['field_name'] ?? '' ?></small>
```

### Flash Messages

System-wide messages displayed at top of page:
- Success messages (green)
- Error messages (red)
- Warning messages (yellow)
- Info messages (blue)

### Database Errors

PDO configured with `ERRMODE_EXCEPTION` for proper error handling

## CSS Styling

### Main Styles (public/css/style.css)

- Solid blue background (#667eea)
- White card-based forms
- Clean, modern design
- Form validation error states
- Responsive layout
- Alert boxes for flash messages

### Dashboard Styles (public/css/dashboard.css)

- Fixed header with navigation
- Dark header background (#2c3e50)
- Light gray body background (#ecf0f1)
- Card-based content layout
- Responsive navigation
- User information display

## Customization

### Changing Colors

Edit `public/css/style.css` and `public/css/dashboard.css`:
- Primary color: #667eea
- Dark background: #2c3e50
- Light background: #ecf0f1
- Success: #27ae60
- Error: #e74c3c

### Adding New Validation Rules

1. Create validation function in `src/libs/validation.php`:
```php
function is_rulename(array $data, string $field, $param1, $param2) : bool {
    // validation logic
    return true/false;
}
```

2. Add error message to `DEFAULT_VALIDATION_ERRORS` constant

3. Use in field definitions:
```php
'field' => 'rulename: param1, param2'
```

### Adding New Pages

1. Create logic file in `src/` directory
2. Create view file in `public/` directory
3. Include bootstrap: `require __DIR__ . '/../src/bootstrap.php'`
4. Add protection if needed: `require_login()`
5. Include header and footer views

## Common Issues and Solutions

### Session Already Started Warning

The bootstrap file checks session status before starting. If you still see this warning, ensure bootstrap is only included once per request.

### Database Connection Errors

- Verify database credentials in `config/database.php`
- Ensure MySQL server is running
- Check database and table exist
- Verify PDO MySQL extension is enabled in PHP

### Validation Not Working

- Check field names match between form and validation rules
- Ensure validation functions are defined correctly
- Verify error messages are displayed in form

### Redirect Loops

- Check `require_login()` is not called on login page
- Verify session variables are set correctly after login
- Clear browser cookies and sessions

## Best Practices

1. Always use prepared statements for database queries
2. Escape output with `htmlspecialchars()` when displaying user data
3. Use `require_login()` to protect authenticated pages
4. Validate and sanitize all user inputs
5. Use flash messages for user feedback
6. Keep sensitive data out of version control (database.php)
7. Use HTTPS in production environments
8. Implement CSRF tokens for production use
9. Add rate limiting for login attempts
10. Log authentication events for security monitoring

## Future Enhancements

- Password reset functionality
- Email verification
- Remember me functionality
- Two-factor authentication
- User profile management
- Admin panel
- User roles and permissions
- Activity logging
- Password strength meter
- Account lockout after failed attempts
- Email notifications
- Social media authentication

## License

This project is provided as-is for educational purposes.

## Support

For issues or questions, refer to the PHP documentation at php.net and MySQL documentation at dev.mysql.com.
