<?php

/**
 * Json.php (UTF-8)
 * Copyright (c) 2016 Sami Holck <sami.holck@gmail.com>
 */

namespace Sphp\Stdlib\Parsers;

use Exception;
use Zend\Config\Reader\Json as JsonFormat;
use Sphp\Exceptions\RuntimeException;

/**
 * Implements JSON reader
 * 
 * @author  Sami Holck <sami.holck@gmail.com>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @filesource
 */
class Json extends AbstractReader {

  /**
   * @var JsonFormat 
   */
  private $parser;

  public function __construct() {
    $this->parser = new JsonFormat();
  }

  public function fromString(string $string) {
    try {
      return $this->parser->fromString($string);
    } catch (Exception $ex) {
      throw new RuntimeException($ex->getMessage(), $ex->getCode(), $ex);
    }
  }

  /**
   * processConfig(): defined by AbstractWriter.
   *
   * @param  array $config
   * @return string
   * @throws RuntimeException if encoding errors occur.
   */
  public function encode(array $config): string {
    $serialized = json_encode($config, JSON_UNESCAPED_SLASHES|JSON_FORCE_OBJECT);

    if (false === $serialized) {
      throw new RuntimeException(json_last_error_msg());
    }

    return $serialized;
  }
  
  /**
   * processConfig(): defined by AbstractWriter.
   *
   * @param  string $config
   * @return array
   * @throws RuntimeException if decoding errors occur.
   */
  public function decode(string $config): array {
    $serialized = json_decode($config);

    if (false === $serialized) {
      throw new RuntimeException(json_last_error_msg());
    }

    return $serialized;
  }

  /**
   * processConfig(): defined by AbstractWriter.
   *
   * @param  string $path
   * @return array
   * @throws RuntimeException if decoding errors occur.
   */
  public function decodeFromFile(string $path): array {
    $raw = file_get_contents($path);
    $serialized = json_decode($raw, true);
    //var_dump($raw);
    if (false === $serialized) {
      throw new RuntimeException(json_last_error_msg());
    }

    return $serialized;
  }
}
