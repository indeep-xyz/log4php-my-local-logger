MyLocalLogger (log4php)
----

Write logs with log4php in my settings.

Dependency
----

- [Apache log4php](http://logging.apache.org/log4php)

Usage
----

```php
// Include the class Logger
require_once('path/to/lib/log4php/Logger.php');

// Include the classes in MyLocalLogger
require_once('path/to/MyLocalLogger/Write.php');
require_once('path/to/MyLocalLogger/LoggerAgent.php');

// Set a directory path to write log files
\MyLocalLogger\Configure::setLogDir('/path/to/log');

// Set names as mocks
\MyLocalLogger\Configure::setMockNames(['debug' , 'journal']);

try {
  \MyLocalLogger\Write::journal('IN');
  \MyLocalLogger\Write::input('JSON', json_encode($json));
  \MyLocalLogger\Write::output('JSON', json_encode($json));
  \MyLocalLogger\Write::journal('OUT');
}
catch (Exception $ex) {
  \MyLocalLogger\Write::error('Something error', $ex);
}
```

### mock?

```php
\MyLocalLogger\Configure::setMockNames(['debug' , 'journal']);
$agent = new LoggerAgent([
    'debug', 'journal', 'data', 'error', 'fatal',
    ]);

// An instance of MyLocalLogger\Mock
$logger = $agent->getLogger('debug');

// An instance of Logger of log4php
$logger = $agent->getLogger('error');
```

Mock objects have methods to write log Logger has but the methods write no log.

The code the first line above sets names as mocks which mimic instances of Logger.
LoggerAgent#getLogger returns an object which is a mock when the argument passed to the method has been configured to the class Configure.

You can reduce extra logs according to the mode, for example, debug or release:

```php
if (!file_exists(dirname(__FILE__) . '/DEBUG_MODE')) {
  \MyLocalLogger\Configure::setMockNames(['debug' , 'journal']);
}
```

Author
----

[indeep-xyz](https://github.com/indeep-xyz)
