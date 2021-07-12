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

<?php include("../include/header-cat.php"); ?>
<div class="container">
    <div class="row justify-content-center ">
        <h4 style="margin: 10px 0px;">List of categoris</h4>
    </div>
    <div class="row justify-content-center">
        <a href="cat-edit.php" style="margin-bottom: 20px;">Add New</a>
    </div>
    <div class="row justify-content-center main">
        <div class="col-3">
            <h6>Category name</h6>
        </div>
        <div class="col-2">
            <h6>Action</h6>
        </div>
    </div>
    <?php
    $page = $_GET['page'] ?? 1;
    $perPage = 8;
    $offSet =($page -1) * $perPage;
    $cats = $db->table('category')->get($perPage, $offSet);
    foreach ($cats as $cat) {
        echo"
        <div class='row justify-content-center main'>
            <div class='col-3'>
                <p>$cat->CategoryName</p>
            </div>
            <div class='col-1'>
                <p><a href='cat-edit.php?cat-edit=$cat->CategoryID'><i class='fas fa-edit'></i></a></p>
            </div>
            <div class='col-1'>
                <p><a href='cat.php?delete-cat=$cat->CategoryID'><i  style='color: red' class='fas fa-trash-alt'></i></a></p>
            </div>
        </div> 
        ";
    }
    $total_cat = $db->table('category')->count();
    $totalPages = ceil($total_cat / $perPage);
    $db->pagination('cat.php',$page, $totalPages);
    ?>
    </div>
    <?php
    if (isset($_GET['delete-cat'])) {
        $catID = $_GET['delete-cat'];
        $result = $db->table('category')->columnId('CategoryID')->delete($catID);
        if ($result) {
            echo "<script>alert('Category has been deleted successfull!')</script>";
            echo "<script>window.open('cat.php','_self')</script>";
        }
        else {
          echo "<script>alert('Error')</script>";
          echo "<script>window.open('cat.php','_self')</script>";
        }
    }
    ?>
</body>
</html>