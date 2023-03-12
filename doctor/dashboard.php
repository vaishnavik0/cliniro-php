<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:doctorlogout.php');
  } else{
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

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6" >

        

        
          <div class="container text-center">
            <div class="row g-2">
            <form role="form" method="post" name="search" >
            <div class="row border border-primary bg-success m-auto p-2 justify-content-center rounded">
              <div class="col-sm-4 text-center form-group">
                  <label for="patname" class="fw-bold text-light">Date:</label>
                  <input type="date" id="datesearch" name="datesearch">
              </div>

              <div class="col-sm-2 text-center form-group mt-3">
                <button type="submit" name="search" id="submit" class="btn btn-outline-light">Submit</button>
              </div>
              
              
            </div>

        </form>
            <?php
                   if(isset($_POST['search']))
                   { 
                      $datesearch=$_POST['datesearch'];
                      $result = mysqli_query($con,"SELECT COUNT(PatientID) as TPat, SUM(PayAmount) TAmt from tblmedicalhistory WHERE DocId=".$_SESSION['id']." and CreationDate like '$datesearch%';");
                      while ($row=mysqli_fetch_array($result)) { 
                      ?>
                  
              <div class="col-lg-5 m-auto mt-4 rounded" style="background-color:#20bf55">
                <div class="p-3">
                <h3 class="fw-bold text-center">Patients</h3>
                <h1 class="fw-bold" id="form-subhead">
                <i class="bi bi-person"></i> <?php echo $row['TPat'];?>
                  </h1>
                  <hr>
                  <?php echo $datesearch?>
                </div>
              </div>
              <div class="col-lg-5 m-auto mt-4 bg-info rounded">
                <div class="p-3">
                <h3 class="fw-bold text-center">Revenue</h3>
                <h1 class="fw-bold" id="form-subhead">
                ₹ <?php echo $row['TAmt'];?> 
                  </h1>
                  <hr>
                  <?php echo $datesearch?>
                </div>
              </div>
              <?php } } else { ?>

                <div class="col-lg-5 m-auto mt-4  bg-info rounded">
                <div class="p-3">
                <h3 class="fw-bold text-center">Revenue</h3>
                <h1 class="fw-bold" id="form-subhead">
                  <?php
                      date_default_timezone_set("Asia/Kolkata");
                      $todaydate =date("Y-m-d");
                      $docid = $_SESSION['id'];
                      $result = mysqli_query($con,"SELECT PatientID as TotalPatients from tblmedicalhistory WHERE DocId=".$_SESSION['id'].";");
                      $num_rows = mysqli_num_rows($result);
                      {
                        echo htmlentities($num_rows);  
                      }
                    ?>
                  </h1>
                </div>
              </div>
              <div class="col-lg-5 m-auto mt-4  rounded" style="background-color:#20bf55">
                <div class="p-3">
                <h3 class="fw-bold text-center">Revenue</h3>
                <h1 class="fw-bold" id="form-subhead">
                  <?php
                      date_default_timezone_set("Asia/Kolkata");
                      $todaydate =date("Y-m-d");
                      $docid = $_SESSION['id'];
                      $result = mysqli_query($con,"SELECT PatientID as TotalPatients from tblmedicalhistory WHERE DocId=".$_SESSION['id'].";");
                      $num_rows = mysqli_num_rows($result);
                      {
                        echo htmlentities($num_rows);  
                      }
                    ?>
                  </h1>
                </div>
              </div>


                <?php } ?>
            </div>
          </div>
        </div>

        
      <div class="col-lg-6">
          <div class="card rounded bg-success">
            <div class="card-body">
              <h5 class="card-title text-light text-center"> <i class="fs-3 bi bi-person"></i> Total Patients Treated</h5>

              <!-- Line Chart -->
              <canvas id="lineChart" style="max-height: 400px;background-color:#E9F8F9;border-radius:5px"></canvas>
              <?php 
              $sql ="SELECT COUNT(PatientID) as TotalPatients, MONTHNAME(CreationDate) as Month from tblmedicalhistory WHERE DocId=".$_SESSION['id']." GROUP by MONTHNAME(CreationDate);";
              $result = mysqli_query($con,$sql);
              $chart_data="";
              while ($row = mysqli_fetch_array($result)) { 
      
                 $LineMonth[]  = $row['Month']  ;
                 $TotalPat[] = $row['TotalPatients'];
             }
              ?>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#lineChart'), {
                    type: 'line',
                    data: {
                      labels: <?php echo json_encode($LineMonth); ?>,
                      datasets: [{
                        label: 'Patients Treated',
                        data: <?php echo json_encode($TotalPat); ?>,
                        fill: false,
                        borderColor: '#012970',
                        tension: 0.1,
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointHoverRadius: 10
                      }]
                    },
                    options: {
                      scales: {
                        y: {
                          beginAtZero: true
                        }
                      }
                    }
                  });
                });
              </script>
              <!-- End Line CHart -->

            </div>
          </div>
        </div>

       

        

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Ratings</h5>

              <!-- Doughnut Chart -->
              <canvas id="doughnutChart" style="max-height: 400px;"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#doughnutChart'), {
                    type: 'doughnut',
                    data: {
                      labels: [
                        'Red',
                        'Blue',
                        'Yellow'
                      ],
                      datasets: [{
                        label: 'My First Dataset',
                        data: [300, 50, 100],
                        backgroundColor: [
                          'rgb(255, 99, 132)',
                          'rgb(54, 162, 235)',
                          'rgb(255, 205, 86)'
                        ],
                        hoverOffset: 4
                      }]
                    }
                  });
                });
              </script>
              <!-- End Doughnut CHart -->

            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body rounded" style="background-color:#012970">
              <h5 class="card-title text-light text-center"> <i class=" fs-3 bi bi-cash-coin"></i> Month Wise Generated Revenue</h5>
              <?php 
              $sqlbar ="SELECT SUM(PayAmount) as Revenue, MONTHNAME(CreationDate) as Month from tblmedicalhistory WHERE DocId=".$_SESSION['id']." GROUP by MONTHNAME(CreationDate);";
              $result = mysqli_query($con,$sqlbar);
              $chart_data="";
              while ($row = mysqli_fetch_array($result)) { 
      
                 $month[]  = $row['Month']  ;
                 $revenue[] = $row['Revenue'];
             }
              ?>

              <!-- Bar Chart -->
              <canvas id="barChart" style="max-height: 400px;background-color:#E9F8F9;border-radius:5px"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#barChart'), {
                    type: 'bar',
                    data: {
                      labels: <?php echo json_encode($month); ?>,
                      datasets: [{
                        label: 'Revenue',
                        data: <?php echo json_encode($revenue); ?>,
                        borderRadius: 5,
                        backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(255, 159, 64, 0.2)',
                          'rgba(255, 205, 86, 0.2)',
                          'rgba(75, 192, 192, 0.2)',
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(153, 102, 255, 0.2)',
                          'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                          'rgb(255, 99, 132)',
                          'rgb(255, 159, 64)',
                          'rgb(255, 205, 86)',
                          'rgb(75, 192, 192)',
                          'rgb(54, 162, 235)',
                          'rgb(153, 102, 255)',
                          'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                      }]
                    },
                    options: {
                      scales: {
                        y: {
                          beginAtZero: true
                        }
                      }
                    }
                  });
                });
              </script>
              <!-- End Bar CHart -->

            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Pie Chart</h5>

              <!-- Pie Chart -->
              <canvas id="pieChart" style="max-height: 400px;"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#pieChart'), {
                    type: 'pie',
                    data: {
                      labels: [
                        'Red',
                        'Blue',
                        'Yellow'
                      ],
                      datasets: [{
                        label: 'My First Dataset',
                        data: [300, 50, 100],
                        backgroundColor: [
                          'rgb(255, 99, 132)',
                          'rgb(54, 162, 235)',
                          'rgb(255, 205, 86)'
                        ],
                        hoverOffset: 4
                      }]
                    }
                  });
                });
              </script>
              <!-- End Pie CHart -->

            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Radar Chart</h5>

              <!-- Radar Chart -->
              <canvas id="radarChart" style="max-height: 400px;"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#radarChart'), {
                    type: 'radar',
                    data: {
                      labels: [
                        'Eating',
                        'Drinking',
                        'Sleeping',
                        'Designing',
                        'Coding',
                        'Cycling',
                        'Running'
                      ],
                      datasets: [{
                        label: 'First Dataset',
                        data: [65, 59, 90, 81, 56, 55, 40],
                        fill: true,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgb(255, 99, 132)',
                        pointBackgroundColor: 'rgb(255, 99, 132)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(255, 99, 132)'
                      }, {
                        label: 'Second Dataset',
                        data: [28, 48, 40, 19, 96, 27, 100],
                        fill: true,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgb(54, 162, 235)',
                        pointBackgroundColor: 'rgb(54, 162, 235)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(54, 162, 235)'
                      }]
                    },
                    options: {
                      elements: {
                        line: {
                          borderWidth: 3
                        }
                      }
                    }
                  });
                });
              </script>
              <!-- End Radar CHart -->

            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Polar Area Chart</h5>

              <!-- Polar Area Chart -->
              <canvas id="polarAreaChart" style="max-height: 400px;"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#polarAreaChart'), {
                    type: 'polarArea',
                    data: {
                      labels: [
                        'Red',
                        'Green',
                        'Yellow',
                        'Grey',
                        'Blue'
                      ],
                      datasets: [{
                        label: 'My First Dataset',
                        data: [11, 16, 7, 3, 14],
                        backgroundColor: [
                          'rgb(255, 99, 132)',
                          'rgb(75, 192, 192)',
                          'rgb(255, 205, 86)',
                          'rgb(201, 203, 207)',
                          'rgb(54, 162, 235)'
                        ]
                      }]
                    }
                  });
                });
              </script>
              <!-- End Polar Area Chart -->

            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Stacked Bar Chart</h5>

              <!-- Stacked Bar Chart -->
              <canvas id="stakedBarChart" style="max-height: 400px;"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#stakedBarChart'), {
                    type: 'bar',
                    data: {
                      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                      datasets: [{
                          label: 'Dataset 1',
                          data: [-75, -15, 18, 48, 74],
                          backgroundColor: 'rgb(255, 99, 132)',
                        },
                        {
                          label: 'Dataset 2',
                          data: [-11, -1, 12, 62, 95],
                          backgroundColor: 'rgb(75, 192, 192)',
                        },
                        {
                          label: 'Dataset 3',
                          data: [-44, -5, 22, 35, 62],
                          backgroundColor: 'rgb(255, 205, 86)',
                        },
                      ]
                    },
                    options: {
                      plugins: {
                        title: {
                          display: true,
                          text: 'Chart.js Bar Chart - Stacked'
                        },
                      },
                      responsive: true,
                      scales: {
                        x: {
                          stacked: true,
                        },
                        y: {
                          stacked: true
                        }
                      }
                    }
                  });
                });
              </script>
              <!-- End Stacked Bar Chart -->

            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Bubble Chart</h5>

              <!-- Bubble Chart -->
              <canvas id="bubbleChart" style="max-height: 400px;"></canvas>
              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#bubbleChart'), {
                    type: 'bubble',
                    data: {
                      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                      datasets: [{
                          label: 'Dataset 1',
                          data: [{
                              x: 20,
                              y: 30,
                              r: 15
                            },
                            {
                              x: 40,
                              y: 10,
                              r: 10
                            },
                            {
                              x: 15,
                              y: 37,
                              r: 12
                            },
                            {
                              x: 32,
                              y: 42,
                              r: 33
                            }
                          ],
                          borderColor: 'rgb(255, 99, 132)',
                          backgroundColor: 'rgba(255, 99, 132, 0.5)'
                        },
                        {
                          label: 'Dataset 2',
                          data: [{
                              x: 40,
                              y: 25,
                              r: 22
                            },
                            {
                              x: 24,
                              y: 47,
                              r: 11
                            },
                            {
                              x: 65,
                              y: 11,
                              r: 14
                            },
                            {
                              x: 11,
                              y: 55,
                              r: 8
                            }
                          ],
                          borderColor: 'rgb(75, 192, 192)',
                          backgroundColor: 'rgba(75, 192, 192, 0.5)'
                        }
                      ]
                    },
                    options: {
                      responsive: true,
                      plugins: {
                        legend: {
                          position: 'top',
                        },
                        title: {
                          display: true,
                          text: 'Chart.js Bubble Chart'
                        }
                      }
                    }
                  });
                });
              </script>
              <!-- End Bubble Chart -->

            </div>
          </div>
        </div>

      </div>
    </section>


</main><!-- End #main -->


 

  

<?php include('include/footer.php');?>

</body>

</html>

<?php } ?>