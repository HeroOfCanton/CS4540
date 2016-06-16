<?php

  // This function will return only if the current user is logged in, using the specified
  // role (if $role is nonempty).
  session_start();

    // Reports if https is in use
  function usingHTTPS () 
  {
    return isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] != "off");
  }


  // Redirects to HTTPS
  function redirectToHTTPS()
  {
    if(!usingHTTPS())
    {
      $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      header("Location:$redirect");
      exit();
    }
  }

  function verifyLogin () 
    {
      require '../../db_config.php';
      
      // Empty error message
      $message = "";
      $output = "";
    
      // User is attempting to log in.  Verify credentials.
      if ($_POST['Login'] != "" && $_POST['password'] != "") 
      {
        $username = $_POST['Login'];
        $password = $_POST['password'];

        try {
          $db = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8", $db_user_name, $db_password);
          $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
          
          // Get the information about the user.  This includes the
          // hashed password, which will be prefixed with the salt.

          $stmt = $db->prepare("SELECT * from Users where Login = ?");
          $stmt->bindValue(1, $username);
          $stmt->execute();

          // Was this a real user?
          if ($row = $stmt->fetch()) {
            
            // Validate the password
            $hashedPassword = $row['Hashword'];
            if (password_verify($password, $hashedPassword)) 
              {
                $_SESSION['ID'] =         htmlentities($row['ID']);
                $_SESSION['Role'] =       htmlentities($row['Position']);
                $_SESSION['Login'] =      htmlentities($row['Login']);
                $_SESSION['First_Name'] = htmlentities($row['First_Name']);
                $_SESSION['Last_Name'] =  htmlentities($row['Last_Name']);

                // Login successful, let's take them to their page
                if($row['Position'] == "Student") 
                {
                  header("Location: Student/student_forms.php"); 
                }
                else if($row['Position'] == "Faculty")
                {
                  header("Location: Advisor/students.php?lastName=" .$_SESSION['Last_Name']);
                }
                // If we're here, must be DGS
                else
                {
                  header("Location: DGS/overview.php");
                }
              }
            else {
              $message = "Login or Password was wrong, please try again.";
            }
          }
          else {
            $message = "Username or password was wrong";
          }
        }
        catch (PDOException $ex)
          {
            $message .= "<p>oops</p>";
            $message .= "<p> Code: {$ex->getCode()} </p>";
            $message .=" <p> See: dev.mysql.com/doc/refman/5.0/en/error-messages-server.html#error_er_dup_key";
            $message .= "<pre>$ex</pre>";

            if ($ex->getCode() == 23000)
              {
                $message .= "<h2> Duplicate Entries not allowed </h2>";
              }
          }
      }
      // Because Safari :(
      else
      {
        $message = "Please fill out both fields";
      }
      return $message;
    }

  function verify_role($role)
    {
        // Perhaps the user is already logged in
      if (isset($_SESSION['userid'])) 
        {
          // Does the user belong to the appropriate role?
          if ($role == '' || (isset($_SESSION['roles']) && $role == $_SESSION['roles'])) 
            {
              return true;
            }
          else 
            {
              return false;
            }
          
        }
      return false;
    }

?>