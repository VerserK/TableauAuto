<?php
  session_start ();

$_SESSION['state']=session_id();
if($_SESSION['msatg'] != 1){
  echo "<meta http-equiv='refresh' content='0;URL=index.php' />";
  $message = "คุณยังไม่ได้ทำการ Log in";
  echo "<script type='text/javascript'>alert('$message');</script>";
  }
require_once "connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tableau Automation Management</title>
  <link rel="icon" type="image/x-icon" href="dist/img/favicon.ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@100&display=swap">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition sidebar-mini sidebar-open">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-info navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="dashboard" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?php echo $_SESSION["uname"]; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="?action=logout" class="dropdown-item dropdown-footer">Log Out</a>
          <?php
            $ip =  $_SERVER['REMOTE_ADDR'];
            $agent = $_SERVER['HTTP_USER_AGENT'];
            $session = session_id();
            $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $actiontype = 'logout';
            if (isset($_GET['action'])) {
            if ($_GET['action'] == 'logout'){
              $sqllogs = "INSERT INTO logs_users_action ([action],[ip],[agent],[session],[url],[action_type],[created],[empid]) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
              $paramslogs = array($actiontype,$ip,$agent,$session,$url,$actiontype,date("Y-m-d H:i:s"),$_SESSION['empid']);
              $stmtlogs = sqlsrv_query($conn, $sqllogs, $paramslogs);
             unset ($_SESSION['msatg']);

             header ('Location: https://tableauauto.azurewebsites.net/index');
          }
          }
          ?>
        </div>
      </li>
      <!-- Full Screen Menu -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-info elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard">
      <img src="dist/img/logo-th.png" alt="Kubota Logo" class="img-fluid">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Tableau Automation
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="dashboard" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="mail" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Email</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="line" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Line</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tableau Automation Management</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content Email -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">

            <!-- general form elements -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Dashboard Email Notification</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- /.card-header -->
              <!-- <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>NO</th>
                    <th>Enable</th>
                    <th>MailGroup</th>
                    <th>type</th>
                    <th>ID</th>
                    <th>ImageWidth</th>
                    <th>filterName</th>
                    <th>filterValue</th>
                    <th>imageName</th>
                    <th>Time</th>
                    <th>from</th>
                    <th>to</th>
                    <th>cc</th>
                    <th>bcc</th>
                    <th>Subject</th>
                    <th>Content</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody> -->
                    <?php
                    $sqladmin ="SELECT REPLACE([status], ' ', '') as status FROM [dbo].[admin] WHERE [empid] = $_SESSION[empid] ";
                    $resultadmin = sqlsrv_query($conn, $sqladmin);
                    $rowadmin = sqlsrv_fetch_array($resultadmin, SQLSRV_FETCH_ASSOC);
                    $i = 1;
                    if ($rowadmin["status"] === 'admin'){
                      echo '<div class="card-body">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>NO</th>
                          <th>Enable</th>
                          <th>MailGroup</th>
                          <th>type</th>
                          <th>Dashboard ID</th>
                          <th>ImageWidth</th>
                          <th>filterName</th>
                          <th>filterValue</th>
                          <th>imageName</th>
                          <th>Time</th>
                          <th>from</th>
                          <th>to</th>
                          <th>cc</th>
                          <th>bcc</th>
                          <th>Subject</th>
                          <th>Content</th>
                          <th>empid</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>';
                      $sqltablebyid = "SELECT * FROM [dbo].[mailnoti] ORDER BY [MailGroup] DESC";
                      $resulttablebyid = sqlsrv_query($conn, $sqltablebyid);
                      while ($rowtablebyid = sqlsrv_fetch_array($resulttablebyid, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$rowtablebyid['Enable']."</td>";
                        echo "<td>".$rowtablebyid['MailGroup']."</td>";
                        echo "<td>".$rowtablebyid['type']."</td>";
                        echo "<td>".$rowtablebyid['ID']."</td>";
                        echo "<td>".$rowtablebyid['ImageWidth']."</td>";
                        echo "<td>".$rowtablebyid['filterName']."</td>";
                        echo "<td>".$rowtablebyid['filterValue']."</td>";
                        echo "<td>".$rowtablebyid['imageName']."</td>";
                        echo "<td>".$rowtablebyid['CRON']."</td>";
                        echo "<td>".$rowtablebyid['from']."</td>";
                        echo "<td>".$rowtablebyid['to']."</td>";
                        echo "<td>".$rowtablebyid['cc']."</td>";
                        echo "<td>".$rowtablebyid['bcc']."</td>";
                        echo "<td>".$rowtablebyid['Subject']."</td>";
                        echo "<td>".$rowtablebyid['Content']."</td>";
                        echo "<td>".$rowtablebyid['empid']."</td>";
                        echo "<td>";
                        echo "<a class='dropdown ms-4' data-toggle='dropdown' href='#'><i class='fas fa-ellipsis-v'></i></a>";
                        echo "<div class='dropdown-menu dropdown-menu dropdown-menu-left'>";
                        echo "<div class='dropdown-divider'></div>";
                        echo "<a class='dropdown-item' href='mailinsert?no=".$rowtablebyid['no']."'>Insert</a>";
                        echo "<a class='dropdown-item' href='mailedit?no=".$rowtablebyid['no']."'>Edit</a>";
                        echo "<a class='dropdown-item' data-val='".$rowtablebyid['MailGroup']."' href='#' data-toggle='modal' data-target='#modal-delete'>Delete</a>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                      }
                      echo '</tbody>
                        <tfoot>
                        <tr>
                          <th>NO</th>
                          <th>Enable</th>
                          <th>MailGroup</th>
                          <th>type</th>
                          <th>Dashboard ID</th>
                          <th>ImageWidth</th>
                          <th>filterName</th>
                          <th>filterValue</th>
                          <th>imageName</th>
                          <th>Time</th>
                          <th>from</th>
                          <th>to</th>
                          <th>cc</th>
                          <th>bcc</th>
                          <th>Subject</th>
                          <th>Content</th>
                          <th>empid</th>
                          <th>Action</th>
                        </tr>
                        </tfoot>
                      </table>
                    </div>';
                    }else{
                      echo '<div class="card-body">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>NO</th>
                          <th>Enable</th>
                          <th>MailGroup</th>
                          <th>type</th>
                          <th>Dashboard ID</th>
                          <th>ImageWidth</th>
                          <th>filterName</th>
                          <th>filterValue</th>
                          <th>imageName</th>
                          <th>Time</th>
                          <th>from</th>
                          <th>to</th>
                          <th>cc</th>
                          <th>bcc</th>
                          <th>Subject</th>
                          <th>Content</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>';
                      $sqltablebyid = "SELECT * FROM [dbo].[mailnoti] WHERE [empid] = $_SESSION[empid] ORDER BY [MailGroup] DESC";
                      $resulttablebyid = sqlsrv_query($conn, $sqltablebyid);
                      while ($rowtablebyid = sqlsrv_fetch_array($resulttablebyid, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$rowtablebyid['Enable']."</td>";
                        echo "<td>".$rowtablebyid['MailGroup']."</td>";
                        echo "<td>".$rowtablebyid['type']."</td>";
                        echo "<td>".$rowtablebyid['ID']."</td>";
                        echo "<td>".$rowtablebyid['ImageWidth']."</td>";
                        echo "<td>".$rowtablebyid['filterName']."</td>";
                        echo "<td>".$rowtablebyid['filterValue']."</td>";
                        echo "<td>".$rowtablebyid['imageName']."</td>";
                        echo "<td>".$rowtablebyid['CRON']."</td>";
                        echo "<td>".$rowtablebyid['from']."</td>";
                        echo "<td>".$rowtablebyid['to']."</td>";
                        echo "<td>".$rowtablebyid['cc']."</td>";
                        echo "<td>".$rowtablebyid['bcc']."</td>";
                        echo "<td>".$rowtablebyid['Subject']."</td>";
                        echo "<td>".$rowtablebyid['Content']."</td>";
                        echo "<td>";
                        echo "<a class='dropdown ms-4' data-toggle='dropdown' href='#'><i class='fas fa-ellipsis-v'></i></a>";
                        echo "<div class='dropdown-menu dropdown-menu dropdown-menu-left'>";
                        echo "<div class='dropdown-divider'></div>";
                        echo "<a class='dropdown-item' href='mailinsert?no=".$rowtablebyid['MailGroup']."'>Insert</a>";
                        echo "<a class='dropdown-item' href='mailedit?no=".$rowtablebyid['no']."'>Edit</a>";
                        echo "<a class='dropdown-item' data-val='".$rowtablebyid['MailGroup']."' href='#' data-toggle='modal' data-target='#modal-delete'>Delete</a>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                    }
                    echo '</tbody>
                        <tfoot>
                        <tr>
                          <th>NO</th>
                          <th>Enable</th>
                          <th>MailGroup</th>
                          <th>type</th>
                          <th>Dashboard ID</th>
                          <th>ImageWidth</th>
                          <th>filterName</th>
                          <th>filterValue</th>
                          <th>imageName</th>
                          <th>Time</th>
                          <th>from</th>
                          <th>to</th>
                          <th>cc</th>
                          <th>bcc</th>
                          <th>Subject</th>
                          <th>Content</th>
                          <th>Action</th>
                        </tr>
                        </tfoot>
                      </table>
                    </div>';
                  }
                    ?>
                  <!-- </tbody>
                  <tfoot>
                  <tr>
                    <th>NO</th>
                    <th>Enable</th>
                    <th>MailGroup</th>
                    <th>type</th>
                    <th>ID</th>
                    <th>ImageWidth</th>
                    <th>filterName</th>
                    <th>filterValue</th>
                    <th>imageName</th>
                    <th>Time</th>
                    <th>from</th>
                    <th>to</th>
                    <th>cc</th>
                    <th>bcc</th>
                    <th>Subject</th>
                    <th>Content</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div> -->
              <!-- /.card-body -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Main content Line -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">

            <!-- general form elements -->
            <div class="card card-success border-success mb-3">
              <div class="card-header">
                <h3 class="card-title">Dashboard Line Notification</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- /.card-header -->
              <!-- <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>NO</th>
                    <th>Enable</th>
                    <th>DashboardName</th>
                    <th>ViewId</th>
                    <th>Token</th>
                    <th>FilterName</th>
                    <th>FilterValue</th>
                    <th>Time</th>
                    <th>Message</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody> -->
                    <?php
                    $sqladmin ="SELECT REPLACE([status], ' ', '') as status FROM [dbo].[admin] WHERE [empid] = $_SESSION[empid] ";
                    $resultadmin = sqlsrv_query($conn, $sqladmin);
                    $rowadmin = sqlsrv_fetch_array($resultadmin, SQLSRV_FETCH_ASSOC);
                    $i = 1;
                    if ($rowadmin["status"] === 'admin'){
                      echo '<div class="card-body">
                        <table id="example2" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>NO</th>
                            <th>Enable</th>
                            <th>Dashboard Name</th>
                            <th>Dashboard ID</th>
                            <th>Token</th>
                            <th>FilterName</th>
                            <th>FilterValue</th>
                            <th>Time</th>
                            <th>Message</th>
                            <th>empid</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>';
                      $sqltablelinebyid = "SELECT * FROM [dbo].[linenoti] ORDER BY [no] DESC";
                      $resulttablelinebyid = sqlsrv_query($conn, $sqltablelinebyid);
                      while ($rowtablelinebyid = sqlsrv_fetch_array($resulttablelinebyid, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$rowtablelinebyid['Enable']."</td>";
                        echo "<td>".$rowtablelinebyid['Dashboardname']."</td>";
                        echo "<td>".$rowtablelinebyid['ViewId']."</td>";
                        echo "<td>".$rowtablelinebyid['Token']."</td>";
                        echo "<td>".$rowtablelinebyid['FilterName']."</td>";
                        echo "<td>".$rowtablelinebyid['FilterValue']."</td>";
                        echo "<td>".$rowtablelinebyid['Time']."</td>";
                        echo "<td>".$rowtablelinebyid['Message']."</td>";
                        echo "<td>".$rowtablelinebyid['empid']."</td>";
                        echo "<td>";
                        echo "<a class='dropdown ms-4' data-toggle='dropdown' href='#'><i class='fas fa-ellipsis-v'></i></a>";
                        echo "<div class='dropdown-menu dropdown-menu dropdown-menu-left'>";
                        echo "<div class='dropdown-divider'></div>";
                        echo "<a class='dropdown-item' href='lineedit?no=".$rowtablelinebyid['no']."'>Edit</a>";
                        echo "<a class='dropdown-item' href='#' data-val='".$rowtablelinebyid['no']."' data-toggle='modal' data-target='#modal-delete-line'>Delete</a>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                      }
                      echo '</tbody>
                        <tfoot>
                        <tr>
                          <th>NO</th>
                          <th>Enable</th>
                          <th>Dashboard Name</th>
                          <th>Dashboard ID</th>
                          <th>Token</th>
                          <th>FilterName</th>
                          <th>FilterValue</th>
                          <th>Time</th>
                          <th>Message</th>
                          <th>empid</th>
                          <th>Action</th>
                        </tr>
                        </tfoot>
                      </table>
                    </div>';
                    }else{
                      echo '<div class="card-body">
                        <table id="example2" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>NO</th>
                            <th>Enable</th>
                            <th>Dashboard ID</th>
                            <th>ViewId</th>
                            <th>Token</th>
                            <th>FilterName</th>
                            <th>FilterValue</th>
                            <th>Time</th>
                            <th>Message</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody>';
                      $sqltablelinebyid = "SELECT * FROM [dbo].[linenoti] WHERE [empid] = $_SESSION[empid] ORDER BY [no] DESC";
                      $resulttablelinebyid = sqlsrv_query($conn, $sqltablelinebyid);
                      while ($rowtablelinebyid = sqlsrv_fetch_array($resulttablelinebyid, SQLSRV_FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$i."</td>";
                        echo "<td>".$rowtablelinebyid['Enable']."</td>";
                        echo "<td>".$rowtablelinebyid['Dashboardname']."</td>";
                        echo "<td>".$rowtablelinebyid['ViewId']."</td>";
                        echo "<td>".$rowtablelinebyid['Token']."</td>";
                        echo "<td>".$rowtablelinebyid['FilterName']."</td>";
                        echo "<td>".$rowtablelinebyid['FilterValue']."</td>";
                        echo "<td>".$rowtablelinebyid['Time']."</td>";
                        echo "<td>".$rowtablelinebyid['Message']."</td>";
                        echo "<td>";
                        echo "<a class='dropdown ms-4' data-toggle='dropdown' href='#'><i class='fas fa-ellipsis-v'></i></a>";
                        echo "<div class='dropdown-menu dropdown-menu dropdown-menu-left'>";
                        echo "<div class='dropdown-divider'></div>";
                        echo "<a class='dropdown-item' href='lineedit?no=".$rowtablelinebyid['no']."'>Edit</a>";
                        echo "<a class='dropdown-item' href='#' data-val='".$rowtablelinebyid['no']."' data-toggle='modal' data-target='#modal-delete-line'>Delete</a>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                      }
                      echo '</tbody>
                        <tfoot>
                        <tr>
                          <th>NO</th>
                          <th>Enable</th>
                          <th>Dashboard ID</th>
                          <th>ViewId</th>
                          <th>Token</th>
                          <th>FilterName</th>
                          <th>FilterValue</th>
                          <th>Time</th>
                          <th>Message</th>
                          <th>Action</th>
                        </tr>
                        </tfoot>
                      </table>
                    </div>';
                    }?>
                  <!-- </tbody>
                  <tfoot>
                  <tr>
                    <th>NO</th>
                    <th>Enable</th>
                    <th>DashboardName</th>
                    <th>ViewId</th>
                    <th>Token</th>
                    <th>FilterName</th>
                    <th>FilterValue</th>
                    <th>Time</th>
                    <th>Message</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div> -->
              <!-- /.card-body -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
          <?php
            $sqldelete = "SELECT * FROM [dbo].[mailnoti]";
            $resultdelete = sqlsrv_query($conn, $sqldelete);
          ?>
          <?php while ($rowdelete = sqlsrv_fetch_array($resultdelete, SQLSRV_FETCH_ASSOC)) {?>
          <div class="modal fade" id="modal-delete">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Want to Delete Data ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to delete your Email Notification?</p>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <p id="btnDelete"></p>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>

        <?php
            $sqllinedelete = "SELECT * FROM [dbo].[linenoti]";
            $resultlinedelete = sqlsrv_query($conn, $sqllinedelete);
          ?>
          <?php while ($rowlinedelete = sqlsrv_fetch_array($resultlinedelete, SQLSRV_FETCH_ASSOC)) {?>
          <div class="modal fade" id="modal-delete-line">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Want to Delete Data ?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to delete your Line Notification?</p>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <p id="btnDeleteLine"></p>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>

  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2022 <a href="https://www.siamkubota.co.th/">SIAM KUBOTA Corporation</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
});

</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", {
        extend: 'csv',
        text: 'CSV',
        charset: 'utf-8',
        extension: '.csv',
        bom: true
    }, "excel", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", {
        extend: 'csv',
        text: 'CSV',
        charset: 'utf-8',
        extension: '.csv',
        bom: true
    }, "excel", "print", "colvis"]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    $('.swalDefaultError').ready(function() {
      Toast.fire({
        icon: 'error',
        title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
      })
    });
  });

  $('#modal-delete').on('show.bs.modal', function (event) {
  var myVal = $(event.relatedTarget).data('val');
  var ahrefButton = '<a href="maildelete?MailGroup='+myVal+'" type="button" class="btn btn-danger">Delete</a>'
  document.getElementById('btnDelete').innerHTML += ahrefButton;
});

$('#modal-delete-line').on('show.bs.modal', function (event) {
  var myVal = $(event.relatedTarget).data('val');
  var ahrefButton = '<a href="linedelete?no='+myVal+'" type="button" class="btn btn-danger">Delete</a>'
  document.getElementById('btnDeleteLine').innerHTML += ahrefButton;
});
</script>
</body>
</html>
