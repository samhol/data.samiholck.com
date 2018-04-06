<?php

namespace Sphp\Config;

use Sphp\Stdlib\Networks\URL;

Config::instance()->set('CURRENT_URL', URL::getCurrentURL());
Config::instance()->set('ROOT_URL', 'http://data.samiholck.com/'); 
