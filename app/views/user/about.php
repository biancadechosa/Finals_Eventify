<?php include APP_DIR . 'views/templates/header.php'; ?>
<body>
    <div id="app">
        <div class="container">
            <?php include APP_DIR . 'views/templates/nav.php'; ?>
            <?php include APP_DIR . 'views/user/header.php'; ?>

            <section class="hero">
                <h1>About Eventify</h1>
                <p>Your Ultimate Local Event Finder</p>
            </section>

            <main class="about-main">
                <section class="about-section">
                    <h2>What is Eventify?</h2>
                    <p>Eventify is a platform designed to connect you with exciting events happening around you. Whether you're looking for music festivals, food festivals, tech meetups, or local community events, we have it all. With Eventify, you can easily discover and book events in your area based on your preferences and interests.</p>
                </section>

                <section class="about-section">
                    <h2>How Does It Work?</h2>
                    <p>Simply search for events by location, type, or date, and discover what's happening near you. Once you've found an event that piques your interest, you can quickly book your spot and receive instant confirmation. It's that simple!</p>
                </section>

                <section class="about-section">
                    <h2>Why Choose Eventify?</h2>
                    <ul>
                        <li><strong>Easy Search:</strong> Find events near you with just a few clicks.</li>
                        <li><strong>Instant Booking:</strong> Book your tickets and get instant confirmation.</li>
                        <li><strong>Curated for You:</strong> Discover events tailored to your interests and preferences.</li>
                        <li><strong>Safe and Secure:</strong> Your personal and payment information is always protected.</li>
                    </ul>
                </section>

                <section class="about-section">
                    <h2>Our Mission</h2>
                    <p>At Eventify, our mission is to make it easier for people to discover and attend local events. We believe that great experiences should be accessible to everyone, and we're committed to providing a platform that simplifies the process of finding and booking events. Join us today and start exploring!</p>
                </section>
            </main>

            <footer class="about-footer">
                <p>&copy; 2024 Eventify. All rights reserved.</p>
            </footer>
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

        .about-main {
            padding: 40px 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .about-section {
            margin-bottom: 30px;
        }

        .about-section h2 {
            font-size: 1.8em;
            margin-bottom: 15px;
            color: #0073e6;
        }

        .about-section p,
        .about-section ul {
            font-size: 1em;
            color: #555;
        }

        .about-section ul {
            padding-left: 20px;
            list-style: disc;
        }

        .about-footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</body>
