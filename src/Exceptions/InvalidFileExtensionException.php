<?php namespace ffrancesco\exceptions;

class InvalidFileExtensionException extends \Exception {

  public function __construct($message) {
    parent::__construct($message);
  }

} 