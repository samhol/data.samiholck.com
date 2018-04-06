<?php

/**
 * InvalidStateException.php (UTF-8)
 * Copyright (c) 2017 Sami Holck <sami.holck@gmail.com>
 */

namespace Sphp\Html\Exceptions;

use Exception;

/**
 * Indicates the current state of an HTML object involved is invalid
 *
 * @author  Sami Holck <sami.holck@gmail.com>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @filesource
 */
class InvalidStateException extends Exception implements HtmlException {
  
}
