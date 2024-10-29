<?php
// Database configuration
$servername = "localhost"; // Change if not local
$username = "root"; // Database username (e.g., 'root')
$password = ""; // Database password (leave empty if none)
$dbname = "ajevents"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($Email, $v_code)
{
    require ("PHPMailer/PHPMailer.php");
    require ("PHPMailer/SMTP.php");
    require ("PHPMailer/Exception.php");

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'adityajoshi0524@gmail.com';                     //SMTP username
        $mail->Password   = 'nlcx mgbx lyvz dnmp';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('adityajoshi0524@gmail.com', 'AJEvents');
        $mail->addAddress($Email);     //Add a recipient
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email Verification for AJEvents Account';
        $mail->Body = "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style>
                body {
                    font-family: 'Roboto', sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #ffffff;
                    border: 1px solid #dddddd;
                    border-radius: 8px;
                    padding: 20px;
                }
                .header {
                    background-color: #848181;
                    color: #ffffff;
                    text-align: center;
                    padding: 10px 0;
                    border-radius: 8px 8px 0 0;
                }
                .header h1 {
                    margin: 0;
                }
                .content {
                    margin: 20px 0;
                    text-align: center;
                }
                .content h2 {
                    color: #333333;
                }
                .content p {
                    color: #555555;
                    font-size: 16px;
                    line-height: 1.5;
                }
                .verify-btn {
                    display: inline-block;
                    background-color: #333;
                    color: #ffffff !important;
                    text-decoration: none;
                    padding: 12px 0;
                    width: 150px;
                    border-radius: 5px;
                    font-size: 16px;
                    text-align: center;
                    line-height: 1.2;
                    font-weight: 600;
                }
                .verify-btn:hover {
                    background-color: #212529;
                }
                .footer {
                    margin-top: 30px;
                    font-size: 12px;
                    color: #888888;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Welcome to AJEvents</h1>
                </div>
                <div class='content'>
                    <h2>Thank you for registering!</h2>
                    <p>We are excited to have you on board. Please verify your email address by clicking the button below to activate your account.</p>
                    <a href='http://localhost/AJEvents/Codes/email_verification.php?email=$Email&v_code=$v_code' class='verify-btn'>Verify Email</a>
                </div>
                <div class='footer'>
                    <p>If you did not create an account, you can safely ignore this email.</p>
                </div>
            </div>
        </body>
        </html>";
            
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Handle signup
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['signup'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $v_code = bin2hex(random_bytes(16));
        $is_verified = '0';

        // Check if email already exists
        $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $checkEmail->store_result();

        if ($checkEmail->num_rows > 0) {
            echo "Email is already registered!";
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, verification_code, is_verified) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $password, $v_code, $is_verified);

            if ($stmt->execute() && sendMail($_POST['email'], $v_code)) {
                echo "Registration successful! A verification link has been sent to your email. Please check your inbox and verify your email address before logging in.";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $checkEmail->close();
    }

    // Handle login
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Fetch the user from the database
        $stmt = $conn->prepare("SELECT id, username, password, is_verified FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        // Check if any row was returned
        if ($stmt->num_rows > 0) {
            // Bind result variables
            $stmt->bind_result($id, $username, $hashedPassword, $is_verified);
            $stmt->fetch();  // Fetch the result
            
            // Verify password and check if the user is verified
            if (password_verify($password, $hashedPassword) && $is_verified == 1) {
                // Password is correct and the user is verified. Start a session and store user information
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                echo "Login successful!";
            } else {
                echo "Invalid password or the user is not verified.";
            }
        } else {
            // Handle the case where no user was found
            echo "No user found with this email.";
        }

        // Close statement
        $stmt->close();
    }
}

$conn->close();
?>