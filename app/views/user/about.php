<?php
include APP_DIR.'views/templates/header.php';
?>
<div id="app">
    <?php include APP_DIR.'views/templates/nav.php'; ?>

    <div id="app-content">
        <!-- Header Section -->
        <header class="about-header">
            <div class="logo">Eventify</div>
            <nav>
                <a href="/user/home" id="home-link">Home</a>
                <a href="#" id="about-link">About</a>
                <a href="/user/contact" id="contact-link">Contact</a>
            </nav>
        </header>

        <!-- Main Content -->
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
    </div> <!-- End of app-content -->

    <footer class="about-footer">
        <p>&copy; 2024 Eventify. All rights reserved.</p>
    </footer>
</div> <!-- End of app -->

<style>
    /* Header section */
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
        margin-top: 80px; /* to avoid overlap with fixed header */
    }

    .main-header h1 {
        margin: 0;
        font-size: 3em;
        font-weight: bold;
    }

    .main-header p {
        margin-top: 15px;
        font-size: 1.5em;
    }

    /* Main content section */
    .about-main {
        padding: 40px 20px;
        background-color: #f4f4f4;
    }

    .about-section {
        margin-bottom: 40px;
        background-color: #fff;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .about-section h2 {
        font-size: 2em;
        color: #0073e6;
    }

    .about-section p {
        font-size: 1.1em;
        color: #555;
        line-height: 1.6;
    }

    .about-section ul {
        list-style-type: none;
        padding: 0;
    }

    .about-section ul li {
        font-size: 1.1em;
        color: #555;
        margin-bottom: 10px;
    }

    .about-section ul li strong {
        color: #0073e6;
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
            align-items: flex-start;
        }

        nav a {
            margin-left: 15px;
            font-size: 1em;
        }

        .main-header h1 {
            font-size: 2.5em;
        }

        .main-header p {
            font-size: 1.3em;
        }

        .about-section h2 {
            font-size: 1.8em;
        }

        .about-section p {
            font-size: 1em;
        }
    }
</style>

</body>
</html>
