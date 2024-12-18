<?php
include APP_DIR.'views/templates/header.php';
?>
<body>
    <div id="app">
    <?php
    include APP_DIR.'views/templates/nav.php';
    ?>

    <section class="hero">
        <h1>Browse Events</h1>
        <p>Find events that match your interests and location.</p>
    </section>

    <section class="events-filter">
        <form id="filter-form">
            <label for="type">Event Type</label>
            <select name="type" id="type">
                <option value="">All Types</option>
                <option value="concert">Concert</option>
                <option value="meetup">Meetup</option>
                <option value="festival">Festival</option>
            </select>

            <label for="location">Location</label>
            <input type="text" name="location" id="location" placeholder="Enter a location">

            <label for="date">Date</label>
            <input type="date" name="date" id="date">

            <button type="submit" id="filter-button">Filter</button>
        </form>
    </section>

    <section class="events-section">
        <h2>Upcoming Events</h2>
        <div id="events-container">
            <!-- Events will be dynamically loaded here -->
        </div>
    </section>
</body>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Initial load of all events
    loadEvents();

    // Filter form submission
    $('#filter-form').submit(function(e) {
        e.preventDefault(); // Prevent page reload
        loadEvents();
    });

    function loadEvents() {
        let formData = $('#filter-form').serialize(); // Get form data

        $.ajax({
            url: '/user/browse',
            method: 'GET',
            data: formData,
            success: function(response) {
                $('#events-container').html(response); // Update events container with new data
            },
            error: function() {
                alert('An error occurred while fetching events.');
            }
        });
    }
});
</script>

</html>
