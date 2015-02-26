<?php namespace ffrancesco;

use ffrancesco\Exceptions\FileNotFoundException;
use ffrancesco\Exceptions\ParseErrorException;
use InvalidArgumentException;

class Config implements \ArrayAccess {

  /**
   * @var array|mixed
   */
  protected $config = array ();

  /**
   * @var string
   */
  protected $env;

  /**
   * @var string
   */
  protected $filename;

  /**
   * @var string
   */
  protected $path;

  /**
   * @param $env
   * @param $filename
   * @param $path
   * @return Config
   */
  public static function get($env, $filename, $path) {
    return new Config($env, $filename, $path);

  }

  public function __construct($env, $filename, $path = null) {

    if (is_null($filename) || is_null($env)) {
      throw new InvalidArgumentException;
    }

    $this->env      = $env;
    $this->filename = $filename;
    $this->path     = is_null($path) ? '' : $path;

    $path = $this->buildPath();

    if (!file_exists($path)) {
      throw new FileNotFoundException('File not found');
    }

    $this->config = $this->loadConfig($path);

  }

  /**
   * @param $path
   * @return mixed
   * @throws exceptions\ParseErrorException
   */
  protected function loadConfig($path) {
    $config = json_decode(file_get_contents($path), true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new ParseErrorException('Parse error');
    }

    return $config;

  }

  /**
   * @param mixed $offset
   * @return bool
   */
  public function offsetExists($offset) {
    return array_key_exists($offset, $this->config);

  }

  /**
   * @param mixed $offset
   * @return mixed|null
   */
  public function offsetGet($offset) {
    return $this->offsetExists($offset) ? $this->config[ $offset ] : null;

  }

  /**
   * @param mixed $offset
   * @param mixed $value
   * @throws \BadMethodCallException
   */
  public function offsetSet($offset, $value) {
    throw new \BadMethodCallException('Values cannot be changed in this class, thrown in %s');

  }

  /**
   * @param mixed $offset
   * @throws \BadMethodCallException
   */
  public function offsetUnset($offset) {
    throw new \BadMethodCallException('Values cannot be changed in this class, thrown in %s');

  }

  /**
   * @return string
   */
  protected function getCurrentEnv() {
    return getenv($this->env) ? : 'local';

  }

  /**
   * @return string
   */
  protected function buildPath() {
    return $this->path . '/' . $this->filename . '.' . $this->getCurrentEnv() . '.json';

  }

}