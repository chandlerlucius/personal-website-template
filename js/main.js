$(document).ready(function() {

  //Make title and subtitle look like typed text
  var count = 0;
  var title = $("#title-page h1").text();
  var subtitle = $("#title-page h3").text();

  $("#title-page h1").text("_");
  $("#title-page h3").text("");

  printUnderscoreLoop("#title-page h1", 2);
  printNameLoop("#title-page h1", title);
  printUnderscoreLoop("#title-page h3", 4);
  printNameLoop("#title-page h3", subtitle);

  function printUnderscoreLoop(selector, length) {
    for(var i = 1; i <= length; i++) {
      count += 500;
      setTimeout(printUnderscore, count, selector, i);
    }
  }

  function printUnderscore(selector, i) {
    if(i % 2 == 0) {
      $(selector).text("_").css("color", "#FFF");
    } else {
      $(selector).css("color", "transparent");
    }
  }

  function printNameLoop(selector, title) {
    for(var j = 0; j <= title.length; j++) {
      count += 100;
      var text = title.substring(0, j);
      setTimeout(printName, count, selector, text + "_");
    }
    setTimeout(printName, count, selector, title);
  }

  function printName(selector, text) {
    $(selector).text(text).css("color", "#FFF");
  }

  //Change scheme color with random generator
  var array = [];
  array[0] = "blue";
  array[1] = "red";
  array[2] = "green";
  array[3] = "gold";
  var num = Math.floor(Math.random() * array.length);
  document.getElementById(array[num]).checked = true;

  //Fix mobile jumping when address bar is removed
  // var bg = jQuery(".title-page, .overlay");
  // jQuery(window).resize("resizeBackground");
  // function resizeBackground() {
  //   bg.height(jQuery(window).height());
  // }
  // resizeBackground();

  //Fix iPhone background image issue
  var browser = (/webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
  if(browser) {
    $('#title-page').css('background-attachment','scroll');
  }

  //Fade in elements when scrolling to them
  function fade() {
    $('.fade').each(function() {
      /* Check the location of each desired element */
      var objectBottom = $(this).offset().top + $(this).outerHeight();
      var windowBottom = $(window).scrollTop() + $(window).innerHeight();

      var objectTop = $(this).offset().top;
      var windowTop = $(window).scrollTop();

      // if (objectTop < windowTop) {
      //   if ($(this).css('opacity')==1) {$(this).fadeTo(1000,0);}
      // } else if(objectBottom < windowBottom) {
      //   if ($(this).css('opacity')==0) {$(this).fadeTo(1000,1);}
      // } else {
      //   if ($(this).css('opacity')==1) {$(this).fadeTo(1000,0);}
      // } 
      if (objectBottom > windowBottom) {
        if ($(this).css('opacity')==1) {$(this).fadeTo(1000,0);}
      } else {
        if ($(this).css('opacity')==0) {$(this).fadeTo(1000,1);}
      }
    });
  }
  fade();
  $(window).scroll(function() {fade();});

	//Store menu values
	var lastId, 
		navMenu = $("#nav-menu"), 
		navMenuHeight = navMenu.outerHeight(),
    	menuElements = navMenu.find("a"),
	    scrollElements = menuElements.map(function() {
	    	var element = $($(this).attr("href"));
	      	if (element.length) { 
	      		return element;
	      	}
	    });

	// Click animation for menu values
	$(".link").click(function(e) {
		e.preventDefault();
	    var target = $($(this).attr("href"));
	    $('html, body').stop().animate({
	       scrollTop: target.offset().top
	    }, 1000);
	});

	// Scroll animation for menu values
	$(window).scroll(function(){
	   // Get container scroll position
	   var fromTop = $(this).scrollTop() + navMenuHeight;
	   
	   // Get id of current scroll item
	   var scrollElement = scrollElements.map(function(){
			if ($(this).offset().top < fromTop)
				return this;
	   });
	   // Get the id of the current element
	   scrollElement = scrollElement[scrollElement.length - 1];
	   var id = scrollElement && scrollElement.length ? scrollElement[0].id : "";
	   
	   if (lastId !== id) {
	       lastId = id;
	       // Set/remove active class
	       menuElements.removeClass("active-menu").end()
	       menuElements.filter("[href=#"+id+"]").addClass("active-menu");
	   }                   
	});

	// Show javascript content if javascript is enabled
  $(".javascript").show();
  $(".non-javascript").hide();

	// AJAX function called when user submits email form
	$('#email').submit(submitEmail);

    function submitEmail() {
        var overlayAndImage = "<div class=loading-overlay><div class=absolute-center><img class=gallery-popup-image src=./img/Loading.gif alt=Loading Image title=Loading Image></img></div>";
        var origData = $(this).serializeArray();
        var data = origData.filter(function(elem){
			return elem.name != 'email-body'; 
		});
        data.push({name: 'email-body', value: $('#email-body').html()});
        
        $.ajax({
            url       : $(this).attr('action'),
            type      : $(this).attr('method'),
            data      : $.param(data),
            beforeSend: function() { 
                            $(overlayAndImage).animateAppendTo("body", 1000);
                        },
            success   : function(data) {
                            alert(data);
                            $('#email')[0].reset();
                            $('#email-body').empty();
                        },
            error     : function(data, textStatus, errorThrown) {
                            alert(data.responseText);
                        },
            complete  : function() { 
                            $(".loading-overlay").animateRemoveFrom("body", 1000);
                        },
        });  
        return false;
    }

    $.fn.animateAppendTo = function(sel, speed) {
        $(sel).append($(this)
        .css({'opacity':'0'})
        .animate({'opacity':'0.8'}, speed));
    };

    $.fn.animateRemoveFrom = function(sel, speed) {
        $(this)
        .css({'opacity':'0.8'})
        .animate({'opacity':'0'}, speed, 
        function() {
            ($(this).remove())
        });
    };
});