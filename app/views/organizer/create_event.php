<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Style for the card to make it smaller */
        .card {
            width: 100%;
            max-width: 400px; /* Set a max-width to make the card smaller */
            margin: 0 auto; /* Center the card */
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #4e73df, #1e3d7d); /* Blue Gradient */
            color: #fff; /* Make text white to contrast with the blue gradient */
        }

        /* Make image responsive and adjust size */
        .card img {
            width: 100%;
            height: 200px; /* Set a fixed height for the image */
            object-fit: cover; /* Crop the image to fill the card */
        }

        .card-body {
            padding: 1rem; /* Reduce padding for a more compact layout */
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #fff; /* Set the title text color to white */
        }

        .card-text {
            font-size: 1rem;
            color: #f1f1f1; /* Light color for text */
        }

        .card-text strong {
            color: #fff; /* Set strong text to white */
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .col-md-6 {
                width: 100%;
                margin-bottom: 1.5rem;
            }

            .card img {
                height: 180px; /* Adjust image height on smaller screens */
            }
        }
    </style>
</head>
<body>
    <div class="container mt-3">
        <h2>Create Event</h2>
        <?php flash_alert(); ?>

        <!-- Two-Column Layout -->
        <div class="row">
            <!-- Left Column: Form -->
            <div class="col-md-6">
                <form id="createEventForm">
                    <div class="mb-3 mt-3">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                        <small class="text-danger" id="titleError"></small>
                    </div>
                    <div class="mb-3">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="location">Location:</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_date">Start Date:</label>
                        <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date">End Date:</label>
                        <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="ticket_price">Ticket Price:</label>
                        <input type="number" class="form-control" id="ticket_price" name="ticket_price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="popularity">Popularity:</label>
                        <input type="number" class="form-control" id="popularity" name="popularity">
                    </div>
                    <div class="mb-3">
                        <label for="ratings">Ratings:</label>
                        <input type="number" class="form-control" id="ratings" name="ratings" step="0.1" max="5">
                    </div>
                    <div class="mb-3">
                        <label for="type">Type:</label>
                        <input type="text" class="form-control" id="type" name="type">
                    </div>
                    <div class="mb-3">
                        <label for="images">Images:</label>
                        <input type="file" class="form-control" id="images" name="images">
                    </div>

                    <button type="submit" class="btn btn-warning">Create</button>
                    <a class="btn btn-success mb-0.5" role="button" href="<?= site_url('/organizer/dashboard'); ?>">Show Events</a>
                </form>
            </div>

            <!-- Right Column: Real-Time Preview -->
            <div class="col-md-6">
                <h4>Event Preview</h4>
                <div class="card">
                    <img id="previewImage" src="/public/images/flowers.png" class="card-img-top" alt="Event Image">
                    <div class="card-body">
                        <h5 class="card-title" id="previewTitle">Event Title</h5>
                        <p class="card-text" id="previewDescription">Event Description</p>
                        <p class="card-text">
                            <strong>Location:</strong> <span id="previewLocation">Event Location</span><br>
                            <strong>Date:</strong> <span id="previewStartDate">Start Date</span> - 
                            <span id="previewEndDate">End Date</span><br>
                            <strong>Price:</strong> <span id="previewPrice">Price</span>
                        </p>
                        <p class="card-text">
                            <strong>Ratings:</strong> <span id="previewRatings">Ratings</span><br>
                            <strong>Type:</strong> <span id="previewType">Event Type</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Real-Time Preview
            $('#title').on('input', function () {
                $('#previewTitle').text($(this).val());
            });
            $('#description').on('input', function () {
                $('#previewDescription').text($(this).val());
            });
            $('#location').on('input', function () {
                $('#previewLocation').text($(this).val());
            });
            $('#start_date').on('input', function () {
                $('#previewStartDate').text($(this).val());
            });
            $('#end_date').on('input', function () {
                $('#previewEndDate').text($(this).val());
            });
            $('#ticket_price').on('input', function () {
                $('#previewPrice').text($(this).val());
            });
            $('#ratings').on('input', function () {
                $('#previewRatings').text($(this).val());
            });
            $('#type').on('input', function () {
                $('#previewType').text($(this).val());
            });

            // Change Image Preview when file is selected
            $('#images').on('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        $('#previewImage').attr('src', event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // AJAX Form Submission
            $('#createEventForm').on('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this); // Use FormData for file upload
                $.ajax({
                    url: '<?= site_url('/organizer/create'); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        alert('Event created successfully!');
                        window.location.href = '<?= site_url('/organizer/dashboard'); ?>';
                    },
                    error: function () {
                        alert('Failed to create the event.');
                    }
                });
            });
        });
    </script>
</body>
</html>
