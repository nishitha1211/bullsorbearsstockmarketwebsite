<!DOCTYPE html>
<html lang="en">
<head>
    <link href="../frontend/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="../frontend/css/style.css">
    <script src="../frontend/js/index.js"></script>
    <?php
    //require('index.php');
    require_once 'Pagination.php';
    require('db_connection.php');
    global $connection;
    $conn = $connection;

    $limit      =  6;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    //$links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 3;
    $query      = "SELECT * FROM Company";

    $Paginator  = new pagination( $conn, $query );

    $results    = $Paginator->getData( $limit,$page );
    $data_arr = $results->data;

  ?>

</head>
<body>

<?php
    $j=0;
    while($j==0 || $j==3 && $j<6){
?>

<div class="card-deck" style="padding: 5px">
<?php
    for($i=$j;$i<$j+3&&$i<count($data_arr);$i++){
    ?>
    <div class="card" id="<?php echo 'card'.$data_arr[$i]['id']; ?>" >
        <div>
            <img style="width: 20%; float:left" class="card-img-top" src="..." alt="Card image cap">

            <h5 style="width: 80%; float:right" class="card-title"><?php echo $data_arr[$i]['name']; ?></h5> </div>
        <div class="card text-center" style="margin: 0px;">
            <div class="card-header">
                <ul class="nav nav-pills card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#<?php echo $data_arr[$i]['id']; ?>_trade" data-toggle="tab" role="tab">Trade</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#<?php echo 'card'.$data_arr[$i]['id']; ?>_details" data-toggle="tab" role="tab">Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#<?php echo 'card'.$data_arr[$i]['id']; ?>_prediction" data-toggle="tab" role="tab">Prediction</a>
                    </li>
                </ul>

            </div>
            <div class="tab-content clearfix">
                <div class="tab-pane active" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_trade" >
                    <div class="card-body">
                        <div>
                            <p  style="width: 50%; float:left" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_price">Price: <?php echo $data_arr[$i]['price']; ?></p>
                            <?php if ($data_arr[$i]['difference'] >=0){ ?>
                            <i  id="<?php echo 'card'.$data_arr[$i]['id']; ?>_up" class="fa fa-caret-up"  style="width:50%;float:right;color:green"></i>
                            <?php } else { ?>
                            <i  id="<?php echo 'card'.$data_arr[$i]['id']; ?>_down"  class="fa fa-caret-down" style="width:50%;float:right;color:red"></i>
                            <?php } ?>
                        </div>
                        <form action="index.php" method="post">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons" aria-label="Basic example">
                            <input id="<?php echo 'card'.$data_arr[$i]['id']; ?>_buy_button" type="radio" class="btn btn-secondary" style="background-color:red">Buy</input>
                            <input id="<?php echo 'card'.$data_arr[$i]['id']; ?>_sell_button" type="radio" class="btn btn-secondary" style="background-color:green">Sell</input>

                            <div class="container">
                                <div class="page-header"></div>
                                <div class="input-group spinner" >
                                    <input type="text" class="form-control" value="42" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_spin">

                                    <div class="input-group-btn-vertical">
                                        <button class="btn btn-default" type="button" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_up_spinner" ><i class="fa fa-caret-up"></i></button>
                                        <button class="btn btn-default" type="button" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_down_spinner"><i class="fa fa-caret-down"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 5px">
                            <a id=<?php echo 'card'.$data_arr[$i]['id']; ?>_cart_button href="#" class="btn btn-primary">Add to cart</a>
                            <a id=<?php echo 'card'.$data_arr[$i]['id']; ?>_checkout_button href="#" class="btn btn-primary">Checkout</a>
                        </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_details" >
                    <h3>We use the class nav-pills instead of nav-tabs which automatically creates a background color for the tab</h3>
                </div>

                <div class="tab-pane" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_prediction">
                    <h3>We applied clearfix to the tab-content to rid of the gap between the tab and the content</h3>
                </div>

            </div>

        </div>
    </div>
    <?php } $j=$j+3;?>
</div>
    <?php } ?>


<?php
echo $Paginator->createLinks( 'pagination' ); ?>

</body>
</html>