$(document).ready(function(){
	$( "#sortable" ).sortable();
	$(".update").mouseenter(function () {
		var data = $("#sortable").sortable('toArray');
        $('#order').val(data);
        $('#order2').val(data);
		});
	$( "#sortable" ).disableSelection();
	});