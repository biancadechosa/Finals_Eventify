<?php
include APP_DIR.'views/templates/header.php';
?>
<div id="app">
    <?php include APP_DIR.'views/templates/nav.php'; ?>

    <div id="app-content">
        <!-- Navigation Header -->
        <header class="about-header">
            <div class="logo">Eventify</div>
            <nav>
                <a href="/user/home" id="home-link">Home</a>
                <a href="#" id="about-link">About</a>
                <a href="/user/contact" id="contact-link">Contact</a>
            </nav>
        </header>

        <!-- Main Content -->
        <div class="main-content">
            <header class="main-header">
                <h1>About Eventify</h1>
                <p>Your Ultimate Local Event Finder</p>
            </header>

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
        </div>
    </div> <!-- End of app-content -->

    <footer class="about-footer">
        <p>&copy; 2024 Eventify. All rights reserved.</p>
    </footer>
</div> <!-- End of app -->

<style>
    /* Fixed Navigation Header */
    .about-header {
        background-color: #0073e6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 30px;
        color: #fff;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 100;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .logo {
        font-size: 1.8em;
        font-weight: bold;
        color: #fff;
        text-transform: uppercase;
    }

    nav a {
        color: #fff;
        margin-left: 20px;
        text-decoration: none;
        font-size: 1.1em;
    }

    nav a:hover {
        text-decoration: underline;
    }

    /* Main content header */
    .main-header {
        background: linear-gradient(135deg, #0073e6, #005bb5);
        color: #fff;
        text-align: center;
        padding: 80px 20px 20px;
        margin-top: 80px; /* Offset for fixed nav */
    }

    .main-header h1 {
        margin: 0;
        font-size: 3em;
        font-weight: bold;
    }

    .main-header p {
        font-size: 1.2em;
        margin-top: 10px;
    }

    /* About Main Content */
    .about-main {
        padding: 40px 20px;
        background-color: #f4f4f4;
        max-width: 1200px;
        margin: 0 auto;
    }

    .about-section {
        margin-bottom: 30px;
    }

    .about-section h2 {
        color: #0073e6;
        font-size: 2em;
        margin-bottom: 10px;
    }

    .about-section p,
    .about-section ul {
        font-size: 1.1em;
        line-height: 1.6;
        color: #555;
    }

    .about-section ul {
        padding-left: 20px;
    }

    .about-section ul li {
        margin-bottom: 10px;
    }

    /* Footer */
    .about-footer {
        background-color: #0073e6;
        color: #fff;
        text-align: center;
        padding: 20px 0;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .about-header {
            flex-direction: column;
            text-align: center;
        }

        .main-header {
            padding: 100px 20px 20px;
        }

        .main-header h1 {
            font-size: 2.5em;
        }

        .about-main {
            padding: 20px;
        }

        .about-section h2 {
            font-size: 1.5em;
        }
    }
</style>
