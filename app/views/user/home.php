<?php include APP_DIR.'views/templates/header.php'; ?>
<body>
    <div id="app">
        <div class="container">
            <?php include APP_DIR.'views/templates/nav.php'; ?>
            <?php include APP_DIR.'views/user/header.php'; ?>

            <section class="hero">
                <h1>Find Local Events Near You!</h1>
                <p>Discover exciting events based on your location and interests, and book them instantly with Eventify.</p>
            </section>

            <!-- Search Bar Section -->
            <section class="search-bar">
                <input type="text" id="event-search" placeholder="Search events...">
            </section>

            <section class="events-section">
                <h2>Upcoming Events</h2>
                <div id="events-container">
                    <?php if (!empty($event)): ?>
                        <?php foreach ($event as $event): ?>
                            <?php if ($event['status'] !== 'Pending' && $event['status'] !== 'rejected'): ?>
                                <div class="event-card" data-title="<?= htmlspecialchars($event['title']); ?>" data-description="<?= htmlspecialchars($event['description']); ?>">
                                    <?php if (!empty($event['images'])): ?>
                                        <div class="event-image-container">
                                            <img src="<?= htmlspecialchars($event['images']); ?>" alt="<?= htmlspecialchars($event['title']); ?>" class="event-image">
                                        </div>
                                    <?php endif; ?>
                                    <div class="event-details">
                                        <h3><?= htmlspecialchars($event['title']); ?></h3> <!-- Simple title without link -->
                                        <p class="event-description"><?= htmlspecialchars($event['description']); ?></p>
                                        <p><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></p>
                                        <p><strong>Date:</strong> <?= htmlspecialchars($event['start_date']); ?> to <?= htmlspecialchars($event['end_date']); ?></p>
                                        <p><strong>Price Range:</strong> <?= htmlspecialchars($event['ticket_price']); ?></p>
                                        <p><strong>Type:</strong> <?= htmlspecialchars($event['type']); ?></p>
                                        <a class="book-now-btn" href="<?= site_url('/user/create_booking/' . $event['event_id']); ?>">Book Now</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No events found.</p>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Organizer Application Section -->
            <section class="apply-organizer">
                <div style="text-align: center; margin-top: 30px;">
                    <a href="/user/apply_as_organizer" class="apply-btn">Apply as an Organizer</a>
                </div>
            </section>
        </div>
    </div>

    <style>
        /* General Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f9f9f9;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
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
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .event-image-container {
            width: 100%;
            max-height: 200px;
            overflow: hidden;
        }

        .event-image {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .event-details {
            padding: 20px;
            text-align: center;
        }

        .event-details h3 {
            margin: 0;
            font-size: 1.5em;
            color: #0073e6;
        }

        .event-details .event-description {
            margin: 10px 0 15px;
            color: #555;
            font-size: 1em;
        }

        .event-details p {
            margin: 5px 0;
            font-size: 1em;
            color: #555;
        }

        .book-now-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #0073e6;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .book-now-btn:hover {
            background-color: #005bb5;
        }

        #events-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .search-bar {
            text-align: center;
            margin: 20px 0;
        }

        #event-search {
            width: 80%;
            padding: 10px;
            font-size: 1em;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        #event-search:focus {
            border-color: #0073e6;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 115, 230, 0.5);
        }

        .apply-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 1.2em;
            transition: background-color 0.3s ease;
        }

        .apply-btn:hover {
            background-color: #218838;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("event-search");
            const eventCards = document.querySelectorAll(".event-card");

            searchInput.addEventListener("input", function () {
                const searchQuery = searchInput.value.toLowerCase();

                eventCards.forEach(card => {
                    const title = card.dataset.title.toLowerCase();
                    const description = card.dataset.description.toLowerCase();

                    if (title.includes(searchQuery) || description.includes(searchQuery)) {
                        card.style.display = "block";
                    } else {
                        card.style.display = "none";
                    }
                });
            });
        });
    </script>
</body>
