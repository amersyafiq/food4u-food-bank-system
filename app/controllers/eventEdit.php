<?php

    $newFoodArr = array();
    $newDropoffArr = array();

    //UPDATE EVENT
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = mysqli_real_escape_string($mysqli, trim($_POST['name']));
        $date = $_POST['date'];
        $time = $_POST['time'];
        $address = mysqli_real_escape_string($mysqli, trim($_POST['address']));
        $desc = mysqli_real_escape_string($mysqli, trim($_POST['desc']));
        $vol_goal = $_POST['vol'];
        $money_goal = $_POST['money'];
        $admin_id = $_POST['admin_id'];
    
        $foodArr = $_POST['food'];
        $newFoodArr = isset($_POST['newFood']) ? $_POST['newFood'] : array();
    
        $dropoffArr = $_POST['dropoff'];
        $newDropoffArr = isset($_POST['newDropoff']) ? $_POST['newDropoff'] : array();
    
        //UPDATING EVENT TABLE
        $sql = "UPDATE `event` SET EVENT_NAME = '$name',
                                EVENT_DATE = '$date',
                                EVENT_TIME = '$time',
                                EVENT_ADDRESS = '$address',
                                EVENT_DESC = '$desc',
                                VOL_GOAL = '$vol_goal',
                                MONEY_GOAL = '$money_goal',
                                ADMIN_ID = '$admin_id'
                WHERE EVENT_ID = '$id'";
        $results = mysqli_query($mysqli, $sql);
    
        //UPDATING EXISTING FOOD_DONATION RECORDS
        foreach ($foodArr as $food) {
            if (isset($food['id']) && isset($food['name']) && isset($food['goal']) && isset($food['amount'])) {
                $food_id = $food['id'];
                $food_name = mysqli_real_escape_string($mysqli, trim($food['name']));
                $food_goal = $food['goal'];
                $food_amount = $food['amount'];
                $sql = "UPDATE food_donation 
                        SET FOOD_TYPE = '$food_name', FOOD_GOAL = '$food_goal', FOOD_AMOUNT = '$food_amount' 
                        WHERE FOOD_ID = '$food_id' AND EVENT_ID = '$id'";
                $result = mysqli_query($mysqli, $sql);
            }
        }
    
        //INSERTING NEW FOOD_DONATION RECORDS
        foreach ($newFoodArr as $newFood) {
            if (!empty($newFood['name']) && !empty($newFood['amount'])) {
                $newFood_name = mysqli_real_escape_string($mysqli, trim($newFood['name']));
                $newFood_goal = $newFood['amount'];
                $newSql = "INSERT INTO food_donation (FOOD_ID, EVENT_ID, FOOD_TYPE, FOOD_GOAL, FOOD_AMOUNT) 
                        VALUES (NULL, '$id', '$newFood_name', '$newFood_goal', 0)";
                $result = mysqli_query($mysqli, $newSql);
            }
        }
    
        //UPDATING EXISTING DROP_OFF RECORDS
        foreach ($dropoffArr as $dropoff) {
            if (isset($dropoff['id']) && !empty($dropoff['address'])) {
                $dropoff_id = $dropoff['id'];
                $dropoff_address = mysqli_real_escape_string($mysqli, trim($dropoff['address']));
                $sql = "UPDATE drop_off 
                        SET DROPOFF_ADD = '$dropoff_address' 
                        WHERE DROPOFF_ID = '$dropoff_id' AND EVENT_ID = '$id'";
                $result = mysqli_query($mysqli, $sql);
            }
        }
    
        //INSERTING NEW DROP_OFF RECORDS
        foreach ($newDropoffArr as $dropoff) {
            if (!empty($dropoff)) {
                $sql = "INSERT INTO drop_off (DROPOFF_ID, EVENT_ID, DROPOFF_ADD) 
                        VALUES (NULL, '$id', '$dropoff')";
                $result = mysqli_query($mysqli, $sql);
            }
        }
    
        $_SESSION['message'] = "Event post has been successfully updated!";
        header("location:" . BASE_URL . "/dashboard.php");
        exit();
    }

?>