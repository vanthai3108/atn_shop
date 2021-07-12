<!DOCTYPE html>
<html lang="en">
<head>
    <title>ATN</title>
    <LINK REL="SHORTCUT ICON"  HREF="images/013.svg">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/index.css">  
</head>
<body>
<?php
include("include/header.php");
?>
<div class="container  main">
    <div class="row justify-content-center">
        <div class="col col-md-3 col-10">
            <ul id="sidebar">
                <li><a>Categories</a></li>
                <?php   
                    $search=$_GET['key'] ?? null;
                    $categories = $db->table('category')->getAll();
                    foreach($categories as $cat){
                        echo "<li";
                        $Cat = $_GET['cat'] ?? 1 ;
                        if (isset($search) != null){
                            $Cat=0;
                        }
                        if($Cat == $cat->CategoryID){
                            echo " class='now'";
                        }
                        echo "
                        ><a href='index.php?cat=$cat->CategoryID'>$cat->CategoryName</a></li>";
                    }
                ?>
            </ul>
        </div>
        <div class="col col-md-9 col-11">
            <div class="row justify-content-center">
            <?php 
            $Cat = $_GET['cat'] ?? 1 ;
            $page = $_GET['page'] ?? 1;
            $perPage = 6;
            $offSet =($page -1 ) * $perPage;
            $products = $db->table('product')->getWhere('CategoryID', $Cat, $perPage, $offSet);
            if (isset($search) != null){
                $products = $db->table('product')->getLike('ProductName', $search, $perPage, $offSet);
                echo"<div class='col col-12'><h3 style='text-align:center;'>Product search results for '$search'</h3></div>";
            }
            foreach($products as $pro){
                echo "
                <div class='col col-lg-4 col-sm-6 col-12'>
                    <div class='row justify-content-center'>
                        <div class='card col col-11 item'>
                            <div class='row justify-content-center'>
                                <img class='card-img-top col col-10 item-img' src='images/$pro->ProductImage' alt='Card image'>
                            </div>
                            <div class='card-body row justify-content-center'>
                                <h6 class='card-title'>$pro->ProductName</h6>
                                <div class='col col-12'>
                                    <div class='row  justify-content-center'>
                                        <p class='card-text col col-12'>Prices: <span>$pro->ProductPrices</span>$</p>
                                    </div>
                                </div>
                                <a href='index.php?add_cart=$pro->ProductID' class='btn btn-primary'>Add to Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>
            </div>
            <?php
                $total_pro = $db->table('product')->countWhere('CategoryID', $Cat);
                if (isset($search) != null){
                    $total_pro = $db->table('product')->countLike('ProductName', $search);
                }
                $totalPages = ceil($total_pro / $perPage); 
                if ($total_pro > 0) {
                    $db->table('product')->pagination('index.php',$page, $totalPages);
                }
                else {
                    echo"
                        <h4>There are currently no products </h4>";
                    }
                ?>
        </div>
    </div>
</div>
<div class="container footer">
    <div class="row justify-content-center">
        <h2 class="col col-12">© 2021 ATN - Cloud Computing. Copyright by Van Thai</h2>
    </div>
</div>

<?php
if (isset($_GET["add_cart"])) {	
    $productID =  intval($_GET['add_cart']);
    if ($session->has('Username') && $session->get('Username') != null){
        $userID = $user['UserID'];
        $check_pro = $db->table('cart')->check([
            'ProductID' => $productID,
            'UserID' => $userID,
        ]);
        if ($check_pro > 0) {
            echo "<script>alert('Products already in the cart')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        }
        else {
            $add_cart = $db->table('cart')->insert([
                'UserID' => $userID,
                'ProductID' => $productID,
            ]);
            if ($add_cart) {
                echo "<script>alert('Product added to the cart successfully!')</script>";
                echo "<script>window.open('index.php','_self')</script>";
            }
            else {
                echo "<script>alert('Error')</script>";
                echo "<script>window.open('index.php','_self')</script>";
            }
        }
    }
    else {
        echo "<script>alert('You need to be logged in to perform this action')</script>";
    }
    }
?>
</body>
</html>