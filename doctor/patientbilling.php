<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:doctorlogout.php');
  } else{
if(isset($_POST['submit']))
  {
    
    $patid=$_GET['patid'];
    $docid = $_SESSION['id'];
    $description = $_POST['paydescrp'];
    $total = $_POST['payamount'];
   
 
      $query=mysqli_query($con, "insert into  billing(Patid,DocId,Description,Amount)values('$patid','$docid','$description','$total')");
    if ($query) {
    echo '<script>alert("Bill Created")</script>';
    echo "<script>window.location.href ='manage-patient.php'</script>";
  }
  else
    {
      echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  
}


  

?>

<!DOCTYPE html>
<html lang="en">

<?php include('include/head.php');?>

<!--script>
  const uid = sessionStorage.getItem("uid")

  if (uid == null){
    window.location.href = "pages-login.html"
  }
</script-->

<body>

<?php include('include/header.php');?>
<?php include('include/sidebar.php');?>

  <main class="main" id="main">
    <div class="pagetitle">
      <h1>Patient Billing</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Patients</li>
          <li class="breadcrumb-item active">Billing</li>
        </ol>
      </nav>
    </div>

    <section class="section">
        <?php
        $patid=$_GET['patid'];
        $ret=mysqli_query($con,"select * from users where id='$patid'");
        $cnt=1;
        while ($row=mysqli_fetch_array($ret)) {
        ?>
        
        <div class="d-flex flex-wrap text-center m-2 rounded" id="patient-nav">
            <a href="view-patient.php?viewid=<?php echo $row['id'];?>" class="p-2 flex-grow-1 border rounded m-2">Patient Info</a>
            <a href="prescriptions.php?prespid=<?php echo $row['id'];?>" class="p-2 flex-grow-1 border rounded m-2">Prescriptions</a>
            <a href="#" class="p-2 flex-grow-1 border rounded m-2">Appointments</a>
            <a href="patientbilling.php?patid=<?php echo $row['id'];?>" class="p-2 flex-grow-1 border rounded m-2 border-success border-2 fw-bold">Billings</a>
        </div>
        
        <div class="row" >
            <div class="col-xxl-3 ">
                <div class="card">
                    <img class="card-img-top" src="../assets/img/cardback.png" alt="Bologna">
                    <div class="card-body text-center">
                        <img class="avatar rounded-circle" src="../assets/img/messages-3.jpg" alt="patientpic">
                        <h4 class="card-title"><?php  echo $row['fullName'];?></h4>
                        <div class="d-flex justify-content-between flex-wrap" id="form-subhead">
                            <div class="px-2"> <b>Id:</b>PT-<?php  echo $row['id'];?></div>
                            <div class="px-2"> <b>Weight:</b><?php  echo $row['Weight'];?></div>
                            <div class="px-2"> <b>Age:</b><?php  echo $row['Age'];?></div>
                            <div class="px-2"> <b>Gender:</b><?php  echo $row['gender'];?></div>
                            <div class="px-2"> <b>Blood Grp:</b> <?php  echo $row['bloodgrp'];?></div>
                            <div class="px-2"> <b>Allergies:</b> <?php  echo $row['Allergy'];?></div>
                        </div>
                        <hr class="mt-1">
                        <button class="btn btn-outline-success mt-2 text-center align-items-center" data-bs-toggle="modal" data-bs-target="#billpayment">Add +</button>
                    </div>
                </div>
                <?php }?>
            </div>

            <div class="col-xxl-9">
                <div class="container-fluid box8 rounded table-responsive" id="patients-patients-cont">
                    <table class="table datatable">
                        <thead>
                            <tr id="form-subhead">
                                <th scope="col">#</th>
                                <th scope="col">Bill No.</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $docid = $_SESSION['id'];
                            $patid=$_GET['patid'];
                            $ret=mysqli_query($con,"SELECT * FROM billing where Patid='$patid' AND DocId='$docid';");
                            $i = 1;
                            while ($row=mysqli_fetch_array($ret)) { ?>
                            <tr>
                                <td class="center"><?php echo $i;?>.</td>
                                <td></td>
                                <td><?php echo $row['Created'];?></td>
                                <td> 
                                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal<?php echo $row['billid'] ?>">View</button>
                                </td>
                            </tr>
                            <?php $i++; }?>

                            <div class="modal fade modal-dialog-scrollable modal-lg " id="billpaymentview<?php echo $row['billid'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="billpayment">Bill</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" name="submit">
                                                <div class="row jumbotron rounded py-2">
                                                    <?php
                                                    $ret=mysqli_query($con,"select * from doctors  where id='".$_SESSION['id']."'");
                                                    while ($row=mysqli_fetch_array($ret)) { 
                                                    ?>       
                                                    <div class="row">
                                                        <div class="col-sm-2 text-center justify-content-center m-auto">
                                                            <img src="assets/img/logo.svg"  alt="" style="width:100px; height:100px; ">
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <div class="row">
                                                                <div class="col-sm-7">
                                                                    <div class="text-center fw-bold fs-3" id="form-subhead">Dr. <?php echo $row['doctorName'];?></div>
                                                                    <div class="text-center fw-bold fs-5" id="form-subhead"> <img src="assets/img/logo.svg" alt="" style="width:15px; height:15px">
                                                                    <?php echo $row['clinic_name'];?> <img src="assets/img/logo.svg" alt="" style="width:15px; height:15px"> </div> 
                                                                    <div class="text-center fw-bold fs-5" id="form-subhead"><?php echo $row['specilization'];?> Specialist</div>
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <div class="text-center fw-bold" id="form-subhead">Timing:</div>
                                                                    <div class="text-center" id="form-subhead"><?php echo $row['clinic_timing'];?></div>
                                                                    <div class="text-center text-danger">Closed: <?php echo $row['closed'];?></div>
                                                                    <div class="text-center fw-bold" id="form-subhead">Contact:</div>
                                                                    <div class="text-center" id="form-subhead"><?php echo $row['clinic_contact'];?></div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex flex-row">
                                                                <div class="fw-bold mx-2" id="form-subhead">Address:</div>
                                                                <div id="form-subhead"><?php echo $row['address'];?></div>
                                                            </div>
                                                        </div>
                                                        <hr style="border: 1px solid #012970;"> 
                                                        <?php }?>
                                                    </div> <!---------END OF HEADER----------->
                                                    <?php
                                                    $patid=$_GET['patid'];
                                                    $ret=mysqli_query($con,"select * from users where id='$patid'");
                                                    while ($row=mysqli_fetch_array($ret)) {
                                                    ?>
                                                    <div class="col-sm-4 text-center form-group">
                                                        <label for="doctorname" class="fw-bold">Name:</label>
                                                        <input type="text" class="form-control text-center border-0" name="patname" id="patname" value="<?php  echo $row['fullName'];?>" readonly  >
                                                    </div>
                                                    <div class="col-sm-4 text-center form-group">
                                                        <label for="sex" class="fw-bold">Bill No:</label>
                                                        <input type="text" class="form-control text-center border-0" name="gender" id="sex" value="<?php  echo $row['gender'];?>" readonly  >
                                                    </div>
                                                    <div class="col-sm-4 text-center form-group">
                                                        <label for="age" class="fw-bold">Date:</label>
                                                        <div>
                                                            <?php
                                                            date_default_timezone_set("Asia/Kolkata");
                                                            echo date("Y-m-d")."\t";
                                                            echo date("H:i:s");
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class=" mt-0"><hr style="border: 1px solid #012970;"></div>
                                                    <?php }?>
                                                    <div class="col-sm-8 form-group text-center fw-bold ">
                                                        <label for="description text-center fw-bold">Description</label>
                                                        <hr class="text-primary fw-bold">
                                                        <input type="text" class="form-control" name="paydescrp" id="description" placeholder="About Desease" required>
                                                    </div>
                                                    <div class="col-sm-4 form-group text-center fw-bold">
                                                        <label for="total ">Total</label>
                                                        <hr class="text-primary fw-bold">
                                                        <input type="text" class="form-control" name="payamount" id="total" placeholder="Amount" required>
                                                    </div>
                                                    <div class="col-sm-12 form-group mt-3">
                                                        <br>
                                                        <label for="signature " class="float-end fw-bold">Authorized Signature</label>                                    
                                                    </div>
                                                    <div class="col-sm-12 form-group mt-3">
                                                        <hr class="mt-0">
                                                        <button type="submit" name="submit"  class="btn btn-outline-success float-end">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section class="modals-section">
        <div class="modal fade modal-dialog-scrollable modal-lg " id="billpayment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="billpayment">Bill</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" name="submit">
                            <div class="row jumbotron rounded py-2">
                                <?php
                                $ret=mysqli_query($con,"select * from doctors  where id='".$_SESSION['id']."'");
                                while ($row=mysqli_fetch_array($ret)) { 
                                ?>       
                                <div class="row">
                                    <div class="col-sm-2 text-center justify-content-center m-auto">
                                        <img src="assets/img/logo.svg"  alt="" style="width:100px; height:100px; ">
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <div class="text-center fw-bold fs-3" id="form-subhead">Dr. <?php echo $row['doctorName'];?></div>
                                                <div class="text-center fw-bold fs-5" id="form-subhead"> <img src="assets/img/logo.svg" alt="" style="width:15px; height:15px">
                                                <?php echo $row['clinic_name'];?> <img src="assets/img/logo.svg" alt="" style="width:15px; height:15px"> </div> 
                                                <div class="text-center fw-bold fs-5" id="form-subhead"><?php echo $row['specilization'];?> Specialist</div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="text-center fw-bold" id="form-subhead">Timing:</div>
                                                <div class="text-center" id="form-subhead"><?php echo $row['clinic_timing'];?></div>
                                                <div class="text-center text-danger">Closed: <?php echo $row['closed'];?></div>
                                                <div class="text-center fw-bold" id="form-subhead">Contact:</div>
                                                <div class="text-center" id="form-subhead"><?php echo $row['clinic_contact'];?></div>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row">
                                            <div class="fw-bold mx-2" id="form-subhead">Address:</div>
                                            <div id="form-subhead"><?php echo $row['address'];?></div>
                                        </div>
                                    </div>
                                    <hr style="border: 1px solid #012970;"> 
                                    <?php }?>
                                </div> <!---------END OF HEADER----------->
                                <?php
                                $patid=$_GET['patid'];
                                $ret=mysqli_query($con,"select * from users where id='$patid'");
                                while ($row=mysqli_fetch_array($ret)) {
                                ?>
                                <div class="col-sm-4 text-center form-group">
                                    <label for="doctorname" class="fw-bold">Name:</label>
                                    <input type="text" class="form-control text-center border-0" name="patname" id="patname" value="<?php  echo $row['fullName'];?>" readonly  >
                                </div>
                                <div class="col-sm-4 text-center form-group">
                                    <label for="sex" class="fw-bold">Bill No:</label>
                                    <input type="text" class="form-control text-center border-0" name="gender" id="sex" value="<?php  echo $row['gender'];?>" readonly  >
                                </div>
                                <div class="col-sm-4 text-center form-group">
                                    <label for="age" class="fw-bold">Date:</label>
                                    <div>
                                        <?php
                                        date_default_timezone_set("Asia/Kolkata");
                                        echo date("Y-m-d")."\t";
                                        echo date("H:i:s");
                                        ?>
                                    </div>
                                </div>
                                <div class=" mt-0"><hr style="border: 1px solid #012970;"></div>
                                <?php }?>
                                <div class="col-sm-8 form-group text-center fw-bold ">
                                    <label for="description text-center fw-bold">Description</label>
                                    <hr class="text-primary fw-bold">
                                    <input type="text" class="form-control" name="paydescrp" id="description" placeholder="About Desease" required>
                                </div>
                                <div class="col-sm-4 form-group text-center fw-bold">
                                    <label for="total ">Total</label>
                                    <hr class="text-primary fw-bold">
                                    <input type="text" class="form-control" name="payamount" id="total" placeholder="Amount" required>
                                </div>
                                <div class="col-sm-12 form-group mt-3">
                                    <br>
                                    <label for="signature " class="float-end fw-bold">Authorized Signature</label>                                    
                                </div>
                                <div class="col-sm-12 form-group mt-3">
                                    <hr class="mt-0">
                                    <button type="submit" name="submit"  class="btn btn-outline-success float-end">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </main>


 

  

  <?php include('include/footer.php');?>

</body>

</html>

<?php } ?>