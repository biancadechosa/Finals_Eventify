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

        .actions button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
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

        .picture {
            text-align: center;
        }

        .picture img {
            max-width: 60px;
            max-height: 60px;
            border-radius: 50%;
        }

    </style>
</head>
<body>
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
                    <th>Picture</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data rows dynamically populated here -->
                <?php foreach ($applications as $application): ?>
                    <tr>
                        <td><?= htmlspecialchars($application['name']); ?></td>
                        <td><?= htmlspecialchars($application['email']); ?></td>
                        <td><?= htmlspecialchars($application['phone']); ?></td>
                        <td><?= htmlspecialchars($application['experience']); ?></td>
                        <td><?= htmlspecialchars($application['event_type']); ?></td>
                        <td class="picture">
                            <img src="<?= base_url('uploads/' . $application['picture']); ?>" alt="Applicant Picture">
                        </td>
                        <td class="actions">
                            <form action="<?= site_url('/admin/approve_application/' . $application['id']); ?>" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $application['id']; ?>">
                                <button class="approve" type="submit">Approve</button>
                            </form>
                            <form action="<?= site_url('/admin/reject_application/' . $application['id']); ?>" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $application['id']; ?>">
                                <button class="reject" type="submit">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
