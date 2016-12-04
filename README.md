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
\MyLocalLogger\LoggerAgent::setLogDir('/path/to/log');

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

Author
----

[indeep-xyz](https://github.com/indeep-xyz)
