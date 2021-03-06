<?php

/**
 * SPHPlayground Framework (http://playgound.samiholck.com/)
 *
 * @link      https://github.com/samhol/SPHP-framework for the source repository
 * @copyright Copyright (c) 2007-2019 Sami Holck <sami.holck@gmail.com>
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Sphp\Apps\Trackers;

use Sphp\Html\Tables\Table;
use Sphp\Html\Lists\Ul;
use Sphp\Html\Navigation\A;

/**
 * Description of VisitsView
 *
 * @author samih
 */
class VisitsView {

  /**
   * @var Data 
   */
  private $data;

  public function __construct(Data $data) {
    $this->data = $data;
  }

  public function buildPersonalData(User $user) {
    $table = new \Sphp\Html\Tables\Table;
    $table->setCaption('Sites clicked');
    $table->useThead()->thead()->appendHeaderRow(['URL:', 'total visits:']);
    foreach ($this->data->getUrlData() as $urlData) {
      $table->useTbody()->tbody()->appendBodyRow([$urlData->url, $urlData->visits]);
    }
    $table->useTfoot()->tfoot()->appendHeaderRow(['foo']);
    echo $table;
  }

  public function buildTotals(): Ul {
    $totals = new Ul;
    $totals->appendMd("__Individual Users:__`" . $this->data->count(Data::UID) . '`', true);
    $totals->appendMd("__Individual IPs:__`" . $this->data->count(Data::IP) . '`', true);
    $totals->appendMd("__User Visits:__`" . $this->data->count(Data::NUM_VISITS) . '`', true);
    $totals->appendMd("__User Clicks:__`" . $this->data->count(Data::CLICKS) . '`', true);
    $totals->appendMd("__Individual User Agents:__`" . $this->data->userAgents()->count() . '`', true);
    return $totals;
  }

  public function buildSiteTable(bool $validUrls = true): Table {
    $table = new Table;
    $table->useThead()->thead()->appendHeaderRow(['URL:', 'Individual users:', 'total visits:']);
    $table->useTbody();
    foreach ($this->data->urls()->getstatsFor($validUrls) as $urlData) {
      $table->tbody()->appendBodyRow([$this->buildPathLink($urlData->url), $urlData->userCount, $urlData->hits]);
    }
    // $table->useTfoot()->tfoot()->appendHeaderRow(['foo']);
    return $table;
  }

  public function buildPathLink(string $path): A {
    return new A($path, '<span class="icon"><i class="fas fa-link"></i></span> <span class="path">' . $path . '</span>');
  }

}
