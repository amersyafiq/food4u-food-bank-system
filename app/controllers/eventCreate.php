<?php

    //DISPLAY EVENT REQUESTS
    $sql = "SELECT e.REQ_ID as ID, e.*, p.*, 
             COALESCE(v.VOL_NAME, o.ORG_NAME) as USER_NAME, 
             COALESCE(v.VOL_IMAGE, o.ORG_IMAGE) as USER_IMAGE,
             COALESCE(o.ORG_DESC) as USER_DESC
            FROM event_request e
            LEFT OUTER JOIN partnership p ON e.REQ_ID = p.REQ_ID
            LEFT OUTER JOIN volunteer v ON e.VOL_ID = v.VOL_ID
            LEFT OUTER JOIN organization o ON e.ORG_ID = o.ORG_ID
            WHERE REQ_STATUS = 'pending'
            ORDER BY PARTNERSHIP DESC, REQ_DATE ASC;";
    $results = mysqli_query($mysqli, $sql);
    $requests = mysqli_fetch_all($results, MYSQLI_ASSOC);

    if (isset($_GET['req-id'])) {
        $req_id = $_GET['req-id'];

        $requests = array_filter($requests, function ($request) use ($req_id) {
                    return ($request['ID'] == $req_id);});
    }

    //DELETE EVENT REQUESTS
    if (isset($_POST['discard'])) {
        $delete_req_id = $_POST['delete-req-id'];
        $delete_req_image = $_POST['delete-req-image'];
        $partnership = $_POST['delete-req-partnership'];

        dd($_POST);
        if(!empty($delete_req_image)) { 
            unlink(ROOT_PATH . '/' . $delete_req_image); 
        }

        if($partnership) {
            $sql = "DELETE FROM partnership WHERE REQ_ID = '$delete_req_id'";
            $results = mysqli_query($mysqli, $sql);
        }

        $sql = "DELETE FROM event_request WHERE REQ_ID = '$delete_req_id'";
        $results = mysqli_query($mysqli, $sql);

        $_SESSION['message'] = "Event request has been successfully deleted!";
        header("location:" . BASE_URL . "/events/create.php");
        exit();
    }

    //GET EVENT REQUEST BASED ON REQ ID
    if (isset($_GET['req-id'])) {
        $req_id = $_GET['req-id'];

        //GET DATA FORM EVENT TABLE
        $sql = "SELECT * FROM event_request WHERE REQ_ID = '$req_id'";
        $results = mysqli_query($mysqli, $sql);
        $req = mysqli_fetch_assoc($results);
        
        $name = $req['REQ_NAME'];
        $address = $req['REQ_ADDRESS'];
        $desc = $req['REQ_DESC'];
        $image = $req['REQ_IMAGE'];
        $partnership = $req['PARTNERSHIP'];
    
    }


    //EVENT CREATION
    if (isset($_POST['create'])) {
        //FORM VALIDATION
        if (empty($_POST['name'])) {
            array_push($errors, "Event name field is empty.");
        }
        if (empty($_POST['address'])) {
            array_push($errors, "Event address field is empty.");
        }
        if (empty($_POST['date'])) {
            array_push($errors, "Event date field is empty.");
        }
        if (empty($_POST['time'])) {
            array_push($errors, "Event time field is empty.");
        }
        if (empty($_POST['desc'])) {
            array_push($errors, "Event description field is empty.");
        }
        if (empty($_POST['vol'])) {
            array_push($errors, "Volunteer goal field is empty.");
        }
        if (empty($_POST['money'])) {
            array_push($errors, "Money donation goal field is empty.");
        }
        if (empty($_POST['food'][0]['name']) || empty($_POST['food'][0]['amount'])) {
            array_push($errors, "At least 1 food donation goal must be added.");
        } else {
            foreach($_POST['food'] as $food) {
                if(empty($food['name']) || empty($food['amount'])) {
                    array_push($errors, "Make sure all input field for food donation is entered correctly");
                    break;
                }
            }
        }
        
        if (empty($_POST['dropoff'][0])) {
            array_push($errors, "At least 1 drop-off address must be added.");
        } else {
            foreach ($_POST['dropoff'] as $dropoff) {
                if (empty($dropoff)) {
                    array_push($errors, "Make sure all input fields for drop-off addresses are entered correctly.");
                    break;
                }
            }
        }

        /* IMAGE VALIDATION AND UPLOAD */
        if (!empty($_FILES['image']['name'])) {
            $img_name = time() . "_" . $_FILES['image']['name'];
            $dest = "assets/event_images/" . $img_name;
            $result = move_uploaded_file($_FILES['image']['tmp_name'], ROOT_PATH . "/" . $dest);

            if ($result) {
                $_POST['image'] = $dest;
            }
            else {
                array_push($errors, "Failed to upload image");
            }

        } else {
            if(empty($_POST['image'])) {
                array_push($errors, "Event photo field is empty.");
            } else {
                //COPY AND MOVE THE THE FILE FROM EVENT REQUEST TO EVENT
                $source = $_POST['image'];
                $file_name = basename($source);
                $dest = "assets/event_images/" . $file_name;

                if (copy(ROOT_PATH . "/" . $source, ROOT_PATH . "/" . $dest)) {
                    $_POST['image'] = $dest;
                } else {
                    array_push($errors, "Failed to copy image");
                }
            }
        }

        $name = mysqli_real_escape_string($mysqli, trim($_POST['name']));
        $date = $_POST['date'];
        $time = $_POST['time'];
        $address = mysqli_real_escape_string($mysqli, trim($_POST['address']));
        $desc = mysqli_real_escape_string($mysqli, trim($_POST['desc']));
        $vol_goal = $_POST['vol'];
        $money_goal = $_POST['money'];
        $admin_id = $_SESSION['id'];
        $foodArr = $_POST['food'];
        $dropoffArr = $_POST['dropoff'];
        $req_id = isset($_POST['req_id']) ? $_POST['req_id'] : NULL;


        if(count($errors) === 0) {
            $image = $_POST['image'];

            //INSERT DATA INTO EVENT TABLE
            if(isset($req_id)) {
                //UPDATING EVENT REQUEST STATUS
                $sql = "UPDATE event_request SET REQ_STATUS = 'accepted' WHERE REQ_ID = '$req_id'";
                $results = mysqli_query($mysqli, $sql);

                $sql = "INSERT INTO event (EVENT_ID, EVENT_PHOTO, EVENT_NAME, EVENT_DATE, EVENT_TIME, EVENT_ADDRESS, EVENT_DESC, VOL_GOAL, VOL_AMOUNT, MONEY_GOAL, MONEY_AMOUNT, ADMIN_ID, REQ_ID) 
                    VALUES (NULL, '$image', '$name', '$date', '$time', '$address', '$desc', '$vol_goal', 0, '$money_goal', 0, '$admin_id', '$req_id')";
            } else {
                $sql = "INSERT INTO event (EVENT_ID, EVENT_PHOTO, EVENT_NAME, EVENT_DATE, EVENT_TIME, EVENT_ADDRESS, EVENT_DESC, VOL_GOAL, VOL_AMOUNT, MONEY_GOAL, MONEY_AMOUNT, ADMIN_ID, REQ_ID) 
                VALUES (NULL, '$image', '$name', '$date', '$time', '$address', '$desc', '$vol_goal', 0, '$money_goal', 0, '$admin_id', NULL)";
            }
            $result = mysqli_query($mysqli, $sql);

            $event_id = mysqli_insert_id($mysqli);
            
            //INSERT DATA INTO FOOD_DONATION TABLE
            foreach ($foodArr as $index => $food) {
                $food_name = mysqli_real_escape_string($mysqli, trim($food['name']));
                $food_goal = mysqli_real_escape_string($mysqli, trim($food['amount']));
                $sql = "INSERT INTO food_donation (FOOD_ID, EVENT_ID, FOOD_TYPE, FOOD_GOAL, FOOD_AMOUNT) 
                        VALUES (NULL, '$event_id', '$food_name', '$food_goal', 0)";
                $result = mysqli_query($mysqli, $sql);
            }

            //INSERT DATA INTO DRO_POFF TABLE
            foreach ($dropoffArr as $index => $dropoff) {
                if (!empty($dropoff)) {
                    $dropoff = mysqli_real_escape_string($mysqli, trim($dropoff));
                    $sql = "INSERT INTO drop_off (DROPOFF_ID, EVENT_ID, DROPOFF_ADD) 
                            VALUES (NULL, '$event_id', '$dropoff')";
                    $result = mysqli_query($mysqli, $sql);
                }
            }

            $_SESSION['message'] = "Event post has been successfully created!";
            header("location:" . BASE_URL . "/dashboard.php");
            exit();
        } else {
            if(isset($_POST['image'])) {
                unlink(ROOT_PATH . '/' . $_POST['image']);
            }
        }
    }



?>