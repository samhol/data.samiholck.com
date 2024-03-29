<?php

namespace Sphp\Stdlib;

require_once('../sphp/settings.php');

header('Content-type: image/svg+xml');

//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$showDefs = filter_input(INPUT_GET, 'defs', FILTER_VALIDATE_BOOLEAN);
?>
<svg class="local" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid meet" xmlns="http://www.w3.org/2000/svg"
     xmlns:xlink="http://www.w3.org/1999/xlink">
       <?php if (isset($_GET['defs'])): ?>
    <defs>
      <linearGradient id="s-logo-gradient" x1="0%" y1="0%" x2="0%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#FF8000" stop-opacity="1"/>
        <stop offset="100%" stop-color="#333" stop-opacity="1"/>
      </linearGradient>
    </defs>
  <?php endif; ?>
  <g transform="translate(0.000000,100.000000) scale(0.100000,-0.100000)" style="fill:url(#s-logo-gradient);
     stroke: #005000;
     stroke-width: 3;">
    <path class="sphp-center" d="M465 966 c-81 -36 -121 -137 -112 -280 8 -127 21 -160 98 -241 80 -85 89 -101 89 -159 0 -102 -80 -116 -157 -28 l-33 37 0 -107 0 -106 33 -21 c76 -47 178 -30 225 37 49 68 65 216 37 327 -17 64 -39 98 -104 160 -57 54 -85 109 -77 153 13 83 80 96 154 29 l22 -20 0 96 c0 93 -1 97 -26 113 -34 23 -111 28 -149 10z"/>
    <path class="sphp-left" d="M158 471 c-103 -99 -108 -106 -108 -145 0 -39 5 -46 110 -144 l110 -104 0 60 0 59 -76 63 -77 64 77 70 77 71 -3 55 -3 55 -107 -104z"/>
    <path class="sphp-right" d="M731 518 l-2 -53 76 -65 c41 -36 75 -68 75 -71 0 -4 -34 -34 -75 -68 l-75 -62 0 -55 c0 -30 3 -54 8 -54 4 0 53 46 110 103 138 138 138 137 -1 275 -56 56 -105 102 -108 102 -3 0 -6 -24 -8 -52z"/>
  </g>
</svg>
