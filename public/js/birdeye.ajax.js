// Birdeye Reviews
// -- Ajax Functions

var birdEyeAjax = {
	reviewsContainer: jQuery('#Reviews_Container'),
	reviewsTableBody: jQuery('.block'),
	button: '<div class="actionButtonWrapper"><a id="LoadReviews" href="#" class="">Load More</a></div>',
	loadingGraphic: '<div id="L_wrapper" class="l-wrapper"><img src="/./wp-content/plugins/new/images/loading.svg"></div>',
	init: function () {
		
		birdEyeAjax.reviewsContainer.append(birdEyeAjax.button).data('page', 25).parent().css({'padding': '0'});
		
		jQuery('#LoadReviews').css({'margin': '0px auto'}).parent().css({'text-align': 'center'});
		
		birdEyeAjax.loadButtonClick();
		birdEyeAjax.sourceCheckboxUncheckAll();
		
		jQuery('input[name=reviews-filter]').each( function () {
			birdEyeAjax.sourceCheckboxCheck(jQuery(this));
		});

		jQuery('select[name=selectSource]').on('change',function () {
			birdEyeAjax.sourceSelectCheck(jQuery(this));
		});


		/*jQuery('select[name="selectSource"]').on('change', function () {
			var selected = jQuery('select[name="selectSource"]').find(':selected').val();
		});*/
		
	},
    sourceSelectCheck: function (_this) {
		
		_this.click ( function () {
			birdEyeAjax.sourceSelectAll();
			_this.prop('selected', true);
			birdEyeAjax.reviewsContainer.data('source', _this.prop('value'));
			birdEyeAjax.reviewsContainer.data('page', 0);
			birdEyeAjax.reviewsTableBody.html('');
			birdEyeAjax.getRecords();
		});
		
	},
    sourceSelectAll: function () {
		jQuery('select[name=selectSource]').each( function () {
			jQuery(this).prop('selected', false);
		});
	},

	sourceCheckboxCheck: function (_this) {
		
		_this.click ( function () {
			birdEyeAjax.sourceCheckboxUncheckAll();
			_this.prop('checked', true);
			birdEyeAjax.reviewsContainer.data('source', _this.prop('value'));
			birdEyeAjax.reviewsContainer.data('page', 0);
			birdEyeAjax.reviewsTableBody.html('');
			birdEyeAjax.getRecords();
		});
		
	},
	sourceCheckboxUncheckAll: function () {
		jQuery('input[name=reviews-filter]').each( function () {
			jQuery(this).prop('checked', false);
		});
	},
	loadButtonClick: function () {
		
		jQuery('#LoadReviews').click( function (e) {
			e.preventDefault();
			birdEyeAjax.getRecords();
			jQuery(this).blur();
		});
		
	},
	getRecords: function () {
		
		var page = jQuery('#Reviews_Container').data('page');
		var protocol = "http:";
		var source = birdEyeAjax.reviewsContainer.data('source');
		var Data;
		//console.log(source);
		
		if(window.location.protocol == "https:") {
			var protocol = "https:";
		}

		/* var PostAjax = {"ajaxurl":protocol+"\/\/"+window.location.host+"\/wp-admin\/admin-ajax.php "};*/

			Data = {
				'action' : 'birdeye_ajax_fetch_reviews',
				'page'   : page,
				'source' : source
				
				
			};
			        
         
		jQuery.ajax({
			/* url: PostAjax.ajaxurl, */
			url :ajaxurl,
			type: "POST",
			data: Data,

			beforeSend: function () {
				jQuery('#LoadReviews').parent().prepend(birdEyeAjax.loadingGraphic);
				jQuery('#L_wrapper').css({'text-align': 'center', 'margin-top': '10px'});
				jQuery('#Reviews_Container').parent().parent().removeAttr('style');
			},
			success: function ( data ) {
							
				jQuery('#L_wrapper').remove();
				birdEyeAjax.reviewsTableBody.append(data);
				jQuery('#Reviews_Container').data('page',page+25);
				
				console.log(jQuery('#Reviews_Container').data('page'));
				
			}
		});
		
	}
};

jQuery(document).ready(birdEyeAjax.init());
