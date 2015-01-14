$(document).ready(function () 
{ 
	if($('.vc-player video').length>0) {
		
		objArray = $('.vc-player video');
		for(i=0;i<objArray.length;i++)
		    $(objArray[i]).videocontrols( 
			{ 
			    theme: 
			    { 
				progressbar: 'blue', 
				range: 'pink', 
				volume: 'pink' 
			    } 
			}); // End Document Video Control
	}


	if($('.carousel').length>0) {
		$('.carousel').carousel({
		    pause: true,
		    interval: false
		});
	}
	
	
	$(".follow").click(ajaxReq);
	$(".dazzle").click(ajaxReq);
	$(".like").click(ajaxReq);
	$(".dislike").click(ajaxReq);
			
    function ajaxReq(e) {
		e.preventDefault();
		var urlval = $(this).attr("href");
		var spinner = "<i class='fa fa-spinner fa-spin'></i>  ";
		var oldtxt =  $(this).html();
		var obj = $(this);
		$(this).prepend(spinner);
		
		var jqxhr = $.get( urlval )
			  .fail(function() {
				    $.msgBox({
		                content: "An error occurred during update. Please make sure you are connected to internet",
		                type: "error"
		            });
			  })
			  .always(function() {
				  	$(obj).html(oldtxt);
			  });

	}
	
    $('#settingsTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
      });
    /*$('#uploadfile').on('show.bs.modal', function(e) {
     $('#fileUpload').trigger('click');
     });*/
    $('#uploadbtn').click(function(e) {
        $('#fileUpload').trigger('click');
        $("#fileUpload").change(function() {
            $('#uploadfile').modal('show');
        });
    });
    
    $('#searchbox input').bind('keypress', function(e) {
	if(e.keyCode==13){
            document.searchform.submit();
	}
});
    
}); // End Document Ready


