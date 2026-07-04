<?php
session_start();
include('./admin/db.php');

$alertMessage = '';

if(isset($_POST['register'])){
    $u_name=$_POST['u_name'];
    $u_email=$_POST['u_email'];
    $u_password=$_POST['u_password'];
    $u_phone=$_POST['u_phone'];
    $u_address=$_POST['u_address'];
    $u_role="User";
    if(!empty($u_name) && !empty($u_email) && !empty($u_password) && !empty($u_phone) && !empty($u_address)){
        $stmt = $pdo->prepare('INSERT INTO users (user_name, user_email, user_password, user_address, user_phone, user_role) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$u_name, $u_email, $u_password, $u_address, $u_phone, $u_role]);
    }else{
        $alertMessage = 'please fill your input';
    }
}

if(isset($_POST['login'])){
    $user_email=$_POST['user_email'];
    $user_password=$_POST['user_password'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE user_email = ? AND user_password = ?');
    $stmt->execute([$user_email, $user_password]);
    $row = $stmt->fetch();
    if(isset($row['user_id'])){
        $user_id=$row['user_id'];
        $user_role=$row['user_role'];
        $_SESSION['user_id']=$user_id;
        if($user_role=="Admin"){
            $_SESSION['admin']=true;
            header("Location: ./admin/index.php");
            exit();
        }else{
            $_SESSION['login']=true;
            header("Location: ./index.php");
            exit();
        }
    }else{
        $alertMessage = 'your data is false';
    };
    
}

include('./layout/navbar.php');

?>

<?php if(!empty($alertMessage)): ?>
<script>alert('<?php echo $alertMessage; ?>')</script>
<?php endif; ?>

<div class="container mb-5 px-3" style="margin-top: 100px;">
    <div class="d-flex justify-content-between">
        <div class="login-form">
            <p>already one of us?</p>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="user_email" class="form-label mb-3">Email</label>
                    <input type="email" name="user_email" class="form-control" id="user_email" placeholder="Enter Your Email">
                </div>
                <div class="mb-3">
                    <label for="user_password" class="form-label mb-3">Password</label>
                    <input type="password" name="user_password" class="form-control" id="user_password" placeholder="Enter Your Password">
                </div>
                <input type="submit" name="login" class="form-submit" value="Sign In">
            </form>
        </div>
        <div class="login-form">
            <p>first time here?</p>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="u_name" class="form-label mb-3">Full Name</label>
                    <input name="u_name" type="text" class="form-control" id="u_name" placeholder="Enter Your Name">
                </div>
                <div class="mb-3">
                    <label for="u_email" class="form-label mb-3">Email</label>
                    <input name="u_email" type="email" class="form-control" id="u_email" placeholder="Enter Your Email">
                </div>
                <div class="mb-3">
                    <label for="u_password" class="form-label mb-3">Password</label>
                    <input name="u_password" type="password" class="form-control" id="u_password" placeholder="Enter Your Password">
                </div>
                <div class="mb-3">
                    <label for="u_phone" class="form-label mb-3">Phone</label>
                    <input name="u_phone" type="number" class="form-control" id="u_phone" placeholder="Enter Your Phone">
                </div>
                <div class="mb-3">
                    <label for="u_address" class="form-label mb-3">Address</label>
                    <input name="u_address" type="text" class="form-control" id="u_address" placeholder="Enter Your Address">
                </div>
                <input type="submit" name="register" class="form-submit" value="Register">
            </form>
        </div>
    </div>
</div>

<?php
include('./layout/footer.php');
?>
