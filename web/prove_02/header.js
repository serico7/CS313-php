$(document).ready(function(){
	$("#mainNav").mouseenter(function () {
		$("#mainNav").css({
			transition: 'background-color .3s ease-in-out',
			"background-color":"#d9d9d9"
		});
	});
	$("#mainNav").mouseleave(function () {
		$("#mainNav").css({
			transition: 'background-color .3s ease-in-out',
			"background-color":"#white"
		});
	});
	$("#indexNav").mouseenter(function () {
		$("#indexNav").css({
			transition: 'background-color .3s ease-in-out',
			"background-color":"#d9d9d9"
		});
	});
	$("#indexNav").mouseleave(function () {
		$("#indexNav").css({
			transition: 'background-color .3s ease-in-out',
			"background-color":"#white"
		});
	});
});