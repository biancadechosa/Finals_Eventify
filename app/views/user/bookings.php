<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f0f8ff, #d6e4f0);
            font-family: 'Arial', sans-serif;
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding: 2rem;
        }

        .card {
            flex: 1;
            max-width: 48%; 
            margin-right: 2%;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            background-color: #ffffff;
        }

        .card-title {
            font-size: 2rem;
            font-weight: bold;
            color: #0056b3;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: #333333;
        }

        .form-control {
            padding: 0.8rem;
            font-size: 1rem;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .form-control:focus {
            border-color: #0056b3;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.3);
        }

        .btn-primary {
            width: 100%;
            padding: 0.8rem;
            font-size: 1.1rem;
            font-weight: bold;
            background-color: #0056b3;
            border: none;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #004494;
        }

        .form-check-label {
            font-weight: 500;
            color: #555555;
        }

        .form-check-input {
            margin-left: 10px;
        }

        .reminder-info {
            font-size: 0.9rem;
            color: #888888;
            margin-top: -10px;
        }

        .card-body {
            padding: 2rem;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9rem;
            color: #555555;
        }

        .ticket-section {
            flex: 1;
            max-width: 45%;
            margin-left: 2%;
            padding: 1.5rem;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .ticket-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #0056b3;
        }

        .ticket-description {
            margin-top: 10px;
            color: #555555;
        }

        .copy-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
        }

        .copy-btn:hover {
            background-color: #218838;
        }
        
        .container {
            padding: 3rem 5%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Event Booking</h5>
                <form action="<?= site_url('/user/create_booking/' . segment(4)); ?>" method="POST">
                <?php flash_alert(); ?>
                    <div class="form-group">
                    <label for="user_email" class="form-label">Email:</label>
                        <input 
                            type="email" 
                            id="user_email" 
                            name="user_email" 
                            class="form-control" 
                            value="<?= isset($user['email']) ? $user['email'] : ''; ?>" 
                        required
                        >
                        <label for="booking_date" class="form-label">Select Booking Date:</label>
                        <input 
                            type="datetime-local" 
                            id="booking_date" 
                            name="booking_date" 
                            class="form-control" 
                            min="<?= date('Y-m-d\TH:i', strtotime($event['start_date'])); ?>" 
                            max="<?= date('Y-m-d\TH:i', strtotime($event['end_date'])); ?>" 
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="ticket_quantity" class="form-label">Number of Tickets:</label>
                        <input 
                            type="number" 
                            id="ticket_quantity" 
                            name="ticket_quantity" 
                            class="form-control" 
                            min="1" 
                            required
                        >
                    </div>

                    <div class="form-check mb-3">
                        <input 
                            type="checkbox" 
                            class="form-check-input" 
                            id="reminder_set" 
                            name="reminder_set"
                        >
                        <label for="reminder_set" class="form-check-label">Set Reminder</label>
                        <p class="reminder-info">Optional: Enable if you want to receive a reminder.</p>
                    </div>

                    <div class="form-group">
                        <label for="reminder_date" class="form-label">Reminder Date:</label>
                        <input 
                            type="datetime-local" 
                            id="reminder_date" 
                            name="reminder_date" 
                            class="form-control" 
                            min="<?= date('Y-m-d\TH:i', strtotime($event['start_date'])); ?>" 
                            max="<?= date('Y-m-d\TH:i', strtotime($event['end_date'])); ?>" 
                            disabled
                        >
                    </div>

                    <button type="submit" class="btn btn-primary">Book Now</button>
                </form>
            </div>
        </div>

        <!-- Ticket Number Display -->
        <div class="ticket-section">
            <div class="ticket-number">
                <?php if (isset($ticket_number)) : ?>
                    Your ticket number is: <?= $ticket_number; ?>
                <?php else : ?>
                    Your ticket number will appear here after booking.
                <?php endif; ?>
            </div>
            <div class="ticket-description">
                Please keep this ticket number for your reference. You can use it to manage your booking.
            </div>
            <?php if (isset($ticket_number)) : ?>
                <button class="copy-btn" onclick="copyTicketNumber()">Copy Ticket Number</button>
            <?php endif; ?>
        </div>
    </div>

    <footer>&copy; 2024 Event Booking. All rights reserved.</footer>

    <script>
    $(document).ready(function () {
        $('#reminder_set').on('change', function () {
            if ($(this).is(':checked')) {
                $('#reminder_date').prop('disabled', false);
            } else {
                $('#reminder_date').val(''); // Clear the value
                $('#reminder_date').prop('disabled', true);
            }
        });

        // Form validation before submission
        $('form').on('submit', function (e) {
            const reminderSet = $('#reminder_set').is(':checked');
            const reminderDate = $('#reminder_date').val();
        });
    });

    function copyTicketNumber() {
        var ticketNumber = document.querySelector('.ticket-number').textContent.replace('Your ticket number is: ', '');
        var tempInput = document.createElement('input');
        tempInput.value = ticketNumber;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        alert('Ticket number copied to clipboard!');
    }
</script>

</body>
</html>
