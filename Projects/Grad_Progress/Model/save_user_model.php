<?php

  /**
   * Author: Ryan Welling
   * Date: Spring 2016
   */

require '../../db_config.php';         // contains db connection variables
                                 // separated for security and abstraction purposes
session_start();
  try
  {
    //
    // The main content of the page will be in this variable
    //
    $output = "";
    
    //
    // Connect to the data base and select it.
    //
    $db = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8", $db_user_name, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // If we're not editing the form, this is a new form
    if($_SESSION['edit'] != "yes" || $_SESSION['edit'] == "")
    {
      // Check to make sure they filled it all out
      // Because Safari :(
      if($_POST['UID'] == "" | 
         $_POST['First_Name'] == "" | 
         $_POST['Last_Name'] == "" | 
         $_POST['Login'] == "" |
         $_POST['password1'] == "" | 
         $_POST['password2'] == ""
         )
      {
        $message = "Form has empty data. Please try again.";
      }
      // Make sure password fields match
      else if($_POST['password1'] != $_POST['password2'])
      {
        $message = "Passwords do not match. Please try again.";
      }
      // Things look good, let's stick it in the database
      else 
      {
        $login = trim($_POST['Login']);
        $password = trim($_POST['password1']);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Build that query
        $query = "
          INSERT into Users SET
            ID = '" .htmlentities($_POST['UID']) ."',
            Login = '" .htmlentities($login) ."',
            First_Name = '" .htmlentities($_POST['First_Name']) ."',
            Last_Name = '" .htmlentities($_POST['Last_Name']) ."',
            Hashword = '" .$hashedPassword ."',
            Position = 'Student'"
          ;
        
        $statement = $db->prepare( $query );
        $result = $statement->execute(  );  

        // If it executes, DB saved information, setup SESSION and go
        if($result)
        {
          $message = "User Saved Successfully. User has role of Student until DGS updates.";
          if(!isset($_SESSION['ID']) || !isset($_SESSION['Login']) || !isset($_SESSION['Role']))
          {
            $_SESSION['ID'] =         htmlentities($_POST['UID']);
            $_SESSION['Role'] =       "Student";
            $_SESSION['Login'] =      htmlentities($_POST['Login']);
            $_SESSION['First_Name'] = htmlentities($_POST['First_Name']);
            $_SESSION['Last_Name'] =  htmlentities($_POST['Last_Name']);
          }
          $_POST = array();
        }
        // Problem with DB
        else 
        {
          $message = "User not Saved. Please try again";
        }   
      }
    }
    // We are editing the form
    else
    { 
      // Because Safari :(
      if(
         $_POST['First_Name'] == "" | 
         $_POST['Last_Name'] == "" | 
         $_POST['Login'] == ""
         )
        {
          $message = "Form has empty data. Please try again.";
        }
      else
      {
        // Build that query
        $query = "
          UPDATE Users SET
            Login = '"      .htmlentities($_POST['Login']) ."',
            First_Name = '" .htmlentities($_POST['First_Name']) ."',
            Last_Name = '"  .htmlentities($_POST['Last_Name']) ."'
          WHERE ID = '" .$_SESSION['ID'] ."'"
          ;
        
        $statement = $db->prepare( $query );
        $result = $statement->execute(  );  

        if($result)
        {
            $_SESSION['Login'] =      htmlentities($_POST['Login']);
            $_SESSION['First_Name'] = htmlentities($_POST['First_Name']);
            $_SESSION['Last_Name'] =  htmlentities($_POST['Last_Name']);
            $_SESSION['edit'] =       "no";
            
            $_POST = array();
            $message = "User Information Edited successfully";
        }
        else 
        {
          $message = "User not Saved. Please try again";
        } 
      }
    }
  }

  catch (PDOException $ex)
  {

    $output .= "<p>oops</p>";
    $output .= "<p> Code: {$ex->getCode()} </p>";
    $output .=" <p> See: dev.mysql.com/doc/refman/5.0/en/error-messages-server.html#error_er_dup_key";
    $output .= "<pre>$ex</pre>";

    if ($ex->getCode() == 23000)
    {
      $output .= "<b>Duplicate Entries not allowed</b>";
    }
  }
?>