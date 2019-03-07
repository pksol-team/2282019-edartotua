$(document).ready(function() {
	
	$(document).on('click', 'li.paramsmeters', function(e) {
		
		var $this = $(this);
		
		var tooltip_content = $this.find('span[data-template]');
		
		var existsContentDiv = tooltip_content.attr('class');

		$('#'+existsContentDiv).remove();

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
					$('#save_data').trigger('click');
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
		$(this).attr('value', $(this).val().replace(/[^0-9\.]/g,''));
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
		
		if(this.checked) {
			$(this).attr('checked', true);
		} else {
			$(this).removeAttr('checked', true);
		}

	});

	set_default_lis($);

	$(document).on('click', '#save_data', function(e) {
		e.preventDefault();

		$this = $(this);

		setTimeout(function () {

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

							if ( $li.hasClass('add_sequence') == false && $li.hasClass('dashed_image_li') == false) {

								console.log($li);

								var element_id = $li.find('img').attr('data-elementid');

								$li.find('[data-template="true"] [data-field-type]').each(function(index, params) {
									var $param = $(params);

									if ($param.attr('data-field-type') == 'integer' || $param.attr('data-field-type') == 'string' || $param.attr('data-field-type') == 'double') {
										
										paramsData += $param.find('input').attr('value')+',';

									} else if($param.attr('data-field-type') == 'bool') {

										if($param.find('input').is(':checked')) {
											paramsData += '1'+ ',';
										} else {
											paramsData += '0'+ ',';
										}

									} else {

										paramsData += $param.find('select').val() + ',';

									}
								
								});

								elements += element_id+','+ paramsData.slice(0,-1) +';';
							}

						});					
					}

					RowData += '@'+elements;

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


				button.find('img').hide();
				button.find('span').text('Saved');
				console.log(response);

				if(response.length > 15){
					$("div.img-validate, .build-next").addClass('scnd_step');
					$(".loader").hide();
				}else{
					$("div.img-validate, .build-next").removeClass('scnd_step');

				}

			});

		}, 1000);

	});




	// Whizard OPEN




				$(".build-next, div.img-validate").on('click', function() {
					if(!$(this).hasClass('scnd_step')){
						alert('Please add atlest one element');
					}

				});
				
		 		// Build Whizerd
		 		$('div.img-build').on('click',function(){	 			


		 			$('div.whizerd:eq(1)').addClass('active');
		 			$('div.whizerd:eq(1)').find('img').attr('src', 'images/build-active.png');
		 			
		 			$('div.whizerd:eq(2), div.whizerd:eq(4)').find('img').attr('src', 'images/unfill-bullets.png');
		 			
		 			$('div.whizerd:eq(3)').removeClass('active');
		 			$('div.whizerd:eq(3)').find('img').attr('src', 'images/validate.png');
		 			
		 			$('div.whizerd:eq(5)').removeClass('active');
		 			$('div.whizerd:eq(5)').find('img').attr('src', 'images/download.png');

		 			// Arrows
		 			$('.left-arrow').css('visibility','hidden');
		 			$('.right-arrow').css('visibility','visible');

		 			// Tabs
		 			$('div.build-tab').show();
		 			$('div.validate-tab').hide();
		 			$('div.download-tab').hide();		 			
		 			

		 		});

		 		// Validate Whizerd
		 		// $('div.img-validate, #build-next').on('click',function(){
		 		$(document).on('click', '.scnd_step', function(){


		 			// var strategy_data = $("input[name='strategy_data']").val();
		 					 			
		 			// 		 			if(strategy_data != null){

		 			$('div.whizerd:eq(1)').removeClass('active');
		 			$('div.whizerd:eq(1)').find('img').attr('src', 'images/build.png'); 
		 			
		 			$('div.whizerd:eq(2)').find('img').attr('src', 'images/filled-bullets.png'); 	
		 			
		 			$('div.whizerd:eq(3)').addClass('active');
		 			$('div.whizerd:eq(3)').find('img').attr('src', 'images/validate-active.png'); 
		 			
		 			$('div.whizerd:eq(4)').find('img').attr('src', 'images/unfill-bullets.png');
		 			
		 			$('div.whizerd:eq(5)').removeClass('active');
		 			$('div.whizerd:eq(5)').find('img').attr('src', 'images/download.png');		


		 			// Arrows
		 			$('.left-arrow').css('visibility','visible');
		 			$('.right-arrow').css('visibility','visible');
		 			
		 			// Tabs
		 			$('div.build-tab').hide();
		 			$('div.validate-tab').show();
		 			$('div.download-tab').hide();
		 				
		 					 				// console.log('not null');		 				
		 					 			// }else{
		 					 			// 	console.log('null');		 				
		 					 			// }

		 		});

		 		// Download Whizerd
		 		$('div.img-download, .summary-btn').on('click',function(){
		 			$this = $(this);

		 			$('div.whizerd:eq(1)').removeClass('active');
		 			
		 			$('div.whizerd:eq(2), div.whizerd:eq(4)').find('img').attr('src', 'images/filled-bullets.png');
		 			
		 			$('div.whizerd:eq(3)').removeClass('active');
		 			$('div.whizerd:eq(3)').find('img').attr('src', 'images/validate.png');

		 			$('div.whizerd:eq(5)').addClass('active');
		 			$('div.whizerd:eq(5)').find('img').attr('src', 'images/download-active.png');
		 			// $this.find('img').attr('src', 'images/download-active.png');

		 			// Arrows
					$('.right-arrow').css('visibility','hidden');

		 			// Tabs
		 			$('div.build-tab').hide();
		 			$('div.validate-tab').hide();
		 			$('div.download-tab').show();
		 		});

		 		// Previous Arrow
		 		$('div.left-arrow').on('click',function(){
		 			var active_div = $(this).nextUntil('div.active');
		 			var current_tab = active_div.prev().hasClass('img-validate');
		 			
		 			if(current_tab){ 	

		 				$('div.img-validate').trigger('click');

		 			}else{

		 				$('div.img-build').trigger('click');		

		 			}
		 			
		 			
		 		});


		 		// Continue Arrow
		 		$('div.right-arrow').on('click',function(){

		 			var active_div = $(this).prevUntil('div.active');
		 			var current_tab = active_div.prev().hasClass('img-build'); 		
		 			
		 			if(current_tab){
		 				
		 				$('div.img-validate').trigger('click');

		 			}else{

		 				$('div.img-download').trigger('click');	

		 			}
		 			
		 		});


		 		$("#validate-next").on('click', function() {
		 			$(".validatingGraph").hide();
		 			$('.validatingScreen').hide();
		 			$("#validateGraph").show();
		 			$('.validatedScreen').show();


		 			
		 		});


		 		 		$("#validate-next").on('click', function() {
		 		 			var validation_data = $(".validate-form").serializeArray();
		 		 			console.log(validation_data);
		 		 			var url = $(this).attr('data-action');
		 		 			$.ajax({
		 						url: url,
		 						type: 'POST',
		 						data: validation_data,
		 					})
		 					.done(function(response) {


		 						// button.find('img').hide();
		 						// button.find('span').text('Saved');
		 						// console.log("response = "+response);

		 						// if(response.length > 15){
		 						// 	$("div.img-validate, .build-next").addClass('scnd_step');
		 						// 	$(".loader").hide();
		 						// }else{
		 						// 	$("div.img-validate, .build-next").removeClass('scnd_step');
		 						// }

		 					});
		 		 		});




	// Whizard Close







	

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
					var rowID = ( row_L.attr('class').split('gallery_new') )[1];
					
					appendedEl.find('span:first').attr('class', alreadyClass+'-'+rowID);

					appendedEl.attr('data-tooltip-content', '#'+alreadyClass+'-'+rowID);	

					$("<button type='button' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button>").appendTo(appendedEl);

				}

			} else {
				
				var first_row = $('.tab-pane[data-tab_id="'+element_id+'"] table tr:first td .trash');
				var appendedEl = $this.clone().appendTo(first_row).show();
				appendedEl.find('[disabled]').removeAttr('disabled');
				appendedEl.find('.d-none').removeClass('d-none');

				$("<button type='button' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button>").appendTo(appendedEl).hide();

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
			allListWidth += li.outerWidth()+5;

		});

		row.width(allListWidth);

	});

}


$(document).ready(function() {
	setTdWidth($);
});


function setTdWidth($) {
	$('table tr td').width($('#nav-tab2').outerWidth()-24);
}