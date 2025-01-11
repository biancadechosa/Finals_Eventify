<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification E-Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .receipt-container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        .notification {
            padding: 15px;
            border-bottom: 1px solid #ccc;
            margin-bottom: 15px;
        }

        .notification:last-child {
            border-bottom: none;
        }

        .notification h2 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .notification p {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }

        .receipt-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }

        .bold {
            font-weight: bold;
        }

/* Style for the "Back to My Bookings" button */
.btn-back {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    margin-top: 20px;
    border: none;
    cursor: pointer;
    text-align: center;
}

.btn-back:hover {
    background-color: #0056b3;
    text-decoration: none;
}

.btn-back i {
    margin-right: 8px;
}


    </style>
</head>
<body>
<?php include APP_DIR.'views/user/header.php'; ?>
<div class="receipt-container">
    <header class="receipt-header">
        
        <h1>Email Notification E-Receipt</h1>
        <p>Thank you for your booking. Below are the details of the email notifications sent.</p>
    </header>

    <?php if (!empty($notifications)): ?>
        <?php foreach ($notifications as $notification): ?>
            <div class="notification">
                <h2>Notification #<?php echo htmlspecialchars($notification['id']); ?></h2>
                <p><span class="bold">Recipient Email:</span> <?php echo htmlspecialchars($notification['recipient_email']); ?></p>
                <p><span class="bold">Subject:</span> <?php echo htmlspecialchars($notification['subject']); ?></p>
                <p><span class="bold">Message:</span> <?php echo nl2br(htmlspecialchars($notification['message'])); ?></p>
                <p><span class="bold">Ticket Number:</span> <?php echo htmlspecialchars($notification['ticket_number']); ?></p>
                <p><span class="bold">Quantity:</span> <?php echo htmlspecialchars($notification['ticket_quantity']); ?></p>
                <p><span class="bold">Price:</span> $<?php echo number_format($notification['ticket_price'], 2); ?></p>
                <p><span class="bold">Event Title:</span> <?php echo htmlspecialchars($notification['event_title']); ?></p>
                <p><span class="bold">Event Location:</span> <?php echo htmlspecialchars($notification['event_location']); ?></p>
                <p><span class="bold">Event Start Date:</span> <?php echo date('F j, Y', strtotime($notification['start_date'])); ?></p>
                <p><span class="bold">Event End Date:</span> <?php echo date('F j, Y', strtotime($notification['end_date'])); ?></p>
                <p><span class="bold">Sent At:</span> <?php echo date('F j, Y, g:i a', strtotime($notification['sent_at'])); ?></p>
                
            </div>



        <?php endforeach; ?>
    <?php else: ?>
        <p>No email notifications available.</p>
    <?php endif; ?>

    <footer class="receipt-footer">
        <p>&copy; <?php echo date('Y'); ?> Your Company. All Rights Reserved.</p>
    </footer>
</div>

</body>
</html>
