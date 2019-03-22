
$(document).ready(function(){
    $(".javascript-social").show();
    
    $(".non-javascript-social").hide();

	$('#email').submit(submitEmail);

    function submitEmail() {
        var overlayAndImage = "<div class=loading-overlay><div class=absolute-center><image class=gallery-popup-image src=../img/Loading.gif alt=Loading Image title=Loading Image></image></div>";
        var data = $(this).serializeArray();
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