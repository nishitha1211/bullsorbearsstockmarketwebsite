$(document).ready(function () {
    $(".fa-trash").click(function (event) {
        $id=event.target.id;
        $id=$id.replace('_trash',"");
        var data = {
          number: $id
        };
        console.log(data);
        $.ajax({
            type: "POST",
            url: "../frontend/cart.php",
            dataType: 'text',
            data: data,
            success:function () {
                location.reload();
            }
        })
    });

    $("[id$='_quantity']").on('click', function() {
        $details_id = $(this).attr('id');
        $details_id=$details_id.replace('_quantity',"");
        $('#'+$details_id+'_tick').css("visibility", "visible");
    });

    $("[id$='_tick']").on('click', function() {
        $details_id = $(this).attr('id');
        $cart_id=$details_id.replace('_tick','');
        $quantity_id = $details_id.replace('_tick','_quantity');
        alert($quantity_id);
        $quantity = $("#"+$quantity_id).val();
        $('#'+$details_id+'_tick').css("visibility", "hidden");
        var data = {
            quantity: $quantity,
            cart_id : $cart_id
        };
        console.log(data);
        alert(data);
        $.ajax({
            type: "POST",
            url: "../frontend/cart.php",
            dataType: 'text',
            data: data,
            success:function () {
                location.reload();
            }
        })
    });

    $("#checkout").click(function (event) {
        if($("#table-row").length) {
            window.location = "payment.php";
        }
        else {
            $('.error_msg').html("No items in cart to checkout");
            $('#myModal').modal('show');
            $('.modal-backdrop.in').css('opacity', '0.5');
            event.preventDefault();
        }
    });
});

