// Get the modal
var modal = document.getElementById("authModal");

// Get the button that opens the modal
var authBtn = document.getElementById("authBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
authBtn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// Function to switch between login and signup tabs
function openForm(evt, formName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(formName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Open the login form by default
document.getElementById("Login").style.display = "block";
document.getElementsByClassName("tablinks")[0].className += " active";

function togglePassword(inputId, icon) {
  const passwordInput = document.getElementById(inputId);
  const type = passwordInput.type === 'password' ? 'text' : 'password';
  passwordInput.type = type;

  // Toggle eye icon (optional: switch between open and closed eye icon)
  icon.classList.toggle('fa-eye-slash');
  icon.classList.toggle('fa-eye');
}