$(document).ready(function(){
	$( "#sortable" ).sortable();
	$(".update").mouseenter(function () {
		var data = $("#sortable").sortable('toArray');
        $('#order').val(data);
        $('#order2').val(data);
        $('#sortsize2').val($('sortsize').val());
		});
	$(".work").click(function(){
    	if ($(this).prop('checked'))
	    {
 		   	$("#workcount").val(parseInt($("#workcount").val()) + 1);
    	    $("#true").val($("#true").val() + "," + $(this).prop('id'));
		}
    	else
   		{
    		$("#workcount").val(parseInt($("#workcount").val()) - 1);
        	var str = $('#true').val();
        	var arr = str.split(",");
			for( var i = 0; i < arr.length; i++)
        	{ 
   				if ( arr[i] === 5) {
     				arr.splice(i, 1); 
     				i--;
            	}
        	}
        	$("#true").val(arr);
   		}
	});
	$( "#sortable" ).disableSelection();
});