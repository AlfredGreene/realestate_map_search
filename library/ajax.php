<?php
error_reporting(E_ERROR);
ini_set('display_errors', 1);

/*
 * Handle AJAX call to return properties
 */
include_once('config.php');

$action=$_POST['action'];

switch($action)
{
    case 'getProperties':
       // $filter=$property_search->generateFilter($_REQUEST);

        $html=$property_search->getPropertiesHTML();
        $markers=$property_search->getProperties();
        $response=array('html'=>$html,'markers'=>$markers, 'count'=>count($markers));

        echo json_encode($response);

        break;
    default:
        echo json_encode('Incorrect request');
}