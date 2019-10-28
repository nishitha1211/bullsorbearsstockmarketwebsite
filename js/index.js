$(document).ready(function () {
    $("[id$='_cart_button']").on('click',function (event) {
        $id = event.target.id;
        $val = $id.replace('card', '');
        $val = $val.replace('_cart_button','');
        $quantity = $('#card' + $val+ '_spin').val();
        //buy/sell
        if($('#card' + $val + '_buy_button').is(':checked')){
            $buy_sell = 'b'
        }
        else{
            $buy_sell = 's'
        }
        //Price
        $price = $('#card'+$val+'_price').text();
        $price = $price.replace('Price:','');
        $total_price = $quantity * $price;
        $userId = 1;
        var data = {
            id: $val,
            quantity : $quantity,
            buy_sell : $buy_sell,
            price: $total_price,
            userId: $userId
        };

        $.ajax({
            type: "POST",
            url: "../frontend/indexHelper.php",
            dataType: 'text',
            data: data,
            success:function (response) {
                $('.error_msg').html(response);
                $('#myModal').modal('show');
                $('.modal-backdrop.in').css('opacity', '0.5');
                event.preventDefault();
            }
        })
    });
    $("[id$='_checkout_button']").on('click',function (event) {
        $id = event.target.id;
        $val = $id.replace('card', '');
        $val = $val.replace('_checkout_button','');
        $quantity = $('#card' + $val+ '_spin').val();
        //buy/sell
        if($('#card' + $val + '_buy_button').is(':checked')){
            $buy_sell = 'b'
        }
        else{
            $buy_sell = 's'
        }
        //Price
        $price = $('#card'+$val+'_price').text();
        $price = $price.replace('Price:','');
        $total_price = $quantity * $price;
        $userId = 1;
        var data = {
            company_id: $val,
            quantity : $quantity,
            buy_sell : $buy_sell,
            price: $total_price,
            userId: $userId
        };
        $.ajax({
            type: "POST",
            url: "../frontend/indexHelper.php",
            dataType: "text",
            data: data,
            success:function (response) {
                if(response == "yes") {
                    var mapForm = document.createElement("form");
                    mapForm.target = "Map";
                    mapForm.method = "POST"; // or "post" if appropriate
                    mapForm.action = "payment.php";

                    var mapInput = document.createElement("input");
                    mapInput.type = "hidden";
                    mapInput.name = "id";
                    mapInput.value = $val;
                    mapForm.appendChild(mapInput);

                    var mapInput = document.createElement("input");
                    mapInput.type = "hidden";
                    mapInput.name = "quantity";
                    mapInput.value = $quantity;
                    mapForm.appendChild(mapInput);

                    var mapInput = document.createElement("input");
                    mapInput.type = "hidden";
                    mapInput.name = "buy_sell";
                    mapInput.value = $buy_sell;
                    mapForm.appendChild(mapInput);

                    var mapInput = document.createElement("input");
                    mapInput.type = "hidden";
                    mapInput.name = "price";
                    mapInput.value = $total_price;
                    mapForm.appendChild(mapInput);
                    document.body.appendChild(mapForm);
                    mapForm.submit();
                }
                else{
                    $('.error_msg').html("You don't have enough stocks to sell for this company.");
                    $('#myModal').modal('show');
                    $('.modal-backdrop.in').css('opacity', '0.5');
                    event.preventDefault();
                }
            }
        });
    });
    $("[id$='_tradenav']").on('click', function() {
        $trade_id = $(this).attr('id');
        $('#'+$trade_id).addClass("active");
        $trade_id = $trade_id.replace('_tradenav', '');
        $('#'+$trade_id+'_detailsnav').removeClass("active");
        $('#'+$trade_id+'_predictionnav').removeClass("active");
    });
    $("[id$='_detailsnav']").on('click', function() {
        $details_id = $(this).attr('id');
        $('#'+$details_id).addClass("active");
        $details_id = $details_id.replace('_detailsnav', '');
        $('#'+$details_id+'_tradenav').removeClass("active");
        $('#'+$details_id+'_predictionnav').removeClass("active");
    });
    $("[id$='_predictionnav']").on('click', function() {
        $prediction_id = $(this).attr('id');
        $('#'+$prediction_id).addClass("active");
        $prediction_id = $prediction_id.replace('_predictionnav', '');
        $('#'+$prediction_id+'_tradenav').removeClass("active");
        $('#'+$prediction_id+'_detailsnav').removeClass("active");
    });
    $("#refresh_button").click(function () {
        $.post( "index.php", { search_stock: '', sort_stock: '' } );
        $.ajax({
            type: "POST",
            url: "../frontend/get_api_data.php",
            success:function () {
                window.location.href = 'index.php';
            }
        });
    });
});

