<?php include("../path.php"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Food4U | Events Post</title>

        <!-- FONT & FONTAWESOME -->
        <link rel="stylesheet" href="<?php echo BASE_URL. '/assets/css/post.css' ?> ">
        <link rel="stylesheet" href="<?php echo BASE_URL. '/assets/css/message.css' ?> ">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- JQUERY SCRIPTS -->
        <script src="<?php echo BASE_URL. '/assets/js/jquery-3.7.1.js'?>"></script>
        <script src="<?php echo BASE_URL. '/assets/js/jquery-ui-1.13.3/jquery-ui.js'?>"></script>
        <script src="<?php echo BASE_URL . '/assets/js/post.js'?>"></script>

    </head>

    <body>
        <?php
            if (!isset($_SESSION['id']))
            {
                header("Location:" . BASE_URL . "/index.php");
                die();
            }
        ?>
        <?php include(ROOT_PATH . "/app/controllers/eventPost.php") ?>
        <?php include(ROOT_PATH . "/app/controllers/eventActivity.php") ?>

        <!-- HEADER -->
        <?php include(ROOT_PATH . "/app/includes/header.php"); ?>

        <div class="nav-main">

            <?php if(isset($_SESSION['id'])) {
                include(ROOT_PATH . "/app/includes/nav.php");
            } ?>

            <!-- MAIN -->
            <main>
                <article class="return-btn">
                    <section>
                    <?php if(!($_SESSION['role'] === 'Administrator')): ?>
                        <button onclick="location.href='<?php echo BASE_URL . '/events.php'?>'" type="button">
                    <?php else: ?>
                        <button onclick="location.href='<?php echo BASE_URL . '/dashboard.php'?>'" type="button">
                    <?php endif; ?>    
                            ◄
                            <h1> RETURN </h1>
                        </button>
                    </section>

                    <!--DISPLAY ERROR MESSAGE-->
                     <?php include(ROOT_PATH . "/app/includes/errorMessage.php"); ?>

                     <!--DISPLAY SUCCESS MESSAGE -->
                     <?php if(isset($_SESSION['message'])) {
                            include(ROOT_PATH . "/app/includes/successMessage.php");
                            unset($_SESSION['message']);
                        }
                     ?>

                </article>

                <article>
                    <section>
                        <img src="<?php echo BASE_URL . "/" . $image ?>">
                    </section>
                    <section>
                        <h1><?php echo $name; ?></h1>
                        <p><?php echo $desc; ?></p>
                    </section>
                    <section class="multi-field">
                        <div class="time">
                            <div> <p><?php echo date('F d', strtotime($date)); ?></p> </div>
                            <div> <p><?php echo date("h:i A", strtotime($time)); ?></p> </div>
                        </div>
                        <div class="address">
                            <p><?php echo $address ?></p>
                            <img src="<?php echo BASE_URL . '/assets/images/map_logo.png'; ?>">
                        </div>
                    </section>
                    <?php if (isset($req_id)): ?>
                        <section>
                            <h2>Requested by</h2>
                            <div class="accordion-content-profile">
                                <img src="<?php echo BASE_URL . '/' . $user_image ?>">
                                <div>
                                    <h2> <?php echo $user_name ?> </h2>
                                    <div>
                                        <?php if (!empty($user_desc)): ?>
                                            <p><?php echo $user_desc?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>
                </article>

                <form>
                    <section class="donation">
                        <h2> MAKE DONATION </h2>
                        <p> Select one of the options below to make a donation </p>
                    </section>
                    <section class="donation-items">
                        <div>
                            <button class="donation-container money-type" type="button"
                            <?php if ($_SESSION['role'] !== 'Volunteer') { echo 'disabled'; } ?>>
                                <div>
                                    <p><span class="color-goal">RM <?php echo $money_amount ?></span> / RM<?php echo $money_goal ?></p>
                                    <div class="progress-bar">
                                        <div style="width: <?php echo (($money_amount / $money_goal) * 100) ?>%" class="curr-progress"></div>
                                    </div>
                                </div>
                                <div>
                                    <h2>Money</h2>
                                </div>
                            </button>

                            <?php foreach ($foodArr as $index => $food): ?>
                                <button data-food-id="<?php echo $food['FOOD_ID']; ?>" 
                                        data-food-name="<?php echo $food['FOOD_TYPE']; ?>"  
                                        data-food-goal="<?php echo $food['FOOD_GOAL']; ?>"
                                        data-food-amount="<?php echo $food['FOOD_AMOUNT']; ?>"
                                        class="donation-container food-type" type="button"
                                        <?php if ($_SESSION['role'] !== 'Volunteer') { echo 'disabled'; } ?>>
                                    <div>
                                        <p><span class="color-goal"><?php echo $food['FOOD_AMOUNT'] ?></span> / <?php echo $food['FOOD_GOAL'] ?> PAX</p>
                                        <div class="progress-bar">
                                            <?php $progressWidth = ($food['FOOD_AMOUNT'] / $food['FOOD_GOAL']) * 100;
                                                  $remainingWidth = 100 - $progressWidth; ?>
                                            <div style="width: <?php echo $progressWidth ?>%" class="curr-progress"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <h2><?php echo $food['FOOD_TYPE'] ?></h2>
                                    </div>
                                </button>
                            <?php endforeach; ?>

                            <?php if($_SESSION['role'] === 'Organization'): ?>
                                <button class="donation-container bulk-type" type="button">
                                    <div>
                                        <h2>SPONSOR THIS EVENT</h2>
                                    </div>
                                </button>
                            <?php endif; ?>

                        </div>
                    </section>
                </form>

                <form action="<?php echo BASE_URL . '/events/post.php?id=' . $id; ?>" method="post" style="margin-bottom: 3rem" enctype="multipart/form-data">
                    <div class="popup food-donation">
                        <div>
                            <div class="btn">
                                <img class="popup-close" src="<?php echo BASE_URL . "/assets/images/X_logo.png"; ?>">
                            </div>
                            <div>
                                <h1>FOOD DONATION PANEL</h1>
                                <p>Choose one of the drop-off addresses and send your contribution there. </p>
                                <p>Submission of this form will notify staff of your donation. </p>
                            </div>
                            <h3> Donation Item </h3>
                            <div class="donation-qty">
                                <p></p>
                            </div>
                            <h3> Choose drop-off address </h3>
                            <input type="hidden" name="foodId" value="">
                            <input type="hidden" name="foodGoal" value="">
                            <input type="hidden" name="foodAmount" value="">
                            <div class="dropoff-address">
                                <?php foreach($dropoffArr as $index => $dropoff): ?>
                                    <div>
                                        <input type="radio" name="donateAddr" value="<?php echo $dropoff['DROPOFF_ADD'] ?>">
                                        <p> <?php echo $dropoff['DROPOFF_ADD'] ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <h3> Enter the quantity of your contribution </h3>
                            <div class="donation-qty">
                                <input type="number" name="donateAmount1">
                                PAX
                            </div>
                            <div class="popup-btn">
                                <button type="submit" name="food-donate" > SUBMIT </button>
                            </div>
                        </div>
                    </div>

                    <div class="popup money-donation">
                        <div>
                            <div class="btn">
                                <img class="popup-close" src="<?php echo BASE_URL . "/assets/images/X_logo.png"; ?>">
                            </div>
                            <div>
                                <h1>MONEY DONATION PANEL</h1>
                                <p>Scan the QR code and send your monetary contribution through online payment. </p>
                                <p>Submission of this form will notify staff of your donation. </p>
                                <div class="qr-code">
                                    <img src="<?php echo BASE_URL . '/assets\images\MONEY_QR.jpg' ?>">
                                </div>
                            </div>
                            <h3> Upload QR Payment Proof </h3>
                            <div class="donation-qty">
                                <input type="file" name="image" accept="image/*"/>
                            </div>
                            <h3> Enter Donation Amount </h3>
                            <input type="hidden" name="moneyGoal" value="<?php echo $money_goal ?>">
                            <input type="hidden" name="moneyAmount" value="<?php echo $money_amount ?>">
                            <div class="donation-qty">
                                RM <input type="number" name="donateAmount2">
                            </div>
                            <div class="popup-btn">
                                <button type="submit" name="money-donate"> SUBMIT </button>
                            </div>
                        </div>
                    </div>

                    <div class="popup bulk-donation">
                        <div style="width: <?php if ($_SESSION['role'] === 'Administrator') { echo 60; } ?>%">
                            <div class="btn">
                                <img class="popup-close" src="<?php echo BASE_URL . "/assets/images/X_logo.png"; ?>">
                            </div>
                            <?php if($_SESSION['role'] === 'Organization'): ?>
                                <div>
                                    <h1>SPONSOR PANEL</h1>
                                    <p>If your organization is interested in sponsoring this event, please submit the form below. </p>
                                    <p>We will get right back to you in due time. </p>
                                </div>
                                <h3> How would you like to send your contribution?  </h3>
                                <input type="hidden" name="moneyGoal" value="<?php echo $money_goal ?>">
                                <input type="hidden" name="moneyAmount" value="<?php echo $money_amount ?>">
                                <div class="donation-qty">
                                    <select name="option">
                                        <option selected="selected"> Select method </option>
                                        <option value="dropoff">Drop-off at our address</option>
                                        <option value="pickup">Pick-up at your address</option>
                                    </select>
                                </div>
                                <h3 id="sponsor-method-text"></h3>
                                <div class="dropoff-address dropoff-method">
                                    <?php foreach($dropoffArr as $index => $dropoff): ?>
                                        <div>
                                            <input type="radio" name="dropoffId" value="<?php echo $dropoff['DROPOFF_ID'] ?>">
                                            <p> <?php echo $dropoff['DROPOFF_ADD'] ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="donation-qty pickup-method">
                                    <textarea maxlength="255" type="text" name="pickupAddress"></textarea>
                                </div>
                                <div class="popup-btn">
                                    <button type="submit" name="sponsor-donate"> SUBMIT </button>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                
                    <section class="donation">
                        <h2> VOLUNTEER </h2>
                        <p> Participate in this event as volunteer </p>
                    </section>
                    <section class="donation-items">
                        <div>
                            <button type="button" class="donation-container">
                                <div>
                                    <p><span class="color-goal"><?php echo $vol_amount ?></span> / <?php echo $vol_goal ?> VOLUNTEER</p>
                                    <div class="progress-bar">
                                        <div style="width: <?php echo (($vol_amount / $vol_goal) * 100) ?>%" class="curr-progress"></div>
                                    </div>
                                </div>
                                <div>
                                    <h2>Volunteer</h2>
                                </div>
                            </button>

                            <?php if(isset($_SESSION['joined_event']) && !in_array($id, $_SESSION['joined_event'])): ?>
                                <input type="hidden" name="vol-id" value="<?php echo $_SESSION['id'] ?>">
                                <button class="donation-container volunteer-type" type="submit" name="vol-join-btn">
                                    <div>
                                        <h2>VOLUNTEER THIS EVENT</h2>
                                    </div>
                                </button>
                            <?php elseif(isset($_SESSION['joined_event']) && in_array($id, $_SESSION['joined_event'])): ?>
                                <input type="hidden" name="vol-id" value="<?php echo $_SESSION['id'] ?>">
                                <button class="donation-container volunteer-type2" type="submit" name="vol-leave-btn">
                                    <div>
                                        <h2>LEAVE THIS EVENT</h2>
                                    </div>
                                </button>
                            <?php endif; ?>

                            <?php if((isset($_SESSION['joined_event']) && in_array($id, $_SESSION['joined_event']))): ?>
                                <?php foreach($volArr as $index => $vol): ?>
                                    <button type="button" class="donation-container vol-profile">
                                        <div class="vol-profile-img" >
                                            <img src="<?php echo BASE_URL . "/" . $vol['VOL_IMAGE'] ?>">
                                        </div>
                                        <div class="vol-name">
                                            <h2><?php echo $vol['VOL_NAME'] ?></h2>
                                        </div>
                                    </button>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if($_SESSION['role'] === 'Administrator'): ?>
                                <?php foreach($volArr as $index => $vol): ?>
                                    <button data-vol-name="<?php echo $vol['VOL_NAME']; ?>"
                                            data-vol-image="<?php echo BASE_URL . '/' . $vol['VOL_IMAGE']; ?>"
                                            data-vol-email="<?php echo $vol['VOL_EMAIL']; ?>"
                                            data-vol-phone="<?php echo $vol['VOL_PHONE']; ?>"
                                            type="button" class="donation-container vol-profile vol-card">
                                        <div class="vol-profile-img" >
                                            <img src="<?php echo BASE_URL . "/" . $vol['VOL_IMAGE'] ?>">
                                        </div>
                                        <div class="vol-name">
                                            <h2><?php echo $vol['VOL_NAME'] ?></h2>
                                        </div>
                                    </button>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </section>
                </form>

                <div class="popup vol-popup">
                    <div>
                        <div class="btn">
                            <img class="popup-close" src="<?php echo BASE_URL . "/assets/images/X_logo.png"; ?>">
                        </div>
                        <div>
                            <h1>VOLUNTEER PROFILE</h1>
                        </div>
                        <div class="vol-layout">
                            <div class="vol-image">
                                <img src="">
                            </div>
                            <div class="vol-layout-content">
                                <h3> Volunteer Name </h3>
                                <div class="vol-container vol-name">
                                    <p></p>
                                </div>
                                <h3> Volunteer Email </h3>
                                <div class="vol-container vol-email">
                                    <p></p>
                                </div>
                                <h3> Volunteer Phone Number </h3>
                                <div class="vol-container vol-phone">
                                    <p></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                
            </main>
        </div>

        

        <!-- FOOTER -->
        <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>
    </body>
</html>