<?php

  /**
   * Author: Ryan Welling
   * Date: Spring 2016
   */
session_start();
require '../../../db_config.php';         // contains db connection variables
                                 // separated for security and abstraction purposes

try
{
  //
  // Let's set some variables!
  //
  $output = "";

  // Check the role
  if(isset($_SESSION['Role']))
  {
    // If you're a student, let's make sure you can't access someone else's page
    if($_SESSION['Role'] == "Student")
    {
      $ID = $_SESSION['ID'];
    }
    // If you're not a Student, don't matter, you came here via $_GET
    else 
    {
      $ID = $_GET['id'];
    }
  }
  else
  {
    header("Location: ../not_auth.php");
  }
  $student_name = "";

  // Connect to the data base and select it.
  $db = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8", $db_user_name, $db_password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  // Build the basic queries
  $query = "
       SELECT Form_ID, First_Name, Date, Degree, Track, Advisor FROM Progress
       WHERE ID=" .$ID ."";

  $query_info = "
       SELECT First_Name, Last_Name, ID, Login FROM Users
       WHERE ID=" .$ID ."";
   
  // Prepare and execute the query
  $statement = $db->prepare($query);
  $statement->execute( );

  $statement_info = $db->prepare($query_info);
  $statement_info->execute( );

  // Fetch all the results
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);

  $result_info = $statement_info->fetchAll(PDO::FETCH_ASSOC);

  //
  // Build the web page for the results
  //

  if (empty($result))
    {
      $output .= 
           "<tr>"
          .  "<td>STUDENT HAS NOT SUBMITTED ANY FORMS</td>"
          ."</tr>\n";
    }
  else if(empty( $result_info ))
    {
      $output_info .= 
           "<tr>"
          .  "<td>STUDENT DOES NOT EXIST. HOW DID YOU GET HERE??!</td>"
          ."</tr>\n";
    }
  else
    {
      foreach ($result as $row)
	     {
	     $student_name = $row['First_Name'];

	       $output .=
          "<tr>"
          .  "<td><a href='../Student/indiv_form.php?form_id=" .$row['Form_ID'] ."'>" .$row['Form_ID'] ."</a></td>" 
          .  "<td>" .$row['Date']     ."</td>"
          .  "<td>" .$row['Degree']   ."</td>"
          .  "<td>" .$row['Track']    ."</td>"
          .  "<td>" .$row['Advisor']  ."</td>"
          ."</tr>\n";
	     }

       foreach ($result_info as $row)
       {
         $output_info .=
          "<tr>"
          .  "<td>" .$row['First_Name']     ."</td>"
          .  "<td>" .$row['Last_Name']   ."</td>"
	        .  "<td><a href='../edit_user.php?login=" .$row['Login'] ."'>" .$row['Login'] ."</a></td>"
          .  "<td>" .$row['ID']  ."</td>"
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