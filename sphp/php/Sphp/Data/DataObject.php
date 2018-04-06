<?php

/*
 * The MIT License
 *
 * Copyright 2018 Sami Holck <sami.holck@gmail.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Sphp\Data;

use Sphp\Stdlib\Datastructures\Arrayable;
use Sphp\Stdlib\Strings;
use Sphp\Exceptions\BadMethodCallException;
use Sphp\Database\Exceptions\InvalidArgumentException;

/**
 * Description of DataObject
 *
 * @author  Sami Holck <sami.holck@gmail.com>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @filesource
 */
class DataObject implements \ArrayAccess, Arrayable, \IteratorAggregate {

  private $reflector;
  protected $foo;
  public function __construct() {
    $this->reflector = new \ReflectionClass($this);
  }

  /**
   * Creates a HTML object
   *
   * @param  string $name the name of the component
   * @param  array $arguments 
   * @return TagInterface the corresponding component
   * @throws BadMethodCallException
   */
  public function __call(string $name, array $arguments) {
    if (Strings::match($name, '/^(has|get|set)/')) {
      var_dump($name = preg_replace('/^(has|get|set)/', '', $name));
      echo lcfirst($name);
      return true;
    } else {
      throw new BadMethodCallException("Method $name does not exist");
    }
  }

  public function toArray(): array {
    $raw = get_object_vars($this);
    $result = [];
    foreach ($raw as $prop => $val) {
      if ($val instanceof Arrayablerrayable) {
        $result[$prop] = $val->toArray();
      } else if ($val instanceof \Iterator) {
        $result = array_merge($result, $val->toArray());
      } else {
        $result[$prop] = $val;
      }
    }
    return $result;
  }

  public function __toString(): string {

    ;
  }

  public function getIterator(): \Traversable {
    return new \ArrayIterator($this->toArray());
  }

  public function offsetExists($offset): bool {
    return $this->reflector->hasProperty($offset);
  }

  public function offsetGet($offset) {
    if ($this->offsetExists($offset)) {
      return $this->{$offset};
    } else {
      throw new InvalidArgumentException;
    }
  }

  public function offsetSet($offset, $value) {
    $methodName = 'set' . ucfirst($offset);
    if ($this->reflector->hasMethod($methodName)) {
      try {
        $this->reflector->getMethod($methodName)->invoke($this, $value);
      } catch (\Exception $ex) {
        throw new InvalidArgumentException;
      }

      //$this->reflector->{$methodName}($value);
    } else if ($this->offsetExists($offset)) {
      $this->$offset = $value;
    } else {
      throw new InvalidArgumentException;
    }
  }

  public function offsetUnset($offset) {
    
  }

}
