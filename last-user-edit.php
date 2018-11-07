<?php
include 'config.php';

$today = date("Y-m-d");
$dateminus = date('Y-m-d', strtotime("-" . $daysPassed  . " days"));
$url = file_get_contents($bmlt_server. "/client_interface/json/?switcher=GetChanges&start_date=" .$dateminus. "&end_date=" .$today. "&service_body_id=" .$serviceBodyId);
$changes_results = json_decode($url,true);

try {
    $conn = new PDO("mysql:host=$dbServername;dbname=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

$gtu = $conn->prepare('SELECT * FROM `na_comdef_users` WHERE `user_level_tinyint` = 2');
$gtu->execute();

$result = $gtu->fetchAll();
$areas_u = array();
foreach ($result as $users) {
    $areas_u[] .= $users['name_string'];
}
asort($areas_u);
$bmlt_users = array_map('trim',$areas_u);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>BMLT - Last Change By User</title>
</head>
<body>

<?php

foreach ($bmlt_users as $user) {
    $user_k = getArrayKey($changes_results, 'user_name', $user);
    if (is_numeric($user_k)) {
        echo '<div style="font-weight: bold; font-size: 18pt;">' . $changes_results[$user_k]['user_name'] . '</div>';
        echo '<div style="font-weight: normal; font-size: 14pt;">Last Edit: ' . $changes_results[$user_k]['date_string'] . "<br>User: " . $changes_results[$user_k]['user_name'] . "<br>Change Type: " . str_replace ('comdef_change_type_', '', $changes_results[$user_k]['change_type']) . "<br>Meeting Name: " . $changes_results[$user_k]['meeting_name'] . "<br>Change ID: " . $changes_results[$user_k]['change_id'] . '</div>';
        echo "<br>";
    }
    else if (!is_numeric($user_k)) {
        echo '<div style="font-weight: bold; font-size: 18pt;">' . $user . '</div>';
        echo '<div style="font-weight: normal; font-size: 14pt;">No edits have been made by User: ' . $user . " in the last 60 days" . '</div>';
        echo "<br>";
    }
}

function getArrayKey($changes, $field, $value) {
    foreach($changes as $key => $change) {
        if ( $change[$field] === $value ) {
            return $key;
        }
        else if ( $change[$field] === '0' ) {
            $key = 'zero';
            return $key;
        }
    }
    return false;
}
?>

    </body>
</html>
