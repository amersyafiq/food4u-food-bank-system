<?php include("../path.php"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Food4U Homepage</title>

        <!-- FONT & FONTAWESOME -->
        <link rel="stylesheet" href="<?php echo BASE_URL. '/assets/css/create_edit.css' ?> ">
        <link rel="stylesheet" href="<?php echo BASE_URL. '/assets/css/message.css' ?> ">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- JQUERY SCRIPTS -->
        <script src="<?php echo BASE_URL. '/assets/js/jquery-3.7.1.js'?>"></script>
        <script src="<?php echo BASE_URL. '/assets/js/jquery-ui-1.13.3/jquery-ui.js'?>"></script>
        <script src="<?php echo BASE_URL. '/assets/js/edit.js'?>"></script>

    </head>

    <body>
        <?php
            if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'Administrator')
            {
                header("Location:" . BASE_URL . "/index.php");
                die();
            } 
        ?>
        <?php include(ROOT_PATH . "/app/controllers/eventPost.php") ?>
        <?php include(ROOT_PATH . "/app/controllers/eventEdit.php") ?>

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
                        <button onclick="location.href='<?php echo BASE_URL . '/dashboard.php'?>'" type="button">
                            ◄
                            <h1> RETURN </h1>
                        </button>
                    </section>
                    <section>
                        <h1> EDIT EVENT </h1>
                        <p> Edit and update the selected event information </p>
                    
                        <!--DISPLAY ERROR MESSAGE-->
                        <?php include(ROOT_PATH . "/app/includes/errorMessage.php"); ?>
                    
                    </section>
                </article>
                

                <form action="<?php echo BASE_URL . '/events/edit.php?id=' . $id ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id ?>"/>
                    <article>
                        <section class="section-title">
                            <p> SECTION 1 </p>
                            <h1> EVENT INFORMATION </h1>
                        </section>
                        <section class="section-input">
                            <div>
                                <p>Event Name</p>
                                <input maxlength="255" type="text" name="name" value="<?php echo $name ?>"/>
                            </div>
                            <div>
                                <p>Event Address</p>
                                <textarea maxlength="255" type="text" name="address"><?php echo $address ?></textarea>
                            </div>
                            <div class="multi-field">
                                <div>
                                    <p>Event Date</p>
                                    <input type="date" name="date" value="<?php echo $date ?>"/>
                                </div>
                                <div>
                                    <p>Event Time</p>
                                    <input type="time" name="time" value="<?php echo $time ?>"/>
                                </div>
                            </div>
                        </section>
                    </article>

                    <article>
                        <section class="section-title">
                            <p> SECTION 2 </p>
                            <h1> EVENT DESCRIPTION </h1>
                        </section>
                        <section class="section-input">
                            <div>
                                <p>Brief Description of the Event</p>
                                <textarea type="text" name="desc"><?php echo $desc ?></textarea>
                            </div>
                            <div>
                                <img id="preview-edit" src="<?php echo BASE_URL . "/" . $image?>" />
                            </div>
                        </section>
                    </article>

                    <article>
                        <section class="section-title">
                            <p> SECTION 3 </p>
                            <h1> SET EVENT GOALS </h1>
                        </section>
                        <section class="section-input">
                            <div class="multi-field">
                                <div>
                                    <p>Volunteer Goals</p>
                                    <input type="number" name="vol" value="<?php echo $vol_goal ?>"/>
                                </div>
                                <div>
                                    <p>Money Donation Goals</p>
                                    <input type="number" name="money" value="<?php echo $money_goal ?>"/>
                                </div>
                            </div>
                            <input type="hidden" name="admin_id" value="<?php echo $admin_id ?>"/>
                            <div>
                                <p>Current Food Donation Goals</p>
                                <table>
                                    <thead>
                                        <tr class='tr-3'>
                                            <th>No.</th><th> Food Donation </th><th> Goal (PAX) </th><th> Current (PAX) </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (count($foodArr) > 0) {
                                                foreach ($foodArr as $index => $food) {
                                                    echo "<tr class='tr-3'>
                                                        <input maxlength='50' type='hidden' name='food[$index][id]' value='" . $food['FOOD_ID'] . "'>
                                                        <td>" . ($index + 1) . ".</td>
                                                        <td><input maxlength='50' type='text' name='food[$index][name]' value='" . $food['FOOD_TYPE'] . "' placeholder=' Enter Food Name '/></td>
                                                        <td><input type='number' name='food[$index][goal]' value='" . $food['FOOD_GOAL'] . "' placeholder=' Enter Amount '/></td>
                                                        <td><input type='number' name='food[$index][amount]' value='" . $food['FOOD_AMOUNT'] . "' placeholder=' Enter Amount '/></td>
                                                    </tr>";
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div>
                                <p>Add New Food Donation Goals</p>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>No.</th><th> Food Donation </th><th> Amount (PAX) </th>
                                        </tr>
                                    </thead>
                                    <tbody id="food-append">
                                        
                                    </tbody>
                                </table>
                                <div id="food-btn">
                                    <button id="add-btn"> Add More </button>
                                </div>
                            </div>

                        </section>
                    </article>

                    <article>
                        <section class="section-title">
                            <p> SECTION 4 </p>
                            <h1> ADDITIONAL INFORMATION </h1>
                        </section>
                        <section class="section-input">
                            <div>
                                <p>Current Drop-Off Address</p>
                                <table>
                                    <thead>
                                        <tr class="tr-2">
                                            <th>No.</th><th> Address </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (count($dropoffArr) > 0) {
                                                foreach ($dropoffArr as $index => $addr) {
                                                    echo "<tr class='tr-2'>
                                                            <input type='hidden' name='dropoff[$index][id]' value='$addr[DROPOFF_ID]'>
                                                            <td>" . ($index + 1) . "</td>
                                                            <td><input maxlength='' type='text' name='dropoff[$index][address]' value='$addr[DROPOFF_ADD]' placeholder=' Enter Drop-Off Address '/></td>
                                                          </tr>";
                                                }
                                            } 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <p>Add New Drop-Off Address</p>
                                <table>
                                    <thead>
                                        <tr class="tr-2">
                                            <th>No.</th><th> Address </th>
                                        </tr>
                                    </thead>
                                    <tbody id="addr-append">
                                        
                                    </tbody>
                                </table>
                                <div id="food-btn">
                                    <button id="add-btn2"> Add More </button>
                                </div>
                            </div>

                        </section>
                    </article>

                    <button type="submit" name="update">UPDATE</button>
                </form>
            </main>
        </div>

        <!-- FOOTER -->
        <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>
    </body>
</html>