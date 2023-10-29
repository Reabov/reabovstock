/*
	 timer - время показа сообщения
	 type - warning, info, success, danger
	 * */
	function show(msg, txt, timer, type)
	{
		if( msg==undefined || msg=='' || $('#alert__msg').length > 0 ){
			return false;
		}
		var top = 120;
		if( timer==undefined ){
			timer = 4500;
		}
		
		if( txt==undefined ){
			txt = '';
		}
		
		if(type==undefined){
			type = '';
		}
		
		var winWidth = $(window).width();
		if( winWidth < 1025 ){
			top = 70;
		}
		if( winWidth < 360 ){
			top = 40;
		}
		
		var popup = document.createElement('div');
		$(popup).attr('id','alert__msg').addClass(type);
		
		var title = document.createElement('div');
		$(title).addClass('alert__title').text(msg);
		$(popup).append(title);
		
		if( txt!='' ){
			var text = document.createElement('div');
			$(text).addClass('alert_message').html(txt);
			$(popup).append(text);
		}
		
		/* габариты сообщения */
		var popupwidth = 450;
		var popupleft;
		if( winWidth <600 ){
			popupwidth =  winWidth * 0.8;
			popupleft = (winWidth - popupwidth)/2;
			$(popup).css({"width": popupwidth+"px","top": top+"px","left": popupleft+"px"});
		}else{
			/* контент измеряем, если много - делаем окно шире */
			if( msg.length > 1000 ){
				popupwidth = 600;
			}
			popupleft = (winWidth - popupwidth)/2; 
			$(popup).css({"width": popupwidth+"px","top": top+"px","left": popupleft+"px"});
		}
		
		var btn = document.createElement('div');
		$(btn).addClass('alert__ok').text( close__btn );
		$(popup).append(btn);
		
		$('body').append(popup);
		$(popup).fadeIn(450);
		
		setTimeout(function(){
			$('#alert__msg').fadeOut(400).delay(500).queue(function(){
				$('#alert__msg').remove();
			})       
		}, timer);
		
	}
	
	$('body').on('click','.alert__ok', function(){
		$('#alert__msg').fadeOut(400).delay(500).queue(function(){
			$('#alert__msg').remove();
		})  
	});
	
	
	
	function isInteger(num) {
	    var d = num ^ 0; 
	    if (d == num) 
	    return true; 
	    else{
	    	return false
	    }
    }
    
    
    function isEmail(email) {
	    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(email);
	}
	
	
	
	
	
	function getChar(event) {
      if (event.which == null) {
        if (event.keyCode < 32) return null;
        return String.fromCharCode(event.keyCode) /* IE */
      }

      if (event.which != 0 && event.charCode != 0) {
        if (event.which < 32) return null;
        return String.fromCharCode(event.which) 
      }

      return null; 
    }
    
    
    $('body').on('keypress', '.num-field', function(e){
    	e = e || event;
	
	      if (e.ctrlKey || e.altKey || e.metaKey) return;
	
	      var chr = getChar(e);
	      if (chr == null) return;
	
	      if (chr < '0' || chr > '9') {
	        return false;
	      }
    });
    
    
    function loader() {
	    $('body').prepend('<div id="loader"></div>');
	}
	
	function loader_destroy() {
	    $('#loader').remove();
	}
	
	(function( $ ){
	
		$.fn.loader = function(timeout) {
			var element = this;
			var initialPosition = element.css('position');
			if( initialPosition === 'static' ){
				element.css('position','relative');
			}
			
			var cover = document.createElement('div');
			$(cover).addClass('local-cover');
			
			element.append(cover);
			
			if(timeout==undefined){
				timeout = 2000;
			}
			timeout = parseInt(timeout);
			setTimeout(function(){
				$(cover).remove();
				element.css('position',initialPosition);
			},timeout);
			
			return element;
		};
		
		$.fn.unloader = function() {
			var element = this;
			
			$(element).find('.local-cover').remove();
			
			return element;
		};
		
		
	})( jQuery );
	
	
	
	function accent(elem){
        $(elem).addClass('animated shake accented');
        setTimeout(function(){
            $(elem).removeClass('animated shake accented');
        },1000);
    }
    
    
    
	function validatePhone(phoneText) 
    {
       var filter = /^[0-9-+]+$/; 
       if (filter.test(phoneText)) 
         { 
            return true; 
         }else{
            return false; 
         }
    }
	



