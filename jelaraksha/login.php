<?php
session_start();
include "commonHeader.php";
include "connection.php";
?>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/breadcrumbs-bg.jpg');">
        <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">

            <!-- <h2>Pump</h2> -->
            <h2>Login</h2>

        </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up" data-aos-delay="100">



            <div class="row gy-4 mt-1">
                <div class="col-lg-6" style="margin: auto;">
                    <form action="" method="post">
                        <div class="row gy-4 mb-3 ">
                            <div class="col-lg-6 form-group">
                                <input type="text" name="uname" class="form-control" id="name" placeholder="Username" required>
                            </div>
                            <div class="col-lg-6 form-group">
                                <input type="password" class="form-control" name="password" id="email" placeholder="Password" required>
                            </div>
                        </div>


                        <div class="text-center"><button type="submit" name="submit" class="btn btn-warning">Login</button></div>
                    </form>
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
        } else if ($row['usertype'] == 'Public') {
            echo "<script>alert('Login Successful');</script>";
            echo "<script>window.location.href='userHome.php';</script>";
        }
    } else {
        echo "<script>alert('Login Failed');</script>";
    }
}
include "commonFooter.php";
?>