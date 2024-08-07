<?php include("path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/eventPost.php") ?>
<?php include(ROOT_PATH . "/app/controllers/eventList.php") ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Food4U | Events</title>

        <!-- FONT & FONTAWESOME -->
        <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/events.css' ?> ">
        <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/message.css' ?> ">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- JQUERY SCRIPTS -->
        <script src="<?php echo BASE_URL. '/assets/js/jquery-3.7.1.js'?>"></script>
        <script src="<?php echo BASE_URL. '/assets/js/jquery-ui-1.13.3/jquery-ui.js'?>"></script>
        <script src="<?php echo BASE_URL . '/assets/js/events.js'?>"></script>

    </head>

    <body>
        <?php
            if (!isset($_SESSION['id']))
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
                        <h1> EVENT LIST </h1>
                        <p> Browse and select an event for further actions </p>
                    
                        <!-- DISPLAY SUCCESS MESSAGE -->
                        <?php if(isset($_SESSION['message'])) {
                            include("app/includes/successMessage.php");
                            unset($_SESSION['message']);
                        }
                        ?>
                    </section>
                </article>

                <div class="search-form">
                    <div class="search-container">
                        <select name="eventType">
                            <option value="all" > All Events</option>
                            <option value="upcoming" >Upcoming Events</option>
                            <option value="finished" >Finished Events</option>
                            <?php if($_SESSION['role'] === 'Volunteer'): ?>    
                                <option value="joined" <?php if (isset($select_joined)) { echo 'selected'; } ?>>Joined Events</option>
                            <?php endif; ?>
                        </select>
                        <div class="search-event">
                            <input type="text" name="searchEvent" value="<?php echo isset($search) ? $search : ''; ?>">
                            <img src="https://img.icons8.com/?size=100&id=59878&format=png&color=000000">
                        </div>
                    </div>
                </div>

                <article id="search-empty" style="display: none;">
                    <section>
                        <p style="margin-bottom: 10rem;">No results can be found.</p>
                    </section>
                </article>

                <article class="event-container">
                    <?php foreach ( $rows as $index => $event ): ?>
                        <button onclick="location.href='<?php echo BASE_URL . '/events/post.php?id=' . $event['EVENT_ID']; ?>'" type="button" <?php if($event['EVENT_DATE'] < $currDate) { echo "disabled"; } ?>>
                            <div class="event-1">
                                <div class="title-address">
                                    <h1><?php echo $event['EVENT_NAME'] ?></h1>
                                    <div>
                                        <p><?php echo $event['EVENT_ADDRESS'] ?></p>
                                        <img src="<?php echo BASE_URL . '/assets/images/map_logo.png'; ?>">
                                    </div>
                                </div>
                                <div class="goal-datetime">
                                    <div class="goal">
                                        <div>
                                            <p>Volunteer</p>
                                            <h2><?php echo $event['VOL_AMOUNT'] ?> of <?php echo $event['VOL_GOAL'] ?></h2>
                                        </div>
                                        <div>
                                            <p>Money</p>
                                            <div class="progress-bar">
                                                <div style="width: <?php echo $event['MONEY_AMOUNT'] / $event['MONEY_GOAL'] * 100  ?>%" class="curr-progress"></div>
                                            </div>
                                        </div>
                                        <div>
                                            <p>Food</p>
                                            <div class="progress-bar">
                                                <div style="width: <?php echo foodCurrProgress($event['EVENT_ID']); ?>%" class="curr-progress"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="time">
                                        <div> <p><?php echo date('F d', strtotime($event['EVENT_DATE'])); ?></p> </div>
                                        <div> <p><?php echo date("h:i A", strtotime($event['EVENT_TIME'])); ?></p> </div>
                                        <?php if (isset($_SESSION['joined_event']) && in_array($event['EVENT_ID'], $_SESSION['joined_event'])): ?>
                                            <div class="color-div"> <p> Joined </p> </div>
                                        <?php endif; ?>
                                        <?php if (isset($event['REQ_ID'])): ?>
                                            <div class="color-div"> <p> Partnered </p> </div>
                                        <?php endif; ?>
                                        <?php if($event['EVENT_DATE'] < $currDate): ?>
                                            <div class="color-div"> <p> Ended </p> </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </button>
                    <?php endforeach; ?>
                </article> 

            </main>
        </div>

        <!-- FOOTER -->
        <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>
    </body>
</html>