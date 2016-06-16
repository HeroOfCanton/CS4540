<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 

    <html lang="en"> 
      <head>
        <title>Entrance Portal</title> 
    
        <!-- Meta Information about Page -->
        <meta charset="utf-8" />
        <meta name="AUTHOR"      content="Ryan Welling"/>
        <meta name="keywords"    content="University of Utah, Spring 2016"/>
        <meta name="description" content="Entrance Portal"/>
    
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
        			$("#login_button").on("click", function() {
        				$("#login_form").show();
        			});

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

				<div class="jumbotron" style="background-image: url('Controllers/Resources/img/campus.jpg') !important; background-position: center center !important">
					<div align="center">	
						<h1 style="color: #e8002b; text-shadow: 2px 2px #ffffff;">Entrance Portal</h1>
						<h3>Hello <?= $_SESSION['First_Name']; ?></h3>
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
                            $navelem = '<li><a href="Student/student_forms.php?id=' .$_SESSION['ID'] .'" title="Student Form">Your Forms</a></li>';
                        }
                        else if($_SESSION['Role'] == Faculty)
                        {
                            $navelem = '<li><a href="Advisor/students.php?lastName=' .$_SESSION['Last_Name'] .'" title="Advisor Portal">List of Students</a></li>';
                        }
                        else {
                        	$navelem = '<li><a href="DGS/overview.php" title="DGS Home">DGS Home</a></li>';
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
		    
		    <div class="container">
					<div class="row">
						<div class="col-sm-12">
							<h2 style="padding-bottom: 25px;">Welcome to the <span style="color: #e8002b;">University of Utah</span> School of Computing Graduate Progress Tracker</h2>
						</div><!--col-sm-12-->
					</div><!--row-->
					<div class="row">
						<div class="col-sm-6">
							<p style="font-size:150%;">The School of Computing tracks Graduate student progress each semester to make sure the students are making satisfactory progress toward their degree. </p>
						</div><!--col-sm-6-->
						<div class="col-sm-6">
							<p style="font-size:150%;"> If you're an existing user, please login, and you'll be taken to the correct portal to access your information. If you're a new user, please register using the 'New User' button below.</p>
						</div><!--col-sm-6-->
					</div><!--row-->
				</div><!--container-->
			
			<div align = "center" style="margin-top:50px;">
				<button class="btn" id="login_button"><span>Login</span></button>
			
				<a href="new_user.php"><button class="btn"><span>New User</span></button></a>
			</div>

			<?php if($_POST)
					{
						$display = "block";
					}
					else
					{
						$display = "none";
					}
			?>
			<div align="center" style="margin-top:50px;">

			<form class="form-inline" action="authenticate.php" method="post" id="login_form" style="display:<?= $display; ?>;">
			  <div class="form-group">
			    <label class="sr-only" for="exampleInputEmail3">Login</label>
			    <input class="form-control" id="Login" name="Login" type="text" pattern="[a-zA-Z0-9]+" value="<?= $_POST['Login']; ?>" placeholder="User Name" required autofocus>
			  </div>
			  <div class="form-group">
			    <label class="sr-only" for="exampleInputPassword3">Password</label>
			    <input class="form-control" id="password" name="password" type="password" minlength="8" value="<?= $_POST['password']; ?>" placeholder="Password" required>
			  </div>
			  <button id="saveForm" name="saveForm" type="submit" value="Submit" class="btn btn-primary">Sign in</button>
			  	
			  </div>
			  <p align="center"> Message: <?= $message; ?> <?= $output; ?> </p>
			</form>

			</div>
		</body>
	</html>
