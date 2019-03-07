function drag_and_drop_elements($, type, counter) {
	var $gallery = $(".gallery"),
		$trash = $(".trash"),
		droppableDiv;

	// Let the gallery items be draggable
	$("li", $(".gallery")).draggable({
		revert: "invalid", // when not dropped, the item will revert back to its initial position
		helper: "clone",
		cursor: "move",

		
	
		// connectToSortable: ".trash",
		// revert: 'invalid',
		
		// stop: function( event, ui ) {

		// 	var element = ui.helper; //.clone().appendTo($(this)).hide().fadeIn();

		// 	var row = element.closest('td');

		// 	if (row.length > 0) {

		// 		var current_element_id = element.find('img').attr('data-elementid');

		// 		var tooltip_content = element.find('span[data-template]');

		// 		tooltip_content.find('[disabled]').removeAttr('disabled');
		// 		tooltip_content.find('button').removeClass('d-none');

		// 		var index_of_element = tooltip_content.attr('class').split('-');	
				
		// 		var tooltipClass = row.attr('class')+current_element_id+'tooltip-content'+index_of_element[1];

		// 		tooltip_content.attr('class', tooltipClass);
		// 		element.attr('data-tooltip-content', '#'+tooltipClass);

				
		// 		row.find('.dashed_image_li').insertAfter(row.find('li:last'));
		// 		row.find('.door_image_li').insertAfter(row.find('li:last'));
		// 		row.find('.dashed_image_li').hide();

		// 		console.log(element.next());

		// 		// row.find('.add_sequence').remove();
				
		// 		// $('#nav-tabContent .gallery').find('[data-title="SEQ"]').clone().removeClass('paramsmeters').addClass('add_sequence').insertAfter(element).show();
		// 		setScrollAndIndex($);
				
		// 		// element.trigger('click');

		// 	}

		// }


	});

	// Let the trash be droppable, accepting the gallery items
	if (type == 'default') {
		droppableDiv = $(".trash");
	} else {
		droppableDiv = $('.gallery_new' + counter).find('.trash');
	}


	$(".trash_dont_accept").droppable({
		drop: function(event, ui) {

			if($(this).closest('.add_new_stage').prev().find('td ul li').length > 2){
				$('#addrow').trigger('click');
				var append_ = $('table.order-list tbody:visible');
				var cloning_data = $('table.order-list tbody:visible tr:nth-last-child(2) td').find('ul.trash');
				var element = ui.draggable.clone().prependTo($(cloning_data)).hide().fadeIn();
				var row = element.closest('td');


				var current_element_id = ui.draggable.find('img').attr('data-elementid');

				var tooltip_content = element.find('span[data-template]');

				tooltip_content.find('[disabled]').removeAttr('disabled');
				tooltip_content.find('button').removeClass('d-none');

				var index_of_element = tooltip_content.attr('class').split('-');	
				
				var tooltipClass = row.attr('class')+current_element_id+'tooltip-content'+index_of_element[1];

				tooltip_content.attr('class', tooltipClass);
				element.attr('data-tooltip-content', '#'+tooltipClass);

				
				row.find('.dashed_image_li').insertAfter(row.find('li:last'));
				row.find('.door_image_li').insertAfter(row.find('li:last'));
				row.find('.dashed_image_li').hide();
				setScrollAndIndex($);
				element.trigger('click');

			}	else {
				alert('Please drop atleast one element in previous scenario...');
			}	

		}


	});
	
	droppableDiv.droppable({
		accept: ".gallery > li",
		classes: {
			"ui-droppable-active": "ui-state-highlight"
		},
		
		drop: function(event, ui) {	

			console.log('workingdrop');

			if($.tooltipster.instances($('.build-next')).length > 0){

				$(".build-next").tooltipster('destroy');			

			}	

			$(".build-next").removeClass('button_clicked');						

			$(".delete_element_tab").trigger('click');

			var element = ui.draggable.clone().appendTo($(this)).hide().fadeIn();
			
			var row = element.closest('td');

			var current_element_id = ui.draggable.find('img').attr('data-elementid');

			var tooltip_content = element.find('span[data-template]');

			tooltip_content.find('[disabled]').removeAttr('disabled');
			tooltip_content.find('button').removeClass('d-none');

			var index_of_element = tooltip_content.attr('class').split('-');	
			
			var tooltipClass = row.attr('class')+current_element_id+'tooltip-content'+index_of_element[1];

			tooltip_content.attr('class', tooltipClass);
			element.attr('data-tooltip-content', '#'+tooltipClass);

			
			row.find('.dashed_image_li').insertAfter(row.find('li:last'));
			row.find('.door_image_li').insertAfter(row.find('li:last'));
			row.find('.dashed_image_li').hide();


			// row.find('.add_sequence').remove();
			// $('#nav-tabContent .gallery').find('[data-title="SEQ"]').clone().removeClass('paramsmeters').addClass('add_sequence').insertAfter(element).show();

			setScrollAndIndex($);
			
			element.trigger('click');

			// $('#save_data').trigger('click');
			

		},
		activate( event, ui ){
			if($('.tooltipster-base').is(':visible')){
				$('.tooltipster-base').hide();
			}
			$('.left_elements_tab').css({
				visibility: 'hidden'
				// zIndex: '0'
			});

			$(ui.helper[0]).css({'visibility': 'visible', 'z-index' : '1000'});

		},
		deactivate(event, ui){
			console.log("deactivate");
			$(".left_elements_tab").animate({
				left: "-999px",
			}, 'slow');
		}

	});

	counter++;

	// Let the gallery be droppable as well, accepting items from the trash
	$(".gallery").droppable({
		accept: ".trash li",
		classes: {
			"ui-droppable-active": "custom-state-active"
		},

		activate( event, ui ) {
			$('.add_elements_plus').css('z-index', '-100');
			$('.delete-div > div').css('z-index', '100');			
		},

		deactivate( event, ui ) {
			$('.add_elements_plus').css('z-index', '10');
			$('.delete-div > div').css('z-index', '-999');
		},

		over( event, ui ) {
			$('.delete-div > div').addClass('hover-del');
		},

		out( event, ui ) {
			$('.delete-div > div').removeClass('hover-del');
		},

		drop: function(event, ui) {

			console.log("workingdrag");

			if($.tooltipster.instances($('.build-next')).length > 0){

				$(".build-next").tooltipster('destroy');			

			}	
			$(".build-next").removeClass('button_clicked');			
			
			var current_row_tr = ui.draggable.closest('tr').find('.trash');

			recycleImage(ui.draggable);

			var prevEl = ui.draggable.prev();
			var nextEl = ui.draggable.next().next();

			if (prevEl.hasClass('sequence_li') && nextEl.hasClass('add_sequence')) {
				nextEl.remove();
				current_row_tr.find('.dashed_image_li').show();
			}

			if (nextEl.hasClass('add_sequence')) {
				nextEl.remove();
				current_row_tr.find('.dashed_image_li').show();	
			}

			if ( current_row_tr.find('li').length == 4 && ui.draggable.closest('td').hasClass('gallery_new') == false ) {
				current_row_tr.find('.close').trigger('click');
			}



			setTimeout( function() {
				setScrollAndIndex($);
			}, 450 );

		}
		
	});


	var recycle_icon = "<a href='link/to/recycle/script/when/we/have/js/off' title='Recycle this image' class='ui-icon ui-icon-refresh'>Recycle image</a>";
	
	// Image deletion function
	var trash_icon = "<a href='link/to/trash/script/when/we/have/js/off' title='Delete this image' class='ui-icon ui-icon-trash'>Delete image</a>";

	function recycleImage($item) {

		var seqAfter = $item.next().next();

		$item.fadeOut(function() {
			$item
				.find("a.ui-icon-refresh")
				.remove()
				.end()
				.css("width", "32%")
				.append(trash_icon)
				.find("img")
				.css("height", "90px")
				.end()				
				.appendTo($(".gallery"))
				.remove();

			if (seqAfter.hasClass('sequence_li')) {
				seqAfter.remove();
			}


		});



	}

	$( ".trash" ).sortable({
		items: "> li:not(.d-sort)",

		update: function(ev, ui) {

			$(".build-next").removeClass('button_clicked');			

			add_arrow_element($);

			// 	var $elThis = ui.item;
	  //           current_row = $(this);

	  //           current_row.find('li:not(.door_image_li, .dashed_image_li)').each(function(index, el) {
	            	
	  //           	var $el = $(el);	            	

	  //           	if($el.hasClass('sequence_li')) {

	  //           		$el.attr('update_index', index);

	  //           		if (index != $el.attr('data-index')) {
	  //           			$el.insertBefore(current_row.find('li:not(.door_image_li, .dashed_image_li)').eq($el.attr('data-index')));
	  //           		}

	  //           	}

	  //           });

	  //           var first_li = current_row.find('li:not(.door_image_li, .dashed_image_li)').eq(0);
	  //           if(first_li.hasClass('sequence_li')) {
	  //           	first_li.insertAfter(first_li.next('li'));
	  //  			}

	  //           current_row.find('li:not(.door_image_li, .dashed_image_li)').each(function(indexx, ell) {
                	
   //              	var $eel = $(ell);

   //              	if ($eel.hasClass('sequence_li') && $eel.next('li').hasClass('sequence_li')) {

   //              		$eel.next('li').insertAfter($eel.next('li').next('li'));
	  //           	}

	  //           });

			// $('#save_data').trigger('click');

        },

	});

}


// add row dynamically
$(document).ready(function() {

	drag_and_drop_elements($, 'default');

	var counter = 0;
	// Previous Add row 
	// $(document).on('click', '#addrow', function(e) {

	// 	var li_length_for_addScenario = $('table.order-list tbody:visible tr:last-child td:last-child .trash li').length;

	// 		if (li_length_for_addScenario > 2) {
	// 		var cols = "";

	// 		var dashed_image_li_clone = $('table.order-list tbody:visible tr:first-child').find('.dashed_image_li').html();

	// 		cols += "<tr><td class='gallery_new" + counter + "'><div class='ui-helper-reset gallery-rep'><ul id='trash' class='trash ui-widget-content ui-state-default' style='overflow-x: auto;'><li class='dashed_image_li d-sort'>"+dashed_image_li_clone+"</li></ul></div></td></tr>";

	// 		$(cols).appendTo('table.order-list tbody:visible');

	// 		set_default_lis( $, $('.gallery_new'+ counter) );

	// 		drag_and_drop_elements($, 'append_row', counter);

	// 		counter++;

	// 	} else {
	// 		alert('Please drop atleast one element...');
	// 	}
		

	// });


	$(document).on('click', '#addrow', function(e) {
			var li_length_for_addScenario = $('table.order-list tbody:visible tr:nth-last-child(2) td .trash li').length;

				if (li_length_for_addScenario > 2) {
				var cols = "";

				var dashed_image_li_clone = $('table.order-list tbody:visible tr:first-child').find('.dashed_image_li').html();

				var append_ = $('table.order-list tbody:visible');

				var td_width = $("td.gallery_new").css('width');

				cols += "<tr><td class='gallery_new" + counter + "' style='width: "+td_width+";'><div class='ui-helper-reset gallery-rep'><ul id='trash' class='trash ui-widget-content ui-state-default' style='overflow-x: auto;'><li class='dashed_image_li d-sort'>"+dashed_image_li_clone+"</li></ul></div></td></tr>";
				var add_row_droppable = $('table.order-list tbody:visible tr:last-child');
				$(cols).appendTo(append_);
				$(add_row_droppable).appendTo(append_);

				set_default_lis( $, $('.gallery_new'+ counter) );

				drag_and_drop_elements($, 'append_row', counter);

				counter++;
				

			} else {
				alert('Please drop atleast one element...');
			}
	});


	// DELETE ROW
	$("table.order-list").on("click", ".close", function(event) {
		
		$(".build-next").removeClass('button_clicked');			
		
		var $this = $(this);

		$this.closest("tr").fadeOut('fast', function() {
			$this.closest("tr").remove();
			counter -= 1;
		});

	});

		

		$(document).on('click', '.arrow_pop', function(e){			

			e.stopPropagation();

			if($.tooltipster.instances($('.build-next')).length > 0){

				$(".build-next").tooltipster('destroy');			

			}	

			$(".build-next").removeClass('button_clicked');			

			var $this = $(this);

			var current_li = $this.closest('li');

			var seq_arrow = $(".gallery").find('li[data-element-append="7"]');

			var seq_added =	$(seq_arrow).clone().insertAfter(current_li).show();

			seq_added.find('i.fa-remove').addClass('delete_arrow');

			seq_added.removeClass('add_sequence door_image_li').addClass('paramsmeters sequence_li disabled_arrow');

			seq_added.find('button').removeClass('d-none');

			seq_added.find('[disabled]').removeAttr('disabled');

			seq_added.removeClass('d-sort');
			
			current_li.next("li.sequence_li").trigger('click');

			seq_added.next("li").css({
				display: 'inline-block'
			});

			add_arrow_element($);

			setScrollAndIndex($);
		});


		// HELP CODE
		$(".pop").popover({ trigger: "manual" , html: true, animation:false})
		    .on("mouseenter", function () {		
		    	// console.log("testing");
		        var _this = this;
		        $(this).popover("show");
		        $(".popover").on("mouseleave", function () {
		            $(_this).popover('hide');
		        });
		    }).on("mouseleave", function () {
		        var _this = this;
		        setTimeout(function () {
		            if (!$(".popover:hover").length) {
		                $(_this).popover("hide");
		            }
		        }, 300);
		});

		var arrow_text = $(".gallery li[data-title='SEQ']").find('strong').html();

		$(document).on('mouseover', '.arrow_pop.pop', function(e) {
	        $(this).popover("show");

	        $(this).attr('data-content', arrow_text);	        

	    });    

	    // Cancel Arrow
	    $(document).on('mouseover', 'li.sequence_li', function(event) {
	    	event.preventDefault();
	    	$(this).find('i').show();
	    });

	    $(document).on('mouseout', 'li.sequence_li', function(event) {
	    	event.preventDefault();
	    	$(this).find('i').hide();
	    });

	   // Delete arrow 
	    $(document).on('click', '.delete_arrow', function(e) {   
	    	e.stopPropagation();
			
			if($.tooltipster.instances($('.build-next')).length > 0){

				$(".build-next").tooltipster('destroy');			

			}	

			$(".build-next").removeClass('button_clicked');			

	    	var current_li =  $(this).closest('li');
			
			var prev_li = current_li.prev("li");
			
			// current_li.prev('li').find('img').removeClass('disabled_arrow');
			
			current_li.fadeOut("slow", function() {
			
				prev_li.find('img.arrow_pop').removeClass('disabled_arrow');	

		    	current_li.remove(); 
	   		}); 

		// Dashed image
			var current_td = $(this).closest("td");

			var ul_length = current_td.find('ul.trash li').length;

	      	var next_row_elements = current_td.closest('tr').next().find('ul.trash li');


	      	if(ul_length == 3){
	      		if(next_row_elements.length > 2){   
	      			$(current_td).closest('tr').remove();
	      		}
	      		if(current_td.closest('tr').prev("tr").find('ul.trash li').length >= 3){
	      			current_td.closest('tr').remove();
	      		}
	      		else{
	      			$(current_td).find('li.dashed_image_li').css('display', 'inline-block');	      			
	      		}
	      	}

	   		add_arrow_element($);

	    });


	    // DELETE ELEMENT    
	    // $(document).on('click', '.delete_element', function(e) {        

	    // 	e.stopPropagation();

	    //   	// Showing dashed_image after empty li
	    //   	var current_td = $(this).closest("td");

	    //   	// if next li have elements and previous li is empty
	    //   	var next_row_elements = current_td.closest('tr').next().find('ul.trash li');


	    //   	var ul_length = current_td.find('ul.trash li').length;

	    // 	var li = $(this).closest('li'); 


	    // 	if(li.find('img.arrow_pop').is(':visible') == false){

	    // 		$(".trash").find('li.sequence_li').fadeOut("slow", function() {
	   	// 	        $(".trash").find('li.sequence_li').remove();
	   	// 		});
	   			
	    // 	}
	    	
	    // 	$(li).fadeOut("slow", function() {
	   	// 	    $(li).remove();
		   //    	if(ul_length == 3){
		   //    		if(next_row_elements.length > 2){   
		   //    			$(current_td).closest('tr').remove();
		   //    		}
		   //    		if(current_td.closest('tr').prev("tr").find('ul.trash li').length >= 3){
		   //    			current_td.closest('tr').remove();
		   //    		}
		   //    		else{
		   //    			$(current_td).find('li.dashed_image_li').css('display', 'inline-block');	      			
		   //    		}
		   //    	}
	   	// 	});
	    // });

	    $(document).on('click', '.delete_element', function(e) {        

	    	e.stopPropagation();

	    	if($.tooltipster.instances($('.build-next')).length > 0){

	    		$(".build-next").tooltipster('destroy');			

	    	}	

			$(".build-next").removeClass('button_clicked');			

	      	// Showing dashed_image after empty li
	      	var current_td = $(this).closest("td");

	      	var ul_length = current_td.find('ul.trash li').length;

	      	var next_row_elements = current_td.closest('tr').next().find('ul.trash li');

	      	var $this = $(this);

	      	$this.parent("li").fadeOut('slow', function() {
	      		$this.parent("li").remove();
	      		if(ul_length == 3){
		      		if(next_row_elements.length > 2){   
		      			$(current_td).closest('tr').remove();
		      		}
		      		if(current_td.closest('tr').prev("tr").find('ul.trash li').length >= 3){
		      			current_td.closest('tr').remove();
		      		}
		      		else{
		      			$(current_td).find('li.dashed_image_li').css('display', 'inline-block');	      			
		      		}
		      	}
		      	add_arrow_element($);
	      	});

	    });

});



function add_arrow_element($){
		$('#nav-tabContent2 .omc.tab-pane').each(function(index, tabs) {

			var $tabs = $(tabs);
			var RowData = '';

			$tabs.find('.trash').each(function(index, rows) {

				var $rows = $(rows);
				var elements = '';

					$rows.find('li').each(function(index, li) {

						var $li = $(li);
						var paramsData = '';

						if($li.hasClass('sequence_li') == false){
							if($li.next("li").hasClass('sequence_li') == false){
								$li.find('img.arrow_pop').removeClass('disabled_arrow');
							}else{
								$li.find('img.arrow_pop').addClass('disabled_arrow');								
							}
						}
					});
			});


		});
	}