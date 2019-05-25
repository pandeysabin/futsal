$(document).ready(function() {
  $("#uname").on("input", function() {
    var input = $(this);
  });
});

function loginFormValidate() {
  var uName = document.forms["logInForm"]["uName"];
  var pwd = document.forms["logInForm"]["pwd"];

  if (uName.value == " ") {
    window.alert("Please fill out your username!");
    uName.focus();
    return false;
  }

  if (pwd.value == "") {
    window.alert("Please enter password.");
    pwd.focus();
    return false;
  }
  return true;
}

$(document).ready(function() {
  $("#login").click(function() {
    $(".register").css("display", "none");
    $(".login-form").css("display", "block");
  });
  $("#register").click(function() {
    $(".login-form").css("display", "none");
    $(".register").css("display", "block");
  });
});
