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
  </head><!-- //////////////////head//////////////// -->
    <?php
    require '../class/EnDeCode.php';
$myconn=new EnDeCode();
$read='../connection/conn_DB.txt';
$myconn->para_read($read);
$db=$myconn->conn_PDO();
if($db != FALSE){
//$db=$conn_DB->getDb();
//===ชื่อกลุ่ม
                    $sql = "select * from  community order by comm_id limit 1";
                    $myconn->imp_sql($sql);
                    $resultComm=$myconn->select('');
}
                    if (!empty($resultComm[0]['logo'])) {
                                    $pic = $resultComm[0]['logo'];
                                    $fol = "logo/";
                                } else {
                                    $pic = 'agency.ico';
                                    $fol = "images/";
                                }

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_ENCODED);
$loan_id=$myconn->sslDec($id);
$sql2="SELECT lc.loan_number,loan_startdate,CONCAT(pr.pname,p.fname,' ',p.lname)AS fullname,
(TIMESTAMPDIFF(year,p.birth,NOW()))AS age,p.cid,p.member_no,sa.saving_total,
CONCAT(ad.hourseno,'  ม.',ad.moo,' ต.',dis.DISTRICT_NAME,' อ.',amp.AMPHUR_NAME,' จ.',pro.PROVINCE_NAME)AS address,
lc.loan_total,co.contract_name,co.witdawal,
(SELECT CONCAT(p.fname,' ',p.lname) FROM person p WHERE p.person_id=lc.bondsman_1)AS bonds1,
(SELECT p.member_no FROM person p WHERE p.person_id=lc.bondsman_1)AS mem_no1,
(SELECT sa.saving_total FROM saving_account sa WHERE sa.person_id=lc.bondsman_1)AS saving1,
(SELECT CONCAT(p.fname,' ',p.lname) FROM person p WHERE p.person_id=lc.bondsman_2)AS bonds2,
(SELECT p.member_no FROM person p WHERE p.person_id=lc.bondsman_2)AS mem_no2,
(SELECT sa.saving_total FROM saving_account sa WHERE sa.person_id=lc.bondsman_2)AS saving2,
(SELECT CONCAT(p.fname,' ',p.lname) FROM person p WHERE p.person_id=lc.bondsman_3)AS bonds3,
(SELECT p.member_no FROM person p WHERE p.person_id=lc.bondsman_3)AS mem_no3,
(SELECT sa.saving_total FROM saving_account sa WHERE sa.person_id=lc.bondsman_3)AS saving3
FROM loan_card lc
#INNER JOIN loan_account la ON la.loan_id=lc.loan_id
INNER JOIN contract co ON co.contract_id=lc.contract_id
INNER JOIN person p ON p.person_id=lc.person_id
INNER JOIN preface pr ON pr.pname_id=p.pname_id
INNER JOIN address ad ON ad.person_id=p.person_id
INNER JOIN district dis ON dis.DISTRICT_ID=ad.district
INNER JOIN amphur amp ON amp.AMPHUR_ID=ad.amphur
INNER JOIN province pro ON pro.PROVINCE_ID=ad.province
INNER JOIN saving_account sa ON sa.person_id=p.person_id
WHERE lc.loan_id=:loan_id LIMIT 1";
$myconn->imp_sql($sql2);
$execute = array(':loan_id' => $loan_id);
$loan_data=$myconn->select($execute);

include_once ('../plugins/funcDateThai.php');
include '../plugins/function_date.php';
include '../plugins/Convert_num_text.php';

require_once('../plugins/library/mpdf60/mpdf.php'); //ที่อยู่ของไฟล์ mpdf.php ในเครื่องเรานะครับ
ob_start(); // ทำการเก็บค่า html นะครับ*/
$loan_id;
?>
<table width="100%" border="0">
  <tr>
      <td width="12%" rowspan="2" align="center" valign="top">&nbsp;<img src="../<?= $fol.$pic?>" width="100"></td>
      <td colspan="3" valign="bottom"><h4>&nbsp;สัญญาเงินกู้ยืมเงิน วิสาหกิจชุมชน <?= $resultComm[0]['group_name']?></h4></td>
  </tr>
  <tr>
    <td width="29%" height="43">&nbsp;</td>
    <td colspan="2">&nbsp;สัญญาเลขที่ &nbsp;<?= $loan_data[0]['loan_number']?>&nbsp; ลงวันที่ &nbsp;<?= DateThai2($loan_data[0]['loan_startdate'])?>&nbsp; </td>
  </tr>
  <tr>
    <td colspan="4"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                ข้าพเจ้าฯ &nbsp;<?= $loan_data[0]['fullname']?>&nbsp; อายุ &nbsp;<?= $loan_data[0]['age']?>&nbsp; ปี เลขบัตร ปชช &nbsp;<?= $loan_data[0]['cid']?>&nbsp; 
                <br>เลขสมาชิก &nbsp;<?= $loan_data[0]['member_no']?>&nbsp; 
มีหุ้น &nbsp;<?= number_format($loan_data[0]['saving_total'])?>&nbsp; บาท ภูมิลำเนาเลขที่ &nbsp;<?= $loan_data[0]['address']?>&nbsp; ได้กู้ยืมเงินจากวิสาหกิจชุมชน 
<?= $resultComm[0]['group_name']?> &nbsp;<?= number_format($loan_data[0]['loan_total'])?>&nbsp; บาท( &nbsp;<?= num2wordsThai(number_format($loan_data[0]['loan_total']))?>บาทถ้วน&nbsp; )
ประเภทเงินกู้ &nbsp;<?= $loan_data[0]['contract_name']?>&nbsp; กำหนดผ่อนชำระเงินกู้เป็นรายเดือน ภายใน ๖๐ งวด งวดละ………....บาท พร้อมดอกเบี้ยอัตราร้อยละ &nbsp;<?= number_format($loan_data[0]['witdawal'])?>&nbsp; บาทต่อเดือน หากไม่สามารถชำระตามกำหนด จะเสียค่าปรับเป็นเงิน ๕ บาทต่อเดือน 
โดยบุคคลผู้คำประกันและผู้คำประกันทั้งหมดยินยอมชดใช้หนี้ตามจำนวนที่ค้างชำระพร้อมดอกเบี้ย แก่วิสาหกิจชุมชน <?= $resultComm[0]['group_name']?> แทนข้าพเจ้า คือ
<br>
    </p>
</td>
  </tr>
  <tr>
    <td colspan="3">
      <p>๑.&nbsp;<?= $loan_data[0]['bonds1']?>&nbsp;เลขสมาชิก&nbsp;<?= $loan_data[0]['mem_no1']?>&nbsp; มีหุ้น &nbsp;<?= number_format($loan_data[0]['saving1'])?>&nbsp; บาท</p>
      <p>๒.&nbsp;<?= $loan_data[0]['bonds2']?>&nbsp;เลขสมาชิก&nbsp;<?= $loan_data[0]['mem_no2']?>&nbsp; มีหุ้น &nbsp;<?= number_format($loan_data[0]['saving2'])?>&nbsp; บาท</p>
      <p>๓.&nbsp;<?= $loan_data[0]['bonds3']?>&nbsp;เลขสมาชิก&nbsp;<?= $loan_data[0]['mem_no3']?>&nbsp; มีหุ้น &nbsp;<?= number_format($loan_data[0]['saving3'])?>&nbsp; บาท</p>
        &nbsp; และข้าพเจ้าได้รับเงินกู้ตามจำนวนดังกล่าวครบถ้วนแล้ว </td>
    <td width="35%">
        <p>ลงชื่อ…………………………………..ผู้ค้ำประกัน ๑ </p>
        <p>ลงชื่อ…………………………………..ผู้ค้ำประกัน ๒</p>
        <p>ลงชื่อ…………………………………..ผู้ค้ำประกัน ๓ </p>
        <p>&nbsp;</p></td>
  </tr>
<tr>
    <td colspan="4" align="center">&nbsp;
<br>                            ลงชื่อ………………………………..….สมาชิกผู้กู้เงิน                                                                        
<br>                                ( &nbsp;<?= $loan_data[0]['fullname']?>&nbsp; )
<br>วันที่ &nbsp;<?= DateThai2($loan_data[0]['loan_startdate'])?>&nbsp; 
<br><br>ลงชื่อ………………………………..….กรรมการผู้จ่ายเงิน   
<br><br>     (……………………………...…..…)
<br><br>วันที่……………………       
<hr>
</td>
  </tr>
<tr>
    <td colspan="4" align="center">&nbsp;
    ส่วนของคณะกรรมการ

<br><br>ความเห็นของคณะกรรมการพิจารณาเงินกู้     [ &nbsp; ] อนุมัติ   [ &nbsp; ] ไม่อนุมัติ เพราะ …………………………………..……………………

<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
ลงชื่อ………………………………..ประธานกรรมการพิจารณาเงินกู้   
<br><br>	                                    (……………………………...…..…) 		
<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
ลงชื่อ………………………………..กรรมการพิจารณาเงินกู้
<br><br>                                               (……………………………...…..…) 
<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
ลงชื่อ………………………………..กรรมการพิจารณาเงินกู้/พยาน
<br><br>                      		   (……………………………...…..…)               
<p>ความเห็นของประธานวิสาหกิจชุมชนฯ</p>                                    
<br>[ &nbsp; ] อนุมัติ     [ &nbsp; ] ไม่อนุมัติ เพราะ ………………………………………………………………….
<br><br>                                         ลงชื่อ………………………………..
<br><br>                                              (……………………………...…..…)
<br><br>                                              วันที่…………………………..


<br><br>หมายเหตุ เอกสารให้จัดทำขึ้น ๒ ฉบับ มอบให้ผู้กู้ ๑ ฉบับและเก็บไว้ที่ วิสาหกิจชุมชนฯ ๑ ฉบับ 

</td>
  </tr>



</table>

    <?php 
$time_re=  date('Y_m_d');
$html = ob_get_contents();
ob_clean();

$pdf = new mPDF('tha2','A4','11','');
$pdf->autoScriptToLang = true;
$pdf->autoLangToFont = true;
$pdf->SetDisplayMode('fullpage');

$pdf->WriteHTML($html, 2);
$pdf->Output("../ContractPDF/Contract$loan_id $time_re.pdf");
echo "<meta http-equiv='refresh' content='0;url=../ContractPDF/Contract$loan_id $time_re.pdf' />";
$myconn->close_PDO();?>

        <!-- //////////////////foot//////////////// -->                    
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
