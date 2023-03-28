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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Cron -->
  <link rel="stylesheet" href="src/jqCron.css">
  <link rel="stylesheet" href="style.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
                <a href="dashboard" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="mail" class="nav-link active">
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
              <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
              <li class="breadcrumb-item active">Email</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <script type="text/javascript">
      function fncAction1()
      {
        if(mail_id.value.length != 0){
          alert("Please ADD Data");
          document.getElementById("add").focus();
          return false;
        }
        if(document.getElementById("tbl").rows.length > 1){
            if(mail_mailto.value.length == 0){
              alert("Please Select Contacts");
              document.getElementById("mail_mailto").focus(); 
              return false;
            }else if(mail_subject.value.length == 0){
              alert("Please enter Subject");
              document.getElementById("mail_subject").focus(); 
              return false;
            }else if(summernote.value.length == 0){
              alert("Please Select Content");
              document.getElementById("summernote").focus(); 
              return false;
            }else{
              document.addRow.action='testSend.php';
              document.addRow.target='iframe_target';
              document.createElement('form').submit.call(document.addRow);
              setTimeout(function() {
                  $('#modal-check-test').modal('hide');
              }, 8000);
            }
          }else if(document.getElementById("tbl").rows.length = 1){
            if (mail_id.value.length == 0){ 
              alert("Please enter Dashboard ID");  	
              document.getElementById("mail_id").focus();
              return false; 
            }else if(mail_imagename.value.length == 0){
              alert("Please enter imageName");
              document.getElementById("mail_imagename").focus();
              return false; 
            }else if(mail_corn.value.length == 0){
              alert("Please enter Time Send"); 
              document.getElementById("mail_corn").focus(); 	
              return false;
            }else if(mail_mailto.value.length == 0){
              alert("Please Select Contacts");
              document.getElementById("mail_mailto").focus(); 
              return false;
            }else{
              return true;
            }
          }

      }
      function fncAction2()
      {
        if(mail_id.value.length != 0){
          alert("Please ADD Data");
          document.getElementById("add").focus();
          return false;
        }
        if(document.getElementById("tbl").rows.length > 1){
            if(mail_mailto.value.length == 0){
              alert("Please Select Contacts");
              document.getElementById("mail_mailto").focus(); 
              return false;
            }else if(mail_subject.value.length == 0){
              alert("Please enter Subject");
              document.getElementById("mail_subject").focus(); 
              return false;
            }else{
              document.addRow.action='addmail.php';
              document.addRow.target='_self';
              document.createElement('form').submit.call(document.addRow)
            }
          }else if(document.getElementById("tbl").rows.length = 1){
            if (mail_id.value.length == 0){ 
              alert("Please enter Dashboard ID");  	
              document.getElementById("mail_id").focus();
              return false; 
            }else if(mail_imagename.value.length == 0){
              alert("Please enter imageName");
              document.getElementById("mail_imagename").focus();
              return false; 
            }else if(mail_corn.value.length == 0){
              alert("Please enter Time Send"); 
              document.getElementById("mail_corn").focus(); 	
              return false;
            }else if(mail_mailto.value.length == 0){
              alert("Please Select Contacts");
              document.getElementById("mail_mailto").focus(); 
              return false;
            }else{
              return true;
            }
          }
      }
    </script>
    <!-- Main content -->
    <section class="content">
      <form action="addmail" method="POST" name="addRow">
          <iframe id="iframe_target" name="iframe_target" src="#" hidden></iframe>
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md">

            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Email Notification</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <div class="row">

                  <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Dashboard List</h3>
                    </div>
                    <div class="card-body">
                      <table id="tbl" class="table table-sm">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Enable</th>
                            <th>MailGroup</th>
                            <th>Type</th>
                            <th>Dashboard ID</th>
                            <th>ImageWidth</th>
                            <th>filterName</th>
                            <th>filterValue</th>
                            <th>imageName</th>
                            <th>Time</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>

                        </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  </div>

                  <!-- left column mini -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputBorder">Enable</label>
                        <div class="card-body">
                          <input type="checkbox" id="mail_enable" name="mail_enable" data-on-text="Enable" data-off-text="Disable" data-bootstrap-switch data-off-color="danger" data-on-color="success" checked>
                          <input type="hidden" id="mail_enable_val" name="mail_enable_val"/>
                        </div>
                    </div>

                    <?php
                      $query = "SELECT MailGroup FROM [dbo].[mailnoti] ORDER BY MailGroup DESC";
                      $result = sqlsrv_query($conn,$query);
                      $row = sqlsrv_fetch_array($result);
                      $SixDigitRandomNumber = rand(100000,999999);
                      $lastid = $row['MailGroup'];
                      if(empty($lastid))
                        {
                          $number = "GM-0000001";
                        }
                      else
                        {
                          $idd = str_replace("GM-", "", $lastid);
                          $id = str_pad($idd + 1, 7, 0, STR_PAD_LEFT);
                          $number = 'GM-'.$SixDigitRandomNumber;
                        }
                    ?>

                      <div class="form-group">
                        <label for="exampleInputBorder">MailGroup</label><i class="fa-solid fa-circle-question"></i>
                        <input type="text" class="form-control form-control-border" id="mail_mailgroup" name="mail_mailgroup" autocomplete=off value="<?php echo $number; ?>" readonly>
                      </div>

                      <div class="form-group">
                        <label>Type</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="mail_type">
                          <option selected="selected" value="dashboard">dashboard</option>
                          <option value="excel">excel</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorder">Dashboard ID</label>
                        <a href="#" class="btn btn-block btn-outline-info" data-toggle="modal" data-target="#modal-default">ID Viewer</a>
                        <input type="text" class="form-control form-control-border" id="mail_id" name="mail_id" autocomplete=off>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorder">ImageWidth</label>
                        <input type="text" class="form-control form-control-border" id="mail_imagewidth" name="mail_imagewidth" value="500" readonly>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorder">filterName</label>
                        <input type="text" class="form-control form-control-border" id="mail_filtername" name="mail_filtername" autocomplete=off>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorder">filterValue</label>
                        <input type="text" class="form-control form-control-border" id="mail_filtervalue" name="mail_filtervalue" autocomplete=off>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorder">imageName</label>
                        <input type="text" class="form-control form-control-border" id="mail_imagename" name="mail_imagename" autocomplete=off>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorder">Time</label>
                        <!--- somewhere within <body> -->
                          <div class="example7"></div>
                          <input class="example7-input form-control form-control-border" name="mail_corn" readonly/>
                      </div>

                      <div class="col-md-6">
                        <input type="button" id="add" name="add" value="Add Data" onclick="addData();" class="btn btn-block btn-outline-info">
                      </div>

                  </div>
                  <!-- right column mini -->
                  <div class="col-md-6">

                      <div class="form-group">
                        <label for="exampleInputBorder">FROM</label>
                        <i class="fa fa-info-circle" style="color:blue" aria-hidden="true" data-html="true" data-toggle="tooltip" data-placement="top" title="รูปแบบการตั้ง Email<br>
                        'ชื่อที่ต้องการส่ง'<อีเมล@kubota.com> <br>
                        โดยจะต้องทำการขอสิทธิ์ในการใช้งานอีเมลจากผู้ดูแลระบบก่อนเพื่อที่จะสามารถส่งในนามดังกล่าว"></i>
                        <input type="text" class="form-control form-control-border" id="mail_from" name="mail_from" autocomplete=off>
                      </div>

                      <div class="form-group">
                        <label>To</label>
                        <?php 
                          $sql1 = "SELECT *FROM [dbo].[allemployee] WHERE ISNULL([email],'') != '' ORDER BY eid";
                          $result1 = sqlsrv_query($conn, $sql1);
                        ?>
                        <div class="select2-purple">
                          <select class="select2" multiple="multiple" data-dropdown-css-class="select2-purple" data-placeholder="Select a To" style="width: 100%;" id="mail_mailto" name="mail_mailto[]">
                            <?php while ($row1 = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)) {?>
                            <option value="<?php echo $row1["email"]; ?>"><?php echo $row1["nameEN"]. " " . $row1["lastnameEN"]; ?></option>
                          <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label>CC</label>
                        <?php 
                          $sql2 = "SELECT *FROM [dbo].[allemployee] WHERE ISNULL([email],'') != '' ORDER BY eid";
                          $result2 = sqlsrv_query($conn, $sql2); 
                        ?>
                        <div class="select2-purple">
                          <select class="select2" multiple="multiple" data-dropdown-css-class="select2-purple" data-placeholder="Select a CC" style="width: 100%;" id="mail_mailcc" name="mail_mailcc[]">
                            <?php while ($row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)) {?>
                            <option value="<?php echo $row2["email"]; ?>"><?php echo $row2["nameEN"]. " " . $row2["lastnameEN"]; ?></option>
                          <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label>BCC</label>
                        <?php 
                          $sql3 = "SELECT *FROM [dbo].[allemployee] WHERE ISNULL([email],'') != '' ORDER BY eid";
                          $result3 = sqlsrv_query($conn, $sql3);
                        ?>
                        <div class="select2-purple">
                          <select class="select2" multiple="multiple" data-dropdown-css-class="select2-purple" data-placeholder="Select a BCC" style="width: 100%;" id="mail_mailbcc" name="mail_mailbcc[]">
                            <?php while ($row3 = sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC)) {?>
                            <option value="<?php echo $row3["email"]; ?>"><?php echo $row3["nameEN"]. " " . $row3["lastnameEN"]; ?></option>
                          <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorder">Subject</label>
                        <i class="fa fa-info-circle" style="color:blue" aria-hidden="true" data-html="true" data-toggle="tooltip" data-placement="top" title="เงื่อนไขคำสั่ง<br>
                            (date) = วันที่ปัจจุบัน<br>
                            (-date) = วันที่ย้อนหลัง 1 วัน<br>
                            (month) = เดือนปัจจุบัน<br>
                            (-month) = ย้อนหลัง 1 เดือน"></i>
                        <input type="text" class="form-control form-control-border" id="mail_subject" name="mail_subject" autocomplete=off>
                      </div>

                        <div class="form-group">
                          <label>Content</label>
                          <i class="fa fa-info-circle" style="color:blue" aria-hidden="true" data-html="true" data-toggle="tooltip" data-placement="top" title="เงื่อนไขคำสั่ง<br>
                            (date) = วันที่ปัจจุบัน<br>
                            (-date) = วันที่ย้อนหลัง 1 วัน<br>
                            (month) = เดือนปัจจุบัน<br>
                            (-month) = ย้อนหลัง 1 เดือน<br>
                            (nl)(im=imageName.jpeg)(nl) = ขึ้นบรรทัดใหม่ตามด้วยรูปภาพจาก Tableau"></i>
                            <textarea id="summernote" name="summernotez"></textarea>
                        </div>
                        <!-- /.card-header -->
                        <div class="col-md-6">
                          <input type="button" id="addPicture" name="addPicture" value="Add Picture" onclick="addPic()" class="btn btn-block btn-outline-info">
                        </div>

                  </div>
                    <div class="col-md-6">
                      
                    </div>
                    <div class="col-md-6 text-right">
                      <!--<button id="testbtn" type="button" class="btn btn-block btn-outline-warning" onclick="fncAction1()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">Test Send</button>-->
                      <button id="testModel" type="button" class="btn btn-block btn-outline-warning" data-toggle="modal" data-target="#modal-check-test" onclick="addMailModel()">Preview and Sending</button>
                      <button type="button" class="btn btn-block btn-outline-success" onclick="fncAction2()">Submit</button>
                    </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->


        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      </form><!-- /.form -->

      <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Dashboard Scheme</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Dashboard Name</th>
                    <th>ContentUrl</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sqlapi = "SELECT [workbook],[owner],[project],[tags],[location],[idviewer].[id],[idviewer].[name],[contentUrl],[createdAt],[updatedAt],[viewUrlName] 
                    FROM idviewer INNER JOIN tableau_alluser ON idviewer.[owner] = tableau_alluser.id WHERE tableau_alluser.email ='$_SESSION[email]'";
                    $resultapi = sqlsrv_query($conn, $sqlapi);
                  echo '<tr>';
                  while ($rowapi = sqlsrv_fetch_array($resultapi, SQLSRV_FETCH_ASSOC)) {
                      // code...
                    echo '<td><a href="javascript:void(0)" class="link" aria-controls="'.$rowapi["viewUrlName"].'" onclick="getAttrs(event)">'.$rowapi["id"].'</a></td>';
                    echo '<td>'.$rowapi["name"].'</td>';
                    echo '<td>'.$rowapi["contentUrl"].'</td>';
                  echo '</tr>';
                    }
                    ?>
                </tbody>
                <thead>
                  <tr>
                    <th>Dashboard ID</th>
                    <th>Dashboard Name</th>
                    <th>ContentUrl</th>
                  </tr>
                </thead>
              </table>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      
      <div class="modal fade" id="modal-check-test">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Verify that the recipient's name is correct?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>to :</p> 
              <p id="demo"></p>
              <p>CC :</p> 
              <p id="demoCC"></p>
              <p>BCC :</p> 
              <p id="demoBCC"></p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
              <button id="testbtn" type="button" class="btn btn-outline-info" onclick="fncAction1()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">Correct</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

    </section>
    <!-- /.content -->
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
<script src="//code.jquery.com/jquery-1.10.1.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Cron -->
<script src="src/jqCron.js"></script>
<script src="src/jqCron.en.js"></script>
<script src="src/jqCron.th.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
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
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- Page specific script -->
<script>
$(function () {
  bsCustomFileInput.init();
  //Initialize Select2 Elements
    $('.select2').select2({
      tags: true
    })

  //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  // Summernote
    $('#summernote').summernote({
  toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
    ['insert', ['link']],
    ['view', ['fullscreen', 'codeview', 'help']],
    ['mybutton', ['hello']]
  ],

  buttons: {
    hello: HelloButton
  }
})
  //bootstrap-switch
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
});

  // $('#mail_enable').on('change', function(){
  //   this.value = this.checked ? 'x' : '0';
  //     alert(this.value);
  // }).change();

    var ckbox = $("[name='mail_enable']");
    var ckbox_val = $("[name='mail_enable_val']");

    ckbox.on('switchChange.bootstrapSwitch init.bootstrapSwitch', function(event,  state) {
        if (this.checked) ckbox_val.val('x')
        else ckbox_val.val('')
    });

   ckbox.bootstrapSwitch('state', true);

   $(document).ready(() => {
    // set `this` for this scope.
    const self = this;

    const btn = $("#testbtn");

    // bind click event and its handler
    btn.click(() => {
      btn.prop("disabled", true);

      btn.html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
      );

      setTimeout(() => {
        btn.removeAttr("disabled");
        btn.html(
        'Correct'
      );
      }, 8000)
    });
  });

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

  function addPic(){
    var rowCount = $("#tbl tr").length;
    var alltext = '';
    for (let i = 1; i < rowCount; i++){
      var tables = document.getElementById("tbl").rows[i].cells[8].textContent;
      alltext += '(nl)(im=' + tables + '.jpeg)(nl)<br>';
      $("#summernote").summernote('code', alltext);
    }
  }
  function addMailModel() {
    var options = document.getElementById('mail_mailto').selectedOptions;
    var optionsCC = document.getElementById('mail_mailcc').selectedOptions;
    var optionsBCC = document.getElementById('mail_mailbcc').selectedOptions;
    var values = Array.from(options).map(({ value }) => value);
    var valuesCC = Array.from(optionsCC).map(({ value }) => value);
    var valuesBCC = Array.from(optionsBCC).map(({ value }) => value);
    console.log(values);
    document.getElementById("demo").innerHTML = values;
    document.getElementById("demoCC").innerHTML = valuesCC;
    document.getElementById("demoBCC").innerHTML = valuesBCC;
  }
  
  var HelloButton = function (context) {
  var ui = $.summernote.ui;

  // create button
  var button = ui.button({
    contents: '<i class="fa fa-child"/> Hello',
    tooltip: 'hello',
    click: function () {
      // invoke insertText method with 'hello' on editor module.
      context.invoke('editor.insertText', 'hello');
    }
  });

  return button.render();   // return button as jquery object
}
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
      "responsive": true, "lengthChange": false, "autoWidth": false
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
  });
</script>
<script type="text/javascript">
  $(function(){
    $('.example7').jqCron({
        enabled_minute: false,
        multiple_dom: true,
        multiple_month: true,
        multiple_mins: true,
        multiple_dow: true,
        multiple_time_hours: true,
        multiple_time_minutes: true,
        default_period: 'week',
        default_value: '0 10 * * *',
        bind_to: $('.example7-input'),
        bind_method: {
            set: function($element, value) {
                $element.val(value);
            }
        },
        no_reset_button: true,
        lang: 'en'
    });
});
</script>
<script type="text/javascript">
function getAttrs(e) {
  let uname = e.target.getAttribute('aria-controls');
  document.getElementById("mail_imagename").value = uname;
}
document.addEventListener("click", setText);
function setText(event) {
  // Check to see if the event was triggered by one of the links
  if(event.target.classList.contains("link")){
    // Set the value of the input to the text of the element that was clicked
    $("#mail_id").val($(event.target).text());                             // JQuery
    $('#modal-default').modal('hide');
  }
}
</script>
<script type="text/javascript">
  var table = document.getElementsByTagName('table')[0],
  rows = table.getElementsByTagName('tr'),
  text = 'textContent' in document ? 'textContent' : 'innerText';
  console.log(text);

  function addData() {
    var mailEnable = document.addRow.mail_enable_val.value;
    var mailGroup = document.addRow.mail_mailgroup.value;
    var mailType = document.addRow.mail_type.value;
    var mailId = document.addRow.mail_id.value;
    var mailImageWidth = document.addRow.mail_imagewidth.value;
    var mailfilterName = document.addRow.mail_filtername.value;
    var mailfilterValue = document.addRow.mail_filtervalue.value;
    var mailimagename = document.addRow.mail_imagename.value;
    var mailCorn = document.addRow.mail_corn.value;
    var joker = 0;

    var tr = document.createElement('tr');

    var td1 = tr.appendChild(document.createElement('td'));
    var td2 = tr.appendChild(document.createElement('td'));
    var td3 = tr.appendChild(document.createElement('td'));
    var td4 = tr.appendChild(document.createElement('td'));
    var td5 = tr.appendChild(document.createElement('td'));
    var td6 = tr.appendChild(document.createElement('td'));
    var td7 = tr.appendChild(document.createElement('td'));
    var td8 = tr.appendChild(document.createElement('td'));
    var td9 = tr.appendChild(document.createElement('td'));
    var td10 = tr.appendChild(document.createElement('td'));
    var td11 = tr.appendChild(document.createElement('td'));

    for (var i = 0, len = rows.length; i < len; i++){
      td1.innerHTML = '<input type="hidden" name="mail_rowz[]" value="'+ i +'">'+ i;
    }
    td2.innerHTML = '<input type="hidden" name="mail_enablez[]" value="'+ mailEnable +'">'+ mailEnable;
    td3.innerHTML = '<input type="hidden" name="mail_mailgroupz[]" value="'+ mailGroup +'">'+ mailGroup;
    td4.innerHTML = '<input type="hidden" name="mail_typez[]" value="'+ mailType +'">'+ mailType;
    td5.innerHTML = '<input type="hidden" name="mail_idz[]" value="'+ mailId +'">'+ mailId;
    td6.innerHTML = '<input type="hidden" name="mail_imagewidthz[]" value="'+ mailImageWidth +'">'+ mailImageWidth;
    td7.innerHTML = '<input type="hidden" name="mail_filternamez[]" value="'+ mailfilterName +'">'+ mailfilterName;
    td8.innerHTML = '<input type="hidden" name="mail_filtervaluez[]" value="'+ mailfilterValue +'">'+ mailfilterValue;
    td9.innerHTML = '<input type="hidden" name="mail_imagenamez[]" value="'+ mailimagename +'">'+ mailimagename;
    td10.innerHTML = '<input type="hidden" name="mail_cornz[]" value="'+ mailCorn +'">'+ mailCorn;
    td11.innerHTML = '<input type="button" name="delete" value="Delete" onclick="delData(this);" class="btn btn-block btn-outline-danger">'

    document.getElementById("tbl").appendChild(tr);
    document.getElementById("mail_id").value='';
    document.getElementById("mail_filtername").value='';
    document.getElementById("mail_filtervalue").value='';
    document.getElementById("mail_imagename").value='';
  }
  function delData(dRow) {
    var d = dRow.parentNode.parentNode;
    d.parentNode.removeChild(d);
  }
</script>
</body>
</html>
