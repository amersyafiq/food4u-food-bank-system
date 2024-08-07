<?php
    function dd($value) {
        echo "<pre>" . print_r($value, true) . "</pre>";
        die();
    }
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once ROOT_PATH . '/app/database/connect.php';
    
    $errors = array();
    $joinedEvents = array();

    if (isset($_POST['register'])) {
        $role = $_POST['role'];

        /* FORM VALIDATION */

        if (!empty($_POST['name'])) {
            if (strlen($_POST['name']) < 6) {
                array_push($errors, "Name must be at least 6 characters long.");
            }
        } else {
            array_push($errors, "Name field is empty.");
        }
        if (empty($_POST['phone'])) {
            array_push($errors, "Phone number field is empty.");
        }
        if (empty($_POST['password'])) {
            array_push($errors, "Password field is empty.");
        }
        if (empty($_POST['passwordconf'])) {
            array_push($errors, "Password confirmation field is empty.");
        }
        if ($role == "Organization") {
            if (empty($_POST['org-address'])) {
                array_push($errors, "Organization address field is empty.");
            }
            if (empty($_POST['org-desc'])) {
                array_push($errors, "Organization description field is empty.");
            }
        }
        if ($_POST['password'] !== $_POST['passwordconf']) {
            array_push($errors, "Password do not match");
        }

        /* EMAIL VALIDATION */
        $email = $_POST['email'];
        if (!empty($_POST['email'])) {
            /* CHECK IF EMAIL IS CORRECT */
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                /* CHECK IF EMAIL ALREADY EXIST OR NOT */
                if ($role == "Volunteer") {
                    $sql = "SELECT * FROM volunteer WHERE VOL_EMAIL='$email'";
                }
                else {
                    $sql = "SELECT * FROM organization WHERE ORG_EMAIL='$email'";
                }
                $results = mysqli_query($mysqli, $sql);
                if($results && mysqli_num_rows($results) > 0) {
                    array_push($errors, "Email address already exists.");
                }
            } else {
                array_push($errors, "Email is invalid.");
            }
        } else {
            array_push($errors, "Email field is empty.");
        }

        /* IMAGE VALIDATION AND UPLOAD */
        if (!empty($_FILES['image']['name'])) {
            $img_name = time() . "_" . $_FILES['image']['name'];
            $dest = "assets/user_images/" . $img_name;
            $result = move_uploaded_file($_FILES['image']['tmp_name'], $dest);

            if ($result) {
                $_POST['image'] = $dest;
            }
            else {
                array_push($errors, "Failed to upload image");
            }

        } else {
            $_POST['image'] = "assets/images/default_image.png";
        }


        if(count($errors) === 0) {
            /* INSERTIND DATA INTO DATABASE */
            $name = mysqli_real_escape_string($mysqli, trim($_POST['name']));
            $phone = mysqli_real_escape_string($mysqli, trim($_POST['phone']));

            /* ENCRYPTING PASSWORD */
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            $image = $_POST['image'];

            if ($role === "Volunteer") {
                $sql = "INSERT INTO volunteer (VOL_NAME, VOL_PASSWORD, VOL_IMAGE, VOL_EMAIL, VOL_PHONE) 
                        VALUES ('$name', '$password', '$image', '$email', '$phone')";
            }
            else if ($role === "Organization") {
                $address = mysqli_real_escape_string($mysqli, trim($_POST['org-address']));
                $desc = mysqli_real_escape_string($mysqli, trim($_POST['org-desc']));
                $sql = "INSERT INTO organization (ORG_NAME, ORG_PASSWORD, ORG_EMAIL, ORG_IMAGE, ORG_PHONE, ORG_ADDRESS, ORG_DESC) 
                        VALUES ('$name', '$password', '$email', '$image', '$phone', '$address', '$desc')";
            }

            $result = mysqli_query($mysqli, $sql);
            
            //AUTO LOG IN USER
            $_SESSION['id'] = mysqli_insert_id($mysqli);
            $_SESSION['role'] = $role;
            $_SESSION['name'] = $name;
            $_SESSION['image'] = $image;
            $_SESSION['message'] = "Your account has been successfully registered!";
            
            if ($role === "Volunteer") {
                $_SESSION['joined_event'] = array();
            }

            header("Location: " . BASE_URL . "/index.php", true, 301);
            exit();
        } else {
            if(isset($_POST['image']) && $_POST['image'] !== "assets/images/default_image.png") {
                unlink(ROOT_PATH . '/' . $_POST['image']);
            }
        }

    }

    if (isset($_POST['login'])) {
        $role = $_POST['role'];

        //FORM VALIDATION
        $email = $_POST['email'];
        if (!empty($_POST['email'])) {
            /* CHECK IF EMAIL IS CORRECT */
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is invalid.");
            }
        } else {
            array_push($errors, "Email field is empty.");
        }
        if (empty($_POST['password'])) {
            array_push($errors, "Password field is empty.");
        }

        if(count($errors) === 0) {
    
            if ($role === "Volunteer") {
                $sql = "SELECT * FROM volunteer WHERE VOL_EMAIL='$email'";
                $key = 'VOL';
            }
            else if ($role === "Organization") {
                $sql = "SELECT * FROM organization WHERE ORG_EMAIL='$email'";
                $key = 'ORG';
            } else if ($role === "Administrator") {
                $sql = "SELECT * FROM administrator WHERE ADMIN_EMAIL='$email'";
                $key = 'ADMIN';
            }
            
            $results = mysqli_query($mysqli, $sql);
            $result = mysqli_fetch_assoc($results);
            

            if (isset($result)) {
                $passVerify = password_verify($_POST['password'], $result[$key . '_PASSWORD']);
                $id = $result[$key.'_ID'];
                $name = $result[$key.'_NAME'];
                $image = $role === 'Administrator' ? "assets/images/admin_image.png" : $result[$key.'_IMAGE'];
            }

            if ($result && $passVerify) {
                //USER LOG IN
                $_SESSION['id'] = $id;
                $_SESSION['role'] = $role;
                $_SESSION['name'] = $name;
                $_SESSION['image'] = $image;
                $_SESSION['message'] = "You has successfully logged in!";
                
                if ($role === "Volunteer") {
                    $_SESSION['joined_event'] = $joinedEvents;

                    //GET JOINED EVENTS
                    $sql = "SELECT * FROM participation WHERE VOL_ID = '$id'";
                    $results = mysqli_query($mysqli, $sql);
                    if (mysqli_num_rows($results) > 0) {
                        while($row = mysqli_fetch_assoc($results)) {
                            $joinedEvents[] = $row['EVENT_ID'];
                        }
                        $_SESSION['joined_event'] = $joinedEvents;
                    }
                    else {
                        $_SESSION['joined_event'] = array();
                    }
                }

                if ($role === "Administrator") {
                    header("Location: " . BASE_URL . "/dashboard.php", true, 301);
                    exit();
                } else {
                    header("Location: " . BASE_URL . "/index.php", true, 301);
                    exit();
                }
            } else {
                array_push($errors, "Wrong email address or password.");
            }
        }
    }
?>