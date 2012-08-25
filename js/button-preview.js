var kkLikeButtonPrev  = {
	
	initialize : function(){
		_this = this;
		
		this.updateForm();
		this.setColor();
		this.setTextColor();
		this.setBorderSize();
		this.setBorderColor();
		this.setFontSize();
		this.setRoundCorner();
		
		jQuery('#own_button_type').live('change',function(){
			_this.updateForm();
		});
		
		jQuery('#button_color').live('change',function(){
			_this.setColor();
		});
		
		jQuery('#button_text_color').live('change',function(){
			_this.setTextColor();
		});
		
		jQuery('#button_border_size').live('change',function(){
			_this.setBorderSize();
		});
		
		jQuery('#button_border_color').live('change',function(){
			_this.setBorderColor();
		});
		
		jQuery('#button_font_size').live('change',function(){
			_this.setFontSize();
		});

		jQuery('#button_round_corners').live('change',function(){
			_this.setRoundCorner();
		});
	},
	
	updateForm : function(){
		if(jQuery('#own_button_type').is(':checked')){
			jQuery('.button-template').hide();
			jQuery('.button-own').show();
			jQuery('#kklike-button-prev-box').show().animate({
				top : '510px',
				opacity : 1
			},300);
		}else{
			jQuery('.button-template').show();
			jQuery('.button-own').hide();
			jQuery('#kklike-button-prev-box').animate({
				top : '416px',
				opacity : 0
			},300,function(){
				jQuery('#kklike-button-prev-box').hide();
			});
		}
	},
	
	setColor : function(){
		jQuery('#kklike-button-prev-box').find('.kklike-box').css({
			'background'	:	'#' + jQuery('#button_color').val()
		});
	},
	
	setBorderSize : function(){
		jQuery('#kklike-button-prev-box').find('.kklike-box').css({
			'border-width'	:	jQuery('#button_border_size').val() + 'px'
		});
		jQuery('#kklike-button-prev-box').find('.kklike-value').css({
			'border-left-width'		:	jQuery('#button_border_size').val() + 'px',
			'border-right-width'	:	jQuery('#button_border_size').val() + 'px'
		});
	},
	
	setBorderColor : function(){
		jQuery('#kklike-button-prev-box').find('.kklike-box').css({
			'border-color'	:	'#' + jQuery('#button_border_color').val()
		});
		jQuery('#kklike-button-prev-box').find('.kklike-value').css({
			'border-left-color'		:	'#' + jQuery('#button_border_color').val(),
			'border-right-color'	:	'#' + jQuery('#button_border_color').val()
		});
	},
	
	setTextColor : function(){
		jQuery('#kklike-button-prev-box .kklike-value, #kklike-button-prev-box .kklike-text').css({
			'color'	:	'#' + jQuery('#button_text_color').val()
		});
	},
	
	setFontSize : function(){
		jQuery('#kklike-button-prev-box').find('.kklike-box').css({
			'font-size'	:	jQuery('#button_font_size').val() + 'px'
		});
	},

	setRoundCorner : function(){
		jQuery('#kklike-button-prev-box').find('.kklike-box').css({
			'border-radius'	:	jQuery('#button_round_corners').val() + 'px'
		});
	}
	
};

function kkLikeButtonPrevConstr(){
	this.kkLikeButtonPrev = kkLikeButtonPrev;
}