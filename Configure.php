<?php

namespace MyLocalLogger;

/**
 * This class manages configure settings for MyLocalLogger.
 *
 * @author  indeep-xyz
 * @package MyLocalLoggers
 * @version 0.1.0
 */
class Configure {
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

  /**
   * Get names as mocks which mimic instances of Logger.
   * @return [array<string>] It has names of logger as mocks
   */
  public static function getMockNames() {
    return self::$mockNames;
  }
}