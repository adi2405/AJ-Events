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
    <meta name="author" content="Events">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>AJEvents/ Rent a venue</title>


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
                            <li><a href="user-about.php">About Us</a></li>
                            <li><a href="rent-venue.php" class="active">Rent Venue</a></li>
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
    <div class="page-heading-rent-venue">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Are You Looking For A Venue?</h2>
                    <span>Check out our venues, pick your choice and fill the reservation application.</span>
                </div>
            </div>
        </div>
    </div>

    <div class="rent-venue-tabs">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row" id="tabs">
                        <div class="col-lg-12">
                            <div class="heading-tabs">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <ul>
                                          <li><a href='#tabs-1'>Madison Square Garden</a></li>
                                          <li><a href='#tabs-2'>Radio City Musical Hall</a></a></li>
                                          <li><a href='#tabs-3'>Royce Hall</a></a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-4">
                                          <div class="main-dark-button">
                                              <a href="user-tickets.php">Purchase Tickets</a>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <section class='tabs-content'>
                                <article id='tabs-1'>
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <div class="right-content">
                                                <h4>Madison Square Garden</h4>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Pariatur vero illum sit dicta officia dignissimos quis totam dolorem, libero, ipsa voluptatum natus, vel enim quia aut. Ullam placeat esse enim!
                                                <br>
                                                <br>
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio aut, quidem aspernatur omnis molestiae asperiores in blanditiis minus sit. Sit beatae, id voluptas aliquid repellat iusto consequatur obcaecati. Nihil, nostrum!
                                                </p>
                                                <ul class="list">
                                                    <li>Madison Square Garden</li>
                                                    <li>$2,840 per day</li>
                                                    <li>860 Guests</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div id="map">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4055.832024014269!2d72.85986867551051!3d19.061981282139772!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c90064e6b06d%3A0xa117f6f432847cb3!2sJio%20World%20Garden!5e1!3m2!1sen!2sin!4v1728740546142!5m2!1sen!2sin" width="100%" height="240px" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                <h5>Any Question?</h5>
                                                <p>Tumeric air affogato sare torial waistcoat denim stumber.</p>
                                            <div class="text-button">
                                                <a href="ticket-details.php">Need Direction? <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </article>                            
                                <article id='tabs-2'>
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <div class="right-content">
                                                <h4>Radio City Musical Hall</h4>
                                                <p> Aliquam tempor, purus vitae ullamcorper rhoncus, quam nunc imperdiet sem, sed placerat purus dui in lorem. Donec ornare at risus in varius. In at magna ante. Curabitur at metus sed purus pretium ullamcorper. Cras vitae sapien bibendum urna pulvinar faucibus. Aliquam sed dui in orci tincidunt cursus quis non tellus. Vestibulum a placerat ex, ac cursus dui.</p>
                                                <ul class="list">
                                                    <li>Radio City Musical Hall</li>
                                                    <li>$4,750 per day</li>
                                                    <li>1,100 Guests</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div id="map">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4057.7305859613316!2d72.81750037550877!3d18.98420888220155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7ce63d14b3d83%3A0xb6ce08c6304dcc32!2sMahalakshmi%20Race%20Course!5e1!3m2!1sen!2sin!4v1728740715565!5m2!1sen!2sin" width="100%" height="240px" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                <h5>Any Question?</h5>
                                                <p>Tumeric air affogato sare torial waistcoat denim stumber.</p>
                                            <div class="text-button">
                                                <a href="ticket-details.php">Need Direction? <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </article>   
                                <article id='tabs-3'>
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <div class="right-content">
                                                <h4>Royce Hall</h4>
                                                <p> Maecenas ut pharetra felis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed ut nisi quis tellus vulputate posuere. Aenean consectetur quam et quam fringilla, nec aliquam diam congue. Nulla dui arcu, aliquam sed mattis non, euismod vitae libero. </p>
                                                <ul class="list">
                                                    <li>Royce Hall</li>
                                                    <li>$5,860 per day</li>
                                                    <li>1,250 Guests</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div id="map">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4056.3184687154794!2d73.02420997551005!3d19.04208378215547!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c3c53b1e255b%3A0x3fa8b73a42118233!2sD%20Y%20Patil%20Sports%20Stadium!5e1!3m2!1sen!2sin!4v1728740906607!5m2!1sen!2sin" width="100%" height="240px" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                                <h5>Any Question?</h5>
                                                <p>Tumeric air affogato sare torial waistcoat denim stumber.</p>
                                            <div class="text-button">
                                                <a href="ticket-details.php">Need Direction? <i class="fa fa-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </article>    
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rent-venue-application">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="heading-text">
                        <h4>Reservation Application</h4>
                    </div>
                    <div class="contact-form">
                        <form id="contact" action="" method="post">
                          <div class="row">
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <input name="name" type="text" id="name" placeholder="Your Name*" required="">
                              </fieldset>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your Email*" required="">
                              </fieldset>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <input name="phone-number" type="text" id="phone-number" placeholder="Phone Number*" required="">
                              </fieldset>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <input name="company-organization" type="text" id="company-organization" placeholder="Company / Organization*" required="">
                              </fieldset>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <input name="venue-requested" type="text" id="venue-requested" placeholder="Venue Requested*" required="">
                              </fieldset>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <input name="type-event" type="text" id="type-event" placeholder="Type Of Event*" required="">
                              </fieldset>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <input name="date-requested-first" type="text" id="date-requested-first" placeholder="Date Requested (Primary Date)*" required="">
                              </fieldset>
                            </div>
                            <div class="col-md-6 col-sm-12">
                              <fieldset>
                                <input name="date-requested-second" type="text" id="date-requested-second" placeholder="Date Requested (Secondary Date)*" required="">
                              </fieldset>
                            </div>
                            <div class="col-lg-12">
                              <fieldset>
                                <textarea name="about-event-hosting" rows="6" id="about-event-hosting" placeholder="About The Event You Are Hosting" required=""></textarea>
                              </fieldset>
                            </div>
                            <div class="col-lg-12">
                              <fieldset>
                                <button type="submit" id="form-submit" class="main-dark-button">Submit Request</button>
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