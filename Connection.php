<?php

  function Connect(){
    $db_host="localhost";
    $db_user="root";
    $db_password="";
    $db_database="sigaf";
    $db_port = '3306';

    mysqli_report(MYSQLI_REPORT_STRICT);
		$con = mysqli_connect($db_host,$db_user,$db_password,$db_database,$db_port);

    if(!mysqli_connect_errno()){
      $con -> set_charset("utf8");
      $con -> autocommit(false);
      return $con;
    }
    else{
      echo "Error de conexion" . mysqli_connect_error();
      exit();
    }
  }
 ?>
