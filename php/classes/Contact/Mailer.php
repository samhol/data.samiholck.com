<?php

/**
 * ContactMailer.php (UTF-8)
 * Copyright (c) 2017 Sami Holck <sami.holck@gmail.com>
 */

namespace Sphp\Manual\Contact;

use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;
use Sphp\Exceptions\Exception;

/**
 * 
 *
 * @author  Sami Holck <sami.holck@gmail.com>
 * @since   2017-03-11
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @filesource
 */
class Mailer {

  /**
   * @var Message
   */
  private $message;

  /**
   * Constructs a new instance
   *
   * @param Message $message
   */
  public function __construct(Message $message = null) {
    if ($message === null) {
      $message = new Message();
      $message->setEncoding('UTF-8');
    }
    $this->setMessage($message);
    $this->sendmail = new Sendmail();
  }

  public function setFrom($email) {
    $this->message->setFrom($email);
    return $this;
  }

  public function setTo(string...$email) {
    $this->message->setTo($email);
    return $this;
  }

  public function setSubject(string $subject) {
    $this->message->setSubject($subject);
    return $this;
  }

  public function setBody(string $body) {
    $this->message->setBody($body);
    return $this;
  }

  /**
   * 
   * @return Message
   */
  public function getMessage(): Message {
    return $this->message;
  }

  /**
   * 
   * @param  Message $message
   * @return self for a fluent interface
   */
  public function setMessage(Message $message) {
    $this->message = $message;
    return $this;
  }

  /**
   * 
   * @return bool
   */
  public function containsValidMessage(): bool {
    return $this->message->isValid();
  }

  /**
   * 
   * @return self for a fluent interface
   * @throws Exception if the message is not valid
   */
  public function send() {
    if (!$this->containsValidMessage()) {
      throw new Exception('Sending interupted: Message is invalid');
    }
    $this->sendmail->send($this->message);
    return $this;
  }

}
