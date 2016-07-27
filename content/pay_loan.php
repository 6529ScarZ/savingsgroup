<section class="content-header">
            <h1><font color='blue'>  จ่ายเงินกู้ที่ผ่านการอนุมัติ </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> จ่ายเงินกู้ที่ผ่านการอนุมัติ</li>
            </ol>
</section>
<?php
                                $conn_DB2= new DbPDO_mng();
                                $read="connection/conn_DB.txt";
                                $conn_DB2->para_read($read);
?>
<section class="content">
<br>
    <?php include 'content/list_loan.php';?>
    </section>
         