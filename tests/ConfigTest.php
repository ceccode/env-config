<?php namespace ffrancesco\Test;

require_once realpath(__DIR__ . '/../vendor/autoload.php');

use ffrancesco\Config;
use ffrancesco\exceptions;

/**
 * Class ConfigTest
 * @package ffrancesco\Test
 */
class ConfigTest extends \PHPUnit_Framework_TestCase {

  /**
   * @expectedException InvalidArgumentException
   */
  public function testExceptionIsRaisedForInvalidConstructorArguments() {
    new Config(null);
  }

  /**
   * @expectedException ffrancesco\exceptions\FileNotFoundException
   */
  public function testExceptionIsRaisedForFileNotFound() {
    new Config('config');
  }

  /**
   * @expectedException ffrancesco\exceptions\ParseErrorException
   */
  public function testExceptionIsRaisedForMalformedJsonFile() {
    new Config('configmalformed', (__DIR__ . '/fake'));
  }

  public function testConfigReturnInstanceOfArrayAccess() {
    $config = new Config('config', (__DIR__ . '/fake'));
    $this->assertInstanceOf('\ArrayAccess', $config);

  }

  public function testCanStaticallyInstanceConfig() {
    Config::get('config', (__DIR__ . '/fake'));
  }

  /**
   * @expectedException \BadMethodCallException
   */
  public function testExceptionIsRaisedForSetConfigAttr() {
    $config               = Config::get('config', (__DIR__ . '/fake'));
    $config[ 'database' ] = 'database_2';

  }

  /**
   * @expectedException \BadMethodCallException
   */
  public function testExceptionIsRaisedForUnsetConfigAttr() {
    $config = Config::get('config', (__DIR__ . '/fake'));
    unset($config[ 'database' ]);

  }


} 