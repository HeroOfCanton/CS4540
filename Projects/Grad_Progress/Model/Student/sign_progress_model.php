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
                UPDATE Progress
                SET Status = 'Signed'
                WHERE Form_ID = '" .$form_ID ."'"
                ;
       
      //
      // Prepare and execute the query
      //
      $statement = $db->prepare( $query );
      $result = $statement->execute(  );
      if ($result)
        {
          $message = "Form Signed Successfully";
        }
      else
        {
          $message = "Form not signed, try again.";
        }

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

      //
      // Build the web page for the results
      //

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
              .  "<td>" .$row['Status'] ."</td>"
              ."</tr>\n";

              $prog_data = $row['Progress'];
            }

          // Make the signed button appear if needed  
          if($row['Status'] == "Unsigned")
            {
              $unsigned = '<a href="sign_progress.php?form_ID=' .$row[Form_ID] .'">Sign Form</a>';
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