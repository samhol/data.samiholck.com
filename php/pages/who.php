<?php

namespace Sphp\Manual;

$birth = new \DateTime('1975-09-16 00:25 EET');
$now = new \DateTime();
$age = $now->diff($birth);

md(<<<MD
#WHO AM I? <small>...and does it matter?</small>

I am a $age->y years $age->m months and $age->d days old Finnish man.
I live in Turku with my common-law wife.
        
Do you want to hire me to do Anything web related... back-end, front-end, testing...
        
Contact me if you do...
        
<hr>
MD
);
//oadPage('contact');
//include 'samiholck/templates/carousels/videos.php';
?>
