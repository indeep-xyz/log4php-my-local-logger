<?php

namespace MyLocalLogger;

require_once(dirname(__FILE__) . '/LoggerAgent.php');
require_once(dirname(__FILE__) . '/Edit.php');

/**
 * This class manages to write logs with log4php.
 *
 * @author  indeep-xyz
 * @package MyLocalLoggers
 * @version 0.1.0
 */
class Write {

  /**
   * An instance of LoggerAgent
   * @var LoggerAgent
   */
  private static $agent = null;

  /**
   * Initialize and Return an instance of LoggerAgent.
   * @return [LoggerAgent] An instance of LoggerAgent
   */
  public static function getLoggerAgent() {
    if (self::$agent === null) {
      self::$agent = new LoggerAgent([
          'debug', 'journal', 'data', 'error', 'fatal',
          ]);
    }

    return self::$agent;
  }

  /**
   * Write a debug log by the debug logger.
   * @param [string] $messageSource - A message source to write into log
   */
  public static function debug($messageSource) {
    $agent = self::getLoggerAgent();
    $logger = $agent->getLogger('debug');

    $message = sprintf(
        "[%s] %s",
        Edit::createCallerString(),
        $messageSource
        );

    $logger->debug($message);
  }

  /**
   * Write an error log by the error logger..
   * @param [string] $messageSource - A message source to write into log
   * @param [Exception] $exception - A kind of Exception instance
   */
  public static function error($messageSource, $exception = null) {
    $agent = self::getLoggerAgent();
    $logger = $agent->getLogger('error');

    $message = sprintf(
        "[%s] %s",
        Edit::createCallerString(),
        $messageSource
        );

    if ($exception === null) {
      $logger->error($message);
    }
    else {
      $message .= "\n" . Edit::createErrorString($exception);
      $logger->error($message, $exception);
    }
  }

  /**
   * Write a fatal log by the fatal logger.
   * @param [string] $messageSource - A message source to write into log
   * @param [Exception] $exception - A kind of Exception instance
   */
  public static function fatal($messageSource, $exception = null) {
    $agent = self::getLoggerAgent();
    $logger = $agent->getLogger('fatal');

    $message = sprintf(
        "[%s] %s",
        Edit::createCallerString(),
        $messageSource
        );

    if ($exception === null) {
      $logger->fatal($message);
    }
    else {
      $message .= "\n" . Edit::createErrorString($exception);
      $logger->fatal($message, $exception);
    }
  }

  /**
   * Write an input log by the data logger.
   * @param [string] $type - A type of data to write into log
   * @param [string] $dataStringSource - String converted from some data
   */
  public static function input($type, $dataStringSource = '') {
    $agent = self::getLoggerAgent();
    $logger = $agent->getLogger('data');

    if (strlen($dataStringSource) < 1) {
      $dataString = ' (empty)';
    }
    else {
      $dataString = sprintf(
          "\n%s\n\n",
          preg_replace('/^/m', '    ', $dataStringSource)
          );
    }

    $message = sprintf(
        "[input] [%s] %s%s",
        Edit::createCallerString(),
        $type,
        $dataString
        );

    $logger->info($message);
  }

  /**
   * Write an output log by the data logger.
   * @param [string] $type - A type of data to write into log
   * @param [string] $dataStringSource - String converted from some data
   */
  public static function output($type, $dataStringSource = '') {
    $agent = self::getLoggerAgent();
    $logger = $agent->getLogger('data');

    if (strlen($dataStringSource) < 1) {
      $dataString = ' (empty)';
    }
    else {
      $dataString = sprintf(
          "\n%s\n\n",
          preg_replace('/^/m', '    ', $dataStringSource)
          );
    }

    $message = sprintf(
        "[output] [%s] %s%s",
        Edit::createCallerString(),
        $type,
        $dataString
        );

    $logger->info($message);
  }

  /**
   * Write a journal log by the journal logger.
   * @param [string] $messageSource - A message source to write into log
   */
  public static function journal($messageSource) {
    $agent = self::getLoggerAgent();
    $logger = $agent->getLogger('journal');

    $message = sprintf(
        "[%s] %s",
        Edit::createCallerString(),
        $messageSource
        );

    $logger->debug($message);
  }
}