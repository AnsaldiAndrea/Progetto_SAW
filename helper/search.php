<?php

function search($data) {
    include("helper/connection.php");
    $input = clear_input($data);
    $title = $input['title'];
    $city = $input['city'];
    $tags = $input['tags'];
    
    $title_search = $city_search = $tags_search = "";

    $search_query = "SELECT distinct id,game,host,address,lat,lng,date,comment from Game |tags| where status=1";
    $query_list = [];
    if($tags) {
        $tags_search = " tag in (".implode(',', $tags).")";
        $search_query = str_replace("|tags|", "join GameTags on id=game_id", $search_query); 
        array_push($query_list, $tags_search);
    } else {
        $search_query = str_replace("|tags|", "", $search_query);
    }
    if($title) {
        $title_search = " game like '%$title%' ";
        array_push($query_list, $title_search);
    }
    if($city) {
        $city_search = " address like '%,%$city%' ";
        array_push($query_list, $city_search);    
    }
    if($query_list) {
        $search_query = $search_query." and ".implode(' and ', $query_list);
    }
    $result = [];
    $stmt = $conn->prepare($search_query);
    if($stmt->execute()) {
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    $stmt->close();
    $conn->close();
    return $result;
}

function clear_input($input){
    include("helper/connection.php");
    include_once("helper/functions.php");

    $title = $city = "";
    $tags = array();

    if(check_value_get('titolo')){
        $title = sanitize($conn, $input['titolo']);
    }
    if(check_value_get('citta')){
        $city = sanitize($conn, $input['citta']);
    }
    if(check_value_get('tags')){
        if(is_array($input['tags'])){
            foreach($input['tags'] as $t){
                array_push($tags, intval($t));
            }
        } else {
            $_SESSION['error'] = ['danger', 'Richista non inviata correttamente'];
            return array();
        }
    }
    return array("title"=>$title, "city"=>$city, "tags" => $tags);
}

?>