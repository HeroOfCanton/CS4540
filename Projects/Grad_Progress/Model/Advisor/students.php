<?php

  /**
   * Author: H. James de St. Germain
   * Date: Spring 2015
   *
   *  Sample code for using PHP PDO object
   *
   * Note separation of main PHP from main HTML using output variable
   */
session_start();
require '../../../db_config.php';         // contains db connection variables
                                 // separated for security and abstraction purposes

try
{
  //
  // The main content of the page will be in this variable
  //
  
  if(isset($_SESSION['Role']))
  {
    // If you're a student, let's make sure you can't access someone else's page
    if($_SESSION['Role'] == "Student")
    {
      header("Location: ../not_auth.php");
    }
    // If you're not a Student, don't matter, you came here via $_GET
    else 
    {
      $lastName = $_GET['lastName'];
    }
  }
  else
  {
    header("Location: ../not_auth.php");
  }
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
  $query_student = "
       SELECT Users.ID, First_Name, Last_Name, Advisor from Users
        LEFT JOIN Students on Users.ID=Students.ID
        WHERE Students.Advisor='" .$lastName ."'";

  $query_forms = "
       SELECT Form_ID, Date, First_Name, Last_Name FROM Progress
        WHERE Status='Unsigned'";
   
  //
  // Prepare and execute the query
  //
  $statement_student = $db->prepare( $query_student );
  $statement_student->execute(  );

  $statement_forms = $db->prepare( $query_forms );
  $statement_forms->execute(  );

  //
  // Fetch all the results
  //
  $result_student = $statement_student->fetchAll(PDO::FETCH_ASSOC);
  $result_forms = $statement_forms->fetchAll(PDO::FETCH_ASSOC);

  //
  // Build the web page for the results
  //

  if ( empty( $result_student ) )
    {
      $output_student .= 
           "<tr>"
          .  "<td>This advisor has no students</td>"
          ."</tr>\n";
    }
  else if ( empty( $result_forms ) )
    {
      $output_forms .= 
           "<tr>"
          .  "<td>This advisor has no forms to sign</td>"
          ."</tr>\n";
    }
  else
    {
      foreach ($result_student as $row_student)
	     {
	       $output_student .=
          "<tr>"
          .  "<td><a href='../Student/student_forms.php?id=" .$row_student['ID'] ."'>" 
          .  $row_student['First_Name'] . " " .$row_student['Last_Name'] 
          .  "</a></td>"
          ."</tr>\n";
	     }
       $count_forms = 0;
       foreach ($result_forms as $row_forms)
       {
         $output_forms .=
          "<tr>"
          .  "<td>
                <a href='../Student/indiv_form.php?form_id=" .$row_forms['Form_ID'] ."'>" .  $row_forms['Form_ID'] . "</a>
              </td>"
          .  "<td>"
                .$row_forms['First_Name'] ." ".$row_forms['Last_Name']
          .   "</td>"
          ."</tr>\n";
          $count_forms++;
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