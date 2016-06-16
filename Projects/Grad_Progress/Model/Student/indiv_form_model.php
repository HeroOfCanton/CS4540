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
  // The main content of the page will be in this variable
  //

  // Check the role
  if(isset($_SESSION['Role']))
  {
    // If you're a student, let's make sure you can't access someone else's page
    if($_SESSION['Role'] == "Student")
    {
      $form_ID = $_GET['form_id'];
    }
    // If you're not a Student, don't matter, you came here via $_GET
    else 
    {
      $form_ID = $_GET['form_id'];
    }
  }
  else
  {
    header("Location: ../not_auth.php");
  }
  $output = "";
  $student_name = "";
  
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
       SELECT Form_ID, Date, ID, First_Name, Last_Name, Degree, Track,
              Year_Admit, Sem_Admit, Advisor, Committee_1, Committee_2, 
              Committee_3, Progress, Status FROM Progress
        WHERE Form_ID=" .$form_ID ."";
   
  //
  // Prepare and execute the query
  //
  $statement = $db->prepare( $query );
  $statement->execute(  );

  //
  // Fetch all the results
  //
  $result    = $statement->fetchAll(PDO::FETCH_ASSOC);

  // Make sure students can't access each other's forms
  if($_SESSION['Role'] == "Student")
    {
      foreach ($result as $row)
      {
        if($_SESSION['ID'] != $row['ID'])
        {
           header("Location: ../not_auth.php");
        }
      }
    }

    // Start building the page
  if ( empty( $result ) )
    {
	 if($_SESSION['ID'] != $row['ID'])
        {
           header("Location: ../not_auth.php");
        }

	
      $output .= 
           "<tr>"
          .  "<td>NO FORM AVAILABLE</td>"
          ."</tr>\n";
    }
  else
    {
      foreach ($result as $row)
        {

          $student_name = $row['First_Name'];
          $output .=
          "<tr>"
          .  "<td>" .$row['Form_ID']    ."</td>" 
          .  "<td>" .$row['Date']       ."</td>"
          .  "<td>" .$row['ID']         ."</td>"
          .  "<td>" .$row['First_Name'] ."</td>"
          .  "<td>" .$row['Last_Name']  ."</td>"
          .  "<td>" .$row['Degree']     ."</td>" 
          .  "<td>" .$row['Track']      ."</td>"
          .  "<td>" .$row['Year_Admit'] ."</td>"
          .  "<td>" .$row['Sem_Admit']  ."</td>"
          .  "<td>" .$row['Advisor']    ."</td>"
          .  "<td>" .$row['Committee_1']."</td>"
          .  "<td>" .$row['Committee_2']."</td>" 
          .  "<td>" .$row['Committee_3']."</td>"
          .  "<td>" .$row['Status']	."</td>"
          ."</tr>\n";

          $prog_data = $row['Progress'];
        }

      // Make the signed button appear if needed  
      if($row['Status'] == "Unsigned")
	      {
		      $unsigned = '<a href="sign_progress.php?form_ID=' .$row[Form_ID] .'" class="btn btn-s btn-success">Sign Form <span class="glyphicon glyphicon-pencil"></span></a>';
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