# Headless CORS Manager for WordPress

A lightweight, professional PHP module for controlling WordPress REST API CORS (Cross-Origin Resource Sharing) headers. This component is essential for headless WordPress architectures where the frontend (e.g., a React, Vue, or Next.js app) resides on a different domain than the WordPress backend.

## ✨ Features

* **Enables Headless Architecture:** Allows your frontend application to securely fetch data from the WordPress REST API.
* **Secure Origin Validation:** Securely validates the request origin against a filterable allow-list, rather than using a generic wildcard (`*`).
* **Pre-flight Request Handling:** Correctly handles `OPTIONS` (pre-flight) requests required by browsers for complex cross-origin requests.
* **Filter-Based Configuration:** Easily add your frontend domains using a standard WordPress filter—no need to edit the module's core files.

---

## 🚀 Installation & Usage

Follow these two simple steps to integrate the module into your theme.

### 1. Include the Module

1.  Copy the entire `wp-headless-cors-manager` directory into your active WordPress theme's folder. A good location is `/wp-content/themes/your-theme/includes/`.
2.  Open your theme's `functions.php` file and add the following line to load the module:

```php
// Load the Headless CORS Manager
require_once get_template_directory() . '/includes/wp-headless-cors-manager/headless-cors-manager.php';
```

### 2. Configure Allowed Domains

By default, the module allows requests from common development servers (`http://localhost:3000`, `http://localhost:8080`).

To add your production and staging domains, add the following code to your theme's `functions.php` file.

```php
/**
 * Add frontend application domains to the REST API allowed origins list.
 *
 * @param array $allowed_origins The default list of allowed origins.
 * @return array The modified list of allowed origins.
 */
function my_theme_add_allowed_origins( $allowed_origins ) {

    // Add your production frontend URL
    $allowed_origins[] = '[https://your-production-app.com](https://your-production-app.com)';
    
    // Add your staging frontend URL
    $allowed_origins[] = '[https://staging.your-app.com](https://staging.your-app.com)';

    return $allowed_origins;
}
add_filter( 'hussainas_rest_allowed_origins', 'my_theme_add_allowed_origins' );
```

That's it. Your WordPress REST API will now accept authenticated requests from the domains you specified.

