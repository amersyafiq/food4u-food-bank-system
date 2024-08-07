<?php

    // DISPLAY ALL EVENTS
    if (isset($_POST['search_event']) || isset($_POST['search_type'])) {
        $search_type = $_POST['search_type'];
        $search = !empty($_POST['search_event']) ? mysqli_real_escape_string($mysqli, trim($_POST['search_event'])) : null;

        $sql = "SELECT * FROM event ";

        if ($search_type === 'all') {
            $select_all = true;
            $sql .= " WHERE EVENT_NAME LIKE '%$search%'";
        } else if ($search_type === 'upcoming') {
            $select_upcoming = true;
            $sql .= " WHERE EVENT_DATE > '$currDate' AND EVENT_NAME LIKE '%$search%'";
        } else if ($search_type === 'finished') {
            $select_finished = true;
            $sql .= " WHERE EVENT_DATE < '$currDate' AND EVENT_NAME LIKE '%$search%'";
        } else if ($search_type === 'joined') {
            $select_joined = true;
            $joined_events = implode(',', $_SESSION['joined_event']);
            $sql .= " WHERE EVENT_ID IN ('$joined_events') AND EVENT_NAME LIKE '%$search%'";
        }

        $sql .= " ORDER BY EVENT_DATE DESC";
        
        $results = mysqli_query($mysqli, $sql);

        $data = '';
        while($row = mysqli_fetch_assoc($results)) {
            if (isset($row['REQ_ID'])) { $partner = 'Yes'; } else { $partner = 'No'; }
            $date = date('F d', strtotime($row['EVENT_DATE']));
            $time = date('h:i A', strtotime($row['EVENT_TIME']));

            $data .= "<button onclick=\"location.href='" . BASE_URL . "/events/post.php?id=" . $row['EVENT_ID'] . "'\" type='button'"; 
            if($row['EVENT_DATE'] < $currDate) { $data .= "disabled"; }
            $data .= ">
                    <div class='event-1'>
                        <div class='title-address'>
                            <h1>  $row[EVENT_NAME] </h1>
                            <div>
                                <p> $row[EVENT_ADDRESS] </p>
                                <img src='" . BASE_URL . "/assets/images/map_logo.png'>
                            </div>
                        </div>
                        <div class='goal-datetime'>
                            <div class='goal'>
                                <div>
                                    <p>Volunteer</p>
                                    <h2> $row[VOL_AMOUNT] of $row[VOL_GOAL] </h2>
                                </div>
                                <div>
                                    <p>Money</p>
                                    <div class='progress-bar'>
                                        <div style='width:" . $row['MONEY_AMOUNT'] / $row['MONEY_GOAL'] * 100 . "%' class='curr-progress'></div>
                                    </div>
                                </div>
                                <div>
                                    <p>Food</p>
                                    <div class='progress-bar'>
                                        <div style='width:" . foodCurrProgress($row['EVENT_ID']) . "%' class='curr-progress'></div>
                                    </div>
                                </div>
                            </div>
                            <div class='time'>
                                <div> <p> $date </p> </div>
                                <div> <p> $time </p> </div>";
                                
                                if (isset($_SESSION['joined_event']) && in_array($row['EVENT_ID'], $_SESSION['joined_event'])) {
                                    $data .= "<div class='color-div'> <p> Joined </p> </div>";
                                }
                                    
                                if (isset($row['REQ_ID'])) {
                                    $data .= "<div class='color-div'> <p> Partnered </p> </div>";
                                }


                                if($row['EVENT_DATE'] < $currDate) {
                                    $data .= "<div class='color-div'> <p> Ended </p> </div>";
                                }

            $data .= "
                            </div>
                        </div>
                    </div>
                </button>";
        }
        echo $data;
        exit();
    } else {
        $sql = "SELECT * FROM event ORDER BY EVENT_DATE DESC";
    }

    $results = mysqli_query($mysqli, $sql);
    $rows = mysqli_fetch_all($results, MYSQLI_ASSOC);

    if(count($rows) === 0) {
        $empty_rows = true;
    }

    function foodCurrProgress($event_id) {
        global $mysqli;
        $sql = "SELECT SUM(FOOD_GOAL) AS `SUM_FOOD_GOAL`, SUM(FOOD_AMOUNT) AS `SUM_FOOD_AMOUNT` FROM food_donation WHERE EVENT_ID = $event_id GROUP BY EVENT_ID";
        $results = mysqli_query($mysqli, $sql);
        $sum = mysqli_fetch_assoc($results);
        if (isset($sum)) {
            $percentage = $sum['SUM_FOOD_AMOUNT'] / $sum['SUM_FOOD_GOAL'] * 100;
            return $percentage;
        } else {
            return 0;
        }
    }

?>