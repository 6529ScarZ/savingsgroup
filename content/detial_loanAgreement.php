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
<script language="JavaScript" type="text/javascript">
            var StayAlive = 1; // เวลาเป็นวินาทีที่ต้องการให้ WIndows เปิดออก 
            function KillMe()
            {
                setTimeout("self.close()", StayAlive * 1000);
            }
        </script>
    <?php
    if(!null==  filter_input(INPUT_GET, 'kill')){
        $body="KillMe();
            self.focus();
            window.opener.location.reload();";
    }  else {
        $body="";
}
    $loan_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    require '../class/Detial.php';
$myconn=new Detial();
$read='../connection/conn_DB.txt';
$myconn->para_read($read);
$db=$myconn->conn_PDO();
$sql ="SELECT lc.loan_number,p.member_no,CONCAT(p.fname,' ',p.lname) AS fullname,p.cid,c.contract_name,c.witdawal,
lc.loan_startdate,lc.loan_enddate,lc.note,
(SELECT CONCAT(p.fname,' ',p.lname) FROM person p WHERE p.person_id=lc.bondsman_1)bondsman_1,
(SELECT CONCAT(p.fname,' ',p.lname) FROM person p WHERE p.person_id=lc.bondsman_2)bondsman_2,
(SELECT CONCAT(p.fname,' ',p.lname) FROM person p WHERE p.person_id=lc.bondsman_3)bondsman_3
FROM loan_card lc 
INNER JOIN person p ON p.person_id=lc.person_id
INNER JOIN contract c ON c.contract_id=lc.contract_id
WHERE lc.loan_id=$loan_id";
$myconn->imp_sql($sql);
$myconn2=new Detial();
$myconn2->para_read($read);
$db=$myconn2->conn_PDO();
$sql2="select approve from loan_card WHERE loan_id=$loan_id";
$myconn2->imp_sql($sql2);
$approve=$myconn2->select('');
$myconn2->close_PDO();
   include_once ('../plugins/funcDateThai.php');
    ?>
        <body class="hold-transition skin-green fixed sidebar-mini" onload="<?= $body?>">
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
                <div class="box-body" align='center'>
                    <form class="navbar-form" role="form" action='../process/prcloanAgreement.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
                    <?php if($approve=='W'){?>
                        <div class="well well-sm">
                <b>ยืนยันการอนมัติเงินกู้</b>
                <div class="form-group">
                    <input type="radio" name="confirm" id="confirm" value="Y" required>&nbsp;&nbsp; อนุมัติ<br> 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="confirm" id="confirm" value="N" required>&nbsp;&nbsp; ไม่อนุมัติ
                </div>
                </div>
                    <?php }
                        $title=  array("สัญญาเงินกู้เลขที่","หมายเลขสมาชิก","ชื่อ-นามสกุล","เลขบัตรประชาชน","ประเภทเงินกู้",
                            "ดอกเบี้ย (ร้อยละ/ปี)","วันที่เริ่มสัญญาเงินกู้","วันที่ครบกำหนดสัญญา","การนำไปใช้ประโยชน์",
                            "สมาชิกผู้ค้ำประกันคนที่ 1","สมาชิกผู้ค้ำประกันคนที่ 2","สมาชิกผู้ค้ำประกันคนที่ 3");
                        $myconn->create_Detial($title);
                        $myconn->close_PDO();
                         if($approve=='W'){
                    ?>
                        <input type="hidden" name="check" value="plus">
                        <input type="hidden" name="method" value="comfirm_loanAgreement">
                        <input type="hidden" name="loan_id" value="<?= $loan_id?>">
                        <input type="submit" name="submit" class="btn btn-success" value="ยืนยันอนุมัติเงินกู้">
                         <?php }?>
                    </form>
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
