<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 

      <html lang="en"> 
        <head>
          <title>Due Progress Form</title> 
      
          <!-- Meta Information about Page -->
          <meta charset="utf-8" />
          <meta name="AUTHOR"      content="Ryan Welling"/>
          <meta name="keywords"    content="University of Utah, Spring 2016"/>
          <meta name="description" content="Due Progress Form"/>
      
         <!-- ALL CSS FILES -->
          <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

            <!-- Optional theme -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

            <!-- Latest compiled and minified JavaScript -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

            <!-- Bootstrap Date-Picker Plugin -->
						<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
						<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

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

              var date_input=$('input[name="date"]'); //our date input has the name "date"
							var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
						  var options={
				        format: 'mm/dd/yyyy',
				        container: container,
				        todayHighlight: true,
				        autoclose: true,
						  };
						  date_input.datepicker(options); //initiali110/26/2015 8:20:59 PM ze plugin
            });
          </script>

          </head>

        <body style="padding-top: 50px;">    
			<div class="jumbotron">
				
				<div align="center">	
				<h1 style="color: #e8002b; text-shadow: 2px 2px #a9a9a9;">Grad Progress Form</h1>
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
                        <li><a href="href=../../../index.html" title="Main Page">Main Page</a></li>
                        <li><a href="mailto:ryan@ryanwelling.com" title="Email Me">Email Me</a></li>
                      </ul> 
                  </li>

                  <!-- Next Main Menu Item -->
                  <li><a href="../index.html" title="Grad Progess Main Page">Grad Progress Main</a></li>

                  <!-- Next Main Menu Item -->
                  <li><a href="../entrance.php" title="Entrance Portal">Entrance Portal</a></li>

                  <!-- Next Main Menu Item -->
                  <li class="active"><a href="#">Due Progress Form</a></li>
                  <?php 
                      if($_SESSION['Role'] == Student)
                      {
                          $navelem = '<li><a href="student_forms.php" title="Student Form">Your Forms</a></li>';
                      }
                      else if($_SESSION['Role'] == Faculty)
                      {
                          $navelem = '<li><a href="../Advisor/students.php?lastName=' .$_SESSION['Last_Name'] .'" title="Advisor Portal">List of Students</a></li>';
                      }
                      // Must be DGS
                      else
                      {
                          $navelem = '<li><a href="../Advisor/students.php" title="Advisor Portal">List of Students</a></li>';
                      }
                  ?>
                  <!-- Next Main Menu Item -->
                	<?= $navelem; ?>
              	</ul>
              </div><!-- /.navbar-collapse -->
          </div><!-- /.container -->
      </nav>
      <div class="container-fluid">
	      <div class="row">
		      <div class="col-sm-6">     	
            <form class="form-horizontal" action="save_progress.php" method="post">
							<fieldset>

								<!-- Form Name -->
								<legend>Due Progress</legend>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="date">Date</label>  
									  <div class="col-md-4">
									  	<input id="date" name="date" type="date" class="form-control input-md" required="" value="<?= $_POST['date']; ?>" autofocus > 
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="First_Name">First Name</label>  
									  <div class="col-md-4">
									  	<input id="First_Name" name="First_Name" type="text" placeholder="John" class="form-control input-md" pattern="[a-zA-Z]+" value="<?= $_POST['First_Name']; ?>" required="">   
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="Last_Name">Last Name</label>  
									  <div class="col-md-4">
									  	<input id="Last_Name" name="Last_Name" type="text" placeholder="Smith" class="form-control input-md" pattern="[a-zA-Z]+" value="<?= $_POST['Last_Name']; ?>" required="">
									  </div>
									</div>

									<!-- Prepended text-->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="ID">University ID</label>
									  <div class="col-md-4">
									    <div class="input-group">
									     <!-- <span class="input-group-addon">0</span> -->
									      <input id="ID" name="ID" class="form-control" placeholder="0123456" maxlength="7" pattern="[0-9]+" value="<?= $_POST['ID']; ?>" type="text" required="">
									    </div>
									    <p class="help-block">Must be 7 digits; Numbers only</p>
									  </div>
									</div>

									<!-- Multiple Radios -->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="Degree">Choose a Degree</label>
									  <div class="col-md-4">
									  <div class="radio">
									    <label for="Degree-0">
									      <input type="radio" name="Degree" id="Degree-0" value="Computer Science" checked="checked">
									      Computer Science
									    </label>
										</div>
									  <div class="radio">
									    <label for="Degree-1">
									      <input type="radio" name="Degree" id="Degree-1" value="Computing">
									      Computing
									    </label>
										</div>
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="Track">Track</label>  
									  <div class="col-md-4">
									  	<input id="Track" name="Track" type="text" placeholder="Networking" class="form-control input-md" pattern="[a-zA-Z0-9 ]+([a-zA-Z0-9]*)" value="<?= $_POST['Track']; ?>" required="">	    
									  </div>
									</div>

									<!-- Select Basic -->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="Sem_Admit">Semester Admitted</label>
									  <div class="col-md-4">
									    <select id="Sem_Admit" name="Sem_Admit" class="form-control">
									      <option value="Spring">Spring</option>
									      <option value="Fall">Fall</option>
									    </select>
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="Year_Admit">Year Admitted</label>  
									  <div class="col-md-4">
									  	<input id="Year_Admit" name="Year_Admit" type="text" placeholder="2015" class="form-control input-md" maxlength="4" pattern="[0-9]+" value="<?= $_POST['Year_Admit']; ?>" required="">
									  <span class="help-block">4 digit year; No earlier than 2010</span>  
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="Advisor">Advisor</label>  
									  <div class="col-md-4">
									  	<input id="Advisor" name="Advisor" type="text" placeholder="Welling" class="form-control input-md" pattern="[a-zA-Z]+" value="<?= $_POST['Advisor']; ?>" required="">  
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="Committee_1">Committee Members</label>  
									  <div class="col-md-4">
									  	<input id="Committee_1" name="Committee_1" type="text" placeholder="Germain" class="form-control input-md" pattern="[a-zA-Z]+" value="<?= $_POST['Committee_1']; ?>" required="">    
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="Committee_2"></label>  
									  <div class="col-md-4">
									  	<input id="Committee_2" name="Committee_2" type="text" placeholder="Parker" class="form-control input-md" pattern="[a-zA-Z]+" value="<?= $_POST['Committee_2']; ?>" required="">									    
									  </div>
									</div>

									<!-- Text input-->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="Committee_3"></label>  
									  <div class="col-md-4">
									  	<input id="Committee_3" name="Committee_3" type="text" placeholder="Thomas" class="form-control input-md" pattern="[a-zA-Z]+" value="<?= $_POST['Committee_3']; ?>" required="">									    
									  </div>
									</div>

									<!-- Textarea -->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="Progress">Progress</label>
									  <div class="col-md-4">                     
									    <textarea class="form-control" id="Progress" name="Progress" spellcheck="true" placeholder="Keep it pithy, don't babble."><?= $_POST['Progress']; ?></textarea>
									  </div>
									</div>

									<!-- Button (Double) -->
									<div class="form-group">
									  <label class="col-md-4 control-label" for="resetForm"></label>
									  <div class="col-md-8">
									    <button id="resetForm" name="resetForm" class="btn btn-danger" type="reset">Reset Form</button>
									    <button id="saveForm" name="saveForm" class="btn btn-success" type="submit">Submit Form</button>
									  </div>
									</div>

							</fieldset>
						</form>
						<?= $output; ?>
						<?= $message; ?>
        	</div><!--col-sm-6-->
        	
 				<div class="col-sm-6">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
	            <tr>
                <th>Activity</th>
                <th>Good Progress</th>
                <th>Acceptable Progress</th>
                <th>Completed Semesters</th>
	            </tr>
	            <tr>
                <td>Identify Advisor</td>
                <td>1 semester</td>
                <td>2 semesters</td>
                <td></td>
	            </tr>
	            <tr>
                <td>Program of study approved by advisor and initial committee</td>
                <td>4 semesters</td>
                <td>5 semesters</td>
                <td></td>
	            </tr>
	            <tr>
                <td>Complete teaching mentorship</td>
                <td>4 semesters</td>
                <td>6 semesters</td>
                <td></td>
	            </tr>
	            <tr>
                <td>Complete required courses</td>
                <td>5 semesters</td>
                <td>6 semesters</td>
                <td></td>
	            </tr>
	            <tr>
                <td>Full committee formed</td>
                <td>6 semesters</td>
                <td>7 semesters</td>
                <td></td>
	            </tr>
	            <tr>
                <td>Program of Study approved by committee</td>
                <td>6 semesters</td>
                <td>7 semesters</td>
                <td></td>
	            </tr>
	            <tr>
                <td>Written qualifier</td>
                <td>5 semesters</td>
                <td>6 semesters</td>
                <td></td>
	            </tr>
	            <tr>
                <td>Oral qualifier/Proposal</td>
                <td>7 semesters</td>
                <td>8 semesters</td>
                <td></td>
	            </tr>
	            <tr>
                <td>Dissertation defense</td>
                <td>10 semesters</td>
                <td>12 semesters</td>
                <td></td>
	            </tr>
	            <tr>
                <td>Final document</td>
                <td></td>
                <td></td>
                <td></td>
	            </tr>
	          </table>
	        </div><!--table-responsive-->
	      </div><!--col-sm-6-->
			</div><!--row-->
		</div><!--container-->

    <div id="footer" align="center" style="padding: 100px;">
			<a href="../loggedout.php" class="btn btn-s btn-danger"><span class="glyphicon glyphicon-log-out"></span> Click here to Log Out</a>
		</div>

	</body>
</html>
