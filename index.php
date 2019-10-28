<?php
session_start();
if (isset($_SESSION['login_user'])) {
?>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>Bulls Or Bears Investors</title>

    <link href="img/bob.jpg" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>

    <?php
        require('predict.php');
        require_once 'Pagination.php';
        require('db_connection.php');
        global $connection;
        $conn = $connection;
        session_start();
        if(isset($_SESSION['sort_stock'])){
            $_POST['sort_stock']=TRUE;
            $val=$_SESSION['sort_stock'];
        }
        $limit = 6;
        $page = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;

        $query = "SELECT * FROM Company where delete_flag = 0";
        $search_results = $conn ->query($query);

        if(isset($_POST['sort_stock'])){
            if(isset($_POST['sort'])){
                $val= $_POST['sort'];
            }
            $_SESSION['sort_stock']=$val;
            switch($val){
                case 1: $query = "SELECT * FROM Company where delete_flag = 0 ORDER BY name"; break;
                case 2: $query = "SELECT * FROM company where delete_flag = 0 ORDER BY name DESC"; break;
                case 3: $query = "SELECT * FROM Company where delete_flag = 0 ORDER BY price"; break;
                case 4: $query = "SELECT * FROM Company where delete_flag = 0 ORDER BY price DESC"; break;
                default: $query = "SELECT * FROM Company where delete_flag = 0";
            }
            $_POST['sort_stock'] = null;
        }
        if(isset($_POST['search_stock'])){
            $id = $_POST['search'];
            $query = "SELECT * FROM Company where id=".$id;
            $_POST['search_stock'] = null;
        }

        $Paginator  = new pagination( $conn, $query );
        $results    = $Paginator->getData( $limit,$page );
        $data_arr = $results->data;
    ?>
</head>
<body>
<div class="click-closed"></div>
<!--/ Form Search Star /-->
<div class="box-collapse">
    <div class="title-box-d">
        <h3 class="title-d">Search Stocks</h3>
    </div>
    <span class="close-box-collapse right-boxed ion-ios-close"></span>
    <div class="box-collapse-wrap form">
        <form class="form-a" method="post" action="index.php">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <div class="form-group">
                        <label for="Type">Sort Price/ Company</label>
                        <select class="form-control form-control-lg form-control-a" id="Type" name="sort">
                            <option value="1">Company: Low To High</option>
                            <option value="2">Company: High To Low</option>
                            <option value="3">Price: Low To High</option>
                            <option value="4">Price: High To Low</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" name="sort_stock" class="btn btn-b">Sort Stock</button>
                </div>
                <div class="col-md-6 mb-2" style="padding-top: 50px;">
                    <div class="form-group">
                        <label for="Type">Search Company</label>
                        <select class="form-control form-control-lg form-control-a" id="Type" name="search">
                            <?php
                            while ($search_result = $search_results->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $search_result['id']; ?>"><?php echo $search_result['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" name="search_stock" class="btn btn-b">Search Company</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--/ Form Search End /-->
<!--/ Modal Start /-->
<div class="modal" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Message</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p class="error_msg"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--/ Modal End /-->
<!--/ Nav Star /-->
<nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault"
                aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        </button>
        <a class="navbar-brand text-brand" href="index.php">
            <img src="img/bob.jpg" width="100" height="100"/>
            <span class="color-b">Bulls</span>
            <span class="color-a">Or</span>
            <span class="color-e">Bears</span></a>
        <button type="button" class="btn btn-link nav-search navbar-toggle-box-collapse d-md-none" data-toggle="collapse"
                data-target="#navbarTogglerDemo01" aria-expanded="false">
            <span class="fa fa-search" aria-hidden="true"></span>
        </button>
        <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle fa-2x"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="transactionHistory.php">Transaction History</a></li>
                        <li><a class="dropdown-item" href="userProfile.php">Account Settings</a></li>
                        <li><a class="dropdown-item" href="userInventory.php">My Stocks</a></li>
                        <li><a class="dropdown-item" href="logout.php">LogOut</a></li>
                    </ul>
                </li>

                <?php
                    if($_SESSION['login_user']=='admin') {
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-cog fa-2x"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="admin_addCompany.php">Add Company</a></li>
                                <li><a class="dropdown-item" href="admin_companyList.php">View Company</a></li>
                                <li><a class="dropdown-item" href="admin_sales_history.php">Sales History</a></li>
                                <li><a class="dropdown-item" href="logout.php">LogOut</a></li>
                            </ul>
                        </li>

                        <?php
                    }
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart fa-2x"></i></a>
                </li>
            </ul>
        </div>
        <button type="button" class="btn btn-b-n navbar-toggle-box-collapse d-none d-md-block" data-toggle="collapse"
                data-target="#navbarTogglerDemo01" aria-expanded="false">
            <span class="fa fa-search" aria-hidden="true"></span>
        </button>
    </div>
</nav>
<!--/ Nav End /-->

<div class = "section-t8 container">
    <p>
        <a id="refresh_button" class="btn btn-success">
            <span  class="fa fa-refresh" style="color:white" ></span>
        </a>
    </p>
    <?php
    $j=0;
    while($j==0 || $j==3 && $j<6){
        ?>
    <div class="card-deck" style="padding: 5px">
        <?php
            for($i=$j;$i<$j+3&&$i<count($data_arr);$i++){
        ?>
            <div class="card col-xs-12 col-sm-6 col-md-4" style="margin: 8px; padding-right: 0px; padding-left: 0px" id="<?php echo 'card'.$j.$data_arr[$i]['id']; ?>" >
                <div style="padding-top: 2px">
                    <img src="<?php echo $data_arr[$i]['image']?>" style="border-style:solid; width: 20%; float:left" class="card-img-top" src="..." alt="Card image cap">
                    <h5 id="<?php echo 'card'.$data_arr[$i]['id']; ?>_name" style="width: 60%; float:right" class="card-title"><?php echo $data_arr[$i]['name']; ?></h5>
                </div>
                <div class="card text-center" style="margin-left: 0px; margin-right: 0px" >
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_tradenav" href="#<?php echo 'card'.$data_arr[$i]['id']; ?>_trade" data-toggle="tab" role="tab">Trade</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_detailsnav" href="#<?php echo 'card'.$data_arr[$i]['id']; ?>_details" data-toggle="tab" role="tab">Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_predictionnav" href="#<?php echo 'card'.$data_arr[$i]['id']; ?>_prediction" data-toggle="tab" role="tab">Prediction</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content clearfix">
                        <div class="tab-pane active" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_trade" >
                            <div class="card-body">
                                <div>
                                    <p style="width: 50%; float:left" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_price">Price:<?php echo $data_arr[$i]['price']; ?></p>
                                    <?php if ($data_arr[$i]['difference'] >=0){ ?>
                                        <i  id="<?php echo 'card'.$data_arr[$i]['id']; ?>_up" class="fa fa-caret-up fa-2x"  style="width:50%;float:right;color:green"></i>
                                    <?php } else { ?>
                                        <i  id="<?php echo 'card'.$data_arr[$i]['id']; ?>_down"  class="fa fa-caret-down fa-2x  " style="width:50%;float:right;color:red"></i>
                                    <?php } ?>
                                </div>
                                <div>
                                    <div style="width: 40%;float:right">
                                    <div class="form-check form-check-inline" >
                                        <input class="form-check-input <?php echo 'card'.$data_arr[$i]['id']; ?>" type="radio" name="<?php echo 'card'.$data_arr[$i]['id']; ?>_buy_sell" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_buy_button" value="b" checked>
                                        <label class="form-check-label" for="inlineRadio1" >Buy</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input <?php echo 'card'.$data_arr[$i]['id']; ?>" type="radio" name="<?php echo 'card'.$data_arr[$i]['id']; ?>_buy_sell" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_sell_button" value="s">
                                        <label class="form-check-label" for="inlineRadio2">Sell</label>
                                    </div>
                                    </div>
                                    <div style="width:60%:float:left">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons" aria-label="Basic example">
                                        <div class="container">
                                            <div class="page-header"></div>
                                            <div class="input-group spinner" >
                                                <input type="number" min="1" class="form-control" value="1" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_spin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                    <div style="padding-top: 5px">
                                        <button type="button" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_cart_button"  class="btn btn-success car" >Add to cart</button>
                                        <button type="button" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_checkout_button"  class="btn btn-success checkout">Checkout</button>

                                    </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_details" >
                            <p>
                                Open: <?php echo $data_arr[$i]['open']; ?> <br>
                                High: <?php echo $data_arr[$i]['high']; ?> <br>
                                Low:  <?php echo $data_arr[$i]['low']; ?> <br>
                                Last trade day: <?php echo $data_arr[$i]['last_trade_day']; ?> <br>
                                Previous Close: <?php echo $data_arr[$i]['previous_close']; ?> <br>
                            </p>

                        </div>

                        <div class="tab-pane" id="<?php echo 'card'.$data_arr[$i]['id']; ?>_prediction">
                            <?php
                            $query_check = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = N'".$data_arr[$i]['symbol']."'";
                            $result_check = $conn->query($query_check);
                            if($result_check->num_rows>0) {
                                ?>
                                <p>

                                    <b>Prediction for tomorrow</b>:
                                    <br/>
                                    <br/>

                                    <?php
                                    $stock = $data_arr[$i]['symbol'];
                                    predict_for_closing_price($stock);
                                    ?>
                                    <br/>

                                    <br/>
                                    <?php
                                    $stock = $data_arr[$i]['symbol'];
                                    predict_for_opening_price($stock);
                                    ?>
                                </p>
                                <?php
                            }
                            else{
                                ?>
                                <p>No prediction data available</p>
                            <?php
                            }
                            ?>
                        </div>

                    </div>

                </div>
            </div>
        <?php } $j=$j+3;?>
    </div>
<?php }

    echo $Paginator->createLinks( 'pagination' ); ?>

</div>

<!--/ footer Star /-->
<section class="section-footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <div class="widget-a">
                    <div class="w-header-a">
                        <h3 class="w-title-a text-brand">Bulls Or Bears</h3>
                    </div>
                    <div class="w-body-a">
                        <p class="w-text-a color-text-a">
                            Leading financial services company and pioneer in the online stock sales industry. Itâ€™s the platform for traders passionate about the markets. Intuitive and easy-to-use. Packed with opportunity-finding and market-seizing tools and features.
                        </p>
                    </div>
                    <div class="w-footer-a">
                        <ul class="list-unstyled">
                            <li class="color-a">
                                <span class="color-text-a">Phone </span> +1 (123)456-7890 </li>
                            <li class="color-a">
                                <span class="color-text-a">Email </span> bobinvestors@gmail.com</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 section-md-t3">
                <div class="widget-a">
                    <div class="w-header-a">
                        <h3 class="w-title-a text-brand">The Company</h3>
                    </div>
                    <div class="w-body-a">
                        <div class="w-body-a">
                            <ul class="list-unstyled">
                                <li class="item-list-a">
                                    <i class="fa fa-angle-right"></i> <a href="#">Site Map</a>
                                </li>
                                <li class="item-list-a">
                                    <i class="fa fa-angle-right"></i> <a href="#">Legal</a>
                                </li>
                                <li class="item-list-a">
                                    <i class="fa fa-angle-right"></i> <a href="#">Agent Admin</a>
                                </li>
                                <li class="item-list-a">
                                    <i class="fa fa-angle-right"></i> <a href="#">Careers</a>
                                </li>
                                <li class="item-list-a">
                                    <i class="fa fa-angle-right"></i> <a href="#">Affiliate</a>
                                </li>
                                <li class="item-list-a">
                                    <i class="fa fa-angle-right"></i> <a href="#">Privacy Policy</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 section-md-t3">
                <div class="widget-a">
                    <div class="w-header-a">
                        <h3 class="w-title-a text-brand">International sites</h3>
                    </div>
                    <div class="w-body-a">
                        <ul class="list-unstyled">
                            <li class="item-list-a">
                                <i class="fa fa-angle-right"></i> <a href="#">India</a>
                            </li>
                            <li class="item-list-a">
                                <i class="fa fa-angle-right"></i> <a href="#">America</a>
                            </li>
                            <li class="item-list-a">
                                <i class="fa fa-angle-right"></i> <a href="#">Canada</a>
                            </li>
                            <li class="item-list-a">
                                <i class="fa fa-angle-right"></i> <a href="#">Germany</a>
                            </li>
                            <li class="item-list-a">
                                <i class="fa fa-angle-right"></i> <a href="#">Singapore</a>
                            </li>
                            <li class="item-list-a">
                                <i class="fa fa-angle-right"></i> <a href="#">China</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="nav-footer">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">About</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">Property</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">Blog</a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">Contact</a>
                        </li>
                    </ul>
                </nav>
                <div class="socials-a">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-facebook-f" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-instagram" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-pinterest-p" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-dribbble" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--/ Footer End /-->

<a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
<div id="preloader"></div>

<!-- JavaScript Libraries -->

<script src="lib/jquery/jquery-migrate.min.js"></script>
<script src="lib/popper/popper.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="lib/scrollreveal/scrollreveal.min.js"></script>

<!-- Template Main Javascript File -->
<script src="js/main.js"></script>
</body>
</html>

    <?php
}

else{
    header("location: login.php");
}
?>
