<?php

    //NUMBER OF VOL, ORG, EVENTS, AND DONATIONS
    $sql = "SELECT COUNT(*) FROM volunteer";
    $results = mysqli_query($mysqli, $sql);
    $countVol = mysqli_fetch_assoc($results);

    $sql = "SELECT COUNT(*) FROM organization";
    $results = mysqli_query($mysqli, $sql);
    $countOrg = mysqli_fetch_assoc($results);

    $sql = "SELECT COUNT(*) FROM event";
    $results = mysqli_query($mysqli, $sql);
    $countEvent = mysqli_fetch_assoc($results);

    $sql = "SELECT COUNT(*) FROM donation";
    $results = mysqli_query($mysqli, $sql);
    $countDonation = mysqli_fetch_assoc($results);

    
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
            $status = $row['EVENT_DATE'] > $currDate ? 'Upcoming' : 'Ended'; 
            $date = date('F d', strtotime($row['EVENT_DATE']));
            $time = date('h:i A', strtotime($row['EVENT_TIME']));
            $data .= "<tr>
                        <td> $row[EVENT_ID] </td>
                        <td> $row[EVENT_NAME] </td>
                        <td> $date </td>
                        <td> $time </td>
                        <td> <p class='event-status'>$status</p> </td>
                        <td class='action-btns'>
                            <button type='button' onclick='location.href=\"" . BASE_URL . '/events/post.php?id=' . $row['EVENT_ID'] . "\"'><img src='https://img.icons8.com/?size=100&id=61040&format=png&color=FFFFFF'></button>
                            <button type='button' onclick='location.href=\"" . BASE_URL . '/events/edit.php?id=' . $row['EVENT_ID'] . "\"'><img src='https://img.icons8.com/?size=100&id=MCdDfCTzd5GC&format=png&color=FFFFFF'></button>
                            <button data-delete-name=' $row[EVENT_NAME] ' 
                                    data-delete-id=' $row[EVENT_ID] '
                                    data-delete-vol=' $row[VOL_AMOUNT] ' 
                                    class='delete-btn'>
                                    <img src='https://img.icons8.com/?size=100&id=67884&format=png&color=FFFFFF'>
                            </button>
                            <button data-donate-id=' $row[EVENT_ID] '
                                    class='donate-btn'>
                                    <img src='https://img.icons8.com/?size=100&id=MuNNwJd8zS20&format=png&color=FFFFFF'>
                            </button>
                        </td>
                    </tr>";
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


    //DELETE SELECTED EVENT
    if(isset($_POST['delete'])) {
        $delete_id = $_POST['DELETE_ID'];

        //EMAIL PARTICIPATING VOLUNTEER
        $sql = "SELECT v.VOL_EMAIL FROM volunteer v, participation p
                WHERE v.VOL_ID = p.VOL_ID AND p.EVENT_ID = '$delete_id'";
        $results = mysqli_query($mysqli, $sql);
        while($row = mysqli_fetch_assoc($results)) {
            $deleteVolArr[] = $row['VOL_EMAIL'];
        }

        $sql = "SELECT EVENT_NAME, EVENT_ADDRESS, EVENT_DATE, EVENT_TIME, EVENT_PHOTO, REQ_ID FROM event WHERE EVENT_ID = '$delete_id'";
        $results = mysqli_query($mysqli, $sql);
        $event = mysqli_fetch_assoc($results);

        if(count($deleteVolArr) > 0) {
            $emails = $deleteVolArr;
            $subject = "CANCELLATION OF ";
            $message = "To whom it may concern,<br><br>" . "We regret to inform you the cancellation for the following event: <br><br>";
            $message .= "<b>Event name: </b>" . $event['EVENT_NAME'] . "<br>";
            $message .= "<b>Event address: </b>" . $event['EVENT_ADDRESS'] . "<br>";
            $message .= "<b>Event date: </b>" . $event['EVENT_DATE'] . "<br>";
            $message .= "<b>Event time: </b>" . $event['EVENT_TIME'] . "<br><br>";
            $message .= "For any questions regarding this cancellation, please contact Uncle Tony by replying to this email or contact 012-8812666 (Tony) .";
            
        }
        unlink(ROOT_PATH . '/' . $event['EVENT_PHOTO']);

        //DELETE FROM DONATION TABLE
        $sql = "DELETE FROM donation WHERE EVENT_ID = '$delete_id'";
        $results = mysqli_query($mysqli, $sql);

        //DELETE FROM FOOD_DONATION TABLE
        $sql = "DELETE FROM food_donation WHERE EVENT_ID = '$delete_id'";
        $results = mysqli_query($mysqli, $sql);

        //DELETE FROM SPONSOR TABLE
        $sql = "DELETE FROM sponsor WHERE EVENT_ID = '$delete_id'";
        $results = mysqli_query($mysqli, $sql);

        //DELETE FROM DROP_OFF TABLE
        $sql = "DELETE FROM drop_off WHERE EVENT_ID = '$delete_id'";
        $results = mysqli_query($mysqli, $sql);

        //DELETE FROM PARTICIPATION TABLE
        $sql = "DELETE FROM participation WHERE EVENT_ID = '$delete_id'";
        $results = mysqli_query($mysqli, $sql);

        //DELETE FROM event TABLE
        $sql = "DELETE FROM event WHERE EVENT_ID = '$delete_id'";
        $results = mysqli_query($mysqli, $sql);

        //DELETE EVENT REQUEST / PARTNERSHIP
        if(!empty($event['REQ_ID'])) {
            $req_id = $event['REQ_ID'];

            $sql = "SELECT * FROM event_request WHERE REQ_ID = $req_id";
            $results = mysqli_query($mysqli, $sql);
            $request = mysqli_fetch_assoc($results);
            $partnership = $request['PARTNERSHIP'];
            $image = $request['REQ_IMAGE'];

            if(!empty($image)) { unlink(ROOT_PATH . '/' . $image); };

            if($partnership) {
                //DELETE FROM PARTNERSHIP TABLE
                $sql = "DELETE FROM partnership WHERE REQ_ID = '$req_id'";
                $results = mysqli_query($mysqli, $sql);
            }

            //DELETE FROM EVENT_REQUEST TABLE
            $sql = "DELETE FROM event_request WHERE REQ_ID = '$req_id'";
            $results = mysqli_query($mysqli, $sql);
        }


        if(count($deleteVolArr) > 0) {
            $response = sendMultiMail($emails, $subject, $message);
        }

        if($results) {
            $_SESSION['message'] = "Event has successfully been deleted and all participating volunteers have been notified!";
            header("location:" . BASE_URL . "/dashboard.php");
            exit();
        }
    }

    if(isset($_POST['count_donation'])) {
        $event_id = $_POST['count_donation'];
        $sql = "SELECT COUNT(*) FROM donation WHERE EVENT_ID ='$event_id'";
        $results = mysqli_query($mysqli, $sql);
        $result = mysqli_fetch_assoc($results);
        echo $result['COUNT(*)'];
        exit();
    }
    if(isset($_POST['count_sponsor'])) {
        $event_id = $_POST['count_sponsor'];
        $sql = "SELECT COUNT(*) FROM sponsor WHERE EVENT_ID ='$event_id'";
        $results = mysqli_query($mysqli, $sql);
        $result = mysqli_fetch_assoc($results);
        echo $result['COUNT(*)'];
        exit();
    }

    if (isset($_POST['donate_id'])) {
        $event_id = $_POST['donate_id'];

        //ACCEPT DONATION
        if(!empty($_POST['accept_id'])) {
            $donation_id = $_POST['accept_id'];
            $donation_qty = $_POST['donation_qty'];

            $sql = "SELECT v.VOL_EMAIL, v.VOL_NAME, d.DONATION_DATE FROM volunteer v, donation d
                    WHERE v.VOL_ID = d.VOL_ID AND d.EVENT_ID = '$event_id' AND d.DONATION_ID = '$donation_id'";
            $results = mysqli_query($mysqli, $sql);
            $row = mysqli_fetch_assoc($results);
            $email = $row['VOL_EMAIL'];
            $vol_name = $row['VOL_NAME'];
            $donation_date = $row['DONATION_DATE'];

            $subject = "FOOD4U EVENT DONATION APPROVAL";
            $message = "Dear " . $vol_name . ",";
            $message .= "<br><br>We would like to let you know that the contribution you made at " . $donation_date . " has been processed.";
            $message .= "<br>The donation goal has been updated at: <u style='color: blue; cursor: pointer'><a href='" . BASE_URL . "/events/post.php?id=" . $event_id . "'>" . BASE_URL . "/events/post.php?id=" . $event_id . "</a></u>";
            $message .= "<br><br>For any questions regarding this, please contact Uncle Tony by replying to this email or calling 012-8812666 (Tony).";
            $message .= "<br>Thank you for your support and generosity";
            $message .= "<br><br>Best regards, <br>The Food4U Team";
            $response = sendMail($email, $subject, $message);

            //UPDATE DONATION STATUS (pending -> accepted)
            if($response) {
                $sql = "UPDATE donation SET DONATION_STATUS = 'accepted' WHERE DONATION_ID = '$donation_id'";
                $result = mysqli_query($mysqli, $sql);
            }

            //UPDATE FOOD_DONATION OR MONEY
            if(!empty($_POST['food_id'])) {
                $food_id = $_POST['food_id'];
                $sql = "UPDATE food_donation SET FOOD_AMOUNT = FOOD_AMOUNT + $donation_qty WHERE FOOD_ID = '$food_id'";
                $result = mysqli_query($mysqli, $sql);
            } else {
                $sql = "UPDATE event SET MONEY_AMOUNT = MONEY_AMOUNT + $donation_qty WHERE EVENT_ID = '$event_id'";
                $result = mysqli_query($mysqli, $sql);
            }
        }

        //UNDO DONATION
        if(!empty($_POST['undo_id'])) {
            $donation_id = $_POST['undo_id'];
            $donation_qty = $_POST['donation_qty'];

            //UPDATE DONATION STATUS (pending -> accepted)
            $sql = "UPDATE donation SET DONATION_STATUS = 'pending' WHERE DONATION_ID = '$donation_id'";
            $result = mysqli_query($mysqli, $sql);

            //UPDATE FOOD_DONATION OR MONEY
            if(!empty($_POST['food_id'])) {
                $food_id = $_POST['food_id'];
                $sql = "UPDATE food_donation SET FOOD_AMOUNT = FOOD_AMOUNT - $donation_qty WHERE FOOD_ID = '$food_id'";
                $result = mysqli_query($mysqli, $sql);
            } else {
                $sql = "UPDATE event SET MONEY_AMOUNT = MONEY_AMOUNT - $donation_qty WHERE EVENT_ID = '$event_id'";
                $result = mysqli_query($mysqli, $sql);
            }
        }

        //DELETE DONATION
        if(!empty($_POST['delete_id'])) {
            $delete_id = $_POST['delete_id'];

            if(!empty($_POST['money_qr'])) {
                $money_qr = $_POST['money_qr'];
                unlink(ROOT_PATH . '/' . $money_qr);
            }

            $sql = "DELETE FROM donation WHERE DONATION_ID = '$delete_id'";
            $results = mysqli_query($mysqli, $sql);
        }

        $search_type = !empty($_POST['search_type2']) ? $_POST['search_type2'] : 'pending';
        $search = !empty($_POST['search_donation']) ? mysqli_real_escape_string($mysqli, trim($_POST['search_donation'])) : '';
        
        $sql = "SELECT D.DONATION_ID, D.EVENT_ID, D.FOOD_ID, V.VOL_NAME, D.DONATION_DATE, F.FOOD_TYPE, D.MONEY_QR, D.DONATION_QTY, D.DONATION_STATUS
                FROM donation D 
                LEFT OUTER JOIN volunteer V ON D.VOL_ID = V.VOL_ID
                LEFT OUTER JOIN food_donation F ON D.FOOD_ID = F.FOOD_ID AND D.EVENT_ID = F.EVENT_ID
                WHERE DONATION_STATUS IN ('$search_type')
                AND D.EVENT_ID = '$event_id'";

        if (!empty($search)) {
            $sql .= " AND VOL_NAME LIKE '%$search%'";
        }

        $sql .= " ORDER BY D.DONATION_ID ASC;";

        $results = mysqli_query($mysqli, $sql);

        $data = '';
        while($row = mysqli_fetch_assoc($results)) {
            $date = date('F d', strtotime($row['DONATION_DATE']));
            $donation_name = !empty($row['FOOD_TYPE']) ? $row['FOOD_TYPE'] : "Money <a class='donation-qr' href='" . BASE_URL . "/" . $row['MONEY_QR'] . "' target='_blank'><div class='hover-img'><img class='show-img' src='https://img.icons8.com/?size=100&id=68826&format=png&color=C4C4C4'><span><img src='" . BASE_URL . "/" . $row['MONEY_QR'] . "'></span></div></a>";
            
            $data .= "
                <tr>
                <td> $row[DONATION_ID] </td>
                <td> $row[VOL_NAME] </td>
                <td> $date </td>
                <td> $donation_name </td>
                <td> $row[DONATION_QTY] </td>
                <td> $row[DONATION_STATUS] </td>
                <td class='action-btns'>";

            if($row['DONATION_STATUS'] === 'pending') {
                $data .= "
                    <button data-donation-id='$row[DONATION_ID]' 
                            data-food-id='$row[FOOD_ID]'
                            data-donate-qty='$row[DONATION_QTY]'
                            type='button' class='acceptDonation'><img src='https://img.icons8.com/?size=100&id=7690&format=png&color=FFFFFF'></button>
                    <button data-donation-id='$row[DONATION_ID]' 
                            data-money-qr='$row[MONEY_QR]'
                            type='button' class='deleteDonation'><img src='https://img.icons8.com/?size=100&id=67884&format=png&color=FFFFFF'></button>
                ";
            } else if ($row['DONATION_STATUS'] === 'accepted') {
                $data .= "
                    <button data-donation-id='$row[DONATION_ID]' 
                            data-food-id='$row[FOOD_ID]'
                            data-donate-qty='$row[DONATION_QTY]'
                            type='button' class='undoDonation'><img src='https://img.icons8.com/?size=100&id=95867&format=png&color=FFFFFF'></button>
                ";
            }
               
            $data .= "
                </td>
            </tr>
            ";
        }
        echo $data;
        exit();
    }


    if (isset($_POST['sponsor_id'])) {
        $event_id = $_POST['sponsor_id'];

        //SEND EMAIL
        if(!empty($_POST['sponsor_notify'])) {
            $notify_id = $_POST['sponsor_notify'];
            $email = $_POST['sponsor_email'];
            $sponsor_name = $_POST['sponsor_name'];

            $subject = "FOOD4U EVENT SPONSORSHIP";
            $message = "Dear " . $_POST['sponsor_name'] . ",";
            $message .= "<br><br>We would like to extend our thanks for your kindness in considering sponsoring our upcoming event.";
            $message .= "<br>For event details, please visit the event page: <u style='color: blue; cursor: pointer'><a href='" . BASE_URL . "/events/post.php?id=" . $event_id . "'>" . BASE_URL . "/events/post.php?id=" . $event_id . "</a></u>";
            $message .= "<br><br>The event is in need of the following donations: ";
            $message .= "<br><ol><li><b>Food Donation:</b><ul>";
            
            $sql = "SELECT * FROM food_donation WHERE EVENT_ID = '$event_id'";
            $results = mysqli_query($mysqli, $sql);
            while($row = mysqli_fetch_assoc($results)) {
                $remainder = $row['FOOD_GOAL'] - $row['FOOD_AMOUNT'];
                $message .= "<li><b>$row[FOOD_TYPE]:</b> $remainder PAX</li>";
            }

            $sql = "SELECT * FROM event WHERE EVENT_ID = '$event_id'";
            $results = mysqli_query($mysqli, $sql);
            $row = mysqli_fetch_assoc($results);
            $remainder = $row['MONEY_GOAL'] - $row['MONEY_AMOUNT'];
            $message .= "</ul></li><br><li><b>Money Donation:</b> RM$remainder </li></ol>";

            $message .= "For any questions or to confirm your sponsorship, please contact Uncle Tony by replying to this email or calling 012-8812666 (Tony). Our team will provide guidance to ensure the successful completion of the sponsorship process.";
            $message .= "<br>Thank you for your support and generosity";
            $message .= "<br><br>Best regards, <br>The Food4U Team";

            $response = sendMail($email, $subject, $message);
            if($response) {
                $sql = "UPDATE sponsor SET STATUS = 'notified' WHERE SPONSOR_ID ='$notify_id'";
                $results = mysqli_query($mysqli, $sql);
            }
        }

        
        if(!empty($_POST['sponsor_accept'])) {
            $admin_id = $_SESSION['id'];
            $accept_id = $_POST['sponsor_accept'];

            //SEND MAIL TO ALL NOTIFIED THAT IS NOT SELECTED
            $sql = "SELECT DISTINCT G.ORG_EMAIL FROM sponsor S, organization G
                    WHERE S.ORG_ID = G.ORG_ID
                    AND STATUS = 'notified' 
                    AND SPONSOR_ID NOT IN ($accept_id)";
            $results = mysqli_query($mysqli, $sql);
            while($row = mysqli_fetch_assoc($results)) {
                $deferOrgArr[] = $row['ORG_EMAIL'];
            }

            if(count($deferOrgArr) > 0) {
                $emails = $deferOrgArr;

                $subject = "FOOD4U EVENT SPONSORSHIP NOTICE";
                $message = "To whom it may concern,";
                $message .= "<br><br>Thank you very much for your interest in sponsoring our upcoming charity event. We greatly appreciate your generosity and willingness to support our cause.";
                $message .= "<br><br>We wanted to inform you that the sponsorship opportunity for this event has been filled by another organization. However, we have several other upcoming events that could benefit from your support.";
                $message .= "<br>To explore other sponsorship opportunities, please visit our events page: <u style='color: blue; cursor: pointer'><a href='" . BASE_URL . "/events.php'>" . BASE_URL . "/events.php </a></u>";
                $message .= "<br><br>If you have any questions or need further assistance, please feel free to contact Uncle Tony by replying to this email or calling 012-8812666 (Tony).";
                $message .= "<br><br>Thank you once again for your support and understanding. We look forward to the possibility of working with you on future events.";
                $message .= "<br><br>Best regards, <br>The Food4U Team";

                $response = sendMultiMail($emails, $subject, $message);
            }

            //UPDATE OTHERS SPONSOR STATUS TO 'deferred'
            $sql = "UPDATE sponsor SET STATUS = 'deferred', ADMIN_ID = '$admin_id' WHERE EVENT_ID = '$event_id'";
            $results = mysqli_query($mysqli, $sql);

            //UPDATE SELECTED SPONSOR STATUS TO 'accepted'
            $sql = "UPDATE sponsor SET STATUS = 'accepted', ADMIN_ID = '$admin_id' WHERE SPONSOR_ID = '$accept_id'";
            $results = mysqli_query($mysqli, $sql);

            //UPDATE MONEY DONATION GOAL
            $sql = "SELECT * FROM event WHERE EVENT_ID = '$event_id'";
            $results = mysqli_query($mysqli, $sql);
            $result = mysqli_fetch_assoc($results);

            $newMoneyAmount = $result['MONEY_GOAL'];
            $sql = "UPDATE event SET MONEY_AMOUNT = '$newMoneyAmount' WHERE EVENT_ID = '$event_id'";
            $results = mysqli_query($mysqli, $sql);

            //UPDATE FOOD DONATION GOAL
            $sql = "SELECT * FROM food_donation WHERE EVENT_ID = '$event_id'";
            $results = mysqli_query($mysqli, $sql);
            while($row = mysqli_fetch_assoc($results)) {
                $foodID = $row['FOOD_ID'];
                $newFoodAmount = $row['FOOD_GOAL'];
                $update_sql = "UPDATE food_donation SET FOOD_AMOUNT = '$newFoodAmount' WHERE FOOD_ID = '$foodID'";
                $update_result = mysqli_query($mysqli, $update_sql);
            }

        }
        

        $no_action_btns = false;
        $sql = "SELECT * FROM sponsor WHERE EVENT_ID = '$event_id' AND STATUS = 'accepted'";
        $results = mysqli_query($mysqli, $sql);
        $result = mysqli_fetch_assoc($results);
        if (!empty($result)) {
            $no_action_btns = true;
        }

        $sql = "SELECT s.SPONSOR_ID, s.EVENT_ID, s.ORG_ID, o.ORG_NAME, o.ORG_EMAIL, o.ORG_DESC, s.PICKUP_ADD, do.DROPOFF_ADD, s.STATUS
                FROM sponsor s
                LEFT JOIN organization o ON s.ORG_ID = o.ORG_ID
                LEFT JOIN drop_off do ON s.DROPOFF_ID = do.DROPOFF_ID
                WHERE s.EVENT_ID = $event_id";
        $results = mysqli_query($mysqli, $sql);

        $data = '';
        while($row = mysqli_fetch_assoc($results)) {
            $method = !empty($row['PICKUP_ADD']) ? 'Pick-Up' : 'Drop-Off';
            $address = !empty($row['PICKUP_ADD']) ? $row['PICKUP_ADD'] : $row['DROPOFF_ADD'];
            $data .= "
                <tr>
                <td> $row[SPONSOR_ID] </td>
                <td> <h3>$row[ORG_NAME]</h3><p>$row[ORG_DESC]</p> </td>
                <td> <h3>$method</h3><p>$address</p> </td>
                <td> $row[STATUS] </td>
                <td class='action-btns'>";

            if(!$no_action_btns) {
                if($row['STATUS'] === 'pending') {
                    $data .= "
                        <button data-sponsor-id='$row[SPONSOR_ID]' 
                                data-sponsor-email='$row[ORG_EMAIL]'
                                data-sponsor-name='$row[ORG_NAME]'
                                type='button' class='emailSponsor'><img src='https://img.icons8.com/?size=100&id=86875&format=png&color=FFFFFF'></button>
                    ";
                } else if ($row['STATUS'] === 'notified') {
                    $data .= "
                        <button data-sponsor-id='$row[SPONSOR_ID]' 
                                type='button' class='acceptSponsor'><img src='https://img.icons8.com/?size=100&id=7690&format=png&color=FFFFFF'></button>
                    ";
                }
            }
               
            $data .= "
                </td>
            </tr>
            ";
        }
        echo $data;
        exit();
    }


?>