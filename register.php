<html lang="en">
<head>
    <title>ATN | Register</title>
    <LINK REL="SHORTCUT ICON"  HREF="images/013.svg">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="styles/register.css">
</head>

<body>
    <?php
    require 'core/database.php';
    require 'core/session.php';
    require 'core/file.php';
    require 'config/config.php';
    
    $db = new database();
    $session = new session();
    $file = new file();
    if(isset($_POST['signup'])){
        $file_name = $_FILES['Image']['name'];
        $file_tmp = $_FILES['Image']['tmp_name'];
        $path = "images/";
        $file_name = $file->newname($path, $file_name);
        move_uploaded_file($file_tmp, $file->moveNew($path, $file_name));
        $username = $_POST['UserName'];
        $password = $_POST['Password'];
        $fullname = $_POST['FullName'];
        $email= $_POST['Email'];
        $phone= $_POST['PhoneNumber'];
        $confirm = $_POST['Confirm'];
        $check_user = $db->table('user')->check([
            'UserName' => $username,
        ]);
    }
    ?>
<div class="container-fluid">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8 col-10">
                <div class="row">
                    <a class="col col-12" href="index.php">
                        <div class="row justify-content-center" id="logo">
                            <img class="col col-12" src="images/013.svg">
                        </div>
                    </a>
                </div>
            </div>
            <div class="col col-lg-7 col-md-12 col-12">
                <div class="row d-flex justify-content-center">
                    <h1 class="col col-12">Register</h1>
                </div>
                <div class="row d-flex justify-content-center">
                    <form class="col col-md-9 col-11" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" required="" name="UserName" placeholder="Username">
                            <div>
                          <?php 
                          if(isset($_POST['signup'])){
                              if ($check_user > 0 ) {
                              echo "<small>Username available</small>";
                          }
                          } 
                          ?>
                            </div>
                          </div>
                          <div class="form-group">
                              <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="Password" class="form-control" required="" name="Password" placeholder="Create Password">
                          </div>
                          <div class="form-group">
                              <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input type="Password" class="form-control" required="" name="Confirm" placeholder="Repeat Password">
                            <div>
                          <?php 
                          if(isset($_POST['signup'])){
                            if($password !== $confirm) {
                              echo "<small>Repeat password is incorrect</small>";
                          }
                          } 
                          ?>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            </div>
                            <input type="text" class="form-control" required="" name="FullName" placeholder="Full Name">
                          </div>
                          <div class="form-group">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" required="" name="PhoneNumber" placeholder="Phone Number">
                          </div>
                          <div class="form-group">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" required="" name="Email" placeholder="Email Address">
                          </div>
                          <div class="form-group" id="avatar">
                            <div class="input-group-append">
                                <span class="input-group-text">Avatar</span>
                            </div>
                            <input type="file" name="Image" class="form-control avatainput" required="">
                          </div>
                          <div class="row justify-content-center">
                              <button  type="submit" name="signup" class="btn btn-primary col col-sm-4 col-11">Register</button>
                          </div>
                    </form>
                </div>
                <div class="row d-flex justify-content-center">
                    <p class="col-12 register">Have an account? <a href="login.php" style="color: white;">Login here!</a></p>
                </div>
                
            </div>
        </div>	
    </div>	
</div>
<?php 
      if(isset($_POST['signup'])){
        if ($check_user == 0 && $password == $confirm) {
            $result = $db->table('user')->insert([
                'UserName' => $username,
                'Password' => $password,
                'FullName' => $fullname,
                'PhoneNumber' => $phone,
                'EmailAddress' => $email,
                'AvataImage' => $file_name,
            ]);
            if ($result) {
                echo "<script>alert('Register successfull!')</script>";
                echo "<script>window.open('login.php','_self')</script>";
            }
            else {
                echo "<script>alert('Error')</script>";
            }
        }
    }
?>
</body>
</html>