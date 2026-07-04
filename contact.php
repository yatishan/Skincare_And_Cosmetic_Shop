<?php
include('./layout/navbar.php');

if(isset($_POST['save'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $message=$_POST['message'];
    if(!empty($name) && !empty($email) && !empty($phone) && !empty($message)){
        $stmt = $pdo->prepare('INSERT INTO contacts (name, email, phone, message) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $email, $phone, $message]);
    }else{
        echo "<script> alert('please fill your input') </script>";
    }
}

?>

<div class="container my-5 contact">
    <h5 class="text-center mt-5 mb-3">GET IN TOUCH WITH US</h5>
    <h4 class="text-center mb-5">Contact Us</h4>
    <div class="row justify-content-between">
        <div class="col-lg-6">
          <form action="./contact.php" method="post">
          <input type="text" name="name" class="form-control my-4" placeholder="name" style="border:1px solid pink;">
            <input type="email" name="email" class="form-control my-4" placeholder="email" style="border:1px solid pink;">
            <input type="number" name="phone" class="form-control my-4" placeholder="phone" style="border:1px solid pink;">
            <textarea class="form-control mt-4 mb-3" name="message" rows="4" style="border:1px solid pink;">message</textarea>
            <input type="submit" value="Save" name="save" class="home-btn btn-danger text-white px-4 my-3">
          </form>
        </div>
        <div class="col-lg-5">
            <div class="my-3 d-flex align-items-center">
                <i class="fa-solid fa-phone"></i>
                <div class="ms-3 mt-1">
                    <p>Phone</p>
                    <p>09891556130</p>
                </div>  
            </div>
            <div class="my-3 d-flex align-items-center">
                <i class="fa-solid fa-envelope"></i>
                <div class="ms-3 mt-1">
                    <p>Email</p>
                    <p>example@gmail.com</p>
                </div>  
            </div>
            <div class="my-3 d-flex align-items-center">
                <i class="fa-solid fa-map-location-dot"></i>
                <div class="ms-3 mt-1">
                    <p>Address</p>
                    <p>myanmar,yangon</p>
                </div>  
            </div>
        </div>
    </div>
</div>

<?php
include('./layout/footer.php');
?>