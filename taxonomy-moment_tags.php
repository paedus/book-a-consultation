<?php

require_once 'templates/archive-product.php';

the_archive(array('accommodations', 'landing-page', 'landing-page-cities', 'moments'), true);