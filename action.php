<?php

//action.php

include('database_connection.php');

if(isset($_POST["action"]))
{
	if($_POST["action"] == "insert")
	{
		$query = "
		INSERT INTO karyawan (nama, alamat, tgl_lahir, jabatan) VALUES ('".$_POST["nama"]."', '".$_POST["alamat"]."', '".$_POST["tgl"]."', '".$_POST["jabatan"]."')
		";
		$statement = $koneksi->prepare($query);
		$statement->execute();
		echo '<p>Data Inserted...</p>';
	}
	if($_POST["action"] == "fetch_single")
	{
		$query = "
		SELECT * FROM karyawan WHERE id_karyawan = '".$_POST["id"]."'
		";
		$statement = $koneksi->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		{
			$output['nama'] = $row['nama'];
            $output['alamat'] = $row['alamat'];
			$output['tgl_lahir'] = $row['tgl_lahir'];
			$output['jabatan'] = $row['jabatan'];
		}
		echo json_encode($output);
    }
    
	if($_POST["action"] == "update")
	{
		$query = "
		UPDATE karyawan 
		SET nama = '".$_POST["nama"]."', 
        alamat = '".$_POST["alamat"]."',
        tgl_lahir = '".$_POST["tgl"]."',
        jabatan = '".$_POST["jabatan"]."'
		WHERE id_karyawan = '".$_POST["hidden_id"]."'
		";
		$statement = $koneksi->prepare($query);
		$statement->execute();
		echo '<p>Data Updated</p>';
	}
	if($_POST["action"] == "delete")
	{
		$query = "DELETE FROM karyawan WHERE id_karyawan = '".$_POST["id"]."'";
		$statement = $koneksi->prepare($query);
		$statement->execute();
		echo '<p>Data Deleted</p>';
	}
}

?>
