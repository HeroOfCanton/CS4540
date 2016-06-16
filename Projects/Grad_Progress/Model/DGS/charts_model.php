<?php
session_start();

require '../../../db_config.php';

try {
	$output = "";
	$advisor = array();
	$count = array();
	$year = array();
	$chart = $_GET['chart'];

	//
	// Connect to the data base and select it.
	//
	$db = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8", $db_user_name, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

		if ($chart == 'gpa') {

			//
			// Build the basic query
			//
			$query = "SELECT round(gpa, 1) AS Rounded, count(*) AS Total, 
								(COUNT(*) / (SELECT COUNT(*) FROM Students)) * 100 AS Percentage 
								FROM Students
								group by rounded
								order by Total desc
								";

			//
			// Prepare and execute the query
			//
			$statement = $db->prepare( $query );
			$statement->execute(  );

			//
			// Fetch all the results
			//
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);

			$gpaArr = array();
			foreach ($result as $row) {
				if ($row['Rounded'] == '4.0') {
					$gpaArr[] = array('name' => $row['Rounded'], 'y' => $row['Percentage'], 'sliced' => 'true', 'selected' => 'true');
				}
				else {
		    	$gpaArr[] = array('name' => $row['Rounded'], 'y' => $row['Percentage']);
				}
		  }

		  $json = json_encode($gpaArr, JSON_NUMERIC_CHECK);

	  	require '../../View/DGS/gpa_chart_view.php';
		}
		else if ($chart == 'student'){

	  // New query for number of students per advisor
	  $query = "SELECT Advisor, count(*) AS count from Students
							group by Advisor
							order by Students.Advisor asc";

		// Prepare and execute the query
		$statement = $db->prepare( $query );
		$statement->execute(  );

		// Fetch all the results
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		foreach ($result as $row) {
	    	$advisor[] = $row['Advisor'];
	    	$count[] = $row['count'];
	  }

	  $json_count = json_encode($count);
	  $json_advisor = json_encode($advisor);

	  require '../../View/DGS/advisor_chart_view.php';
		}

		else {

		// New query for number of students per advisor
	  $query = "SELECT Year_Admit, count(*) as count FROM Progress
							group by Year_Admit
							order by Year_Admit asc";

		// Prepare and execute the query
		$statement = $db->prepare( $query );
		$statement->execute(  );

		// Fetch all the results
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);

		foreach ($result as $row) {
	    	$year[] = array($row['Year_Admit'], $row['count']);
	  }

	  $json = json_encode($year, JSON_NUMERIC_CHECK);

	  require '../../View/DGS/admit_chart_view.php';
			
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