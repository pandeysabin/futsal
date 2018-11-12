function loginFormValidate()
{
	var uName = document.forms["logInForm"]["uName"].value;
	var pwd = document.forms["logInForm"]["pwd"].value;

	if(uName == " ")
	{
		alert("Please fill out your username!");
		document.getElementById("uname").focus();
		return false;
	}
	else if(pwd == "")
	{
		alert("Please enter password.");
		return false;
	}
	else 
	{
		return true;
	}

}

$(document).ready(function() 
{
	$("#login").click(function() 
	{
		$(".register").css("display", "none");
		$(".login-form").css("display", "block");
	});
	$("#register").click(function() 
	{
		$(".login-form").css("display", "none");
		$(".register").css("display", "block");
	});
});