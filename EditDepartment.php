<?php
  header("Access-Control-Allow-Origin: *");
  require_once('Connection.php');

  $id = $_POST['id'];
  $code = $_POST['code'];
  $description = $_POST['description'];
  $note = $_POST['note'];
  $status = $_POST['status'];
  $response['success'] = null;
  $response['message'] = '';

  try {
    $con = Connect();
    $sql = 'UPDATE departments SET code=?, description=?, note=?, status=? WHERE id=?';
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sssii', $code, $description, $note, $status, $id);
    $stmt->execute();
    if($con->affected_rows > 0){
      $response['success'] = true;
      $response['message'] = 'department edited';
    }else {
      $response['success'] = false;
      $response['message'] = 'department not edited';
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
