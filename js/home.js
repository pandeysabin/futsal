$(document).ready(function() {
	$("#login").click(function() {
		$(".register").css("display", "none");
	});
	$("#register").click(function() {
		$(".register").css("display", "block");
	});
});