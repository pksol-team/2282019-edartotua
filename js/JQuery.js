$(document).ready(function() {

	$(document).on('click', 'li.paramsmeters', function(e) {

		var $this = $(this);

		var tooltip_content = $this.find('span[data-template]');

		var existsContentDiv = tooltip_content.attr('class');

		$('#' + existsContentDiv).remove();

		var template = tooltip_content.clone().appendTo('.tooltip_templates').show();
		template.attr('id', template.attr('class'));

		if ($.tooltipster.instances($this).length == 0) {

			$this.tooltipster({
				theme: 'tooltipster-light',
				interactive: true,
				onlyOne: true,
				trigger: 'click',
				position: "bottom",

				functionReady: function(origin, tooltip) {

					$('.close_tooltip').on("click", function() {
						origin.hide();
					});

					$('.close_tooltip_save').on('click', function() {

						$this.find('[data-template]').remove();
						var reposDiv = $(tooltip.tooltip).find('[data-template]').clone().appendTo($this).removeAttr('id').hide();
						origin.hide();

					});

				},

				functionAfter: function(instance, helper) {
					$this.tooltipster('destroy');
					setTimeout(function(){
						if(!($(".left_elements_tab").is(':hover')) && !($('.tooltipster-base').is(':visible'))){						
						// if(!($(".left_elements_tab").is(':hover'))){
							$(".left_elements_tab").animate({
									left: "-999px",
								}, 'slow');
						}
					}, 100);
					// $('#save_data').trigger('click');
				},

			});

			$this.tooltipster('show');
		}

	});

	$(document).on('input', 'span[data-template] input[type="number"]', function(e) {
		$(this).attr('value', $(this).val());
	});

	$(document).on('input', 'span[data-template] [data-field-type="string"] input[type="text"]', function(e) {
		$(this).attr('value', $(this).val());
	});

	$(document).on('keypress keyup blur', 'span[data-template] input[step="any"]', function(event) {
		$(this).attr('value', $(this).val().replace(/[^0-9\.]/g, ''));
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});

	$(document).on('change', 'span[data-template] select', function(e) {
		var $this = $(this);
		$this.find("option:selected").attr('selected', true);
		$this.find('option:not(:selected)').removeAttr('selected');
	});

	$(document).on('click', '.form-check-label', function(e) {
		$(this).prev().trigger('click');
	});

	$(document).on('change', 'span[data-template] input[type="checkbox"]', function(e) {

		if (this.checked) {
			$(this).attr('checked', true);
		} else {
			$(this).removeAttr('checked', true);
		}

	});

	set_default_lis($);

	var deleteContent = $(".delete-div").html();
	// var savingContent = '<div style="z-index: 100;"><p><strong>Saving...</strong><span class="saving"><i class="fa fa-spinner fa-spin" style="font-size:70px; color:#4b4d4e;"></i></span></p></div>';

	$(document).on('click', '#save_data', function(e) {
		e.preventDefault();

		var $this = $(this);

		// $(".delete-div").html(savingContent);

		setTimeout(function() {

			var button = $this;

			button.find('img').show();
			button.find('span').text('saving');

			var strategy_data = new Object();

			$('#nav-tabContent2 .omc.tab-pane').each(function(index, tabs) {

				var $tabs = $(tabs);
				var RowData = '';

				$tabs.find('.trash').each(function(index, rows) {

					var $rows = $(rows);
					var elements = '';

					if ($rows.find('li').length > 2) {

						$rows.find('li').each(function(index, li) {

							var $li = $(li);
							var paramsData = '';

							if ($li.hasClass('add_sequence') == false && $li.hasClass('dashed_image_li') == false) {

								// console.log($li);

								var element_id = $li.find('img').attr('data-elementid');

								$li.find('[data-template="true"] [data-field-type]').each(function(index, params) {
									var $param = $(params);

									if ($param.attr('data-field-type') == 'integer' || $param.attr('data-field-type') == 'string' || $param.attr('data-field-type') == 'double') {

										paramsData += $param.find('input').attr('value') + ',';

									} else if ($param.attr('data-field-type') == 'bool') {

										if ($param.find('input').is(':checked')) {
											paramsData += '1' + ',';
										} else {
											paramsData += '0' + ',';
										}

									} else {

										paramsData += $param.find('select').val() + ',';

									}

								});

								elements += element_id + ',' + paramsData.slice(0, -1) + ';';
							}

						});
					}

					RowData += '@' + elements;

				});

				strategy_data[$tabs.attr('id')] = RowData.substr(1);

			});

			var url = button.attr('data-action');

			$(".loader").show();

			$.ajax({
					url: url,
					type: 'POST',
					data: strategy_data,
				})
				.done(function(response) {

					console.log(response);
					button.find('img').hide();
					button.find('span').text('Saved');

					if (response.length > 20) {
						var new_data = $("input.element_data_new").val();

						if(new_data == ''){
							$("input.element_data_new").val(response);						
						}else{
							$("input.element_data_old").val(new_data);
							$("input.element_data_new").val(response);
						}
						$("div.img-validate, .build-next").addClass('scnd_step');
						$("div.img-validate img, .build-next, div.right-arrow img").css('cursor', 'pointer');
						// $(".delete-div").html(deleteContent);

					} else {
						// $("div.img-validate, .build-next").removeClass('scnd_step');
					}

				});

		}, 1000);


		if($.tooltipster.instances($('.build-next')).length > 0){

			$(".build-next").tooltipster('destroy');			

		}

		// Validate previous and current element data
		var old_value = $("input.element_data_old").val();
		var new_value = $("input.element_data_new").val();
		if(old_value != new_value){	
			$(".build-next").removeClass('button_clicked');						
		}

	});





	// Whizard OPEN



	var activeWhizard = $("div.top-row").find('div.active');

	activeWhizard.find('p').css('font-weight', 'bold');

	$("div.img-validate, .build-next").addClass('scnd_step');
	$("div.img-download").addClass('thrd_step');
	
	
	// Build Whizerd
	$('div.img-build').on('click', function() {

		$('div.whizerd:eq(1)').find('p').css('font-weight', 'bold');
		$('div.whizerd:eq(1)').addClass('active');
		$('div.whizerd:eq(1)').find('img').attr('src', 'images/build-active.png');

		$('div.whizerd:eq(3)').removeClass('active');
		$('div.whizerd:eq(3)').find('img').attr('src', 'images/validate.png');
		$('div.whizerd:eq(3)').find('p').css('font-weight', 'normal');
		$("p.active-tab-right").html($('div.whizerd:eq(3)').find('p').html());

		$('div.whizerd:eq(5)').removeClass('active');
		$('div.whizerd:eq(5)').find('img').attr('src', 'images/download.png');
		$('div.whizerd:eq(5)').find('p').css('font-weight', 'normal');

		// Arrows
		$('.left-arrow').css('visibility', 'hidden');
		$('.right-arrow').css('visibility', 'visible');


		// Bullets
		$(".animate_bullets_left").animate({
			backgroundPosition: '0'
		}, 200);
		$(".animate_bullets_right").animate({
			backgroundPosition: '0'
		}, 200);

		$("div.build-tab").css({
			display: 'block',
			position: 'relative'
		}).animate({
			"right": "0"
		}, 'slow');

		$("div.validate-tab").css({
			display: 'none',
			position: 'absolute',
			left: '9999px',
			right: '0px'
		});

		$("div.download-tab").css({
			display: 'none',
			position: 'absolute',
			left: '9999px'
		});
		$(".system_defination_btn").show(1);

	});

		$(document).on('click', '.scnd_step', function() {

			$this = $(this);

			var activeClass;
			if ($('div.whizerd:eq(1)').hasClass('active')) {
				activeClass = 1;
			} else {
				activeClass = 5;
			}

			if($("input.validate_visisted").val() != 'visited'){
				
				prev_value = $("input.element_data_old").val();
				next_value = $("input.element_data_new").val(); 			

			}

	 			$('#save_data').trigger('click');	

	 			$("input.element_data_old").val(prev_value);
	 			$("input.element_data_new").val(next_value);

			
			


			var ajaxIndex = 0;

			$(document).ajaxComplete(function(event, xhr, settings) {

				var error_txt = $("input.error_code_data").attr('data-error');
				
				var error_0 = error_txt+" "+$("input.error_code_data").attr('data-error-0');
				
				ajaxIndex++;    


				if (ajaxIndex == 1) {

					if (xhr.responseText.length > 20 || settings.url.includes('system_defination')) {

						if(validate_strategy($) == true){
							// Display validation screen
							if(!$this.hasClass('build-next')){

								$("input.validate_visisted").val('visited');									$("inupt.validate_visisted").val('visited');
								$(".summary-btn, div.img-download").addClass('thrd_step');

								$("p.active-tab-left").html($('div.whizerd:eq(1)').find('p').html());
								$('div.whizerd:eq(1)').find('p').css('font-weight', 'normal');
								$('div.whizerd:eq(1)').removeClass('active');
								$('div.whizerd:eq(1)').find('img').attr('src', 'images/build.png');


								$('div.whizerd:eq(3)').addClass('active');
								$('div.whizerd:eq(3)').find('img').attr('src', 'images/validate-active.png');
								$('div.whizerd:eq(3)').find('p').css('font-weight', 'bold');


								$('div.whizerd:eq(5)').removeClass('active');
								$('div.whizerd:eq(5)').find('img').attr('src', 'images/download.png');
								$('div.whizerd:eq(5)').find('p').css('font-weight', 'normal');
								$("p.active-tab-right").html($('div.whizerd:eq(5)').find('p').html());

								// Arrows		 						
								$('.left-arrow').css('visibility', 'visible');
								$('.right-arrow').css('visibility', 'visible');



								$("div.build-tab").css({
									display: 'none',
									position: 'absolute',
									right: '9999px'
								});



								if (activeClass == 1) {
									// Bullets
									$(".animate_bullets_left").animate({
										backgroundPosition: '128px'
									}, 200);
									// Tab
									$("div.validate-tab").css({
										display: 'block',
										position: 'relative'
									}).animate({
										"left": "0"
									}, 'slow');
								} 
								else {
									$(".animate_bullets_right").animate({
										backgroundPosition: '0px'
									}, 200);
									$("div.validate-tab").css({
										display: 'block',
										position: 'relative'
									}).animate({
										"right": "0"
									}, 'slow');
								}

								$("div.download-tab").css({
									display: 'none',
									position: 'absolute'
								}).animate({
									"left": "9999px"
								}, 'slow');
								// $(".build-next").removeClass('button_clicked');
							}
							else{
								
								var old_value = $("input.element_data_old").val();
								var new_value = $("input.element_data_new").val();
								console.log(old_value, new_value);
								if(old_value == new_value){															
									console.log("Matched");
									// $(".build-next").addClass('open_scnd_tooltip');
									
									// $(".build-next").trigger('open_scnd_tooltip');

									var old_defintion = $(".system-defination").html();

									if($.tooltipster.instances($('.build-next')).length > 0){

										$(".build-next").tooltipster('destroy');			

									}		    
									var definition = '<div class="checking" style="width: 320px; position: relative;"><span class="close_tooltip"><i class="fa fa-close"></i></span>'+old_defintion+'</div>';
									
									$('span.append_response').html(definition);

									$('.build-next').tooltipster({
									    	contentCloning: true,
									    	trigger: 'click',
									    	theme: 'tooltipster-light',
											interactive: true,
											functionReady: function(origin, tooltip) {

												$('.close_tooltip').on("click", function() {
													origin.hide();
												});
											},

									});
									$(".build-next").tooltipster('show');
									
								}else{

									console.log("Not Matched");

									
									$("input.validate_visisted").val('');
									if($.tooltipster.instances($('.build-next')).length > 0){

										$(".build-next").tooltipster('destroy');			

									}	
									$this.addClass('button_clicked');
									$(".system-defination").html('<div style="position: relative;top: 50%;"><img src="images/ajax-loader-green.gif" style="margin-top: -2%;"></div>');

									$this.attr('disabled', true);
									var session_id = $("input[name=session_strategy_id]").val();
									var url = $this.attr('data-action');
									
																	
									$.ajax({
										url: url,
										type: 'POST',
										data: {
											insert_data: 'insertion',
											session_id: session_id
										},
									})
									.done(function(response) {										
										var btn_text = $(".system_defination_btn").find('div button.build-next span').html();
										var refresh_icon = btn_text+'<i class="fa fa-refresh fa-spin refresh_definition" style="font-size:18px; margin-left: 10px;"></i>';
										$(".system_defination_btn").find('div button.build-next span').html(refresh_icon);
									


										var definition_id = response;
										var close_interval;
										close_interval = setInterval(function(){
											$.ajax({
												url: url,
												type: 'POST',
												data: {
													insert_data: '',
													strategy_definition_id: definition_id
												},
											})
											.done(function(response) {											

												// console.log($(".download_pay"));

												if(response.length > 8){

													// $(".download_pay").attr('disabled', false);

													$("i.refresh_definition").hide();

													if($.tooltipster.instances($('.build-next')).length > 0){

														$(".build-next").tooltipster('destroy');			

													}

													var definition = '<div style="width: 320px; position: relative;"><span class="close_tooltip"><i class="fa fa-close"></i></span>'+response+'</div>'
													$('span.append_response').html(definition);

													$('.build-next').tooltipster({
													    	contentCloning: true,
													    	trigger: 'click',													    	
													    	theme: 'tooltipster-light',
															interactive: true,
															functionReady: function(origin, tooltip) {

																$('.close_tooltip').on("click", function() {
																	origin.hide();
																});																

															},
													});

													$(".build-next").tooltipster('show');

													clearInterval(close_interval);
													$(".build-next").attr('disabled', false);
													$(".system-defination").html(response).show();
												}																		
											});
											
										}, 1000);
									});
								}
							}
						}												
					}
					else {		

					 	if(settings.url.includes('save_data')){
							alert(error_0);
					 	}
					}

				}

			});
			console.log("validate");
			setTimeout(function(){
			$(".system_defination_btn").show();
			   
			}, 450);
		});



	// Download Whizerd
	$(document).on('click', '.thrd_step', function() {


		var ajaxIndex = 0;

		if($("input.validate_visisted").val() != 'visited'){
			
			prev_value = $("input.element_data_old").val();
			next_value = $("input.element_data_new").val(); 			
		}

		$('#save_data').trigger('click');	

		$("input.element_data_old").val(prev_value);
		$("input.element_data_new").val(next_value);


		$(document).ajaxComplete(function(event, xhr, settings) {

			var error_txt = $("input.error_code_data").attr('data-error');
			
			var error_0 = error_txt+" "+$("input.error_code_data").attr('data-error-0');
			
			ajaxIndex++;    


			if (ajaxIndex == 1) {

				if (xhr.responseText.length > 20 || settings.url.includes('system_defination')) {
					if(validate_strategy($) == true){

						$(".system_defination_btn").hide();
						$("input.validate_visisted").val('');
						var old_value = $("input.element_data_old").val();
						var new_value = $("input.element_data_new").val();
						 console.log(old_value)
						if(old_value != new_value){
							
							$(".download_pay").attr('disabled', true);

							if(!$("button.build-next").hasClass('button_clicked')){
								$(".system-defination").html('<div style="position: relative;top: 50%;"><img src="images/ajax-loader-green.gif" style="margin-top: -2%;"></div>');
								$(".build-next").addClass('button_clicked');

								$(".build-next").attr('disabled', true);
								var session_id = $("input[name=session_strategy_id]").val();
								var url = $(".build-next").attr('data-action');
								$.ajax({
									url: url,
									type: 'POST',
									data: {
										insert_data: 'insertion',
										session_id: session_id
									},
								})
								.done(function(response) {
									var definition_id = response;
									var close_interval;
									close_interval = setInterval(function(){
										$.ajax({
											url: url,
											type: 'POST',
											data: {
												insert_data: '',
												strategy_definition_id: definition_id
											},
										})
										.done(function(response) {
											if(response.length > 8){
												// $(".download_pay").attr('disabled',false);

												if($.tooltipster.instances($('.build-next')).length > 0){

													$(".build-next").tooltipster('destroy');			

												}
												var definition = '<div style="width: 320px; position: relative;"><span class="close_tooltip"><i class="fa fa-close"></i></span>'+response+'</div>'
												$('span.append_response').html(definition);

												$('.build-next').tooltipster({
												    	contentCloning: true,
												    	trigger: 'click',
												    	theme: 'tooltipster-light',
														interactive: true,
														functionReady: function(origin, tooltip) {

															$('.close_tooltip').on("click", function() {
																origin.hide();
															});																

														},
																	
												});

												// $(".build-next").tooltipster('show');

												clearInterval(close_interval);
												$(".build-next").attr('disabled', false);
												$(".system-defination").html(response).show();
												$(".build-next").addClass('button_clicked');
											}																		
										});
										
									}, 1000);
								});
							}			
						}

						$this = $(this);
						$("p.active-tab-left").html($('div.whizerd:eq(3)').find('p').html());
						$('div.whizerd:eq(1)').removeClass('active');
						$('div.whizerd:eq(1)').find('p').css('font-weight', 'normal');

						$('div.whizerd:eq(3)').removeClass('active');
						$('div.whizerd:eq(3)').find('img').attr('src', 'images/newValidate.png');
						$('div.whizerd:eq(3)').find('p').css('font-weight', 'normal');

						$('div.whizerd:eq(5)').addClass('active');
						$('div.whizerd:eq(5)').find('img').attr('src', 'images/download-active.png');
						$('div.whizerd:eq(5)').find('p').css('font-weight', 'bold');

						// Arrows
						$('.right-arrow').css('visibility', 'hidden');
						$('.left-arrow').css('visibility', 'visible');


						$("div.build-tab").css({
							display: 'none',
							position: 'absolute',
							right: '9999px'
						});
						$("div.validate-tab").css({
							display: 'none',
							position: 'absolute',
							right: '9999px',
							left: 'unset'
						});
						$(".animate_bullets_right").animate({
							backgroundPosition: '128px'
						}, 200);
						$(".animate_bullets_left").animate({
							backgroundPosition: '128px'
						}, 200);

						$("div.download-tab").css({
							display: 'block',
							position: 'relative',
						}).animate({
							"left": "0"
						}, 'slow');
					}

				}
				else{
					alert(error_0);
				}
			}
		});

	});

	// Previous Arrow
	$('div.left-arrow').on('click', function() {
		var active_div = $(this).nextUntil('div.active');
		var current_tab = active_div.prev().hasClass('img-validate');

		if (current_tab) {

			$('div.img-validate').trigger('click');

		} else {

			$('div.img-build').trigger('click');

		}


	});


	// Continue Arrow
	$('div.right-arrow').on('click', function() {

		var build_li_length = $("ul#trash li").length;

		var active_div = $(this).prevUntil('div.active');
		var current_tab = active_div.prev().hasClass('img-build');

		if (current_tab) {

			$('div.img-validate').trigger('click');

		} else {

			$('div.img-download').trigger('click');

		}

	});

	

	$("#validate-next").on('click', function() {
		$("#chartContainer").hide();
		$(".validatingGraph").html('<div style="position: relative;top: 50%;"><img src="images/ajax-loader-green.gif" style="margin-top: -2%;"><span>Data Insertion...</span></div>').show();
		$(".validatedScreen").hide();
		$(".validatingScreen").show();


		var validation_data = $(".validate-form").serializeArray();
		var url = $(this).attr('data-action');
		$.ajax({
				url: url,
				type: 'POST',
				data: validation_data,
			})
			.done(function(response) {

				$('#validate-next').attr('disabled', true);
				$('#validate-next').css('cursor', 'not-allowed');

				var url = $("input[name='siteLink']").val();
				var validation_id = response;
				var dps = []; // dataPoints
				var y_axis_points = []; // dataPoints				
				var chart = new CanvasJS.Chart("chartContainer", {
					axisY: {
					},
					axisX:{
						minimum : 1,
						interval: 50
					},
					data: [{
						type: "line",
						dataPoints: dps
					}]
				});

				
				var updateInterval = 500;
				


				// OLD WORK DYNAMIC GRAPH

				// var updateChart = function(validateId) {

				// 	$.ajax({
				// 			url: url,
				// 			type: 'POST',
				// 			data: {
				// 				sesion_val_id: validateId
				// 			},
				// 		}).done(function(response) {

				// 			var responseData = jQuery.parseJSON(response.trim());

				// 			var status = responseData.status;


				// 			if (status == 'N') {
				// 				$(".validatingGraph").html('<div style="position: relative;top: 50%;"><img src="images/ajax-loader-green.gif" style="margin-top: -2%;"><span>Loading Data...</span></div>');
				// 			}
				// 			if (responseData.y_axix != undefined && status != 'N') {
				// 				$(".validatingGraph").hide();
				// 				$("#chartContainer").show();


				// 				dps.push({
				// 					// x: i,
				// 					// x: parseInt(responseData.x_axix),
				// 					y: parseFloat(responseData.y_axix)
				// 				});
				// 				// i++;
				// 				chart.render();
				// 			}



				// 			if (status == 'F' && responseData.y_axix == undefined) {


				// 				var report = responseData.report;
				// 				if(responseData.report == ''){
				// 					resultReport = "<div style='position: relative;top: 50%;'><p style='margin-left: 3%;'>No record found...</p></div>";
				// 					$("#chartContainer").hide();
				// 					$(".validatingGraph").html(resultReport).show();

				// 				}else{								
				// 					var resultReport = "<p style='margin-left: 3%;'>";
				// 					var arrReport = report.split(';');
				// 					$.each( arrReport, function( index, value ) {
				// 					    resultReport += value+"<br>"; 
				// 					});
				// 					resultReport += "</p>";
				// 				}
				// 				$(".validatingScreen").hide();
				// 				$(".validatedScreen").html(resultReport).show();
				// 				clearInterval(interval);
				// 				if (response.length > 0) {
				// 					$("div.img-download, .summary-btn").addClass('thrd_step');

				// 				} else {
				// 					$("div.img-download, .summary-btn").removeClass('thrd_step');
				// 				}
				// 				$('#validate-next').attr('disabled', false);
				// 				$('#validate-next').css('cursor', 'pointer');


				// 			}
				// 		});
				// };

				var updateChart = function(validateId) {
					$.ajax({
							url: url,
							type: 'POST',
							data: {
								sesion_val_id: validateId
							},
						})
						.done(function(response) {

							var responseData = jQuery.parseJSON(response.trim());
							
							if(responseData.status == 'N'){
								$(".validatingGraph").html('<div style="position: relative;top: 50%;"><img src="images/ajax-loader-green.gif" style="margin-top: -2%;"><span>Loading Data...</span></div>');								
							}

							else if(responseData.status == 'P' ) {	
								console.log(responseData.y_axix);

								$(".validatingGraph").hide();
								$("#chartContainer").show();

								var y_axix = responseData.y_axix;

								console.log(y_axix);

								if(y_axix.length > 0){

								for (var i = 0; i < y_axix.length ; i++) {										
									dps.push({
										y: parseFloat(y_axix[i])
									});

									y_axis_points.push(parseFloat(y_axix[i]));

								}

								

								var x_interval = y_axis_points.length/4;
								console.log("x_interval = ");
								console.log(x_interval);
								chart.options.axisY.minimum = Math.min.apply(Math,y_axis_points);	
								chart.options.axisX.interval = Math.round(x_interval);	
								// console.log(y_axis_points);
									chart.render();
								}	
							}else if(responseData.status == 'F'){

								var report = responseData.report;
								console.log(report);
								if(responseData.report != null){
									var resultReport = "<p style='margin-left: 3%;'>";
									var arrReport = report.split(';');
									$.each( arrReport, function( index, value ) {
									    resultReport += value+"<br>"; 
									});
									resultReport += "</p>";
								}else{
									resultReport = "<div style='position: relative;top: 50%;'><p style='margin-left: 3%;'>No record found...</p></div>";									
								}
								
								$(".validatingScreen").hide();

								$(".validatedScreen").html(resultReport).show();


								$('#validate-next').attr('disabled', false);
								$('#validate-next').css('cursor', 'pointer');
								clearInterval(interval);
							}
						});

				};

				updateChart(validation_id);

				interval = setInterval(function() {
					updateChart(validation_id)
				}, updateInterval);


			});
	});



	// Whizard Close


	
	// Hover on build strategy screen
		

		var div_height = $(".left_elements_tab").css('height');
		$('.add_elements_plus').hover(function() {

			var body_cursor = $('body').css('cursor');
			if (!$('.tooltipster-base').is(':visible') && (body_cursor != 'move')) {
				
				$('.left_elements_tab').css('visibility', 'visible').animate({
					left: "-15px",
				}, {
					easing: 'swing',
					duration: 500,
					complete: function() {
						if($('.tooltipster-base').is(':visible')){							
							$(".left_elements_tab").animate({
								left: "-15px",
							}, 'slow');								
						}else
						if (!($('.left_elements_tab').is(':hover')) && !($('.add_elements_plus').is(':hover'))) {
							$(".left_elements_tab").animate({
								left: "-999px",
							}, 'slow');
						}

					}
				});

			}


			

		});

		$(".delete_element_tab").click(function(event) {
			$(".left_elements_tab").animate({
				left: "-999px",
			}, 'slow');
		});

		$('.left_elements_tab').mouseleave(function(event) {

			var body_cursor = $('body').css('cursor');

			if(body_cursor == 'auto' && !($('.tooltipster-base').is(':visible'))) {
				
				$(".left_elements_tab").animate({
					left: "-999px",
				}, 'slow');

			}


		});


		






});

function set_default_lis($, row_L = false) {

	var icon = $("#nav-tab2 .active").attr('data-icon-id');

	$('#nav-tabContent .gallery').find('[data-element-append]').each(function(index, el) {
		var $this = $(el);

		if ($this.attr('data-title') != 'SEQ') {

			var element_id = $this.attr('data-element-append');


			if (row_L != false) {

				if (element_id == icon) {
					var first_row = row_L.find('.trash');
					var appendedEl = $this.clone().appendTo(first_row).show();
					appendedEl.find('[disabled]').removeAttr('disabled');
					appendedEl.find('.d-none').removeClass('d-none');


					var alreadyClass = appendedEl.find('span').attr('class');
					var rowID = (row_L.attr('class').split('gallery_new'))[1];

					appendedEl.find('span:first').attr('class', alreadyClass + '-' + rowID);

					appendedEl.attr('data-tooltip-content', '#' + alreadyClass + '-' + rowID);

					// $("<button type='button' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button>").appendTo(appendedEl);
					$("<button type='button' class='close' aria-label='Close'>x</button>").prependTo('.gallery_new'+rowID);


				}

			} else {

				var first_row = $('.tab-pane[data-tab_id="' + element_id + '"] table tr:first td .trash');
				var appendedEl = $this.clone().appendTo(first_row).show();
				appendedEl.find('[disabled]').removeAttr('disabled');
				appendedEl.find('.d-none').removeClass('d-none');
				$("<button type='button' class='close' aria-label='Close'>x</button>").prependTo('.gallery_new'+rowID);


				// $("<button type='button' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button>").appendTo(appendedEl).hide();

			}



		}

	});

}

function setScrollAndIndex($) {

	$('table .trash:visible').each(function(index, el) {

		var row = $(el);
		var allListWidth = 0;

		row.find('li:visible').each(function(index2, el2) {

			var li = $(el2);
			li.attr('data-index', index2);
			allListWidth += li.outerWidth() + 5;

		});

		row.width(allListWidth);

	});

}

function validate_strategy($){

	var error_txt = $("input.error_code_data").attr('data-error');
	
	// var error_0 = error_txt+" "+$("input.error_code_data").attr('data-error-0');
	var error_1 = error_txt+" "+$("input.error_code_data").attr('data-error-1');
	var error_2 = error_txt+" "+$("input.error_code_data").attr('data-error-2');
	var error_3 = error_txt+" "+$("input.error_code_data").attr('data-error-3');

	var check_li_first =[];
	var check_li_last =[];
	var chack_two_arrow = [];

	// Validation elements arrangement
	$('#nav-tabContent2 .omc.tab-pane').each(function(index, tabs) {

		var $tabs = $(tabs);
		var RowData = '';


		$tabs.find('.trash').each(function(index, rows) {

			var $rows = $(rows);

			var li_length = $rows.find('li').length;

			var third_last_li = li_length-2;

			var first_li = $rows.find('li:first-child');
			
			var scnd_li = $rows.find('li:nth-child('+third_last_li+')');

			
			check_li_first.push(first_li.hasClass('sequence_li'));
			check_li_last.push(scnd_li.hasClass('sequence_li'));
			
			
			$rows.find('li').each(function(index, li) {

				var $li = $(li);
				
				var boolean_ = $li.hasClass('sequence_li') && $li.next().hasClass('sequence_li');
				chack_two_arrow.push(boolean_);

				
			});
		});
	});

			// console.log(jQuery.inArray(true, check_li_last));

	// Disply error popup
	if(jQuery.inArray(true, check_li_last) != '-1' || jQuery.inArray(true, check_li_first) != '-1' || jQuery.inArray(true, chack_two_arrow) != '-1'){
		if(jQuery.inArray(true, check_li_first) != '-1'){
			alert(error_1);
		}
		if(jQuery.inArray(true, check_li_last) != '-1'){
			alert(error_2);
		}
		if(jQuery.inArray(true, chack_two_arrow) != '-1'){
			alert(error_3);
		}						
	}else{

		return true;
	}
}

$(document).ready(function() {
	setTdWidth($);
});


function setTdWidth($) {
	$('table tr td').width($('#nav-tab2').outerWidth() - 24);
}


$(document).on('click', '.open_scnd_tooltip', function(event) {
	event.preventDefault();
	
	var old_defintion = $(".system-defination").html();

	if($.tooltipster.instances($('.build-next')).length > 0){

		$(".build-next").tooltipster('destroy');			

	}		    
	var definition = '<div class="checking" style="width: 320px; position: relative;"><span class="close_tooltip"><i class="fa fa-close"></i></span>'+old_defintion+'</div>';
	
	$('span.append_response').html(definition);

	$('.build-next').tooltipster({
	    	contentCloning: true,
	    	trigger: 'click',
	    	theme: 'tooltipster-light',
			interactive: true,
			functionReady: function(origin, tooltip) {

				$('.close_tooltip').on("click", function() {
					origin.hide();
				});
			},

	});
	$(".build-next").tooltipster('show');

});

$(document).on('click', 'input[name="read_accept"], input[name="agree_condition"]', function(event) {
	if($(this).attr('checked')){
		$(this).removeAttr('checked');
	}else{
		$(this).attr('checked', true);		
	}
	var first_option = $('input[name="read_accept"]').attr('checked');
	var scnd_option = $('input[name="agree_condition"]').attr('checked');

		console.log(first_option, scnd_option);
		if(first_option == 'checked' && scnd_option == 'checked'){
			$(".download_pay").attr('disabled', false);
		}else{
			$(".download_pay").attr('disabled', true);			
		}
});






$(document).on('click', '.download_pay', function(event) {
	event.preventDefault();
	$('a.reset').trigger('click');
	var first_option = $('input[name="read_accept"]').attr('checked');
	var scnd_option = $('input[name="agree_condition"]').attr('checked');

	// console.log(first_option, scnd_option);
	// if(first_option != 'checked' || scnd_option != 'checked'){
		// $(".download_pay").attr('disabled', false);

		// if(first_option != 'checked' && scnd_option != 'checked'){
		// 	alert("Please check the options");
		// }
		// else if(first_option != 'checked'){
		// 	alert("Please check fst");
		// }else{
		// 	alert("Please check scnd");
		// }
	// }else{

		$(".download_pay").attr('disabled', true);
		$('.payment_loader').show();
		var session_id = $("input[name=session_strategy_id]").val();
		var  url = $("input[name='session_compiled']").val();
		$.ajax({
			url: url,
			type: 'POST',
			data: {
				session_id: session_id
			},
		})
		.done(function(response) {
			var compile_id = $.trim(response);
			var close_interval;
            var url = $("input[name='check_link_status']").val();
			close_interval = setInterval(function(){
				$.ajax({
					url: url,
					type: 'POST',
					data: {
						compile_id: compile_id
					},
				})
				.done(function(response) {
					var response_data = $.trim(response);
					if(response_data != ''){
						if(response_data.includes('complie_error')){	
							var error = response_data.split("complie_error");
							$(".download_pay").attr('disabled', true);
							$('.payment_loader').hide();
							$('input[name="read_accept"]').removeAttr('checked');
							$('input[name="agree_condition"]').removeAttr('checked');
							alert(error);
						}else{
							$("input.file_url_compiled").val(response_data);
							$(".download_pay").attr('disabled', false);
							$('.payment_loader').hide();
							$(".payment_stripe").fadeIn('fast', function() {
								$(".download-tab").css('opacity', '0.2');
								$(".payment_stripe").show();
							});
						}
		                clearInterval(close_interval);                    																		
					}
				});
				
			}, 1000);
		});
		

		// setTimeout(function(){
		// $('.payment_loader').hide();
		
		// $(".payment_stripe").fadeIn('fast', function() {
		// 	$(".download-tab").css('opacity', '0.2');
		// 	$(".payment_stripe").show();
		// });
			
		// }, 3000);
	// }


});

// jQuery(document).ready(function($) {
// 	console.log("testing");
// 	console.log($("input[name='cardnumber']"));
// 	// console.log($("input.is-empty").attr('placeholder'));
// });





