<?php

namespace Sphp\Html\Foundation\Sites\Bars;
?>
<pre>
  <?php

  use Sphp\Data\DataObject;
  use Sphp\Data\Human\Person;
  use Sphp\Stdlib\Parser;

$do = new DataObject();
  $do->hasFoo();
  $do['foo'] = 'bar';
  echo "do[foo]: ".$do['foo'];
  var_dump($do->offsetExists('reflector'));
  $data = Parser::json()->decodeFromFile('http://www.samiholck.com/data/');
  // print_r($data);
  $person = new Person($data);
  print_r($person->toArray());

  use Sphp\Html\Lists\Ul;
  use Sphp\Html\Media\Icons\FontAwesome;
  ?>
</pre>
<ul class="fa-ul">
  <li>
    <span class="fa-li"><?php FontAwesome::user('Name')->printHtml() ?></span> 
    <?php echo $person->getFullname() ?></li>
  <li>
    <span class="fa-li"><?php FontAwesome::phone('phonenumber')->printHtml() ?></span> 
    <?php echo $person->getPhonenumber() ?></li>
  <li>
    <span class="fa-li"><?php FontAwesome::envelope('Email address')->printHtml() ?></span> 
    <?php echo $person->getEmail() ?></li>
  <li>
    <span class="fa-li"><?php FontAwesome::get('fa fa-map-marker-alt', 'Email address')->printHtml() ?></span> 
    <?php echo $person->getAddress() ?></li>
</ul>
