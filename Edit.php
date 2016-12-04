<?php

namespace MyLocalLogger;

/**
 * This class manages to edit string for logging.
 *
 * @author  indeep-xyz
 * @package MyLocalLoggers
 * @version 0.1.0
 */
class Edit {
  /**
   * Create caller string.
   * @param  [integer] $depth - The depth of calling
   * @return [string] String combined caller string before the argument messageSource
   */
  public static function createCallerString($depth = 2) {
    $backtrace = debug_backtrace();
    $className = 'main';
    $functionName = 'main';

    if ($depth < count($backtrace)) {
      $className = $backtrace[$depth]['class'];
      $functionName = $backtrace[$depth]['function'];
    }

    return sprintf(
        '%s::%s',
        $className,
        $functionName
        );
  }

  /**
   * Create error string.
   * @param  [Exception] $exception - A kind of Exception instance
   * @return [string] String combined error string after the argument messageSource
   */
  public static function createErrorString($exception) {
    return sprintf(
        "--> %s\n%s",
        $exception->getMessage(),
        preg_replace('/^/m', '--> ', $exception->getTraceAsString())
        );
  }
}