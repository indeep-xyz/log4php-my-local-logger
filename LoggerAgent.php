<?php

namespace MyLocalLogger;

require_once(dirname(__FILE__) . '/Mock.php');

/**
 * This class manages instances of the class of log4php Logger.
 *
 * @author  indeep-xyz
 * @package MyLocalLoggers
 * @version 0.1.1
 */
class LoggerAgent {

  /**
   * A name of a configuration file for log4php.
   */
  const CONFIG_XML_FILENAME = 'config.xml';

  /**
   * Instances of Logger.
   * @var [array<Logger>]
   */
  private $loggers;

  /**
   * A directory path for destination of log files.
   * @var [string]
   */
  private static $logDir = '';

  /**
   * Names as mocks which mimic instances of Logger.
   * When the argument passed to #getLogger is in this field,
   * it returns a mock object.
   * @var [array<string>]
   */
  private static $mockNames = [];

  /**
   * Constructor.
   * Configure Logger and set its instances
   * to static member variables.
   * @param [array] $loggerKeys - The keys as names of Logger instances
   */
  function __construct(array $loggerKeys) {
    $this->configure();
    $this->initializeLoggers($loggerKeys);
  }

  /**
   * Configure the class of log4php "Logger".
   */
  private function configure() {
    $config = $this->loadXmlConfig();
    \Logger::configure($config);
  }

  /**
   * Load a config file and arrange the loaded data.
   * @return [array] Arranged log4php configuration data
   */
  private function loadXmlConfig() {
    $configurator = new \LoggerConfiguratorDefault();
    $config = $configurator->parse(dirname(__FILE__) . '/' . self::CONFIG_XML_FILENAME);
    $this->rewriteLogDir($config);

    return $config;
  }

  /**
   * Rewrite the parameter of destination of log files
   * in the log4php configuration.
   * @param  [array] &$config - log4php configuration data
   */
  private function rewriteLogDir(array &$config) {
    foreach ($config['appenders'] as &$appender) {
      $path = $appender['params']['fileName'];
      $path = \MyLocalLogger\LoggerAgent::createLogPath($path);

      $appender['params']['fileName'] = $path;
    }
  }

  /**
   * Initialize The field "loggers".
   * Its item is initialized into a Logger instance,
   * or set a mock when a key name is in the static field mockNames.
   * @param [array] $loggerKeys - The keys as names of Logger instances
   */
  private function initializeLoggers(array $loggerKeys) {
    foreach ($loggerKeys as $key) {
      if (in_array($key, self::$mockNames)) {
        $this->loggers[$key] = new Mock();
        continue;
      }

      $this->loggers[$key] = \Logger::getLogger($key);
    }
  }

  /**
   * Return an instance of Logger.
   * @param  [string] $key - A key of a Logger instance
   * @return [Logger] An instance
   */
  public function getLogger($key) {
    return $this->loggers[$key];
  }

  /**
   * Create a path of a log file.
   * @param  [string] $suffix - A suffix, a file name etc..
   * @return [string] A path combined with the self::logDir parameter
   */
  public static function createLogPath($suffix) {
    $path;

    if (strlen(self::$logDir) < 1) {
      $path = self::getDefaultLogDir() . '/' . $suffix;
    }
    else {
      $path = self::$logDir . '/' . $suffix;
    }

    return $path;
  }

  /**
   * Return the default value of a directory for destination.
   * @return [string] The default value of a directory for destination
   */
  public static function getDefaultLogDir() {
    return getcwd() . '/.log';
  }

  /**
   * Set a directory path for destination of log files.
   * @param [string] $logDir - A directory path
   */
  public static function setLogDir($logDir) {
    self::$logDir = $logDir;
  }

  /**
   * Set names as mocks which mimic instances of Logger.
   * A mock has the methods to receive to write
   * but they write no logs.
   * Names of the methods are the same names
   * consistent with methods Logger has.
   * @param [array<string>] $mockNames - It has names of logger as mocks
   */
  public static function setMockNames(array $mockNames) {
    self::$mockNames = $mockNames;
  }
}