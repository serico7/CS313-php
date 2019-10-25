$(document).ready(function(){
	$( "#sortable" ).sortable();
	$("#generate").mouseenter(function () {
		var data = $("#sortable").sortable('toArray');
        $('#order').val(data);
        $('#order2').val(data);
		});
	$( "#sortable" ).disableSelection();
	$('ul').sortable({
        axis: 'y',
        stop: function (event, ui) {
	        var data = $(this).sortable('toArray');
            $('#order').val(data);
}});});