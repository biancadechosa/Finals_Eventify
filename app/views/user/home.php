
<?php
include APP_DIR.'views/templates/header.php';
?>
<body>
    <div id="app">
        <div class="container">
            <?php include APP_DIR.'views/templates/nav.php'; ?>

            <header>
                <div class="logo">Eventify</div>
                <nav>
                    <a href="#" id="home-link">Home</a>
                    <a href="/user/about" id="about-link">About</a>
                    <a href="/user/browse" id="browse-link">Browse Events</a>
                    <a href="#" id="contact-link">Contact</a>
                </nav>
            </header>

            <section class="hero">
                <h1>Find Local Events Near You!</h1>
                <p>Discover exciting events based on your location and interests, and book them instantly with Eventify.</p>
            </section>

            <section class="events-section">
                <h2>Upcoming Events</h2>
                <div id="events-container">
                <?php if (!empty($event)): ?>
    <?php foreach ($event as $event): ?>
        <?php if ($event['status'] !== 'Pending' && $event['status'] !== 'rejected'): // Filter by status ?>
            <div class="event-card">
                <h3><a href="/user/event/<?= htmlspecialchars($event['event_id']); ?>"><?= htmlspecialchars($event['title']); ?></a></h3>
                <p><?= htmlspecialchars($event['description']); ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></p>
                <p><strong>Date:</strong> <?= htmlspecialchars($event['start_date']); ?> to <?= htmlspecialchars($event['end_date']); ?></p>
                <p><strong>Price Range:</strong> <?= htmlspecialchars($event['ticket_price']); ?></p>
                <p><strong>Popularity:</strong> <?= htmlspecialchars($event['popularity']); ?></p>
                <p><strong>Ratings:</strong>
                    <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['event_id']); ?>">
                    <span class="stars">
                        <?= str_repeat('★', $event['ratings']) . str_repeat('☆', 5 - $event['ratings']); ?>
                    </span>
                </p>
                <p><strong>Type:</strong> <?= htmlspecialchars($event['type']); ?></p>
                <a class="book-now-btn" role="button" href="<?= site_url('/user/create_booking/' . $event['event_id']); ?>" data-event_id="<?= $event['event_id']; ?>">Book Now</a>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>No events found.</p>
<?php endif; ?>

                </div>
            </section>
        </div>
    </div>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #fafafa;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        header {
            background-color: #0073e6;
            color: #fff;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .logo {
            font-size: 1.8em;
            font-weight: bold;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1.1em;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #ffcc00;
        }

        .hero {
            text-align: center;
            padding: 60px 20px;
            background: linear-gradient(135deg, #0073e6, #005bb5);
            color: #fff;
        }

        .hero h1 {
            margin: 0;
            font-size: 2.5em;
            line-height: 1.2;
        }

        .hero p {
            margin: 15px 0 25px;
            font-size: 1.2em;
            color: #f1f1f1;
        }

        .events-section {
            padding: 40px 0;
        }

        .events-section h2 {
            font-size: 2em;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }

        .event-card {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .event-card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .event-card h3 {
            margin: 0;
            font-size: 1.5em;
            color: #0073e6;
        }

        .event-card p {
            margin: 5px 0;
            font-size: 1em;
            color: #555;
        }

        .event-card .stars {
            color: gold;
        }

        #events-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 0 15px;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2em;
            }

            .hero p {
                font-size: 1.1em;
            }

            nav a {
                margin: 0 10px;
            }

            .events-section h2 {
                font-size: 1.8em;
            }
            
        }
    </style>
    
</body>
</html>
