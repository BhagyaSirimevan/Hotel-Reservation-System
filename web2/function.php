<?php

// Data clean customized function
function cleanInput($input = null) {
    return htmlspecialchars(stripcslashes(trim($input)));
}

function dbConn() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "nectar_mount_resort";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database Coneection Error " . $conn->connect_error);
    } else {
        return $conn;
    }
}

function contactNoValidation($contact) {

    $pattern = '/^0[0-9]{9}$/'; // Pattern to validate 10 digit number starting with 0

    if (!preg_match($pattern, $contact)) {
        return true;
    }
}

function emailValidation($email) {

    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        return true;
    }
}

function nicValidation($nic) {
     
    // d - digits
    // $ - end of the string
        if (!preg_match("/^([\d]{9}[vV]{1})$/", $nic) && !preg_match("/^[\d]{12}$/", $nic)) {
            
            return true;
           
        }
        
        
     
}

function genderValidation($nic) {
    if(preg_match("/^([\d]{9}[vV]{1})$/", $nic)){
            $ThreeDigits = substr($nic, 2, 3);
            return $ThreeDigits;
            
        } elseif (preg_match("/^[\d]{12}$/", $nic)) {
            $ThreeDigits = substr($nic, 4, 3);
             return $ThreeDigits;
    }
}

// get updated field names
function updatedFields($olddata ,$newdata){
    // $olddata = array with existing record details in the database
    // $newdata = array with submitted details in the form after update
   
    // create an array for store updated field names 
    $updated = array();
    
    // ex: $olddata as title=>Mr
    foreach ($olddata as $oldfield=>$oldvalue){
        // ex: $newdata as $title=>Miss
        foreach ($newdata as $newfield=>$newvalue){
            // ex: $title==$title && Mr!=Miss
            if($oldfield==$newfield && $oldvalue!=$newvalue){
                
                // assign updated field name ex: $updated[0]="title";
                $updated[]=$oldfield;
                break;
            }
        }
    }
   return $updated; 
}

function textFieldValidation($text) {

    $pattern = '/^[A-Za-z\s]+$/'; // Pattern to validate 10 digit number starting with 0

    if (!preg_match($pattern, $text)) {
        return true;
    }
}


?>