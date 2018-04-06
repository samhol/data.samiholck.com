<?php

namespace Sphp\MVC;

use Sphp\Html\Foundation\Sites\Containers\ThrowableCallout;

$loadPage = function ($par, string $file = 'index') {
  //var_dump(func_get_args());
  try {
    ob_start();
    $page = "php/pages/$file.php";
    if (is_file($page)) {
      $class = $file;
      include $page;
      include 'php/templates/menus/siteNav.php';
    } else {
      $class = 'error';
      include "php/pages/error.php";
    }
    $content = ob_get_contents();
  } catch (\Throwable $e) {
    $content .= (new ThrowableCallout($e))->showInitialFile()->showTrace();
  } catch (\Exception $e) {
    $content .= (new ThrowableCallout($e))->showInitialFile()->showTrace();
  }
  ob_end_clean();
  echo "<main class=\"container $class\">$content</main>";
};

$loadNotFound = function () {
  echo '<main class="container error">';
  include "php/pages/error.php";
  echo '</main>';
};
$loadIndex = function () use ($loadPage) {
  $loadPage('index');
};

$router = (new Router())
        ->setDefaultRoute($loadNotFound)
        ->route('/', $loadIndex)
        ->route('/index.php', $loadIndex, 10)
        ->route('/<!category>', $loadPage, 9);
