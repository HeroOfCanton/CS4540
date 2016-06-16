<?php

  /**
   * Author: Ryan Welling
   * Date: Spring 2016
   */
session_start();
require '../../../db_config.php'; // contains db connection variables
                                  // separated for security and abstraction purposes

  try
    {

      if($_SESSION['Role'] == "")
      {
        header("Location: ../not_auth.php");
      }

      $output = "";
      $form_ID = $_GET['form_ID'];
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
           SELECT ID, First_Name, Last_Name, Degree, Track,
                  Year_Admit, Sem_Admit, Advisor, Committee_1, Committee_2, 
                  Committee_3, Progress FROM Progress
            WHERE Form_ID=" .$form_ID ."";
       
      // Prepare and execute the query
      $statement = $db->prepare( $query );
      $statement->execute(  );

      //
      // Fetch all the results
      //
      $result    = $statement->fetchAll(PDO::FETCH_ASSOC);

      // Build the web page for the results
      if ( empty( $result ) )
        {
          $output .= 
               "<tr>"
              .  "<td>NO FORM AVAILABLE</td>"
              ."</tr>\n";
        }
      else
        {
          foreach ($result as $row)
            {

              $_POST['ID'] = $row['ID'];   
              $_POST['First_Name'] = $row['First_Name'];
              $_POST['Last_Name'] = $row['Last_Name'];  
              $_POST['Degree'] = $row['Degree'];     
              $_POST['Track'] = $row['Track'];      
              $_POST['Year_Admit'] = $row['Year_Admit'];   
              $_POST['Sem_Admit'] = $row['Sem_Admit'];    
              $_POST['Advisor'] = $row['Advisor'];      
              $_POST['Committee_1'] = $row['Committee_1'];  
              $_POST['Committee_2'] = $row['Committee_2'];  
              $_POST['Committee_3'] = $row['Committee_3'];  
              $_POST['Progress'] = $row['Progress'];
              $_POST['Year'] = $row['Year_Admit'];
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
?>