$(document).ready(function() {
	
	// Expand Panel
	$("#open").click(function(){
		$("div#panel").slideDown("slow");
		return false;
	});
	$("#postit").click(function(){
		$("#open").click();
		return false;
	});

	// Collapse Panel
	$("#close").click(function(){
		$("div#panel").slideUp("slow");
		return false;
	});

	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$("#toggle a").click(function () {
		$("#toggle a").toggle();
		return false;
	});

});
