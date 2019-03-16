<?php

	require('connection.php');

	$id = $_GET['user_id'];

		if(isset($_GET['role']) && $_GET['role'] == 'admin'){
		
			$query = mysqli_query($con,"SELECT * FROM `wp_payment` ");
			
		}else{
			$query = mysqli_query($con,"SELECT * FROM `wp_payment` WHERE `user_id` = $id");	
		}		


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="wp-heading-inline">
				Payments</h3>
		    	<table id="example" class="table table-striped table-bordered" style="width:100%">
		            <thead>
		                <tr>
		                    <th>Payment id</th>
		                    <th>File</th>
		                    <th>User</th>
		                    <th>Payment</th>
		                    <th>Date</th>
		                </tr>
		            </thead>
		            <tbody>
						<?php
						if(mysqli_num_rows($query) > 0){
							while($row = mysqli_fetch_array($query)){
								$session_id = $row['session_id'];
								$user_id = $row['user_id'];
								?>
								<tr>
									<td><?= $row['payment_id']; ?></td>
									<?php
										$fetch_file = mysqli_query($con,"SELECT * FROM `session_compiled` WHERE session_id = '$session_id' ORDER BY session_comp_id DESC LIMIT 1");

										if(mysqli_num_rows($fetch_file) > 0){
											?>
												<td>
													<a href="<?= mysqli_fetch_assoc($fetch_file)['url_file']; ?>"><button class="btn btn-primary">Download</button></a>
													</td>
											<?php
										}else{
											?>
											<td>No Data</td>
											<?php
										}

										$fetch_user = mysqli_query($wp_con,"SELECT * FROM `wp_users` WHERE id = $user_id ");
										if(mysqli_num_rows($fetch_user) > 0){
											?>
											<td><?= mysqli_fetch_assoc($fetch_user)['user_nicename']; ?></td>
											<?php
										}else{
											?>
											<td>No Data</td>
											<?php
										}
									?>

									<td> <?= !empty($row['payment_amount']) ? $row['payment_amount']." £": "no Data" ?>
									</td>
									<td><?= $row['date']; ?></td>
								</tr>

								<?php
							}
						}
						else{
							echo "no data";
						}
						?>
		            </tbody>
		        </table>
				
			</div>
		</div>		
	</div>
	

	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
	<script>

		$(document).ready(function() {
		    $('#example').DataTable();
		} );
	</script>
</body>
</html>
