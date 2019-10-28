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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
        <link href="css/style.css" rel="stylesheet">
        <script src="lib/jquery/jquery.min.js"></script>
        <script src="lib/jquery/jquery-migrate.min.js"></script>
        <script src="lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <script src="js/cart.js"></script>

        <?php
        require('db_connection.php');
        global $connection;
        $conn = $connection;
        session_start();
        $userId = $_SESSION['userId'];


        if (isset($_POST['number'])) {
            $id = $_POST['number'];
            $query1 = "Update cart set delete_flag=1 where id=" . $id;
            $conn->query($query1);
        }

        if (isset($_POST['quantity']) && isset($_POST['cart_id'])) {
            $quantity = $_POST['quantity'];
            $cart_id = $_POST['cart_id'];
            $query_cart = "Select total_price,quantity from cart where id=" . $cart_id;
            $results = $conn->query($query_cart);
            $per_price = 0;
            while ($result = $results->fetch_assoc()) {
                $price = $result['total_price'];
                $quan = $result['quantity'];
                $per_price = $price / $quan;
                echo "per price" . $per_price;
            }
            $total_price = $per_price * $quantity;
            $query1 = "Update cart set total_price={$total_price}, quantity={$quantity} where id=" . $cart_id;
            $conn->query($query1);
        }

        $query = "SELECT cart.id AS id, cart.companyId as companyId, cart.total_price as total_price, cart.quantity as quantity, cart.buy_sell as buy_sell,cart.delete_flag as delete_flag, company.name as companyName 
        FROM cart join company ON cart.companyId=company.id where cart.delete_flag=0 AND company.delete_flag=0 AND cart.userId=".$userId;
        $results = $conn->query($query);
        ?>
    </head>

    <body>
    <div class="click-closed"></div>
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
            <button type="button" class="btn btn-link nav-search navbar-toggle-box-collapse d-md-none"
                    data-toggle="collapse"
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
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown"
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
        </div>
    </nav>
    <!--/ Nav End /-->

    <div class="section-t8 container">
        <h3>Cart</h3>
        <table class="table">
            <tr>
                <th>S.No</th>
                <th>Company Name</th>
                <th>Total Price</th>
                <th>Quantity</th>
                <th>Buy/Sell</th>
                <th>Delete</th>
            </tr>
            <?php
            $i = 0;
            while ($result = $results->fetch_assoc()) {
                $i = $i + 1;
                ?>
                <tr id="table-row">
                    <td> <?php echo $i ?>  </td>
                    <td> <?php echo $result['companyName'] ?> </td>
                    <td><?php echo $result['total_price'] ?></td>
                    <td style="text-align: center">
                        <input id="<?php echo $result['id'] ?>_quantity" type="number" min="1"
                               value="<?php echo $result['quantity'] ?>">
                        <i id="<?php echo $result['id'] ?>_tick" class="fas fa-check"
                           style="visibility: hidden; padding-left: 10px;"></i>
                    </td>
                    <td><?php echo $result['buy_sell'] ?></td>
                    <td><i id="<?php echo $result['id'] ?>_trash" class="fa fa-trash" aria-hidden="true"></i></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <button id="checkout" class="btn btn-lg btn-success"><i class="glyphicon glyphicon-ok-sign"></i>Checkout
        </button>
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
                                Leading financial services company and pioneer in the online stock sales industry.
                                Itâ€™s the platform for traders passionate about the markets. Intuitive and easy-to-use.
                                Packed with opportunity-finding and market-seizing tools and features.
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

    <script src="lib/popper/popper.min.js"></script>
    <script src="js/main.js"></script>
    </body>
    </html>

    <?php
}

else{
    header("location: login.php");
}
    ?>