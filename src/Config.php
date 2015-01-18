<?php

  namespace ffrancesco;


  use ffrancesco\exceptions\FileNotFoundException;
  use ffrancesco\exceptions\InvalidFileExtensionException;
  use ffrancesco\exceptions\ParseErrorException;
  use InvalidArgumentException;

  class Config implements \ArrayAccess {

    /**
     * @var array|mixed
     */
    protected $config = array();


    public static function get($path) {
      return new Config($path);
    }


    public function __construct($path) {

      if (is_null($path)) {
        throw new InvalidArgumentException;
      }

      /**
       *
       */
      $file_parts = pathinfo($path);
      if (!file_exists($path)) {
        throw new FileNotFoundException('File not found');
      }

      if ((strtolower($file_parts[ 'extension' ]) !== 'json')) {
        throw new InvalidFileExtensionException('Invalid file extension');
      }

      $this->config = $this->load($path);

    }

    protected function load($path) {
      $config = json_decode(file_get_contents($path), true);

      if (json_last_error() !== JSON_ERROR_NONE) {
        throw new ParseErrorException('Parse error');
      }

      return $config;

    }

    public function offsetExists($offset) {
      return array_key_exists($offset, $this->config);
    }

    public function offsetGet($offset) {
      return $this->offsetExists($offset) ? $this->config[$offset]:NULL;
    }

    public function offsetSet($offset, $value) {
      throw new \BadMethodCallException('Values cannot be changed in this class, thrown in %s');
    }

    public function offsetUnset($offset) {
      throw new \BadMethodCallException('Values cannot be changed in this class, thrown in %s');
    }

  }