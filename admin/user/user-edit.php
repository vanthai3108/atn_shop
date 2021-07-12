<!DOCTYPE html>
<html>
<head>
<title>ATN | Admin</title>
    <LINK REL="SHORTCUT ICON"  HREF="../../images/013.svg">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
<?php include("../include/header-user.php"); ?>
<?php 
    $userID = $_GET['user-edit'] ?? null;
    if ($userID != null){
        $user = $db->table('user')->getWhereOne('UserID', $userID);
    }
?>
<div class="container">
    <div class="row justify-content-center">
        <h4 style="margin: 10px 0px;">Add/Edit Facility</h4>
    </div>
    <div class="row justify-content-center">
        <form class="col-6" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" class="form-control" name="UserName" value="<?php if ($userID != null){ echo "$user->UserName";} ?>" required="" placeholder="Username">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="Password"  value="<?php if ($userID != null){ echo "$user->Password";} ?>" required="" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="FullName" required="" value="<?php if ($userID != null){ echo "$user->FullName"; }?>" placeholder="Fullname">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="PhoneNumber" required=""  value="<?php if ($userID != null){ echo "$user->PhoneNumber";} ?>" placeholder="Phone Number">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="Email" required=""  value="<?php if ($userID != null){echo "$user->Address"; }?>"  placeholder="Email Address">
            </div>
            <div class="form-group">
                <input type="file" class="select-avatar" name="Image" required=""  value="<?php if ($userID != null){ echo "$user->AvataImage"; }?>"  placeholder="Avatar">
            </div>
            <div class="form-group select-type row">
                <div class="col-4">
                    <p>Permission:</p> 
                </div>
                <div class="col-4">
                    <input type="radio" id="admin" name="checkAdmin" required=""  <?php if( $userID != null ){if($user->Permission == 1){ echo"checked";}} ?>  value="1">
                    <label for="admin">Admin</label>  
                </div>
                <div class="col-4">
                    <input type="radio" id="user" name="checkAdmin"  required="" <?php if( $userID != null ){if($user->Permission == 0){ echo"checked";}} ?> value="0">
                    <label for="user">No</label>
                </div>
            </div>
            <div class="form-group select-type row">
                <div class="col-4">
                    <p>Status:</p> 
                </div>
                <div class="col-4">
                    <input type="radio" id="status-1" name="checkStatus" required=""  <?php if( $userID != null ){if($user->Status == "true"){ echo"checked";}} ?>  value="true">
                    <label for="status-1">True</label>  
                </div>
                <div class="col-4">
                    <input type="radio" id="status-2" name="checkStatus"  required="" <?php if( $userID != null ){if($user->Status !== "true"){ echo"checked";}} ?> value="false">
                    <label for="status-2">False</label>
                </div>
            </div>
            <div class="row action" style="margin-bottom:20px;">
                <div class="col-6">
                    <button type="submit" name="add" class="btn btn-primary btn-block" <?php if( $userID != null ) { echo " disabled";} ?>>Add</button>
                </div>
                <div class="col-6">
                    <button type="submit" name="edit" class="btn btn-primary btn-block" <?php if( $userID == null ) { echo " disabled";} ?>>Edit</button>
                </div>
            </div>
        </form>
    </div> 
</div>
<?php  
    if(isset($_POST['add'])){
        $file_name = $_FILES['Image']['name'];
        $file_tmp = $_FILES['Image']['tmp_name'];
        $path = "../../images/";
        $file_name = $file->newname($path, $file_name);
        move_uploaded_file($file_tmp, $file->moveNew($path, $file_name));
        $username = $_POST['UserName'];
        $password = $_POST['Password'];
        $fullname = $_POST['FullName'];
        $email= $_POST['Email'];
        $phone= $_POST['PhoneNumber'];
        $checkadmin = $_POST['checkAdmin'];
        $checkstatus = $_POST['checkStatus'];
        $check_user = $db->table('user')->check([
            'UserName' => $username,
        ]);
        if ($check_user > 0 ) {
            echo "<div  class='col-12 check' >
            <small>Add failed, username available</small>
            </div>";
        }
        else {
            $result = $db->table('user')->insert([
                'UserName' => $username,
                'Password' => $password,
                'FullName' => $fullname,
                'PhoneNumber' => $phone,
                'EmailAddress' => $email,
                'AvataImage' => $file_name,
                'Permission' => $checkadmin,
                'Status' => $checkstatus,
            ]);
            if ($result) {
                echo "<script>alert('Add user successfull!')</script>";
                echo "<script>window.open('user.php','_self')</script>";
            }
            else {
                echo "<script>alert('Error')</script>";
            }
        }
    }
    if(isset($_POST['edit'])){
        $file_name = $_FILES['Image']['name'];
        $file_tmp = $_FILES['Image']['tmp_name'];
        $path = "../../images/";
        $file_name = $file->newname($path, $file_name);
        move_uploaded_file($file_tmp, $file->moveNew($path, $file_name));
        $username = $_POST['UserName'];
        $password = $_POST['Password'];
        $fullname = $_POST['FullName'];
        $email= $_POST['Email'];
        $phone= $_POST['PhoneNumber'];
        $checkadmin = $_POST['checkAdmin'];
        $checkstatus = $_POST['checkStatus'];
        $check_user = $db->table('user')->check([
            'UserName' => $username,
        ]);
        if ($check_user > 0 &&  $username != $check_user['UserName'] ) {
            echo "<div  class='col-12 check' >
            <small>Edit failed, username available</small>
            </div>";  
        }
        else {
            $result = $db->table('user')->columnId('UserID')->update($userID, [
                'UserName' => $username,
                'Password' => $password,
                'FullName' => $fullname,
                'PhoneNumber' => $phone,
                'EmailAddress' => $email,
                'AvataImage' => $file_name,
                'Permission' => $checkadmin,
                'Status' => $checkstatus,
            ]);
            if ($result) {
                echo "<script>alert('Edit user successfull!')</script>";
                echo "<script>window.open('user.php','_self')</script>";
                $del_old_img = $file->del_file('../../images/'.$user->AvataImage);
            }
            else {
                echo "<script>alert('Error')</script>";
            }
        }
    }
?>  
</body>
</html>