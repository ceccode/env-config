<?php namespace ffrancesco\exceptions;

  class ParseErrorException extends \Exception {

    public function __construct($message) {
      parent::__construct($message);
    }

  }