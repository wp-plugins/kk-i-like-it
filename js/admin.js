jQuery(document).ready(function(){
	
	jQuery('.kknewcheckbox').iphoneStyle();
	
	jQuery('.kkadmin-radio-ui').buttonset();
	
    jQuery('.kkadmin-radio-prev-box input[type="radio"]:checked').parents('.kkadmin-radio-prev-box').addClass('kkadmin-active');
    
    jQuery('.kkadmin-radio-prev-box input[type="radio"]').live('click', function(){
    	jQuery(this).parents('.kkadmin-selectbox').find('.kkadmin-radio-prev-box').removeClass('kkadmin-active');
    	jQuery(this).parents('.kkadmin-radio-prev-box').addClass('kkadmin-active');
    });

    jQuery('.kkpb-color-pick').ColorPicker({
    	'color'			:	jQuery(this).val(),
    	'flat'			:	false,
    	'livePreview'	:	true,
		onSubmit: function(hsb, hex, rgb, el) {
    		jQuery(el).val(hex);
    		jQuery(el).ColorPickerHide();
    		jQuery(el).change();
    	},
    	onHide: function(hsb, hex, rgb, el) {
    		jQuery(el).val(hex);
    	},
    }).bind('keyup', function(){
    	jQuery(this).ColorPickerSetColor(this.value);
    });
    
	jQuery('.kk-tooltip').qtip({
		content: {
			title		:	'Info:',
	      	attr		: 	'title'
	   	},
	   	position: {
	   		my			:	'left center',
	   		at			:	'right center'
	    },
	    style: {
	        classes		: 	'ui-tooltip-shadow ui-tooltip-dark'
	     }
	});
	
	jQuery('.kkpb-progressbar-content').qtip({
		content: {
			title		:	'Progress:',
	      	attr		: 	'title'
	   	},
	   	position: {
	   		my			:	'bottom center',
	   		at			:	'top center'
	    },
	    style: {
	        classes		: 	'ui-tooltip-shadow ui-tooltip-dark'
	     }
	});
	
});