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
  $login = $_GET['login'];
  $edit_form = True;
  $_SESSION['edit'] = "yes";
  
  //
  // Connect to the data base and select it.
  //
  $db = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8", $db_user_name, $db_password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  //
  // Basic error checking to see if any $_POST variables are empty
  //

  // Build that query
  $query = "
    SELECT * FROM Users
      WHERE Login = '" .$login ."'"
    ;
  
  $statement = $db->prepare( $query );
  $statement->execute(  );
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);

  // Build the web page for the results
  if ( empty( $result ) )
    {
      $output .= 
           "NO FORM AVAILABLE, HOW DID YOU GET HERE??!";
    }
  else
    {
      foreach ($result as $row)
        {

          // Don't show the form to student who isn't authorized
          if($_SESSION['Role'] != "Faculty" && ($_SESSION['ID'] != $row['ID']))
          {
            header("Location: /not_auth.php");
          }
          
          $_POST['UID'] =        htmlentities($row['ID']);   
          $_POST['First_Name'] = htmlentities($row['First_Name']);
          $_POST['Last_Name'] =  htmlentities($row['Last_Name']);  
          $_POST['Login'] =      htmlentities($row['Login']);
          $_SESSION['edit'] =    "yes";
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