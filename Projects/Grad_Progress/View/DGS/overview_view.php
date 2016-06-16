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
    <link rel="stylesheet" type="text/css" href="../Resources/CSS/dgs.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts.src.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>

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

          $(document).on("change", "#Student", function(e){
            val = $("#Student").val();
            $("#table_result").load("student_info.php?id=" +val);
          });

          $(document).on("change", "#chart", function(e){
            val = $("#chart").val();
            $("#chart_result").load("charts.php?chart=" +val);
          });

        });
      </script>
    </head>

    <body style="padding-top: 70px;">

    <div class="container-fluid">
      <div class="jumbotron">
        <div align="center">  
          <h1>HELLO <?= $_SESSION['First_Name']; ?></h1>
          <h3>Welcome to your Feifdom</h3>
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
                  <li><a href="href=../../../../../index.html" title="Main Page">Main Page</a></li>
                  <li><a href="mailto:ryan@ryanwelling.com" title="Email Me">Email Me</a></li>
                </ul> 
              </li>
              <!-- Next Main Menu Item -->
              <li><a href="../index.html" title="Grad Progess Main Page">Grad Progress Main</a></li>

              <!-- Next Main Menu Item -->
              <li class="active"><a href="../entrance.php" title="Entrance Portal">Entrance Portal</a></li>        
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container -->
      </nav>
      
      <div class="container-fluid" style="padding-right: 10px;">
        <div class="row">
          <div class="col-sm-4">      
            <form class="form-horizontal">
              <fieldset>
                <!-- Form Name -->
                <legend>Student Data</legend>
                <!-- Select Basic -->
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="Student">Choose Student</label>
                    <div class="col-md-4">
                      <select id="Student" name="Student" class="form-control">
                        <?= $output; ?>
                      </select>
                    </div>
                  </div><!--form-group-->
                </fieldset>
              </form>
            </div><!--col-sm-4-->
          <div class="col-sm-8">      
            <form class="form-horizontal">
              <fieldset>
                <!-- Form Name -->
                <legend>Available Charts</legend>
                <!-- Select Basic -->
                  <div class="form-group">
                    <label class="col-md-4 control-label" for="chart">Choose Form</label>
                    <div class="col-md-4">
                      <select id="chart" name="chart" class="form-control">
                        <option value="blank"></option>
                        <option value="gpa">GPA Distribution</option>
                        <option value="student">Ratio of Students to Advisors</option>
                        <option value="year">Students admitted per Year</option>
                      </select>
                    </div>
                  </div><!--form-group-->
                </fieldset>
              </form>
            </div><!--col-sm-8-->
          </div><!--row-->
        <div class="row">
          <div class="col-sm-4"> 
            <div id="table_result">
            </div>
          </div> <!--col-sm-4-->
          <div class="col-sm-8"> 
            <div id="chart_result">
            </div>
          </div> <!--col-sm-8-->
        </div><!--row-->
      </div><!--container-->
    </body>
</html>



