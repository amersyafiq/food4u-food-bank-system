<link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/nav.css' ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php echo BASE_URL . '/assets/js/nav.js' ?>"></script>
<nav>
    <div class="nav-1">
        <p>Navigation</p>
        <img id="nav-btn" src="<?php echo BASE_URL . '\assets\images\hamburger.png' ?> ">
    </div>
    <div class="nav-2">
        <?php if (!isset($admin)): ?>
            <button onclick="gotoURL('<?php echo BASE_URL . '/index.php' ?>')">
                <img src="<?php echo BASE_URL . '\assets\images\home_logo.png' ?> ">
                <p>Home</p>
            </button>
            <button onclick="gotoURL('<?php echo BASE_URL . '/events.php' ?>')">
                <img src="<?php echo BASE_URL . '\assets\images\eventlist_logo.png' ?> ">
                <p>Event List</p>
            </button>
            <button onclick="gotoURL('<?php echo BASE_URL . '/requests.php' ?>')">
                <img src="<?php echo BASE_URL . '\assets\images\requestevent_logo.png' ?> ">
                <p>Request Event</p>
            </button>
        <?php else: ?>
            <button onclick="gotoURL('<?php echo BASE_URL . '/dashboard.php' ?>')">
                <img style="filter: invert(1);" src="https://img.icons8.com/?size=100&id=6ocfyfPqD0qz&format=png&color=000000">
                <p>Dashboard</p>
            </button>
            <button onclick="gotoURL('<?php echo BASE_URL . '/events/create.php' ?>')">
                <img src="<?php echo BASE_URL . '\assets\images\requestevent_logo.png' ?> ">
                <p>Schedule Event</p>
            </button>
        <?php endif; ?>
    </div>
</nav>