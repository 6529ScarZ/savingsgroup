<section class="content-header">
               <?php 
               if(NULL !==(filter_input(INPUT_GET,'method'))){
                   $method=filter_input(INPUT_GET,'method');
               if($method=='approve'){?>
            <h1><font color='blue'>  สัญญาเงินกู้ที่ผ่านการอนุมัติ </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> สัญญาเงินกู้ที่ผ่านการอนุมัติ</li>
               <?php }elseif($method=='fail'){?>
            <h1><img src='images/adduser.ico' width='75'><font color='blue'>  สัญญาเงินกู้ที่ไม่ผ่านการอนุมัติ </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> สัญญาเงินกู้ที่ไม่ผ่านการอนุมัติ</li>
              <?php }elseif($method=='pay'){?>
            <h1><img src='images/adduser.ico' width='75'><font color='blue'>  สัญญาเงินกู้ที่จ่ายแล้ว </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> สัญญาเงินกู้ที่จ่ายแล้ว</li>
               <?php }}?>
            </ol>
</section>
<?php
                                $conn_DB2= new DbPDO_mng();
                                $read="connection/conn_DB.txt";
                                $conn_DB2->para_read($read);
?>
<section class="content">
<br>
    <?php include 'content/list_loanAgreement.php';?>
    </section>
         