<?php
    require(ROOT_PATH . "/script.php");
    $errors = array();

    function dd($value) {
        echo "<pre>" . print_r($value, true) . "</pre>";
        die();
    }

    require_once ROOT_PATH . '/app/database/connect.php';

    $name = '';
    $date = '';
    $time = '';
    $address = '';
    $desc = '';
    $vol_goal = '';
    $vol_amount = '';
    $money_goal = '';
    $money_amount = '';
    $foodArr = array();
    $dropoffArr = array();
    $sponsorArr = array();
    $volArr = array();
    $deleteVolArr = array();


    date_default_timezone_set('Asia/Kuala_Lumpur');
    $currDate = date('Y-m-d', time());


    //GET EVENT BASED ON ID
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM event WHERE EVENT_ID = '$id'";
        $results = mysqli_query($mysqli, $sql);
        if($results && mysqli_num_rows($results) === 0) {
            header("Location:" . BASE_URL . "/events.php");
            die();
        }

        //GET DATA FORM EVENT TABLE
        $sql = "SELECT * FROM event WHERE EVENT_ID = $id";
        $results = mysqli_query($mysqli, $sql);
        $event = mysqli_fetch_assoc($results);
        
        $name = $event['EVENT_NAME'];
        $date = $event['EVENT_DATE'];
        $time = $event['EVENT_TIME'];
        $address = $event['EVENT_ADDRESS'];
        $desc = $event['EVENT_DESC'];
        $image = $event['EVENT_PHOTO'];
        $vol_goal = $event['VOL_GOAL'];
        $vol_amount = $event['VOL_AMOUNT'];
        $money_goal = $event['MONEY_GOAL'];
        $money_amount = $event['MONEY_AMOUNT'];
        $admin_id = $event['ADMIN_ID'];
        $req_id = isset($event['REQ_ID']) ? $event['REQ_ID'] : NULL;

        //GET DATA FROMM FOOD_DONATION TABLE
        $sql = "SELECT * FROM food_donation WHERE EVENT_ID = $id";
        $results = mysqli_query($mysqli, $sql);
        while($row = mysqli_fetch_assoc($results)) {
            $foodArr[] = $row;
        }

        //GET DATA FROMM DROP_OFF TABLE
        $sql = "SELECT * FROM drop_off WHERE EVENT_ID = $id";
        $results = mysqli_query($mysqli, $sql);
        while($row = mysqli_fetch_assoc($results)) {
            $dropoffArr[] = $row;
        }

        //GET DATA FOR SPONSOR
        $sql = "SELECT s.SPONSOR_ID, s.EVENT_ID, s.ORG_ID, o.ORG_NAME, o.ORG_EMAIL, o.ORG_DESC, s.PICKUP_ADD, do.DROPOFF_ADD
                FROM sponsor s
                LEFT JOIN organization o ON s.ORG_ID = o.ORG_ID
                LEFT JOIN drop_off do ON s.DROPOFF_ID = do.DROPOFF_ID
                WHERE s.EVENT_ID = $id";
        $results = mysqli_query($mysqli, $sql);
        while($row = mysqli_fetch_assoc($results)) {
            $sponsorArr[] = $row;
        }

        //GET DATA FOR VOLUNTEERS
        $sql = "SELECT v.VOL_NAME, v.VOL_IMAGE, v.VOL_EMAIL, v.VOL_PHONE FROM volunteer v, participation p
                WHERE v.VOL_ID = p.VOL_ID AND p.EVENT_ID = '$id'";
        $results = mysqli_query($mysqli, $sql);  
        while($row = mysqli_fetch_assoc($results)) {
            $volArr[] = $row;
        }

        //GET DATA FROM USER
        if($req_id) {
            $sql = "SELECT e.REQ_ID as ID,
                    e.PARTNERSHIP,
                    COALESCE(v.VOL_NAME, o.ORG_NAME) as USER_NAME, 
                    COALESCE(v.VOL_IMAGE, o.ORG_IMAGE) as USER_IMAGE,
                    COALESCE(o.ORG_DESC) as USER_DESC
                    FROM event_request e
                    LEFT OUTER JOIN partnership p ON e.REQ_ID = p.REQ_ID
                    LEFT OUTER JOIN volunteer v ON e.VOL_ID = v.VOL_ID
                    LEFT OUTER JOIN organization o ON e.ORG_ID = o.ORG_ID
                    WHERE e.REQ_ID = '$req_id'";
            $results = mysqli_query($mysqli, $sql);
            $event = mysqli_fetch_assoc($results);
            $user_name = $event['USER_NAME'];
            $user_image = $event['USER_IMAGE'];
            $user_desc = isset($event['USER_DESC']) ? $event['USER_DESC'] : NULL;
        } 


    }

    

?>