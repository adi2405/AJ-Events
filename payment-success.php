<?php
// Start the session
session_start();

require 'vendor/autoload.php';

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

// PayPal API context
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        "AczTtUGXs9zEblnLHqq1h6roGpyeg8mUcje3XDxn78HkWPf8lgbshPHiWSuJAh5sHdhBt_WO6ZnWt1GR", 
        "EKyih4yB0fo5zSOW6BPlge7trMLssD9vIrlxB9mNYsXz8o-32ZWaXioPrIis47GzuLk4XdkODQpuspEQ"
    )
);

// Database connection
$host = 'localhost'; // Replace with your DB host
$db = 'ajevents'; // Replace with your DB name
$user = 'root'; // Replace with your DB user
$pass = ''; // Replace with your DB password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

// Check if payment ID and Payer ID are present
if (isset($_GET['paymentId']) && isset($_GET['PayerID'])) {
    $paymentId = $_GET['paymentId'];
    $payerId = $_GET['PayerID'];

    // Execute the payment
    $payment = Payment::get($paymentId, $apiContext);
    $execution = new PaymentExecution();
    $execution->setPayerId($payerId);

    try {
        // Execute the payment
        $result = $payment->execute($execution, $apiContext);

        // Retrieve event details from session
        if (isset($_SESSION['email'], $_SESSION['event_name'], $_SESSION['event_date'], $_SESSION['venue'], $_SESSION['quantity'], $_SESSION['total_price'])) {
            $email = $_SESSION['email'];
            $eventName = $_SESSION['event_name'];
            $eventDate = $_SESSION['event_date'];
            $venue = $_SESSION['venue'];
            $ticketQuantity = $_SESSION['quantity'];
            $totalPrice = $_SESSION['total_price'];

            // Set the payment status
            $paymentStatus = 'completed';

            // Check if this transaction already exists
            $checkStmt = $pdo->prepare("SELECT * FROM transactions WHERE payment_id = :payment_id AND payer_id = :payer_id");
            $checkStmt->execute([
                ':payment_id' => $paymentId,
                ':payer_id' => $payerId
            ]);

            if ($checkStmt->rowCount() > 0) {
                echo "This transaction has already been recorded.";
                exit();
            }

            // Insert transaction details into the database
            $stmt = $pdo->prepare(
                "INSERT INTO transactions (email, event_name, event_date, venue, quantity, total_price, payment_status, payment_id, payer_id) 
                VALUES (:email, :event_name, :event_date, :venue, :quantity, :total_price, :payment_status, :payment_id, :payer_id)"
            );
            
            $stmt->execute([
                ':email' => $email,
                ':event_name' => $eventName,
                ':event_date' => $eventDate,
                ':venue' => $venue,
                ':quantity' => $ticketQuantity,
                ':total_price' => $totalPrice,
                ':payment_status' => $paymentStatus,
                ':payment_id' => $paymentId,
                ':payer_id' => $payerId
            ]);

            // Clear session data after successful insertion
            unset($_SESSION['email']);
            unset($_SESSION['event_name']);
            unset($_SESSION['event_date']);
            unset($_SESSION['venue']);
            unset($_SESSION['quantity']);
            unset($_SESSION['total_price']);

            // Payment success, display success message or redirect to a success page
            echo "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Payment Confirmation</title>
                <style>
                    body {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        background-color: #f7f8fa;
                        font-family: Arial, sans-serif;
                    }
                    .confirmation {
                        text-align: center;
                        background-color: white;
                        padding: 40px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        border-radius: 10px;
                    }
                    .confirmation .checkmark-container {
                        width: 100px;
                        height: 100px;
                        border-radius: 50%;
                        background-color: #4CAF50;
                        position: relative;
                        margin: 0 auto 20px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        animation: bounce 1s ease-in-out;
                    }
                    .confirmation .checkmark {
                        color: white;
                        font-size: 50px;
                        font-weight: bold;
                    }
                    .confirm-payment-container {
                        display: inline-block;
                    }
                    @keyframes bounce {
                        0% {
                            transform: scale(0.5);
                        }
                        50% {
                            transform: scale(1.2);
                        }
                        100% {
                            transform: scale(1);
                        }
                    }
                    h2 {
                        color: #333;
                    }
                    p {
                        color: #666;
                    }
                    #redirect-msg {
                        margin-top: 20px;
                    }
                </style>
                <script>
                    // Redirect after 5 seconds
                    let counter = 5;
                    const interval = setInterval(() => {
                        document.getElementById('counter').innerText = counter;
                        counter--;
                        if (counter < 0) {
                            clearInterval(interval);
                            window.location.href = 'user-dashboard.php';
                        }
                    }, 1000);
                </script>
            </head>
            <body>
                <div class='confirmation'>
                    <div class='checkmark-container'>
                        <div class='checkmark'>✔</div>
                    </div>
                    <h2>Payment Successful!</h2>
                    <!-- Display event details -->
                    <div class='confirm-payment-container'>
                        <p><strong>Event:</strong> " . htmlspecialchars($eventName) . "</p>
                        <p><strong>Date:</strong> " . htmlspecialchars($eventDate) . "</p>
                        <p><strong>Venue:</strong> " . htmlspecialchars($venue) . "</p>
                        <p><strong>Ticket Quantity:</strong> " . htmlspecialchars($ticketQuantity) . "</p>
                        <p><strong>Total Price:</strong> $" . number_format($totalPrice, 2) . "</p>
                    </div>
                </div>
                <p id='redirect-msg'>Redirecting to your dashboard in <span id='counter'>5</span> seconds...</p>
                <p>If not redirected, <a href='user-dashboard.php'>click here</a>.</p>
            </body>
            </html>
            ";
        } else {
            echo "Error: Required session data not found.";
        }

    } catch (Exception $ex) {
        echo "Error executing payment: " . $ex->getMessage();
        exit();
    }
} else {
    echo "Payment failed or cancelled.";
}
?>