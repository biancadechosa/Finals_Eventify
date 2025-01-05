<?php
include APP_DIR.'views/templates/header.php';
?>
<div id="app">
    <?php include APP_DIR.'views/templates/nav.php'; ?>

    <header class="main-header">
        <div class="logo">Eventify</div>
        <nav>
            <a href="/user/home" id="home-link">Home</a>
            <a href="/user/about" id="about-link">About</a>
            <a href="#" id="contact-link">Contact</a>
        </nav>
    </header>

    <div id="app-content">
        <!-- Contact Header -->
        <header class="contact-header">
            <h1>Contact Us</h1>
            <p>We'd love to hear from you!</p>
        </header>

        <main class="contact-main">
            <div class="contact-info">
                <section class="contact-section">
                    <h2>Our Office</h2>
                    <p>123 Eventify Street, City, Country</p>
                    <p><strong>Email:</strong> support@eventify.com</p>
                    <p><strong>Phone:</strong> +123 456 7890</p>
                </section>

                <section class="contact-section">
                    <h2>Get in Touch</h2>
                    <form action="#" method="POST" class="contact-form">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" placeholder="Your Full Name" required>

                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Your Email" required>

                        <label for="message">Message</label>
                        <textarea id="message" name="message" placeholder="Your Message" rows="5" required></textarea>

                        <button type="submit">Send Message</button>
                    </form>
                </section>
            </div>

            <!-- Map Section -->
            <section class="contact-map">
                <h2>Find Us Here</h2>
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=your-google-map-embed-code" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </section>
        </main>
    </div> <!-- End of app-content -->

    <footer class="contact-footer">
        <p>&copy; 2024 Eventify. All rights reserved.</p>
    </footer>
</div> <!-- End of app -->

<style>
  /* Shared styles for headers */
header {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-sizing: border-box;
}

/* Main Header Navigation Bar */
.main-header {
    background-color: #0073e6;
    color: #fff;
}

.main-header .logo {
    font-size: 2em;
    font-weight: bold;
}

.main-header nav a {
    color: white;
    margin: 0 15px;
    text-decoration: none;
    font-size: 1.1em;
}

.main-header nav a:hover {
    text-decoration: underline;
}

/* Contact Header */
.contact-header {
    background-color: #0073e6;
    color: #fff;
    text-align: center;
    padding: 60px 20px;
    background: linear-gradient(135deg, #0073e6, #005bb5);
    max-width: 1200px;
    margin: 0 auto;
    box-sizing: border-box;
}

.contact-header h1 {
    margin: 0;
    font-size: 3.5em;
    font-weight: bold;
}

.contact-header p {
    margin-top: 15px;
    font-size: 1.3em;
}

/* Main content */
.contact-main {
    padding: 40px 20px;
    background-color: #f4f4f4;
    max-width: 1200px;
    margin: 0 auto;
}

.contact-info {
    display: flex;
    justify-content: space-between;
    gap: 30px;
    flex-wrap: wrap;
}

.contact-section {
    background-color: #fff;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    flex: 1;
    margin-bottom: 30px;
}

.contact-section h2 {
    font-size: 2em;
    color: #0073e6;
}

.contact-section p {
    font-size: 1.1em;
    color: #555;
    line-height: 1.6;
}

.contact-form {
    display: flex;
    flex-direction: column;
}

.contact-form label {
    margin-bottom: 5px;
    font-size: 1.1em;
}

.contact-form input,
.contact-form textarea {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 1em;
}

.contact-form button {
    background-color: #0073e6;
    color: white;
    padding: 10px 20px;
    font-size: 1.1em;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.contact-form button:hover {
    background-color: #005bb5;
}

/* Map Section */
.contact-map {
    margin-top: 40px;
    text-align: center;
}

.contact-map iframe {
    border: none;
    border-radius: 10px;
    max-width: 100%;
}

/* Footer */
.contact-footer {
    background-color: #0073e6;
    color: #fff;
    text-align: center;
    padding: 20px 0;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .contact-info {
        flex-direction: column;
        gap: 20px;
    }

    .contact-form {
        width: 100%;
    }

    .contact-section {
        flex: none;
        width: 100%;
    }

    .contact-header h1 {
        font-size: 2.5em;
    }

    .contact-header p {
        font-size: 1.2em;
    }
}

</style>

</body>
</html>
