<?php
  header("Access-Control-Allow-Origin: *");
  require_once('Connection.php');

  $code = $_POST['code'];
  $description = $_POST['description'];
  $note = $_POST['note'];
  $response['success'] = null;
  $response['message'] = '';

  try {
    $con = Connect();
    $sql = 'INSERT INTO categories (code, description, note) VALUES (?, ?, ?)';
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sss', $code, $description, $note);
    $stmt->execute();
    $con->commit();
    $response['success'] = true;
    $response['message'] = 'new category added';
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
