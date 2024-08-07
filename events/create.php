<?php include("../path.php"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Food4U | Schedule Event</title>

        <!-- FONT & FONTAWESOME -->
        <link rel="stylesheet" href="<?php echo BASE_URL. '/assets/css/create_edit.css' ?> ">
        <link rel="stylesheet" href="<?php echo BASE_URL. '/assets/css/message.css' ?> ">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- JQUERY SCRIPTS -->
        <script src="<?php echo BASE_URL. '/assets/js/jquery-3.7.1.js'?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/jquery-ui.min.js"></script>
        <script src="<?php echo BASE_URL. '/assets/js/create.js'?>"></script>

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
        <?php include(ROOT_PATH . "/app/controllers/eventCreate.php") ?>

        <!-- HEADER -->
        <?php include(ROOT_PATH . "/app/includes/header.php"); ?>

        <div class="nav-main">

            <?php if(isset($_SESSION['id'])) {
                include(ROOT_PATH . "/app/includes/nav.php");
            } ?>

            <!-- MAIN -->
            <main>
                <article>
                    <?php if(isset($_GET['req-id'])): ?>
                        <section>
                            <button onclick="location.href='<?php echo BASE_URL . '/events/create.php'?>'" type="button">
                                ◄
                                <h1> RETURN </h1>
                            </button>
                        </section>
                    <?php endif; ?>
                    <section>
                        <h1> SCHEDULE EVENT </h1>
                        <p> Create or select an event recommended by users </p>
                    
                        <!--DISPLAY ERROR MESSAGE-->
                        <?php include(ROOT_PATH . "/app/includes/errorMessage.php"); ?>
                    
                        <!-- DISPLAY SUCCESS MESSAGE -->
                        <?php if(isset($_SESSION['message'])) {
                            include(ROOT_PATH . "/app/includes/successMessage.php");
                            unset($_SESSION['message']);
                        }
                        ?>

                    </section>
                </article>

                <article style="width: 100% !important; display: flex; justify-content: flex-end;">
                    <section style="width: 100%; display: flex; justify-content: flex-end;">
                        <button type="button" class="view-request">
                            <img style="width: 40px; height: 40px;" src="<?php echo BASE_URL . '/assets/images/create_logo.png' ?>">
                            <h1> VIEW REQUEST </h1>
                        </button>
                    </section>
                    <form action="create.php" method="post" style="margin: 0;">
                        <section class="display-request">
                            <div class="accordion">
                                <?php foreach ($requests as $request): ?>
                                    <h2 class="accordion-header">
                                        <?php if($request['PARTNERSHIP']): ?>
                                            <div class='partner-small'>&nbsp</div>
                                            <div class='partner-big'>PARTNERED</div>
                                        <?php endif; ?>
                                        <p><?php echo $request['REQ_NAME'] ?></p>
                                        <img src="<?php echo BASE_URL . "/assets/images/down_arrow.png" ?>">
                                    </h2>
                                    <div class="accordion-content">
                                        <table class="accordion-content-table">
                                            <tr>
                                                <th>DESCRIPTION</th>
                                                <td><?php echo $request['REQ_DESC'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>ADDRESS</th>
                                                <td><?php echo $request['REQ_ADDRESS'] ?></td>
                                            </tr>
                                            <tr>
                                                <th>PHOTO</th>
                                                <td><img src="<?php echo BASE_URL . '/' . $request['REQ_IMAGE'] ?>"></td>
                                            </tr>
                                            <tr>
                                                <th>RECIPIENTS</th>
                                                <td>
                                                    Number of Recipients - <?php echo $request['REQ_RECPTNUM'] ?>
                                                    <br>Assistance Required - <?php echo $request['REQ_ASSISTANCE'] ?></br>
                                                </td>
                                            </tr>
                                            <?php if($request['PARTNERSHIP']): ?>
                                                <tr>
                                                    <th>CONTRIBUTION</th>
                                                    <td><?php echo $request['CONTRIBUTION'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th>REQUIREMENT</th>
                                                    <td><?php echo $request['REQUIREMENTS'] ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        </table>
                                        <div class="accordion-buttons">
                                            <input type="hidden" name="delete-req-image" value="<?php echo $request['REQ_IMAGE'] ?>">
                                            <input type="hidden" name="delete-req-id" value="<?php echo $request['ID'] ?>">
                                            <input type="hidden" name="delete-req-partnership" value="<?php echo $request['PARTNERSHIP'] ?>">
                                            <button onclick="location.href='<?php echo BASE_URL . '/events/create.php?req-id=' . $request['ID']; ?>'" type="button">ACCEPT</button>
                                            <button type="submit" name="discard">DISCARD</button>
                                        </div>
                                        <div class="accordion-content-profile">
                                            <img src="<?php echo BASE_URL . '/' . $request['USER_IMAGE'] ?>">
                                            <div>
                                                <h2> <?php echo $request['USER_NAME'] ?> </h2>
                                                <div>
                                                    <?php if (!empty($request['USER_DESC'])): ?>
                                                        <p><?php echo $request['USER_DESC'] ?></p>
                                                    <?php endif; ?>
                                                    <span><?php echo date('d M Y', strtotime($request['REQ_DATE'])) ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>                     
                            </div>
                        </section>
                    </form>
                </article>
                
            <?php if(isset($_GET['req-id'])): ?>
                <form action="<?php echo BASE_URL . '/events/create.php?req-id=' . $req_id ?>" method="post" enctype="multipart/form-data">
            <?php else: ?>
                <form action="<?php echo BASE_URL . '/events/create.php'?>" method="post" enctype="multipart/form-data">
            <?php endif; ?>
                    <article>
                        <section class="section-title">
                            <p> SECTION 1 </p>
                            <h1> EVENT INFORMATION </h1>
                        </section>
                        <section class="section-input">
                            <div>
                                <p>Event Name</p>
                                <input maxlength="255" type="text" name="name" value="<?php echo $name ?>" placeholder="Enter the name of the event"/>
                            </div>
                            <div>
                                <p>Event Address</p>
                                <textarea maxlength="255" type="text" name="address" placeholder="Enter the address or venue of the event"><?php echo $address ?></textarea>
                            </div>
                            <div class="multi-field">
                                <div>
                                    <p>Event Date</p>
                                    <input type="date" name="date" value="<?php echo $date ?>" placeholder="Select the event date"/>
                                </div>
                                <div>
                                    <p>Event Time</p>
                                    <input type="time" name="time" value="<?php echo $time ?>" placeholder="Select the event time"/>
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
                                <textarea type="text" name="desc" placeholder="Provide a brief overview of the event, including its purpose and key activities"><?php echo $desc ?></textarea>
                            </div>
                            
                            <?php if(isset($_GET['req-id'])): ?>
                                <div>
                                    <input type="hidden" name="image" value="<?php echo $image ?>"/>
                                    <p>Event Photo</p>
                                    <img id="preview-edit" src="<?php echo BASE_URL . "/" . $image?>" />
                                </div>
                            <?php else: ?>
                                <div class="multi-field">
                                    <div>
                                        <p>Event Photo</p>
                                        <input type="file" name="image" accept="image/*" placeholder="Upload an event photo"/>
                                    </div>
                                    <div id="resize">
                                        <p>Image Preview</p>
                                        <img id="preview" src="" style="display: none;" />
                                    </div>
                                </div>
                            <?php endif; ?>
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
                                    <input type="number" name="vol" value="<?php echo $vol_goal ?>" placeholder="Enter the number of volunteers needed"/>
                                </div>
                                <div>
                                    <p>Money Donation Goals</p>
                                    <input type="number" name="money" value="<?php echo $money_goal ?>" placeholder="Enter the target amount for money donations"/>
                                </div>
                            </div>
                            <div>
                                <p>Food Donation Goals</p>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>No.</th><th> Food Donation </th><th> Amount (PAX) </th>
                                        </tr>
                                    </thead>
                                    <tbody id="food-append">
                                        <?php
                                            if (count($foodArr) > 0) {
                                                foreach ($foodArr as $index => $food) {
                                                    echo "<tr>
                                                        <td>" . ($index + 1) . ".</td>
                                                        <td><input maxlength='50' type='text' name='food[$index][name]' value='" . htmlspecialchars($food['name']) . "' placeholder='Enter Food Name'/></td>
                                                        <td><input type='number' name='food[$index][amount]' value='" . htmlspecialchars($food['amount']) . "' placeholder='Enter Amount'/></td>
                                                    </tr>";
                                                }
                                            } else {
                                                echo "<tr>
                                                    <td>1.</td>
                                                    <td><input maxlength='50' type='text' name='food[0][name]' placeholder='Enter Food Name'/></td>
                                                    <td><input type='number' name='food[0][amount]' placeholder='Enter Amount'/></td>
                                                </tr>";
                                            }
                                        ?>
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
                                <p>Drop-Off Address</p>
                                <table>
                                    <thead>
                                        <tr class="tr-2">
                                            <th>No.</th><th> Address </th>
                                        </tr>
                                    </thead>
                                    <tbody id="addr-append">
                                        <?php
                                            if (count($dropoffArr) > 0) {
                                                foreach ($dropoffArr as $index => $addr) {
                                                    echo "<tr class='tr-2'>
                                                            <td>" . ($index + 1) . "</td>
                                                            <td><input maxlength='255' type='text' name='dropoff[]' value='" . htmlspecialchars($addr) . "' placeholder='Enter Drop-Off Address'/></td>
                                                        </tr>";
                                                }
                                            } 
                                            else {
                                                echo "<tr class='tr-2'>
                                                    <td>1.</td>
                                                    <td><input maxlength='255' type='text' name='dropoff[0]' placeholder='Enter Drop-Off Address'/></td>
                                                </tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <div id="food-btn">
                                    <button id="add-btn2"> Add More </button>
                                </div>
                            </div>
                        </section>
                    </article>
                    <?php if(isset($_GET['req-id'])): ?>
                        <input type="hidden" name="req_id" value="<?php echo $req_id ?>"/>
                    <?php endif; ?>
                    <button type="submit" name="create">CREATE</button>
                </form>
            </main>
        </div>

        <!-- FOOTER -->
        <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>
    </body>
</html>