<?php

/**
 * MembershipRequestCallout.php (UTF-8)
 * Copyright (c) 2017 Sami Holck <sami.holck@gmail.com>
 */

namespace Sphp\Manual\Contact;

use Sphp\Html\Foundation\Sites\Containers\Callout;
use Sphp\Html\Lists\Dl;

/**
 * Description of MembershipRequestCallout
 *
 * @author  Sami Holck <sami.holck@gmail.com>
 * @since   2017-05-05
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @filesource
 */
class MembershipRequestCallout extends AbstractComponentGenerator {

  /**
   *
   * @var MemberData 
   */
  private $memberData;

  public function __construct() {
    ;
  }

  public function getMemberData(): MemberData {
    return $this->memberData;
  }

  public function setMemberData(MemberData $memberData) {
    $this->memberData = $memberData;
    return $this;
  }

  protected function generateMemberData(): Dl {
    $dl = new Dl();
    $dl->addCssClass('member-data');
    $data = $this->getMemberData();
    $dob = $data->getDateOfBirth();
    if ($dob instanceof \DateTimeInterface) {
      $age = $dob->diff(new \DateTime('now'));
      if ($age->y < 18) {
        $dl->appendTerms("Juniorijäsen:");
        $dl->appendDescriptions("<strong>Ikä: </strong>{$age->y}-vuotias");
      } else {
        $dl->appendTerms("Aikuinen");
      }
      $dl->appendDescriptions('<strong>Syntymäaika: </strong>' . $dob->format('j.n.Y'));
    } else {
      $dl->appendTerms("Aikuinen");
      $dl->appendDescriptions('Syntymäaikaa ei annettu');
    }
    $dl->appendTerms('Nimi:');
    $dl->appendDescriptions("{$data->getFname()} {$data->getLname()}");
    $dl->appendTerms('Osoite:');
    $dl->appendDescriptions($data->getStreet());
    $dl->appendDescriptions("{$data->getZipcode()} {$data->getCity()}");
    $dl->appendTerms('Sähköpostiosoite:');
    $dl->appendDescriptions($data->getEmail());
    if ($data->hasPhoneNumber()) {
      $dl->appendTerms('Puhelinnumero:');
      $dl->appendDescriptions($data->getPhoneNumber());
    }
    if ($data->hasAdditionalInformation()) {
      $dl->appendTerms('Lisätiedot:');
      $dl->appendDescriptions($data->getAdditionalInformation());
    }
    return $dl;
  }

  public function generate(): \Sphp\Html\ContentInterface {
    $callout = new Callout();
    $callout->setClosable();
    $callout->setColor('success');
    $callout->addCssClass('membership-application small');
    $callout->appendMd('##Kiitos hakemuksestasi');
    $callout->appendMd("Käsittelemme jäsenhakemuksen mahdollisimman pian");
    $callout->append('<strong>Hakemuksen tiedot:</strong>');
    $callout->append($this->generateMemberData());
    //$callout->printHtml();
    return $callout;
  }

}
