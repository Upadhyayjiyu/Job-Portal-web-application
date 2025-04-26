<?php

//To Handle Session Variables on This Page
session_start();


//Including Database Connection From db.php file to avoid rewriting in all files
require_once("db.php");
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Job Portal</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <link rel="stylesheet" href="css/_all-skins.min.css">
  <!-- Custom -->
  <link rel="stylesheet" href="css/custom.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">

    <header class="main-header">

      <!-- Logo -->
      <a href="index.php" class="logo logo-bg">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>J</b>P</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><span><b>J</b></span>ob <span><b>P</b></span>ortal</span>
      </a>

      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li>
              <a href="jobs.php">Jobs</a>
            </li>
            <li>
              <a href="#candidates">Candidates</a>
            </li>
            <li>
              <a href="#company">Company</a>
            </li>
            <li>
              <a href="#about">About Us</a>
            </li>
            <?php if (empty($_SESSION['id_user']) && empty($_SESSION['id_company'])) { ?>
              <li>
                <a href="login.php">Login</a>
              </li>
              <li>
                <a href="sign-up.php">Sign Up</a>
              </li>
              <?php } else {

              if (isset($_SESSION['id_user'])) {
              ?>
                <li>
                  <a href="user/index.php">Dashboard</a>
                </li>
              <?php
              } else if (isset($_SESSION['id_company'])) {
              ?>
                <li>
                  <a href="company/index.php">Dashboard</a>
                </li>
              <?php } ?>
              <li>
                <a href="logout.php">Logout</a>
              </li>
            <?php } ?>
          </ul>
        </div>
      </nav>
    </header>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-left: 0px;">

      <section class="content-header bg-main">
        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center index-head">
              <h1>All <strong>JOBS</strong> In One Place</h1>
              <p>One search, global reach</p>
              <p><a class="btn btn-success btn-lg" href="jobs.php" role="button">Search Jobs</a></p>
            </div>
          </div>
        </div>
      </section>

      <section class="content-header">
        <div class="container">
          <div class="row">
            <div class="col-md-12 latest-job margin-bottom-20">
              <h1 class="text-center">Job Listing</h1>
              <div class="slide-container swiper">
                <div class="slide-content">
                  <div class="card-wrapper swiper-wrapper">
                    <?php
                    $sql = "SELECT * FROM job_post ORDER BY id_jobpost DESC LIMIT 5";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                      $i = 1;
                      while ($row = $result->fetch_assoc()) {
                        $sql1 = "SELECT * FROM company WHERE id_company='$row[id_company]'";
                        $result1 = $conn->query($sql1);
                        if ($result1->num_rows > 0) {
                          while ($row1 = $result1->fetch_assoc()) { ?>
                            <div class="card swiper-slide">
                              <div class="image-content">
                                <span class="overlay"></span>
                                <div class="card-image">
                                  <img src="<?php echo 'img/latest-job-' . $i . '.png' ?>" alt="" class="card-img">
                                </div>
                              </div>
                              <div class="card-content">
                                <h2 class="name"><?php echo ucwords($row['jobtitle']); ?></h2>
                                <p class="description"><strong>Company: <?php echo $row1['companyname']; ?> <br>City: <?php echo $row1['city']; ?> <br> Experience <?php echo $row['experience']; ?> Years <br> Salary: $<?php echo $row['maximumsalary']; ?>/month</strong></p>
                                <!-- <p class="description"><strong><?php echo $row1['companyname']; ?> | <?php echo $row1['city']; ?> | Experience <?php echo $row['experience']; ?> Years</strong></p> -->
                                  <a class="button" href="view-job-post.php?id=<?php echo $row['id_jobpost']; ?>">View More</a>
                              </div>
                            </div>
                          <?php }
                          $i++;
                        }
                      }
                    }
                    ?>
                  </div>
                </div>
                <div class="swiper-button-next swiper-navBtn"></div>
                <div class="swiper-button-prev swiper-navBtn"></div>
                <div class="swiper-pagination"></div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="candidates" class="content-header">
        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center latest-job margin-bottom-20">
              <h1>Candidates</h1>
              <p>Finding a job just got easier. Create a profile and apply with single mouse click.</p>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4 col-md-4">
              <div class="thumbnail candidate-img">
                <img src="img/browse2.jpg" alt="Browse Jobs">
                <div class="caption">
                  <h3 class="text-center">Find Your Dream Jobs</h3>
                </div>
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="thumbnail candidate-img">
                <img src="img/interviewed.jpeg" alt="Apply & Get Interviewed">
                <div class="caption">
                  <h3 class="text-center">Prepare present and get hired</h3>
                </div>
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="thumbnail candidate-img">
                <img src="img/career.jpg" alt="Start A Career">
                <div class="caption">
                  <h3 class="text-center">Start A Career</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="company" class="content-header">
        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center latest-job margin-bottom-20">
              <h1>Companies</h1>
              <p>Hiring? Register your company for free, browse our talented pool, post and track job applications</p>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4 col-md-4">
              <div class="thumbnail company-img">
                <img src="img/postjob.jpg" alt="Browse Jobs">
                <div class="caption">
                  <h3 class="text-center">Post A Job</h3>
                </div>
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="thumbnail company-img">
                <img src="img/manage.jfif" alt="Apply & Get Interviewed">
                <div class="caption">
                  <h3 class="text-center">Recruitment</h3>
                </div>
              </div>
            </div>
            <div class="col-sm-4 col-md-4">
              <div class="thumbnail company-img">
                <img src="img/hire.png" alt="Start A Career">
                <div class="caption">
                  <h3 class="text-center">Hire</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="statistics" class="content-header">
        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center latest-job margin-bottom-20">
              <h1>Application Tracking</h1>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner card-border-left">
                  <?php
                  $sql = "SELECT * FROM job_post";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $totalno = $result->num_rows;
                  } else {
                    $totalno = 0;
                  }
                  ?>
                  <h3><?php echo $totalno; ?></h3>

                  <p>Job Offers</p>
                </div>
                <div class="icon">
                  <i class="ion ion-ios-paper"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner card-border-left">
                  <?php
                  $sql = "SELECT * FROM company WHERE active='1'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $totalno = $result->num_rows;
                  } else {
                    $totalno = 0;
                  }
                  ?>
                  <h3><?php echo $totalno; ?></h3>

                  <p>Registered Company</p>
                </div>
                <div class="icon">
                  <i class="ion ion-briefcase"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner card-border-left">
                  <?php
                  $sql = "SELECT * FROM users WHERE resume!=''";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $totalno = $result->num_rows;
                  } else {
                    $totalno = 0;
                  }
                  ?>
                  <h3><?php echo $totalno; ?></h3>

                  <p>CV'S/Resume</p>
                </div>
                <div class="icon">
                  <i class="ion ion-ios-list"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner card-border-left">
                  <?php
                  $sql = "SELECT * FROM users WHERE active='1'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    $totalno = $result->num_rows;
                  } else {
                    $totalno = 0;
                  }
                  ?>
                  <h3><?php echo $totalno; ?></h3>

                  <p>Daily Users</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-stalker"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
          </div>
        </div>
      </section>

      <section id="about" class="content-header">
        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center latest-job margin-bottom-20">
              <h1>Profile</h1>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5">
              <img src="img/profile.jpg" class="img-responsive">
            </div>
            <div class="col-md-7 about-text margin-bottom-20">
              <p>Job portals are websites or online platforms that connect job seekers with potential employers.<br>
              <p>The online job portal application allows job seekers and recruiters to connect.The application provides the ability for job seekers to create their accounts, upload their profile and resume, search for jobs, apply for jobs, view different job openings. The application provides the ability for companies to create their accounts, search candidates, create job postings, and view candidates applications.
              </p>
              <p>
                This website is used to provide a platform for potential candidates to get their dream job and excel in yheir career.
                This site can be used as a paving path for both companies and job-seekers for a better life .

              </p>
            </div>
          </div>
        </div>
      </section>

    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer" style="margin-left: 0px;">
      <div class="text-center">
        <strong>Copyright &copy; 2025 <a href="learningfromscratch.online">Job Portal</a>.</strong> All rights
        reserved.
      </div>
    </footer>

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>

  </div>
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="js/adminlte.min.js"></script>
  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    var swiper = new Swiper(".slide-content", {
      slidesPerView: 3,
      spaceBetween: 25,
      loop: true,
      centerSlide: 'true',
      fade: 'true',
      grabCursor: 'true',
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
        },
        520: {
          slidesPerView: 2,
        },
        950: {
          slidesPerView: 3,
        },
      },
    });
  </script>
  <
    </body>

</html>