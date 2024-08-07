<?php
    if(isset($_POST['food-donate'])) {
        if($_SESSION['role'] !== 'Volunteer') {
            array_push($errors, "Only volunteer can access this feature");
        }

        if (empty($_POST['donateAmount1'])) {
            array_push($errors, "The donation quantity field is empty");
        } else {
            if($_POST['donateAmount1'] > ($_POST['foodGoal'] - $_POST['foodAmount'])) {
                array_push($errors, "The donation quantity exceed the donation goal");
            }
            if ($_POST['donateAmount1'] < 0 ) {
                array_push($errors, "Invalid donation quantity");
            }
        }

        if(count($errors) === 0) {
            $food_donation_id = $_POST['foodId'];
            $food_donation_amount = $_POST['donateAmount1'];
            $donor_id = $_SESSION['id'];

            $sql = "INSERT INTO donation (DONATION_ID, EVENT_ID, DONATION_QTY, DONATION_STATUS, DONATION_DATE, MONEY_QR, VOL_ID, FOOD_ID) 
                    VALUES (NULL, '$id', '$food_donation_amount', 'pending', '$currDate', NULL, '$donor_id', '$food_donation_id')";
            $results = mysqli_query($mysqli, $sql);

            if($results) {
                $_SESSION['message'] = "Your pending contribution has been successfully submitted! Once our staff verify the donation at the selected drop-off address, the donation goal will be updated. ";
                header("location:" . BASE_URL . "/events/post.php?id=" . $id);
                exit();
            }
        }
    }

    if(isset($_POST['money-donate'])) {
        if($_SESSION['role'] !== 'Volunteer') {
            array_push($errors, "Only volunteer can access this feature");
        }
        
        if (empty($_POST['donateAmount2'])) {
            array_push($errors, "The donation quantity field is empty");
        } else {
            if($_POST['donateAmount2'] > ($_POST['moneyGoal'] - $_POST['moneyAmount'])) {
                array_push($errors, "The donation quantity exceed the donation goal");
            }
            if ($_POST['donateAmount2'] < 0 ) {
                array_push($errors, "Invalid donation quantity");
            }
        }

        if (!empty($_FILES['image']['name'])) {
            $img_name = time() . "_" . $_FILES['image']['name'];
            $dest = "assets/payment_proof/" . $img_name;
            $result = move_uploaded_file($_FILES['image']['tmp_name'], ROOT_PATH . "/" . $dest);

            if ($result) {
                $_POST['image'] = $dest;
            }
            else {
                array_push($errors, "Failed to upload image");
            }

        } else {
            array_push($errors, "Transaction proof field is empty.");
        }

        if(count($errors) === 0) {
            $image = $_POST['image'];
            $money_donation_amount = $_POST['donateAmount2'];
            $donor_id = $_SESSION['id'];

            $sql = "INSERT INTO donation (DONATION_ID, EVENT_ID, DONATION_QTY, DONATION_STATUS, DONATION_DATE, MONEY_QR, VOL_ID, FOOD_ID) 
                    VALUES (NULL, '$id', '$money_donation_amount', 'pending', '$currDate', '$image', '$donor_id', NULL)";
            $results = mysqli_query($mysqli, $sql);

            if($results) {
                $_SESSION['message'] = "Your pending contribution has been successfully submitted! Once our staff verify the money transaction, the donation goal will be updated. ";
                header("location:" . BASE_URL . "/events/post.php?id=" . $id);
                exit();
            }

        } else {
            if(isset($_POST['image'])) {
                unlink(ROOT_PATH . '/' . $_POST['image']);
            }
        }
    }

    if(isset($_POST['sponsor-donate'])) {
        if (empty($_POST['option'])) {
            array_push($errors, "Please select a sponsor method");
        } else {
            if ($_POST['option'] === 'dropoff') {
                if (empty($_POST['dropoffId'])) {
                    array_push($errors, "One of the drop-off address must be selected");
                } 
            } else if ($_POST['option'] === 'pickup') {
                if (empty($_POST['pickupAddress'])) {
                    array_push($errors, "Pick-up address field is empty");
                } 
            } else {
                array_push($errors, "Please select a sponsor method");
            }
        }

        $org_id = $_SESSION['id'];
        $sql = "SELECT * FROM sponsor WHERE ORG_ID = '$org_id' AND EVENT_ID = '$id'";
        $results = mysqli_query($mysqli, $sql);
        if($results && mysqli_num_rows($results) > 0) {
            array_push($errors, "Each organization can only submit sponsor inquiry once per event");
        }

        if(count($errors) === 0) {
            $option = $_POST['option'];
            if($option === 'dropoff') {
                $dropoff_id = $_POST['dropoffId'];
                $sql = "INSERT INTO sponsor (SPONSOR_ID, EVENT_ID, PICKUP_ADD, `STATUS`, ORG_ID, DROPOFF_ID, ADMIN_ID) 
                        VALUES (NULL, '$id', NULL, 'pending', '$org_id', '$dropoff_id', NULL)";
            } else if($option === 'pickup') {
                $pickup_address = $_POST['pickupAddress'];
                $sql = "INSERT INTO sponsor (SPONSOR_ID, EVENT_ID, PICKUP_ADD, `STATUS`, ORG_ID, DROPOFF_ID, ADMIN_ID) 
                        VALUES (NULL, '$id', '$pickup_address', 'pending', '$org_id', NULL, NULL)";
            }
            $results = mysqli_query($mysqli, $sql);
            if($results) {
                $_SESSION['message'] = "Your sponsor inquiry has been successfully sent!";
                header("location:" . BASE_URL . "/events/post.php?id=" . $id);
                exit();
            }
        }
    }   


    if(isset($_POST['vol-join-btn'])) {
        if (!($vol_amount < $vol_goal)) {
            array_push($errors, "The volunteer goal has been reached.");
        }
        
        if(count($errors) === 0) {
            $time = date("Y-m-d");
            $vol_id = $_POST['vol-id'];

            //INSERT INTO PARTICIPATION TABLE
            $sql = "INSERT INTO participation (VOL_ID, EVENT_ID, JOIN_DATE) 
                    VALUES ('$vol_id', '$id', '$time')";
            $results = mysqli_query($mysqli, $sql);

            $updatedVolAmount = $vol_amount + 1;
            //UPDATE VOLUNTEER DATA IN EVENT TABLE
            $sql = "UPDATE event SET VOL_AMOUNT = '$updatedVolAmount'  
                    WHERE EVENT_ID = '$id'";
            $results = mysqli_query($mysqli, $sql);

            $updatedJoinEvent = $_SESSION['joined_event'];
            if($results) {
                array_push($updatedJoinEvent, $id);
                $_SESSION['joined_event'] = $updatedJoinEvent;
            }

            $_SESSION['message'] = "Successfully joined the event!";
            header("location:" . BASE_URL . "/events/post.php?id=" . $id);
            exit();
        }
    }

    if(isset($_POST['vol-leave-btn'])) {
        $vol_id = $_POST['vol-id'];

        $sql = "DELETE FROM participation WHERE VOL_ID = '$vol_id' AND EVENT_ID = '$id'";
        $results = mysqli_query($mysqli, $sql);

        $updatedVolAmount = $vol_amount - 1;
        //UPDATE VOLUNTEER DATA IN EVENT TABLE
        $sql = "UPDATE event SET VOL_AMOUNT = '$updatedVolAmount'  
                WHERE EVENT_ID = '$id'";
        $results = mysqli_query($mysqli, $sql);

        $updatedJoinEvent = $_SESSION['joined_event'];
        if (($key = array_search($id, $updatedJoinEvent)) !== false) {
            unset($updatedJoinEvent[$key]);
            $_SESSION['joined_event'] = $updatedJoinEvent;
        }

        $_SESSION['message'] = "Successfully left the event!";
        header("location:" . BASE_URL . "/events/post.php?id=" . $id);
        exit();
    }

?>