<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
  require_once('Connection.php');

  $userName = $_POST['username'];
  $pass = $_POST['pass'];
  $response['success']=null;
  $response['data']=null;
  try {
    $con = Connect();
    $data;
    $query = "SELECT id, name, usertype FROM users WHERE username=? AND pass=MD5(?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ss', $userName, $pass);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
      while ($row = $result->fetch_object()) {
        $data['id']= $row->id;
        $data['name']= $row->name;
        $data['usertype']= $row->usertype;
        $response['data']=$data;
      }
      $response['success'] = true;
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
