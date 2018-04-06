<?php

namespace Sphp\Html\Foundation\Sites\Navigation;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('php/settings.php');

use Sphp\Http\Headers\Headers;

// required header
$headers = new Headers();
$headers->allowOrigin('*');
$headers->allowMethods('POST', 'GET');
$headers->contentType('application/json; charset=UTF-8');
$headers->maxAge(1000);
$headers->execute();
header("Access-Control-Allow-Headers: X-Requested-With");

use Sphp\Stdlib\Parser;

$arr = Parser::fromFile('data/personal-info.yml');
$what = filter_input(INPUT_GET, 'get', FILTER_SANITIZE_STRING);
if ($what === null) {
  $data = $arr;
} else if (array_key_exists($what, $arr)) {
  $data[$what] = $arr[$what];
} else {
  $data = [];
}
$json = json_encode($data, JSON_PRETTY_PRINT);
echo $json;
//print_r(json_decode($json));
