<?php
session_start();

require '../../../db_config.php';

try {
	$output = "";
	$ID = $_GET['id'];

	//
	// Connect to the data base and select it.
	//
	$db = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8", $db_user_name, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	//
	// Build the basic query
	//
	$query = "SELECT * FROM Students
						WHERE ID = '" .$ID ."'";

	//
	// Prepare and execute the query
	//
	$statement = $db->prepare( $query );
	$statement->execute(  );

	//
	// Fetch all the results
	//
	$result    = $statement->fetchAll(PDO::FETCH_ASSOC);

	foreach ($result as $row)
	    {
	    	$output .=
          "<tr>"
          .  "<td>" .$row['ID']    			."</td>" 
          .  "<td>" .$row['Degree']     ."</td>"
          .  "<td>" .$row['Year_Admit'] ."</td>"
          .  "<td>" .$row['Sem_Admit'] 	."</td>"
          .  "<td>" .$row['Advisor']  	."</td>"
          .  "<td>" .$row['gpa']     		."</td>" 
          ."</tr>\n";
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