<section class="content-header">
               <?php 
               if(!empty($_REQUEST['method'])){
                   $method=$_REQUEST['method'];
               if($method=='edit'){?>
            <h1><font color='blue'>  แก้ไขข้อมูลบุคลากร </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="pre_person.php"><i class="fa fa-edit"></i> ข้อมูลพื้นฐาน</a></li>
              <li class="active"><i class="fa fa-edit"></i> แก้ไขข้อมูลบุคลากร</li>
               <?php }}else{?>
            <h1><img src='images/adduser.ico' width='75'><font color='blue'>  เพิ่มข้อมูลบุคลากร </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> เพิ่มข้อมูลบุคลากร</li>
              <?php }?>
            </ol>
</section>
<?php
    if(isset($method)=='edit'){
        $edit_id=$_REQUEST['id'];
        $edit_per=  mysql_query("select * from emppersonal e1 left outer join educate e2 on e1.empno=e2.empno
            where e1.empno='$edit_id'");
        $edit_person=  mysql_fetch_assoc($edit_per);
    }
?>
<section class="content">
<form class="navbar-form" role="form" action='prcperson.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
<div class="row">
          <div class="col-lg-12">
              <div class="box box-success box-solid collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='images/phonebook.ico' width='25'> ข้อมูลทั่วไป</h3>
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group"> 
                <label>รหัสพนักงาน &nbsp;</label>
                <input value='<?=$edit_person[pid];?>' type="text" class="form-control" name="empid" id="empid" placeholder="รหัสพนักงาน" onkeydown="return nextbox(event, 'cidid')" required>
             	</div>
                    <div class="form-group"> 
                    <label>หมายเลขบัตรประชาชน &nbsp;</label>
                <input value='<?=$edit_person[idcard];?>' type="text" class="form-control" name="cidid" id="cidid" placeholder="หมายเลขบัตรประชาชน" maxlength="13" onkeydown="return nextbox(event, 'pname')" onKeyUp="javascript:inputDigits(this);" required>
             	</div><br>
                    <div class="form-group">
         			<label>คำนำหน้า &nbsp;</label>
 				<select name="pname" id="pname" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = mysql_query("SELECT *  FROM pcode order by pname  ");
				 echo "<option value=''>--คำนำหน้า--</option>";
				 while( $result = mysql_fetch_assoc( $sql ) ){
          if($result[pcode]==$edit_person[pcode]){$selected='selected';}else{$selected='';}
				 echo "<option value='$result[pcode]' $selected>$result[pname] </option>";
				 } ?>
			 </select>
			 </div>
                    <div class="form-group"> 
                <label>ชื่อ &nbsp;</label>
                <input value='<?=$edit_person[firstname];?>' type="text" class="form-control" name="fname" id="fname" placeholder="ชื่อ" onkeydown="return nextbox(event, 'lname')" onKeyUp="javascript:inputString(this);" required>
             	</div>
                    <div class="form-group"> 
                <label>นามสกุล &nbsp;</label>
                <input value='<?=$edit_person[lastname];?>' type="text" class="form-control" name="lname" id="lname" placeholder="นามสกุล" onkeydown="return nextbox(event, 'sex')" onKeyUp="javascript:inputString(this);" required>
             	</div><br>
                <div class="form-group">
         			<label>เพศ &nbsp;</label>
 				<select name="sex" id="sex" required  class="form-control"  onkeydown="return nextbox(event, 'bday');">
                                    <? if($edit_person[sex]!=''){
                                          if($edit_person[sex]==1){     ?>
                                 <option value='<?=$edit_person[sex];?>'>ชาย</option>
                                          <?}else{?>
                                 <option value='<?=$edit_person[sex];?>'>หญิง</option>
                                    <?}}?>
				<option value=''>เพศ</option>
                                <option value='1'> ชาย </option>
                                <option value='2'> หญิง </option>
				 </select>
			 </div>
                <div class="form-group"> 
                <label>วันเดือนปีเกิด &nbsp;</label>
                <?php include_once'option/DatePicker/index.php'; ?>
                <?php
 		if($_GET[method]!=''){
 			$take_date=$edit_person[birthdate];
 			edit_date($take_date);
                        }
 		?>
                <input name="bday" type="text" id="datepicker-th-1"  placeholder='รูปแบบ 22/07/2557' class="form-control"  value="<?=$take_date?>" required><br>
                </div>
                <div class="form-group"> 
                <label>ที่อยุ่บ้านเลขที่ &nbsp;</label>
                <input value='<?=$edit_person[address];?>' type="text" class="form-control" name="address" id="address" placeholder="บ้านเลขที่" onkeydown="return nextbox(event, 'hname')" required>
             	</div>
                <div class="form-group"> 
                <label>ชื่อหมู่บ้าน &nbsp;</label>
                <input value='<?=$edit_person[baan];?>' type="text" class="form-control" name="hname" id="hname" placeholder="ชื่อหมู่บ้าน" onkeydown="return nextbox(event, 'postcode')">
                </div><br>
                    <? include_once 'address.php';?>
                <div class="form-group"> 
                <label>รหัสไปรษณีย์ &nbsp;</label>
                <input value='<?=$edit_person[zipcode];?>' type="text" class="form-control" name="postcode" id="postcode" placeholder="รหัสไปรษณีย์" maxlength="5" onkeydown="return nextbox(event, 'status')" onKeyUp="javascript:inputDigits(this);">
             	</div><br>
                <div class="form-group">
         			<label>สถานะภาพ &nbsp;</label>
 				<select name="status" id="status" required  class="form-control"  onkeydown="return nextbox(event, 'htell');"> 
				<?php	$sql = mysql_query("SELECT *  FROM empstatus order by status");
				 echo "<option value=''>--สถานะภาพ--</option>";
				 while( $result = mysql_fetch_assoc( $sql ) ){
          if($result[status]==$edit_person[emp_status]){$selected='selected';}else{$selected='';}
				 echo "<option value='$result[status]' $selected>$result[statusname] </option>";
				 } ?>
			 </select>
			 </div><br>
                <div class="form-group"> 
                <label>เบอร์โทรศัพท์บ้าน &nbsp;</label>
                <input value='<?=$edit_person[telephone];?>' type="text" class="form-control" name="htell" id="htell" placeholder="เบอร์โทรศัพท์บ้าน" maxlength="9" onkeydown="return nextbox(event, 'mtell')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                <div class="form-group"> 
                <label>เบอร์โทรศัพท์มือถือ &nbsp;</label>
                <input value='<?=$edit_person[mobile];?>' type="text" class="form-control" name="mtell" id="mtell" placeholder="เบอร์โทรศัพท์มือถือ" maxlength="10" onkeydown="return nextbox(event, 'email')" onKeyUp="javascript:inputDigits(this);">
             	</div>
                <div class="form-group"> 
                <label>e-mail &nbsp;</label>
                <input value='<?=$edit_person[email];?>' type="text" class="form-control" name="email" id="email" placeholder="email" onkeydown="return nextbox(event, 'order')">
             	</div>
                <div class="form-group">
                <label>รูปถ่าย &nbsp;</label>
                <input type="file" name="image"  id="image" class="form-control"/>
                    </div>
                </div>
                </div>


          </div>
</div>
    <?php if(isset($method)=='edit'){?>
    <input type="hidden" name="method" id="method" value="edit">
    <input type="hidden" name="edit_id" id="edit_id" value="<?=$edit_person['empno'];?>">
   <input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="แก้ไข">
   <?php }else{?> 
   <input type="hidden" name="method" id="method" value="add_person">
   <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
   <?php }?>
</form>
    </section>
         