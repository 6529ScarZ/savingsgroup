<section class="content-header">
               <?php 
               if(NULL !==(filter_input(INPUT_GET,'method'))){
                   $method=filter_input(INPUT_GET,'method');
               if($method=='edit'){?>
            <h1><img src='images/agency.ico' width='35'><font color='blue'>  แก้ไขข้อมูลองค์กร </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="index.php?page=content/add_comm"><i class="fa fa-edit"></i> ข้อมูลองค์กร</a></li>
              <li class="active"><i class="fa fa-edit"></i> แก้ไขข้อมูลองค์กร</li>
               <?php }}else{?>
            <h1><img src='images/agency.ico' width='35'><font color='blue'>  เพิ่มข้อมูลองค์กร </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> เพิ่มข้อมูลองค์กร</li>
              <?php }?>
            </ol>
</section>
<?php
                                $conn_DB2= new EnDeCode();
                                $read="connection/conn_DB.txt";
                                $conn_DB2->para_read($read);
                                $conn_DB2->conn_PDO();
    if(isset($method)=='edit'){
        $edit=filter_input(INPUT_GET,'id',FILTER_SANITIZE_ENCODED);
        $edit_id=$conn_DB2->sslDec($edit);
        $sql= "select * from community comm left outer join budget bu on bu.comm_id=comm.comm_id
                where comm.comm_id='$edit_id'";
                                $conn_DB2->imp_sql($sql);
                                $edit_person=$conn_DB2->select('');
                                $conn_DB2->close_PDO();
    }
    $sql= "select * from community comm ";
                                $conn_DB2->imp_sql($sql);
                                $num_comm=$conn_DB2->select('');
?>
<section class="content">
    <?php if(count($num_comm) == 0 or isset($method)=='edit'){?>
<div class="row">
          <div class="col-lg-12">
              <?php if(empty($method)){$coll_bos='collapsed-box';}?>
              <div class="box box-success box-solid <?= $coll_bos?>">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='images/agency.ico' width='25'> ข้อมูลองค์กร</h3>
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
<form class="navbar-form" role="form" action='index.php?page=process/prccomm' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
                    <div class="form-group"> 
                <label> ชื่อองค์กร &nbsp;</label>
                <input size="40" value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['group_name'];}?>' type="text" class="form-control" name="group_name" id="group_name" placeholder="ชื่อองค์กร" onkeydown="return nextbox(event, 'cid')" required>
             	</div>
                    <div class="form-group"> 
                <label> เลขทะเบียน &nbsp;</label>
                <input size="35" value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['reggov_code'];}?>' type="text" class="form-control" name="reggov_code" id="reggov_code" placeholder="เลขทะเบียนที่ออกให้โดยหน่วยงานรัฐ" onkeydown="return nextbox(event, 'cid')" required>
             	</div>    
                    <div class="form-group"> 
                <label> วันที่จดทะเบียน &nbsp;</label>
                <?php //include_once'plugins/DatePickerS/datepicker.php'; ?>
                <?php /*
 		if(isset($method)=='edit'){
 			$take_date=$edit_person[0]['birth'];
 			edit_date($take_date);
                        }*/
 		?>
                <input name="regist_date" type="date" id="regist_date"  placeholder='รูปแบบ 22/07/2557' class="form-control"  value="<?php if(isset($method)=='edit'){ echo $edit_person[0]['regist_date'];}?>" onkeydown="return nextbox(event, 'mstatus');"required><br>
                    </div><br><br>
    <div class="form-group"> 
                <label> หน่วยงานผู้รับจด &nbsp;</label>
                <input size="50" value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['reg_gov_name'];}?>' type="text" class="form-control" name="reg_gov_name" id="reg_gov_name" placeholder="หน่วยงานที่กลุ่มออมทรัพย์ขอขึ้นทะเบียน" onkeydown="return nextbox(event, 'cid')" required>
             	</div>
                <div class="form-group"> 
                <label> ผู้รับมอบอำนาจทำการแทน &nbsp;</label>
                   <select name="authorized_person" id="authorized_person" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = "SELECT person_id,concat(fname,' ',lname) as fullname  FROM person order by fname";
				 echo "<option value=''>เลือกบุคลากร</option>";
                $conn_DB2->conn_PDO();
                $conn_DB2->imp_sql($sql);
                $result=$conn_DB2->select('');//เรียกใช้ค่าจาก function ต้องใช้ตัวแปรรับ
        for($i=0;$i<count($result);$i++){
                                if($result[$i]['person_id']==$edit_person[0]['authorized_person']){$selected='selected';}else{$selected='';}
				echo "<option value='".$result[$i]['person_id']."' $selected>".$result[$i]['fullname']." </option>";
				 } ?>
			 </select> 
                </div>
                    <div class="form-group"> 
                <label> เงินทุนตั้งต้น &nbsp;</label>
                <input size="30" value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['budget'];}?>' type="text" class="form-control" name="budget" id="budget" placeholder="เงินทุนที่มี ณ.ตอนเริ่มใช้โปรแกรม" onkeydown="return nextbox(event, 'cid')" required>
             	</div><br>             
                <h4> <u>สถานที่ตั้ง</u></h4>
                <div class="form-group"> 
                <label> ที่อยุ่บ้านเลขที่ &nbsp;</label>
                <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['hourseno'];}?>' type="text" class="form-control" name="hourseno" id="hourseno" placeholder="บ้านเลขที่" onkeydown="return nextbox(event, 'village')" onKeyUp="javascript:inputDigits(this);" required>
             	</div>
                <div class="form-group"> 
                <label> ชื่อหมู่บ้าน &nbsp;</label>
                <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['village'];}?>' type="text" class="form-control" name="village" id="village" placeholder="ชื่อหมู่บ้าน" onkeydown="return nextbox(event, 'moo')">
                </div>
                <div class="form-group"> 
                <label> หมู่ที่ &nbsp;</label>
                <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['moo'];}?>' type="text" class="form-control" name="moo" id="moo" placeholder="หมู่ที่" onkeydown="return nextbox(event, 'post')" onKeyUp="javascript:inputDigits(this);">
                </div><br><br>
                    <?php include_once 'content/js/address.php';?>
                <div class="form-group"> 
                <label> รหัสไปรษณีย์ &nbsp;</label>
                <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['post'];}?>' type="text" class="form-control" name="post" id="post" placeholder="รหัสไปรษณีย์" maxlength="5" onkeydown="return nextbox(event, 'tel')" onKeyUp="javascript:inputDigits(this);">
                </div><br><br>
                <div class="form-group"> 
                <label> หมายเลขโทรศัพท์ &nbsp;</label>
                <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['tel'];}?>' type="text" class="form-control" name="tel" id="tel" placeholder="เบอร์โทรศัพท์" maxlength="10" min="10" onkeydown="return nextbox(event, 'email')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                <div class="form-group"> 
                <label> e-mail &nbsp;</label>
                <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['email'];}?>' type="email" class="form-control" name="email" id="email" placeholder="email" onkeydown="return nextbox(event, 'image')">
             	</div>
                <div class="form-group">
                <label> สัญลักษณ์องค์กร &nbsp;</label>
                <input type="file" name="image"  id="image" class="form-control" onkeydown="return nextbox(event, 'Submit')"/>
                    </div>
                <div class="form-group"> 
                <label> Website &nbsp;</label>
                <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['url'];}?>' type="text" class="form-control" name="url" id="url" placeholder="URL" onkeydown="return nextbox(event, 'image')">
             	</div>
                </div>
                </div>


          </div>
</div>
    <?php if(isset($method)=='edit'){?>
    <input type="hidden" name="method" id="method" value="edit_comm">
    <input type="hidden" name="edit_id" id="edit_id" value="<?=$edit_person[0]['comm_id'];?>">
   <input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="แก้ไข">
   <?php }else{?> 
   <input type="hidden" name="method" id="method" value="add_comm">
   <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
   <?php }
    $conn_DB2->close_PDO(); ?>
</form>
                    <br><br>
    <?php } include 'content/list_comm.php';?>
    </section>
         