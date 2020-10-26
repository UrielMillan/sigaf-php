<?php
  header("Access-Control-Allow-Origin: *");
  require_once('Connection.php');

  $name = $_POST['name'];
  $userName = $_POST['username'];
  $password = $_POST['password'];
  $response['success'] = null;
  $response['message'] = '';

  try {
    $con = Connect();
    $sql = 'INSERT INTO users (name, username, password) VALUES (?, ?, MD5(?))';
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sss', $name, $userName, $password);
    $stmt->execute();
    $con->commit();
    $response['success'] = true;
    $response['message'] = 'new user added';
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
