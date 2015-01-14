var gItemCount = 0;
var itemsArray = new Array();
var codesString = "";

$(function() {
	
	$( "#frmLogin" ).submit(loginHandler);
	
	// Making the basic structure for pulling the data 
	if($("div.biditem").length)  {
		gItemCount = $("div.biditem").length;
		var idx = 0;
		$("div.biditem").each(function () {
			
				itemsArray[idx] = new Array();
				itemcode = $(this).attr("data-id");
				itemsArray[idx][0] = itemcode;  
				var subArray = new Array();
				subArray["ref_num"] =  $(this).attr("data-ref");
				subArray["td_itemtitle"] =  $(this).find("td.itemtitle");
				subArray["sp_lastbidder"] =  $(this).find("span.dlastbidder");
				subArray["sp_lastbidamt"] =  $(this).find("span.dlastbidamt");
				subArray["sp_bmins"] =  $(this).find("span.bmins");
				subArray["sp_bsecs"] =  $(this).find("span.bsecs");
				subArray["bt_bidbtn"] =  $(this).find("button.dbidbtn");
				subArray["bt_favbtn"] =  $(this).find("button.dfavbtn");
				itemsArray[idx][1] = subArray;
				codesString = codesString + itemcode;
				idx++;				
				if(idx<gItemCount) codesString = codesString + ",";
		});
	}
	
	if(gItemCount) {
		 
		var refreshId = setInterval(function() {
			
			var url = "/ajax/getprice/" + new Date().getTime();
            var mzxhr = $.ajax( {
				type: "POST",
				url: url,
				data: "itemcodes=" + codesString,
            	dataType: 'json',
            	timeout: 500,
			}).done(function(data) {
				var loopvar;
				for(loopvar=0; loopvar<data.length; loopvar++)
                {
                    updateDetails(data[loopvar]);
                }
			  })
			  .fail(function() {
				 alert("Error communication to server. Please check your internet connection");
			  })
			  .always(function() {
			    //alert( "complete" );
			  });
			 
		
		}, 100000);
		
	}
	
});
	


function updateDetails(data) {
    itemcode = data.itemcode;
    itemref = data.itemref;
    itembidprice = data.currentbidprice;
    bday = data.btdays;
    bhrs = data.bthours;
    bmin = data.btmins;
    bsec = data.btsecs;
    bidcount = data.bidcount;
    activebidder = data.activebidder;
    recentbidders = data.recentbidders;
    disablebid = data.disablebid;
    //alert(bmin + " - " + bsec);
    
    
    pos = -1;
    for(i=0; i<gItemCount; i++ ) {
    	if( itemsArray [i][0] == itemcode )  {
    		pos= i;
    		break;    		
    	}
    }
    if(pos==-1) return;
    subArray = itemsArray[pos][1];
    //		subArray["bt_favbtn"] =  $(this).find("button.dfavbtn");
	
	var obj_td_title  = subArray["td_itemtitle"];
	var obj_sp_bidamt = subArray["sp_lastbidamt"]

    var theMinsBox  = subArray["sp_bmins"]
    var theSecsBox  = subArray["sp_bsecs"] 

    var currentSeconds = theSecsBox.text();
    var currentMins    = theMinsBox.text();

    var objRecentBidder = subArray["sp_lastbidder"]
    var recentBidder    = objRecentBidder.text();
    var bidnowlink  = subArray["bt_bidbtn"]
    $(bidnowlink).attr("disable", disablebid);
    
    if(recentBidder!=recentbidders) {
        objRecentBidder.html(recentbidders)
        $(objRecentBidder).hide();
        $(objRecentBidder).fadeIn('slow');
    }
        
    if(bmin<10) bmin = "0" + bmin;
    theMinsBox.html(bmin);
    if(bsec<10) bsec = "0" + bsec;
    theSecsBox.html(bsec);
    obj_sp_bidamt.html(itembidprice);
    
}



function doBid(obj, itemcode, itemref) {
    
	if($(obj).attr("disable")=="true") { return false; }
    
	spanobj = $(obj).find("span.glyphicon");
    if(spanobj) $(spanobj).remove();
    
    $(obj).prepend("<span class=\"glyphicon glyphicon-refresh glyphicon-refresh-animate\"></span>");
    var url = "/item/bid/" + new Date().getTime();
    $.ajax({
      type: "POST",
      url: url,
      data: "itemcode=" + itemcode + "&refer=<?php echo base_url().uri_string(); ?>",
      dataType: 'json'	
    }).done(function(data) {
    	
        var loopvar;
        alert(data.redirect);
        if(data.redirect!=null && data.redirect!=undefined && data.redirect!="") {
        	spanobj = $(obj).find("span.glyphicon");
            if(spanobj) $(spanobj).remove();
            $('#loginModal').modal('show');
        }
        
        for(loopvar=0; loopvar<data.length; loopvar++)
        {
        	updateDetails(data[loopvar]);
        }
        
    })
    
    .fail(function() {
    	alert("Error communication to server. Please check your internet connection");
    })
    
    .always(function() {
    	//alert( "complete" );
    });
    
    
    

    return false;
}


// Handles the application logic for Login 

function loginHandler(e) {
	e.preventDefault();
	
	varpostdata = $(this).serialize();
	alert(varpostdata);
	$.ajax({
	      type:$(this).attr('method'),
	      url: $(this).attr('action'),
	      data: varpostdata,
	      dataType: 'json'	
	    }).done(function(data) {
	    	
	    	if(data.status=='success') {
	    		$("#loginModal").modal("hide");
	    		window.location.reload();
	    	}
	         
	    })
	    
	    .fail(function() {
	    	alert("Error communication to server. Please check your internet connection");
	    })
	    
	    .always(function() {
	    	//alert( "complete" );
	    });
	    
		
}

function datediff(fromDate,toDate,interval) {
	/*
	 * DateFormat month/day/year hh:mm:ss
	 * ex.
	 * datediff('01/01/2011 12:00:00','01/01/2011 13:30:00','seconds');
	 */
	var second=1000, minute=second*60, hour=minute*60, day=hour*24, week=day*7;
	fromDate = new Date(fromDate);
	toDate = new Date(toDate);
	var timediff = toDate - fromDate;
	if (isNaN(timediff)) return NaN;
	switch (interval) {
		case "years": return toDate.getFullYear() - fromDate.getFullYear();
		case "months": return (
			( toDate.getFullYear() * 12 + toDate.getMonth() )
			-
			( fromDate.getFullYear() * 12 + fromDate.getMonth() )
		);
		case "weeks"  : return Math.floor(timediff / week);
		case "days"   : return Math.floor(timediff / day); 
		case "hours"  : return Math.floor(timediff / hour); 
		case "minutes": return Math.floor(timediff / minute);
		case "seconds": return Math.floor(timediff / second);
		default: return undefined;
	}
}

function checkAge(){
	var dd = $('#rdd').val();
	var mm = $('#rmm').val();
	var yy = $('#ryy').val();
	var cdate = new Date();
	var year = cdate.getFullYear();
	if(mm == '' || dd == '' || yy == '')
	{
		alert("Cannot be blank");
		return false;
	}
	else if(mm > 12 || dd > 31 || yy >= year)
	{
		alert("Error in entry");
		return false;
	}
	
	var edate = new Date(yy,mm,dd);
	
	var diff = datediff(cdate,edate,"years");
	var age = Math.abs(parseInt(diff));
	alert(age);
	if(age >= 18){
		$('#restricted').modal('hide');
	}
	else{
		alert("You dont have permission to view");
		return false;
	}
}