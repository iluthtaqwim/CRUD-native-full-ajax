<html>

<head>
	<title>PHP Ajax Crud using JQuery UI Dialog</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js">
	</script>
	<link rel="stylesheet" href="jquery-ui.css">
	<script src="jquery-ui.js"></script>
</head>

<body>
	<div class="container">
		<br />

		<h3 align="center">PHP Ajax Crud using JQuery UI Dialog</a></h3><br />
		<br />
		<div align="right" style="margin-bottom:5px;">
			<button type="button" name="add" id="add" class="btn btn-success btn-xs">Add</button>
		</div>
		<div class="table-responsive" id="user_data">
			<table class="table" id="tabel-data">
				<thead>
					<tr>
						<th>Nama</th>
						<th>Alamat</th>
						<th>Tanggal Lahir</th>
						<th>Jabatan</th>
						<th colspan=2 class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					include 'database_connection.php';
					$query = "SELECT * FROM karyawan";

					$employee = mysqli_query($koneksi, $query);
					while ($row = mysqli_fetch_array($employee)) {
						echo "<tr>
            <td>" . $row['nama'] . "</td>
            <td>" . $row['alamat'] . "</td>
            <td>" . $row['tgl_lahir'] . "</td>
			<td>" . $row['jabatan'] . "</td>
			
        </tr>";
					}
					?>
				</tbody>

			</table>
		</div>
		<br />
	</div>



	<div id="user_dialog" title="Add Data">
		<form method="post" id="user_form">
			<div class="form-group">
				<label>Nama</label>
				<input type="text" name="nama" id="nama" class="form-control" />
				<span id="error_nama" class="text-danger"></span>
			</div>
			<div class="form-group">
				<label>Alamat</label>
				<input type="text" name="alamat" id="alamat" class="form-control" />
				<span id="error_alamat" class="text-danger"></span>
			</div>
			<div class="form-group">
				<label>Tanggal Lahir</label>
				<input type="date" name="tgl" id="tgl" class="form-control" />
				<span id="error_tgl" class="text-danger"></span>
			</div>
			<div class="form-group">
				<label>Jabatan</label>
				<input type="text" name="jabatan" id="jabatan" class="form-control" />
				<span id="error_jabatan" class="text-danger"></span>
			</div>
			<div class="form-group">
				<input type="hidden" name="action" id="action" value="insert" />
				<input type="hidden" name="hidden_id" id="hidden_id" />
				<input type="submit" name="form_action" id="form_action" class="btn btn-info" value="Insert" />
			</div>
		</form>
	</div>



	<div id="action_alert" title="Action">

	</div>

	<div id="delete_confirmation" title="Confirmation">
		<input type="hidden" name="id_delete">
		<p>Are you sure you want to Delete this data?</p>
	</div>

</body>

</html>



<script>
	$(document).ready(function() {


		$('#tabel-data').DataTable();
		load_data();

		function load_data() {

			$.ajax({
				url: "http://localhost/sekolah/api/coba",
				method: "get",
				dataType: 'json',
				success: function(data) {
					$('#hali').html(data);
					console.log(data);
				}
			});
		}

		$("#user_dialog").dialog({
			autoOpen: false,
			width: 400
		});

		$('#add').click(function() {
			$('#user_dialog').attr('title', 'Add Data');
			$('#action').val('insert');
			$('#form_action').val('Insert');
			$('#user_form')[0].reset();
			$('#form_action').attr('disabled', false);
			$("#user_dialog").dialog('open');
		});

		$('#user_form').on('submit', function(event) {
			event.preventDefault();
			var error_nama = '';
			var error_alamat = '';
			var error_tgl = '';
			var error_jabatan = '';
			if ($('#nama').val() == '') {
				error_nama = 'Name is required';
				$('#error_nama').text(error_nama);
				$('#nama').css('border-color', '#cc0000');
			} else {
				error_nama = '';
				$('#error_nama').text(error_nama);
				$('#nama').css('border-color', '');
			}
			if ($('#alamat').val() == '') {
				error_alamat = 'Alamat is required';
				$('#error_alamat').text(error_alamat);
				$('#alamat').css('border-color', '#cc0000');
			} else {
				error_alamat = '';
				$('#error_alamat').text(error_alamat);
				$('#alamat').css('border-color', '');
			}
			if ($('#tgl').val() == '') {
				error_tgl = 'Tanggal lahir is required';
				$('#error_tgl').text(error_tgl);
				$('#tgl').css('border-color', '#cc0000');
			} else {
				error_tgl = '';
				$('#error_tgl').text(error_tgl);
				$('#alamat').css('border-color', '');
			}
			if ($('#jabatan').val() == '') {
				error_jabatan = 'Jabatan is required';
				$('#error_jabatan').text(error_jabatan);
				$('#jabatan').css('border-color', '#cc0000');
			} else {
				error_jabatan = '';
				$('#error_jabatan').text(error_jabatan);
				$('#jabatan').css('border-color', '');
			}

			if (error_nama != '' || error_alamat != '' || error_tgl != '' || error_jabatan != '') {
				return false;
			} else {
				$('#form_action').attr('disabled', 'disabled');
				var form_data = $(this).serialize();
				$.ajax({
					url: "http://localhost/sekolah/api/coba",
					method: "POST",
					data: form_data,
					success: function(data) {
						$('#user_dialog').dialog('close');
						$('#action_alert').html(data);
						$('#action_alert').dialog('open');
						load_data();
						$('#form_action').attr('disabled', false);
					}
				});
			}

		});

		$('#action_alert').dialog({
			autoOpen: false
		});


		$(document).on('click', '.edit', function() {
			var id = $(this).attr('id');
			var action = 'fetch_single';
			$.ajax({
				url: "action.php",
				method: "POST",
				data: {
					id: id,
					action: action
				},
				dataType: "json",
				success: function(data) {
					$('#nama').val(data.nama);
					$('#alamat').val(data.alamat);
					$('#tgl').val(data.tgl_lahir);
					$('#jabatan').val(data.jabatan);
					$('#user_dialog').attr('title', 'Edit Data');
					$('#action').val('update');
					$('#hidden_id').val(id);
					$('#form_action').val('Update');
					$('#user_dialog').dialog('open');
				}
			});
		});

		$('#delete_confirmation').dialog({
			autoOpen: false,
			modal: true,
			buttons: {
				Ok: function() {
					var id = $('[name="id_delete"]').val();
					var action = 'delete';
					console.log(id);
					$.ajax({
						url: "action.php",
						method: "POST",
						data: {
							id: id,
							action: action
						},
						success: function(data) {
							$('#delete_confirmation').dialog('close');
							$('#action_alert').html(data);
							$('#action_alert').dialog('open');
							load_data();
						}
					});
				},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});

		$(document).on('click', '.delete', function() {
			var id = $(this).attr("id");
			$('[name="id_delete"]').val(id);
			$('#delete_confirmation').data('id_karyawan', id).dialog('open');
		});

	});
</script>