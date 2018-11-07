<?php
include 'config.php';
date_default_timezone_set($timeZone);

$today = date("Y-m-d");
$dateMinus = date('Y-m-d', strtotime("-" . $daysPassed  . " days"));
$url = file_get_contents($bmltServer. "/client_interface/json/?switcher=GetChanges&start_date=" .$dateMinus. "&end_date=" .$today. "&service_body_id=" .$serviceBodyId);
$results = json_decode($url,true);

if (isset($usersArray)) {
    $bmltUsers = array_map('trim',$usersArray);
}

else {
    try {
        $conn = new PDO("mysql:host=$dbServerName;dbname=$dbName", $dbUserName, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }

    $getUsers = $conn->prepare('SELECT * FROM `na_comdef_users` WHERE `user_level_tinyint` = 2');
    $getUsers->execute();

    $result = $getUsers->fetchAll();
    $serviceBodyUsers = array();
    foreach ($result as $users) {
        $serviceBodyUsers[] .= $users['name_string'];
    }
    asort($serviceBodyUsers);
    $bmltUsers = array_map('trim',$serviceBodyUsers);
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>BMLT - Last Change By User</title>
</head>
<body>

<?php

foreach ($bmltUsers as $user) {
    $userKeys = getArrayKey($results, 'user_name', $user);
    if (is_numeric($userKeys)) {
        echo '<div style="font-weight: bold; font-size: 18pt;">'
            . $results[$userKeys]['user_name']
            . '</div>';
        echo '<div style="font-weight: normal; font-size: 14pt;">Last Edit: ' . $results[$userKeys]['date_string']
            . "<br>User: " . $results[$userKeys]['user_name']
            . "<br>Change Type: " . str_replace ('comdef_change_type_', '', $results[$userKeys]['change_type'])
            . "<br>Meeting Name: " . $results[$userKeys]['meeting_name']
            . "<br>Change ID: " . $results[$userKeys]['change_id']
            . '</div>';
        echo "<br>";
    }
    else if (!is_numeric($userKeys)) {
        echo '<div style="font-weight: bold; font-size: 18pt;">'
            . $user
            . '</div>';
        echo '<div style="font-weight: normal; font-size: 14pt;">No edits have been made by User: ' . $user
            . " in the last " . $daysPassed . " days"
            . '</div>';
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
