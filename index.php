<?php include("path.php"); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Food4U | Homepage</title>

        <!-- FONT & FONTAWESOME -->
        <link rel="stylesheet" href="assets/css/index.css">
        <link rel="stylesheet" href="assets/css/message.css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- JQUERY SCRIPTS -->
        <script src='assets/js/jquery-3.7.1.js'></script>
        <script src='assets/js/jquery-ui-1.13.3/jquery-ui.js'></script>
    </head>

    <body>
        <?php include("app/controllers/userAccount.php") ?>
        
        <!-- HEADER -->
        <?php include("app/includes/header.php"); ?>

        <div class="nav-main">

            <?php if(isset($_SESSION['id'])) {
                include("app/includes/nav.php");
            } ?>

            <!-- MAIN -->
            <main <?php if(!isset($_SESSION['id'])) { echo "style='padding: 4.5rem 10vw !important;'"; } ?>>

                <!-- DISPLAY SUCCESS MESSAGE -->
                <?php if(isset($_SESSION['message'])) {
                    include("app/includes/successMessage.php");
                    unset($_SESSION['message']);
                }
                ?>

                <!-- MAIN SECTION -->
                <div class="main-section-bg">
                    <section class="main-section">
                        <div class="main-section-1">
                            <h2> Be the change. Help others. </h2>
                            <h1 class="anim-text"> The Food4U Project </h1>
                            <p> We wish to alleviate the suffering of the homeless and poor 
                                of Kuala Lumpur by using social media as a platform where the 
                                public could contribute through donation, volunteering or 
                                sharing information about struggling community. </p>
                            <div>
                                <?php if(!isset($_SESSION['id'])): ?>
                                    <button class="register">
                                        <a href="register.php">JOIN OUR TEAM</a>
                                    </button>
                                    <button class="login">
                                        <a class="type-site" href="login.php">Already have an account?
                                            <span class="under-text"></span>
                                        </a>
                                    </button>
                                <?php else: ?>
                                    <button class="register">
                                        <a href="events.php">JOIN AN EVENT</a>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="main-section-2">
                            <img src="assets/images/banner-image.png">
                        </div>
                    </section>
                </div>

                <!-- ABOUT US SECTION -->
                <section id="aboutus">
                    <div class="section-title">
                        <h2>About Us</h2>
                        <p>Learn about our project and missions</p>
                    </div>
                    <div class="aboutus">
                        <div>
                            <h2>Founded in 2015.</h2>
                            <p>The Food4U Project humble beginnings can be traced back to 2015 where Uncle Tony 
                                started a soup kitchen out of his own kitchen, pooling whatever resources he could
                                gather with the assistance of his family and friends. One of Food4U’s earliest 
                                contributions began with Uncle Tony distributing bread and water to a crowd of
                                80 people in the city center of Kuala Lumpur. As word spread and the demand for
                                assistance outgrew his capacity, Uncle Tony enlisted the help of volunteers and 
                                expanded the operations of The Food4U Project to meet the growing need. Today, 
                                the project has seen itself with a team of 15 individuals and it can serve up to 
                                300 people with hot food, fresh fruits and vegetables, drinks, and other necessities.</p>
                        </div>
                        <img src="assets/images/food4u_mainpage1.png">
                    </div>
                    <div class="aboutus">
                        <img src="assets/images/food4u_mainpage2.jpg">
                        <div>
                            <h2>Moving forward.</h2>
                            <p>As The Food4U Project grows, our commitment to helping
                               the underprivileged remains strong. We aim to expand our 
                               reach beyond Kuala Lumpur to serve more communities across 
                               Malaysia. Our future plans include increasing our volunteer 
                               base, partnering with local and international organizations 
                               for sustainable food sources, and educating the public on 
                               nutrition and food security. With continued support from 
                               donors, volunteers, and the community, we are dedicated to 
                               ensuring no one has to sleep hungry. Join us in our mission 
                               to create a hunger-free future for all.</p>
                        </div>
                    </div>
                </section>

                <!-- OPERATIONS SECTION -->
                <section id="operations">
                    <div class="section-title">
                        <h2>What We Do</h2>
                        <p>Learn about our food bank operations</p>
                    </div>
                    <div class="card-container">
                        <article>
                            <h4>Food Distribution</h4>
                            <p>The Food4U Project provides hot meals, fresh fruits, and vegetables to those in need at various locations across Malaysia.</p>
                        </article>
                        <article>
                            <h4>Community Outreach</h4>
                            <p>We actively engage with local communities to identify and support individuals and families struggling with food insecurity.</p>
                        </article>
                        <article>
                            <h4>Scheduled Activities</h4>
                            <p>Our team organizes regular food distribution schedules, ensuring consistent support to different areas.</p>
                        </article>
                        <article>
                            <h4>Volunteer Coordination</h4>
                            <p>We enlist and manage volunteers who assist in meal preparation, distribution, and outreach activities, maximizing our impact.</p>
                        </article>
                        <article>
                            <h4>Partnerships</h4>
                            <p>We collaborate with local businesses, non-profits, and international organizations to secure sustainable food sources and funding.</p>
                        </article>
                        <article>
                            <h4>Awareness Campaigns</h4>
                            <p>We utilize social media to raise awareness about food insecurity and encourage community involvement through donations and volunteering.</p>
                        </article>  
                    </div>
                    
                </section>

                <!-- TEAM SECTION -->
                <section id="team">
                    <div class="section-title">
                        <h2>Our Team</h2>
                        <p>Meet the people behind the project</p>
                    </div>
                    <div class="card-container">
                        <article>
                            <div class="profile-container">
                                <img src="https://cdn.uitm.edu.my/gambar_warga/04c73392eee546b7cc24bfc1db628485.png">
                            </div>
                            <p> Muhammad Firdaus bin Mohd Razi <br>(2022858632) </p>
                            <h2> Team Manager </h2>
                            <div class="team-details">
                                <p>CDCS110</p>
                                <p>JCDCS1104E</p>
                                <p>firdausrazi04@gmail.com</p>
                            </div>
                        </article>
                        <article>
                            <div class="profile-container">
                                <img src="https://cdn.uitm.edu.my/gambar_warga/08c644237021cb7ddb4b7446f4abdc70.png">
                            </div>
                            <p> Amer Syafiq bin Abdul Razak <br>(2022613716)</p>
                            <h2> Database Designer & Programmer </h2>
                            <div class="team-details">
                                <p>CDCS110</p>
                                <p>JCDCS1104E</p>
                                <p>amersyafiq1103@gmail.com</p>
                            </div>
                        </article>
                        <article>
                            <div class="profile-container">
                                <img src="https://cdn.uitm.edu.my/gambar_warga/7f178628e40f4562d7b080a01cd31c94.png">
                            </div>
                            <p> Amer Nafis bin Abdul Razak <br>(2022613408) </p>
                            <h2> UI/UX & Programmer </h2>
                            <div class="team-details">
                                <p>CDCS110</p>
                                <p>JCDCS1104E</p>
                                <p>amernafis1103@gmail.com</p>
                            </div>
                        </article>
                    </div>
                </section>
            </main>

        </div>


        <!-- FOOTER -->
        <?php include("app/includes/footer.php"); ?>
    </body>
</html>