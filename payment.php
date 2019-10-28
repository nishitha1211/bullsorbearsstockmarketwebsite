<?php
session_start();
if (isset($_SESSION['login_user'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bulls Or Bears Investors</title>

    <link href="img/bob.jpg" rel="icon">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">

    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/jquery/jquery-migrate.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <?php
    ?>
</head>
<body>
<div class="click-closed"></div>

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
                    <a class="nav-link" href="index.php">Home</a>
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
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="transactionHistory.php">Transaction History</a>
                        <a class="dropdown-item" href="userProfile.php">Account Settings</a>
                        <a class="dropdown-item" href="userInventory.php">My Stocks</a>
                        <a class="dropdown-item" href="logout.php">LogOut</a>
                    </div>
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
<div class="section-t8 container">
    <ul class="nav nav-tabs md-tabs" id="myTabMD" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#Credit" role="tab">Credit Card</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#PayPal" role="tab">Paypal</a>
        </li>
    </ul>
    <div class="tab-content card pt-5">
        <div class="tab-pane fade show active col-md-4" style=" margin: auto; padding-bottom: 10px; padding-top: 10px;" id="Credit" role="tabpanel">
            <div class="card card-outline-secondary">
                <div class="card-body">
                    <h3 class="text-center">Credit Card Payment</h3>
                    <hr>
                    <form class="form" role="form" action="paymentHelper.php" method="post">
                        <div class="form-group">
                            <label for="cc_name">Card Holder's Name</label>
                            <input type="text" class="form-control" id="cc_name" pattern="\w+ \w+.*" required="required">
                        </div>
                        <div class="form-group">
                            <label>Card Number</label>
                            <input type="text" class="form-control" maxlength="20" pattern="\d{16}" required="">
                        </div>
                        <div class="form-group row">
                            <label class="col-md-12">Card Exp. Date</label>
                            <div class="col-md-4">
                                <select class="form-control" name="cc_exp_mo" size="0">
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select class="form-control" name="cc_exp_yr" size="0">
                                    <option>2018</option>
                                    <option>2019</option>
                                    <option>2020</option>
                                    <option>2021</option>
                                    <option>2022</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">CVC</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" autocomplete="off" maxlength="3" pattern="\d{3}" title="Three digits at back of your card" required="" placeholder="CVC">
                            </div>
                        </div>
                        <hr>
                        <?php
                            if(isset($_POST['id'])){
                                ?>
                                <input type='hidden' name='id' value='<?php echo $_POST['id']; ?>'/>
                                <input type='hidden' name='quantity' value='<?php echo $_POST['quantity']; ?>'/>
                                <input type='hidden' name='buy_sell' value='<?php echo $_POST['buy_sell']; ?>'/>
                                <input type='hidden' name='price' value='<?php echo $_POST['price']; ?>'/>
                                <input type='hidden' name='userId' value='<?php echo $_POST['userId']; ?>'/>
                        <?php
                            }
                        ?>
                        <input type='hidden' name='var' value='<?php echo "$var";?>'/>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <button type="reset" class="btn btn-default btn-lg btn-block">Cancel</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" name="cc_submit" class="btn btn-success btn-lg btn-block">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="PayPal" role="tabpanel" style=" margin: auto; padding-bottom: 10px; padding-top: 10px;">
            <div class="card card-outline-secondary">
                <div class="card-body">
                    <h3 class="text-center">PayPal Payment</h3>
                    <hr>
                    <form class="form" role="form" action="paymentHelper.php" method="post">
                        <div class="form-group">
                            <label for="cc_name">Email</label>
                            <input type="email" class="form-control" id="email" required="required">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" required="">
                        </div>
                        <hr>
                        <?php
                            if(isset($_POST['id'])){
                        ?>
                        <input type='hidden' name='id' value='<?php echo $_POST['id']; ?>'/>
                        <input type='hidden' name='quantity' value='<?php echo $_POST['quantity']; ?>'/>
                        <input type='hidden' name='buy_sell' value='<?php echo $_POST['buy_sell']; ?>'/>
                        <input type='hidden' name='price' value='<?php echo $_POST['price']; ?>'/>
                        <input type='hidden' name='userId' value='<?php echo $_POST['userId']; ?>'/>
                        <?php
                            }
                        ?>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <button type="reset" class="btn btn-default btn-lg btn-block">Cancel</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" name="pp_submit" class="btn btn-success btn-lg btn-block">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                                <span class="color-text-a">Phone </span> +1 (123)456-7890
                            </li>
                            <li class="color-a">
                                <span class="color-text-a">Email </span> bobinvestors@gmail.com
                            </li>
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
<script src="js/main.js"></script>
</body>
</html>

    <?php
}

else{
    header("location: login.php");
}
?>