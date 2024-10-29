<?php
require 'vendor/autoload.php'; // Include the PayPal SDK

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;

// PayPal API context setup (replace with your own credentials)
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AczTtUGXs9zEblnLHqq1h6roGpyeg8mUcje3XDxn78HkWPf8lgbshPHiWSuJAh5sHdhBt_WO6ZnWt1GR', // ClientID
        'EKyih4yB0fo5zSOW6BPlge7trMLssD9vIrlxB9mNYsXz8o-32ZWaXioPrIis47GzuLk4XdkODQpuspEQ' // ClientSecret
    )
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve ticket data from the form submission
    $eventName = $_POST['event_name'];
    $eventDate = $_POST['event_date'];
    $venue = $_POST['venue'];
    $ticketQuantity = $_POST['quantity'];
    $totalPrice = $_POST['total_price'];

    // Retrieve email from the session
    $email = $_SESSION['email'];

    // Create a new payer instance
    $payer = new Payer();
    $payer->setPaymentMethod("paypal");

    // Create item details
    $item = new Item();
    $item->setName($eventName . " Tickets") // Name of the event
        ->setCurrency('USD')
        ->setQuantity($ticketQuantity)
        ->setPrice($totalPrice / $ticketQuantity); // Price per ticket

    $itemList = new ItemList();
    $itemList->setItems(array($item));

    // Set payment details
    $amount = new Amount();
    $amount->setCurrency("USD")
        ->setTotal($totalPrice);

    $transaction = new Transaction();
    $transaction->setAmount($amount)
        ->setItemList($itemList)
        ->setDescription("Ticket Purchase for " . $eventName)
        ->setInvoiceNumber(uniqid()); // Generate unique invoice number

    // Set the redirect URLs
    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl("http://localhost/AJEvents/codes/payment-success.php")
        ->setCancelUrl("http://localhost/AJEvents/codes/payment-cancelled.php");

    // Create a payment instance
    $payment = new Payment();
    $payment->setIntent("sale")
        ->setPayer($payer)
        ->setRedirectUrls($redirectUrls)
        ->setTransactions(array($transaction));

    try {
        // Create the payment on PayPal
        $payment->create($apiContext);

        // Redirect the user to the PayPal approval URL
        header("Location: " . $payment->getApprovalLink());
        exit();
    } catch (PayPal\Exception\PayPalConnectionException $ex) {
        echo "Error: " . $ex->getData();
        exit();
    }
} else {
    // Redirect if accessed directly
    header("Location: confirm-purchase.php");
    exit();
}
?>