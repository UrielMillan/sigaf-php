<?php
  header("Access-Control-Allow-Origin: *");
  require_once('Connection.php');

  $id = $_POST['id'];
  $name = $_POST['name'];
  $userName = $_POST['username'];
  $password = $_POST['password'];
  $status = $_POST['status'];
  $response['success'] = null;
  $response['message'] = '';

  try {
    $con = Connect();
    $sql = 'UPDATE users SET name=?, username=?, PASSWORD=MD5(?), status=? WHERE id=?';
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sssii', $name, $userName, $password, $status, $id);
    $stmt->execute();
    if($con->affected_rows > 0){
      $response['success'] = true;
      $response['message'] = 'user edited';
    }else {
      $response['success'] = false;
      $response['message'] = 'user not edited';
    }
    $con->commit();
  } catch (mysqli_sql_exception $e) {
    $con->rollBack();
    echo "Error: " . $e->getMessage();
    $response['success'] = false;
    $response['message'] = 'Error';
  } finally{
    mysqli_close($con);
    echo json_encode($response);
  }

 ?>
