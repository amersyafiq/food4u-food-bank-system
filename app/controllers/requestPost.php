<?php
    require(ROOT_PATH . "/script.php");
    $errors = array();

    function dd($value) {
        echo "<pre>" . print_r($value, true) . "</pre>";
        die();
    }

    require_once ROOT_PATH . '/app/database/connect.php';

    $user_id = $_SESSION['id'];
    $role = $_SESSION['role'];
    $name = '';
    $address = '';
    $desc = '';
    $receptnum = '';
    $assistance = '';
    $partnership = '';
    $contribution = '';
    $requirement = '';

    //DISPLAY EVENT REQUEST ACCORDING TO USER ID
    if ($role === 'Volunteer') {
        $sql = "SELECT * FROM event_request WHERE VOL_ID = '$user_id' ORDER BY REQ_DATE ASC";
    } else if ($role === 'Organization') {
        $sql = "SELECT * FROM event_request WHERE ORG_ID = '$user_id' ORDER BY REQ_DATE ASC";
    }

    $results = mysqli_query($mysqli, $sql);
    $rows = mysqli_fetch_all($results, MYSQLI_ASSOC);
    if (empty($rows)) {
        $emptyRequest = true;
    }

    $sql = "SELECT * FROM event_request WHERE VOL_ID = '$user_id' AND REQ_STATUS = 'accepted'";
    $results = mysqli_query($mysqli, $sql);
    if($results && mysqli_num_rows($results) === 0) {
        $emptyAccepted = true;
    }


    //FIND ACCEPTED EVENT REQUEST WITH REQ_ID
    function findEventReqId ($reqId) {
        global $mysqli;
        $sql = "SELECT * FROM event WHERE REQ_ID = '$reqId'";
        $results = mysqli_query($mysqli, $sql);
        $event = mysqli_fetch_assoc($results);
        if (!empty($event['EVENT_ID'])) {
            return $event['EVENT_ID'];
        } else {
            return dd($reqId);
        }
    }


    //DELETE EVENT REQUEST
    if(isset($_POST['delete'])) {
        $delete_image = $_POST['DELETE_IMAGE'];
        $partnership = $_POST['isPARTNERSHIP'];
        $delete_id = $_POST['DELETE_ID'];

        unlink(ROOT_PATH . '/' . $delete_image);

        if($partnership) {
            //DELETE FROM PARTNERSHIP TABLE
            $sql = "DELETE FROM partnership WHERE REQ_ID = '$delete_id'";
            $results = mysqli_query($mysqli, $sql);
        }

        //DELETE FROM EVENT_REQUEST TABLE
        $sql = "DELETE FROM event_request WHERE REQ_ID = '$delete_id'";
        $results = mysqli_query($mysqli, $sql);

        if($results) {
            $_SESSION['message'] = "Event request has successfully been deleted!";
            header("location:" . BASE_URL . "/requests.php");
            exit();
        }
    }


    if (isset($_GET['id'])) {
        $req_id = $_GET['id'];
        
        $sql = "SELECT * FROM event_request WHERE REQ_ID = $req_id";
        $results = mysqli_query($mysqli, $sql);
        $request = mysqli_fetch_assoc($results);

        $name = $request['REQ_NAME'];
        $address = $request['REQ_ADDRESS'];
        $desc = $request['REQ_DESC'];
        $image = $request['REQ_IMAGE'];
        $recptnum = $request['REQ_RECPTNUM'];
        $assistance = $request['REQ_ASSISTANCE'];
        $partnership = $request['PARTNERSHIP'];
        
        if($partnership) {
            $sql = "SELECT * FROM partnership WHERE REQ_ID = '$req_id'";
            $results = mysqli_query($mysqli, $sql);
            $request = mysqli_fetch_assoc($results);

            $contribution = isset($request['CONTRIBUTION']) ? $request['CONTRIBUTION'] : null;
            $requirement = isset($request['REQUIREMENTS']) ? $request['REQUIREMENTS'] : null;
        }

    }


?>