<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 

<html lang="en"> 
    <head>
      <title>Individual Student Forms</title> 
  
      <!-- Meta Information about Page -->
      <meta charset="utf-8" />
      <meta name="AUTHOR"      content="Ryan Welling"/>
      <meta name="keywords"    content="University of Utah, Spring 2016"/>
      <meta name="description" content="Individual Student Due Progress Forms"/>
  
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
	    <div class="container">
				<div class="jumbotron">
					<div align="center">	
					<h1><?= $student_name; ?>'s Form #<?= $form_ID; ?></h1>
					<h3>Hello <?= $_SESSION['First_Name']; ?></h3>
					</div>
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
								<li><a href="href=../../../index.html" title="Main Page">Main Page</a></li>
								<li><a href="mailto:ryan@ryanwelling.com" title="Email Me">Email Me</a></li>
							</ul> 
						</li>
						<!-- Next Main Menu Item -->
						<li><a href="../index.html" title="Grad Progess Main Page">Grad Progress Main</a></li>

						<!-- Next Main Menu Item -->
						<li><a href="../Student/progress_form.php" title="Due Progress Form">Due Progress Form</a></li>

						<?php 
	                        if($_SESSION['Role'] == Student)
	                        {
	                            $navelem = '<li><a href="student_forms.php" title="Student Form">Your Forms</a></li>';
	                        }
	                        else if($_SESSION['Role'] == Faculty)
	                        {
	                            $navelem = '<li><a href="../Advisor/students.php?lastName=' .$_SESSION['Last_Name'] .'" title="Advisor Portal">List of Students</a></li>';
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

			<div class="container-float" style="margin-left:25px; margin-right: 25px;">
	      <div class="row">
		      <div class="col-sm-12">
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<tr>
									<th>Form ID</th>
									<th>Date</th>
									<th>ID</th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Degree</th>
									<th>Track</th>
									<th>Year Admit</th>
									<th>Sem Admit</th>
									<th>Advisor</th>
									<th>Committee</th>
									<th>Committee</th>
									<th>Committee</th>
									<th>Status</th>
								</tr>
								<?= $output; ?>
							</table>
						</div><!--table-responsive-->
					</div><!--col-sm-12-->
				</div><!--row-->
			</div><!--container-->

			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<p style="padding-left: 5px;">Student Progress:</p>
		  			<p style="border: solid; width: 300px; padding-left: 5px;"><?= $prog_data; ?></p>
		  		</div><!--col-sm-4-->

		  		<div class="col-sm-4" align="center" style="padding-top: 22px;">
		  			<a href="edit_progress.php?form_ID=<?= $form_ID; ?>" class="btn btn-s btn-danger"><span class="glyphicon glyphicon-edit"></span> Edit Form</a>
          	<!-- This makes the signed button appear
          	     Should only appear if the form is unsigned -->
						<?= $unsigned; ?>
		  		</div><!--col-sm-4-->

		  		<div class="col-sm-4">
		  			<div align="center">
		  				<h3 style="text-decoration: underline;"><span class="label label-default">WARNING:</span></h3>
		  			</div>
						<p>If you choose to edit the form, it can be saved as a new form, regardless of any changes made.</p>
		  		</div><!--col-sm-4-->
		  	</div><!--row-->
			</div><!--container-->

			<?= $message; ?>

			<div id="footer" align="center" style="padding: 100px;">
				<a href="../loggedout.php" class="btn btn-s btn-danger"><span class="glyphicon glyphicon-log-out"></span> Click here to Log Out</a>
			</div>	
		</body>
</html>
