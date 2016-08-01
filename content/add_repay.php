<section class="content-header">
               <?php 
               if(NULL !==(filter_input(INPUT_GET,'method'))){
                   $method=filter_input(INPUT_GET,'method');
               if($method=='edit'){?>
            <h1><font color='blue'>  การจ่ายคืนเงินกู้ </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="?page=content/add_repay"><i class="fa fa-edit"></i> การจ่ายคืนเงินกู้</a></li>
              <li class="active"><i class="fa fa-edit"></i> การลงบันทึกจ่ายคืนเงินกู้</li>
               <?php }}else{?>
            <h1><img src='images/adduser.ico' width='75'><font color='blue'>  การจ่ายคืนเงินกู้ </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> การจ่ายคืนเงินกู้</li>
              <?php }?>
            </ol>
</section>
<?php
    if(isset($method)=='edit'){
                                $conn_DB2= new EnDeCode();
                                $read="connection/conn_DB.txt";
                                $conn_DB2->para_read($read);
                                $conn_DB2->conn_PDO();
        $edit=filter_input(INPUT_GET,'id',FILTER_SANITIZE_ENCODED);
        $edit_id=$conn_DB2->sslDec($edit);
        $sql= "select p.*,concat(p2.pname,p.fname,'  ',p.lname) as fullname,
            IF (p.sex=1,'ชาย',IF (p.sex=2,'หญิง','UNKNOW')) as sex_name,
            IF (p.user_type=1,'สมาชิกทั่วไป','สมาชิกสมทบ')as user_type_name,m.mem_status,
						lc.loan_number,con.contract_name,con.witdawal,lc.loan_total,la.loan_total as loan_acc,
						la.`month`,la.period,ROUND(((con.witdawal/12)*la.loan_total)/100,2) AS witd
from person p left outer join address a on p.person_id=a.person_id
            inner join preface p2 on p2.pname_id=p.pname_id
            INNER JOIN member_status m ON m.mem_status_id=p.mem_status_id
						INNER JOIN loan_card lc ON lc.person_id=p.person_id
						INNER JOIN loan_account la ON la.loan_id=lc.loan_id
						INNER JOIN contract con ON con.contract_id=lc.contract_id
WHERE la.loan_id='$edit_id' and la.check_pay='Y' AND la.`status`=1";
                                
                                //$db=$conn_DB1->getDb();
                                $conn_DB2->imp_sql($sql);
                                $edit_person=$conn_DB2->select('');
                                $conn_DB2->close_PDO();
                                
                                $photo_person="photo/".$edit_person[0]['photo'];
    }
?>
<section class="content">
 <?php if(!empty($method)){?>    
<div class="row">
          <div class="col-lg-12">
              <?php if(empty($method)){$coll_bos='collapsed-box';}?>
              <div class="box box-success box-solid <?= $coll_bos?>">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='images/phonebook.ico' width='25'> ส่งคืนเงินกู้</h3>
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
<form class="navbar-form" role="form" action='index.php?page=process/prcrepay' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
    <div class="col-lg-1">
        <img src="<?= $photo_person?>" height="70">
    </div>               
    <div class="form-group"> 
                <label> รหัสสมาชิก &nbsp;</label>
                <?php if(isset($method)=='edit'){ echo $edit_person[0]['member_no'];}?>
             	</div>
                    <div class="form-group"> 
                    <label>&nbsp; หมายเลขบัตรประชาชน &nbsp;</label>
                    <?php if(isset($method)=='edit'){ echo $edit_person[0]['cid'];}?>
                    </div>
                    <div class="form-group">
         			<label>&nbsp; ชื่อ - นามสกุล &nbsp;</label>
 				<?php if(isset($method)=='edit'){ echo $edit_person[0]['fullname'];}?>
                    </div><br>
                <div class="form-group">
         			<label> เลขที่เงินกู้ &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_person[0]['loan_number'];}?> &nbsp; 
                </div>
                <div class="form-group">
         			<label> กู้ประเภท &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_person[0]['contract_name'];}?> &nbsp;
                </div>
                <div class="form-group">
         			<label> ดอกเบี่ยร้อยละ &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_person[0]['witdawal'];}?> &nbsp;บาท/ปี &nbsp;
                </div>
                    <div class="form-group">
         			<label> จำนวนเงินที่กู้ไป &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_person[0]['loan_total'];}?> &nbsp;บาท &nbsp;
                </div>
                <div class="form-group">
         			<label> จำนวนงวดที่ต้องจ่าย &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_person[0]['month'];}?> &nbsp;เดือน &nbsp;
                </div>
                <div class="form-group">
         			<label> งวดละ &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_person[0]['period'];}?> &nbsp;บาท &nbsp;
                </div>
                <div class="form-group">
         			<label> เงินกู้คงเหลือ &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_person[0]['loan_acc'];}?> &nbsp;บาท &nbsp;
                </div><br><br>
                <div class="form-group">
         			<label> จำนวนเงินที่ส่งคืน &nbsp;</label>
                                <input type="text" name="money" id="money" placeholder="จำนวนเงิน" required="" value="<?php if(isset($method)=='edit'){ echo $edit_person[0]['period'];}?>">
                </div>&nbsp;
                <div class="form-group">
         			<label> ดอกเบี่ย &nbsp;</label>
                                <input type="text" name="witdawal" id="witdawal" placeholder="จำนวนเงิน" required="" value="<?php if(isset($method)=='edit'){ echo $edit_person[0]['witd'];}?>">
                </div>&nbsp;
                <a class="" role="button" data-toggle="collapse" href="#collapse" aria-expanded="false" aria-controls="collapseExample">
  ค่าปรับ
</a>
</button>
<div class="collapse" id="collapse">
  <div class="well">
    <div class="form-group">
         			<label> ค่าปรับ &nbsp;</label>
                                <input type="text" name="fine" id="fine" placeholder="จำนวนเงินค่าปรับ">
                </div>
  </div>
</div>&nbsp;
                <?php if(isset($method)=='edit'){?>
    <input type="hidden" name="method" id="method" value="repay">
    <input type="hidden" name="person_id" id="person_id" value="<?=$edit_person[0]['person_id'];?>">
    <input type="hidden" name="repay_id" id="repay_id" value="<?= $edit_id?>">
   <input class="btn-success" type="submit" name="Submit" id="Submit" value="บันทึกการส่งคืน">
   <?php }
   $conn_DB2->close_PDO(); ?>
   </form>
                </div>
                </div>
          </div>
</div>
 <?php }?> 
    <?php include 'content/list_repay.php';?>
    </section>
         