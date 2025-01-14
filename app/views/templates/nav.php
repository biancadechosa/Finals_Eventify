<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url(); ?>">
            Eventify
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto"></ul>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                <?php if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('auth/login'); ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('auth/register'); ?>">Register</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><?= html_escape(get_username(get_user_id())); ?></a>
                    </li>
                    <!-- Check if the user's role is 'organizer' -->
                    <?php if ($_SESSION['role'] === 'organizer'): ?>
                        <li class="nav-item" id="continue-as-user-link">
                            <a class="nav-link" href="<?= site_url('/user/home'); ?>" id="continue-as-user">Continue as User</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('auth/login'); ?>">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        const continueLink = document.getElementById('continue-as-user-link');
        const currentPage = window.location.pathname; // Get the current page URL path

        // Check if the current page is '/organizer/dashboard' or '/organizer/manage_booking'
        if (currentPage.includes('/organizer/dashboard') || currentPage.includes('/organizer/manage_booking')) {
            // Make sure the "Continue as User" link is visible on these pages
            if (continueLink) {
                continueLink.style.display = 'inline-block'; // Show the link
            }
        } else {
            // Hide the "Continue as User" link on other pages
            if (continueLink) {
                continueLink.style.display = 'none'; // Hide the link
            }
        }
    });
</script>
