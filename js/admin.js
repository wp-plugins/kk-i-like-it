function kkLikeUpdateDB(){
    jQuery.post(ajaxurl,{
        action : 'kklike_db_update',
        beforeSend	:	function(){
        	jQuery('#kkpb-db-update-start').hide();
        	jQuery('#kkpb-db-update-loader').show();
        }
    },function(dane){
		
         var dane = jQuery.parseJSON(dane);
         if(!dane.hasError){
         	jQuery('#kkpb-db-update-text').html(dane.msg);
         	setTimeout(function(){window.location.reload();},5000);
         }
    });
}

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
    
	jQuery('#kkpb-db-update-start').click(function(){
		kkLikeUpdateDB();
		return false;
	});
	
});