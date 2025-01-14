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
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <style>
body {
    background: linear-gradient(135deg, #e0f7fa, #ffffff);
    font-family: Arial, sans-serif;
    font-size: 14px; /* Reduced font size slightly */
}

.card {
    margin-top: 15px; /* Reduced margin */
    border: none;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1); /* Slightly reduced shadow */
    border-radius: 8px; /* Reduced border radius */
}

.card-header {
    font-weight: bold;
    color: #fff;
    border-radius: 8px 8px 0 0; /* Adjusted to match the new card radius */
    padding: 12px; /* Reduced padding */
    font-size: 14px; /* Reduced font size */
}

.header-pending {
    background: #03a9f4;
}

.header-approved {
    background: #4caf50;
}

.header-rejected {
    background: #f44336;
}

table.dataTable {
    width: 100% !important;
    table-layout: fixed; /* Make the table responsive */
}

table.dataTable tbody tr:hover {
    background: #f1f1f1;
}

table.dataTable thead {
    background: #f9f9f9;
    border-bottom: 2px solid #ccc;
}

table.dataTable thead th {
    font-weight: bold;
    padding: 6px; /* Reduced padding */
    font-size: 13px; /* Reduced font size */
}

td {
    padding: 4px; /* Reduced padding */
    font-size: 13px; /* Reduced font size */
    word-wrap: break-word;
}

.btn-approve {
    background: #4caf50;
    color: #fff;
    border: none;
    font-size: 12px; /* Reduced button text size */
    padding: 6px 12px; /* Reduced padding */
}

.btn-approve:hover {
    background: #388e3c;
}

.btn-reject {
    background: #f44336;
    color: #fff;
    border: none;
    font-size: 12px; /* Reduced button text size */
    padding: 6px 12px; /* Reduced padding */
}

.btn-reject:hover {
    background: #d32f2f;
}

.table-wrapper {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.event-img {
    width: 100%;
    height: 150px; /* Reduced height */
    object-fit: cover;
    border-radius: 8px; /* Adjusted to match card radius */
}

.sidebar {
    height: 100%;
    width: 200px; /* Reduced width */
    position: fixed;
    top: 0;
    left: -200px; /* Adjusted for smaller sidebar */
    background-color: #003060;
    padding-top: 15px; /* Reduced padding */
    color: white;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1); /* Reduced shadow */
    transition: all 0.3s ease;
}

.sidebar.visible {
    left: 0;
}

.sidebar a {
    padding: 8px 12px; /* Reduced padding */
    text-decoration: none;
    font-size: 14px; /* Reduced font size */
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
    font-size: 20px; /* Reduced font size */
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px; /* Reduced margin */
}

.hamburger {
    position: absolute;
    top: 10px; /* Adjusted for smaller layout */
    left: 10px; /* Adjusted for smaller layout */
    cursor: pointer;
    z-index: 1000;
    font-size: 20px; /* Reduced size */
    background-color: #003060;
    color: white;
    border: none;
    padding: 4px 6px; /* Reduced padding */
    border-radius: 5px;
    opacity: 1;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.hamburger:hover {
    background-color: #055c9d;
}

.container {
    margin-left: 200px; /* Adjusted for smaller sidebar */
    padding: 15px; /* Reduced padding */
    background-color: #ffffff;
    border-radius: 8px; /* Adjusted to match smaller design */
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1); /* Reduced shadow */
    transition: margin-left 0.3s ease;
    font-size: 14px; /* Adjusted font size */
}

.container.collapsed {
    margin-left: 70px; /* Adjusted for smaller layout */
}

</style>

</head>
<body>
<button class="hamburger" id="hamburger">☰</button>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <span>Admin Dashboard</span>
    </div>
    <a href="<?= site_url('/admin/dashboard'); ?>" id="events-link" class="active">Events</a>
    <a href="<?= site_url('/admin/manage_application'); ?>" id="booking-link">Manage Application</a>
</div>
<div class="container mt-3">
    <!-- Pending Events -->
    <div class="card">
        <div class="card-header header-pending">
            Pending Events
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($events as $event): ?>
                <?php if ($event['status'] == 'Pending'): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img 
                            src="<?= !empty($event['images']) ? ($event['images']) : '/public/images/flowers.png'; ?>" 
                            alt="<?= htmlspecialchars($event['title']); ?>"
                            class="event-img"
                        >
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($event['title']); ?></h5>
                            <p class="card-text">
                                <?= substr($event['description'], 0, 100); ?>...
                            </p>
                            <ul class="list-unstyled">
                                <li><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></li>
                                <li><strong>Start Date:</strong> <?= htmlspecialchars($event['start_date']); ?></li>
                                <li><strong>End Date:</strong> <?= htmlspecialchars($event['end_date']); ?></li>
                                <li><strong>Price:</strong> <?= htmlspecialchars($event['ticket_price']); ?></li>
                            </ul>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button class="btn btn-approve btn-sm" data-id="<?= $event['event_id']; ?>">Approve</button>
                            <button class="btn btn-reject btn-sm" data-id="<?= $event['event_id']; ?>">Reject</button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Approved Events -->
    <div class="card mt-4">
        <div class="card-header header-approved">
            Approved Events
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($events as $event): ?>
                <?php if ($event['status'] == 'approved'): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img 
                            src="<?= !empty($event['images']) ? ($event['images']) : '/public/images/flowers.png'; ?>" 
                            alt="<?= htmlspecialchars($event['title']); ?>"
                            class="event-img"
                        >
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($event['title']); ?></h5>
                            <p class="card-text">
                                <?= substr($event['description'], 0, 100); ?>...
                            </p>
                            <ul class="list-unstyled">
                                <li><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></li>
                                <li><strong>Start Date:</strong> <?= htmlspecialchars($event['start_date']); ?></li>
                                <li><strong>End Date:</strong> <?= htmlspecialchars($event['end_date']); ?></li>
                                <li><strong>Price:</strong> <?= htmlspecialchars($event['ticket_price']); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Rejected Events -->
    <div class="card mt-4">
        <div class="card-header header-rejected">
            Rejected Events
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($events as $event): ?>
                <?php if ($event['status'] == 'rejected'): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img 
                        src="<?= !empty($event['images']) ? $event['images'] : '/public/images/flowers.png'; ?>" alt="Event Image" class="card-img-top"
                            alt="<?= htmlspecialchars($event['title']); ?>"
                            class="event-img"
                        >
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($event['title']); ?></h5>
                            <p class="card-text">
                                <?= substr($event['description'], 0, 100); ?>...
                            </p>
                            <ul class="list-unstyled">
                                <li><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></li>
                                <li><strong>Start Date:</strong> <?= htmlspecialchars($event['start_date']); ?></li>
                                <li><strong>End Date:</strong> <?= htmlspecialchars($event['end_date']); ?></li>
                                <li><strong>Price:</strong> <?= htmlspecialchars($event['ticket_price']); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');

        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('visible');
        });
        $('#pendingTable, #approvedTable, #rejectedTable').DataTable({
            pageLength: 5,
            scrollX: true
        });

        $('.btn-approve, .btn-reject').on('click', function () {
            const eventId = $(this).data('id');
            const action = $(this).hasClass('btn-approve') ? 'approve' : 'reject';
            if (confirm(`Are you sure you want to ${action} this event?`)) {
                $.post(`/admin/${action}/${eventId}`, function () {
                    alert(`Event ${action}d successfully`);
                    location.reload();
                });
            }
        });
    });
</script>

</body>
</html>
