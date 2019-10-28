$(document).ready(function () {

    $('#lid').focusout(function () {
        var username = $(this).val();
        var data = {
            user: username
        };
        console.log(data);
        $.ajax({
            type: "POST",
            url: "../frontend/registerAction.php",
            dataType: 'text',
            data: data,
            success:function (response) {
                if(response){
                    $('.error_msg').html("Username already exists");
                    $('#myModal').modal('show');
                    $('.modal-backdrop.in').css('opacity', '0.5');
                    event.preventDefault();
                }
            }
        })
    });

    $('#eid').focusout(function () {
        var email = $(this).val();
        var data = {
            email: email
        };
        console.log(data);
        $.ajax({
            type: "POST",
            url: "../frontend/registerAction.php",
            dataType: 'text',
            data: data,
            success:function (response) {
                if(response){
                    $('.error_msg').html("Email already exists");
                    $('#myModal').modal('show');
                    $('.modal-backdrop.in').css('opacity', '0.5');
                    event.preventDefault();
                }
            }
        })
    });

    $('#ppid').focusout(function(){
        var phone_num = $(this).val();
        var regex = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
        if(regex.test(phone_num)==0 && phone_num){
            $('.error_msg').html("Please input correct mobile number");
            $('#myModal').modal('show');
            $('.modal-backdrop.in').css('opacity', '0.5');
            event.preventDefault();
        }
    });

    $('#pid').focusout(function(){
        var password = $(this).val();
        var regex = /^(?=.[a-z])(?=.[A-Z])(?=.[0-9])(?=.[!@#\$%\^&\*])(?=.{8,})/
        if(regex.test(password)==0 && password){
            var error = "Please input stong password "+
                        "<ul>" +
                        "<li>1 Upper case</li>"+
                        "<li>1 Lower case</li>"+
                        "<li>1 Special Character</li>"+
                        "<li>1 Number</li>"+
                        "<li>Length of 8 characters</li>"+
                        "</ul>";
            $('.error_msg').html(error);
            $('#myModal').modal('show');
            $('.modal-backdrop.in').css('opacity', '0.5');
            event.preventDefault();
        }
    })
});