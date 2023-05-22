<?php
require_once('includes/db.php');

function getOne($table, $camp,$value,$conn){
    $query = "SELECT * FROM $table WHERE $camp='$value'";
    $response = mysqli_query($conn, $query);
    return $response;
}

function create($table, array $data, array $value ,$conn){
    $col_str = implode(", ", $data);
    $val_str = "'" . implode("', '", $value) . "'";

    $query = "INSERT INTO $table ( $col_str) VALUES ( $val_str)";
    $create = mysqli_query($conn, $query);
    return $create;
}

function update($table, array $key_value, $id, $conn){
    $query = "UPDATE $table SET ";

    foreach($key_value as $key => $value) {
        $key_value[] = "{$key} = '{ $value}'";
    }

    $query .= implode(" , ",$key_value)." WHERE `id` = '$id'"; 
    $result = mysqli_query($conn, $query);
    return $result;   
}

function delete($table, $camp,$value, $conn){
    $query = "DELETE FROM $table WHERE $camp='$value'";
    $response = mysqli_query($conn, $query);
    return $response;
}