<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 

      <html lang="en"> 
        <head>
          <title>Student List</title> 
      
          <!-- Meta Information about Page -->
          <meta charset="utf-8" />
          <meta name="AUTHOR"      content="Ryan Welling"/>
          <meta name="keywords"    content="University of Utah, Spring 2016"/>
          <meta name="description" content="Student List"/>
      
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
				
				<div align="center">	
				<h1>Student List</h1>
				<h3>Hello <?= $_SESSION['First_Name']; ?></h3>
				</div>
			</div>

			
			<div class="menu" align="center">
				<ul>
					<!-- First Main Menu Item -->
					<li><a class="drop" href="../../../index.html" title="Main">Main Page</a>
       					<ul>
       						<li><a href="mailto:ryan@ryanwelling.com" title="Email Me">Email Me</a>
       						</li>
    					</ul> 
					</li>

					<!-- Next Main Menu Item -->
					<li><a href="index.html" title="Grad Progess Main Page">Grad Progress Main</a>
					</li>

					<!-- Next Main Menu Item -->
					<li><a href="entrance.php" title="Main Portal">Entrance Portal</a>
						<ul>
       						<li><a href="Advisor/advisor.php" title="Advisor">Advisor Portal</a>
       						</li>
       						<li><a href="student_list.php" title="Student">Student Portal</a>
       						</li>
    					</ul> 
					</li>

					<!-- Next Main Menu Item -->
					<li><a href="allforms.php" title="Forms Page">Available Forms</a>
					</li>

				</ul>
			</div>

			<div id = content>
			<table align="center" style="margin-left:auto; margin-right:auto;">
 
				<tr>
					<th>Student Name </th>
				</tr>

				<?= $output ?>
			</table>
			</div>

		</body>
		</html>
