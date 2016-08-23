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
$person_id=$myconn->sslDec($id);
    $sql = "SELECT p1.photo, p1.member_no,CONCAT(p2.pname,p1.fname,'  ',p1.lname) AS fullname,
IF (p1.user_type=1,'สมาชิกทั่วไป','สมาชิกสมทบ')as user_type_name ,m2.mem_status,CONCAT(sa.saving_total,' ','บาท')AS saving,
lc.loan_number,con.contract_name,CONCAT(con.witdawal,' ','ปี') AS witdawal,concat(lc.loan_total,' ',' บาท') as total,
CONCAT(la.period,' ','บาท')AS period,CONCAT(la.month,' ','เดือน')AS month,CONCAT(la.loan_total,' ','บาท')AS loan_total
FROM person p1
INNER JOIN preface p2 ON p2.pname_id=p1.pname_id
INNER JOIN member_status m2 ON m2.mem_status_id=p1.mem_status_id
INNER JOIN saving_account sa ON sa.person_id=p1.person_id
LEFT OUTER JOIN loan_card lc ON lc.person_id=p1.person_id
LEFT OUTER JOIN loan_account la ON la.loan_id=lc.loan_id
LEFT OUTER JOIN contract con ON con.contract_id=lc.contract_id
WHERE p1.person_id='$person_id'";
    $myconn->imp_sql($sql);
    $myconn->select('');
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
                        $title=  array("เลขที่สมาชิก","ชื่อ - นามสกุล","ประเภทสมาชิก","สถานะ","เงินออมทั้งหมด","เลขที่เงินกู้","ประเภทเงินกู้","ดอกเบี้ยร้อยละ","ยอดเงินกู้ทั้งหมด",
                            "ส่งงวดละ","ระยะเวลาที่ส่ง","ยอดเงินกู้ที่เหลือ");
                        $myconn->create_Detial_photoLeft($title,"../photo/");
                        $myconn->close_PDO();
                        ?>
                     <br>
                    <?php
                        $myconn->conn_PDO();
                        $sql="SELECT sr.receive_date FROM saving_repayment sr 
                            
                                WHERE sr.person_id=$person_id GROUP BY sr.receive_date ORDER BY sr.saving_repay_id ASC";
                        $myconn->imp_sql($sql);
                        $date=$myconn->select("");
                        $title=  array("วันที่จ่าย","จำนวนเงินออม","จำนวนเงินต้น","ดอกเบี้ย","ค่าปรับ","ผู้บันทึก","ใบเสร็จ");
                        $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
                echo "<div align='center' class='table-responsive'>";
                echo "<table class='table table-hover'>";
                echo "<thead><tr align='center'>";
                echo "<th align='center' width='5%'>ลำดับ</th>";
                foreach ($title as $key => $value) {
                    echo "<th align='center'>$value</th>";
                }
                echo "</tr></thead><tbody>";
                $ii=0;
                $C = 1;
                        for($c=0;$c<count($date);$c++){
                        $loan_date[$c]=$date[$c]['receive_date'];
                        $sql="SELECT receive_date,
(SELECT sr.receive_money FROM saving_repayment sr WHERE sr.saving_code=1 AND sr.person_id=$person_id AND (sr.receive_date BETWEEN '$loan_date[$c]' AND '$loan_date[$c]'))saving,
(SELECT sr.receive_money FROM saving_repayment sr WHERE sr.saving_code=2 AND sr.person_id=$person_id AND (sr.receive_date BETWEEN '$loan_date[$c]' AND '$loan_date[$c]'))loan_budget,
(SELECT sr.receive_money FROM saving_repayment sr WHERE sr.saving_code=3 AND sr.person_id=$person_id AND (sr.receive_date BETWEEN '$loan_date[$c]' AND '$loan_date[$c]'))witdawal,
(SELECT sr.receive_money FROM saving_repayment sr WHERE sr.saving_code=4 AND sr.person_id=$person_id AND (sr.receive_date BETWEEN '$loan_date[$c]' AND '$loan_date[$c]'))fine,
CONCAT(p.fname,' ',p.lname) as updater ,loan_id as id
FROM saving_repayment sr
INNER JOIN person p ON p.person_id=sr.updater
WHERE sr.person_id=$person_id AND (sr.receive_date BETWEEN '$loan_date[$c]' AND '$loan_date[$c]') 
GROUP BY receive_date
ORDER BY sr.saving_repay_id ASC";
                        
                        $myconn->imp_sql($sql);
                        $loan_data=$myconn->select("");
                        $field = array_keys($loan_data[0]);
                 
                    if($ii>=5){
                        $ii=0;
                    }
                    echo "<tr class='" . $code_color[$ii] . "'>";
                    echo "<td align='center'>" . $C . "</td>";
                    for ($i = 0; $i < count($field); $i++) {
                        if ($i < (count($field)-1)) {
                            if ($myconn->validateDate($loan_data[0][$field[$i]], 'Y-m-d')) {
                                echo "<td align='center'>" . DateThai1($loan_data[0][$field[$i]]) . "</td>";
                            } else {
                                echo "<td align='center'>" . $loan_data[0][$field[$i]] . "</td>";
                            }
                        } else{
                            if ($i = (count($field))-1) {?>
                                        <td align='center'>
                                    <a href="#" onClick="window.open('content/repay_PDF.php?id=<?= $loan_data[0][$field[$i]] ?>', '', 'width=550,height=700');
                                            return false;" title="รายละเอียด">     
                                        <img src='../images/printer.ico' width='25'></a></td>
                                 <?php  }
                                }
                    }
                            
                            $C++;
                            $ii++;
                            echo "</tr>";
                        }
                        echo "</tbody></table></div>";
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
