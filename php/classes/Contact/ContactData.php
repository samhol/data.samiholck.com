<?php

/**
 * MemberData.php (UTF-8)
 * Copyright (c) 2017 Sami Holck <sami.holck@gmail.com>
 */

namespace Sphp\Samiholck\Contact;

/**
 *
 * @author  Sami Holck <sami.holck@gmail.com>
 * @since   2017-03-11
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @filesource
 */
class ContactData {

  /**
   * @var mixed 
   */
  private $name;

  /**
   * @var mixed 
   */
  private $email;

  /**
   * @var mixed 
   */
  private $phone;

  /**
   * @var Person 
   */
  private $contacter;

  /**
   * @var mixed 
   */
  private $subject;

  /**
   * @var mixed 
   */
  private $message;

  /**
   * Constructs a new instance
   * 
   * @param array $data
   */
  public function __construct(array $data) {
    foreach ($data as $k => $v) {
      $this->{$k} = $v;
    }
    $this->contacter = new \Sphp\Data\Human\Person($data);
  }

  /**
   * 
   * @return mixed
   */
  public function getName() {
    return $this->name;
  }


  /**
   * 
   * @return mixed
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * 
   * @return boolean
   */
  public function hasPhoneNumber(): bool {
    return !empty($this->phone);
  }

  /**
   * 
   * @return mixed
   */
  public function getPhoneNumber() {
    return $this->phone;
  }

  function getSubject() {
    return $this->subject;
  }

  function getMessage() {
    return $this->message;
  }

}
