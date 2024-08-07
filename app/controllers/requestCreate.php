<?php

    if(isset($_POST['request'])) {

        //REQUEST VALIDATION
        if (empty($_POST['name'])) {
            array_push($errors, "Event request name field is empty.");
        }
        if (empty($_POST['address'])) {
            array_push($errors, "Event request address field is empty.");
        }
        if (empty($_POST['desc'])) {
            array_push($errors, "Event request description field is empty.");
        }

        /* IMAGE VALIDATION AND UPLOAD */
        if (!empty($_FILES['image']['name'])) {
            $img_name = time() . "_" . $_FILES['image']['name'];
            $dest = "assets/request_images/" . $img_name;
            $result = move_uploaded_file($_FILES['image']['tmp_name'], ROOT_PATH . "/" . $dest);

            if ($result) {
                $_POST['image'] = $dest;
            }
            else {
                array_push($errors, "Failed to upload image");
            }
        } else {
            array_push($errors, "Event request photo field is empty.");
        }

        if (empty($_POST['recptnum'])) {
            array_push($errors, "Number of recipients field is empty.");
        }
        if (empty($_POST['assistance'])) {
            array_push($errors, "Assistance description field is empty.");
        }

        if (isset($_POST['partnership'])) {
            $partnership = 1;
            if (empty($_POST['contribution'])) {
                array_push($errors, "Contribution field is empty.");
            } else {
                $contribution = mysqli_real_escape_string($mysqli, trim($_POST['contribution']));
            }
            if (empty($_POST['requirement'])) {
                array_push($errors, "Requirement field is empty.");
            } else {
                $requirement = mysqli_real_escape_string($mysqli, trim($_POST['requirement']));
            }
        } else {
            $partnership = 0;
        }

        if ($role === 'Volunteer') {
            $vol_id = $_SESSION['id'];
        } else if ($role === 'Organization') {
            $org_id = $_SESSION['id'];
        }

        $name = mysqli_real_escape_string($mysqli, trim($_POST['name']));
        $address = mysqli_real_escape_string($mysqli, trim($_POST['address']));
        $desc = mysqli_real_escape_string($mysqli, trim($_POST['desc']));
        $recptnum = mysqli_real_escape_string($mysqli, trim($_POST['recptnum']));
        $assistance = mysqli_real_escape_string($mysqli, trim($_POST['assistance']));

        date_default_timezone_set('Asia/Kuala_Lumpur');
        $date = date('Y-m-d', time());

        if(count($errors) === 0) {
            $image = $_POST['image'];

            if($partnership) {
                $sql = "INSERT INTO event_request (REQ_ID, REQ_NAME, REQ_ADDRESS, REQ_DESC, REQ_RECPTNUM, REQ_ASSISTANCE, REQ_DATE, REQ_IMAGE, PARTNERSHIP, REQ_STATUS, VOL_ID, ORG_ID, ADMIN_ID) 
                    VALUES (NULL, '$name', '$address', '$desc', '$recptnum', '$assistance', '$date', '$image', '$partnership', 'pending', NULL, '$org_id', NULL)";
                $result = mysqli_query($mysqli, $sql);
                
                $req_id = mysqli_insert_id($mysqli);
                $sql = "INSERT INTO partnership (PARTNER_ID, REQ_ID, CONTRIBUTION, REQUIREMENTS) 
                        VALUES (NULL, '$req_id', '$contribution', '$requirement')";
                $result = mysqli_query($mysqli, $sql);   
        
            } else {
                if($role === 'Volunteer') {
                    $sql = "INSERT INTO event_request (REQ_ID, REQ_NAME, REQ_ADDRESS, REQ_DESC, REQ_RECPTNUM, REQ_ASSISTANCE, REQ_DATE, REQ_IMAGE, PARTNERSHIP, REQ_STATUS, VOL_ID, ORG_ID, ADMIN_ID) 
                        VALUES (NULL, '$name', '$address', '$desc', '$recptnum', '$assistance', '$date', '$image', '$partnership', 'pending', '$vol_id', NULL, NULL)";
                } else if ($role === 'Organization') {
                    $sql = "INSERT INTO event_request (REQ_ID, REQ_NAME, REQ_ADDRESS, REQ_DESC, REQ_RECPTNUM, REQ_ASSISTANCE, REQ_DATE, REQ_IMAGE, PARTNERSHIP, REQ_STATUS, VOL_ID, ORG_ID, ADMIN_ID) 
                        VALUES (NULL, '$name', '$address', '$desc', '$recptnum', '$assistance', '$date', '$image', '$partnership', 'pending', NULL, '$org_id', NULL)";
                }
                $result = mysqli_query($mysqli, $sql);
            }

            $_SESSION['message'] = "Event request has been successfully created!";
            header("location:" . BASE_URL . "/requests.php");
            exit();
        } else {
            if(isset($_POST['image'])) {
                unlink(ROOT_PATH . '/' . $_POST['image']);
            }
        }

    }



?>