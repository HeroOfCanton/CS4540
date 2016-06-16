<?php

require '../Projects/db_config.php';

try {
	$score = $_GET["score"];
	$initials = htmlentities($_GET["init"]);
	$output = "";
	$student_name = "";

	//
	// Connect to the data base and select it.
	//
	$db = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8", $db_user_name, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	if($score != "" && $initials != "") {

		$query = "
	   		INSERT into HighScore SET
	   		name =?,
	   		score =?" 
	   		;

	   	$statement = $db->prepare( $query );
	   	$statement->bindValue(1, $initials, PDO::PARAM_STR);
		$statement->bindValue(2, $score, PDO::PARAM_INT);
 		$result = $statement->execute(  );
        
        $query_get = "
		   SELECT * FROM HighScore
		   ORDER BY score desc
		   LIMIT 10";

		//
		// Prepare and execute the query
		//
		$statement_get = $db->prepare( $query_get );
		$statement_get->execute(  );

		//
		// Fetch all the results
		//
		$result_get = $statement_get->fetchAll(PDO::FETCH_ASSOC);

		foreach ($result_get as $row)
		    {
		      $output .=
	          "<tr>"
	          .  "<td>" .htmlspecialchars($row['name'])   ."</td>" 
	          .  "<td>" .$row['score']  ."</td>"
	          ."</tr>\n";
		    }
		    // should be last score pulled out
		    $lowest_score = $row['score'];
	    }

	else {
		//
		// Build the basic query
		//
		$query = "
		   SELECT * FROM HighScore
		   ORDER BY score desc
		   LIMIT 10";

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
	          .  "<td>" .htmlspecialchars($row['name'])   ."</td>" 
	          .  "<td>" .$row['score']  ."</td>"
	          ."</tr>\n";
		    }
		    // should be last score pulled out
		    $lowest_score = $row['score'];
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