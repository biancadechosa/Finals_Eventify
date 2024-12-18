
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['title']); ?> - Eventify </title>
    <link rel="stylesheet" href="/styles.css">
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <header>
            <div class="header-container">
                <h1>Eventify</h1>
                <nav>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/user/about">About</a></li>
                        <li><a href="/user/browse">Browse Events</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Main Section (Event Details) -->
        <main>
            <section class="event-detail"> 
                <h2><?= htmlspecialchars($event['title']); ?></h2>
                
                <!-- Event Image -->
                <div class="event-detail-image">
                    <?php if (!empty($event['image'])): ?>
                        <img src="/uploads/<?= htmlspecialchars($event['image']); ?>" alt="<?= htmlspecialchars($event['title']); ?>">
                    <?php else: ?>
                        <img src="/public/images/flowers.png" alt="Default Event Image">
                    <?php endif; ?>
                </div>

                <div class="event-detail-info">
                    <p><strong>Description:</strong> <?= htmlspecialchars($event['description']); ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($event['venue_name']); ?></p>
                    <p><strong>Address:</strong> <?= htmlspecialchars($event['venue_address']); ?></p>
                    <!-- More details can be added as needed -->
                </div>
            </section>
        </main>

        <!-- Footer Section -->
        <footer>
            <div class="footer-container">
                <p>&copy; <?= date('Y'); ?> Eventify. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>

</html>
