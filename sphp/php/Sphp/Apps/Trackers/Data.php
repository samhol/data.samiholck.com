<?php

/**
 * SPHPlayground Framework (http://playgound.samiholck.com/)
 *
 * @link      https://github.com/samhol/SPHP-framework for the source repository
 * @copyright Copyright (c) 2007-2019 Sami Holck <sami.holck@gmail.com>
 * @license   https://opensource.org/licenses/MIT The MIT License
 */

namespace Sphp\Apps\Trackers;

use PDO;
use PDOException;
use Sphp\Exceptions\RuntimeException;
use Sphp\Exceptions\InvalidArgumentException;

/**
 * Description of DataSaver
 *
 * @author  Sami Holck <sami.holck@gmail.com>
 * @license https://opensource.org/licenses/MIT MIT License
 * @link    https://github.com/samhol/SPHP-framework Github repository
 * @filesource
 */
class Data implements \Countable {

  const ROW_ID = 'uid';
  const UID = 'uid';
  const FIRST_VISIT = 'firstVisit';
  const LAST_VISIT = 'lastVisit';
  const NUM_VISITS = 'visits';
  const IP = 'ip';
  const USER_AGENT = 'userAgent';
  const CLICKS = 'count';
  const VISITS = 'visits';

  /**
   * @var PDO
   */
  private $pdo;

  /**
   * @var UserData
   */
  private $usersController;

  /**
   * @var SiteDataController
   */
  private $urlDataController;

  /**
   * @var UserAgentDataController
   */
  private $uaStorage;

  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
    $this->usersController = new UserData($pdo);
    $this->urlDataController = new SiteDataController($pdo);
    $this->uaStorage = new UserAgentDataController($pdo);
  }

  public function __destruct() {
    unset($this->pdo, $this->usersController);
  }

  public function userAgents(): UserAgentDataController {
    return $this->uaStorage;
  }

  public function urls(): SiteDataController {
    return $this->urlDataController;
  }

  public function users(): UserData {
    return $this->usersController;
  }

  public function gettPdo(): PDO {
    $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $this->pdo;
  }

  public function contains(User $user): bool {
    $stmt = $this->gettPdo()->prepare('SELECT 1 FROM visitors WHERE uid = ? LIMIT 1');
    $stmt->execute([$user->getUID()]);
    return $stmt->fetchColumn() !== false;
  }

  public function getUserData(User $user): array {
    $rawQueryString = 'SELECT %1s, %2$s, %3$s, %4$s, %5$s, INET_NTOA(%6$s) as %6$s, %7$s FROM visitors WHERE %2$s=?';
    $queryString = vsprintf($rawQueryString, [self::ROW_ID, self::UID, self::FIRST_VISIT, self::LAST_VISIT, self::VISITS, self::IP, self::USER_AGENT]);
    $stmt = $this->gettPdo()->prepare($queryString); //'SELECT id, uid, firstVisit, lastVisit, visits, INET_NTOA(ip) as ip, browser FROM visitors WHERE uid=?');
    $stmt->execute([$user->getUID()]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result === false) {
      return [];
    }
    return $result;
  }


  public function getUrlData(User $user = null): array {
    try {
      if ($user === null) {
        $stmt = $this->gettPdo()->prepare("SELECT DISTINCT(url), COUNT(visitorID) AS userCount, SUM(count) AS visits FROM siteVisits group by url");
        $stmt->execute();
      } else {
        $stmt = $this->gettPdo()->prepare("SELECT * FROM siteVisits WHERE uid = ?");
        $stmt->execute([$user->getUID()]);
      }
      //$result = $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      throw new RuntimeException('Refresh counting failed', 0, $e);
    }
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }




  /**
   * Counts statistics data values
   * 
   * @param  string $field
   * @return int
   * @throws RuntimeException
   * @throws InvalidArgumentException
   */
  public function count(string $field = self::NUM_VISITS): int {
    try {
      if ($field === self::IP || $field === self::USER_AGENT) {
        $rawQueryString = 'SELECT COUNT(DISTINCT %s) as count FROM visitors';
      } else if ($field === self::UID) {
        $rawQueryString = 'SELECT COUNT(%s) as count FROM visitors';
      } else if ($field === self::NUM_VISITS) {
        $rawQueryString = 'SELECT SUM(%s) as count FROM visitors';
      } else if ($field === self::CLICKS) {
        $rawQueryString = 'SELECT SUM(%s) as count FROM siteVisits';
      } else {
        $message = vsprintf('Cannot count using parameter value (%s)', [$field]);
        throw new InvalidArgumentException($message, 0, $e);
      }
      $queryString = vsprintf($rawQueryString, [$field]);
      $stmt = $this->gettPdo()->prepare($queryString);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      $message = vsprintf('Cannot count using parameter value (%s)', [$field]);
      throw new RuntimeException($message, 0, $e);
    }
    if ($result->count === null) {
      $result->count = 0;
    }
    return $result->count;
  }

  public function countVisits(User $user = null): int {
    try {
      if ($user === null) {
        $stmt = $this->gettPdo()->prepare('SELECT SUM(visits) as visits FROM visitors');
        $stmt->execute();
      } else {
        $stmt = $this->gettPdo()->prepare('SELECT SUM(visits) as visits FROM visitors WHERE uid = ?');
        $stmt->execute([$user->getUID()]);
      }
      $result = $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      throw new RuntimeException('Visits counting failed', 0, $e);
    }
    return (int) $result->visits;
  }

  public function countRefreshes(User $user = null): int {
    try {
      if ($user === null) {
        $stmt = $this->gettPdo()->prepare('SELECT SUM(count) as refreshes FROM siteVisits');
        $stmt->execute();
      } else {
        $stmt = $this->gettPdo()->prepare('SELECT SUM(count) as refreshes FROM visitors, siteVisits WHERE visitors.uid = ? AND visitors.id = siteVisits.visitorID');
        $stmt->execute([$user->getUID()]);
      }
      $result = $stmt->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      throw new RuntimeException('Refresh counting failed', 0, $e);
    }
    return (int) $result->refreshes;
  }

  public function getStatisticsFor(string $dataField): array {
    try {
      $rawQueryString = 'SELECT %s, SUM(visits) as count FROM visitors GROUP BY %s';
      $queryString = vsprintf($rawQueryString, [$dataField, $dataField]);
      $stmt = $this->gettPdo()->prepare($queryString);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      throw new RuntimeException('Statistics could not be fetched', 0, $e);
    }
    return $result;
  }

}
