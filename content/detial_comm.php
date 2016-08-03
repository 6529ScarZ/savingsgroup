<?php session_start(); 
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ระบบบริหารจัดการกลุ่มออมทรัพย์ </title>
    <LINK REL="SHORTCUT ICON" HREF="images/logo.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../plugins/select2/select2.min.css">
    <!-- Date Picker -->
    <!--<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  </head>

    <?php
    

    require '../class/Detial.php';
$myconn=new Detial();
$read='../connection/conn_DB.txt';
$myconn->para_read($read);
$db=$myconn->conn_PDO();
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_ENCODED);
$comm_id=$myconn->sslDec($id);
$sql ="SELECT comm.logo,comm.group_name,comm.reggov_code,comm.regist_date,comm.reg_gov_name,
CONCAT(p2.pname,p1.fname,' ',p1.lname) AS fullname,
concat(bu.budget,' บาท'),
concat(((bu.budget+bu.receipt)-bu.charge),' บาท') AS total,
concat('บ้านเลขที่ ',comm.hourseno,' บ้าน ',comm.village,' หมู่ ',comm.moo) as address,
concat('ต. ',d1.DISTRICT_NAME,' อ. ',a2.AMPHUR_NAME,' จ. ',p3.PROVINCE_NAME,' ',comm.post) as address2,
concat('โทร. ',comm.tel,' ',' E-mail - ',comm.email)connect,
(SELECT CONCAT(p1.fname,'  ',p1.lname) FROM person p1 WHERE p1.person_id=comm.updater) up_man,
concat('วันที่ ',DATE_FORMAT(LEFT(comm.d_update,11),'%d-%m-%Y'),' ',' เวลา ',RIGHT(comm.d_update,8))as update_date
FROM community comm
INNER JOIN budget bu ON bu.comm_id=comm.comm_id
INNER JOIN person p1 ON p1.person_id=comm.authorized_person
INNER JOIN preface p2 ON p2.pname_id=p1.pname_id
INNER JOIN district d1 ON d1.DISTRICT_ID=comm.district
INNER JOIN amphur a2 ON a2.AMPHUR_ID=comm.amphur
INNER JOIN province p3 ON p3.PROVINCE_ID=comm.province
        WHERE comm.comm_id='$comm_id'";
$myconn->imp_sql($sql);
   include_once ('../plugins/funcDateThai.php');
    ?>
    <body class="hold-transition skin-green fixed sidebar-mini">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">ข้อมูลวัสดุ</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12">
              <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='../images/icon_set2/dolly.ico' width='25'> ข้อมูลสมาชิก</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php
                        $title=  array("ชื่อกลุ่มออมทรัพย์","เลขทะเบียน","วันจดทะเบียน","หน่วยงานผู้รับจดทะเบียน","ผู้รับมอบอำนาจทำการแทน",
                            "เงินทุนตั้งต้น","เงินทุนทั้งหมดของกลุ่ม","ที่ตั้ง","","ติดต่อที่","ผู้ปรับปรุงข้อมูลล่าสุด","เวลาที่ปรับปรุง");
                        $myconn->create_Detial_photoLeft($title,"../logo/");
                        $myconn->close_PDO();
                    ?>
                            </div>
                        </div>

              
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="control-sidebar-bg"></div>
        <!-- jQuery 2.1.4 -->
     <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
        <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- page script -->
    <script>
      $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="../plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>

  </body>
</html>
