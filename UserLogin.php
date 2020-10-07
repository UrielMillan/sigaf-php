<?php
  header("Access-Control-Allow-Origin: *");
  require_once('Connection.php');

  $userName = $_POST['username'];
  $password = $_POST['password'];
  $response['success']=null;
  $response['data']=null;

  try {
    $con = Connect();
    $data = array();
    $query = "SELECT id_usuario, nombre from usuarios WHERE (usuario = ? and password = MD5(?))";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ss', $userName, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
      while ($row = $result->fetch_assoc()) {
        array_push($data,$row);
      }
      $response['success'] = true;
      $response['data'] = $data;
    }else{
      $response['success'] = false;
    }
  } catch (mysqli_sql_exception $e) {
    echo "Error: ". $e->getMessage();
    $response['success'] = false;
  } finally{
    mysqli_close($con);
    echo json_encode($response);
  }

 ?>
