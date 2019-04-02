<?php session_start(); ?>
<?php error_reporting(E_ALL); ?>
<?php
	require_once('stripe-php/init.php');
?>

<?php
	
	// require(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-authenticate.php');
	require('connection.php');
	
	
	global $lang_id;
	$lang_ob = mysqli_query($con,"SELECT * FROM `languajes` WHERE `DEFAULT`='1'");
	$lang_id = mysqli_fetch_assoc($lang_ob)['LANGUAJE_ID'];
	function encodes($text) {
				
				if ($GLOBALS['lang_id'] == 'ES') {
					// $text = htmlentities($text, ENT_QUOTES, "ISO-639-1");
					// $text = htmlentities($text, ENT_QUOTES, "ISO-8859-1");
					$text = htmlspecialchars($text, ENT_NOQUOTES, 'ISO-8859-1');
					$text = html_entity_decode($text);
					return $text;
				} else {
					return $text;
				}
			}
// echo encodes("Telefonía Elemento para validar la entrada/salida cuando se produce en mercado un cruce de medias móviles.");
?>

<?php if ($_SERVER['REQUEST_METHOD'] !== 'POST'): 

		foreach($_SESSION as $key => $value){
			if (strpos($key, 'previousID') !== false) {
			unset($_SESSION[$key]);
			}
		}
	
	 endif; ?>
	
<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
<?php 	

		if ( $_GET['action'] === 'save_data' ) {		

		$user_id = 0;
		// $user_id = get_current_user_id();
		$open_scenario = $_POST['OPEN'];
		$modify_scenario = $_POST['MODIFY'];
		$close_scenario = $_POST['CLOSE'];


        $userAlready = $con->query("SELECT * FROM session_strategy WHERE user_id = '$user_id'");

        if (mysqli_num_rows($userAlready) > 0) {
        	$sql = "UPDATE session_strategy set `open_scenario`='$open_scenario', `close_scenario`= '$close_scenario', `modify_scenario` = '$modify_scenario' WHERE user_id = '$user_id' ";
        } else {
    	    $sql = "INSERT INTO session_strategy (`user_id`, `open_scenario`, `close_scenario`, `modify_scenario`)
			VALUES ( '$user_id', '$open_scenario', '$close_scenario', '$modify_scenario' );";
        }
	    $con->query($sql);
	    
	     if($open_scenario == null && $modify_scenario == null && $close_scenario == null){
	    	$response = "";
	    }
	    else{
	    	$response = $_POST;
	    }
var_dump($response);
	}
	else if($_GET['action'] == 'validate_data'){
		$user_id = 0;
		
				// $user_id = get_current_user_id();
				$ticker = $_POST['ticker'];
				$timeFrame = $_POST['time_frame'];
				$start_time = $_POST['start-date'];
				$end_time = $_POST['end-date'];
				$session_strategy_id = $_POST['session_strategy_id'];
				$status = 'N';

		    	$sql = "INSERT INTO session_validation (user_id, `session_strategy_id`, `ticker_id`, `timeframe_id`, `start_time`, `end_time`, `estatus`)
					 VALUES ( '$user_id', '$session_strategy_id', '$ticker', '$timeFrame', '$start_time', '$end_time', '$status' )";
		        
			    $con->query($sql);

			    $last_validation_id = $con->insert_id;
			    
			   	echo $last_validation_id;
	}

	
	// OLD CODE DYNAMIC GRAPH
		// else if($_GET['action'] == 'chart_data') {
		// 	$sesion_val_id = $_POST['sesion_val_id'];
		   	
		// 	$sesion_validation_id = preg_replace( "/\r|\n/", "", $sesion_val_id );
		// 	$status = mysqli_query($con,"SELECT * FROM `session_validation` WHERE `session_validation_id`= ".$sesion_validation_id."");
		// 		$fetching_date = mysqli_fetch_assoc($status);
	    	
	 //    	$getStauts = $fetching_date['estatus'];
	 //    	$report = $fetching_date['result_report'];
	  		
		    	
	 //    	if($getStauts == 'P' || $getStauts == 'F'){
		// 		if($_SESSION[$sesion_val_id.'previousID'] == NULL) {
			    	
		// 	    	$validation_id = mysqli_query($con,"SELECT * FROM session_validation_chart WHERE sesion_val_id = $sesion_val_id LIMIT 1");
		// 		} 
		// 		else{
		// 			$prevCharId = $_SESSION[$sesion_val_id.'previousID'];
		// 			$prev_id_array = '';
		// 			foreach ($prevCharId as $key => $value) {
		// 				$prev_id_array .= $value.',';
		// 			}
		// 			$not_in_list = substr($prev_id_array, 0, -1);			
		// 			$validation_id = mysqli_query($con,"SELECT * FROM session_validation_chart WHERE sesion_val_id = $sesion_val_id AND chart_seq NOT IN (".$not_in_list.") LIMIT 1");
		// 		}
		//     	if(mysqli_num_rows($validation_id) > 0 ){
		
		// 			$fetch_data = mysqli_fetch_assoc($validation_id);
		// 	    	$y_value = $fetch_data['value'];
		// 	    	$chart_id = $fetch_data['chart_seq'];
		// 	    	if($_SESSION[$sesion_val_id.'previousID'] == NULL)
		// 	    		$_SESSION[$sesion_val_id.'previousID'] = [$chart_id];
		// 	    	else
		// 				array_push($_SESSION[$sesion_val_id.'previousID'], $chart_id);
		// 	    	echo json_encode([
		// 	    		'y_axix' => $y_value,
		// 	    		'x_axix' => $chart_id,
		// 	    		'status' => $getStauts,
		// 	    		'report' => $report
		// 	    	]);
		//     	} 
		//     	else {
		//     		echo json_encode([
		// 	    		'status' => $getStauts,
		// 	    		'report' => $report
		// 	    	]);
		//     	}
	 //    	}	
	 //    	else
	 //    	if($getStauts == 'F' && empty($report)){
		//     		$report = '<p>:No: Data FOund</p>';
		// 		    	echo json_encode([
		// 		    		'status' => $getStauts,
		// 		    		'no_result' => $report,
		// 		    		'report' => ''
		// 		    	]);
		//     	}
		//     	else{
	 //    			echo json_encode([
		// 	    		'status' => $getStauts,
		// 	    		'report' => $report
		// 	    	]);
	 //    	}
		// }
	else if($_GET['action'] == 'chart_data') {

				$y = array();

				$sesion_val_id = $_POST['sesion_val_id'];			

				$sesion_validation_id = preg_replace( "/\r|\n/", "", $sesion_val_id );


				$status = mysqli_query($con,"SELECT * FROM `session_validation` WHERE `session_validation_id`= ".$sesion_validation_id."");
					
				$fetching_date = mysqli_fetch_assoc($status);

				$getStauts = $fetching_date['estatus'];
		    	$report = $fetching_date['result_report'];
					   
				if($getStauts != 'N'){

						if( !isset($_SESSION[$sesion_val_id.'previousID'])){

							$value = mysqli_query($con,"SELECT * FROM session_validation_chart WHERE sesion_val_id = $sesion_val_id ");						
							
							if(mysqli_num_rows($value) > 0){

								$_SESSION[$sesion_val_id.'previousID'] = [];


								while ($data = mysqli_fetch_array($value)) {

									array_push($y, $data['value']);
									array_push($_SESSION[$sesion_val_id.'previousID'], $data['chart_seq']);							
									
								}	
								echo json_encode([
						    		'y_axix' => $y,
						    		'status' => $getStauts,
						    		'report' => $report
						    	]);		

							}
							else{
								echo json_encode([
					    		'y_axix' => '',
					    		'status' => $getStauts,
					    		'report' => $report
					    	]);
							}
						}
						else{

							$prevCharId = $_SESSION[$sesion_val_id.'previousID'];

							$prev_id_array = '';

							foreach ($prevCharId as $key => $value) {
								$prev_id_array .= $value.',';
							}

							$not_in_list = substr($prev_id_array, 0, -1);			


							$value = mysqli_query($con,"SELECT * FROM session_validation_chart WHERE sesion_val_id = $sesion_val_id AND chart_seq NOT IN (".$not_in_list.")");

							if(mysqli_num_rows($value) > 0){

								while ($data = mysqli_fetch_array($value)) {

									array_push($y, $data['value']);
									array_push($_SESSION[$sesion_val_id.'previousID'], $data['chart_seq']);							
									
								}
								echo json_encode([
					    		'y_axix' => $y,
					    		'status' => $getStauts,
					    		'report' => $report
					    	]);
								
							}else{
								echo json_encode([
					    		'y_axix' => '',
					    		'status' => $getStauts,
					    		'report' => $report
					    	]);

							}


						}
						
					} 
				else{
					echo json_encode([
				    		'status' => $getStauts,
				    		'chart_seq' => ''
				    	]);
				}
	

		
			
			// else{
			// 	echo json_encode([
			//     		'status' => $getStauts,
			//     		'chart_seq' => ''
			//     	]);
			// }
		}

	// else if($_GET['action'] == 'system_defination') {	

	// 	$check = $_POST['insert_data'];
	// 	if(!empty($check)){
	// 		$user_id = get_current_user_id();
	// 		$session_id = $_POST['session_id'];
	// 		$status = 'N';

	//     	$sql = "INSERT INTO session_strategy_definition (user_id, `sesion_id`, `estatus`)
	// 			 VALUES ( '$user_id', '$session_id', '$status')";
	        
	// 	    $con->query($sql);

	// 	    $strategy_definition_id = $con->insert_id;
		    
	// 	   	echo $strategy_definition_id;			
	// 	}else{
	// 		$id = $_POST['strategy_definition_id'];
	// 		$value = mysqli_query($con,"SELECT * FROM session_strategy_definition WHERE session_strat_def_id = $id AND estatus = 'F'");
	// 		if(mysqli_num_rows($value) > 0){
	// 			echo mysqli_fetch_assoc($value)['definition_text'];				
	// 		}
	// 	}
		
	// }

		else if($_GET['action'] == 'system_defination') {

			$check = $_POST['insert_data'];

			// echo "id = ".$_POST['session_id'];
			if(!empty($check)){
				$user_id = 0;
				$session_id = $_POST['session_id'];
				$status = 'N';

				$userAlready = $con->query("SELECT * FROM session_strategy_definition WHERE user_id = '$user_id'");

		        if (mysqli_num_rows($userAlready) > 0) {
		        	$sql = "UPDATE session_strategy_definition set `sesion_id`='$session_id', `estatus`= '$status' WHERE user_id = '$user_id'";
		        } else {
		        	$sql = "INSERT INTO `session_strategy_definition` (`user_id`, `sesion_id`, `estatus`) VALUES ('$user_id', '$session_id', '$status')";
		        }
		        
		        $con->query($sql);

			    $definition_id = mysqli_query($con,"SELECT * FROM session_strategy_definition WHERE user_id = '$user_id'");

			    $strategy_definition_id = mysqli_fetch_assoc($definition_id)['session_strat_def_id'];
			    
			   	echo $strategy_definition_id;			
			}
			else{
				$id = $_POST['strategy_definition_id'];
				$value = mysqli_query($con,"SELECT * FROM session_strategy_definition WHERE session_strat_def_id = $id AND estatus = 'F'");

				if(mysqli_num_rows($value) > 0){
					echo encodes(mysqli_fetch_assoc($value)['definition_text']);										
				}
			}
			
		}

		// else if($_GET['action'] == 'stripe_payment'){
			
		// 	$fetch = mysqli_query($con, "SELECT * FROM `payment_keys` WHERE payment_type = 'stripe'");
		// 	if($fetch){
		// 		$s_k = mysqli_fetch_assoc($fetch)['secret_key'];
		// 	}

		// 	$name = $_POST['data']['name'];
		// 	$amount = $_POST['data']['price']*100;
		// 	$currency = 'EUR';
		// 	$source = $_POST['stripe_token'];
		// 	$email = $_POST['data']['email'];
		//     $price = $_POST['data']['price'];
		// 	$description = $_POST['data']['description'];
		// 	$date = date('Y-m-d');
		// 	$user_id = 0;
		// 	$session_id = $_POST['session_id'];
		// 	\Stripe\Stripe::setApiKey($s_k);
		// 	try{  			    
		// 	    //charge a credit or a debit card
		// 		$charge = \Stripe\Charge::create(array(
		// 		    'source'  => $source,
		// 		    'amount'   => $amount,
		// 		    'currency' => $currency,
		// 		    'description' => $description			        
		// 		));

		// 		$json_data = explode("JSON: ", $charge);
		// 		// var_dump($json_data[1]);
		// 		if($charge->paid){
					
		// 			$status = 'N';
		// 			// 4242 4242 4242 4242

		// 			$pay_ = "INSERT INTO `wp_payment` (`payment_id`, `session_id`, `user_id`, `payment_amount`, `date`) VALUES (NULL, '$session_id', '$user_id', '$price', '$date');";
		// 			$con->query($pay_);

		// 			// session_payment
		// 			$session_pay_ = "INSERT INTO `session_payment` (`session_pay_id`, `session_id`, `user_id`, `type_payment`, `estatus`, `estatus_text`) VALUES (NULL, '$session_id', '$user_id', 'STRIPE', 'Success', 'Payment transaction successfull');";
		// 			$con->query($session_pay_);
					
		// 			echo $charge->paid."payment_done_success";
	 // 				// $query = mysqli_query($con,"SELECT * FROM session_compiled WHERE session_comp_id = '$pay_id'");

		// 			// $sql = "INSERT INTO `session_compiled` (`session_id`, `user_id`, `estatus`) VALUES ('$session_id', '$user_id','N')";

		// 		 //    $con->query($sql);				    

		// 	  //    	$last_pay_id = $con->insert_id;
				     
		// 		 //    echo $last_pay_id."pay_id";

		// 		}else{					
		// 			echo $charge;
		// 		}
		// 	} catch(\Exception $e){
		// 		$error = $e->getMessage();
		// 		$session_pay_ = "INSERT INTO `session_payment` (`session_pay_id`, `session_id`, `user_id`, `type_payment`, `estatus`, `estatus_text`) VALUES (NULL, '$session_id', '$user_id', 'STRIPE', 'Failed', '$error');";
		// 		$data = $con->query($session_pay_);				
		// 		echo $e->getMessage();
		// 	}	
		
		// }


		else if($_GET['action'] == 'session_compiled'){
			$user_id = 0;
			
			$session_id = $_POST['session_id'];
			
			$sql = "INSERT INTO `session_compiled` (`session_id`, `user_id`, `estatus`) VALUES ('$session_id', '$user_id','N')";

		    $con->query($sql);				    

	     	$last_pay_id = $con->insert_id;
		     
		    echo $last_pay_id;
		}


		else if($_GET['action'] == 'link_status'){

			$pay_id = $_POST['compile_id'];
	 		
	 		$query = mysqli_query($con,"SELECT * FROM session_compiled WHERE session_comp_id = '$pay_id'");
	 		$fetched_data = mysqli_fetch_assoc($query);
	 		if(mysqli_num_rows($query) > 0){

	 			if($fetched_data['estatus'] == 'F'){
		 			// Send download file link
		 			echo encodes($fetched_data['url_file']);											 				
	 			}else if($fetched_data['estatus'] == 'E'){
	 				$error = mysqli_query($con,"SELECT * FROM error WHERE error_code = 3 AND lang_id = '$lang_id'");
	 				if(mysqli_num_rows($error) > 0){
		 				echo encodes(mysqli_fetch_assoc($error)['ERROR_DESC'])."complie_error";											 				
	 				}
	 			}
	 		
	 		}
			
		}
	else{
			echo "error";

	}


	
	?>
<?php else: ?>
		<!DOCTYPE html>
	   <html lang="<?= strtolower($lang_id); ?>">
	   <head>
		<?php
		$fetch_key = mysqli_query($con, "SELECT * FROM `payment_keys` WHERE payment_type = 'stripe'");
		
			$p_k = mysqli_fetch_assoc($fetch_key)['publish_key'];
?>
<input type="hidden" id="publish_key" value="<?= $p_k?>">	
	   
		<link class="all_files" rel="stylesheet" href="css/jquery-ui.css?time=<?= time(); ?>">
		<link class="all_files" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css?time=<?= time(); ?>" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link class="all_files" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css?time=<?= time(); ?>" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<script class="all_files" src="https://code.jquery.com/jquery-1.12.4.js?time=<?= time(); ?>"></script>	

		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
		
		<script class="all_files" type="text/javascript" src="js/javaScript.js?time=<?= time(); ?>"></script>
		<script class="all_files" src="js/jquery-ui.js?time=<?= time(); ?>"></script>

		<link class="all_files" rel="stylesheet" type="text/css" href="plugin/tooltipster/dist/css/tooltipster.bundle.min.css?time=<?= time(); ?>" />
	    <link class="all_files" rel="stylesheet" type="text/css" href="plugin/tooltipster/dist/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-light.min.css?time=<?= time(); ?>">
	    <script class="all_files" type="text/javascript" src="plugin/tooltipster/dist/js/tooltipster.bundle.min.js?time=<?= time(); ?>"></script>
		<link class="all_files" rel="stylesheet" type="text/css" href="css/style.css?time=<?= time(); ?>">
		
	
		<script src="https://js.stripe.com/v3/"></script>
		<script src="js/index.js" data-rel-js></script>
		
		<link rel="stylesheet" type="text/css" href="css/stripe_base.css" data-rel-css="" />
		<link rel="stylesheet" type="text/css" href="css/stripe_style.css" data-rel-css="" />
		

		<meta class="all_files" name="google" content="notranslate">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta charset="UTF-8">



		<script>
			jQuery(document).ready(function($) {
				$('#bootstrap-css').remove();
				$('.page_title .breadcrumbs').append('<a href="<?php //echo wp_logout_url(home_url('/test')); ?>" class="logoutBtn">Logout</a>');
				$('.all_files').appendTo('head');
			});
		</script>








		</head>
		<?php
			$el_save_obj = mysqli_query($con, "SELECT * FROM `translations` WHERE 
				CONCEPT_NAME = 'STRATEGY_TEXT6' AND
				LANG_ID = '".$lang_id."'
			");

			

			$save_text = mysqli_fetch_assoc($el_save_obj)['TEXT'];
			$fetchcing_add_seq = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='STRATEGY_TEXT5' AND LANG_ID='$lang_id'");
			$add_seq_text = encodes(mysqli_fetch_assoc($fetchcing_add_seq)['TEXT']);


		?>

		<body>
	
	<div class="box_shadow"></div>
		<!-- Mobile menu closed -->
		
		
			<!-- use js code -->
			<?php
				$helpUrl = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='STRATEGY_TEXT9_URL' AND LANG_ID='$lang_id'");						
				$helpText = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='STRATEGY_TEXT8' AND LANG_ID='$lang_id'");						
				$helpTranslated = encodes(mysqli_fetch_assoc($helpText)['TEXT']);				
				$help_breaked = explode("?", $helpTranslated);
				$guide = substr($help_breaked[1], strrpos($help_breaked[1], ' ') + 1);
				$guide = "<a href='".encodes(mysqli_fetch_assoc($helpUrl)['TEXT'])."' target='_blank'>".$guide."</a>";
				$last_space_position = strrpos($help_breaked[1], ' ');
				$helpTranslated = substr($help_breaked[1], 0, $last_space_position);
				$help = $help_breaked[0]."?<br>".$helpTranslated." ".$guide; 
			?>
			<button type="button" class="help pop" data-container="body" data-toggle="popover" data-placement="right" data-content="<?= $help?>"
			 data-original-title="" title="">
			 <img src="images/help.png">
			   <!-- &#10067  -->
			</button>
			
				
		<div class="container h-100 py-6 ">
	

			<div class="row top-row">				
				<div class="left-arrow whizerd">
					<?php
						$JumperPreviousText = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='JUMPER_PREV_TEXT' AND LANG_ID='$lang_id'");						
					?>
					<p style="color: black;"><?= encodes(mysqli_fetch_assoc($JumperPreviousText)['TEXT'])?></p>
					<img src="images/left-arrow.png">
					<p class="active-tab-left" style="color: black;"></p>
				</div>				
				<div class="img-build whizerd active">
					<img src="images/build-active.png" class="img-responsive">
					<?php
						$JumperStrategyText = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='JUMPER_STRATEGY_TEXT' AND LANG_ID='$lang_id'");						
					?>
					<p><?= encodes(mysqli_fetch_assoc($JumperStrategyText)['TEXT'])?></p>
				</div>
				<div class="whizerd w_image">		
					<div style="width: 128px; background-image: url('images/bullets.png'); height: 13px;" class="animate_bullets_left">
						&nbsp;
					</div>
				</div>
				<div class="img-validate whizerd">
					<img src="images/validate.png" class="img-responsive">
					<?php
						$JumperValidateText = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='JUMPER_VAL_TEXT' AND LANG_ID='$lang_id'");						
						$validate_trans = encodes(mysqli_fetch_assoc($JumperValidateText)['TEXT']);
					?>
					<p><?= $validate_trans?></p>
				</div>
				<div class="whizerd w_image">		
					<div style="width: 128px; background-image: url('images/bullets.png'); height: 13px;" class="animate_bullets_right">
						&nbsp;
					</div>
				</div>
				<div class="img-download whizerd">
					<img src="images/download.png" class="img-responsive">
					<?php
						$JumperDownloadText = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='JUMPER_DOWN_TEXT' AND LANG_ID='$lang_id'");						
					?>
					<p><?= encodes(mysqli_fetch_assoc($JumperDownloadText)['TEXT'])?></p>
				</div>
				<div class="right-arrow whizerd">
					<?php
						$JumperNextText = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='JUMPER_NEXT' AND LANG_ID='$lang_id'");						
					?>
					<p style="color: black;"><?= encodes(mysqli_fetch_assoc($JumperNextText)['TEXT'])?></p>
					<img src="images/right-arrow.png">
					<p class="active-tab-right" style="color: black;"><?= $validate_trans?></p>
				</div>				
			</div>
		</div>
		<hr>
		

		<!-- Old build screen -->

		<div class="build-tab">			
			<div class="container-fluid h-100 py-6" style="    padding-bottom: 0 !important;">				
				<div class="row">					
					

					
					<div class="col-sm-4 left_elements_tab">
						<section class="delete-div">
							<div>
								
								<p> 
									<span><i class="fa fa-trash" aria-hidden="true"></i></span> 
									<strong>Delete</strong>
								</p>

							</div>
						</section>	
						<section id="tabs">
							<div class="container">
								<h6 class="section-title">
									<?php
									 	$strategy_text_1_row = mysqli_query($con,"SELECT  `TEXT` FROM `translations` WHERE  `CONCEPT_NAME` = 'STRATEGY_TEXT1' AND LANG_ID = '$lang_id'");
									 	echo encodes(mysqli_fetch_assoc($strategy_text_1_row)['TEXT']);
									?>								
								</h6>
								<div class="row">
									<div class="col-xs-12 all_elements">
										<nav>
											<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
												<?php

													$group_name_results = mysqli_query($con, "
														SELECT
															translations.TABLE_NAME,
															translations.CONCEPT_NAME,
															translations.REG_ID,
															element_group.GROUP_ID,
															element_group.GROUP_NAME,
															element_group.ORDER_ID,
															element_group.ACTIVE,
															translations.TEXT,
															translations.LANG_ID,
															translations.TRANS_ID 
														FROM
															translations
															INNER JOIN element_group ON translations.REG_ID = element_group.GROUP_ID 
														WHERE
															translations.TABLE_NAME = 'element_group'
															AND translations.CONCEPT_NAME = 'GROUP_NAME' 
															AND translations.LANG_ID = '$lang_id'
															AND element_group.ACTIVE = '1'
														ORDER BY
															element_group.ORDER_ID ASC
													");

													while ($group_name_row = mysqli_fetch_array($group_name_results)) {    

													  	$element_group_id = $group_name_row['GROUP_ID'];
														$id = $group_name_row['GROUP_NAME'].'-tab';
														$href = '#'.$group_name_row['GROUP_NAME'];
														$group_name = $group_name_row['GROUP_NAME'];
													?>
														<a class="nav-item nav-link <?php if($group_name_row['ORDER_ID'] == 1) echo 'active'; ?>" id="<?= $id; ?>" data-toggle="tab" href="<?= $href; ?>" role="tab" aria-controls="<?= $group_name; ?>" aria-selected="true"><span><?= encodes($group_name_row['TEXT']); ?></span></a>
													<?php }
												?>
											</div>
										</nav>

										<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
											<?php
												$element_groups = mysqli_query($con, "SELECT `GROUP_NAME`, `ORDER_ID` FROM `element_group`");
												$tab_count = 0;
												while ($element_group = mysqli_fetch_array($element_groups)) {
													$tab_count++;
												  	$id = $element_group['GROUP_NAME'].'-tab';
													$href = $element_group['GROUP_NAME'];
													$element_name = $element_group['GROUP_NAME'];
												 ?>
											<div class="tab-pane fade <?php if($element_group['ORDER_ID'] == 1) echo 'show active'; ?>" id="<?= $href; ?>" role="tabpanel" aria-labelledby="<?= $id; ?>" style="color: black;">
												<div class="ui-widget ui-helper-clearfix">
													<ul class="gallery ui-helper-reset ui-helper-clearfix" id="sortable" style="height: 53.5vh; padding: 0 !important;">
														<?php
															$index = 0;
															$fetch_element_image = mysqli_query($con,"SELECT * FROM elements WHERE `ELEMENT_GROUP_ID` = $element_group[1] AND ACTIVE = '1' ORDER BY ORDER_ID ASC");
															while ($fetch_element_data = mysqli_fetch_array($fetch_element_image)) {
															$element_id = $fetch_element_data['ELEMENT_ID'];
															$element_name = $fetch_element_data['ELEMENT_NAME'];
															$element_img_url = $fetch_element_data['IMAGE_URL'];
															$element_more_info = $fetch_element_data['MORE_INFO_URL'];

															
															$element_name_query = mysqli_query($con,"SELECT * FROM `translations` WHERE TABLE_NAME='elements' AND CONCEPT_NAME='ELEMENT_NAME' AND REG_ID=$element_id AND LANG_ID='$lang_id'");
															$element_name_tran = encodes(mysqli_fetch_assoc($element_name_query)['TEXT']);
															if($element_name_tran == ''){
																$element_name_tran = '&nbsp';
															}

															$fetching_element_description = mysqli_query($con,"SELECT * FROM `translations` WHERE TABLE_NAME='elements' AND CONCEPT_NAME='ELEMENT_DESCRIPTION' AND REG_ID=$element_id AND LANG_ID='$lang_id'");
															$element_desc = mysqli_fetch_assoc($fetching_element_description); 
															$index++;
														?>

														<li class="ui-widget-content ui-corner-tr ui-state-default paramsmeters" data-tooltip-content="#sidebar_content-<?= $index; ?>">
															<p style="font-size: 12px"><?= $element_name_tran; ?></p>
															<i class="fa fa-remove delete_element" style="display: none;"></i>
															<img src="<?= $element_img_url; ?>?time=<?= time(); ?>" alt="<?= $element_name; ?>" width="96" height="90" class="img-responsive" data-elementID="<?= $element_id; ?>">
																<img src="images/seq-add.png" class="arrow_pop pop" data-toggle="tooltip" data-trigger="hover" data-placement="bottom" data-content="" alt="SEQ">

																<span class="sidebar_content-<?= $index; ?>" data-template="true" style="display: none;">
																	
																	<div class="main_head" >
																		<h6><?= $element_name_tran; ?></h6>	
																		<img src="<?= $element_img_url; ?>?time=<?= time(); ?>" alt="" class="pop_image">																		

																		</div>
																	<div class="tooltip_content_container">
																		<!-- <h6><?= $element_name_tran; ?></h6> -->
																		<?php

																			$el_info_obj = mysqli_query($con, "SELECT * FROM `translations` WHERE 
																				CONCEPT_NAME = 'STRATEGY_TEXT7' AND
																				LANG_ID = '".$lang_id."'
																			");

																		?>
																		<p class="el-desc"><?= encodes($element_desc['TEXT']); ?>
																		<a href="<?= $element_more_info; ?>" target='_blank'><?= encodes(mysqli_fetch_assoc($el_info_obj)['TEXT']); ?></a>
																		</p>

																		<span class="close_tooltip"><i class="fa fa-close"></i></span>
																		<div class="testing">
																			<?php

																			$params_sql = "SELECT
																				parameters.PARAM_ID,
																				parameters.PARAM_NAME,
																				parameters.PARAM_TYPE,
																				parameters.DEFAULT_PARAM,
																				parameters.ELEMENT_ID,
																				parameters.ORDER_ID,
																				parameters.ACTIVE,
																				translations.CONCEPT_NAME,
																				translations.TABLE_NAME,
																				translations.TEXT,
																				translations.REG_ID,
																				translations.LANG_ID
																				FROM
																				parameters
																				INNER JOIN translations ON translations.REG_ID = parameters.PARAM_ID
																				WHERE
																				parameters.ELEMENT_ID = $fetch_element_data[0] AND
																				translations.TABLE_NAME = 'PARAMETERS' AND
																				translations.CONCEPT_NAME = 'PARAM_NAME' AND
																				translations.LANG_ID = '$lang_id' AND 
																				parameters.ACTIVE = '1'
																				ORDER BY ORDER_ID ASC
																				";

																			$fetch_parameters_value = mysqli_query($con, $params_sql);
																			
																			while ($fetch_parameters = mysqli_fetch_array($fetch_parameters_value)) :

																				if($fetch_parameters['PARAM_TYPE'] === 'INTEGER') { ?>

																					<div class="form-group" data-field-type='integer'>
																					   <label><?= encodes($fetch_parameters['TEXT']); ?></label>
																					   <input type="number" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm get_design" placeholder="<?= encodes($fetch_parameters['TEXT']); ?>" value="<?= encodes($fetch_parameters['DEFAULT_PARAM']); ?>" disabled>
																					</div>

																				<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'BOOL') { ?>

																					<div class="form-check tooltip-check round"  data-field-type='bool'>
																					  <input class="form-check-input" type="checkbox" disabled id="<?= $fetch_parameters['PARAM_NAME'] ?>" name="<?= $fetch_parameters['PARAM_NAME'] ?>" <?php if($fetch_parameters['DEFAULT_PARAM'] == '1') echo 'checked'; ?> >
																					  <label class="form-check-label"></label>
																						<span class="param_label"><?= $param_label; ?></span>
																					</div>

																				<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'STRING') { ?>
																					
																					<div class="form-group" data-field-type='string'>
																					   <label><?= encodes($fetch_parameters['TEXT']); ?></label>
																					   <input type="text" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm get_design" placeholder="<?= encodes($fetch_parameters['TEXT']); ?>" value="<?= encodes($fetch_parameters['DEFAULT_PARAM']); ?>" disabled>
																					</div>																				
																				<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'DOUBLE') { ?>
																					
																					<div class="form-group" data-field-type='double'>
																					   <label><?= encodes($fetch_parameters['TEXT']); ?></label>
																					   <input type="text" step="any" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm get_design" placeholder="<?= encodes($fetch_parameters['TEXT']); ?>" value="<?= $fetch_parameters['DEFAULT_PARAM']; ?>" disabled>
																					</div>

																				<?php } else {

																					$options = $fetch_parameters['PARAM_TYPE'];
																					$values = explode(";", $options); ?>
																					
																					<div class="form-group" data-field-type='dropdown'>
																						<label><?= encodes($fetch_parameters['TEXT']); ?></label>
																						<select class="form-control form-control-sm get_design" disabled>
																							<?php
																								foreach ($values as $value) {
																									if ($fetch_parameters['DEFAULT_PARAM'] == $value) {
																										echo "<option value='".encodes($value)."' selected>".encodes($value)."</option>";
																									} else {
																										echo "<option value='".encodes($value)."'>".encodes($value)."</option>";
																									}
																								}
																							?>
																						</select>
																					</div>
																				<?php } ?>

																			<?php endwhile; ?>
																		</div>
																			<div style="text-align: center;">
																				<button type="submit" class="btn btn-success btn-block btn-outline-success d-none close_tooltip_save"><?= $save_text; ?></button>
																			</div>
																	</div>
															    </span>
														</li>
														

														<?php } ?>

														<?php if ($tab_count == 1): ?>
															
															<?php $fetch_tabs_omc = mysqli_query($con,"SELECT * FROM `elements` WHERE ELEMENT_GROUP_ID = 0");
															
															$indexx = 0;
															while ($fetching_omc = mysqli_fetch_array($fetch_tabs_omc)) { 
																$indexx++;

																$id = $fetching_omc['ELEMENT_ID'];
																$fetch_parameters_value = mysqli_query($con,"SELECT * FROM parameters WHERE ELEMENT_ID = $id"); 

																$new_con = '';

																$el_description = '';
																
																if($fetching_omc['ELEMENT_NAME'] == 'OPEN') {
																	$strategy = 'STRATEGY_OPEN';
																} elseif($fetching_omc['ELEMENT_NAME'] == 'CLOSE') {
																	$strategy = 'STRATEGY_CLOSE';
																} elseif($fetching_omc['ELEMENT_NAME'] == 'MODIFY') {
																	$strategy = 'STRATEGY_MODIFY';
																} elseif($fetching_omc['ELEMENT_NAME'] == 'SEQ') {
																	$strategy = 'ELEMENT_NAME';
																	$new_con = "REG_ID = '$id' AND";
																}

																$fetching_element_description = mysqli_query($con, "SELECT * FROM `translations` WHERE TABLE_NAME='ELEMENTS' AND CONCEPT_NAME='ELEMENT_DESCRIPTION' AND REG_ID=$id AND LANG_ID='$lang_id'");
																	$el_description = encodes(mysqli_fetch_assoc($fetching_element_description)['TEXT']);

																$el_name_obj = mysqli_query($con, "SELECT * FROM `translations` WHERE 
																	CONCEPT_NAME = '".$strategy."' AND
																	".$new_con."
																	LANG_ID = '".$lang_id."'
																");
																$el_name_ac = encodes(mysqli_fetch_assoc($el_name_obj)['TEXT']);																	
																
																$el_name = mysqli_query($con, "SELECT * FROM `translations` WHERE 
																	CONCEPT_NAME = 'ELEMENT_NAME' AND TABLE_NAME='ELEMENTS'AND REG_ID=$id AND LANG_ID='$lang_id'");

																$el_name_SEQ = encodes(mysqli_fetch_assoc($el_name)['TEXT']);



																?>
																

																<input type="hidden" name="unique" value="<?= $el_name_SEQ?>" >

																<li class="ui-widget-content ui-corner-tr ui-state-default paramsmeters d-sort door_image_li shadow" data-tooltip-content="#tab_one_content-<?= $indexx; ?>" data-element-append="<?= $id; ?>" data-title="<?= $fetching_omc['ELEMENT_NAME']; ?>" style="display: none;">
																	
																	<p style="font-size: 12px" class="v-h"><?= $el_name_ac; ?></p>								
																				
																	<?php if ($fetching_omc['ELEMENT_NAME'] == 'SEQ'): 
																		$img_src = 'images/seq-add.png';
																		?>
																		<i class="fa fa-remove"></i>

																		<img src="images/seq-add.png" alt="<?= $fetching_omc['ELEMENT_NAME']; ?>" width="96" class="img-responsive"  >
																		<strong><?= $add_seq_text; ?></strong>
																	<?php else: 
																		$img_src = $fetching_omc["IMAGE_URL"];
																		?>
																		<img src="<?= $fetching_omc['IMAGE_URL']; ?>?time=<?= time(); ?>" alt="<?= $fetching_omc['ELEMENT_NAME']; ?>" width="96" height="90" class="img-responsive" data-elementID="<?= $id; ?>">
																	<?php endif ?>

																	<!-- New tooltip design -->

		
																	<span class="tab_one_content-<?= $indexx; ?>" data-template="true" style="display: none;">

																		<?php
																			$open_modify_close_name = mysqli_query($con, "SELECT * FROM `translations` WHERE 
																				CONCEPT_NAME = 'ELEMENT_NAME' AND REG_ID = $id AND LANG_ID = '".$lang_id."'
																			");
																		?>
		
																		<div class="main_head">
																			<h6><?= encodes(mysqli_fetch_assoc($open_modify_close_name)['TEXT']); ?></h6>																				
																					<img src="<?= $img_src; ?>?time=<?= time(); ?>" alt="" class="pop_image">																		
																			</div>
		
																		<!-- <div class="design_1"> -->
																		<div class="tooltip_content_container">
																			<?php																		
																				
																				$el_info_obj = mysqli_query($con, "SELECT * FROM `translations` WHERE 
																					CONCEPT_NAME = 'STRATEGY_TEXT7' AND
																					LANG_ID = '".$lang_id."'
																				");
																				
																				$open_modify_close_name = mysqli_query($con, "SELECT * FROM `translations` WHERE 
																					CONCEPT_NAME = 'ELEMENT_NAME' AND REG_ID = $id AND LANG_ID = '".$lang_id."'
																				");

																			?>
																			<!-- <div style="background: black">
																			<h6><?php //echo encodes(mysqli_fetch_assoc($open_modify_close_name)['TEXT']); ?></h6>																				
																			</div> -->
																			
																			
																			<p class="el-desc design_p"> <?= $el_description; ?><a href="<?= $fetching_omc['MORE_INFO_URL']; ?>" target='_blank'> <?= encodes(mysqli_fetch_assoc($el_info_obj)['TEXT']); ?> </a></p>
																			<!-- <hr class="element_line_break"> -->
																			<span class="close_tooltip"><i class="fa fa-close"></i></span>
																																						
																			<div class="testing">
																				
																			
																			<?php
																				$params_sql = "SELECT
																					*
																					FROM
																					parameters
																					WHERE
																					ELEMENT_ID = $id AND ACTIVE = '1' ORDER BY ORDER_ID ASC ";

																				$fetch_parameters_value = mysqli_query($con, $params_sql);
																				
																				while ($fetch_parameters = mysqli_fetch_array($fetch_parameters_value)) :

																					$fetching_param_label = mysqli_query($con,"SELECT * FROM `translations` WHERE TABLE_NAME='PARAMETERS' AND CONCEPT_NAME='PARAM_NAME' AND REG_ID={$fetch_parameters['PARAM_ID']} AND LANG_ID='$lang_id'");
																					$param_label = encodes(mysqli_fetch_assoc($fetching_param_label)['TEXT']);

																					if($fetch_parameters['PARAM_TYPE'] === 'INTEGER') { ?>

																						<div class="form-group" data-field-type='integer'>
																						   <label><?= $param_label; ?></label>
																						  
																						   <input type="number" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm element_form" placeholder="<?= $param_label; ?>" value="<?= encodes($fetch_parameters['DEFAULT_PARAM']); ?>" disabled>
																						
																						</div>

																					<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'BOOL') { ?>

																						<div class="form-check tooltip-check round" data-field-type='bool'>
																						  <input class="form-check-input" type="checkbox" disabled id="<?= $fetch_parameters['PARAM_NAME'] ?>" name="<?= $fetch_parameters['PARAM_NAME'] ?>" <?php if($fetch_parameters['DEFAULT_PARAM'] == '1') echo 'checked'; ?> >
																						  <label class="form-check-label"></label>
																						  <span class="param_label"><?= $param_label; ?></span>
																						</div>

																					<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'DOUBLE') { ?>
																						
																						<div class="form-group" data-field-type='double'>
																						   <label><?= $param_label; ?></label>
																						   <input type="text" step="any" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm element_form" placeholder="<?= encodes($fetch_parameters['TEXT']); ?>" value="<?= $fetch_parameters['DEFAULT_PARAM']; ?>" disabled>
																						</div>

																					<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'STRING') { ?>
																						
																						<div class="form-group" data-field-type='string'>
																						   <label><?= $param_label; ?></label>
																						   <input type="text" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm element_form" placeholder="<?= encodes($fetch_parameters['TEXT']); ?>" value="<?= $fetch_parameters['DEFAULT_PARAM']; ?>" disabled>
																						</div>






																					<?php } else {
																						$options = $fetch_parameters['PARAM_TYPE'];
																						$values = explode(";", $options); ?>
																						
																						<div class="form-group" data-field-type='dropdown'>
																							<label><?= $param_label; ?></label>
																							<select class="form-control form-control-sm element_form" disabled>
																								<?php
																									foreach ($values as $value) {
																										if ($value == $fetch_parameters['DEFAULT_PARAM']) {
																											echo "<option value='".encodes($value)."' selected>".encodes($value)."</option>";
																										} else {
																											echo "<option value='".encodes($value)."'>".encodes($value)."</option>";
																										}
																									}
																								?>
																							</select>
																						</div>
																					<?php } ?>

																				<?php endwhile; ?>
																				</div>
																				<div style="text-align: center;">
																					
																				<button type="submit" class="btn btn-success btn-block btn-outline-success d-none close_tooltip_save "><?= $save_text; ?></button>
																				</div>
																		
																	</div>
																	</span>
																</li>
																<?php 
															}


															// New element configuration

															$fetch_configuration_omc = mysqli_query($con,"SELECT * FROM `elements` WHERE ELEMENT_GROUP_ID = '4' AND  ELEMENT_ID NOT IN (4, 27, 43, 44, 45)");
															
															$index_id = 7;
															while ($configuration_omc = mysqli_fetch_array($fetch_configuration_omc)) { 
																$index_id ++;

																$id = $configuration_omc['ELEMENT_ID'];
																$fetch_parameters_value = mysqli_query($con,"SELECT * FROM parameters WHERE ELEMENT_ID = $id"); 

																

																$el_description = '';
																

																$fetching_element_description = mysqli_query($con, "SELECT * FROM `translations` WHERE TABLE_NAME='ELEMENTS' AND CONCEPT_NAME='ELEMENT_DESCRIPTION' AND REG_ID=$id AND LANG_ID='$lang_id'");
																	$el_description = encodes(mysqli_fetch_assoc($fetching_element_description)['TEXT']);

																$el_name_obj = mysqli_query($con, "SELECT * FROM `translations` WHERE 
																	CONCEPT_NAME = 'ELEMENT_NAME' AND																	
																	LANG_ID = '".$lang_id."'
																");
																$el_name_ac = encodes(mysqli_fetch_assoc($el_name_obj)['TEXT']);																	
																
																$el_name = mysqli_query($con, "SELECT * FROM `translations` WHERE 
																	CONCEPT_NAME = 'ELEMENT_NAME' AND TABLE_NAME='ELEMENTS'AND REG_ID=$id AND LANG_ID='$lang_id'");

																$el_name_SEQ = encodes(mysqli_fetch_assoc($el_name)['TEXT']);



																?>
																

																<input type="hidden" name="unique" value="<?= $el_name_SEQ?>" >

																<li class="ui-widget-content ui-corner-tr ui-state-default paramsmeters d-sort shadow configuration" element_tab_index = '<?= $index_id; ?>' data-tooltip-content="#tab_one_content-<?= $indexx; ?>" data-element-append_conf="<?= $id; ?>" data-title="<?= $fetching_omc['ELEMENT_NAME']; ?>" style="display: none;">
																	
																	<p style="font-size: 12px" class="v-h"><?= $el_name_ac; ?></p>								
																				
																	<?php
																		$img_src = $configuration_omc["IMAGE_URL"];
																		?>
																		<img src="<?= $configuration_omc['IMAGE_URL']; ?>?time=<?= time(); ?>" alt="<?= $fetching_omc['ELEMENT_NAME']; ?>" width="96" height="90" class="img-responsive" data-elementID="<?= $id; ?>">
																	

																	<!-- New tooltip design -->

															
																	<span class="tab_one_content-<?= $indexx; ?>" data-template="true" style="display: none;">

																		<?php
																			$open_modify_close_name = mysqli_query($con, "SELECT * FROM `translations` WHERE 
																				CONCEPT_NAME = 'ELEMENT_NAME' AND REG_ID = $id AND LANG_ID = '".$lang_id."'
																			");
																		?>
															
																		<div class="main_head">
																			<h6><?= encodes(mysqli_fetch_assoc($open_modify_close_name)['TEXT']); ?></h6>																				
																					<img src="<?= $img_src; ?>?time=<?= time(); ?>" alt="" class="pop_image">																		
																			</div>
															
																		<!-- <div class="design_1"> -->
																		<div class="tooltip_content_container">
																			<?php																		
																				
																				$el_info_obj = mysqli_query($con, "SELECT * FROM `translations` WHERE 
																					CONCEPT_NAME = 'STRATEGY_TEXT7' AND
																					LANG_ID = '".$lang_id."'
																				");
																				
																				$open_modify_close_name = mysqli_query($con, "SELECT * FROM `translations` WHERE 
																					CONCEPT_NAME = 'ELEMENT_NAME' AND REG_ID = $id AND LANG_ID = '".$lang_id."'
																				");

																			?>
																			<!-- <div style="background: black">
																			<h6><?php //echo encodes(mysqli_fetch_assoc($open_modify_close_name)['TEXT']); ?></h6>																				
																			</div> -->
																			
																			
																			<p class="el-desc design_p"> <?= $el_description; ?><a href="<?= $fetching_omc['MORE_INFO_URL']; ?>" target='_blank'> <?= encodes(mysqli_fetch_assoc($el_info_obj)['TEXT']); ?> </a></p>
																			<!-- <hr class="element_line_break"> -->
																			<span class="close_tooltip"><i class="fa fa-close"></i></span>
																																						
																			<div class="testing">
																				
																			
																			<?php
																				$params_sql = "SELECT
																					*
																					FROM
																					parameters
																					WHERE
																					ELEMENT_ID = $id AND ACTIVE = '1' ORDER BY ORDER_ID ASC ";

																				$fetch_parameters_value = mysqli_query($con, $params_sql);
																				
																				while ($fetch_parameters = mysqli_fetch_array($fetch_parameters_value)) :

																					$fetching_param_label = mysqli_query($con,"SELECT * FROM `translations` WHERE TABLE_NAME='PARAMETERS' AND CONCEPT_NAME='PARAM_NAME' AND REG_ID={$fetch_parameters['PARAM_ID']} AND LANG_ID='$lang_id'");
																					$param_label = encodes(mysqli_fetch_assoc($fetching_param_label)['TEXT']);

																					if($fetch_parameters['PARAM_TYPE'] === 'INTEGER') { ?>

																						<div class="form-group" data-field-type='integer'>
																						   <label><?= $param_label; ?></label>
																						  
																						   <input type="number" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm element_form" placeholder="<?= $param_label; ?>" value="<?= encodes($fetch_parameters['DEFAULT_PARAM']); ?>" disabled>
																						
																						</div>

																					<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'BOOL') { ?>

																						<div class="form-check tooltip-check round" data-field-type='bool'>
																						  <input class="form-check-input" type="checkbox" disabled id="<?= $fetch_parameters['PARAM_NAME'] ?>" name="<?= $fetch_parameters['PARAM_NAME'] ?>" <?php if($fetch_parameters['DEFAULT_PARAM'] == '1') echo 'checked'; ?> >
																						  <label class="form-check-label"></label>
																						  <span class="param_label"><?= $param_label; ?></span>
																						</div>

																					<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'DOUBLE') { ?>
																						
																						<div class="form-group" data-field-type='double'>
																						   <label><?= $param_label; ?></label>
																						   <input type="text" step="any" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm element_form" placeholder="<?= encodes($fetch_parameters['TEXT']); ?>" value="<?= $fetch_parameters['DEFAULT_PARAM']; ?>" disabled>
																						</div>

																					<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'STRING') { ?>
																						
																						<div class="form-group" data-field-type='string'>
																						   <label><?= $param_label; ?></label>
																						   <input type="text" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm element_form" placeholder="<?= encodes($fetch_parameters['TEXT']); ?>" value="<?= $fetch_parameters['DEFAULT_PARAM']; ?>" disabled>
																						</div>






																					<?php } else {
																						$options = $fetch_parameters['PARAM_TYPE'];
																						$values = explode(";", $options); ?>
																						
																						<div class="form-group" data-field-type='dropdown'>
																							<label><?= $param_label; ?></label>
																							<select class="form-control form-control-sm element_form" disabled>
																								<?php
																									foreach ($values as $value) {
																										if ($value == $fetch_parameters['DEFAULT_PARAM']) {
																											echo "<option value='".encodes($value)."' selected>".encodes($value)."</option>";
																										} else {
																											echo "<option value='".encodes($value)."'>".encodes($value)."</option>";
																										}
																									}
																								?>
																							</select>
																						</div>
																					<?php } ?>

																				<?php endwhile; ?>
																				</div>
																				<div style="text-align: center;">
																					
																				<button type="submit" class="btn btn-success btn-block btn-outline-success d-none close_tooltip_save "><?= $save_text; ?></button>
																				</div>
																		
																	</div>
																	</span>
																</li>
																<?php 
															}



															 ?>
														<?php endif; ?>

													</ul>
												</div>
											</div>
											<?php } ?> 
										</div>									
									</div>
								</div>
							</div>
						</section>
						<div class="close_element_tab" style="display: none;">
							<i class="fa fa-remove delete_element_tab"></i>
						</div>
					</div>
					<div class="col-sm-1 add_elements_plus">
						<i class="fa fa-plus"></i>												
					</div>
						



					

					<div class="col-sm-11" style="padding: 0 !important; height: 567px; overflow: hidden;">
						<section id="tabs_2">
							<nav>
								<div class="nav nav-fill" id="nav-tab2" role="tablist">           
								<?php
									$fetch_tabs_omc = mysqli_query($con,"SELECT * FROM `elements` WHERE ELEMENT_GROUP_ID = 0 AND ELEMENT_NAME != 'SEQ'");
									while ($fetching_omc = mysqli_fetch_array($fetch_tabs_omc)) {	
											
										$omc_id = $fetching_omc['ELEMENT_GROUP_ID'];
										$id = $fetching_omc['ELEMENT_NAME'].'-tab';
										$href = '#'.$fetching_omc['ELEMENT_NAME'];

										if($fetching_omc['ELEMENT_NAME'] == 'OPEN') {
											$strategy = 'STRATEGY_OPEN';
										} elseif($fetching_omc['ELEMENT_NAME'] == 'CLOSE') {
											$strategy = 'STRATEGY_CLOSE';
										} else {
											$strategy = 'STRATEGY_MODIFY';
										}

										$fetchcing_omc_name = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='$strategy' AND REG_ID=$omc_id AND LANG_ID='$lang_id'");

										while ($fetched_omc_name = mysqli_fetch_array($fetchcing_omc_name)) {
											$translated_omc_name = encodes($fetched_omc_name['TEXT']); ?>

											<a class="nav-item nav-link <?php if($fetching_omc['ELEMENT_ID'] == 8) echo 'active'; ?>" data-icon-id="<?= $fetching_omc['ELEMENT_ID']; ?>" id="<?= $id?>" data-toggle="tab" href="<?= $href; ?>" role="tab" aria-controls="<?= $fetching_omc['ELEMENT_NAME']; ?>" aria-selected="false" ><?= $translated_omc_name; ?></a>

										<?php } } ?>
								</div>
							</nav>
							<div class="tab-content px-3 px-sm-0" id="nav-tabContent2">
								<?php

									$fetch_tabs_omc = mysqli_query($con,"SELECT * FROM `elements` WHERE ELEMENT_GROUP_ID = 0 AND ELEMENT_NAME != 'SEQ'");
									while ($fetching_omc = mysqli_fetch_array($fetch_tabs_omc)) {

										$id = $fetching_omc['ELEMENT_ID'];
										$href = $fetching_omc['ELEMENT_NAME'];
										$img = $fetching_omc['IMAGE_URL'];
										$more_info_url = $fetching_omc['MORE_INFO_URL'];								

									?>	

											<div class="omc tab-pane fade <?php if($fetching_omc['ELEMENT_ID']==8) echo 'show active'; ?>" id="<?= $href; ?>" role="tabpanel" aria-labelledby="<?= $href?>" data-id-omc='<?= $fetching_omc['ELEMENT_NAME']; ?>' data-tab_id='<?= $fetching_omc['ELEMENT_ID']; ?>'>	
												<table class=" table order-list" style="height: 500px; margin: 0;">
													<tbody>
														<tr>
															<td class="gallery_new" style="margin-left: 25px;">
																<div class="ui-helper-reset gallery-rep">
																	<ul id="trash" class="trash ui-widget-content ui-state-default" style="width: 100%; overflow-x: auto;">
																		
																		<li class="dashed_image_li d-sort">
																			<p style="font-size: 12px">DASHED iMAGE</p>
																			<?php
																				$fetchcing_drag_text = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='STRATEGY_TEXT4' AND LANG_ID='$lang_id'");
																			?>
																			<div class="dashed-div"> <div style="overflow: hidden; height: 45px;"><?= encodes(mysqli_fetch_array($fetchcing_drag_text)['TEXT']); ?></div> </div>
																		</li>
																		
																	</ul>
																</div>
															</td>
														</tr>														
														<tr class="add_new_stage">
															<td style="margin-left: 25px; ">
																<ul class="trash_dont_accept">
																	<li class="dashed_image_li d-sort">
																		<p style="font-size: 12px">DASHED iMAGE</p>
																		<?php
																			$fetchcing_add_stage_name = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='STRATEGY_TEXT2' AND LANG_ID='$lang_id'");
																			$add_new_b = encodes(mysqli_fetch_array($fetchcing_add_stage_name)['TEXT']);
																		?>
																		<div class="dashed-div-2 "> <div style="overflow: hidden; height: 79px; text-align: center;"><?= ucwords($add_new_b); ?><h3 class="row_design">+</h3></div> </div>
																	</li>
																	<!-- <li class="dashed_image_li d-sort">
																		<p style="font-size: 12px">DASHED iMAGE</p>
																		<?php
																			$fetchcing_add_stage_name = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='STRATEGY_TEXT2' AND LANG_ID='$lang_id'");
																			$add_new_b = encodes(mysqli_fetch_array($fetchcing_add_stage_name)['TEXT']);
																		?>
																		<div class="dashed-div"> 
																			<div class="dashed_title"><?= ucwords($add_new_b); ?><h3 class="row_design">+</h3></div> 
																		</div>	
																	</li> -->																	
																</ul>
															</td>
														</tr>
													</tbody>
											<tfoot style="visibility:  hidden;">
												<tr>
													<td colspan="5" style="text-align: left;">
														<?php
															$fetchcing_add_stage_name = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='STRATEGY_TEXT2' AND LANG_ID='$lang_id'");
															$add_new_b = encodes(mysqli_fetch_array($fetchcing_add_stage_name)['TEXT']);
														?>

														<button class="button arrow" id="addrow"><?= ucwords($add_new_b); ?></button>

													</td>
												</tr>
											</tfoot>
										</table>
								</div>							
								<?php } ?>
							</div>
						</section>

						<br>
					</div>
				</div>

				<!-- <div class="row">
					<div class="col-sm-12">
						
						<?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
						
						<input type="hidden" name="siteLink" value="<?= $actual_link?>?action=chart_data" data-validateId = "">

						<button type="button" id="save_data" class="btn btn-success" data-action="<?= $actual_link; ?>?action=save_data" style="float: right;"> <img src="images/ajax-loader.gif" style="display: none;">  <span>Save Strategy</span> </button>
						
						<?php
							$strategy_summary_text = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='STRATEGY_TEXT3' AND LANG_ID='$lang_id'");
						?>
						<button type="button" id="close_tooltipseter_" class="btn build-next" data-tooltip-content="#tooltip_content_definition" data-action="<?= $actual_link; ?>?action=system_defination" style="margin-top: 20px; margin-left: -14px;float: left;">  <span><?= encodes(mysqli_fetch_assoc($strategy_summary_text)['TEXT']); ?></span> </button>
						<br>

					</div>
				</div> -->
		
		


				</div>
			</div>
		</div>
		
		
		
		

	

		<div class="validate-tab">
			<div class="container-fluid h-100 py-6">
				<div class="row">					
						<div class="col-sm-8" style="border: 1px solid black; border-radius: 25px;">
							<div class="validatingGraph">
								<div style="position: relative;top: 50%;">
									<?php
										$getWelcomValidateText = mysqli_query($con,"SELECT * FROM `translations` WHERE TABLE_NAME='(SCREEN VAL)' AND CONCEPT_NAME='WELCOME_TEXT' AND REG_ID=0 AND LANG_ID='$lang_id'");
										$welcome_validate_trans = encodes(mysqli_fetch_assoc($getWelcomValidateText)['TEXT']);
									?>
									<p><?= $welcome_validate_trans?></p>
								</div>
							</div>
							<div id="chartContainer" style="height: auto; margin-top: 30px; display: none;"></div>					
							 <!-- padding: 5px 5px; -->

							<?php
								$strategyText = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='STRATEGY_TEXT3' AND LANG_ID='$lang_id'");								
							?>
						</div>
						<div class="col-sm-4">		
							<form class="validate-form">
									<div class="form-group option-1">
										<?php
											$tickerText = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='TICKER_TEXT' AND LANG_ID='$lang_id'");
										?>
										<label for="ticket"><?= encodes(mysqli_fetch_assoc($tickerText)['TEXT']); ?>:</label>
										<select id="ticket" class="form-control form-control-sm" name="ticker">
											<?php
											$selectTickers = $con->query("SELECT * FROM ticker");										
											while ($timeTicker = mysqli_fetch_array($selectTickers)) {											
												?>
													<option value="<?php echo $timeTicker['TICKER_ID'];?>"><?php echo $timeTicker['TICKER_NAME'];?></option>
												<?php
											}
										?>
										</select>
									</div>
								<div class="form-group option-1">
									<label for="timeframe">Timeframe: </label>
									<select id="timeframe" class="form-control form-control-sm" name="time_frame">
									<?php
										$selectTimeFrame = $con->query("SELECT * FROM timeframes WHERE LANGUAJE_id = '$lang_id'");										
										while ($timeframe = mysqli_fetch_array($selectTimeFrame)) {											
											?>
												<option value="<?php echo $timeframe['TF_ID'];?>"><?php echo $timeframe['TF_NAME'];?></option>
											<?php
										}
									?>
									</select>
								</div>
								<div class="form-group option-2">
									<label for="start-time">Start Time: </label>				
									<div class="calendar">	
										<?php
											$DateFormat = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='DATEFORMAT_TEXT' AND LANG_ID='$lang_id'");						
											$format = strtolower(encodes(mysqli_fetch_assoc($DateFormat)['TEXT']));
											
										?>
										<input data-format=<?= $format?> type="text" class="datepicker-starttime" name="start-date" value="01/01/<?php echo date("Y")?>"/>
										<i class="fa fa-calendar" aria-hidden="true"></i>
									</div>
								</div>
								<div class="form-group option-2">
									<label for="end-time">End Time: </label>
									<div class="calendar">	
										<input data-format=<?= $format?> type="text" class="datepicker-endtime" name="end-date" value="<?php 
										if($format == 'dd/mm/yyyy')
											echo date("d/m/Y");
										else
											echo date("m/d/Y");
										?>"/>
										<i class="fa fa-calendar" aria-hidden="true"></i>
									</div>
								</div>					
								<!--  Extra Fields -->
								<?php

								$user_id = 0;
								// $user_id = get_current_user_id();
									$strategy_id = mysqli_query($con,"SELECT sesion_id FROM session_strategy WHERE user_id = '$user_id'");
									
									$id = mysqli_fetch_assoc($strategy_id);								 

									?>								
								<input type="hidden" name="user_id" value="<?= $user_id?>">
								<input type="hidden" name="session_strategy_id" value="<?php echo $id['sesion_id'];?>">
								<div class="submit-btn">									
									<button type="button" id="validate-next" data-action="<?= $actual_link; ?>?action=validate_data"><?= $validate_trans?></button>	
								</div>			
							</form>	

							<div class="validateStrategyScreen">	
								<div class="validatingScreen" style="display: none; position: relative;top: 40%;">
									<center>
										<?php
											$WaitingValidationText = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='WAITING_TEXT' AND LANG_ID='$lang_id'");						
										?>
										<p><?= encodes(mysqli_fetch_assoc($WaitingValidationText)['TEXT'])?></p>
										<i class="fa fa-refresh fa-spin" style="font-size:24px"></i>
										<!-- <img src="images/ajax-loader-green.gif"> -->
									</center>
								</div>
								<div class="validatedScreen">
									<center>
										<p>Validated</p>
									</center>
								</div>
							</div>				
						</div>	
						<!-- <div class="col-sm-12">
							
							<button type="button" class="btn summary-btn" style="float: left;">  <span><?= encodes(mysqli_fetch_assoc($strategyText)['TEXT']); ?></span> </button>	
						</div> -->	 
				</div>
			</div>
		</div>

		<?php
			// System defitnitoin Heading
			$fetchcing_defintition_heading = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='STRAT_DEF_TEXT' AND LANG_ID='$lang_id'");
			$definition_heading = encodes(mysqli_fetch_assoc($fetchcing_defintition_heading)['TEXT']);
			
			// Agree condition text
			$fetchcing_condi_text = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='AGREE_COND' AND LANG_ID='$lang_id'");
			$condi_text = encodes(mysqli_fetch_assoc($fetchcing_condi_text)['TEXT']);

			$exploded = explode(" ", $condi_text);

			if($lang_id == 'ES'){
				$link_text = $exploded[0]." ".$exploded[1]." ".$exploded[2]." ".$exploded[3]." ".$exploded[4]." ";
				$link = $exploded[5]." ".$exploded[6];
			}else{
				$link_text = $exploded[0]." ".$exploded[1]." ".$exploded[2]." ".$exploded[3]." ";
				$link = $exploded[4]." ".$exploded[5];
			}

			// Link text

			$fetchcing_condi_text_url = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='CONDITION_URL' AND LANG_ID='$lang_id'");
			$condi_text_url = encodes(mysqli_fetch_assoc($fetchcing_condi_text_url)['TEXT']);

			// Understand System definitoin
			$sys_def_text_1 = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='UNDERSTAND_STRAT_TEXT' AND LANG_ID='$lang_id'");
			$sys_def_text = encodes(mysqli_fetch_assoc($sys_def_text_1)['TEXT']);

			// Download Button
			$download_btn_text = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='DOWN_BUTTON' AND LANG_ID='$lang_id'");
			$down_btn_trans = encodes(mysqli_fetch_assoc($download_btn_text)['TEXT']);



		?>
	
		<div class="download-tab">	
			<div class="container-fluid h-100 py-6">			
				<div class="row">
					<div class="col-sm-4">
						<h3 style="margin-left: 3%;"><?= $definition_heading ?></h3>
						<div class="system-defination">	
						</div>
					</div>
					<div class="col-sm-8">
						<div class="right-options">
							<form>
								<div class="form-group">
									<input type="checkbox" name="read_accept"> 
									<?= $sys_def_text?>
								</div>
								<div class="form-group">
									<!-- Add a target balnk -->
									<input type="checkbox" name="agree_condition"> <?= $link_text ?><a href="<?= $condi_text_url?>" target="_blank"><?= $link ?></a>
								</div>
								<button type="button" class="btn download_pay" id="download-next"><?= $down_btn_trans ?></button>				
							</form>
						</div>
					</div>
				</div>
			</div>		
		</div>	
			<img class="payment_loader" src="images/25.gif" style="display: none; position: absolute; top: 45%; left: 43%; height: 100px;">
	<?php

	$user_info = mysqli_query($wp_con,"SELECT * FROM wp_users WHERE id = 1");
	$user_fetched = mysqli_fetch_assoc($user_info);
	$user_name = $user_fetched['user_nicename'];
	$user_email = $user_fetched['user_email'];

	// Pay title
	$pay_text = mysqli_query($con,"SELECT * FROM `translations` WHERE TABLE_NAME='(DOWNLOAD SCREEN)' AND CONCEPT_NAME='PAY_TITLE' AND LANG_ID='$lang_id'");
	$pay_text_trans = encodes(mysqli_fetch_assoc($pay_text)['TEXT']);

	// Order title
	$order_text = mysqli_query($con,"SELECT * FROM `translations` WHERE TABLE_NAME='(DOWNLOAD SCREEN)' AND CONCEPT_NAME='ORDER_TITLE' AND LANG_ID='$lang_id'");
	$order_text_trans = encodes(mysqli_fetch_assoc($order_text)['TEXT']);

	// Order Description
	$order_desc_text = mysqli_query($con,"SELECT * FROM `translations` WHERE TABLE_NAME='(DOWNLOAD SCREEN)' AND CONCEPT_NAME='ORDER_DESC' AND LANG_ID='$lang_id'");
	$order_desc_text_trans = encodes(mysqli_fetch_assoc($order_desc_text)['TEXT']);

	// Price
	$price_text = mysqli_query($con,"SELECT * FROM `translations` WHERE TABLE_NAME='(DOWNLOAD SCREEN)' AND CONCEPT_NAME='PRICE' AND LANG_ID='$lang_id'");
	$price_text_trans = encodes(mysqli_fetch_assoc($price_text)['TEXT']);

	// Subtotal
	$subtotal_text = mysqli_query($con,"SELECT * FROM `translations` WHERE TABLE_NAME='(DOWNLOAD SCREEN)' AND CONCEPT_NAME='SUBTOTAL' AND LANG_ID='$lang_id'");
	$subtotal_text_trans = encodes(mysqli_fetch_assoc($subtotal_text)['TEXT']);

	// Total
	$total_text = mysqli_query($con,"SELECT * FROM `translations` WHERE TABLE_NAME='(DOWNLOAD SCREEN)' AND CONCEPT_NAME='TOTAL' AND LANG_ID='$lang_id'");
	$total_text_trans = encodes(mysqli_fetch_assoc($total_text)['TEXT']);

	// Pay Text
	$pay = mysqli_query($con,"SELECT * FROM `translations` WHERE TABLE_NAME='(DOWNLOAD SCREEN)' AND CONCEPT_NAME='PAY_TEXT' AND LANG_ID='$lang_id'");
	$pay_trans = encodes(mysqli_fetch_assoc($pay)['TEXT']);

	// Pay Text
	$order_img = mysqli_query($con,"SELECT * FROM `translations` WHERE TABLE_NAME='(DOWNLOAD SCREEN)' AND CONCEPT_NAME='ORDER_IMG_URL' AND LANG_ID='$lang_id'");
	$order_img_trans = encodes(mysqli_fetch_assoc($order_img)['TEXT']);


	if($lang_id == 'ES'){

		// LABEL_NAME
		$label_name = mysqli_query($con, "SELECT * FROM `translations` WHERE 
				TABLE_NAME = 'DOWNLOAD SCREEN)'  AND CONCEPT_NAME = 'LABEL_NAME' AND
				LANG_ID = '".$lang_id."'
			");
		$label_name = encodes(mysqli_fetch_assoc($label_name)['TEXT']);
		
		// LABEL_EMAIL
		$label_email = mysqli_query($con, "SELECT * FROM `translations` WHERE 
				TABLE_NAME = 'DOWNLOAD SCREEN)'  AND CONCEPT_NAME = 'LABEL_EMAIL' AND
				LANG_ID = '".$lang_id."'
			");
		$label_email = encodes(mysqli_fetch_assoc($label_email)['TEXT']);

		// LABEL_PHONE
		$label_phone = mysqli_query($con, "SELECT * FROM `translations` WHERE 
				TABLE_NAME = 'DOWNLOAD SCREEN)'  AND CONCEPT_NAME = 'LABEL_PHONE' AND
				LANG_ID = '".$lang_id."'
			");
		$label_phone = encodes(mysqli_fetch_assoc($label_phone)['TEXT']);

		// LABEL_ADRESS
		$label_address = mysqli_query($con, "SELECT * FROM `translations` WHERE 
				TABLE_NAME = 'DOWNLOAD SCREEN)'  AND CONCEPT_NAME = 'LABEL_ADRESS' AND
				LANG_ID = '".$lang_id."'
			");
		$label_address = encodes(mysqli_fetch_assoc($label_address)['TEXT']);

		// LABEL_CITY
		$label_city = mysqli_query($con, "SELECT * FROM `translations` WHERE 
				TABLE_NAME = 'DOWNLOAD SCREEN)'  AND CONCEPT_NAME = 'LABEL_CITY' AND
				LANG_ID = '".$lang_id."'
			");
		$label_city = encodes(mysqli_fetch_assoc($label_city)['TEXT']);

		// LABEL_STATE
		$label_state = mysqli_query($con, "SELECT * FROM `translations` WHERE 
				TABLE_NAME = 'DOWNLOAD SCREEN)'  AND CONCEPT_NAME = 'LABEL_STATE' AND
				LANG_ID = '".$lang_id."'
			");
		$label_state = encodes(mysqli_fetch_assoc($label_state)['TEXT']);

		// LABEL_ZIP
		$label_zip = mysqli_query($con, "SELECT * FROM `translations` WHERE 
				TABLE_NAME = 'DOWNLOAD SCREEN)'  AND CONCEPT_NAME = 'LABEL_ZIP' AND
				LANG_ID = '".$lang_id."'
			");
		$label_zip = encodes(mysqli_fetch_assoc($label_zip)['TEXT']);

		// LABEL_CARD
		$label_card = mysqli_query($con, "SELECT * FROM `translations` WHERE 
				TABLE_NAME = 'DOWNLOAD SCREEN)'  AND CONCEPT_NAME = 'LABEL_CARD' AND
				LANG_ID = '".$lang_id."'
			");
		$label_card = encodes(mysqli_fetch_assoc($label_card)['TEXT']);

		// LABEL_VALID
		$label_valid = mysqli_query($con, "SELECT * FROM `translations` WHERE 
				TABLE_NAME = 'DOWNLOAD SCREEN)'  AND CONCEPT_NAME = 'LABEL_VALID' AND
				LANG_ID = '".$lang_id."'
			");
		$label_valid = encodes(mysqli_fetch_assoc($label_valid)['TEXT']);

		// LABEL_CVC
		$label_cvc = mysqli_query($con, "SELECT * FROM `translations` WHERE 
				TABLE_NAME = 'DOWNLOAD SCREEN)'  AND CONCEPT_NAME = 'LABEL_CVC' AND
				LANG_ID = '".$lang_id."'
			");
		$label_cvc = encodes(mysqli_fetch_assoc($label_cvc)['TEXT']);

		// LABEL__OR_ENTER
		$label_or_enter = mysqli_query($con, "SELECT * FROM `translations` WHERE 
				TABLE_NAME = 'DOWNLOAD SCREEN)'  AND CONCEPT_NAME = 'LABEL__OR_ENTER' AND
				LANG_ID = '".$lang_id."'
			");
		$label_or_enter = encodes(mysqli_fetch_assoc($label_or_enter)['TEXT']);

	}else{
		$label_name = 'Name';
		$label_email = 'Email';
		$label_phone = 'Phone';
		$label_address = 'Address';
		$label_city = 'City';
		$label_state = 'State';
		$label_zip = 'ZIP';
		$label_card = 'Card Number:';
		$label_valid = 'Expiration:';
		$label_cvc = 'CVC security code:';
		$label_or_enter = 'Or enter card details';
	}


	?>
	
			<!--  Payment Form -->
<!-- <main class="payment_stripe" >
				<section class="container-lg">
				  	<div class="cell example example5" id="example-5">
				  		<span class="close_payment" style="position: relative; left: 100%; top: -20px; font-weight: bold; color: white;">
				  			X
				  		</span>
				  		<div class="row">
				  			<div class="col-sm-7">
							    <form>
							      <div id="example5-paymentRequest">
							      </div>
							      	<fieldset>
								        <legend class="card-only" data-tid="elements_examples.form.pay_with_card" style="font-weight: bold"><?= $pay_text_trans?></legend>
								        <legend class="payment-request-available" data-tid="elements_examples.form.enter_card_manually">Or enter card details</legend>
								        <div class="row">
								          <div class="field">
								            <label for="example5-name" data-tid="elements_examples.form.name_label"><?= $label_name?></label>
								            <input id="example5-name" data-tid="elements_examples.form.name_placeholder" class="input" type="text" value="<?= $user_name?>" required="" autocomplete="name">
								          </div>
								        </div>
								        <div class="row">
								          <div class="field" style="width: 44%;">
								            <label for="example5-email" data-tid="elements_examples.form.email_label"><?= $label_email?></label>
								            <input id="example5-email" data-tid="elements_examples.form.email_placeholder" class="input" type="text" value="<?= $user_email?>" required="" autocomplete="email">
								          </div>
								          <div class="field" style="width: 44%;">
								            <label for="example5-phone" data-tid="elements_examples.form.phone_label"><?= $label_phone?></label>
								            <input id="example5-phone" data-tid="elements_examples.form.phone_placeholder" class="input" type="text" placeholder="(941) 555-0123" required="" autocomplete="tel">
								          </div>
								        </div>
								        <div data-locale-reversible>
								          <div class="row">
								            <div class="field">
								              <label for="example5-address" data-tid="elements_examples.form.address_label"><?= $label_address?></label>
								              <input id="example5-address" data-tid="elements_examples.form.address_placeholder" class="input" type="text" placeholder="185 Berry St" required="" autocomplete="address-line1">
								            </div>
								          </div>
								          <div class="row" data-locale-reversible>
								            <div class="field" style="width: 28%;">
								              <label for="example5-city" data-tid="elements_examples.form.city_label"><?= $label_city?></label>
								              <input id="example5-city" data-tid="elements_examples.form.city_placeholder" class="input" type="text" placeholder="San Francisco" required="" autocomplete="address-level2">
								            </div>
								            <div class="field" style="width: 28%;">
								              <label for="example5-state" data-tid="elements_examples.form.state_label"><?= $label_state?></label>
								              <input id="example5-state" data-tid="elements_examples.form.state_placeholder" class="input empty" type="text" placeholder="CA" required="" autocomplete="address-level1">
								            </div>
								            <div class="field" style="width: 28%;">
								              <label for="example5-zip" data-tid="elements_examples.form.postal_code_label"><?= $label_zip?></label>
								              <input id="example5-zip" data-tid="elements_examples.form.postal_code_placeholder" class="input empty" type="text" placeholder="94107" required="" autocomplete="postal-code">
								            </div>
								          </div>
								        </div>

		
								        <div class="row">
								          <div class="field">
								            <label for="example5-card" data-tid="elements_examples.form.card_label">Card</label>
								            <div id="example5-card" class="input"></div>
								          </div>
								        </div>
								      
								        <input type="hidden" name="token">
								        <input type="hidden" name="price" value="<?= $price_text_trans?>">
								        <button class="pay_amount" name="pay_btn" type="submit" data-tid="elements_examples.form.pay_button"><?= $pay_trans." €". $price_text_trans?> </button>
							    	</fieldset>
							      <div class="error" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
							          <path class="base" fill="#000" d="M8.5,17 C3.80557963,17 0,13.1944204 0,8.5 C0,3.80557963 3.80557963,0 8.5,0 C13.1944204,0 17,3.80557963 17,8.5 C17,13.1944204 13.1944204,17 8.5,17 Z"></path>
							          <path class="glyph" fill="#FFF" d="M8.5,7.29791847 L6.12604076,4.92395924 C5.79409512,4.59201359 5.25590488,4.59201359 4.92395924,4.92395924 C4.59201359,5.25590488 4.59201359,5.79409512 4.92395924,6.12604076 L7.29791847,8.5 L4.92395924,10.8739592 C4.59201359,11.2059049 4.59201359,11.7440951 4.92395924,12.0760408 C5.25590488,12.4079864 5.79409512,12.4079864 6.12604076,12.0760408 L8.5,9.70208153 L10.8739592,12.0760408 C11.2059049,12.4079864 11.7440951,12.4079864 12.0760408,12.0760408 C12.4079864,11.7440951 12.4079864,11.2059049 12.0760408,10.8739592 L9.70208153,8.5 L12.0760408,6.12604076 C12.4079864,5.79409512 12.4079864,5.25590488 12.0760408,4.92395924 C11.7440951,4.59201359 11.2059049,4.59201359 10.8739592,4.92395924 L8.5,7.29791847 L8.5,7.29791847 Z"></path>
							        </svg>
							        <span class="message"></span></div>
							    </form>
							   
							    <div class="success">
							      <div class="icon">
							        <svg width="84px" height="84px" viewBox="0 0 84 84" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							          <circle class="border" cx="42" cy="42" r="40" stroke-linecap="round" stroke-width="4" stroke="#000" fill="none"></circle>
							          <path class="checkmark" stroke-linecap="round" stroke-linejoin="round" d="M23.375 42.5488281 36.8840688 56.0578969 64.891932 28.0500338" stroke-width="4" stroke="#000" fill="none"></path>
							        </svg>
							      </div>
							      <h3 class="title" data-tid="elements_examples.success.title"></h3>
							      <p class="message"><span data-tid="elements_examples.success.message"></span><span class="token"></span></p>
							      <a class="reset" href="#">
							        <svg width="32px" height="32px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							          <path fill="#000000" d="M15,7.05492878 C10.5000495,7.55237307 7,11.3674463 7,16 C7,20.9705627 11.0294373,25 16,25 C20.9705627,25 25,20.9705627 25,16 C25,15.3627484 24.4834055,14.8461538 23.8461538,14.8461538 C23.2089022,14.8461538 22.6923077,15.3627484 22.6923077,16 C22.6923077,19.6960595 19.6960595,22.6923077 16,22.6923077 C12.3039405,22.6923077 9.30769231,19.6960595 9.30769231,16 C9.30769231,12.3039405 12.3039405,9.30769231 16,9.30769231 L16,12.0841673 C16,12.1800431 16.0275652,12.2738974 16.0794108,12.354546 C16.2287368,12.5868311 16.5380938,12.6540826 16.7703788,12.5047565 L22.3457501,8.92058924 L22.3457501,8.92058924 C22.4060014,8.88185624 22.4572275,8.83063012 22.4959605,8.7703788 C22.6452866,8.53809377 22.5780351,8.22873685 22.3457501,8.07941076 L22.3457501,8.07941076 L16.7703788,4.49524351 C16.6897301,4.44339794 16.5958758,4.41583275 16.5,4.41583275 C16.2238576,4.41583275 16,4.63969037 16,4.91583275 L16,7 L15,7 L15,7.05492878 Z M16,32 C7.163444,32 0,24.836556 0,16 C0,7.163444 7.163444,0 16,0 C24.836556,0 32,7.163444 32,16 C32,24.836556 24.836556,32 16,32 Z"></path>
							        </svg>
							      </a>
							    </div>				  				
				  			</div>
				  			<div class="col-sm-5 popup_left_title">
				  				<p class="p-title"><?= $order_text_trans?></p>
								<div class="row div_top">
									<div class="col-sm-3">
										<img class="payment_img" src="images/FDI.png">
										
									</div>
									<div class="col-sm-6"  style="margin-left: 30px;">
										<p class="order_desc"><?= $order_desc_text_trans?></p>
									</div>
									<div class="col-sm-2 price_right">
										<p><?= $price_text_trans?> &#163;</p>
									</div>
								</div>
								<div class="row div_top">
									<div class="col-sm-6">
										<p class="sub_total_text"><?= $subtotal_text_trans?></p>										
									</div>
									<div class="col-sm-6 price_right">
										<p><?= $price_text_trans?> &#163;</p>										
									</div>
								</div>
								<div class="row div_top">
									<div class="col-sm-6">
										<p class="sub_total_text"><?= $total_text_trans?></p>										
									</div>
									<div class="col-sm-6 price_right">
										<p><?= $price_text_trans?> &#163;</p>										
									</div>
								</div>	
								<div class="row div_top download_loader">

									<button disabled="true" style='display: none;background: #d6a7a7;color: white;' class="error_text"></button>
		

									<?php
										// $JumperDownloadText = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='JUMPER_DOWN_TEXT' AND LANG_ID='$lang_id'");						
									?>
									<a class="download_link" href="" target="_blank">
										<button>
											<?= encodes(mysqli_fetch_assoc($JumperDownloadText)['TEXT'])?>											
										</button>
									</a>									
                  					
                  					<svg class="spinner" width="174px" height="174px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                  					     <circle class="path" fill="transparent" stroke-width="2" cx="33" cy="33" r="30" stroke="#fff"/>
                  					       <linearGradient id="gradient">
                  					         <stop offset="50%" stop-color="#42d179" stop-opacity="1"/>
                  					         <stop offset="65%" stop-color="#42d179" stop-opacity=".5"/>
                  					         <stop offset="100%" stop-color="#42d179" stop-opacity="0"/>
                  					       </linearGradient>
                  					    </circle>
                  					     <svg class="spinner-dot dot" width="5px" height="5px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg" x="37" y="1.5">
                  					       <circle class="path" fill="#fff" cx="33" cy="33" r="30"/>
                  					      </circle>
                  					    </svg> 
                  					  </svg> 

								</div>		  				
				  			</div>
				  		</div>
				  	</div>
				</section>
			</main> -->
		<main class="payment_stripe" style="display: none">
				<section class="container-lg">
					<div class="cell example example3" id="example-3">
				  		<span class="close_payment" style="position: relative; left: 100%; top: -20px; font-weight: bold; color: white;">
				  			X
				  		</span>
				  		<div class="row">
				  			<div class="col-sm-7">
					<!-- <div class="cell example example3" id="example-3"> -->
						          <form>
							            <div class="fieldset">
							              <input id="example3-name" data-tid="elements_examples.form.name_label" class="field" type="text" placeholder="<?= $label_name?>" value="<?= $user_name?>" required="" autocomplete="name">
							              <input id="example3-email" data-tid="elements_examples.form.email_label" class="field half-width" type="email" placeholder="<?= $label_email?>" value="<?= $user_email?>" required="" autocomplete="email">
							              <input id="example3-phone" data-tid="elements_examples.form.phone_label" class="field half-width" type="tel" placeholder="<?= $label_phone?>" required="" autocomplete="tel">
							            </div>
							            <div class="fieldset">
							              <div id="example3-card-number" class="field empty"></div>
							              <div id="example3-card-expiry" class="field empty third-width"></div>
							              <div id="example3-card-cvc" class="field empty third-width"></div>
							              <input id="example3-zip" data-tid="elements_examples.form.postal_code_placeholder" class="field empty third-width" placeholder="94107">
							            </div>
							            <input type="hidden" name="token">
								        <input type="hidden" name="price" value="<?= $price_text_trans?>">
							            <button type="submit" data-tid="elements_examples.form.pay_button"><?= $pay_trans." €". $price_text_trans?> </button>
							            <div class="error" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
						                <path class="base" fill="#000" d="M8.5,17 C3.80557963,17 0,13.1944204 0,8.5 C0,3.80557963 3.80557963,0 8.5,0 C13.1944204,0 17,3.80557963 17,8.5 C17,13.1944204 13.1944204,17 8.5,17 Z"></path>
						                <path class="glyph" fill="#FFF" d="M8.5,7.29791847 L6.12604076,4.92395924 C5.79409512,4.59201359 5.25590488,4.59201359 4.92395924,4.92395924 C4.59201359,5.25590488 4.59201359,5.79409512 4.92395924,6.12604076 L7.29791847,8.5 L4.92395924,10.8739592 C4.59201359,11.2059049 4.59201359,11.7440951 4.92395924,12.0760408 C5.25590488,12.4079864 5.79409512,12.4079864 6.12604076,12.0760408 L8.5,9.70208153 L10.8739592,12.0760408 C11.2059049,12.4079864 11.7440951,12.4079864 12.0760408,12.0760408 C12.4079864,11.7440951 12.4079864,11.2059049 12.0760408,10.8739592 L9.70208153,8.5 L12.0760408,6.12604076 C12.4079864,5.79409512 12.4079864,5.25590488 12.0760408,4.92395924 C11.7440951,4.59201359 11.2059049,4.59201359 10.8739592,4.92395924 L8.5,7.29791847 L8.5,7.29791847 Z"></path>
						              </svg>
						              <span class="message"></span></div>
						          </form>
						          <div class="success">
							            <div class="icon">
							              <svg width="84px" height="84px" viewBox="0 0 84 84" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							                <circle class="border" cx="42" cy="42" r="40" stroke-linecap="round" stroke-width="4" stroke="#000" fill="none"></circle>
							                <path class="checkmark" stroke-linecap="round" stroke-linejoin="round" d="M23.375 42.5488281 36.8840688 56.0578969 64.891932 28.0500338" stroke-width="4" stroke="#000" fill="none"></path>
							              </svg>
							            </div>
							            <h3 class="title" data-tid="elements_examples.success.title">Payment successful</h3>
							            <p class="message"><span data-tid="elements_examples.success.message">Thanks for trying Stripe Elements. No money was charged, but we generated a token: </span><span class="token">tok_189gMN2eZvKYlo2CwTBv9KKh</span></p>
							            <a class="reset" href="#">
							              <svg width="32px" height="32px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
							                <path fill="#000000" d="M15,7.05492878 C10.5000495,7.55237307 7,11.3674463 7,16 C7,20.9705627 11.0294373,25 16,25 C20.9705627,25 25,20.9705627 25,16 C25,15.3627484 24.4834055,14.8461538 23.8461538,14.8461538 C23.2089022,14.8461538 22.6923077,15.3627484 22.6923077,16 C22.6923077,19.6960595 19.6960595,22.6923077 16,22.6923077 C12.3039405,22.6923077 9.30769231,19.6960595 9.30769231,16 C9.30769231,12.3039405 12.3039405,9.30769231 16,9.30769231 L16,12.0841673 C16,12.1800431 16.0275652,12.2738974 16.0794108,12.354546 C16.2287368,12.5868311 16.5380938,12.6540826 16.7703788,12.5047565 L22.3457501,8.92058924 L22.3457501,8.92058924 C22.4060014,8.88185624 22.4572275,8.83063012 22.4959605,8.7703788 C22.6452866,8.53809377 22.5780351,8.22873685 22.3457501,8.07941076 L22.3457501,8.07941076 L16.7703788,4.49524351 C16.6897301,4.44339794 16.5958758,4.41583275 16.5,4.41583275 C16.2238576,4.41583275 16,4.63969037 16,4.91583275 L16,7 L15,7 L15,7.05492878 Z M16,32 C7.163444,32 0,24.836556 0,16 C0,7.163444 7.163444,0 16,0 C24.836556,0 32,7.163444 32,16 C32,24.836556 24.836556,32 16,32 Z"></path>
							              </svg>
							            </a>
						          </div>

        			<!-- </div>			  				 -->
				  			</div>
				  			<div class="col-sm-5 popup_left_title">
				  				<p class="p-title"><?= $order_text_trans?></p>
								<div class="row div_top">
									<div class="col-sm-3">
										<img class="payment_img" src="images/FDI.png">
										<!-- <img class="payment_img" src="<?= $order_img_trans?>"> -->
									</div>
									<div class="col-sm-6"  style="margin-left: 30px;">
										<p class="order_desc"><?= $order_desc_text_trans?></p>
									</div>
									<div class="col-sm-2 price_right">
										<p><?= $price_text_trans?> &#163;</p>
									</div>
								</div>
								<div class="row div_top">
									<div class="col-sm-6">
										<p class="sub_total_text"><?= $subtotal_text_trans?></p>										
									</div>
									<div class="col-sm-6 price_right">
										<p><?= $price_text_trans?> &#163;</p>										
									</div>
								</div>
								<div class="row div_top">
									<div class="col-sm-6">
										<p class="sub_total_text"><?= $total_text_trans?></p>										
									</div>
									<div class="col-sm-6 price_right">
										<p><?= $price_text_trans?> &#163;</p>										
									</div>
								</div>	
								<div class="row div_top download_loader">

									<button disabled="true" style='display: none;background: #d6a7a7;color: white;' class="error_text"></button>
		

									<?php
										$JumperDownloadText = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='JUMPER_DOWN_TEXT' AND LANG_ID='$lang_id'");						
									?>
									<a class="download_link" href="" target="_blank">
										<button>
											<?= encodes(mysqli_fetch_assoc($JumperDownloadText)['TEXT'])?>											
										</button>
									</a>									
                  					<!-- <i class="fa fa-refresh fa-spin" style="font-size:24px;"></i> -->
                  					<svg class="spinner" width="174px" height="174px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                  					     <circle class="path" fill="transparent" stroke-width="2" cx="33" cy="33" r="30" stroke="#fff"/>
                  					       <linearGradient id="gradient">
                  					         <stop offset="50%" stop-color="#42d179" stop-opacity="1"/>
                  					         <stop offset="65%" stop-color="#42d179" stop-opacity=".5"/>
                  					         <stop offset="100%" stop-color="#42d179" stop-opacity="0"/>
                  					       </linearGradient>
                  					    </circle>
                  					     <svg class="spinner-dot dot" width="5px" height="5px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg" x="37" y="1.5">
                  					       <circle class="path" fill="#fff" cx="33" cy="33" r="30"/>
                  					      </circle>
                  					    </svg> 
                  					  </svg> 

								</div>		  				
				  			</div>
				  		</div>
				  	</div>
				</section>
			</main>		
	<!-- <main class="payment_stripe">
  
      <section class="container-lg">

        <div class="cell example example3" id="example-3">
          <form>
	            <div class="fieldset">
	              <input id="example3-name" data-tid="elements_examples.form.name_label" class="field" type="text" placeholder="Name" required="" autocomplete="name">
	              <input id="example3-email" data-tid="elements_examples.form.email_label" class="field half-width" type="email" placeholder="Email" required="" autocomplete="email">
	              <input id="example3-phone" data-tid="elements_examples.form.phone_label" class="field half-width" type="tel" placeholder="Phone" required="" autocomplete="tel">
	            </div>
	            <div class="fieldset">
	              <div id="example3-card-number" class="field empty"></div>
	              <div id="example3-card-expiry" class="field empty third-width"></div>
	              <div id="example3-card-cvc" class="field empty third-width"></div>
	              <input id="example3-zip" data-tid="elements_examples.form.postal_code_placeholder" class="field empty third-width" placeholder="94107">
	            </div>
	            <button type="submit" data-tid="elements_examples.form.pay_button">Pay $25</button>
	            <div class="error" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                <path class="base" fill="#000" d="M8.5,17 C3.80557963,17 0,13.1944204 0,8.5 C0,3.80557963 3.80557963,0 8.5,0 C13.1944204,0 17,3.80557963 17,8.5 C17,13.1944204 13.1944204,17 8.5,17 Z"></path>
                <path class="glyph" fill="#FFF" d="M8.5,7.29791847 L6.12604076,4.92395924 C5.79409512,4.59201359 5.25590488,4.59201359 4.92395924,4.92395924 C4.59201359,5.25590488 4.59201359,5.79409512 4.92395924,6.12604076 L7.29791847,8.5 L4.92395924,10.8739592 C4.59201359,11.2059049 4.59201359,11.7440951 4.92395924,12.0760408 C5.25590488,12.4079864 5.79409512,12.4079864 6.12604076,12.0760408 L8.5,9.70208153 L10.8739592,12.0760408 C11.2059049,12.4079864 11.7440951,12.4079864 12.0760408,12.0760408 C12.4079864,11.7440951 12.4079864,11.2059049 12.0760408,10.8739592 L9.70208153,8.5 L12.0760408,6.12604076 C12.4079864,5.79409512 12.4079864,5.25590488 12.0760408,4.92395924 C11.7440951,4.59201359 11.2059049,4.59201359 10.8739592,4.92395924 L8.5,7.29791847 L8.5,7.29791847 Z"></path>
              </svg>
              <span class="message"></span></div>
          </form>
          <div class="success">
	            <div class="icon">
	              <svg width="84px" height="84px" viewBox="0 0 84 84" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	                <circle class="border" cx="42" cy="42" r="40" stroke-linecap="round" stroke-width="4" stroke="#000" fill="none"></circle>
	                <path class="checkmark" stroke-linecap="round" stroke-linejoin="round" d="M23.375 42.5488281 36.8840688 56.0578969 64.891932 28.0500338" stroke-width="4" stroke="#000" fill="none"></path>
	              </svg>
	            </div>
	            <h3 class="title" data-tid="elements_examples.success.title">Payment successful</h3>
	            <p class="message"><span data-tid="elements_examples.success.message">Thanks for trying Stripe Elements. No money was charged, but we generated a token: </span><span class="token">tok_189gMN2eZvKYlo2CwTBv9KKh</span></p>
	            <a class="reset" href="#">
	              <svg width="32px" height="32px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
	                <path fill="#000000" d="M15,7.05492878 C10.5000495,7.55237307 7,11.3674463 7,16 C7,20.9705627 11.0294373,25 16,25 C20.9705627,25 25,20.9705627 25,16 C25,15.3627484 24.4834055,14.8461538 23.8461538,14.8461538 C23.2089022,14.8461538 22.6923077,15.3627484 22.6923077,16 C22.6923077,19.6960595 19.6960595,22.6923077 16,22.6923077 C12.3039405,22.6923077 9.30769231,19.6960595 9.30769231,16 C9.30769231,12.3039405 12.3039405,9.30769231 16,9.30769231 L16,12.0841673 C16,12.1800431 16.0275652,12.2738974 16.0794108,12.354546 C16.2287368,12.5868311 16.5380938,12.6540826 16.7703788,12.5047565 L22.3457501,8.92058924 L22.3457501,8.92058924 C22.4060014,8.88185624 22.4572275,8.83063012 22.4959605,8.7703788 C22.6452866,8.53809377 22.5780351,8.22873685 22.3457501,8.07941076 L22.3457501,8.07941076 L16.7703788,4.49524351 C16.6897301,4.44339794 16.5958758,4.41583275 16.5,4.41583275 C16.2238576,4.41583275 16,4.63969037 16,4.91583275 L16,7 L15,7 L15,7.05492878 Z M16,32 C7.163444,32 0,24.836556 0,16 C0,7.163444 7.163444,0 16,0 C24.836556,0 32,7.163444 32,16 C32,24.836556 24.836556,32 16,32 Z"></path>
	              </svg>
	            </a>
          </div>

        </div>

   
      </section>
    </main> -->

		<div class="row system_defination_btn">
			<div class="col-sm-12">
				
				<?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
				
				<input type="hidden" name="siteLink" value="<?= $actual_link?>?action=chart_data" data-validateId = "">
				<input type="hidden" name="check_link_status" value="<?= $actual_link?>?action=link_status" data-validateId = "">
				<input type="hidden" name="session_compiled" value="<?= $actual_link?>?action=session_compiled" data-validateId = "">

				<button type="button" id="save_data" class="btn btn-success" data-action="<?= $actual_link; ?>?action=save_data" style="float: right;"> <img src="images/ajax-loader.gif" style="display: none;">  <span>Save Strategy</span> </button>
				
				<?php
					$strategy_summary_text = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='STRATEGY_TEXT3' AND LANG_ID='$lang_id'");
				?>
				<button type="button" id="close_tooltipseter_" class="btn build-next" data-tooltip-content="#tooltip_content_definition" data-action="<?= $actual_link; ?>?action=system_defination" style="margin-top: 20px; margin-left: 7px;float: left;">  <span><?= encodes(mysqli_fetch_assoc($strategy_summary_text)['TEXT']); ?> </span> </button>
				<!-- <button type="button" class="btn build-next" style="margin-top: 20px; margin-left: -14px;float: left;">  <span><?= encodes(mysqli_fetch_assoc($strategy_summary_text)['TEXT']); ?></span> </button> -->
				<br>

			</div>
		</div>
	
	<?php
		$error_data = mysqli_query($con, "SELECT * FROM `translations` WHERE 
				CONCEPT_NAME = 'TEXT_ERROR'  AND
				LANG_ID = '".$lang_id."'
			");

		$error_code_0 = mysqli_query($con, "SELECT * FROM `ERROR` WHERE 
				ERROR_CODE = 0  AND
				LANG_ID = '".$lang_id."'
			");

		$error_code_1 = mysqli_query($con, "SELECT * FROM `ERROR` WHERE 
				ERROR_CODE = 1  AND
				LANG_ID = '".$lang_id."'
			");

		$error_code_2 = mysqli_query($con, "SELECT * FROM `ERROR` WHERE 
				ERROR_CODE = 2  AND
				LANG_ID = '".$lang_id."'
			");

		$error_code_3 = mysqli_query($con, "SELECT * FROM `ERROR` WHERE 
				ERROR_CODE = 3  AND
				LANG_ID = '".$lang_id."'
			");



		



	?>

		<input type="hidden" class="error_code_data" data-error="<?= encodes(mysqli_fetch_assoc($error_data)['TEXT'])?>" data-error-0="<?= encodes(mysqli_fetch_assoc($error_code_0)['ERROR_DESC'])?>" data-error-1="<?= encodes(mysqli_fetch_assoc($error_code_1)['ERROR_DESC'])?>" data-error-2="<?= encodes(mysqli_fetch_assoc($error_code_2)['ERROR_DESC'])?>" data-error-3="<?= encodes(mysqli_fetch_assoc($error_code_3)['ERROR_DESC'])?>">
	
		
		<input type="hidden" class="validate_visisted">	
		<input type="hidden" class="element_data_old">
		<input type="hidden" class="element_data_new">
		<!-- <input type="hidden" class="file_url_compiled"> -->
		<a href="" id="myanchor" style="display: none;">Payment</a>
		<div class="tooltip_templates">
		    <span id="tooltip_content_definition" class="append_response">
		    </span>
		</div>
		<!-- <div class="tooltip_templates"></div> -->
		<!-- Graph -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.js"></script>

		<script class=".to_footer" src="js/JQuery.js?time=<?= time(); ?>"></script>
		<script class=".to_footer" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js?time=<?= time(); ?>" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script class=".to_footer" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js?time=<?= time(); ?>" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
		

	<script src="js/l10n.js" data-rel-js></script>

	<script src="js/stripe_design.js" data-rel-js></script>


	<script>
 	
 	 
	 	jQuery(document).ready(function() {
	 		
	 		var date_format = $(".datepicker-starttime").attr('data-format');
	 		// var date=new Date();
	 		// var year=date.getFullYear(); 

			$('.datepicker-starttime').datepicker({
	 			format: date_format,
	 			autoclose: true
	 			// , 
	 			// startDate: new Date(year, '00', '01')
	 		});
	 		$('.datepicker-endtime').datepicker({
	 			format: date_format,
	 			autoclose: true
	 			// , 
	 			// startDate: new Date()
	 		});


			$('.datepicker-starttime').next('i').on('click', function(event) {
				$( ".datepicker-starttime" ).trigger( "focus" );
			});

			$('.datepicker-endtime').next('i').on('click', function(event) {
				$( ".datepicker-endtime" ).trigger( "focus" );
			});

	 	});

	 	
 
 </script>




	</body>
	</html>	

<?php endif ?>