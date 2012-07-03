function kkLike() {};

kkLike.prototype.init = function(){
	jQuery(document).ready(function(){
		jQuery('.kklike-box').live('click', function(){
			var _this = this;
			var obj = jQuery(this);
			var idPost = obj.find('.kklike-id').val();
			
			obj = jQuery('a[rel="kklike-'+idPost+'"]');
			
			var idPost = obj.find('.kklike-id').val();
			var idUser = obj.find('.kklike-user').val();
			var type = obj.find('.kklike-type').val();
			var action = obj.find('.kklike-action').val();
			var onlyUs = obj.find('.kklike-ou').val();
			
			
			if(onlyUs == '1' && idUser == '0'){
				obj.after(jQuery('<div />').css({'clear':'both'}).addClass('kklike-msg').text('Only registered users can vote.'));
        	 	setTimeout(function(){
        	 		jQuery('.kklike-msg').fadeOut('normal');
        	 	},3000);
        	 	return false;
			}
			
			if(action == 'like'){
				var ajaxAction = 'add_like';
			}else{
				var ajaxAction = 'remove_like';
			}
			
			var wiadomosc = {
	            action 	: 	ajaxAction,
	            idPost	:	idPost,
	            idUser	:	idUser,
	            type	:	type
	        };
	        
	        obj.find('.kklike-text').addClass('kklike-load');
	        
	        jQuery.post(kkajax.ajaxurl,wiadomosc,function(dane){ 
	        	 
	        	 var dane = jQuery.parseJSON(dane);

	        	 if(!dane.hasError){
	        	 	obj.find('.kklike-value').text(dane.rating);
	        	 	if(action == 'like'){
	        	 		obj.find('.kklike-text').text(unlikeText);
	        	 		obj.find('.kklike-action').val('unlike');
	        	 	}else{
	        	 		obj.find('.kklike-text').text(likeText);
	        	 		obj.find('.kklike-action').val('like');
	        	 	}
	        	 }
	        	 
	        	 if(dane.msg != ''){
	        	 	obj.after(jQuery('<div />').css({'clear':'both'}).addClass('kklike-msg').text(dane.msg));
	        	 	setTimeout(function(){
	        	 		jQuery('.kklike-msg').fadeOut('normal');
	        	 	},3000);
	        	 }
	        	 
	        	 obj.find('.kklike-text').removeClass('kklike-load');
	        });
			return false;
		});
		
		jQuery('.kklike-rating-hover').mouseenter(function(){
			var obj = jQuery(this).find('.kklike-value');
			obj.animate({width: "show", paddingLeft: "show", paddingRight: "show", marginLeft: "show", marginRight: "show"}, 200);
		}).mouseleave(function(){
			var obj = jQuery(this).find('.kklike-value');
			obj.animate({ width: "hide", paddingLeft: "hide", paddingRight: "hide", marginLeft: "hide", marginRight: "hide" }, 200);
		});
	});
};


/* ========================================= */
/* =========   INICJALIZACJA   ============= */
/* ========================================= */

var KKLike = new kkLike();
KKLike.init();