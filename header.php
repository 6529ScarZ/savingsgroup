<?php session_start(); 
require_once 'class/TablePDO.php';
//function __autoload($class_name) {
    //include 'class/'.$class_name.'.php';
//}
set_time_limit(0);
$conn_DB= new EnDeCode();
$read="connection/conn_DB.txt";
$conn_DB->para_read($read);
$db=$conn_DB->conn_PDO();
if($db != FALSE){
//$db=$conn_DB->getDb();
//===ชื่อกลุ่ม
                    $sql = "select * from  community order by comm_id limit 1";
                    $conn_DB->imp_sql($sql);
                    $resultComm=$conn_DB->select('');
                    
}
                    if (!empty($resultComm[0]['logo'])) {
                                    $pic = $resultComm[0]['logo'];
                                    $fol = "logo/";
                                } else {
                                    $pic = 'agency.ico';
                                    $fol = "images/";
                                }

                    ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ระบบบริหารจัดการกลุ่มออมทรัพย์ </title>
    <LINK REL="SHORTCUT ICON" HREF="<?= $fol.$pic?>">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- Date Picker -->
    <!--<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="plugins/excellentexport.js"></script>
    <link rel="stylesheet" href="bootstrap/site.css">
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
		function popup(url,name,windowWidth,windowHeight){    
				myleft=(screen.width)?(screen.width-windowWidth)/2:100;	
				mytop=(screen.height)?(screen.height-windowHeight)/2:100;	
				properties = "width="+windowWidth+",height="+windowHeight;
				properties +=",scrollbars=yes, top="+mytop+",left="+myleft;   
				window.open(url,name,properties);
	}
</script>
<script type="text/javascript">
                    function inputDigits(sensor) {
                        var regExp = /[0-9.-/]$/;
                        if (!regExp.test(sensor.value)) {
                            alert("กรอกตัวเลขเท่านั้นครับ");
                            sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                        }
                    }
                </script>
                <!--scrip check ตัวอักษร-->
                <script type="text/javascript">
                    function inputString(sensor) {
                        var regExp = /[A-Za-zก-ฮะ-็่-๋์/]$/;
                        if (!regExp.test(sensor.value)) {
                            alert("กรอกตัวอักษรเท่านั้นครับ");
                            sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                        }
                    }

                </script>
  </head>
  <?php
                     if (null !==(filter_input(INPUT_GET, 'popup'))){
                      $popup=  filter_input(INPUT_GET, 'popup');
                      $popup_name=  filter_input(INPUT_GET, 'popname');
                      $id= filter_input(INPUT_GET, 'id',FILTER_SANITIZE_ENCODED);  
                      $date=  filter_input(INPUT_GET, 'date');
                      $cod_popup="window.open('content/pop_$popup_name.php?date=$date&id=$id','','width=470,height=450'); return false;";
                     }
  
                      ?>
  <body class="hold-transition skin-blue-light fixed sidebar-collapse sidebar-mini" onload="<?= $cod_popup?>">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>S</b>aving</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>SAVINGS-</b>System v.1.0</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php if(empty($_SESSION['user'])){?>
                <li class="dropdown messages-menu">
                    
                        <a href="#" onClick="return popup('login_page.php', popup, 300, 330);" title="เข้าสู่ระบบพัสดุ">
                            <img src="images/key-y.ico" width="18"> เข้าสู่ระบบ
                  </a>
                   
                </li>
                <?php }else{                                    
                                    $user_id = $_SESSION['user'];
                                    if (!empty($user_id)) {
                                        
                                        $sql = "select p.photo,
                                            CASE p.user_type
                                            WHEN '1' THEN 'สมาชิกสามัญ'
                                            WHEN '2' THEN 'สมาชิกสมทบ'
                                            ELSE 'Unknown'
                                            END AS posname 
                                            from person p 
                                                        WHERE p.person_id='$user_id'";
                                        $conn_DB->imp_sql($sql);
                                      $result=$conn_DB->select('');
                                      //$conn_DB->close_PDO();
                                      
                                      $empno_photo=$result[0]['photo'];
                                      $posname=$result[0]['posname'];
                                      
                                        if (empty($empno_photo)) {
                                    $photo = 'person.png';
                                    $fold = "images/";
                                } else {
                                    $photo = $empno_photo;
                                    $fold = "photo/";
                                }
                                        //$db->close();
                                    }
                                    
                    ?>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?= $fold.$photo?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?= $_SESSION['fullname']?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?= $fold.$photo?>" class="img-circle" alt="User Image">
                    <p>
                      <?= $posname?>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                      <?php if($_SESSION['Status']=='ADMIN' or ($_SESSION['Status']=='SUSER')){?>
                    <div class="pull-left">
                        <a href="index.php?page=content/add_User&ss_id=<?= $_SESSION['user']?>" class="btn btn-default btn-flat">ข้อมูลส่วนตัว</a>
                      </div><?php }?>
                    <div class="pull-right">
                        <a href="index.php?page=process/logout" class="btn btn-default btn-flat">ออกจากระบบ</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
              <?php if(!empty($_SESSION['Status'])){
          if($_SESSION['Status']=='ADMIN'){?>
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
              <?php }}}?>
            </ul>
          </div>
        </nav>
      </header>
        
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $fol.$pic?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?= $resultComm[0]['group_name']?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> ระบบบริหารกลุ่มออมทรัพย์</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">เมนูหลัก</li>
            <li class=""><a href="index.php">
                    <img src="images/gohome.ico" width="20"> <span>หน้าหลัก</span></a>
            </li>
            <?php if(isset($_SESSION['user'])){ ?>
            <li class="treeview">
              <a href="#">
                  <img src="images/icon_set1/load_upload.ico" width="20">
                <span>ระบบสมาชิก</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li>
                  <a href="#"><i class="fa fa-circle-o text-orange"></i> จัดการสมาชิก <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                      <li><a href="?page=content/add_person"><i class="fa fa-circle-o text-red"></i> สมัคร/แก้ไขสมาชิก</a></li>
                <!--<li><a href="JavaScript:doCallAjax('index.php?page=content/add_person')"><i class="fa fa-circle-o text-red"></i> สมัคร/แก้ไขสมาชิก</a></li>-->
                </ul>
                </li>
                         <?php if($_SESSION['Status']=='ADMIN' or ($_SESSION['Status']=='SUSER')){?>
                <li>
                  <a href="#"><i class="fa fa-circle-o text-orange"></i> รายงาน <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="?page=content/#"><i class="fa fa-circle-o text-yellow"></i> #</a></li>
                    <li><a href="?page=content/#"><i class="fa fa-circle-o text-yellow"></i> #</a></li>
                  </ul>
                </li>
                <?php }?>
              </ul>
            </li>
             <?php if($_SESSION['Status']=='ADMIN' or ($_SESSION['Status']=='SUSER')){?>
                        <li class="treeview">
              <a href="#">
                  <img src="images/icon_set1/load_download.ico" width="20">
                <span>ระบบรับเงิน</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                    <!--<li><a href="?page=content/add_saving"><i class="fa fa-circle-o text-yellow"></i> การออม</a></li>
                    <li><a href="?page=content/add_repay"><i class="fa fa-circle-o text-yellow"></i> จ่ายคืนเงินกู้</a></li>-->
                    <li><a href="?page=content/add_receipts"><i class="fa fa-circle-o text-yellow"></i> การรับเงิน</a></li>
                <!--<li>
                  <a href="#"><i class="fa fa-circle-o text-blue"></i> รายงาน <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="index.php?page=personal/statistics_person"><i class="fa fa-circle-o text-aqua"></i> สถิติบุคลากร</a></li>
                    <li><a href="#" onClick="window.open('personal/detial_type.php','','width=400,height=350'); return false;" title="สถิติประเภทพนักงาน"><i class="fa fa-circle-o text-aqua"></i> สถิติประเภทพนักงาน</a></li>
                    <li><a href="#" onClick="window.open('personal/detial_position.php','','width=600,height=680'); return false;" title="สถิติตำแหน่งพนักงาน"><i class="fa fa-circle-o text-aqua"></i> สถิติตำแหน่งพนักงาน</a></li>
                    </ul>
            </li>-->
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                  <img src="images/icon_set1/disc.ico" width="20">
                <span>ระบบจ่ายเงิน</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li><a href="?page=content/add_loanAgreement"><i class="fa fa-circle-o text-maroon"></i> ทำสัญญากู้</a></li>
                <li><a href="?page=content/pay_loan"><i class="fa fa-circle-o text-maroon"></i> จ่ายเงินกู้</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o text-fuchsia"></i> รายงาน <i class="fa fa-angle-left pull-right"></i></a>
                  <ul class="treeview-menu">
                    <li><a href="?page=content/report_loanAgreement&method=approve"><i class="fa fa-circle-o text-fuchsia"></i> ผู้ทีได้รับอนุมัติกู้</a></li>
                    <li><a href="?page=content/report_loanAgreement&method=fail"><i class="fa fa-circle-o text-fuchsia"></i> ผู้ทีไม่ผ่านอนุมัติกู้</a></li>
                  <li><a href="?page=content/report_loanAgreement&method=pay"><i class="fa fa-circle-o text-fuchsia"></i> ผู้ทีได้รับเงินกู้แล้ว</a></li>  
                  </ul>
                </li>
              </ul>
            </li>
            <?php }}?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <?php/*
                    function insert_date(&$take_date_conv,&$take_date)
                    {
                        $take_date=explode("/",$take_date_conv);
			 $take_date_year=$take_date[2]-543;
			 $take_date="$take_date_year-$take_date[1]-$take_date[0]";
                    }*/
?>