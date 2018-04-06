<?php

/**
 * AttributeInterface.php (UTF-8)
 * Copyright (c) 2015 Sami Holck <sami.holck@gmail.com>.
 */

namespace Sphp\Html\Attributes;

use Sphp\Html\Attributes\Exceptions\AttributeException;
use Sphp\Html\Attributes\Exceptions\ImmutableAttributeException;

/**
 * Defines an HTML attribute object
 *
 * @author  Sami Holck <sami.holck@gmail.com>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @filesource
 */
interface AttributeInterface {

  /**
   * Returns the instance of the object as a string
   *
   * @return string the object as a string
   */
  public function __toString(): string;

  /**
   * Returns the instance of the object as a string
   *
   * @return string the object as a string
   */
  public function getHtml(): string;

  /**
   * Returns the name of the attribute 
   * 
   * @return string the name of the attribute
   */
  public function getName(): string;

  /**
   * Checks whether the attribute has a locked value or not
   * 
   * @return boolean true if the attribute has a locked value and false otherwise
   */
  public function isProtected(): bool;

  /**
   * Returns the value of the attribute
   * 
   * **IMPORTANT:**
   * 
   * * Returns always `boolean false` if attribute is not present.
   * * return `null` or an empty string for empty attributes.
   * 
   * @return bool|int|float|string the value of the attribute
   */
  public function getValue();

  /**
   * Checks whether the attribute is visible or not
   * 
   * **Note:** an attribute is visible if it has locked value or the attribute 
   * name is required or the attribute value is not boolean (false).
   * 
   * @return boolean true if the attribute is visible and false otherwise
   */
  public function isVisible(): bool;

  /**
   * Checks whether the attribute is empty or not
   * 
   * **Note:** an attribute is visible if it has locked value or the attribute 
   * name is required or the attribute value is not boolean (false).
   * 
   * @return boolean true if the attribute is empty and false otherwise
   */
  public function isEmpty(): bool;

  /**
   * Checks whether the attribute is required or not
   * 
   * **Note:** a required attribute either has locked value or the attribute 
   * name is required.
   *
   * @return boolean true if the attribute is required and false otherwise
   */
  public function isDemanded(): bool;
}
