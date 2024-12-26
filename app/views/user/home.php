<?php include APP_DIR.'views/templates/header.php'; ?>
<body>
    <div id="app">
        <div class="container">
            <?php include APP_DIR.'views/templates/nav.php'; ?>

            <header>
                <div class="logo">Eventify</div>
                <nav>
                    <a href="#" id="home-link">Home</a>
                    <a href="/user/about" id="about-link">About</a>
                    <a href="/user/contact" id="contact-link">Contact</a>
                </nav>
            </header>

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
                            <?php if ($event['status'] !== 'Pending' && $event['status'] !== 'rejected'): // Filter by status ?>
                                <div class="event-card" data-title="<?= htmlspecialchars($event['title']); ?>" data-description="<?= htmlspecialchars($event['description']); ?>">
                                    <h3><a href="/user/event/<?= htmlspecialchars($event['event_id']); ?>"><?= htmlspecialchars($event['title']); ?></a></h3>
                                    <p><?= htmlspecialchars($event['description']); ?></p>
                                    <p><strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></p>
                                    <p><strong>Date:</strong> <?= htmlspecialchars($event['start_date']); ?> to <?= htmlspecialchars($event['end_date']); ?></p>
                                    <p><strong>Price Range:</strong> <?= htmlspecialchars($event['ticket_price']); ?></p>
                                    <p><strong>Type:</strong> <?= htmlspecialchars($event['type']); ?></p>
                                    <a class="book-now-btn" href="<?= site_url('/user/create_booking/' . $event['event_id']); ?>">Book Now</a>
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

    <!-- Add jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Event listener for the search input field
            $('#event-search').on('keyup', function() {
                var query = $(this).val().toLowerCase(); // Get the search query

                // Loop through each event card and check if the title or description contains the query
                $('.event-card').each(function() {
                    var title = $(this).data('title').toLowerCase();
                    var description = $(this).data('description').toLowerCase();

                    // Show or hide the event card based on the search query
                    if (title.indexOf(query) !== -1 || description.indexOf(query) !== -1) {
                        $(this).show(); // Show the card if it matches
                    } else {
                        $(this).hide(); // Hide the card if it doesn't match
                    }
                });
            });
        });
    </script>
</body>
</html>
