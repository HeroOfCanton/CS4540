<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 

<?php 
session_start();

unset($_SESSION['ID']);
unset($_SESSION['Role']);
unset($_SESSION['Login']);
unset($_SESSION['First_Name']);
unset($_SESSION['Last_Name']);

$_POST = array();

?>
    <html lang="en"> 
        <head>
          <title>LOGGED OUT</title> 
      
          <!-- Meta Information about Page -->
          <meta charset="utf-8" />
          <meta name="AUTHOR"      content="Ryan Welling"/>
          <meta name="keywords"    content="University of Utah, Spring 2016"/>
          <meta name="description" content="Logged Out"/>
      
          <!-- ALL CSS FILES -->
          <link rel="stylesheet" type="text/css" href="Resources/CSS/global.css">
          </head>

        <body>       
        	<div align="center">
				<h1>YOU HAVE BEEN LOGGED OUT</h1>
				<h3>Please use your browser's back button to return the previous page.</h3>
				<h3>If you'd like to login again, please click the button below.</h3>
				<a href="entrance.php"><button class="btn"><span>Login</span></button></a>
			</div>
		</body>

	</html>
