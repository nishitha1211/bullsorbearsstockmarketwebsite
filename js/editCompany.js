$(document).ready(function () {
    $(".fa-trash").click(function (event) {
        var data = {
            number: event.target.id
        };
        console.log(data);
        $.ajax({
            type: "POST",
            url: "../frontend/admin_companyList.php",
            dataType: 'text',
            data: data,
            success:function () {
                location.reload();
            }
        })
    });

    $(".fa-pencil-alt").click(function (event) {
        var data = {
            edit_number: event.target.id
        };
        $.ajax({
            type: "GET",
            dataType: 'text',
            data: data,
            window: location.href = "admin_editCompany.php?id="+event.target.id,
        })
    });
});