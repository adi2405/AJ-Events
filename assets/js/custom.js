(function ($) {
	
	"use strict";

	$('.owl-show-events').owlCarousel({
		items:4,
		loop:true,
		dots: true,
		nav: true,
		autoplay: true,
		margin:30,
		  responsive:{
			  0:{
				  items:1
			  },
			  600:{
				  items:2
			  },
			  1000:{
				  items:4
			  }
		  }
	  })

	const second = 1000,
      minute = second * 60,
      hour = minute * 60,
      day = hour * 24;

	let countDown = new Date('Oct 31, 2024 09:30:00').getTime(),
    x = setInterval(function() {    

      let now = new Date().getTime(),
          distance = countDown - now;

      document.getElementById('days').innerText = Math.floor(distance / (day)),
        document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
        document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
        document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);

      //do something later when date is reached
      //if (distance < 0) {
      //  clearInterval(x);
      //  'IT'S MY BIRTHDAY!;
      //}

    }, second)

	$(function() {
        $("#tabs").tabs();
    });
	

	$('.schedule-filter li').on('click', function() {
        var tsfilter = $(this).data('tsfilter');
        $('.schedule-filter li').removeClass('active');
        $(this).addClass('active');
        if (tsfilter == 'all') {
            $('.schedule-table').removeClass('filtering');
            $('.ts-item').removeClass('show');
        } else {
            $('.schedule-table').addClass('filtering');
        }
        $('.ts-item').each(function() {
            $(this).removeClass('show');
            if ($(this).data('tsmeta') == tsfilter) {
                $(this).addClass('show');
            }
        });
    });


	// Window Resize Mobile Menu Fix
	mobileNav();


	// Scroll animation init
	window.sr = new scrollReveal();
	

	// Menu Dropdown Toggle
	if($('.menu-trigger').length){
		$(".menu-trigger").on('click', function() {	
			$(this).toggleClass('active');
			$('.header-area .nav').slideToggle(200);
		});
	}


	// Page loading animation
	 $(window).on('load', function() {

        $('#js-preloader').addClass('loaded');

    });


	// Window Resize Mobile Menu Fix
	$(window).on('resize', function() {
		mobileNav();
	});


	// Window Resize Mobile Menu Fix
	function mobileNav() {
		var width = $(window).width();
		$('.submenu').on('click', function() {
			if(width < 767) {
				$('.submenu ul').removeClass('active');
				$(this).find('ul').toggleClass('active');
			}
		});
	}


})(window.jQuery);

$(document).ready(function() {
    // Login AJAX
    $("#loginForm").on("submit", function(event) {
        event.preventDefault(); // Prevent form submission from refreshing the page
        $.ajax({
            type: "POST",
            url: "auth.php", // This is where your PHP authentication script is located
            data: $(this).serialize() + "&login=true", // Serialize form data and append login action
            success: function(response) {
                alert(response); // Display response message
                if (response.includes("successful")) {
                    window.location.href = "user-homepage.php"; // Redirect to dashboard on successful login
                }
            },
            error: function() {
                alert("There was an error processing your request. Please try again.");
            }
        });
    });

    // Signup AJAX
    $("#signupForm").on("submit", function(event) {
        event.preventDefault(); // Prevent form submission from refreshing the page
        $.ajax({
            type: "POST",
            url: "auth.php", // This is where your PHP authentication script is located
            data: $(this).serialize() + "&signup=true", // Serialize form data and append signup action
            success: function(response) {
                alert(response); // Display response message
            },
            error: function() {
                alert("There was an error processing your request. Please try again.");
            }
        });
    });
});

/* Logout */
function logout() {
    var confirmation = confirm("Are you sure you want to logout?");
    if (confirmation) {
        window.location.href = "logout.php";
    }
}

/* Login Alert */
function loginAlert() {
    // Display confirmation dialog
    var result = confirm("Please login to purchase your ticket.");
    
    if (result) {
        var modal = document.getElementById("authModal");
        modal.style.display = "block";
    }
}

/* Purchase Ticket */
    function submitForm() {
        document.getElementById('ticketForm').submit();
    }