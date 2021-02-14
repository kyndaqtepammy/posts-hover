(function($){    //no conflict
    "use strict";
    $(document).ready(function(){
     // alert("Hello World!");
    
     $('.ph-container').click(function() {
        // console.log(ajax_obj.nonce);
         
        $.ajax({
            url: ajax_obj.ajaxurl,
            data: {
                'action' : 'example_ajax_request',
                'fruit': 'banana',
                'nonce': ajax_obj.nonce
            },
            success: function(data) {
                console.log(data);  
            },
            error: function(err) {
                console.log(err);
            }
        });
     });
});
  })(jQuery);   //end no conflict