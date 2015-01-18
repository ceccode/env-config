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
    new Config('fake/this_file_not_exsist.json');
  }

  /**
   * @expectedException ffrancesco\exceptions\InvalidFileExtensionException
   */
  public function testExceptionIsRaisedForInvalidFileExtension() {
    new Config(realpath(__DIR__  .'/fake/config.local.txt'));
  }

  /**
   * @expectedException ffrancesco\exceptions\ParseErrorException
   */
  public function testExceptionIsRaisedForMalformedJsonFile() {
    new Config(realpath(__DIR__  .'/fake/config.local.malformed.json'));
  }

  public function testConfigReturnInstanceOfArrayAccess() {
    $config = new Config(realpath(__DIR__  .'/fake/config.local.json'));
    $this->assertInstanceOf('\ArrayAccess', $config);

  }

  public function testCanStaticallyInstanceConfig() {
    Config::get(realpath(__DIR__  .'/fake/config.local.json'));
  }

  /**
   * @expectedException \BadMethodCallException
   */
  public function testExceptionIsRaisedForSetConfigAttr() {
    $config = Config::get(realpath(__DIR__  .'/fake/config.local.json'));
    $config['database'] = 'database_2';

  }

  /**
   * @expectedException \BadMethodCallException
   */
  public function testExceptionIsRaisedForUnsetConfigAttr() {
    $config = Config::get(realpath(__DIR__  .'/fake/config.local.json'));
    unset($config['database']);

  }

} 