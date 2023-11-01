<?php
include "commonHeader.php";
include "connection.php";
?>

<main id="main">

  <!-- ======= Breadcrumbs ======= -->
  <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/breadcrumbs-bg.jpg');">
    <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">

      <h2>Public</h2>
      <h2>Registration</h2>

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
                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
              </div>
              <div class="col-lg-6 form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
              </div>
            </div>
            <div class="row gy-4 mb-3 ">
              <div class="col-lg-6 form-group">
                <input type="text" name="phone" class="form-control" id="phone" placeholder="Your Phone" pattern="[6789][0-9]{9}" maxlength="10" required>
              </div>
              <div class="col-lg-6 form-group">
                <select name="district" class="form-control" id="" required>
                  <option value="" selected disabled>Select District</option>
                  <option value="Kasaragod">Kasaragod</option>
                  <option value="Kannur">Kannur</option>
                  <option value="Wayanad">Wayanad</option>
                  <option value="Kozhikode">Kozhikode</option>
                  <option value="Malappuram">Malappuram</option>
                  <option value="Palakkad">Palakkad</option>
                  <option value="Thrissur">Thrissur</option>
                  <option value="Ernakulam">Ernakulam</option>
                  <option value="Idukki">Idukki</option>
                  <option value="Alappuzha">Alappuzha</option>
                  <option value="Kottayam">Kottayam</option>
                  <option value="Pathanamthitta">Pathanamthitta</option>
                  <option value="Kollam">Kollam</option>
                  <option value="Thiruvananthapuram">Thiruvananthapuram</option>
                </select>
              </div>
            </div>
            <!-- <div class="form-group mb-3 ">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              </div> -->
            <div class="form-group mb-3 ">
              <textarea class="form-control" name="address" rows="5" placeholder="Address" required></textarea>
            </div>
            <div class="row gy-4 mb-3 ">
              <div class="col-lg-6 form-group">
                <input type="password" name="password" class="form-control" id="name" placeholder="Password" required>
              </div>
              <div class="col-lg-6 form-group">
                <input type="password" class="form-control" name="cPassword" id="email" placeholder="Confirm Password" required>
              </div>
            </div>
            <div class="my-3 mb-3 ">
              <div class="error-message"></div>
            </div>
            <div class="text-center"><button type="submit" name="submit" class="btn btn-warning">Register</button></div>
          </form>
        </div><!-- End Contact Form -->

      </div>

    </div>
  </section><!-- End Contact Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $district = $_POST['district'];
  $address = $_POST['address'];
  $password = $_POST['password'];
  $cPassword = $_POST['cPassword'];

  if ($password == $cPassword) {
    $qry = "INSERT INTO `public` (`name`,`email`,`phone`,`address`,`district`) VALUES ('$name','$email','$phone','$address','$district')";
    $qryLog = "INSERT INTO `login` (`uid`,`username`,`password`,`usertype`,`status`) VALUES ((SELECT MAX(`pid`) FROM `public`), '$email','$password','Public','Active')";
    if (mysqli_query($con, $qry) && mysqli_query($con, $qryLog)) {
      echo "<script>alert('Registration Successful');</script>";
    } else {
      echo "<script>alert('Registration Failed');</script>";
    }
  } else {
    echo "<script>alert('Password Dosent Match');</script>";
  }
}
include "commonFooter.php";
?>