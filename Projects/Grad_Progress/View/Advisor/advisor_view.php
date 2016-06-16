<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 

    <html lang="en"> 
        <head>
          <title>List of Advisors</title> 
      
          <!-- Meta Information about Page -->
          <meta charset="utf-8" />
          <meta name="AUTHOR"      content="Ryan Welling"/>
          <meta name="keywords"    content="University of Utah, Spring 2016"/>
          <meta name="description" content="List of Advisors"/>
      
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
							<li><a href="entrance.php" title="../Entrance Portal">Entrance Portal</a></li>

							<!-- Next Main Menu Item -->
							<li><a href="../allforms.php" title="Forms Page">Available Forms</a></li>
		                </ul>
		            </div>
		            <!-- /.navbar-collapse -->
		        </div>
		        <!-- /.container -->
		    </nav>

		    <div id = header>
				
				<div align="center">	
				<h1>List of Advisors</h1>
				<h3>Hello <?= $_SESSION['First_Name']; ?></h3>
				</div>
			</div>

			<table align="center" style="margin-left:auto; margin-right:auto;">
				
				<tr>
					<th>Advisor Name</th>
				</tr>
				<?= $output; ?>

			</table>

			</body>
			</html>

