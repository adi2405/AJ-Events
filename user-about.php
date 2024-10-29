<?php
session_start();
include("connect.php");

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Regenerate session ID to prevent session fixation
if (!isset($_SESSION['regenerated'])) {
    session_regenerate_id(true);
    $_SESSION['regenerated'] = true;
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE php>
<php lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Tooplate">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <title>AJEvents/ About Us</title>


    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" type="text/css" href="assets/css/owl-carousel.css">

    <link rel="stylesheet" href="assets/css/tooplate-artxibition.css">

    </head>
    
    <body>
    
    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
      <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Pre HEader ***** -->
    <div class="pre-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <span>Hey! The Show Is Starting In 5 Days.</span>
                </div>
                <div class="col-lg-6 col-sm-6">
                    <div class="text-button">
                        <a href="user-contact-us.php">Contact Us Now! <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="user-homepage.php" class="logo">AJ<em>Events</em></a>
                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li><a href="user-homepage.php">Home</a></li>
                            <li><a href="user-about.php" class="active">About Us</a></li>
                            <li><a href="rent-venue.php">Rent Venue</a></li>
                            <li><a href="user-shows-events.php">Shows & Events</a></li> 
                            <li><a href="user-tickets.php">Tickets</a></li> 
                            <li><a href="user-dashboard.php">My Dashboard</a></li> 
                            <li><a href="javascript:void(0);" class="logout-button" onclick="logout()">Logout</a></li>
                        </ul>        
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- Login/Signup Modal -->
    <div id="authModal" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        <div class="auth-form">
            <!-- Tabs for Login and Signup -->
            <div class="tab">
            <button class="tablinks" onclick="openForm(event, 'Login')">Login</button>
            <button class="tablinks" onclick="openForm(event, 'Signup')">Signup</button>
            </div>

            <!-- Login Form -->
            <div id="Login" class="tabcontent">
            <h2>Login</h2>
            <form id="loginForm">
                <label for="email">Email:  <i class="fa fa-envelope" aria-hidden="true"></i></label>
                <input type="email" id="loginEmail" name="email" required>
                
                <label for="password">Password:  <i class="fas fa-lock fa-sm"></i></label>
                <div class="password-wrapper">
                    <input type="password" id="loginPassword" name="password" required>
                    <i class="fa-solid fa-eye" onclick="togglePassword('loginPassword', this)"></i>
                </div>
                
                <button type="submit">Login</button>
            </form>
            </div>

            <!-- Signup Form -->
            <div id="Signup" class="tabcontent">
            <h2>Signup</h2>
            <form id="signupForm">
                <label for="name">Username:  <i class="fa fa-user" aria-hidden="true"></i></label>
                <input type="text" id="signupName" name="name" required>
                
                <label for="email">Email:  <i class="fa fa-envelope" aria-hidden="true"></i></label>
                <input type="email" id="signupEmail" name="email" required>
                
                <label for="password">Password:  <i class="fas fa-lock fa-sm"></i></label>
                <div class="password-wrapper">
                    <input type="password" id="signupPassword" name="password" required>
                    <i class="fa-solid fa-eye" onclick="togglePassword('signupPassword', this)"></i>
                </div>
                
                <button type="submit">Signup</button>
            </form>
            </div>
        </div>
        </div>
    </div>  

    <!-- ***** About Us Page ***** -->
    <div class="page-heading-about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Radio City Musical Hall</h2>
                    <span>October 24-28, 2024 in Navi Mumbai</span>
                </div>
            </div>
        </div>
    </div>

    <div class="about-item">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="left-image">
                        <img src="assets/images/about-image.jpg" alt="party time">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-content">
                        <div class="about-map-image">
                            <img src="assets/images/about-map-image.jpg" alt="party location">
                        </div>
                        <div class="down-content">
                            <h4>Radio City Musical Hall</h4>
                            <ul>
                                <li>Oct 24 Friday</li>
                                <li>09:30 AM - 07:00 PM</li>
                            </ul>
                            <span><i class="fa fa-ticket"></i> Tickets Starting From $34.00</span>
                            <div class="main-dark-button">
                                <a href="ticket-details.php">Purchase Tickets</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="about-upcoming-shows">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <h2>About The Upcoming Show</h2>
                    <p><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Qui quod maiores, rerum modi molestias id, natus tempora neque quam vitae odit, fuga ipsa eaque facere veniam numquam iure perferendis deleniti.</p></p>
                    <h4>Items That Are Restricted</h4>
                    <ul>
                        <li>* Flash Cameras</li>
                        <li>* Food & Drinks</li>
                        <li>* Any kind of flashy objects</li>
                    </ul>
                    <h4>Directions & Car Parking</h4>
                    <p>Art party vegan mixtape before they sold out raclette, cliche banh mi mumblecore ugh hell of. Art party kene 
                        ugh umami, readymade tbh small batch austin distillery aesthetic.Shoreditch narwhal livers edge actually godar
                        affogato sartorial waistcoat ugh raw denim stumptown.
                        </p>
                    <div class="text-button">
                        <a href="user-event-details.php">Need Directions? <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="next-shows">
                        <h4><i class="fa fa-clock-o"></i> Get The Next Show Tickets</h4>
                        <ul>
                            <li>
                                <h5>Winter pop Festival</h5>
                                <span>Oct 22 Fri<br>08:30 AM - 11:00 PM</span>
                                <div class="icon-button">
                                    <a href="ticket-details.php">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <h5>Rock Music Festival</h5>
                                <span>Oct 24 Wed<br>11:00 AM - 09:00 PM</span>
                                <div class="icon-button">
                                    <a href="ticket-details.php">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <h5>Water Splash Festival</h5>
                                <span>Oct 28 Friday<br>10:00 AM - 11:00 PM</span>
                                <div class="icon-button">
                                    <a href="ticket-details.php">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="also-like">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>You Might Also Like...</h2>
                </div>
                <div class="col-lg-4">
                    <div class="like-item">
                        <div class="thumb">
                            <a href="user-event-details.php"><img src="assets/images/like-01.jpg" alt=""></a>
                            <div class="icons">
                                <ul>
                                    <li><a href="user-event-details.php"><i class="fa fa-arrow-right"></i></a></li>
                                    <li><a href="ticket-details.php"><i class="fa fa-ticket"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="down-content">
                            <span>Oct 20 to 24, 2024</span>
                            <a href="user-event-details.php"><h4>Wonder Land Music and Arts Festival</h4></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="like-item">
                        <div class="thumb">
                            <a href="user-event-details.php"><img src="assets/images/like-02.jpg" alt=""></a>
                            <div class="icons">
                                <ul>
                                    <li><a href="user-event-details.php"><i class="fa fa-arrow-right"></i></a></li>
                                    <li><a href="ticket-details.php"><i class="fa fa-ticket"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="down-content">
                            <span>Nov 21 to 26, 2024</span>
                            <a href="user-event-details.php"><h4>Big Water Splashing Festival</h4></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="like-item">
                        <div class="thumb">
                            <a href="user-event-details.php"><img src="assets/images/like-03.jpg" alt=""></a>
                            <div class="icons">
                                <ul>
                                    <li><a href="user-event-details.php"><i class="fa fa-arrow-right"></i></a></li>
                                    <li><a href="ticket-details.php"><i class="fa fa-ticket"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="down-content">
                            <span>Dec 10 to 18, 2024</span>
                            <a href="user-event-details.php"><h4>Tiger Dance Hip Hop Festival</h4></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- *** Subscribe *** -->
    <div class="subscribe">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h4>Subscribe Our Newsletter:</h4>
                </div>
                <div class="col-lg-8">
                    <form id="subscribe" action="" method="get">
                        <div class="row">
                          <div class="col-lg-9">
                            <fieldset>
                              <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your Email Address" required="">
                            </fieldset>
                          </div>
                          <div class="col-lg-3">
                            <fieldset>
                              <button type="submit" id="form-submit" class="main-dark-button">Submit</button>
                            </fieldset>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- *** Footer *** -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="address">
                        <h4>AJEvents HQ Address</h4>
                        <span>G-907 Balaji Symphony, <br>Sukapur, New Panvel 410206,<br>Navi Mumbai.</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><a href="#">Info</a></li>
                            <li><a href="#">Venues</a></li>
                            <li><a href="#">Guides</a></li>
                            <li><a href="#">Videos</a></li>
                            <li><a href="#">Outreach</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="hours">
                        <h4>Open Hours</h4>
                        <ul>
                            <li>Mon to Fri: 10:00 AM to 8:00 PM</li>
                            <li>Sat - Sun: 11:00 AM to 4:00 PM</li>
                            <li>Holidays: Closed</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="under-footer">
                        <div class="row">
                            <div class="col-lg-6">
                                <p>Maharashtra, India.</p>
                            </div>
                            <div class="col-lg-6">
                                <p class="copyright">&copy; 2024 AJEvents Company</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="sub-footer">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="logo"><span>AJ<em>Events</em></span></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="menu">
                                    <ul>
                                        <li><a href="user-homepage.php" class="active">Home</a></li>
                                        <li><a href="user-about.php">About Us</a></li>
                                        <li><a href="rent-venue.php">Rent Venue</a></li>
                                        <li><a href="user-shows-events.php">Shows & Events</a></li> 
                                        <li><a href="user-tickets.php">Tickets</a></li> 
                                        <li><a href="user-dashboard.php">My Dashboard</a></li> 
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="social-links">
                                    <ul>
                                        <li>
                                            <a href="https://twitter.com">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="white"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                                            </a>
                                        </li>
                                        <li><a href="https://www.instagram.com"><i class="fa-brands fa-instagram"></i></a></li>
                                        <li><a href="https://www.facebook.com"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script> 
    <script src="assets/js/mixitup.js"></script> 
    <script src="assets/js/accordions.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    
    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/auth-modal.js"></script>

  </body>
</php>