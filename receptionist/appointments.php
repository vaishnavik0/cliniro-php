<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:doctorlogout.php');
  } else{
    
if (isset($_GET['Apptid'])) {

  $Apptid = $_GET['Apptid'];

  $query=mysqli_query($con, "update patappointments set Appt_Status='0' where Apptid='$Apptid' ");
if ($query) {

echo "<script>window.location.href ='appointments.php'</script>";
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
      <h1>All Appointments</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="doctorlanding.php">Home</a></li>
          <li class="breadcrumb-item active">Appointments</li>
        </ol>
      </nav>
    </div>
    
    <div class="container-fluid box8 rounded table-responsive" id="patients-patients-cont">
      <table class="table datatable">
        <thead>
          <tr id="form-subhead">
            <th scope="col">#</th>
            <th scope="col">Patient Name</th>
            <th scope="col">Patient Contact</th>
            <th scope="col">Appointment Date</th>
            <th scope="col">Created</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        
        <tbody>
        <tr>
          <td colspan="6" class="text-center fw-bold text-success">Today's Appointments</td>
        </tr>
          <?php
          $sql=mysqli_query($con,"select users.id as patid, users.fullName as fname, users.phone as contact, patappointments.*  from patappointments join users on users.id=patappointments.Appt_Patid where patappointments.Appt_Docid=".$_SESSION['id']." AND patappointments.Appt_Date=CURDATE();");
          $cnt=1;
          while($row=mysqli_fetch_array($sql))
          { ?>
            <tr class="table-active">
            <td class="center"><?php echo $cnt;?>.</td>
            <td class="hidden-xs"><a href="view-patient.php?viewid=<?php echo $row['patid'];?>" id="form-subhead"><?php echo $row['fname'];?></a></td>
            <td><?php echo $row['contact'];?></td>
            <td><?php echo $row['Appt_Date'];?> / <?php echo $row['Appt_Time'];?></td>
            <td><?php echo $row['Appt_Created'];?></td>
            <td>
            <?php if($row['Appt_Status']==1)
            { ?>
            <a href="appointments.php?Apptid=<?php echo $row['Apptid'];?>"><button class="btn btn-outline-success">Active</button></a>
            <?php } else { ?>
              <button type="button" class="btn btn-outline-danger" disabled>Canceled</button>
              <?php } ?>
            </td>
          </tr>
          <?php  $cnt=$cnt+1; }?>

          <tr>
          <td colspan="6" class="text-center fw-bold text-primary">Upcoming Appointments</td>
        </tr>
          <?php
          $sql=mysqli_query($con,"select users.id as patid, users.fullName as fname, users.phone as contact, patappointments.*  from patappointments join users on users.id=patappointments.Appt_Patid where patappointments.Appt_Docid=".$_SESSION['id']." AND patappointments.Appt_Date > CURDATE();");
          $cnt=1;
          while($row=mysqli_fetch_array($sql))
          { ?>
            <tr class="table-warning">
            <td class="center"><?php echo $cnt;?>.</td>
            <td class="hidden-xs"><a href="view-patient.php?viewid=<?php echo $row['patid'];?>" id="form-subhead"><?php echo $row['fname'];?></a></td>
            <td><?php echo $row['contact'];?></td>
            <td><?php echo $row['Appt_Date'];?> / <?php echo $row['Appt_Time'];?></td>
            <td><?php echo $row['Appt_Created'];?></td>
            <td>
            <?php if($row['Appt_Status']==1)
            { ?>
            <a href="appointments.php?Apptid=<?php echo $row['Apptid'];?>"><button class="btn btn-outline-success">Active</button></a>
            <?php } else { ?>
              <button type="button" class="btn btn-outline-danger" disabled>Canceled</button>
              <?php } ?>
            </td>
          </tr>
          <?php  $cnt=$cnt+1; }?>

          <tr>
          <td colspan="6" class="text-center fw-bold text-danger">Past Appointments</td>
        </tr>
          <?php
          $sql=mysqli_query($con,"select users.id as patid, users.fullName as fname, users.phone as contact, patappointments.*  from patappointments join users on users.id=patappointments.Appt_Patid where patappointments.Appt_Docid=".$_SESSION['id']." AND patappointments.Appt_Date < CURDATE() order by patappointments.Appt_Date desc;");
          $cnt=1;
          while($row=mysqli_fetch_array($sql))
          { ?>
            <tr class="table-danger">
            <td class="center"><?php echo $cnt;?>.</td>
            <td class="hidden-xs"><a href="view-patient.php?viewid=<?php echo $row['patid'];?>" id="form-subhead"><?php echo $row['fname'];?></a></td>
            <td><?php echo $row['contact'];?></td>
            <td><?php echo $row['Appt_Date'];?> / <?php echo $row['Appt_Time'];?></td>
            <td><?php echo $row['Appt_Created'];?></td>
            <td>
            <?php if($row['Appt_Status']==1)
            { ?>
            <button class="btn btn-outline-success" disabled>Done</button>
            <?php } else { ?>
              <button type="button" class="btn btn-outline-danger" disabled>Canceled</button>
              <?php } ?>
            </td>
          </tr>
          <?php  $cnt=$cnt+1; }?>


        </tbody>
      </table>
    </div>
  </main>
  <?php include('include/footer.php');?>
</body>

</html>
<?php } ?>


<!--
  SELECT date_column
FROM your_table_name
ORDER BY
  CASE 
    WHEN date_column = CURDATE() THEN 0 -- current date
    ELSE 1 -- other dates
  END,
  date_column DESC;
-->