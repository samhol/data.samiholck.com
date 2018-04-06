<?php

/**
 * Address.php (UTF-8)
 * Copyright (c) 2011 Sami Holck <sami.holck@gmail.com>
 */

namespace Sphp\Data;

use Sphp\Stdlib\Datastructures\Arrayable;
use Sphp\Stdlib\Strings;

/**
 * Implements a geographical address
 *
 * @author  Sami Holck <sami.holck@gmail.com>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @filesource
 */
class Address implements GeographicalAddress, Arrayable {

  /**
   * @var string|null
   */
  protected $street;

  /**
   * @var string|null
   */
  protected $zipcode;

  /**
   *
   * @var string|null
   */
  protected $city;

  /**
   * @var string|null
   */
  protected $country;

  /**
   * @var string|null
   */
  protected $maplink = [];

  public function __construct(array $data = []) {
    $this->fromArray($data);
  }

  public function getStreet() {
    return $this->street;
  }

  public function setStreet(string $streetaddress = null) {
    $this->street = $streetaddress;
    return $this;
  }

  public function hasZipcode(): bool {
    return Strings::isEmpty($this->zipcode);
  }

  public function getZipcode() {
    return $this->zipcode;
  }

  public function setZipcode(string $zipcode = null) {
    $this->zipcode = $zipcode;
    return $this;
  }

  public function hasCity(): bool {
    return Strings::isEmpty($this->zipcode);
  }

  public function getCity() {
    return $this->city;
  }

  public function setCity(string $city = null) {
    $this->city = $city;
    return $this;
  }

  public function getCountry() {
    return $this->country;
  }

  public function setCountry(string $country = null) {
    $this->country = $country;
    return $this;
  }

  public function getMaplinks(): array {
    return $this->maplink;
  }

  public function setMaplinks(array $maplink = []) {
    $this->maplink = $maplink;
    return $this;
  }

  public function fromArray(array $raw = []) {
    $args = [
        'street' => \FILTER_SANITIZE_STRING,
        'zip' => \FILTER_SANITIZE_STRING,
        'city' => \FILTER_SANITIZE_STRING,
        'country' => \FILTER_SANITIZE_STRING,
        'maplinks' => array(
            'filter' => FILTER_REQUIRE_ARRAY,
            'flags' => FILTER_FORCE_ARRAY,
        )
    ];
    $address = filter_var_array($raw, $args, true);
    $this->setStreet($address['street']);
    $this->setZipcode($address['zip']);
    $this->setCity($address['city']);
    $this->setCountry($address['country']);
    if ($address['maplinks'] !== null) {
      $this->setMaplinks($address['maplinks']);
    }
    return $this;
  }

  public function toArray(): array {
    return get_object_vars($this);
  }

  public function toJson(): string {
    return json_encode($this->toArray());
  }

  /**
   * Returns the string representation of the object
   *
   * @return string the string representation of the object
   */
  public function __toString(): string {
    $address = $this->getStreet();
    if ($this->hasZipcode()) {
      $address .= ', ' . $this->getZipcode();
    }
    $address .= ' ' . $this->getCity();
    $address .= ', ' . $this->getCountry();
    return $address;
  }

  public function equals($object) {
    return $object == $this;
  }

}
