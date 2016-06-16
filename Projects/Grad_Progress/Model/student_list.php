<?php

  /*
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

  //
  // Build the basic query
  //
  $query = "
       SELECT First_Name, Last_Name, ID FROM Users
       WHERE Position='Student' 
   ";
   
  //
  // Prepare and execute the query
  //
  $statement = $db->prepare( $query );
  $statement->execute(  );

  //
  // Fetch all the results
  //
  $result    = $statement->fetchAll(PDO::FETCH_ASSOC);

  //
  // Build the web page for the results
  //

  if ( empty( $result ) )
    {
      $output .= 
           "<tr>"
          .  "<td>NO DATA</td>"
          ."</tr>\n";
    }
  else
    {
      foreach ($result as $row)
	     {
	       $output .=
          "<tr>"
          .  "<td><a href='Student/student_forms.php?id=" .$row['ID'] ."'>" 
          .  $row['First_Name'] . " " .$row['Last_Name'] 
          .  "</a></td>"
          ."</tr>\n";
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
      $output .= "<h2> Duplicate Entries not allowed </h2>";
    }
}