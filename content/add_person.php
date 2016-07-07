<section class="content-header">
               <?php 
               if(NULL !==(filter_input(INPUT_GET,'method'))){
                   $method=filter_input(INPUT_GET,'method');
               if($method=='edit'){?>
            <h1><font color='blue'>  แก้ไขข้อมูลสมาชิก </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="pre_person.php"><i class="fa fa-edit"></i> ข้อมูลพื้นฐาน</a></li>
              <li class="active"><i class="fa fa-edit"></i> แก้ไขข้อมูลสมาชิก</li>
               <?php }}else{?>
            <h1><img src='images/adduser.ico' width='75'><font color='blue'>  เพิ่มข้อมูลสมาชิก </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> เพิ่มข้อมูลสมาชิก</li>
              <?php }?>
            </ol>
</section>
<?php
    if(isset($method)=='edit'){
        $edit_id=filter_input(INPUT_GET,'id');
        $sql= "select * from person p left outer join address a on p.person_id=a.person_id
                where p.person_id='$edit_id'";
                                $conn_DB1= new DbPDO_mng();
                                $read="connection/conn_DB.txt";
                                $conn_DB1->para_read($read);
                                $conn_DB1->conn_PDO();
                                //$db=$conn_DB1->getDb();
                                $conn_DB1->imp_sql($sql);
                                $edit_person=$conn_DB1->select('');
                                $conn_DB1->close_PDO();
    }
?>
<section class="content">
<div class="row">
          <div class="col-lg-12">
              <?php if(empty($method)){$coll_bos='collapsed-box';}?>
              <div class="box box-success box-solid <?= $coll_bos?>">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='images/phonebook.ico' width='25'> ข้อมูลสมาชิก</h3>
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
<form class="navbar-form" role="form" action='index.php?page=process/prcperson' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
                    <div class="form-group"> 
                <label> รหัสสมาชิก &nbsp;</label>
                <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['member_no'];}?>' type="text" class="form-control" name="member_no" id="member_no" placeholder="รหัสสมาชิก" onkeydown="return nextbox(event, 'cid')" required>
             	</div>
                    <div class="form-group"> 
                    <label> หมายเลขบัตรประชาชน &nbsp;</label>
                    <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['cid'];}?>' type="text" class="form-control" name="cid" id="cid" min="13" max="13" placeholder="หมายเลขบัตรประชาชน" maxlength="13" onkeydown="return nextbox(event, 'pname')" onKeyUp="javascript:inputDigits(this);" required>
                    </div><br><br>
                    <div class="form-group">
         			<label> คำนำหน้า &nbsp;</label>
 				<select name="pname" id="pname" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = "SELECT *  FROM preface order by pname_id ";
                                $conn_DB2= new DbPDO_mng();
                                $read="connection/conn_DB.txt";
                                $conn_DB2->para_read($read);
                                $conn_DB2->conn_PDO();
                                $conn_DB2->imp_sql($sql);
                                $result=$conn_DB2->select('');
                                //$conn_DB2->close_mysqli();
				 echo "<option value=''>--คำนำหน้า--</option>";
				 for($i=0;$i<count($result);$i++){
                                if($result[$i]['pname_id']==$edit_person[0]['pname_id']){$selected='selected';}else{$selected='';}
				echo "<option value='".$result[$i]['pname_id']."' $selected>".$result[$i]['pname']." </option>";
				 } ?> 
			 </select>
			 </div>
                    <div class="form-group"> 
                <label> ชื่อ &nbsp;</label>
                <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['fname'];}?>' type="text" class="form-control" name="fname" id="fname" placeholder="ชื่อ" onkeydown="return nextbox(event, 'lname')" onKeyUp="javascript:inputString(this);" required>
             	</div>
                    <div class="form-group"> 
                <label> นามสกุล &nbsp;</label>
                <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['lname'];}?>' type="text" class="form-control" name="lname" id="lname" placeholder="นามสกุล" onkeydown="return nextbox(event, 'sex')" onKeyUp="javascript:inputString(this);" required>
             	</div>
                <div class="form-group">
         			<label> เพศ &nbsp;</label>
 				<select name="sex" id="sex" required  class="form-control"  onkeydown="return nextbox(event, 'birth');">
                                    <?php if(!empty($edit_person[0]['sex'])){
                                          if($edit_person[0]['sex']==1){?>
                                 <option value='<?=$edit_person['sex'];?>'>ชาย</option>
                                          <?php }else{?>
                                 <option value='<?=$edit_person[0]['sex'];?>'>หญิง</option>
                                    <?php }}?>
				<option value=''> เพศ </option>
                                <option value='1'> ชาย </option>
                                <option value='2'> หญิง </option>
				 </select>
			 </div>
                <div class="form-group"> 
                <label> วันเดือนปีเกิด &nbsp;</label>
                <?php //include_once'plugins/DatePickerS/datepicker.php'; ?>
                <?php /*
 		if(isset($method)=='edit'){
 			$take_date=$edit_person[0]['birth'];
 			edit_date($take_date);
                        }*/
 		?>
                <input name="birth" type="date" id="birth"  placeholder='รูปแบบ 22/07/2557' class="form-control"  value="<?php if(isset($method)=='edit'){ echo $edit_person[0]['birth'];}?>" onkeydown="return nextbox(event, 'mstatus');"required><br>
                </div><br><br>
                <div class="form-group">
         			<label> สถานะสมรส &nbsp;</label>
 				<select name="mstatus" id="mstatus" required  class="form-control"  onkeydown="return nextbox(event, 'member_status');"> 
				<?php	$sql = "SELECT *  FROM mstatus order by mstatus_id";
                                //$conn_DB2->conn_mysqli();
                                $conn_DB2->imp_sql($sql);
                                $result=$conn_DB2->select('');
                                //$conn_DB2->close_mysqli();
				 echo "<option value=''>--สถานะภาพ--</option>";
				 for($i=0;$i<count($result);$i++){
                    if($result[$i]['mstatus_id']==$edit_person[0]['mstatus_id']){$selected='selected';}else{$selected='';}
				echo "<option value='".$result[$i]['mstatus_id']."' $selected>".$result[$i]['mstatus']." </option>";
				 } ?>
			 </select>
                </div><br><br>
                                <div class="form-group"> 
                <label> วันสมัคร &nbsp;</label>
                <?php //include_once'plugins/DatePickerS/datepicker.php'; ?>
                <?php /*
 		if(isset($method)=='edit'){
 			$take_date=$edit_person[0]['birth'];
 			edit_date($take_date);
                        }*/
 		?>
                <input name="regist_date" type="date" id="regist_date"  placeholder='รูปแบบ 22/07/2557' class="form-control"  value="<?php if(isset($method)=='edit'){ echo $edit_person[0]['regist_date'];}?>" onkeydown="return nextbox(event, 'mstatus');"required><br>
                </div>
                <div class="form-group">
        <label> ประเภทสมาชิก &nbsp;</label>
	<select name='user_type' id='user_type'class='form-control' onchange="data_show(this.value,'process');"  required >
			<?php 		
				echo "<option value=''>เลือกประเภทสมาชิก</option>";			
		 		if($edit_person[0]['user_type']=="2"){$ok='selected';}
				if($edit_person[0]['user_type']=="1"){$selected='selected';}
				echo "<option value='1'  $selected>สมาชิกทั่วไป</option>";	
				echo "<option value='2'  $ok >สมาชิกสมทบ</option>";						
				?>
			</select>
                        </div>
                <div class="form-group">
         			<label> สถานะการเป็นสมาชิก &nbsp;</label>
 				<select name="member_status" id="member_status" required  class="form-control"  onkeydown="return nextbox(event, 'hourseno');"> 
				<?php	$sql = "SELECT *  FROM member_status order by mem_status_id";
                                //$conn_DB2->conn_mysqli();
                                $conn_DB2->imp_sql($sql);
                                $result=$conn_DB2->select('');
                                ///$conn_DB2->close_mysqli();
				 echo "<option value=''>--สถานะภาพ--</option>";
				 for($i=0;$i<count($result);$i++){
                    if($result[$i]['mem_status_id']==$edit_person[0]['mem_status_id']){$selected='selected';}else{$selected='';}
				echo "<option value='".$result[$i]['mem_status_id']."' $selected>".$result[$i]['mem_status']." </option>";
				 } ?>
			 </select>
                </div><br><br>
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
                <label> รูปถ่าย &nbsp;</label>
                <input type="file" name="image"  id="image" class="form-control" onkeydown="return nextbox(event, 'Submit')"/>
                    </div>
                </div>
                </div>


          </div>
</div>
    <?php if(isset($method)=='edit'){?>
    <input type="hidden" name="method" id="method" value="edit_person">
    <input type="hidden" name="edit_id" id="edit_id" value="<?=$edit_person[0]['person_id'];?>">
   <input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="แก้ไข">
   <?php }else{?> 
   <input type="hidden" name="method" id="method" value="add_person">
   <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
   <?php }
   $conn_DB2->close_PDO();?>
</form>
                    <br><br>
    <?php include 'content/list_person.php';?>
    </section>
         