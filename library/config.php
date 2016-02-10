<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/*
 * SET UP custom variables
 */
setlocale(LC_MONETARY, 'en_US.UTF-8');

$site_logo='images/logo.png';
$site_logo_w='auto';
$site_logo_h='100%';
$site_custom_css='css/custom.css';

$site_name='<Your Site name>';
$site_url='<Your Site url>';
$site_mapsAPIKey='<Your Google Maps API KEY>';

$site_db_array=['dsn'=>'<Your DB DSN>','u'=>'<DB user>','p'=>'<DB Password>'] ;

include_once('class.PropertySearch.php');
$property_search=new PropertySearch($site_db_array);

