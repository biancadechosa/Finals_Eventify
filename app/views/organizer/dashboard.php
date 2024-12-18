<?php
include APP_DIR.'views/templates/header.php';
?>
<body>
    <div id="app">
    <?php
    include APP_DIR.'views/templates/nav.php';
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
            font-family: Arial, sans-serif;
            background-color: #f4f9ff;
        }

        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: -250px;
            background-color: #003060;
            padding-top: 20px;
            color: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease; 
        }

        .sidebar.visible {
            left: 0; 
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            border-bottom: 1px solid #d1d1d1;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #055c9d;
        }

        .sidebar .active {
            background-color: #0E86D4;
        }

        .sidebar-header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

         .hamburger {
            position: absolute;
            top: 15px;
            left: 15px;
            cursor: pointer;
            z-index: 1000;
            font-size: 25px;
            background-color: #003060;
            color: white;
            border: none;
            padding: 5px 8px;
            border-radius: 5px;
            opacity: 1;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .hamburger:hover {
            background-color: #055c9d;
        }
 
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background-color: #003060;
            transition: all 0.3s ease;
            padding-top: 40px;
            padding-left: 15px;
        }

        .sidebar.visible {
            left: 0; 
        }

        .sidebar.visible .hamburger {
            opacity: 0;
        }

        .container {
            margin-left: 250px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: margin-left 0.3s ease; 
        }

        .container.collapsed {
            margin-left: 80px;
        }

        h4 {
            color: #003060;
            font-weight: bold;
        }

        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .card-img-top {
            height: 180px;
            object-fit: cover;
        }

        .card-title {
            color: #003060;
            font-weight: bold;
        }

        .card-text {
            font-size: 14px;
            color: #055C9D;
        }

        .card-status {
            font-size: 14px;
            margin: 10px 0;
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
            background-color: #FFA500; 
        }

        .status-approved {
            background-color: #28A745;
        }

        .status-completed {
            background-color: #007BFF;
        }

        .status-rejected {
            background-color: #D72638; 
        }

        .btn {
            font-weight: bold;
            border-radius: 5px;
            text-transform: uppercase;
        }

        .btn-success {
            background-color: #055C9D;
            border: none;
        }

        .btn-success:hover {
            background-color: #0E86D4;
        }

        .btn-danger {
            background-color: #D72638;
            border: none;
        }

        .btn-danger:hover {
            background-color: #F46036;
        }

        .d-flex {
            gap: 10px;
        }

        .dropdown-toggle {
            background-color: white; 
            border: none; 
            color: transparent; 
            font-size: 20px; 
            cursor: pointer;
        }

        .dropdown-toggle::after {
            content: '...'; 
            color: #333; 
            font-size: 30px; 
        }

        .dropdown-menu {
            min-width: 180px;
        }

        .dropdown-menu a {
            color: #333;
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>

    <button class="hamburger" id="hamburger">☰</button>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <span>Organizer Dashboard</span>
        </div>
        <a href="<?= site_url('/organizer/dashboard'); ?>" id="events-link" class="active">Events</a>
        <a href="<?= site_url('/organizer/manage_booking'); ?>" id="booking-link">Manage Bookings</a>
    </div>

    <div class="container mt-3" id="content">
        <h4 class="mb-4">Events List</h4>
        <a class="btn btn-warning mb-4" role="button" href="<?= site_url('/organizer/create'); ?>">Create Event</a>

    
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
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href=<?=site_url('/organizer/update/' . $event['event_id']);?>>Update</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="confirmDelete(<?= $event['event_id']; ?>)">Delete</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <script>
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');

        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('visible');
        });
        function confirmDelete(eventId) {
    if (confirm("Are you sure you want to delete this event?")) {
        window.location.href = "<?= site_url('/organizer/delete/'); ?>" + eventId;
    }
}

    </script>

</body>
</html>
