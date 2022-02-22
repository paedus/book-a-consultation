<?php

if ( !defined( 'ABSPATH' ) ) exit;

define ('COMPONENTS_PATH', trailingslashit( get_stylesheet_directory() ).'templates/components/' );

define ('MISSING_IMAGE_PLACEHOLDER', 21826 );

define ('CURRENT_LANGUAGE',explode('_',strtolower(get_locale()))[1]);

define ( 'IS_DEFAULT_LANGUAGE', get_locale()==='en_US' );

define ( 'IS_PRODUCTION', $_SERVER['HTTP_HOST']==='elitevoyage.com' );
