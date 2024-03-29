<?php

/**
 * SPHPlayground Framework (http://playgound.samiholck.com/)
 *
 * @link      https://github.com/samhol/SPHP-framework for the source repository
 * @copyright Copyright (c) 2007-2018 Sami Holck <sami.holck@gmail.com>
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Sphp\Html\Forms;

use ArrayAccess;
use Sphp\Html\Container;
use Sphp\Html\PlainContainer;
use Sphp\Html\Forms\Inputs\HiddenInput;
use Sphp\Html\TraversableContent;
use IteratorAggregate;

/**
 * Implements an HTML &lt;form&gt; tag
 *
 * The form element represents a collection of form-associated elements, some
 * of which can represent editable values that can be submitted to a server
 * for processing.
 *
 * @author  Sami Holck <sami.holck@gmail.com>
 * @link    http://www.w3schools.com/tags/tag_form.asp w3schools HTML API
 * @license https://opensource.org/licenses/MIT The MIT License
 * @filesource
 */
class ContainerForm extends AbstractForm implements IteratorAggregate, TraversableForm, ArrayAccess {

  /**
   * @var PlainContainer
   */
  private $container;

  /**
   * Constructor
   *
   * **Important!**
   *
   * Parameter `$content` can be of any type that converts to a
   * string or to an array of strings. So also an object of any class that
   * implements magic method `__toString()` is allowed.
   *
   *  **Note:** The method attribute specifies how to send form-data
   *  (the form-data is sent to the page specified in the action attribute)
   *
   * @precondition `$method == "get|post"`
   * @param  string|null $action where to send the form-data when the form is submitted
   * @param  string|null $method how to send form-data
   * @param  mixed $content tag's content
   * @link   http://www.w3schools.com/tags/att_form_action.asp action attribute
   * @link   http://www.w3schools.com/tags/att_form_method.asp method attribute
   */
  public function __construct(string $action = null, string $method = null, $content = null) {
    parent::__construct();
    if ($content !== null) {
      $this->append($content);
    }
    if ($action !== null) {
      $this->setAction($action);
    }
    if ($method !== null) {
      $this->setMethod($method);
    }
    $this->container = new PlainContainer();
  }

  public function content(): \Sphp\Html\Container {
    return $this->container;
  }

  public function append($value) {
    $this->content()->append($value);
    return $this;
  }

  public function getNamedInputComponents(): TraversableContent {
    $search = function($element) {
      $element instanceof InputInterface && $element->isNamed();
    };
    return $this->getComponentsBy($search);
  }

  public function contentToString(): string {
    return $this->container . $this->getHiddenInputs();
  }

  public function count(): int {
    
  }

  public function getComponentsBy(callable $rules): TraversableContent {
    
  }

  public function getComponentsByObjectType($typeName): TraversableContent {
    
  }

  public function toArray(): array {
    
  }

  public function getIterator(): \Traversable {
    return $this->container;
  }

  public function offsetExists($offset): bool {
    return $this->container->offsetExists($offset);
  }

  public function offsetGet($offset) {
    return $this->container->offsetGet($offset);
  }

  public function offsetSet($offset, $value): void {
    $this->container->offsetSet($offset, $value);
  }

  public function offsetUnset($offset): void {
    $this->container->offsetUnset($offset);
  }

}
