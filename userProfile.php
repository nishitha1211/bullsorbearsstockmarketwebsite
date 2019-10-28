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
        require('db_connection.php');
        global $connection;
        $conn = $connection;
        $userId = $_SESSION['userId'];
        if(isset($_POST['submit']))
        {
            $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
            $update_query = "update person set NAME= '{$_POST['first_name']}',gender='{$_POST['gender']}',username='{$_POST['username']}',email='{$_POST['email']}',pass='{$password}',phone={$_POST['phone']} where id=".$userId;
            $update_result = $conn->query($update_query);
            echo "update: ".$update_result;
        }
        $query = "SELECT * FROM person where id={$userId} and delete_flag=0";
        $results = $conn->query($query);
        ?>
    </head>

    <body>
    <div class="click-closed"></div>

    <!--/ Nav Star /-->
    <nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault"
                    aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
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

    <div class="container section-t8">
        <?php while ($result = $results->fetch_assoc()) { ?>
            <h3>Profile</h3>
            <form class="form" action="userProfile.php" method="post" id="userProfileForm">
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="first_name"><strong>First Name</strong></label>
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="first name" value="<?php echo $result['NAME']; ?>" required>

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="last_name"><strong>Last Name</strong></label>
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="last name" value="<?php echo $result['NAME']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="gender"><strong>Gender</strong></label>
                        <input type="text" class="form-control" name="gender" id="gender" placeholder="gender" value="<?php echo $result['gender']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="phone"><strong>Phone</strong></label>
                        <input type="tel" class="form-control" name="phone" id="phone" placeholder="enter phone" value="<?php echo $result['phone']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="email"><strong>Email</strong></label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="you@email.com" value="<?php echo $result['email']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="username"><strong>Username</strong></label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="username" value="<?php echo $result['username']; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <label for="password"><strong>Password</strong></label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="password" value="" required>

                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <br>
                        <br>
                        <button class="btn btn-lg btn-success" type="submit" name="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                        <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                    </div>
                </div>
            </form>
        <?php } ?>
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

    <script src="js/main.js"></script>

    </body>
    </html>

    <?php
}

else{
    header("location: login.php");
}
?>
