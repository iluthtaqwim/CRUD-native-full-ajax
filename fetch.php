<?php

//fetch.php

include("database_connection.php");

$query = "SELECT * FROM karyawan";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$total_row = $statement->rowCount();
?>
<table id="data" class="table table-striped table-bordered data">
	<thead>
		<tr>
			<th>Nama</th>
			<th>Alamat</th>
			<th>Tanggal Lahir</th>
			<th>Jabatan</th>
			<th colspan=2 class="text-center">Action</th>
		</tr>
	</thead>
<?php
if($total_row > 0)
{
	foreach($result as $row)
	{
		echo'
		<tbody>
			<tr>
				<td width="40%">'.$row["nama"].'</td>
				<td width="40%">'.$row["alamat"].'</td>
				<td width="40%">'.$row["tgl_lahir"].'</td>
				<td width="40%">'.$row["jabatan"].'</td>
				<td width="10%">
					<button type="button" name="edit" class="btn btn-primary btn-xs edit" id="'.$row["id_karyawan"].'">Edit</button>
				</td>
				<td width="10%">
					<button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id_karyawan"].'">Delete</button>
				</td>
			</tr>
		
		';
	}
}
else
{
	echo'
		<tr>
			<td colspan="4" align="center">Data not found</td>
		</tr>
	</tbody>';

}
$output = '</table>';
echo $output;
?>

