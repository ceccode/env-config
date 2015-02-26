<?php namespace ffrancesco\Exceptions;

  class ParseErrorException extends \Exception {

    public function __construct($message) {
      parent::__construct($message);
    }

  }