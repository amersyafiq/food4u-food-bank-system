<?php include("path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/eventPost.php") ?>
<?php include(ROOT_PATH . "/app/controllers/eventDashboard.php") ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Food4U | Dashboard</title>

        <!-- FONT & FONTAWESOME -->
        <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/dashboard.css' ?> ">
        <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/message.css' ?> ">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- JQUERY SCRIPTS -->
        <script src="<?php echo BASE_URL. '/assets/js/jquery-3.7.1.js'?>"></script>
        <script src="<?php echo BASE_URL. '/assets/js/jquery-ui-1.13.3/jquery-ui.js'?>"></script>
        <script src="<?php echo BASE_URL . '/assets/js/dashboard.js'?>"></script>

    </head>

    <body>
        <?php
            if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'Administrator')
            {
                header("Location:" . BASE_URL . "/index.php");
                die();
            } 
        ?>
        
        <!-- HEADER -->
        <?php include(ROOT_PATH . "/app/includes/header.php"); ?>

        <div class="nav-main">

            <?php if(isset($_SESSION['id'])) {
                include(ROOT_PATH . "/app/includes/nav.php");
            } ?>

            <!-- MAIN -->
            <main>
                <article>
                    <section>
                        <h1> DASHBOARD </h1>
                        <p> View and alter the data of Food4U System </p>
                    
                        <!-- DISPLAY SUCCESS MESSAGE -->
                        <?php if(isset($_SESSION['message'])) {
                            include("app/includes/successMessage.php");
                            unset($_SESSION['message']);
                        }
                        ?>
                    </section>
                </article>

                <article>
                    <div class="dashboard-selection">
                        <div class="volunteers">
                            <img src="https://img.icons8.com/?size=100&id=99268&format=png&color=FFFFFF">
                            <div>
                                <h2><?php echo $countVol['COUNT(*)'] ?></h2>
                                <p>Volunteers</p>
                            </div>
                        </div>
                        <div class="organizations">
                            <img src="https://img.icons8.com/?size=100&id=53426&format=png&color=FFFFFF">
                            <div>
                                <h2><?php echo $countOrg['COUNT(*)'] ?></h2>
                                <p>Organizations</p>
                            </div>
                        </div>
                        <div class="events">
                            <img src="https://img.icons8.com/?size=100&id=26063&format=png&color=FFFFFF">
                            <div>
                                <h2><?php echo $countEvent['COUNT(*)'] ?></h2>
                                <p>Total Events</p>
                            </div>
                        </div>
                        <div class="donations">
                            <img src="https://img.icons8.com/?size=100&id=MuNNwJd8zS20&format=png&color=FFFFFF">
                            <div>
                                <h2><?php echo $countDonation['COUNT(*)'] ?></h2>
                                <p>Total Donations</p>
                            </div>
                        </div>
                    </div>
                </article>
                
                <article class="dashboard-card-container">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h1>Latest Event</h1>
                            <button class="download-btn download-events">
                                <img src="https://img.icons8.com/?size=100&id=59866&format=png&color=FFFFFF">
                                <p>Download as PDF</p>
                            </button>
                        </div>
                        <div class="card-content">
                            <div>
                                <div>
                                    <select name="eventType">
                                        <option value="all" > All Events</option>
                                        <option value="upcoming" >Upcoming Events</option>
                                        <option value="finished" >Finished Events</option>
                                    </select>
                                </div>
                                <div class="search-event">
                                    <input type="text" name="searchEvent" value="<?php echo isset($search) ? $search : ''; ?>">
                                    <img src="https://img.icons8.com/?size=100&id=59878&format=png&color=000000">
                                </div>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th><th>EVENT NAME</th><th>DATE</th><th>TIME</th><th>STATUS</th><th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="events-response">
                                    <?php foreach ( $rows as $index => $event ): ?>
                                        <tr>
                                            <td><?php echo $event['EVENT_ID'] ?></td>
                                            <td><?php echo $event['EVENT_NAME'] ?></td>
                                            <td><?php echo date('F d', strtotime($event['EVENT_DATE'])); ?></td>
                                            <td><?php echo date("h:i A", strtotime($event['EVENT_TIME'])); ?></td>
                                            <td><p class="event-status"><?php $status = $event['EVENT_DATE'] > $currDate ? 'Upcoming' : 'Ended'; echo $status; ?></p></td>
                                            <td class="action-btns">
                                                <button type="button" onclick="location.href='<?php echo BASE_URL . '/events/post.php?id=' . $event['EVENT_ID']; ?>'"><img src="https://img.icons8.com/?size=100&id=61040&format=png&color=FFFFFF"></button>
                                                <button type="button" onclick="location.href='<?php echo BASE_URL . '/events/edit.php?id=' . $event['EVENT_ID']; ?>'"><img src="https://img.icons8.com/?size=100&id=MCdDfCTzd5GC&format=png&color=FFFFFF"></button>
                                                <button data-delete-name="<?php echo $event['EVENT_NAME'] ?>" 
                                                        data-delete-id="<?php echo $event['EVENT_ID'] ?>"
                                                        data-delete-vol="<?php echo $event['VOL_AMOUNT'] ?>" 
                                                        class="delete-btn">
                                                        <img src="https://img.icons8.com/?size=100&id=67884&format=png&color=FFFFFF">
                                                </button>
                                                <button data-donate-id="<?php echo $event['EVENT_ID'] ?>"
                                                        class="donate-btn">
                                                        <img src="https://img.icons8.com/?size=100&id=MuNNwJd8zS20&format=png&color=FFFFFF">
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </article>


                <form action="<?php echo BASE_URL . '/dashboard.php' ?>" method="post">
                    <div class="popup delete-card">
                        <div>
                            <div class="btn">
                                <img class="popup-close" src="<?php echo BASE_URL . "/assets/images/X_logo.png"; ?>">
                            </div>
                            <div>
                                <h1>ARE YOU SURE?</h1>
                                <p>By deleting this event, an email notification will be sent to all participating volunteers about its cancellation and all data related to this event will be deleted. This action can't be undone. </p>
                            </div>
                            <h3> Event Name </h3>
                            <div class="name-container">
                                <p></p>
                            </div>
                            <h3> Participating Volunteer(s) </h3>
                            <div class="name-container">
                                <p class="vol-amt"></p>
                            </div>
                            <input type="hidden" name="DELETE_ID" value="">
                
                            <div class="popup-btn">
                                <button type="submit" name="delete"> DELETE </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="popup donate-card">
                    <div>
                        <div class="btn">
                            <img class="popup-close" src="<?php echo BASE_URL . "/assets/images/X_logo.png"; ?>">
                        </div>
                        <div>
                            <h1>PENDING DONATION</h1>
                            <p>ID: <span class='donation-event-id'></span></p>
                        </div>
                        <div class="donation-selection">
                            <h3 class="donation-selection-text">Individual Donation <p>50</p></h3>
                            <h3>Sponsor Inquiry <p>5</p></h3>
                        </div>
                        <div class="donation-filter">
                            <div>
                                <select name="donationType">
                                    <option value="pending" > Pending </option>
                                    <option value="accepted" > Accepted </option>
                                </select>
                            </div>
                            <div class="search-event">
                                <input type="text" name="searchDonation" value="<?php echo isset($search) ? $search : ''; ?>">
                                <img src="https://img.icons8.com/?size=100&id=59878&format=png&color=000000">
                            </div>
                        </div>
                        <div class="donation-table-container">
                            <table class="donation-table">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>DONOR NAME</th><th>DATE</th><th>DONATION NAME</th><th>QUANTITY</th><th>STATUS</th><th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="donation-response">

                                </tbody>
                            </table>
                            <table class="sponsor-table">
                                <thead>
                                    <tr>
                                        <th>ID</th><th>ORGANIZATION NAME AND DESCRIPTION</th><th>SPONSOR METHOD AND ADDRESS</th><th>STATUS</th><th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="sponsor-response">

                                </tbody>
                            </table>
                        </div>
                        <button class="download-btn download-donation">
                            <img src="https://img.icons8.com/?size=100&id=59866&format=png&color=FFFFFF">
                            <p>Download as PDF</p>
                        </button>
                        <button class="download-btn download-sponsor">
                            <img src="https://img.icons8.com/?size=100&id=59866&format=png&color=FFFFFF">
                            <p>Download as PDF</p>
                        </button>
                    </div>
                </div>

            </main>
        </div>

        <!-- FOOTER -->
        <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>
    </body>
</html>
