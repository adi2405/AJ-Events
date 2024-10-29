<?php
session_start();
include 'db-connection.php';

// Check if the user is logged in and the email is available in the session
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page if not logged in
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username']; // Get the username from session

// Fetch the user's email based on the username
$stmt = $pdo->prepare("SELECT email FROM users WHERE username = :username");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && isset($user['email'])) {
    $email = $user['email']; // Get the email from the database result
} else {
    echo "User email not found!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the ticket details from the form submission
    $eventName = $_POST['event_name'];
    $eventDate = $_POST['event_date'];
    $venue = $_POST['venue'];
    $ticketQuantity = $_POST['quantity'];
    $ticketPrice = $_POST['ticket_price'];
    $totalPrice = $ticketQuantity * $ticketPrice;

    // Store details in session for future access
    $_SESSION['email'] = $email;
    $_SESSION['event_name'] = $eventName;
    $_SESSION['event_date'] = $eventDate;
    $_SESSION['venue'] = $venue;
    $_SESSION['quantity'] = $ticketQuantity;
    $_SESSION['total_price'] = $totalPrice;
} else {
    // Redirect if accessed directly
    header("Location: user-tickets.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Ticket Purchase</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .ticket-container {
            background: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 10px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            position: relative;
            clip-path: path('M 0 0 H 100% V calc(100% - 30px) Q calc(100% - 15px) 100% calc(100% - 30px) calc(100% - 30px) H 30px Q 15px calc(100% - 30px) 0 calc(100% - 30px) Z');
        }
        .ticket-image {
            max-width: 560px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 320px;  
            border-radius: 10px;
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .ticket-header h2 {
            font-size: 24px;
            font-weight: bold;
        }
        .ticket-details {
            margin-bottom: 20px;
            margin-top: 20px;
            padding-left: 62px;
        }
        .ticket-details p {
            font-size: 16px;
            line-height: 1.5;
            margin: 0 0 10px;
        }
        .ticket-details h4 {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }
        .ticket-footer {
            text-align: center;
        }
        .main-dark-button {
            background-color: #343a40;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .main-dark-button:hover {
            background-color: #23272b;
        }
        .perforation {
            height: 2px;
            width: 569px;
            right: 5px;
            background-color: #dddddd;
            margin: 20px 0;
            position: relative;
        }
        .perforation:before, .perforation:after {
            content: "";
            display: block;
            position: absolute;
            top: -12px;
            width: 20px;
            height: 20px;
            background-color: #f8f9fa;
            border-radius: 50%;
            z-index: 1;
        }
        .perforation:before {
            left: -25px;
        }
        .perforation:after {
            right: -25px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="ticket-container">
            <div class="ticket-header">
                <h2>Confirm Your Purchase</h2>
            </div>
            <div class="ticket-image">
                <!-- Placeholder for the event ticket image -->
                <img src="assets/images/ticket-details.jpg" alt="Event Ticket" class="ticket-image">
            </div>
            <div class="ticket-details">
                <p><strong>Event:</strong> <?php echo $eventName; ?></p>
                <p><strong>Date:</strong> <?php echo $eventDate; ?></p>
                <p><strong>Venue:</strong> <?php echo $venue; ?></p>
                <p><strong>Tickets:</strong> <?php echo $ticketQuantity; ?></p>
                <p><strong>Price per Ticket:</strong> $<?php echo number_format($ticketPrice, 2); ?></p>
                <h4><strong>Total Price:</strong> $<?php echo number_format($totalPrice, 2); ?></h4>
            </div>
            
            <!-- Perforation line -->
            <div class="perforation"></div>
            
            <div class="ticket-footer">
                <form action="process-payment.php" method="POST">
                    <input type="hidden" name="event_name" value="<?php echo $eventName; ?>">
                    <input type="hidden" name="event_date" value="<?php echo $eventDate; ?>">
                    <input type="hidden" name="venue" value="<?php echo $venue; ?>">
                    <input type="hidden" name="quantity" value="<?php echo $ticketQuantity; ?>">
                    <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
                    <button type="submit" class="main-dark-button">Confirm and Proceed to Payment</button>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-2.1.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>