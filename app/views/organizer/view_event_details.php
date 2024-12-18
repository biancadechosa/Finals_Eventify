<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h2><?= $e['title']; ?></h2>
            </div>
            <div class="card-body">
                <!-- Event Image -->
                <div class="mb-3">
                    <img src="<?= $details['images']; ?>" alt="Event Image" class="img-fluid" width="500">
                </div>

                <!-- Event Information -->
                <p><strong>Description:</strong> <?= $e['description']; ?></p>
                <p><strong>Location:</strong> <?= $e['location']; ?></p>
                <p><strong>Date:</strong> <?= $e['start_date']; ?> - <?= $e['end_date']; ?></p>
                <p><strong>Price:</strong> <?= $e['price_range']; ?></p>
                <p><strong>Popularity:</strong> <?= $e['popularity']; ?></p>
                <p><strong>Ratings:</strong> <?= $e['ratings']; ?></p>
                <p><strong>Type:</strong> <?= $e['type']; ?></p>

                <!-- New Fields from Event Table -->
                <p><strong>Created At:</strong> <?= $e['created_at']; ?></p>
                <p><strong>Updated At:</strong> <?= $e['updated_at']; ?></p>

                <!-- Event Venue Details -->
                <h4>Event Venue Details</h4>
                <p><strong>Venue Name:</strong> <?= $details['venue_name']; ?></p>
                <p><strong>Venue Address:</strong> <?= $details['venue_address']; ?></p>
                <p><strong>Seating Chart:</strong> <?= $details['seating_chart']; ?></p>
                <p><strong>Ticket Price:</strong> <?= $details['ticket_price']; ?></p>
                <p><strong>Available Seats:</strong> <?= $details['available_seats']; ?></p>
                <p><strong>Status:</strong> <?= $details['status']; ?></p>

                <a href="<?= site_url('/organizer/dashboard'); ?>" class="btn btn-primary">Back to Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
