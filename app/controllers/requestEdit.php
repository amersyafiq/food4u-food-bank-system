<?php
    $key = $_SESSION['role'] === 'Volunteer' ? 'VOL' : 'ORG';
    $sql = "SELECT * FROM event_request WHERE $key"."_ID = '$_SESSION[id]' AND REQ_ID = $_GET[id]"; 
    $results = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($results) === 0) {
        header("Location:" . BASE_URL . "/requests.php");
        die();
    }

    if(isset($_POST['update'])) {

        $req_id = $_POST['req_id'];
        $name = mysqli_real_escape_string($mysqli, trim($_POST['name']));
        $address = mysqli_real_escape_string($mysqli, trim($_POST['address']));
        $desc = mysqli_real_escape_string($mysqli, trim($_POST['desc']));
        $recptnum = $_POST['recptnum'];
        $assistance = mysqli_real_escape_string($mysqli, trim($_POST['assistance']));
        $partnership = $_POST['partnership'] ? 1 : 0;
        $contribution = isset($_POST['contribution']) ? mysqli_real_escape_string($mysqli, trim($_POST['contribution'])) : null;
        $requirement = isset($_POST['requirement']) ? mysqli_real_escape_string($mysqli, trim($_POST['requirement'])) : null;

        //UPDATING EVENT_REQUEST TABLE
        $sql = "UPDATE event_request 
                SET REQ_NAME = '$name',
                    REQ_ADDRESS = '$address',
                    REQ_DESC = '$desc',
                    REQ_RECPTNUM = '$recptnum',
                    REQ_ASSISTANCE = '$assistance',
                    PARTNERSHIP = '$partnership'
                WHERE REQ_ID = '$req_id'";
        $result = mysqli_query($mysqli, $sql);

        //UPDATING PARTNERSHIP TABLE
        if($partnership) {
            $sql = "UPDATE partnership
                    SET CONTRIBUTION = '$contribution',
                        REQUIREMENTS = '$requirement'
                    WHERE REQ_ID = '$req_id'";
            $result = mysqli_query($mysqli, $sql);
        }

        $_SESSION['message'] = "Event request has been successfully updated!";
        header("location:" . BASE_URL . "/requests.php");
        exit();
    }

?>