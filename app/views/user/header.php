<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <style>
        /* Header Styling */
        header {
            background-color: #0073e6;
            color: #fff;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <a href="/user/home" style="color: #fff; text-decoration: none;">Eventify</a>
        </div>
        <nav>
            <a href="/user/home" id="home-link">Home</a>
            <a href="/user/about" id="about-link">About</a>
            <a href="/user/contact" id="contact-link">Contact</a>
            <a href="/user/mybook" id="contact-link">My Bookings</a>
        </nav>
    </header>

    <script>
        // You can add any header-specific scripts here if needed in the future
    </script>
</body>
</html>
