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
    
require '../class/EnDeCode.php';
$myconn=new EnDeCode();
$read='../connection/conn_DB.txt';
$myconn->para_read($read);
$db=$myconn->conn_PDO();
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_ENCODED);
$person_id=$myconn->sslDec($id);
    $sql = "SELECT p1.*,a1.*,p2.pname,m1.mstatus,m2.mem_status,CONCAT(p2.pname,p1.fname,'  ',p1.lname) AS fullname,
IF (p1.sex=1,'ชาย','หญิง')AS sex_name,IF (p1.user_type=1,'สมาชิกทั่วไป','สมาชิกสมทบ')as user_type_name ,
CONCAT(TIMESTAMPDIFF(year,p1.birth,NOW()),' ปี ',
timestampdiff(month,p1.birth,NOW())-(timestampdiff(year,p1.birth,NOW())*12),' เดือน ',
FLOOR(TIMESTAMPDIFF(DAY,p1.birth,NOW())%30.4375),' วัน')AS age,
(SELECT CONCAT(p1.fname,'  ',p1.lname) FROM person p1 WHERE p1.person_id=a1.updater) up_man,
d1.DISTRICT_NAME,a2.AMPHUR_NAME,p3.PROVINCE_NAME
FROM person p1
INNER JOIN address a1 ON a1.person_id=p1.person_id
INNER JOIN preface p2 ON p2.pname_id=p1.pname_id
INNER JOIN mstatus m1 ON m1.mstatus_id=p1.mstatus_id
INNER JOIN member_status m2 ON m2.mem_status_id=p1.mem_status_id
INNER JOIN district d1 ON d1.DISTRICT_ID=a1.district
INNER JOIN amphur a2 ON a2.AMPHUR_ID=a1.amphur
INNER JOIN province p3 ON p3.PROVINCE_ID=a1.province
WHERE p1.person_id='$person_id'";
    $myconn->imp_sql($sql);
    $detial_person=$myconn->select('');
    /*require '../class/Detial.php';
$myconn=new Detial();
$read='../connection/conn_DB.txt';
$myconn->para_read($read);
$db=$myconn->conn_PDO();
$sql ="SELECT   p1.photo, p1.member_no, CONCAT(p2.pname,p1.fname,'  ',p1.lname) AS fullname, p1.cid,
    IF (p1.sex=1,'ชาย','หญิง')AS sex_name,IF (p1.user_type=1,'สมาชิกทั่วไป','สมาชิกสมทบ')as user_type_name,p1.birth,
    CONCAT(TIMESTAMPDIFF(year,p1.birth,NOW()),' ปี ',
timestampdiff(month,p1.birth,NOW())-(timestampdiff(year,p1.birth,NOW())*12),' เดือน ',
FLOOR(TIMESTAMPDIFF(DAY,p1.birth,NOW())%30.4375),' วัน')AS age
        FROM person p1
        INNER JOIN preface p2 ON p2.pname_id=p1.pname_id
        WHERE p1.person_id='$person_id'";
$myconn->imp_sql($sql);
*/
   include_once ('../plugins/funcDateThai.php');
    ?>
    <!--<div class="row">
              <div class="col-lg-12">
                <h1><font color='blue'>  รายละเอียดข้อมูลบุคลากร </font></h1> 
                <ol class="breadcrumb alert-success">
                  <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
                  <li class="active"><a href="pre_person.php"><i class="fa fa-edit"></i> ข้อมูลพื้นฐาน</a></li>
                  <li class="active"><i class="fa fa-edit"></i> รายละเอียดข้อมูลบุคลากร</li>
                </ol>
              </div>
          </div>-->
    <body class="hold-transition skin-green fixed sidebar-mini">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">ข้อมูลสมาชิก</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12">
              <div class="box box-success box-solid">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='../images/icon_set1/user_manage.ico' width='25'> ข้อมูลสมาชิก</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php
                        $photo_person="../photo/".$detial_person[0]['photo']; 
                        /*$title=  array("หมายเลขสมาชิก","ชื่อ-สกุล","เลขบัตรประชาชน","เพศ","ประเภทสมาชิก","วันเกิด","อายุ");
                        $myconn->create_Detial_photo($title,"../photo/");
                        $myconn->close_PDO();*/
                    ?>
                    <table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="4">หมายเลขสมาชิก :&nbsp;<b><?= $detial_person[0]['member_no']?></b>
                                        &nbsp;&nbsp;&nbsp; ประเภทสมาชิก :&nbsp;<b><?= $detial_person[0]['user_type_name']?></b></td>
                                        <td rowspan="6" align="right" valign="top"><img src="<?= $photo_person?>" height="150"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">สถานะการเป็นสมาชิก :&nbsp;<b><?= $detial_person[0]['mem_status']?></b>
                                        &nbsp;&nbsp;&nbsp; วันที่สมัคร :&nbsp;<b><?= DateThai1($detial_person[0]['regist_date'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">ชื่อ-นามสกุล :&nbsp;<b><?= $detial_person[0]['fullname']?></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">เลขที่บัตรประชาชน :&nbsp;<b><?= $detial_person[0]['cid']?></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">วันเกิด :&nbsp;<b><?= DateThai1($detial_person[0]['birth'])?></b>
                                            &nbsp;&nbsp;&nbsp; อายุ :&nbsp;<b><?= $detial_person[0]['age']?></b>
                                            &nbsp;&nbsp;&nbsp; เพศ :&nbsp;<b><?= $detial_person[0]['sex_name']?></b>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">สถานะสมรส :&nbsp;<b><?= $detial_person[0]['mstatus']?></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">ที่อยู่ :&nbsp;&nbsp;&nbsp;บ้านเลขที่&nbsp;<b><?= $detial_person[0]['hourseno']?></b>
                                        &nbsp;&nbsp;&nbsp; ชื่อบ้าน&nbsp;<b><?= $detial_person[0]['village']?></b>
                                        &nbsp;&nbsp;&nbsp; หมู่ที่&nbsp;<b><?= $detial_person[0]['moo']?></b>
                                    </tr>
                                    <tr>
                                        <td colspan="5">ตำบล&nbsp;<b><?= $detial_person[0]['DISTRICT_NAME']?></b>
                                        &nbsp;&nbsp;&nbsp; อำเภอ&nbsp;<b><?= $detial_person[0]['AMPHUR_NAME']?></b>
                                        &nbsp;&nbsp;&nbsp; จังหวัด&nbsp;<b><?= $detial_person[0]['PROVINCE_NAME']?></b>
                                        &nbsp;&nbsp;&nbsp; รหัสไปรษณีย์&nbsp;<b><?= $detial_person[0]['post']?></b></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">หมายเลขโทรศัพท์ :&nbsp;<b><?= $detial_person[0]['tel']?></b>
                                        &nbsp;&nbsp;&nbsp; E-mail :&nbsp;<b><?= $detial_person[0]['email']?></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">ผู้บันทึก/แก้ไขล่าสุด :&nbsp;<b><?= $detial_person[0]['up_man']?></b>
                                            &nbsp;&nbsp;&nbsp; วันที่ :&nbsp;<b><?= DateThai1(substr($detial_person[0]['d_update'], 0,10))?></b>
                                            &nbsp;&nbsp;&nbsp; เวลา :&nbsp;<b><?= substr($detial_person[0]['d_update'], 11)?></b> น.
                                        </td>
                                    </tr>
                                </table>
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
