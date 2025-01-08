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
    <title>Admin - Organizer Applications</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            text-align: center;
            color: #0073e6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background-color: #0073e6;
            color: #fff;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            font-size: 1em;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .actions span {
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .actions .approved {
            color: #28a745;
        }

        .actions .rejected {
            color: #dc3545;
        }

        .picture {
            text-align: center;
        }

        .picture img {
            max-width: 60px;
            max-height: 60px;
            border-radius: 50%;
        }

        .approve, .reject {
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .approve {
            background-color: #28a745;
            color: #fff;
        }

        .approve:hover {
            background-color: #218838;
        }

        .reject {
            background-color: #dc3545;
            color: #fff;
        }

        .reject:hover {
            background-color: #c82333;
        }

        .sidebar {
            height: 100%;
            width: 200px;
            position: fixed;
            top: 0;
            left: -200px;
            background-color: #003060;
            padding-top: 15px;
            color: white;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .sidebar.visible {
            left: 0;
        }

        .sidebar a {
            padding: 8px 12px;
            text-decoration: none;
            font-size: 14px;
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
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        .hamburger {
            position: absolute;
            top: 10px;
            left: 10px;
            cursor: pointer;
            z-index: 1000;
            font-size: 20px;
            background-color: #003060;
            color: white;
            border: none;
            padding: 4px 6px;
            border-radius: 5px;
            opacity: 1;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .hamburger:hover {
            background-color: #055c9d;
        }
        
    </style>
</head>
<body>
<button class="hamburger" id="hamburger">☰</button>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <span>Admin Dashboard</span>
    </div>
    <a href="<?= site_url('/admin/dashboard'); ?>" id="events-link">Events</a>
    <a href="<?= site_url('/admin/manage_application'); ?>" id="booking-link" class="active">Manage Application</a>
</div>
<h1>Organizer Applications</h1>
<div class="container">
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email Address</th>
                <th>Phone Number</th>
                <th>Experience</th>
                <th>Event Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($apply as $application): ?>
                <tr>
                    <td><?= htmlspecialchars($application['name']); ?></td>
                    <td><?= htmlspecialchars($application['email']); ?></td>
                    <td><?= htmlspecialchars($application['phone']); ?></td>
                    <td><?= htmlspecialchars($application['experience']); ?></td>
                    <td><?= htmlspecialchars($application['event_type']); ?></td>
                    <td class="actions">
                        <?php if ($application['email'] !== null): ?>
                            <!-- Only show approval/rejection if no action has been taken yet -->
                            <?php if ($application['status'] === 'approved'): ?>
                                <span class="approved">Approved</span>
                            <?php elseif ($application['status'] === 'rejected'): ?>
                                <span class="rejected">Rejected</span>
                            <?php else: ?>
                                <form action="<?= site_url('/admin/approve_application/' . $application['user_id']); ?>" method="POST" class="approval-form" onsubmit="return confirmAction('approve');">
                                    <input type="hidden" name="user_id" value="<?= $application['user_id']; ?>">
                                    <button class="approve" type="submit">Approve</button>
                                </form>
                                <form action="<?= site_url('/admin/reject_application/' . $application['user_id']); ?>" method="POST" class="approval-form" onsubmit="return confirmAction('reject');">
                                    <input type="hidden" name="user_id" value="<?= $application['user_id']; ?>">
                                    <button class="reject" type="submit">Reject</button>
                                </form>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="pending">Pending Email Verification</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

<script>
    const hamburger = document.getElementById('hamburger');
    const sidebar = document.getElementById('sidebar');

    hamburger.addEventListener('click', () => {
        sidebar.classList.toggle('visible');
    });

    function confirmAction(action) {
        return confirm(`Are you sure you want to ${action} this application?`);
    }
</script>
</body>
</html>
