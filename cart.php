<html>
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
    <link rel="stylesheet" href="styles/cart.css"> 
</head>

<body>
    <?php include("include/header.php"); ?>
    <?php 
    if ($session->has('Username') && $session->get('Username') != null){
        $userID = $session->get('UserID');
    }
    else {
        header("location: index.php");
    }
    ?>
<div class="container main">
        <div class="row justify-content-center">
            <div class="col col-12">
                <h2 style="text-align:center;">Cart</h2>
            </div>
        </div>
        <div class="row cart">
            <form method="post" class="col">
                <div class="row justify-content-center">
                <?php 
                $carts = $db->table('cart')->getWhereAll('UserID', $userID);
                foreach($carts as $cart){
                    $proID = $cart->ProductID;
                    $pro = $db->table('product')->getWhereOne('ProductID', $proID);
                    echo "
                    <div class='col col-md-4 col-xl-3 col-sm-6 col-12'>
                    <div class='row justify-content-center'>
                        <div class='card col col-11 item'>
                            <div class='row justify-content-center'>
                                <img class='card-img-top col col-10 item-img' src='images/$pro->ProductImage' alt='Card image'>
                            </div>
                            <div class='card-body'>
                                <h6 class='card-title'>$pro->ProductName</h6>
                                <p class='card-text'>Prices: <span>$pro->ProductPrices</span>$</p>
                                <div class='row justify-content-center number'>
                                    <p class='col-8'>Quantily: </p>
                                    <input class='col-4' name='number-$cart->CartID' type='number' min='1' value='1'>
                                </div>
                                <a href='cart.php?del-cart=$cart->CartID' class='btn btn-primary btn-block'>Delete</a>
                            </div>
                        </div>
                    </div>
                    </div>
                    ";
                }
                ?>
            </div>
            <div class="row justify-content-center">
                <div class="col col-sm-7 col-11 pay">
                    <button name="pay" class="btn btn-primary btn-block">Order Now</button>	
                </div>
            </div>
        </form>
        <?php
        if (isset($_GET["del-cart"])) {	
            $cartID = intval($_GET['del-cart']);
            $check_user = $db->table('cart')->check([
                'CartID' => $cartID,
            ]);
            $userCart = $check_user['UserID'];
            if ($userID ==$userCart) {
                $del_result = $db->table('cart')->columnId('CartID')->delete($cartID);
                if ($del_result) {
                    echo "<script>window.open('cart.php','_self')</script>";	
                }
                else {
                    echo "<script>alert('Error')</script>";
                    echo "<script>window.open('cart.php','_self')</script>";
                    }
                }
            else {
                echo "<script>alert('You do not have the right to delete !')</script>";
                echo "<script>window.open('cart.php','_self')</script>";	
            }
        }

        if (isset($_POST['pay'])) {
            $pay_carts = $db->table('cart')->getWhereAll('UserID', $userID);
            if($pay_carts > 0){
                foreach ($pay_carts as $pay_cart) {
                    $post_num='number-';
                    $post_num.= $pay_cart->CartID;
                    $number=$_POST[$post_num];
                    $CartPro=$pay_cart->ProductID;
                    $CartUser=$pay_cart->UserID;
                    $Productbought = 
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $day =date('Y/m/d H:i:s');
                    $pay = $db->table('pay')->insert([
                        'PayNumber' => $number,
                        'PayDate' => $day,
                        'UserID' => $CartUser,
                        'ProductID' => $CartPro,
                    ]);
                    $delete = $db->table('cart')->columnId('CartID')->delete($pay_cart->CartID);
                }
                echo "<script>alert('Order successfull!')</script>";
                echo "<script>window.open('cart.php','_self')</script>";	
            }
        }
        ?>
        </div>
        <div class="row">
            <div class="col pay-list">
                <a href="#">Order histories</a>	
            </div>
        </div>
    </div>	
</div>
<div class="container footer">
    <div class="row">
        <h2 class="col">© 2021 ATN - Cloud Computing. Copyright by Van Thai</h2>
    </div>
</div>

</body>
</html>