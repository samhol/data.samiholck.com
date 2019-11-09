<?php

/**
 * SPHPlayground Framework (http://playgound.samiholck.com/)
 *
 * @link      https://github.com/samhol/SPHP-framework for the source repository
 * @copyright Copyright (c) 2007-2018 Sami Holck <sami.holck@gmail.com>
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Sphp\Html\Media;

use Sphp\Html\Content;

/**
 * Defines sizing of HTML media components
 *
 * @author  Sami Holck <sami.holck@gmail.com>
 * @license https://opensource.org/licenses/MIT The MIT License
 * @filesource
 */
interface SizeableMedia extends Content {



  /**
   * Sets the width of the component (in pixels)
   * 
   * @param  int $width the width of the component (in pixels))
   * @return $this for a fluent interface
   */
  public function setWidth(int $width = null);




  /**
   * Sets the height of the component (in pixels)
   * 
   * @param  int $height the height of the component (in pixels)
   * @return $this for a fluent interface
   */
  public function setHeight(int $height = null);

}
