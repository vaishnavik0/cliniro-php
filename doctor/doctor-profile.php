<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:doctorlogout.php');
  } else{


if(isset($_POST['submit']))
{

$docname=$_POST['docname'];
$docgender=$_POST['docgender'];
$docage=$_POST['docage'];
$docdob=$_POST['docdob'];
$docspecialization=$_POST['Doctorspecialization'];
$doccontactno=$_POST['doccontact'];
$docemail=$_POST['docemail'];
$clinicname=$_POST['clinicname'];
$cliniccontact=$_POST['cliniccontact'];
$cliniclocality=$_POST['cliniclocality'];
$cliniccity=$_POST['cliniccity'];
$docfees=$_POST['docfees'];
$docaddress=$_POST['clinicaddress'];

$sql=mysqli_query($con,"Update doctors set specilization='$docspecialization',doctorName='$docname',address='$docaddress',docFees='$docfees',contactno='$doccontactno',docEmail='$docemail',gender='$docgender',age='$docage',dob='$docdob',clinic_name='$clinicname',clinic_contact='$cliniccontact',clinic_locality='$cliniclocality',clinic_city='$cliniccity' where id='".$_SESSION['id']."'");

if($sql)
{
    echo "<script>alert('Doctor Details updated Successfully');</script>";

}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Cliniro</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.svg" rel="icon">
  <!--link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"-->

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">


  <script data-require="jquery@*" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css" />
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>


</head>

<!--script>
  const uid = sessionStorage.getItem("uid")

  if (uid == null){
    window.location.href = "pages-login.html"
  }
</script-->

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.svg" alt="">
        <span class="d-none d-lg-block">Cliniro</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-stopwatch"></i>
            <!--span class="badge bg-primary badge-number">4</span-->
          </a><!-- End Notification Icon -->
        </li><!-- End Notification Nav -->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-easel2"></i>
            <!--span class="badge bg-success badge-number">3</span-->
          </a><!-- End Messages Icon -->
        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/logo copy.svg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">
            <?php $query=mysqli_query($con,"select doctorName from doctors where id='".$_SESSION['id']."'");
            while($row=mysqli_fetch_array($query))
            {
	            echo $row['doctorName'];
            }?>
            </span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>
              <?php $query=mysqli_query($con,"select doctorName from doctors where id='".$_SESSION['id']."'");
            while($row=mysqli_fetch_array($query))
            {
	            echo $row['doctorName'];
            }?>
              </h6>
              <span>
              <?php $query=mysqli_query($con,"select specilization from doctors where id='".$_SESSION['id']."'");
            while($row=mysqli_fetch_array($query))
            {
	            echo $row['specilization'];
            }?> <span>Specialist</span>
              </span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="doctor-profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="doctor-change-password.php">
                <i class="bi bi-gear"></i>
                <span>Change password</span>
              </a>
            </li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="doctorlogout.php" id="logout-btn">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->


  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed " href="doctorlanding.php">
          <i class="bi bi-grid"></i>
          <span>Clifea</span>
        </a>
      </li><!-- End Dashboard Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed"  href="#">
          <i class="bi bi-bar-chart"></i><span>Dashboard</span>
        </a>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Patients</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="manage-patient.php">
              <i class="bi bi-circle"></i><span>All Patients</span>
            </a>
          </li>
          <li>
            <a href="appointments.php">
              <i class="bi bi-circle"></i><span>Appointments</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Schedules</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Kanban</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Notes</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Inventory</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Doctors Inventory</span>
            </a>
          </li>
        </ul>
      </li><!-- End Icons Nav -->

      <li class="nav-heading">CliFea</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-newspaper"></i>
          <span>Be Updated</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-calculator"></i>
          <span>Calci</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-heart-pulse"></i>
          <span>Desease Info</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-easel2"></i>
          <span>drawing-board</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-stopwatch"></i>
          <span>Stop Watch</span>
        </a>
      </li>

      <hr>

      <li class="nav-item">
        <a class="nav-link collapsed" href="doctor-profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Sign Out</span>
        </a>
      </li><!-- End Login Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->

  <main class="main" id="main">
    <div class="pagetitle">
      <h1>Profile-Details</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Profile</li>
          <li class="breadcrumb-item active">Info</li>
        </ol>
      </nav>
    </div>
  
                    <section class="section">

<div class="d-flex flex-wrap text-center m-2 rounded" id="patient-nav">
  <a href="doctor-profile.php" class="p-2 flex-grow-1 border rounded m-2 border-success border-2  fw-bold">Doctor Info</a>
  <a href="doctor-change-password.php" class="p-2 flex-grow-1 border rounded m-2">Change Password</a>
  <!--a href="../patients/pages-patient-appointments.html" class="p-2 flex-grow-1 border rounded m-2">Appointments</a>
  <a href="../patients/pages-patient-billings.html" class="p-2 flex-grow-1 border rounded m-2">Billings</a-->
</div>

<div class="row" >
    <!-- quote -->

    <?php 
$did=$_SESSION['dlogin'];
$sql=mysqli_query($con,"select * from doctors where docEmail='$did'");
while($data=mysqli_fetch_array($sql))
{
?>



    <div class="col-xxl-3 ">
      <div class="card">
        <img class="card-img-top" src="../assets/img/cardback.png" alt="Bologna">
        <div class="card-body text-center">
          <img class="avatar rounded-circle" src="../assets/img/messages-3.jpg" alt="patientpic">

          <div>
          <h4 class="card-title"><?php echo htmlentities($data['doctorName']);?></h4>
          <span>
              <?php $query=mysqli_query($con,"select specilization from doctors where id='".$_SESSION['id']."'");
            while($row=mysqli_fetch_array($query))
            {
	            echo $row['specilization'];
            }?> Specialist
              </span>

          </div>
          
          <!--h6 class="card-subtitle mb-2 text-muted">Famous Actor</h6>
          <p class="card-text">Robert John Downey Jr.'career has included critical and popular success in his youth, followed by a period of substance abuse and legal difficulties, and a resurgence of commercial success in middle age. </p>
          <a href="#" class="btn btn-info">Follow</a>
          <a href="#" class="btn btn-outline-info">Message</a-->

          <div class="d-flex justify-content-between flex-wrap" id="form-subhead">
            <div class="px-2"> <b>Contact:</b><?php echo htmlentities($data['contactno']);?></div>
            <div class="px-2"> <b>Email:</b> <?php echo htmlentities($data['docEmail']);?></div>
            <div class="px-2"> <b>Fees:</b> <?php echo htmlentities($data['docFees']);?></div>
          </div>

          <div class="text-center">
            <hr>
            Profile
          </div>
            <div class="d-flex justify-content-between flex-wrap" id="form-subhead">
                <div class="px-2"> <b>Registerd:</b><?php echo htmlentities($data['creationDate']);?></div>
                <div class="px-2">
                <?php if($data['updationDate']){?>
                    <b>Updated:</b> <?php echo htmlentities($data['updationDate']);?>
                <?php } ?>  
            </div>
          </div>

        </div>
      </div>

      
   </div><!-- End quote -->

   <!-- patient form  -->
   <div class="col-xxl-9">
    <div class="container rounded" id="patients-patients-cont">
    <form role="form" name="adddoc" method="post" onSubmit="return valid();">
                          <div class="row jumbotron box8 rounded py-2">
                            <!--div class="col-sm-12 mx-t3">
                              <h2 class="text-center text-info">Register</h2>
                            </div-->

                            <div class="d-flex">
                              <div class="p-1 fw-bold" id="form-subhead">Personal</div>
                            </div>
                            <div class=" mt-0"><hr></div>

                            <!--div class="col-sm-12 mt-3 fw-bold" id="form-subhead">
                                Personal <hr class="mt-0">

                            </div-->
                            <div class="col-sm-5 form-group">
                            <label for="doctorname">Doctor Name</label>
                      <input type="text" name="docname" class="form-control" value="<?php echo htmlentities($data['doctorName']);?>" >
                            </div>
                            <div class="col-sm-2 form-group">
                                <label for="sex">Gender</label>
                                <select id="sex" name="docgender" class="form-control browser-default custom-select">
                                <option value="<?php echo htmlentities($data['gender']);?>">
					<?php echo htmlentities($data['gender']);?></option>
                                  <option value="male">Male</option>
                                  <option value="female">Female</option>
                                  <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-sm-2 form-group">
                                <label for="docage">Age</label>
                                <input type="number" class="form-control" name="docage" value="<?php echo htmlentities($data['age']);?>">
                            </div>

                            <div class="col-sm-3 form-group mt-1">
                                <label for="Date">Date Of Birth</label>
                                <input type="Date" name="docdob" class="form-control" value="<?php echo htmlentities($data['dob']);?>">
                            </div>


                            <div class="col-sm-5 form-group">
															<label for="DoctorSpecialization">
																Doctor Specialization
															</label>
							                <select name="Doctorspecialization" class="form-control" required="required">
					<option value="<?php echo htmlentities($data['specilization']);?>">
					<?php echo htmlentities($data['specilization']);?></option>
<?php $ret=mysqli_query($con,"select * from doctorspecilization");
while($row=mysqli_fetch_array($ret))
{
?>
																<option value="<?php echo htmlentities($row['specilization']);?>">
																	<?php echo htmlentities($row['specilization']);?>
																</option>
																<?php } ?>
																
															</select>
														</div>

                            <div class="col-sm-3 form-group">
                              <label for="phone">Dr. Phone</label>
                              <input type="number" class="form-control" name="doccontact" value="<?php echo htmlentities($data['contactno']);?>">
                            </div>
                            <div class="col-sm-4 form-group">
                              <label for="email">Dr. Email</label>
                              <input type="email" id="docemail" name="docemail" class="form-control" value="<?php echo htmlentities($data['docEmail']);?>" >
                              <span id="email-availability-status"></span>
                           </div>
                            <div class="col-sm-12 mt-3 fw-bold" id="form-subhead">
                              Clinic Details <hr class="mt-0">
                            </div>

                            <div class="col-sm-4 form-group">
                              <label for="clinicname">Clinic Name</label>
                              <input type="text" class="form-control" name="clinicname" value="<?php echo htmlentities($data['clinic_name']);?>" >
                            </div>
                            <div class="col-sm-4 form-group">
                              <label for="cliniccontact">Clinic Contact</label>
                              <input type="number" class="form-control" name="cliniccontact" value="<?php echo htmlentities($data['clinic_contact']);?>"  required>
                            </div>
                            <div class="col-sm-2 form-group">
                            <label for="cliniclocality">Clinic Locality</label>
                            <input type="text" class="form-control" name="cliniclocality" value="<?php echo htmlentities($data['clinic_locality']);?>"  required>
                          </div>

                          <div class="col-sm-2 form-group">
                            <label for="cliniccity">Clinic City</label>
                            <input type="text" class="form-control" name="cliniccity" value="<?php echo htmlentities($data['clinic_city']);?>"  required>
                          </div>

                            <div class="col-sm-2 form-group">
                              <label for="docfees">Consultancy Fees</label>
                              <input type="text" class="form-control" name="docfees" value="<?php echo htmlentities($data['docFees']);?>"  required>
                            </div>

                            <div class="col-sm-10 form-group">
                            <label for="address">Doctor Clinic Address</label>
                            <textarea name="clinicaddress" class="form-control"><?php echo htmlentities($data['address']);?></textarea>
													</div>                            
                            <div class="col-sm-12 form-group mt-3">
                              <hr class="mt-0">
                              <button type="submit" name="submit" id="submit" class="btn btn-outline-success float-end">Update</button>
                            </div>
                      
                          </div>

                          <?php } ?>
                        </form>
      </div>
     </div><!-- End patient form-->
   </div>


</section>
 

  </main>


 

  

    <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Cliniro</span></strong>. All Rights Reserved
    </div>
  </footer><!--End Footer-->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  
  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/js/tablesearch.js"></script>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


  <!--firebase files-->
  <script src="assets/js/config.js"></script>
  <!-- Template Main JS File -->

  <script src="assets/js/main.js"></script>

</body>

</html>
<?php } ?>
