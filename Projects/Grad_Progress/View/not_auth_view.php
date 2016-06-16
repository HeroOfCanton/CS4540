<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 

  <html lang="en"> 
      <head>
        <title>UNAUTHORIZED ACCESS</title> 
    
        <!-- Meta Information about Page -->
        <meta charset="utf-8" />
        <meta name="AUTHOR"      content="Ryan Welling"/>
        <meta name="keywords"    content="University of Utah, Spring 2016"/>
        <meta name="description" content="Not Authorized"/>
    
        <!-- ALL CSS FILES -->
        <link rel="stylesheet" type="text/css" href="Resources/CSS/global.css">
        </head>

      <body>       
      	<div align="center">
  				<h1>UNAUTHORIZED ACCESS NOT ALLOWED</h1>
          <h3>Hello <?= $_SESSION['First_Name']; ?></h3>
  				<h3>Please use your browser's back button to return the previous page.</h3>
  				<h3>If you'd like to go straight to login, please click the button below.</h3>
  				<a href="entrance.php"><button class="btn"><span>Login</span></button></a>
		    </div>
	    </body>
  </html>
