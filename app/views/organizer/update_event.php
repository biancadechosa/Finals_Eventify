<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .card {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #4e73df, #1e3d7d);
            color: #fff;
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .col-md-6 {
                width: 100%;
                margin-bottom: 1.5rem;
            }

            .card img {
                height: 180px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-3">
        <h2>Update Event</h2>
        <?php flash_alert(); ?>

        <div class="row">
            <div class="col-md-6">
                <form id="updateEventForm" enctype="multipart/form-data">
                    <div class="mb-3 mt-3">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $e['title']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" id="description" name="description" value="<?= $e['description']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="location">Location:</label>
                        <input type="text" class="form-control" id="location" name="location" value="<?= $e['location']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_date">Start Date:</label>
                        <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="<?= $e['start_date']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date">End Date:</label>
                        <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="<?= $e['end_date']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ticket_price">Ticket Price:</label>
                        <input type="text" class="form-control" id="ticket_price" name="ticket_price" value="<?= $e['ticket_price']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="popularity">Popularity:</label>
                        <input type="number" class="form-control" id="popularity" name="popularity" value="<?= $e['popularity']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="ratings">Ratings:</label>
                        <input type="number" class="form-control" id="ratings" name="ratings" step="0.1" max="5" value="<?= $e['ratings']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="type">Type:</label>
                        <input type="text" class="form-control" id="type" name="type" value="<?= $e['type']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="images">Images:</label>
                        <input type="file" class="form-control" id="images" name="images">
                    </div>
                    <button type="submit" class="btn btn-warning">Update</button>
                    <a class="btn btn-success mb-0.5" role="button" href="<?= site_url('/organizer/dashboard'); ?>">Show Events</a>
                </form>
            </div>

            <div class="col-md-6">
                <h4>Event Preview</h4>
                <div class="card">
                    <img id="previewImage" src="<?= isset($e['images']) && !empty($e['images']) ? $e['images'] : '/public/images/flowers.png'; ?>" class="card-img-top" alt="Event Image">
                    <div class="card-body">
                        <h5 class="card-title" id="previewTitle"><?= $e['title']; ?></h5>
                        <p class="card-text" id="previewDescription"><?= $e['description']; ?></p>
                        <p class="card-text">
                            <strong>Location:</strong> <span id="previewLocation"><?= $e['location']; ?></span><br>
                            <strong>Date:</strong> <span id="previewStartDate"><?= $e['start_date']; ?></span> - <span id="previewEndDate"><?= $e['end_date']; ?></span><br>
                            <strong>Price:</strong> <span id="previewPrice"><?= $e['ticket_price']; ?></span>
                        </p>
                        <p class="card-text">
                            <strong>Ratings:</strong> <span id="previewRatings"><?= $e['ratings']; ?></span><br>
                            <strong>Type:</strong> <span id="previewType"><?= $e['type']; ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#title').on('input', function () {
                $('#previewTitle').text($(this).val());
            });

            $('#description').on('input', function () {
                $('#previewDescription').text($(this).val());
            });

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

            // Submit the form via AJAX
            $('#updateEventForm').on('submit', function (e) {
                e.preventDefault();

                // Use FormData for file upload
                const formData = new FormData(this);

                $.ajax({
                    url: '<?= site_url('/organizer/update/' . $e['event_id']); ?>',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        alert('Event updated successfully!');
                        window.location.href = '<?= site_url('/organizer/dashboard'); ?>';
                    },
                    error: function () {
                        alert('Failed to update the event.');
                    }
                });
            });
        });
    </script>
</body>
</html>
