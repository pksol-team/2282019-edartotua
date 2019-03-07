<?php session_start(); ?>
<?php error_reporting(E_ALL); ?>
<?php
	
	require('connection.php');
	// require(dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/wp-authenticate.php');
	
	
	global $lang_id;
	$lang_ob = mysqli_query($con,"SELECT * FROM `languajes` WHERE `DEFAULT`='1'");
	$lang_id = mysqli_fetch_assoc($lang_ob)['LANGUAJE_ID'];
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
			if(!empty($check)){

		$user_id = 0;
				// $user_id = get_current_user_id();
				$session_id = $_POST['session_id'];
				$status = 'N';

				$userAlready = $con->query("SELECT * FROM session_strategy_definition WHERE user_id = '$user_id'");

		        if (mysqli_num_rows($userAlready) > 0) {
		        	$sql = "UPDATE session_strategy_definition set `sesion_id`='$session_id', `estatus`= '$status' WHERE user_id = '$user_id' ";
		        } else {
		    	    $sql = "INSERT INTO session_strategy_definition (user_id, `sesion_id`, `estatus`)
						 VALUES ( '$user_id', '$session_id', '$status')";
		        }
		        
			    $con->query($sql);

			    $definition_id = mysqli_query($con,"SELECT * FROM session_strategy_definition WHERE user_id = '$user_id'");

			    $strategy_definition_id = mysqli_fetch_assoc($definition_id)['session_strat_def_id'];
			    // $strategy_definition_id = $con->insert_id;
			    
			   	echo $strategy_definition_id;			
			}else{
				$id = $_POST['strategy_definition_id'];
				$value = mysqli_query($con,"SELECT * FROM session_strategy_definition WHERE session_strat_def_id = $id AND estatus = 'F'");
				if(mysqli_num_rows($value) > 0){
					echo mysqli_fetch_assoc($value)['definition_text'];				
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

			function encodes($text) {
				
				if ($GLOBALS['lang_id'] == 'ES') {
					$text = htmlentities($text, ENT_QUOTES, "ISO-8859-1");
					$text = html_entity_decode($text);
					return $text;
				} else {
					return $text;
				}
			}

			$save_text = mysqli_fetch_assoc($el_save_obj)['TEXT'];
			$fetchcing_add_seq = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='STRATEGY_TEXT5' AND LANG_ID='$lang_id'");
			$add_seq_text = encodes(mysqli_fetch_assoc($fetchcing_add_seq)['TEXT']);


		?>

		<body>

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
																	<div class="tooltip_content_container">
																		<h6><?= $element_name_tran; ?></h6>
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
																		<br>
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
																					   <input type="number" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm" placeholder="<?= encodes($fetch_parameters['TEXT']); ?>" value="<?= encodes($fetch_parameters['DEFAULT_PARAM']); ?>" disabled>
																					</div>

																				<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'BOOL') { ?>

																					<div class="form-check tooltip-check"  data-field-type='bool'>
																					  <input class="form-check-input" type="checkbox" disabled id="<?= $fetch_parameters['PARAM_NAME'] ?>" name="<?= $fetch_parameters['PARAM_NAME'] ?>" <?php if($fetch_parameters['DEFAULT_PARAM'] == '1') echo 'checked'; ?> >
																					  <label class="form-check-label"><?= encodes($fetch_parameters['TEXT']); ?></label>
																					</div>

																				<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'STRING') { ?>
																					
																					<div class="form-group" data-field-type='string'>
																					   <label><?= encodes($fetch_parameters['TEXT']); ?></label>
																					   <input type="text" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm" placeholder="<?= encodes($fetch_parameters['TEXT']); ?>" value="<?= encodes($fetch_parameters['DEFAULT_PARAM']); ?>" disabled>
																					</div>																				
																				<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'DOUBLE') { ?>
																					
																					<div class="form-group" data-field-type='double'>
																					   <label><?= encodes($fetch_parameters['TEXT']); ?></label>
																					   <input type="text" step="any" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm" placeholder="<?= encodes($fetch_parameters['TEXT']); ?>" value="<?= $fetch_parameters['DEFAULT_PARAM']; ?>" disabled>
																					</div>

																				<?php } else {

																					$options = $fetch_parameters['PARAM_TYPE'];
																					$values = explode(";", $options); ?>
																					
																					<div class="form-group" data-field-type='dropdown'>
																						<label><?= encodes($fetch_parameters['TEXT']); ?></label>
																						<select class="form-control form-control-sm" disabled>
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
																			
																			<button type="submit" class="btn btn-success btn-block btn-outline-success d-none close_tooltip_save"><?= $save_text; ?></button>
																	</div>
															    </span>
														</li>
														

														<?php } ?>

														<?php if ($tab_count == 1): ?>
															
															<?php $fetch_tabs_omc = mysqli_query($con,"SELECT * FROM `elements` WHERE ELEMENT_GROUP_ID = 0");
															
															$indexx = 0;
															while ($fetching_omc = mysqli_fetch_array($fetch_tabs_omc)) { $indexx++;

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
																

																																<input type="hidden" name="unique" value="<?= $el_name_SEQ?>">

																<li class="ui-widget-content ui-corner-tr ui-state-default paramsmeters d-sort door_image_li" data-tooltip-content="#tab_one_content-<?= $indexx; ?>" data-element-append="<?= $id; ?>" data-title="<?= $fetching_omc['ELEMENT_NAME']; ?>" style="display: none;">
																	
																	<p style="font-size: 12px" class="v-h"><?= $el_name_ac; ?></p>								
																				
																	<?php if ($fetching_omc['ELEMENT_NAME'] == 'SEQ'): ?>
																		<i class="fa fa-remove"></i>
																		<img src="images/seq-add.png" alt="<?= $fetching_omc['ELEMENT_NAME']; ?>" width="96" class="img-responsive"  >
																		<strong><?= $add_seq_text; ?></strong>
																	<?php else: ?>
																		<img src="<?= $fetching_omc['IMAGE_URL']; ?>?time=<?= time(); ?>" alt="<?= $fetching_omc['ELEMENT_NAME']; ?>" width="96" height="90" class="img-responsive" data-elementID="<?= $id; ?>">
																	<?php endif ?>

																	<span class="tab_one_content-<?= $indexx; ?>" data-template="true" style="display: none;">
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
																			<h6><?= encodes(mysqli_fetch_assoc($open_modify_close_name)['TEXT']); ?></h6>
																			<p class="el-desc"> <?= $el_description; ?>  <a href="<?= $fetching_omc['MORE_INFO_URL']; ?>" target='_blank'> <?= encodes(mysqli_fetch_assoc($el_info_obj)['TEXT']); ?> </a></p>
																			<span class="close_tooltip"><i class="fa fa-close"></i></span>
																			<br>
																			
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
																						   <input type="number" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm" placeholder="<?= $param_label; ?>" value="<?= encodes($fetch_parameters['DEFAULT_PARAM']); ?>" disabled>
																						</div>

																					<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'BOOL') { ?>

																						<div class="form-check tooltip-check" data-field-type='bool'>
																						  <input class="form-check-input" type="checkbox" disabled id="<?= $fetch_parameters['PARAM_NAME'] ?>" name="<?= $fetch_parameters['PARAM_NAME'] ?>" <?php if($fetch_parameters['DEFAULT_PARAM'] == '1') echo 'checked'; ?> >
																						  <label class="form-check-label"><?= $param_label; ?></label>
																						</div>

																					<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'DOUBLE') { ?>
																						
																						<div class="form-group" data-field-type='double'>
																						   <label><?= $param_label; ?></label>
																						   <input type="text" step="any" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm" placeholder="<?= encodes($fetch_parameters['TEXT']); ?>" value="<?= $fetch_parameters['DEFAULT_PARAM']; ?>" disabled>
																						</div>

																					<?php } elseif($fetch_parameters['PARAM_TYPE'] == 'STRING') { ?>
																						
																						<div class="form-group" data-field-type='string'>
																						   <label><?= $param_label; ?></label>
																						   <input type="text" name="<?= $fetch_parameters['PARAM_NAME'] ?>" class="form-control form-control-sm" placeholder="<?= encodes($fetch_parameters['TEXT']); ?>" value="<?= $fetch_parameters['DEFAULT_PARAM']; ?>" disabled>
																						</div>






																					<?php } else {
																						$options = $fetch_parameters['PARAM_TYPE'];
																						$values = explode(";", $options); ?>
																						
																						<div class="form-group" data-field-type='dropdown'>
																							<label><?= $param_label; ?></label>
																							<select class="form-control form-control-sm" disabled>
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
																				<button type="submit" class="btn btn-success btn-block btn-outline-success d-none close_tooltip_save"><?= $save_text; ?></button>
																		</div>
																	</span>
																</li>
															<?php } ?>
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
									$strategy_id = mysqli_query($con,"SELECT sesion_id FROM session_strategy WHERE user_id = $user_id");
									
									$id = mysqli_fetch_assoc($strategy_id);								 

									?>								
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
	

		

		<div class="download-tab">	
			<div class="container-fluid h-100 py-6">			
				<div class="row">
					<div class="col-sm-4">
						<div class="system-defination">							
						</div>
					</div>
					<div class="col-sm-8">
						<div class="right-options">
							<form>
								<div class="form-group">
									<input type="checkbox" name="checkbox-1"> I've read and understand system definition
								</div>
								<div class="form-group">
									<input type="checkbox" name="checkbox-2"> I've read and I agree with <a href="#">general condition</a>
								</div>
								<button type="button" id="download-next">Downloaded Next</button>				
							</form>
						</div>
					</div>
				</div>
			</div>						
		</div>	


		<div class="row system_defination_btn">
			<div class="col-sm-12">
				
				<?php $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
				
				<input type="hidden" name="siteLink" value="<?= $actual_link?>?action=chart_data" data-validateId = "">

				<button type="button" id="save_data" class="btn btn-success" data-action="<?= $actual_link; ?>?action=save_data" style="float: right;"> <img src="images/ajax-loader.gif" style="display: none;">  <span>Save Strategy</span> </button>
				
				<?php
					$strategy_summary_text = mysqli_query($con,"SELECT * FROM `translations` WHERE CONCEPT_NAME='STRATEGY_TEXT3' AND LANG_ID='$lang_id'");
				?>
				<button type="button" id="close_tooltipseter_" class="btn build-next" data-tooltip-content="#tooltip_content_definition" data-action="<?= $actual_link; ?>?action=system_defination" style="margin-top: 20px; margin-left: -14px;float: left;">  <span><?= encodes(mysqli_fetch_assoc($strategy_summary_text)['TEXT']); ?></span> </button>

				<!-- <button type="button" class="btn build-next" style="margin-top: 20px; margin-left: -14px;float: left;">  <span><?= encodes(mysqli_fetch_assoc($strategy_summary_text)['TEXT']); ?></span> </button> -->
				<br>

			</div>
			<!-- <br> -->
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