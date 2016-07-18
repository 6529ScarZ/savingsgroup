<section class="content-header">
               <?php 
               if(NULL !==(filter_input(INPUT_GET,'method'))){
                   $method=filter_input(INPUT_GET,'method');
               if($method=='edit'){?>
            <h1><font color='blue'>  การออม </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="index.php?page=content/add_saving"><i class="fa fa-edit"></i> การออม</a></li>
              <li class="active"><i class="fa fa-edit"></i> การลงบันทึกออม</li>
               <?php }}else{?>
            <h1><img src='images/adduser.ico' width='75'><font color='blue'>  การออม </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> การออม</li>
              <?php }?>
            </ol>
</section>
<?php
    if(isset($method)=='edit'){
        $edit_id=filter_input(INPUT_GET,'id');
        $sql= "select p.*,concat(p2.pname,p.fname,'  ',p.lname) as fullname,
            IF (p.sex=1,'ชาย',IF (p.sex=2,'หญิง','UNKNOW')) as sex_name,
            IF (p.user_type=1,'สมาชิกทั่วไป','สมาชิกสมทบ')as user_type_name,m.mem_status
from person p left outer join address a on p.person_id=a.person_id
            inner join preface p2 on p2.pname_id=p.pname_id
            INNER JOIN member_status m ON m.mem_status_id=p.mem_status_id
                where p.person_id='$edit_id'";
                                $conn_DB2= new DbPDO_mng();
                                $read="connection/conn_DB.txt";
                                $conn_DB2->para_read($read);
                                $conn_DB2->conn_PDO();
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
                  <h3 class="box-title"><img src='images/phonebook.ico' width='25'> ออมเงิน</h3>
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
<form class="navbar-form" role="form" action='index.php?page=process/prcsaving' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
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
                    </div><br>
                    <div class="form-group">
         			<label>ชื่อ - นามสกุล &nbsp;</label>
 				<?php if(isset($method)=='edit'){ echo $edit_person[0]['fullname'];}?>
             	</div>
                <div class="form-group">
         			<label>&nbsp; เพศ &nbsp;</label>
 				<?php if(isset($method)=='edit'){ echo $edit_person[0]['sex_name'];}?>
                </div><br>
                    <div class="form-group"> 
                <label>ประเภทสมาชิก &nbsp;</label>
                <?php if(isset($method)=='edit'){ echo $edit_person[0]['user_type_name'];}?>
                </div>
                <div class="form-group">
         			<label> สถานะการเป็นสมาชิก &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_person[0]['mem_status'];}?>
                </div><br><br>
                <div class="form-group">
         			<label> จำนวนเงินที่ต้องการออม &nbsp;</label>
                                <input type="text" name="money" id="money" placeholder="จำนวนเงิน" required="">
                </div>&nbsp;
                <?php if(isset($method)=='edit'){?>
    <input type="hidden" name="method" id="method" value="saving">
    <input type="hidden" name="saving_id" id="saving_id" value="<?=$edit_person[0]['person_id'];?>">
   <input class="btn-primary" type="submit" name="Submit" id="Submit" value="บันทึกการออม">
   <?php }
   $conn_DB2->close_PDO(); ?>
   </form>
                </div>
                </div>
          </div>
</div>
 <?php }?> 
    <?php include 'content/list_saving.php';?>
    </section>
         