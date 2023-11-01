<?php
session_start();
include "userHeader.php";
include "connection.php";
$uid = $_SESSION['uid'];
$uname = $_SESSION['uname'];
?>

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/breadcrumbs-bg.jpg');">
        <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">

            <!-- <h2>Pump</h2> -->
            <!-- <h2>Home</h2> -->

        </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up" data-aos-delay="100">



            <div class="row gy-4 mt-1">
                <div class="col-lg-6" style="margin: auto;">
                    <h1 style="text-align: center;">Add Complaint<h1>
                </div><!-- End Contact Form -->

            </div>

        </div>
    </section><!-- End Contact Section -->
    <section id="contact" class="contact">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <br>

            <div class="row gy-4 mt-1">
                <div class="col-lg-6" style="margin: auto;">
                    <form action="" method="post">
                        <div class="row gy-4 mb-3 ">
                            <div class="col-lg-6 form-group">
                                <input type="text" name="location" class="form-control" id="name" placeholder="Location" required>
                            </div>
                            <div class="col-lg-6 form-group">
                                <input type="text" name="subject" class="form-control" id="name" placeholder="Subject" required>
                            </div>
                        </div>
                        <div class="form-group mb-3 ">
                            <textarea class="form-control" name="complaint" rows="5" placeholder="Complaint" required></textarea>
                        </div>
                        <div class="my-3 mb-3 ">
                            <div class="error-message"></div>
                        </div>
                        <div class="text-center"><button type="submit" name="submit" class="btn btn-warning">Add</button></div>
                    </form>
                </div><!-- End Contact Form -->

            </div>

        </div>
    </section>
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php
if (isset($_POST['submit'])) {
    $location = $_POST['location'];
    $subject = $_POST['subject'];
    $complaint = $_POST['complaint'];

    $qry = "INSERT INTO `complaints` (`subject`,`location`,`complaint`,`pid`,`date`) VALUES ('$location','$subject','$complaint','$uid',(SELECT SYSDATE()))";
    if (mysqli_query($con, $qry)) {
        echo "<script>alert('Complaint Registred Successfully');</script>";
    } else {
        echo "<script>alert('Error Occured');</script>";
    }
}

include "userFooter.php";
?>