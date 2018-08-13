<?php
  $host = '127.0.0.1';
  $user = 'root';
  $password = '';
  $db = 'ecommerce';

  $dbconnection = mysqli_connect($host,$user,$password,$db);

  if(mysqli_connect_errno()){
    echo 'Database connection failed with following errors: ' . mysqli_connect_error();
    die();
  }

//require_once('../ecommerce/config.php');
require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/ecommerce/config.php');
require_once BASEURL.'helpers/helpers.php';
