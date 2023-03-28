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
              <li class="breadcrumb-item active">Edit Email</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
            <?php
              $sqledit = "SELECT * FROM [dbo].[mailnoti] WHERE [no] = '".$_GET['no']."' ";
              $queryedit = sqlsrv_query($conn, $sqledit);
              $resultedit = sqlsrv_fetch_array($queryedit, SQLSRV_FETCH_ASSOC);
            ?>

    <script type="text/javascript">
      function fncAction1()
      {
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
          }else if(summernote.value.length == 0){
            alert("Please Select Contacts");
            document.getElementById("summernote").focus(); 
            return false;
          }else{
            document.addRow.action='testSend.php';
            document.addRow.target='iframe_target';
            document.createElement('form').submit.call(document.addRow);
          }
      }
      function fncAction2()
      {
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
          }else if(summernote.value.length == 0){
            alert("Please Select Contacts");
            document.getElementById("summernote").focus(); 
            return false;
          }else{
            document.addRow.action='editmail?no=<?php echo $resultedit['no']; ?>';
            document.addRow.target='_self';
            document.createElement('form').submit.call(document.addRow);
          }
      }
    </script>

    <!-- Main content -->
    <section class="content">
      <form action="editmail?no=<?php echo $resultedit['no']; ?>" method="POST" name="addRow">
        <iframe id="iframe_target" name="iframe_target" src="#" hidden></iframe>
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md">

            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Email Edit Notification</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <!-- left column mini -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputBorder">Enable</label>
                        <div class="card-body">
                        <input value="<?php echo $resultedit['Enable']; ?>" type="checkbox" name="mail_enablez" data-on-text="Enable" data-off-text="Disable" data-bootstrap-switch data-off-color="danger" data-on-color="success" <?php if (strpos($resultedit['Enable'],'x') !== false) echo 'checked="checked" value="x"'; ?>>
                        </div>
                    </div>
                      <div class="form-group">
                        <label for="exampleInputBorder">MailGroup</label>
                        <input type="text" class="form-control form-control-border" id="mail_mailgroup" name="mail_mailgroupz" value="<?php echo $resultedit['MailGroup']; ?>" autocomplete="off" readonly>
                      </div>

                      <div class="form-group">
                        <label>Type</label>
                        <select class="form-control select2bs4" style="width: 100%;" name="mail_typez">
                          <option <?php if (strpos($resultedit['type'],'dashboard') !== false) echo 'value="dashboard" selected="selected"'; ?>>dashboard</option>
                          <option <?php if (strpos($resultedit['type'],'excel') !== false) echo 'value="excel" selected="selected"'; ?>>excel</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorder">ID</label>
                        <a href="#" class="btn btn-block btn-outline-info" data-toggle="modal" data-target="#modal-default" onclick="upload()">ID Viewer</a>
                        <input type="text" class="form-control form-control-border" id="mail_id" name="mail_idz" value="<?php echo $resultedit['ID']; ?>" autocomplete="off">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorder">ImageWidth</label>
                        <input type="text" class="form-control form-control-border" id="mail_imagewidth" name="mail_imagewidthz" value="<?php echo $resultedit['ImageWidth']; ?>" readonly>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorder">filterName</label>
                        <input type="text" class="form-control form-control-border" id="mail_filtername" name="mail_filternamez" value="<?php echo $resultedit['filterName']; ?>" autocomplete="off">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorder">filterValue</label>
                        <input type="text" class="form-control form-control-border" id="mail_filtervalue" name="mail_filtervaluez" value="<?php echo $resultedit['filterValue']; ?>" autocomplete="off">
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorder">imageName</label>
                        <input type="text" class="form-control form-control-border" id="mail_imagename" name="mail_imagenamez" value="<?php echo $resultedit['imageName']; ?>" autocomplete="off">
                      </div>
                  </div>
                  <!-- right column mini -->
                  <div class="col-md-6">

                      <div class="form-group">
                        <label for="exampleInputBorder">Time</label>
                        <!--- somewhere within <body> -->
                          <div class="example7"></div>
                          <input class="example7-input form-control form-control-border" id="mail_corn" name="mail_cornz" value="<?php echo $resultedit['CRON']; ?>" />
                      </div>

                      <div class="form-group">
                        <label for="exampleInputBorder">FROM</label>
                        <input type="text" class="form-control form-control-border" id="mail_from" name="mail_from" value='<?=$resultedit['from']?>' autocomplete="off" ></input>
                      </div>

                      <?php
                          if($_GET['no']){
                            $mailto_value = (explode(",",$resultedit['to']));
                            $mailcc_value = (explode(",",$resultedit['cc']));
                            $mailbcc_value = (explode(",",$resultedit['bcc']));
                          }
                        ?>
                      <div class="form-group">
                        <label>To</label>
                        <?php 
                          $sql1 = "SELECT *FROM [dbo].[allemployee] WHERE ISNULL([email],'') != '' ORDER BY eid";
                          $result1 = sqlsrv_query($conn, $sql1);
                        ?>
                        <div class="select2-purple">
                          <select class="select2" multiple="multiple" data-dropdown-css-class="select2-purple" data-placeholder="Select a To" style="width: 100%;" name="mail_mailto[]" id="mail_mailto">
                            <?php while ($row1 = sqlsrv_fetch_array($result1, SQLSRV_FETCH_ASSOC)) {?>
                            <option 
                              value="<?php echo $row1["email"]; ?>"
                              <?php if (In_array($row1["email"],$mailto_value)) echo 'selected' ; ?>
                            >
                            <?php echo $row1["nameEN"]. " " . $row1["lastnameEN"]; ?>
                            </option>
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
                          <select class="select2" multiple="multiple" data-dropdown-css-class="select2-purple" data-placeholder="Select a CC" style="width: 100%;" name="mail_mailcc[]">
                            <?php while ($row2 = sqlsrv_fetch_array($result2, SQLSRV_FETCH_ASSOC)) {?>
                              <option 
                              value="<?php echo $row2["email"]; ?>"
                              <?php if (In_array($row2["email"],$mailcc_value)) echo 'selected' ; ?>
                            >
                            <?php echo $row2["nameEN"]. " " . $row2["lastnameEN"]; ?>
                            </option>
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
                          <select class="select2" multiple="multiple" data-dropdown-css-class="select2-purple" data-placeholder="Select a BCC" style="width: 100%;" name="mail_mailbcc[]">
                            <?php while ($row3 = sqlsrv_fetch_array($result3, SQLSRV_FETCH_ASSOC)) {?>
                              <option 
                              value="<?php echo $row3["email"]; ?>"
                              <?php if (In_array($row3["email"],$mailbcc_value)) echo 'selected' ; ?>
                            >
                            <?php echo $row3["nameEN"]. " " . $row3["lastnameEN"]; ?>
                            </option>
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
                        <input type="text" class="form-control form-control-border" id="mail_subject" name="mail_subject" value="<?php echo $resultedit['Subject']; ?>" autocomplete="off">
                      </div>

                        <div class="form-group">
                          <label>Content</label>
                            <i class="fa fa-info-circle" style="color:blue" aria-hidden="true" data-html="true" data-toggle="tooltip" data-placement="top" title="เงื่อนไขคำสั่ง<br>
                            (date) = วันที่ปัจจุบัน<br>
                            (-date) = วันที่ย้อนหลัง 1 วัน<br>
                            (month) = เดือนปัจจุบัน<br>
                            (-month) = ย้อนหลัง 1 เดือน<br>
                            (nl)(im=imageName.jpeg)(nl) = ขึ้นบรรทัดใหม่ตามด้วยรูปภาพจาก Tableau"></i>
                            <textarea id="summernote" name="summernotez"><?php echo $resultedit['Content']; ?></textarea>
                        </div>
                  </div>
                    <div class="col-md-6">
                        
                    </div>
                    <div class="col-md-6 text-right">
                      <button id="testbtn" type="button" class="btn btn-block btn-outline-warning" onclick="fncAction1()" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">Test Send</button>
                      <button type="button" class="btn btn-block btn-outline-primary" onclick="fncAction2()">Update</button>
                    </div>
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
                    $sqlapi = "SELECT * FROM idviewer";
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
                    <th>ID</th>
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
    $('.select2').select2()

  //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

  // Summernote
    $('#summernote').summernote()
  //bootstrap-switch
  $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

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
        'Test Send'
      );
      }, 8000)
    });
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
  });
</script>
<script type="text/javascript">
  $(function(){
    $('.example7').jqCron({
        enabled_minute: true,
        multiple_dom: true,
        multiple_month: true,
        multiple_mins: true,
        multiple_dow: true,
        multiple_time_hours: true,
        multiple_time_minutes: true,
        default_period: 'week',
        default_value: '15 10-12 * * 1-5',
        bind_to: $('.example7-input'),
        bind_method: {
            set: function($element, value) {
                $element.val(value);
            }
        },
        no_reset_button: false,
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
</body>
</html>
