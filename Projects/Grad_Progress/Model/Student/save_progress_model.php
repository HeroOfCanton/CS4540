<?php

  /**
   * Author: Ryan Welling
   * Date: Spring 2016
   */
    session_start();
    require '../../../db_config.php';         // contains db connection variables
                                 // separated for security and abstraction purposes

    try {
          // The main content of the page will be in this variable
          $output = "";
//	  var_dump($_POST);
          
          // Connect to the data base and select it.
          $db = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8", $db_user_name, $db_password);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

          // Basic error checking to see if any $_POST variables are empty

          if($_POST['date'] == "" ||
             $_POST['ID'] == "" ||
             $_POST['First_Name'] == "" || 
             $_POST['Last_Name'] == "" ||
             $_POST['Track'] == "" ||
	           $_POST['Degree'] == "" ||  
             $_POST['Year_Admit'] == "" ||
             $_POST['Sem_Admit'] == "" ||
             $_POST['Advisor'] == "" ||  
             $_POST['Committee_1'] == "" ||
             $_POST['Committee_2'] == "" ||
             $_POST['Committee_3'] == "" ||  
             $_POST['Progress'] == ""
             ) 
          {
            $message = "Form has empty data. Please try again.";
          }

          else {

            // Stick the form in the Progress Database
            $query_progress = "
              INSERT into Progress SET
                  Date = '"        .($_POST['date']) ."',
                  ID = '"          .htmlentities($_POST['ID']) ."',
                  First_Name = '"  .htmlentities($_POST['First_Name']) ."',
                  Last_Name = '"   .htmlentities($_POST['Last_Name']) ."',
                  Degree = '"      .htmlentities($_POST['Degree']) ."',
                  Track = '"       .htmlentities($_POST['Track']) ."',
                  Year_Admit = '"  .htmlentities($_POST['Year_Admit']) ."',
                  Sem_Admit = '"   .htmlentities($_POST['Sem_Admit']) ."',
                  Year = '"        .htmlentities($_POST['Year_Admit']) ."',
                  Advisor = '"     .htmlentities($_POST['Advisor']) ."',
                  Committee_1 = '" .htmlentities($_POST['Committee_1']) ."',
                  Committee_2 = '" .htmlentities($_POST['Committee_2']) ."',
                  Committee_3 = '" .htmlentities($_POST['Committee_3']) ."',
                  Status = 'Unsigned',
                  Progress = '"    .htmlentities($_POST['Progress']) ."'"
              ;
//	      echo $query_progress;

            $statement_progress = $db->prepare( $query_progress );
            $result_progress = $statement_progress->execute(  );  

            // Now we have to update Students to most current Advisor
            // So let's find out if this is a new student or an existing one
            $query_students = "
                  SELECT * FROM Students
                  WHERE ID = '" .$_POST['ID'] ."'"
            ;
	    //echo $query_students;
            $statement_students = $db->prepare( $query_students );
	          $statement_students->execute(  ); 
	          $result_students = $statement_students->fetchAll(PDO::FETCH_ASSOC);

            // If there is a result, there's a student, so just update to the new advisor
            if($result_students)
              {
                $query_students_update = "
                UPDATE Students SET 
                  Advisor = '"  .htmlentities($_POST['Advisor']) ."',
                  Degree = '"   .htmlentities($_POST['Degree']) ."'
                  WHERE ID = '" .htmlentities($_POST['ID']) ."'"
                ;
    //		echo $query_students_update;
                $statement_students_update = $db->prepare( $query_students_update );
                $result_students_update = $statement_students_update->execute(  );
              }
            // This must be a new student, so let's add them to the database
            else
              {
                $query_students_insert = "
                INSERT into Students SET 
                  ID = '"         .htmlentities($_POST['ID']) ."',
                  Advisor = '"    .htmlentities($_POST['Advisor']) ."',
                  Year_Admit = '" .htmlentities($_POST['Year_Admit']) ."',
                  Sem_Admit = '"  .htmlentities($_POST['Sem_Admit']) ."',
		              Degree = '" 	  .htmlentities($_POST['Degree']) ."',
		              GPA = '3.14'"
                ;

                $statement_students_insert = $db->prepare( $query_students_insert );
                $result_students_insert = $statement_students_insert->execute(  );  
              }
//	      echo $query_students_insert;
//	      var_dump($result_progress);
//	      var_dump($result_students_insert;
//	      var_dump($result_students_update);
            if(($result_progress && $result_students_update) || 
               ($result_progress && $result_students_insert)) {
                $message = "Form Saved Successfully";
  	            $_POST = array();
            }
            else {
              $message = "Form not saved. Try again";
            }  
          }
        }    

    catch (PDOException $ex) {

      $output .= "<p>oops</p>";
      $output .= "<p> Code: {$ex->getCode()} </p>";
      $output .=" <p> See: dev.mysql.com/doc/refman/5.0/en/error-messages-server.html#error_er_dup_key";
      $output .= "<pre>$ex</pre>";

      if ($ex->getCode() == 23000) {
        $output .= "<h2> Duplicate Entries not allowed </h2>";
      }
    }
?>
