<!-- New Build Screen -->

		<div class="build-tab">			
			<div class="container-fluid h-100 py-6" style="    padding-bottom: 0 !important;">				
				<div class="row">	
					<div class="col-sm-1" style="position: absolute; height: 67.5vh;">
						<!-- <div class="tab element_tab_ " onmouseover="openNav()" onmouseout="closeNav()" > -->
						<div class="tab element_tab_ closeNav openNav" onmouseover="openNav()">
							<nav style="padding-top: 50px; height: 67.5vh;">
								<div class="nav navigation_tabs nav-fill" id="nav-tab" role="tablist">
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
											<button class="tablinks testing" onclick="openCity(event, '<?= $element_group_id ?>')" id="defaultOpen"><?= encodes($group_name_row['TEXT']); ?></button>
											
										<?php }

									?>
								</div>
							</nav>
						 
						</div>
						<!-- <div id ="mySidenav" class="sidenav_element_tab" onmouseover="openNav()" onmouseout="closeNav()"> -->
						<div id ="mySidenav" class="sidenav_element_tab closeNav" onmouseover="openNav()" >
								<h6 class="element-title">
									<?php
									 	$strategy_text_1_row = mysqli_query($con,"SELECT  `TEXT` FROM `translations` WHERE  `CONCEPT_NAME` = 'STRATEGY_TEXT1' AND LANG_ID = '$lang_id'");
									 	echo encodes(mysqli_fetch_assoc($strategy_text_1_row)['TEXT']);
									?>								
								</h6>
								<?php
									$element_groups = mysqli_query($con, "SELECT `GROUP_NAME`, `ORDER_ID` FROM `element_group`");
									$tab_count = 0;
									while ($element_group = mysqli_fetch_array($element_groups)) {
										$tab_count++;
									  	 $id = $element_group['GROUP_NAME'].'-tab';
										$href = $element_group['GROUP_NAME'];
										$element_name = $element_group['GROUP_NAME'];
										$element_id = $element_group['ORDER_ID'];
									 ?>
											<!-- <div class="tab-pane fade <?php if($element_group['ORDER_ID'] == 1) echo 'show active'; ?>" id="<?= $href; ?>" role="tabpanel" aria-labelledby="<?= $id; ?>" style="color: black;"> -->
											<div class="tabcontent" id="<?= $element_id ?>">
												<div class="ui-widget ui-helper-clearfix">
													<ul class="gallery ui-helper-reset ui-helper-clearfix" id="sortable" style="height: 53.5vh; padding: 0px 5px;">
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
																			
																			
																			<p class="el-desc design_p"> <?= $el_description; ?>  <a href="<?= $fetching_omc['MORE_INFO_URL']; ?>" target='_blank'> <?= encodes(mysqli_fetch_assoc($el_info_obj)['TEXT']); ?> </a></p>
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
															<?php } ?>
														<?php endif; ?>

													</ul>
												</div>
											</div>
								<?php } ?> 
							
						</div>
					</div>

					<div class="col-sm-11" style="left: 10%; padding: 0 !important; height: 567px; overflow: hidden;">
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
																	<ul id="trash testing" class="trash ui-widget-content ui-state-default" style="width: 100%; overflow-x: auto;">
																		
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