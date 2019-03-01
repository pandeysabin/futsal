$(document).ready(function(){
    $('#fname').click(function(){
        $('#fname').css({"box-shadow": "1px 1px 1px 1px #656e82"});
    });
    $('#fname').on("blur", function(){
        $('#fname').css({"box-shadow": "none"});
    });
    $('#mname').click(function(){
        $('#mname').css({"box-shadow": "1px 1px 1px 1px #656e82"});
    });
    $('#mname').on("blur", function(){
        $('#mname').css({"box-shadow":"none"});
    });
    $('#lname').click(function(){
        $('#lname').css({"box-shadow": "1px 1px 1px 1px #656e82"});
    });
    $('#lname').on("blur", function(){
        $('#lname').css({"box-shadow":"none"});
    });
    $('#pwd').click(function(){
        $('#pwd').css({"box-shadow": "1px 1px 1px 1px #656e82"});
    });
    $('#pwd').on("blur", function(){
        $('#pwd').css({"box-shadow": "none"});
    });
    $('#cpwd').click(function(){
        $('#cpwd').css({"box-shadow": "1px 1px 1px 1px #656e82"});
    });
    $('#cpwd').on("blur", function(){
        $('#cpwd').css({"box-shadow": "none"});
    });
});