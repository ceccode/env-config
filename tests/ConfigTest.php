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
    new Config(null, null);
  }

  /**
   * @expectedException ffrancesco\exceptions\FileNotFoundException
   */
  public function testExceptionIsRaisedForFileNotFound() {
    new Config('environment', 'config');
  }

  /**
   * @expectedException ffrancesco\exceptions\ParseErrorException
   */
  public function testExceptionIsRaisedForMalformedJsonFile() {
    new Config('environment', 'configmalformed', (__DIR__ . '/fake'));
  }

  public function testConfigReturnInstanceOfArrayAccess() {
    $config = new Config('environment', 'config', (__DIR__ . '/fake'));
    $this->assertInstanceOf('\ArrayAccess', $config);

  }

  public function testCanStaticallyInstanceConfig() {
    Config::get('environment', 'config', (__DIR__ . '/fake'));
  }

  public function testCanReadConfigFromStagingEnv() {
    putenv('environment=staging');
    $conf = Config::get('environment', 'config', (__DIR__ . '/fake'));
    $this->assertEquals($conf[ 'database' ][ 'name' ], 'db_staging_name');

  }

  /**
   * @expectedException \BadMethodCallException
   */
  public function testExceptionIsRaisedForSetConfigAttr() {
    $config               = Config::get('environment', 'config', (__DIR__ . '/fake'));
    $config[ 'database' ] = 'database_2';

  }

  /**
   * @expectedException \BadMethodCallException
   */
  public function testExceptionIsRaisedForUnsetConfigAttr() {
    $config = Config::get('environment', 'config', (__DIR__ . '/fake'));
    unset($config[ 'database' ]);

  }

}