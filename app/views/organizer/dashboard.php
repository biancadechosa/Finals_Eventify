<?php
include APP_DIR . 'views/templates/header.php';
?>
<body>
    <div id="app">
        <?php
        include APP_DIR . 'views/templates/nav.php';
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 

    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f8f9fc;
            color: #333;
        }

        .sidebar {
    height: 100%;
    width: 250px;
    position: fixed;
    top: 0;
    left: -250px;
    background-color: #004080;
    color: white;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
    z-index: 1000;
}

.sidebar.visible {
    left: 0;
}

.sidebar-header {
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 30px;
    color: #f8f9fc;
    position: relative;
    top: 60px;
}

.sidebar-content {
    position: relative;
    top: 40px; /* Move the content down without affecting the space above */
}

.sidebar a {
    padding: 15px 20px;
    text-decoration: none;
    font-size: 18px;
    color: white;
    display: block;
    transition: background-color 0.3s ease;
}

.sidebar a:hover {
    background-color: #055c9d;
}

.sidebar .active {
    background-color: #0e86d4;
}


        .hamburger {
            position: absolute;
            top: 15px;
            left: 15px;
            font-size: 25px;
            background-color: #004080;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            z-index: 1100;
        }

        .hamburger:hover {
            background-color: #055c9d;
        }

        .container {
    max-width: 1200px; /* Increased width to make it wider */
    margin: 0 auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: margin-left 0.3s ease;
}

        h4 {
            color: #004080;
            font-weight: bold;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 180px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-title {
            color: #004080;
            font-weight: bold;
        }

        .btn {
            font-weight: bold;
            border-radius: 5px;
            text-transform: uppercase;
        }

        .btn-warning {
            background-color: #ffa500;
            border: none;
        }

        .btn-warning:hover {
            background-color: #ffb732;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            color: #fff;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #ffa500;
        }

        .status-approved {
            background-color: #28a745;
        }

        .status-completed {
            background-color: #007bff;
        }

        .status-rejected {
            background-color: #dc3545;
        }

        .dropdown-menu {
            min-width: 200px;
        }

        .dropdown-menu a {
            color: #333;
        }

        .dropdown-menu a:hover {
            background-color: #f8f9fa;
        }

        .hero {
    background-color: #004080; /* Dark blue background */
    color: white;
    text-align: center;
    padding: 80px 20px;
    border-radius: 10px;
    margin-bottom: 30px; /* Space between hero and other content */
    max-width: 1200px; /* Slightly wider than before */
    margin-left: auto;
    margin-right: auto; /* Center the hero section */
}

.hero h1 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 15px;
}

.hero p {
    font-size: 1.2rem;
    margin-bottom: 20px;
}

    </style>
</head>

<body>
    <button class="hamburger" id="hamburger">☰</button>
    <div class="sidebar" id="sidebar">
    <div class="sidebar-header">Organizer Dashboard</div>
    <div class="sidebar-content">
        <a href="<?= site_url('/organizer/dashboard'); ?>" class="active">Events</a>
        <a href="<?= site_url('/organizer/manage_booking'); ?>">Manage Bookings</a>
    </div>
</div>

    <section class="hero">
    <h1>Welcome, Organizer!</h1>
    <p>Manage your events and discover new opportunities to engage with your community.</p>
</section>


    <div class="container mt-4" id="content-container">
        <h4>Events List</h4>
        
        <?php if (empty($e)): ?>
            <p>No events created yet. Please create an event to get started.</p>
            <a class="btn btn-warning mb-4" href="<?= site_url('/organizer/create'); ?>">Create Event</a>
        <?php else: ?>
            <a class="btn btn-warning mb-4" href="<?= site_url('/organizer/create'); ?>">Create Event</a>
            <div class="row">
                <?php foreach ($e as $event): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= !empty($event['images']) ? $event['images'] : '/public/images/flowers.png'; ?>" alt="Event Image" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?= $event['title']; ?></h5>
                            <p class="card-text"><?= substr($event['description'], 0, 100); ?>...</p>
                            <p class="card-text">
                                <strong>Location:</strong> <?= $event['location']; ?><br>
                                <strong>Date:</strong> <?= $event['start_date']; ?> - <?= $event['end_date']; ?><br>
                                <strong>Price:</strong> <?= $event['ticket_price']; ?>
                            </p>
                            <p class="card-status">
                                <strong>Status:</strong>
                                <span class="status-badge status-<?= strtolower($event['status']); ?>">
                                    <?= $event['status']; ?>
                                </span>
                            </p>
                            <div class="d-flex justify-content-between">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= site_url('/organizer/update/' . $event['event_id']); ?>">Update</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="confirmDelete(<?= $event['event_id']; ?>)">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const hamburger = document.getElementById('hamburger');
        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('visible');
        });

        function confirmDelete(eventId) {
            if (confirm('Are you sure you want to delete this event?')) {
                window.location.href = '<?= site_url("/organizer/delete/"); ?>' + eventId;
            }
        }
    </script>
</body>
</html>
