<?php

namespace Sphp\Manual;

$birth = new \DateTime('1975-09-16 00:25 EET');
$now = new \DateTime();
$age = $now->diff($birth);

md(<<<MD
#WHO AM I? <small>...and does it matter?</small>

I am a $age->y years $age->m months and $age->d days old Finnish man.
I live in Turku with my common-law wife.
##Hobbies
I follow professional basketball, cycling and snooker. And I also enjoy practising first two of these sports myself.
        
Have you any questions or comments about these sites? ...
        
...Or Do you want to hire me to do Anything web related... back-end, front-end, testing...
        
Contact me if you do...
        
<hr>
MD
);

use Sphp\Html\Foundation\Sites\Containers\Modal;
use Sphp\Html\Document;

use Sphp\Html\Foundation\Sites\Grids\Row;
use Sphp\Html\Foundation\Sites\Media\ResponsiveEmbed;

$map = ResponsiveEmbed::iframe('https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1968.7082546795589!2d22.300856632547603!3d60.43352261303713!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x468c7727a6466e41%3A0xa7ad26a37594a821!2sRakuunatie+59%2C+20720+Turku!5e0!3m2!1sen!2sfi!4v1521810129616');
$g = new Row();
$g->layout()->usePadding();
$g->appendColumn(\Sphp\Stdlib\Filesystem::executePhpToString('contact-form/contacts.php'), ['small-12', 'large-6']);
$g->append($map)->layout()->setLayouts('small-12', 'large-6');
echo $g;
$modal = new Modal('<i class="far fa-envelope"></i> Contact form', '<div id="form-container"></div>');
$modal->getPopup()->addCssClass('contact-form-container')->prepend('<h2>Contact Form</h2>');
$contact = $modal->getTrigger()->addCssClass('button radius');
echo $modal;


$myContacts = new Modal('<i class="far fa-envelope"></i> Contact form', '<h2>Contact Form</h2>');
$myContacts->getPopup()->append('<div id="form-container"></div>');
$myContacts->getTrigger()->addCssClass('button radius');
echo $myContacts;
Document::body()->scripts()->appendSrc('contact-form/form.js');
//oadPage('contact');
//include 'samiholck/templates/carousels/videos.php';
?>
