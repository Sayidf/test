<?php

require_once("koneksi.php");

$request_method=$_SERVER["REQUEST_METHOD"];

switch($request_method)
	{
		case 'GET':
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				get_pasien_id($id);
			}
			else
			{
				get_pasien();
			}
		break;

    case 'POST':
      insert_pasien();
    break;
    
    case 'PUT':
      $id=intval($_GET["id"]);
      update_pasien($id);
    break;

    case 'DELETE':
      $id=intval($_GET["id"]);
      delete_pasien($id);
    break;

		default:
			header("HTTP/1.0 405 Method Not Allowed");
		break;
	}

  function get_pasien(){
    global $koneksi;

    $query="SELECT * FROM tb_pasien";
    $data=array();
    $result=mysqli_query($koneksi, $query);
    while($row=mysqli_fetch_object($result)){
      $data[]=$row;
    }
    $response=array(
      'status' => 1,
      'message' => "Fungsi Get Pasien Berhasil.",
      'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
  }  
  
  function get_pasien_id($id = 0){
    global $koneksi;

    $query="SELECT * FROM tb_pasien";
    if($id != 0){
      $query.=" WHERE id=".$id." LIMIT 1";
    }
    $data=array();
    $result=mysqli_query($koneksi, $query);
    while($row=mysqli_fetch_object($result)){
      $data[]=$row;
    }
    $response=array(
      'status' => 1,
      'message' => "Fungsi Get Pasien Berhasil.",
      'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
  }
  
  function insert_pasien(){
    global $koneksi;
    
    $data = json_decode(file_get_contents('php://input'), true);
    $nama=$data["nama"];
    $umur=$data["umur"];
    $jk=$data["jk"];
    $berat=$data["berat"];
    echo $query="INSERT INTO tb_pasien SET nama='".$nama."', umur='".$umur."', jk='".$jk."', berat='".$berat."'";
    if(mysqli_query($koneksi, $query)){
      $response=array(
      'status' => 1,
      'status_message' =>'Fungsi POST Pasien Berhasil.'
      );
    }
    else{
      $response=array(
      'status' => 0,
      'status_message' =>'Fungsi POST Pasien Gagal.'
      );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }

  function update_pasien($id){
    global $koneksi;

    $post_vars = json_decode(file_get_contents("php://input"), true);
    $nama=$post_vars["nama"];
    $umur=$post_vars["umur"];
    $jk=$post_vars["jk"];
    $berat=$post_vars["berat"];
    $query="UPDATE tb_pasien SET nama='".$nama."', umur='".$umur."', jk='".$jk."', berat='".$berat."' WHERE id=".$id;
    if(mysqli_query($koneksi, $query)){
      $response=array(
        'status' => 1,
        'status_message' =>'Fungsi UPDATE Pasien Berhasil.'
      );
    }
    else{
      $response=array(
        'status' => 0,
        'status_message' =>'Fungsi UPDATE Pasien Gagal.'
      );
    }
      header('Content-Type: application/json');
      echo json_encode($response);
    }  
  
  function delete_pasien($id){
    global $koneksi;
    
    $query="DELETE FROM tb_pasien WHERE id=".$id;
    if(mysqli_query($koneksi, $query)){
      $response=array(
        'status' => 1,
        'status_message' =>'Fungsi DELETE Pasien Berhasil.'
      );
    }
    else{
      $response=array(
        'status' => 0,
        'status_message' =>'Fungsi DELETE Pasien Gagal.'
      );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
  }
  

  
?>