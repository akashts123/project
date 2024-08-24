<?php
session_start();
include "userHeader.php";
include "connection.php";
$uid = $_SESSION['uid'];
$uname = $_SESSION['uname'];
$qry = "SELECT * FROM `login` WHERE `uid`='$uid' AND `username`='$uname'";
$result = mysqli_query($con, $qry);
$row = mysqli_fetch_array($result);
$utype  = $row['usertype'];
if ($utype == 'Admin') {
    $user = "Admin";
} elseif ($utype == 'Public') {
    $qryCust = "SELECT * FROM `public` WHERE `pid`='$uid'";
    $resultCust = mysqli_query($con, $qryCust);
    $rowCust = mysqli_fetch_array($resultCust);
    $user = $rowCust['name'];
}
?>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/breadcrumbs-bg.jpg');">
        <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">

            <!-- <h2>Pump</h2> -->
            <h2>Home</h2>

        </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up" data-aos-delay="100">



            <div class="row gy-4 mt-1">
                <div class="col-lg-6" style="margin: auto;">
                    <h1 style="text-align: center;">Welcome Back <?php echo $user ?></h1>
                </div><!-- End Contact Form -->

            </div>

        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php
if (isset($_POST['submit'])) {
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    $qry = "SELECT * FROM `login` WHERE `username`='$uname'";
    $result = mysqli_query($con, $qry);
    $row = mysqli_fetch_array($result);
    if ($row['password'] == $password) {
        $_SESSION['uname'] = $uname;
        $_SESSION['uid'] = $row['uid'];
        if ($row['usertype'] == 'Admin') {
            echo "<script>alert('Login Successful');</script>";
            echo "<script>window.location.href='Home.php';</script>";
        } else if ($row['usertype'] == 'Pump') {
            echo "<script>alert('Login Successful');</script>";
            echo "<script>window.location.href='Home.php';</script>";
        } else if ($row['usertype'] == 'Customer') {
            echo "<script>alert('Login Successful');</script>";
            echo "<script>window.location.href='Home.php';</script>";
        }
    } else {
        echo "<script>alert('Login Failed');</script>";
    }
}
include "userFooter.php";
?>