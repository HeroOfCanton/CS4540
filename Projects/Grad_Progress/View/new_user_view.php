<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 

    <html lang="en"> 
        <head>
          <title>New User Form</title> 
      
          <!-- Meta Information about Page -->
          <meta charset="utf-8" />
          <meta name="AUTHOR"      content="Ryan Welling"/>
          <meta name="keywords"    content="University of Utah, Spring 2016"/>
          <meta name="description" content="New User Form"/>
      
          <!-- ALL CSS FILES -->
          
           <!-- ALL CSS FILES -->
          <!-- Latest compiled and minified CSS -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

			<!-- Optional theme -->
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

			<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

			<!-- Latest compiled and minified JavaScript -->
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

          <script type="text/javascript">
          	$(document).ready(function() { 
      			
      			$('.dropdown').hover(
			        function() {
			            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn();
			        }, 
			        function() {
			            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut();
			        }
			    	);

				    $('.dropdown-menu').hover(
			        function() {
			            $(this).stop(true, true);
			        },
			        function() {
			            $(this).stop(true, true).delay(200).fadeOut();
			        }
				    );
          		});
          </script>
          </head>

        <body style="padding-top: 70px;">        

			<div id = header>
			<?php
				if($edit_form)
				{
					$form_title = "Edit";
					$req = "";
				}
				else
				{
					$form_title = "New";
					$req = "required";
				}
			?>
				<div align="center">	
				<h1><?= $form_Title; ?> User Form</h1>
				</div>
			</div>
		
		<!-- Navigation -->
		    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		        <div class="container">
		            <!-- Brand and toggle get grouped for better mobile display -->
		            <div class="navbar-header">
		                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		                    <span class="sr-only">Toggle navigation</span>
		                    <span class="icon-bar"></span>
		                    <span class="icon-bar"></span>
		                    <span class="icon-bar"></span>
		                </button>
		                <a class="navbar-brand" href="#">Graduate Tracker</a>
		            </div>
		            <!-- Collect the nav links, forms, and other content for toggling -->
		            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	                <ul class="nav navbar-nav navbar-right">
	                  	<li class="dropdown">
		                  	<a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false" title="Main">Main / Email</a>
							<ul class="dropdown-menu">
								<li><a href="href=../../index.html" title="Main Page">Main Page</a></li>
								<li><a href="mailto:ryan@ryanwelling.com" title="Email Me">Email Me</a></li>
							</ul> 
						</li>

						<!-- Next Main Menu Item -->
						<li><a href="index.html" title="Grad Progess Main Page">Grad Progress Main</a></li>

						<!-- Next Main Menu Item -->
						<li class="active"><a href="entrance.php" title="Entrance Portal">Entrance Portal</a></li>
						<?php 
                        if($_SESSION['Role'] == Student)
                        {
                            $navelem = '<li><a href="Student/student_forms.php" title="Student Form">Your Forms</a></li>';
                        }
                        else if($_SESSION['Role'] == Faculty)
                        {
                            $navelem = '<li><a href="Advisor/students.php?lastName=' .$_SESSION['Last_Name'] .'" title="Advisor Portal">List of Students</a></li>';
                        }
	                    ?>
	                    <!-- Next Main Menu Item -->
	                  	<?= $navelem; ?>
	                </ul>
		            </div>
		            <!-- /.navbar-collapse -->
		        </div>
		        <!-- /.container -->
		    </nav>

			<p style="margin-top: 10px; margin-bottom: 0px; font-size: 200%;" align="center">WELCOME!</p>
			<p style="margin-bottom: 10px;" align="center">Please fill out the entire form</p>

			<form class="form-horizontal" action="save_user.php" method="post">
				<fieldset>

				<!-- Form Name -->
				<legend align="center">New User Registration Form</legend>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="First_Name">First Name</label>  
				  <div class="col-md-4">
				  <input id="First_Name" name="First_Name" type="text" placeholder="John" class="form-control input-md" pattern="[a-zA-Z]+" value="<?= $_POST['First_Name']; ?>" autofocus required="">
				  <span class="help-block">Enter your first name only</span>  
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="Last_Name">Last Name</label>  
				  <div class="col-md-4">
				  <input id="Last_Name" name="Last_Name" type="text" placeholder="Smith" class="form-control input-md" pattern="[a-zA-Z]+" value="<?= $_POST['Last_Name']; ?>" required="">
				  <span class="help-block">Enter your last name only</span>  
				  </div>
				</div>

				<!-- Prepended text-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="UID">University ID</label>
				  <div class="col-md-4">
				    <div class="input-group">
				      <!--<span class="input-group-addon">0</span>-->
				      <input id="UID" name="UID" class="form-control" placeholder="0123456" type="text" maxlength="7" pattern="[0-9]+" value="0<?= $_POST['UID']; ?>" required="">
				    </div>
				    <p class="help-block">Must be 7 digits; numbers only</p>
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="Login">Login</label>  
				  <div class="col-md-4">
				  <input id="Login" name="Login" type="text" placeholder="JohnSmith123" class="form-control input-md" minlength="8" pattern="[a-zA-Z0-9]+" value="<?= $_POST['Login']; ?>" required="">
				  <span class="help-block">Must be at least 8 characters; AlphaNumeric only</span>  
				  </div>
				</div>

				<!-- Password input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="password1">Password</label>
				  <div class="col-md-4">
				    <input id="password1" name="password1" type="password" placeholder="" class="form-control input-md" minlength="8" value="<?= $_POST['password1']; ?>" <?= $req; ?>>
				    <span class="help-block">Must be at least 8 characters long</span>
				  </div>
				</div>

				<!-- Password input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="password2">Please Re-Enter Password</label>
				  <div class="col-md-4">
				    <input id="password2" name="password2" type="password" placeholder="" class="form-control input-md" minlength="8" value="<?= $_POST['password2']; ?>" <?= $req; ?>>
				    <span class="help-block">Passwords must match</span>
				  </div>
				</div>

				<!-- Button -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="saveForm">Submit</label>
				  <div class="col-md-4">
				    <button id="saveForm" name="saveForm" class="btn btn-success" value="Submit">Submit Form</button>
				  </div>
				</div>

				</fieldset>
			</form>
				<div id="form_message">
				<p align="center"> Message: <?= $message; ?> <?= $output; ?> </p>
				</div>
			</form>

		</body>

	</html>
