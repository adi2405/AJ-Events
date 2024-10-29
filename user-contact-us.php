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

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Tooplate">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>AJEvents/ Tickets</title>


    <!-- Additional CSS Files -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" type="text/css" href="assets/css/owl-carousel.css">

    <link rel="stylesheet" href="assets/css/tooplate-artxibition.css">

    <style>
        /* Contact Form Styling */
        .contact-form-section {
            background-color: #f9f9f9;
            padding: 60px 0;
        }

        .contact-form {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }

        .contact-form h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 32px;
            margin-bottom: 40px;
            color: #333;
        }

        .contact-form input[type="text"],
        .contact-form input[type="email"],
        .contact-form textarea {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            color: #333;
            background-color: #f7f7f7;
            transition: all 0.3s ease;
        }

        .contact-form input[type="text"]:focus,
        .contact-form input[type="email"]:focus,
        .contact-form textarea:focus {
            border-color: #333;
            background-color: #fff;
        }

        .contact-form textarea {
            resize: none;
            height: 150px;
        }

        .contact-form button.main-dark-button {
            font-family: 'Poppins', sans-serif;
            background-color: #333;
            color: #fff;
            padding: 12px 40px;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .contact-form button.main-dark-button:hover {
            background-color: #656c74;
        }

        .contact-form fieldset {
            border: none;
            padding: 0;
            margin: 0;
        }

        .contact-form input,
        .contact-form textarea {
            outline: none;
            box-shadow: none;
        }

        @media (max-width: 768px) {
            .contact-form {
                padding: 20px;
            }
            
            .contact-form h2 {
                font-size: 28px;
            }
        }
    </style>

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
                            <li><a href="user-about.php">About Us</a></li>
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
            <form id="loginForm" action="auth.php" method="POST" onsubmit="clearForm('loginForm')">
                <label for="email">Email:  <i class="fa fa-envelope" aria-hidden="true"></i></label>
                <input type="email" id="loginEmail" name="email" required>
                
                <label for="password">Password:  <i class="fas fa-lock fa-sm"></i></label>
                <div class="password-wrapper">
                    <input type="password" id="loginPassword" name="password" required>
                    <i class="fa-solid fa-eye" onclick="togglePassword('loginPassword', this)"></i>
                </div>
                
                <button type="submit" name="login">Login</button>
            </form>
            </div>
    
            <!-- Signup Form -->
            <div id="Signup" class="tabcontent">
            <h2>Signup</h2>
            <form id="signupForm" action="auth.php" method="POST" onsubmit="clearForm('signupForm')">
                <label for="name">Username:  <i class="fa fa-user" aria-hidden="true"></i></label>
                <input type="text" id="signupName" name="name" required>
                
                <label for="email">Email:  <i class="fa fa-envelope" aria-hidden="true"></i></label>
                <input type="email" id="signupEmail" name="email" required>
                
                <label for="password">Password:  <i class="fas fa-lock fa-sm"></i></label>
                <div class="password-wrapper">
                    <input type="password" id="signupPassword" name="password" required>
                    <i class="fa-solid fa-eye" onclick="togglePassword('signupPassword', this)"></i>
                </div>
                
                <button type="submit" name="signup">Signup</button>
            </form>
            </div>
        </div>
        </div>
    </div>

    <!-- Contact Form Section -->
    <div class="contact-form-section" style="background-color: #f9f9f9; padding: 60px 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="contact-form">
                        <h2>Contact Us</h2>
                        <form id="contactForm" action="user-contact-us.php" method="POST" onsubmit="clearForm('contactForm')">
                            <div class="row">
                                <div class="col-lg-6">
                                    <fieldset>
                                        <input type="text" name="name" id="name" placeholder="Your Name" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-6">
                                    <fieldset>
                                        <input type="email" name="email" id="email" placeholder="Your Email" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <input type="text" name="subject" id="subject" placeholder="Subject" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <textarea name="message" id="message" rows="6" placeholder="Your Message" required></textarea>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" class="main-dark-button">Send Message</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
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
</html>