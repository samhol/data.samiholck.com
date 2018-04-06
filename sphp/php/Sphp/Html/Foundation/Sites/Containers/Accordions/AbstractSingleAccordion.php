<?php

/**
 * AbstractSingleAccordion (UTF-8)
 * Copyright (c) 2016 Sami Holck <sami.holck@gmail.com>
 */

namespace Sphp\Html\Foundation\Sites\Containers\Accordions;

use Sphp\Html\AbstractComponent;

/**
 * Implements a single accordion component
 *
 * @author  Sami Holck <sami.holck@gmail.com>
 * @link    http://foundation.zurb.com/ Foundation
 * @link    http://foundation.zurb.com/sites/docs/accordion.html Foundation Accordion
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPLv3
 * @filesource
 */
class AbstractSingleAccordion extends AbstractComponent {

  /**
   * @var PaneInterface
   */
  private $pane;
  
  /**
   * Constructs a new instance
   *
   * @param PaneInterface|null $pane the inner pane component or null
   */
  public function __construct(PaneInterface $pane = null) {
    if ($pane === null) {
      $pane = new Pane();
    }
    parent::__construct('ul');
    $this->cssClasses()->protect('accordion');
    $this->attributes()
            ->protect('data-allow-all-closed', "true")
            ->demand('data-accordion');
    $this->pane = $pane;
  }

  /**
   * Returns the inner pane component
   *
   * @return PaneInterface the inner pane component
   */
  protected function getPane() {
    return $this->pane;
  }

  /**
   * Sets the title of the pane
   *
   * @param  mixed|mixed[] $title the title of the pane
   * @return $this for a fluent interface
   */
  public function setPaneTitle($title) {
    $this->getPane()->setPaneTitle($title);
    return $this;
  }

  /**
   * Sets the visibility of the pane after initialization
   *
   * @param  boolean $visibility true if the pane is visible, false otherwise
   * @return $this for a fluent interface
   */
  public function contentVisible($visibility = true) {
    $this->getPane()->contentVisible($visibility);
    return $this;
  }

  public function contentToString(): string {
    return $this->pane->getHtml();
  }

}
