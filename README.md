# RouteManager

A Simple REST API Route Manager for PHP. Create named routes for easy access to REST APIs. **RouteManager** will assemble and return complete route based on pattern supplied.

### Basic Usage
```php
// create instance
$xn = new \xenin\RouteManager('http://api-base-url');

// setup routes
$xn->add('user', '/user/{userID}/account');
$xn->add('message', '/user/{userID}/messages/{messageID}');

// get routes
$usrRoute = $xn->get('user', array('userID' => 44));
$msgRoute = $xn->get('message', array('userID' => 44,'messageID' => 2));

```

