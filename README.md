# WPZylos Core

[![PHP Version](https://img.shields.io/badge/php-%5E8.0-blue)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)
[![GitHub](https://img.shields.io/badge/GitHub-KYNetCode-181717?logo=github)](https://github.com/KYNetCode/wpzylos-core)

The foundation package for WPZylos framework. Provides core interfaces, context management, and base classes for building WordPress plugins with modern architecture.

📖 **[Full Documentation](https://wpzylos.com)** | 🐛 **[Report Issues](https://github.com/KYNetCode/wpzylos-core/issues)**

---

## ✨ Features

- **ContextInterface** — Plugin identity contract that survives PHP-Scoper
- **PluginContext** — Default implementation with prefixing, paths, hooks, options, transients, cron, meta keys, and asset handles
- **Application** — Plugin kernel with PSR-11 container and service provider lifecycle
- **ServiceProvider** — Base class for modular service registration with convenience methods
- **Paths** — Path and URL resolution with named aliases and `@alias` syntax
- **CacheRepository** — Context-prefixed caching via WordPress object cache + transient fallback
- **Utilities** — `Arr` (dot-notation array helpers) and `Str` (string manipulation) classes

---

## 📋 Requirements

| Requirement | Version |
| ----------- | ------- |
| PHP         | ^8.0    |
| WordPress   | 6.0+    |

---

## 🚀 Installation

```bash
composer require KYNetCode/wpzylos-core
```

---

## 📖 Quick Start

```php
use WPZylos\Framework\Core\Application;
use WPZylos\Framework\Core\PluginContext;

// Create plugin context
$context = PluginContext::create([
    'file'       => __FILE__,
    'slug'       => 'my-plugin',
    'prefix'     => 'myplugin_',
    'textDomain' => 'my-plugin',
    'version'    => '1.0.0',
    'namespace'  => 'MyPlugin',
]);

// Create and boot application
$app = new Application($context);
$app->register(new MyServiceProvider());
$app->boot();
```

---

## 🏗️ Core Components

### PluginContext

Holds plugin identity and configuration:

```php
$context = PluginContext::create([
    'file'       => __FILE__,
    'slug'       => 'my-plugin',
    'prefix'     => 'myplugin_',
    'textDomain' => 'my-plugin',
    'version'    => '1.0.0',
    'namespace'  => 'MyPlugin',
]);

// Identity
$context->slug();        // 'my-plugin'
$context->prefix();      // 'myplugin_'
$context->textDomain();  // 'my-plugin'
$context->version();     // '1.0.0'
$context->namespace();   // 'MyPlugin'

// Prefixed keys
$context->optionKey('setting');          // 'myplugin_setting'
$context->hook('init');                  // 'myplugin_init'
$context->transientKey('cache');         // 'myplugin_cache'
$context->cronHook('daily_sync');        // 'myplugin_daily_sync'
$context->metaKey('order_id');           // '_myplugin_order_id'
$context->assetHandle('admin-js');       // 'my-plugin-admin-js'
$context->tableName('orders');           // 'wp_myplugin_orders'
```

### Application

Plugin kernel that manages service providers and the DI container:

```php
$app = new Application($context);

// Register service providers
$app->register(new DatabaseServiceProvider());
$app->register(new RoutingServiceProvider());

// Boot the application
$app->boot();

// Resolve services from the container
$service = $app->make(MyService::class);

// Check if a service is bound
$app->has(MyService::class); // true/false
```

### ServiceProvider

Base class for modular service registration:

```php
use WPZylos\Framework\Core\ServiceProvider;
use WPZylos\Framework\Core\Contracts\ApplicationInterface;

class MyServiceProvider extends ServiceProvider
{
    public function register(ApplicationInterface $app): void
    {
        parent::register($app);

        $this->singleton(MyService::class, function () {
            return new MyService($this->context());
        });
    }

    public function boot(ApplicationInterface $app): void
    {
        // Called after all providers are registered
        $service = $this->make(MyService::class);
    }
}
```

### Paths

Path resolution with named aliases and `@alias` syntax:

```php
$paths = $app->paths();

// Use built-in aliases
$paths->path('@views/welcome.php');     // /plugin/resources/views/welcome.php
$paths->url('@assets/css/app.css');     // https://.../resources/assets/css/app.css

// Register custom aliases (chainable)
$paths->alias('templates', 'resources/templates');

// Check existence
$paths->exists('@config/app.php');      // true/false

// Plugin uploads directory
$paths->uploads('invoices/1.pdf');      // .../wp-content/uploads/my-plugin/invoices/1.pdf
```

### CacheRepository

Context-prefixed caching with WordPress object cache and transient fallback:

```php
use WPZylos\Framework\Core\Cache\CacheRepository;

$cache = new CacheRepository($context);

// Object cache
$cache->put('key', 'value', 3600);
$cache->get('key');               // 'value'
$cache->forget('key');

// Remember pattern
$users = $cache->remember('active_users', 3600, function () {
    return get_users(['role' => 'subscriber']);
});

// Transient fallback (persistent across requests)
$cache->transientPut('license', $data, DAY_IN_SECONDS);
$cache->transientGet('license');
$cache->transientRemember('api_data', HOUR_IN_SECONDS, fn() => fetch_api());
```

---

## 📦 Related Packages

| Package                                                                  | Description                 |
| ------------------------------------------------------------------------ | --------------------------- |
| [wpzylos-container](https://github.com/KYNetCode/wpzylos-container) | PSR-11 dependency injection |
| [wpzylos-config](https://github.com/KYNetCode/wpzylos-config)       | Configuration management    |
| [wpzylos-hooks](https://github.com/KYNetCode/wpzylos-hooks)         | WordPress hook management   |
| [wpzylos-scaffold](https://github.com/KYNetCode/wpzylos-scaffold)   | Plugin template             |

---

## 📖 Documentation

For comprehensive documentation, tutorials, and API reference, visit **[wpzylos.com](https://wpzylos.com)**.

---

## ☕ Support the Project

- [GitHub Sponsors](https://github.com/sponsors/KYNetCode)
- [PayPal Donate](https://www.paypal.com/donate/?hosted_button_id=66U4L3HG4TLCC)

---

## 📄 License

MIT License. See [LICENSE](LICENSE) for details.

---

## 🤝 Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

---

**Made with ❤️ by [KYNetCode](https://github.com/KYNetCode)**
