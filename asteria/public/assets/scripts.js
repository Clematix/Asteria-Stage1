

$(function() {
    
$('#uploadform').validate({

    submitHandler: function(form) {
var url = $(form).attr('action');


    $.ajax({
        url: url,
        type: 'POST',
        data: $(this).serialize(),
         beforeSend: function (data) { $('.loader-image').show();},
        // afterSend: function() {form.submit(); },
        success: function (data) {
            alert(data)
        },
        
    });
form.submit(); 
}

    
});

$('#updateform').validate({

    submitHandler: function(form) {
var url = $(form).attr('action');

    $.ajax({
        url: url,
        type: 'POST',
        data: $(this).serialize(),
         beforeSend: function (data) { $('.loader-image').show();},
        // afterSend: function() {form.submit(); },
        success: function (data) {
            alert(data)
        },
        
    });
form.submit(); 
}

    
});

//     $('#uploadform').validate({
//      
//  
//      submitHandler: function(form) {
//         
//         //var data = new FormData(this); 
//      var url = $(form).attr('action');
//     //var data = new FormData(this);
//      alert(data);
//      $.ajax({
//        type: "POST",
//        url: url,
//        data: $(form).serialize(),
//       
//        beforeSend : function (){
//            alert(data);
//                $('.loader-image').show();
//            },
//       
//        // serializes the form's elements.
//       
//        success:function(response)
//        {alert(response);
//            if(response==1){alert(response);}
//         // $('.loader-image').hide();
//
//        }
//       
//      });
//    
//    } 
//    
//  });
  
$('.book_delete').click(function()
  { 
     if(confirm('Are you sure you want to delete this?'))
     {
         return true;
     }
     else
     {
         return false;
     }
     
  }); 
  
  

    // Side Bar Toggle
    $('.hide-sidebar').click(function() {
	  $('#sidebar').hide('fast', function() {
	  	$('#content').removeClass('span9');
	  	$('#content').addClass('span12');
	  	$('.hide-sidebar').hide();
	  	$('.show-sidebar').show();
	  });
	});

	$('.show-sidebar').click(function() {
		$('#content').removeClass('span12');
	   	$('#content').addClass('span9');
	   	$('.show-sidebar').hide();
	   	$('.hide-sidebar').show();
	  	$('#sidebar').show('fast');
	});



}); 