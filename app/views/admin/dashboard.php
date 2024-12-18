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
        }

        .card {
            margin-top: 20px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 10px;
        }

        .card-header {
            font-weight: bold;
            color: #fff;
            border-radius: 10px 10px 0 0;
            padding: 15px;
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
            padding: 8px;
        }

        td {
            padding: 6px;
            word-wrap: break-word;
        }

        .btn-approve {
            background: #4caf50;
            color: #fff;
            border: none;
        }

        .btn-approve:hover {
            background: #388e3c;
        }

        .btn-reject {
            background: #f44336;
            color: #fff;
            border: none;
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
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>
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

<script>
    $(document).ready(function () {
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
