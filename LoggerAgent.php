<?php

namespace MyLocalLogger;

require_once(dirname(__FILE__) . '/Configure.php');
require_once(dirname(__FILE__) . '/Mock.php');

/**
 * This class manages instances of the class of log4php Logger.
 *
 * @author  indeep-xyz
 * @package MyLocalLoggers
 * @version 0.1.2
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
      $path = Configure::createLogPath($path);

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
    $mockNames = Configure::getMockNames();

    foreach ($loggerKeys as $key) {
      if (in_array($key, $mockNames)) {
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
}