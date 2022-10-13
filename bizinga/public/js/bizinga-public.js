(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */




	 $(document).ready(function(){
		// Load more data
		$('.load-more').click(function(){
			var row = Number($('#row').val());
			var allcount = Number($('#all').val());
			var rowperpage = 3;
			row = row + rowperpage;
	
			if(row <= allcount){
				$("#row").val(row);
	
				$.ajax({
					url: 'getData.php',
					type: 'post',
					data: {row:row},
					beforeSend:function(){
						$(".load-more").text("Loading...");
					},
					success: function(response){
	
						// Setting little delay while displaying new content
						setTimeout(function() {
							// appending posts after last post with class="post"
							$(".post:last").after(response).show().fadeIn("slow");
	
							var rowno = row + rowperpage;
	
							// checking row value is greater than allcount or not
							if(rowno > allcount){
	
								// Change the text and background
								$('.load-more').text("Hide");
								$('.load-more').css("background","darkorchid");
							}else{
								$(".load-more").text("Load more");
							}
						}, 2000);
	
	
					}
				});
			}else{
				$('.load-more').text("Loading...");
	
				// Setting little delay while removing contents
				setTimeout(function() {
	
					// When row is greater than allcount then remove all class='post' element after 3 element
					$('.post:nth-child(3)').nextAll('.post').remove();
	
					// Reset the value of row
					$("#row").val(0);
	
					// Change the text and background
					$('.load-more').text("Load more");
					$('.load-more').css("background","#15a9ce");
					
				}, 2000);
	
	
			}
	
		});
		$('.owl-carousel').owlCarousel({
			loop:true,
			margin:10,
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
					nav:true
				},
				600:{
					items:3,
					nav:true
				},
				1280:{
					items:5,
					nav:true
				}
			}
		});
	});
	 
	

})( jQuery );
