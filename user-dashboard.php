<?php
session_start();
require 'db-connection.php'; // Ensure you have the PDO connection here

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

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Retrieve the email of the logged-in user based on the username
    $stmt = $pdo->prepare("SELECT email FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $email = $user['email'];

        // Retrieve all the transactions for this user
        $stmt = $pdo->prepare("SELECT * FROM transactions WHERE email = :email AND payment_status = 'completed'");
        $stmt->execute([':email' => $email]);
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} else {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tickets Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f1;
            color: #fff;
        }

        /* Dashboard Layout */
        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background-color: #343a3e;
            padding: 20px;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar h2 {
            color: #fff;
            font-weight: 800;
            margin-bottom: 40px;
        }

        .sidebar nav ul {
            list-style: none;
        }

        .sidebar nav ul li {
            margin-bottom: 20px;
        }

        .sidebar nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .sidebar nav ul li a:hover {
            color: #f1c40f;
        }

        /* Main Content */
        .main-content {
            padding: 20px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #ddd;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 1.8rem;
            color: #333;
        }

        .header .profile {
            font-size: 1rem;
            color: #666;
        }

        /* Tickets List Section */
        .tickets-list {
            background-color: #343a3e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .tickets-list h2 {
            font-size: 1.6rem;
            margin-bottom: 20px;
        }

        .ticket {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            background-color: #f7f7f7;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .ticket-details {
            display: flex;
            flex-direction: column;
        }

        .ticket-details p {
            margin-bottom: 5px;
            font-size: 1rem;
        }

        .ticket-status {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 40px;
            border-radius: 50px;
            font-weight: bold;
            color: #fff;
            background-color: #27ae60;
        }

        .ticket-status.pending {
            background-color: #e67e22;
        }

        .ticket-status.cancelled {
            background-color: #e74c3c;
        }
        
        .ticket-ct {
        position: relative;
        width: 750px;
        height: 220px;
        background-image: radial-gradient(circle at top left, transparent 17px, #FFFFF0 17px), radial-gradient(circle at top right, transparent 17px, #FFFFF0 17px), radial-gradient(circle at bottom left, transparent 17px, #FFFFF0 17px), radial-gradient(circle at bottom right, transparent 17px, #FFFFF0 17px);
        background-size: 51% 51%;
        background-repeat: no-repeat;
        background-position: top left, top right, bottom left, bottom right;
        z-index: 1;
        margin-bottom: 20px;
        margin-left: 30px;
        }

        .ticket-ct:before, .ticket-ct:after {
        box-sizing: border-box;
        position: absolute;
        color: #2B292B;
        text-align: center;
        }

        .ticket-ct:before {
        content: '';
        font-family: 'Roboto', sans-serif;
        white-space: pre;
        font-size: 32px;
        font-weight: bold;
        line-height: 1;
        background-image: linear-gradient(45deg, transparent 75%, #FFFFF0 75%), linear-gradient(135deg, transparent 75%, #FFFFF0 75%), linear-gradient(-45deg, transparent 75%, #FFFFF0 75%), linear-gradient(-135deg, transparent 75%, #FFFFF0 75%);
        background-size: 8px 8px;
        background-repeat: repeat-y;
        background-position: 0 0, 0 0, 100% 0, 100% 0;
        width: 765px;
        height: 185px;
        left: -8px;
        top: 17px;
        padding-right: 20px;
        padding-top: 8px;
        }
            
        .ticket-ct:after {
        content: 'WI0001';
        font-family: monospace;
        font-size: 14px;
        line-height: 1;
        border: 2px solid #9E2B1F;
        width: 180px;
        height: 700px;
        transform: rotate(-90deg);
        padding-top: 670px;
        top: -240px;
        left: 285px;
        border-radius: 10px;
        background: linear-gradient(to bottom, transparent 658px, #9E2B1F 155px, #9E2B1F 660px, transparent 155px);
        }
        
        .ticket-details-ct {
        display: inline-block;
        margin-left: 40px;
        margin-top: 40px;
        text-align: left; 
        line-height: 21px;
        }
        
        .ticket-details-ct p, .ticket-details-ct h4 {
        margin: 5px 0;
        color: #2B292B;
        }

        .confirm-ticket { 
        position: absolute;
        top: 136px;
        right: 345px;
        box-shadow: 0 0 0 3px green, 0 0 0 2px green inset;  
        border: 2px solid transparent;
        border-radius: 4px;
        display: inline-block;
        padding: 5px 2px;
        line-height: 22px;
        color: green;
        font-size: 24px;
        font-family: 'Black Ops One', cursive;
        text-transform: uppercase;
        text-align: center;
        opacity: 0.4;
        width: 155px;
        transform: rotate(10deg) translate(250px, -90px);
        z-index: 1;
        }   

        .confirm-ticket::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 110px;
        height: 110px;
        background-color: transparent;
        border-radius: 50%;
        box-shadow: 0 0 0 3px green, 0 0 0 2px green inset;  /* Same border and shadow style */
        border: 2px solid transparent;
        transform: translate(-50%, -50%);
        z-index: -1; /* Place behind the square */
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 44px;
            left: 210px;
            font-size: 78px;
            color: rgba(0, 0, 0, 0.1);
            transform: rotate(-30deg);
            z-index: 0;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .overview {
                grid-template-columns: 1fr;
            }

            .dashboard {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: fixed;
                width: 100%;
                height: 100%;
                z-index: 1000;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                grid-column: span 2;
            }
        }
    </style>
</head>
<body>

<div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>Dashboard</h2>
        <nav>
            <ul>
                <li><a href="#">My Tickets</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="user-homepage.php">Home</a></li> 
                <li><a href="#">Help</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <section class="main-content">
        <div class="header">
            <h1>My Tickets</h1>
            <div class="profile">Hello,
                <?php 
                if (isset($_SESSION['username'])) {
                    echo $_SESSION['username'];
                } else {
                    echo "Guest";
                }
                ?>
            </div>
        </div>

        <!-- Tickets List -->
        <section class="tickets-list">
            <h2>Ticket Details</h2>

            <?php if (!empty($transactions)): ?>
                <?php foreach ($transactions as $transaction): ?>
                    <div class="ticket-ct">
                        <div class="watermark">AJEvents</div>
                        <div class="ticket-details-ct">
                            <p><strong>Event:</strong> <?php echo htmlspecialchars($transaction['event_name']); ?></p>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($transaction['event_date']); ?></p>
                            <p><strong>Venue:</strong> <?php echo htmlspecialchars($transaction['venue']); ?></p>
                            <p><strong>Ticket(s) for:</strong> <?php echo htmlspecialchars($transaction['quantity']); ?></p>
                            <p><strong>Total Price:</strong> $<?php echo htmlspecialchars($transaction['total_price']); ?></p>
                        </div>
                        <div class="confirm-ticket">
                            Confirmed
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No tickets purchased yet.</p>
            <?php endif; ?>

        </section>
    </section>
</div>

</body>
</html>