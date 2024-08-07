<link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/header.css' ?>">
<script src="<?php echo BASE_URL . '/assets/js/header.js'?>"></script>

<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Administrator') { $admin = 'admin'; } ?>
<header class="<?php echo isset($admin) ? $admin : ''; ?>">
    <article class="header-1">
        <div class="logo" >
            <img src="<?php echo BASE_URL . '\assets\images\logo.png' ?> "/>
            <?php if (isset($admin)): ?>
                <p>Admin Dashboard</p>
            <?php endif; ?>
        </div>
        <?php if (isset($_SESSION['id'])): ?>
        <div class="user-profile-container">
            <div class="user-profile">
                <div class="profile-1">
                    <section class="user-img">
                        <img src="<?php echo BASE_URL."/".$_SESSION['image']; ?>">
                    </section>
                    <section class="user-info">
                        <p><?php echo $_SESSION['role']; ?></p>
                        <h2><?php echo $_SESSION['name']; ?></h2>
                    </section>
                    <img src="https://img.icons8.com/?size=100&id=99977&format=png&color=FFFFFF">
                </div>
                <div class="profile-2">
                    <section class="profile-dropdown">
                        <button onclick="gotoURL('<?php echo BASE_URL . '/logout.php' ?>')">
                            LOG OUT
                        </button>
                    </section>
                </div>
            </div>
        </div>

        <?php else: ?>
            <div class="buttons">
                <button class="login">
                    <a class="type-site" href="<?php echo BASE_URL . '/index.php';?>">HOME
                        <span class="under-text"></span>
                    </a>
                </button>
                <button class="login">
                    <a class="type-site" href="<?php echo BASE_URL . '/login.php'?>">LOGIN
                        <span class="under-text"></span>
                    </a>
                </button>
                <button class="register">
                    <a href="<?php echo BASE_URL . '/register.php'?>">REGISTER</a>
                </button>
            </div>
        <?php endif; ?>
        <div class="dropdown">
            <img class="hamburger" src="<?php echo BASE_URL . '\assets\images\hamburger.png' ?> ">
        </div>
    </article>
    <article class="header-2">
        
    </article>
</header>
