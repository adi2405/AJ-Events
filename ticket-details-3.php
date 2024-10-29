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

    <title>AJEvents/ Ticket Details</title>


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
                            <li><a href="rent-venue.php">Rent Venue</a></li>
                            <li><a href="user-shows-events.php">Shows & Events</a></li> 
                            <li><a href="user-tickets.php" class="active">Tickets</a></li> 
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

    <!-- ***** About Us Page ***** -->
    <div class="page-heading-shows-events">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Tickets On Sale Now!</h2>
                    <span>Check out Today's events and upcoming shows and grab your ticket right now.</span>
                </div>
            </div>
        </div>
    </div>

    <div class="ticket-details-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="left-image">
                        <img src="assets/images/ticket-details-3.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-content">
                        <h4>Golden Festival</h4>
                        <span>200 Tickets still available</span>
                        <ul>
                            <li><i class="fa fa-clock-o"></i> Sunday: 06:00 PM to 09:00 PM</li>
                            <li><i class="fa fa-map-marker"></i>DY Patil Stadium, Navi Mumbai</li>
                        </ul>
                        <form id="ticketForm" action="confirm-purchase.php" method="POST">
                            <input type="hidden" name="event_name" value="Golden Festival">
                            <input type="hidden" name="event_date" value="Sunday 06:00 PM to 09:00 PM">
                            <input type="hidden" name="venue" value="DY Patil Stadium, Navi Mumbai">
                            <input type="hidden" name="ticket_price" value="45">

                            <div class="quantity-content">
                                <div class="left-content">
                                    <h6>Standard Ticket</h6>
                                    <p>$45 per ticket</p>
                                </div>
                                <div class="right-content">
                                    <div class="quantity buttons_added">
                                        <input type="button" value="-" class="minus" onclick="decreaseQuantity()"><input type="number" step="1" min="1" max="10" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" oninput="validateQuantity()" id="ticketQuantity"><input type="button" value="+" class="plus" onclick="increaseQuantity()">
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="total">
                            <h4 id="totalPrice">Total: $45.00</h4>
                            <div class="main-dark-button" onclick="submitForm()"><a href="#">Purchase Tickets</a></div>
                        </div>
                        <div class="warn">
                            <p>*You Can Only Buy 10 Tickets For This Show</p>
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
    
    <script>
        /* Ticket Pricing */

        const ticketPrice = 45;

        function updateTotal() {
            const quantity = document.getElementById('ticketQuantity').value;
            const total = quantity * ticketPrice;
            document.getElementById('totalPrice').innerText = `Total: $${total.toFixed(2)}`;
        }

        function increaseQuantity() {
            const quantityInput = document.getElementById('ticketQuantity');
            let currentQuantity = parseInt(quantityInput.value);
            if (currentQuantity < 10) {
                quantityInput.value = currentQuantity + 1;
                updateTotal();
            }
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById('ticketQuantity');
            let currentQuantity = parseInt(quantityInput.value);
            if (currentQuantity > 1) {
                quantityInput.value = currentQuantity - 1;
                updateTotal();
            }
        }

        function validateQuantity() {
            const quantityInput = document.getElementById('ticketQuantity');
            let currentQuantity = parseInt(quantityInput.value);
            
            // Check for valid range (1 to 10)
            if (isNaN(currentQuantity) || currentQuantity < 1) {
                quantityInput.value = 1;
            } else if (currentQuantity > 10) {
                quantityInput.value = 10;
            }
            updateTotal();
        }
    </script>

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

  </body>

</html>
