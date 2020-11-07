<?php
  header("Access-Control-Allow-Origin: *");
  require_once('Connection.php');

  $response['success'] = null;
  $response['data'] = array();

  try {
    $con = Connect();
    $sql='SELECT id, code, description, note, status FROM brands';
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $data= array();
    while($row = $result->fetch_assoc()){
      array_push($data, $row);
    }
    $response['success'] = true;
    $response['data'] = $data;
  } catch (mysqli_sql_exception $e) {
    echo "Error: " . $e->getMessage();
    $response['success'] = false;
    $response['data'] = null;
  }finally{
    mysqli_close($con);
    echo json_encode($response);
  }

?>
