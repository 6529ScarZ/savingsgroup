<section class="content-header">
               <?php 
               if(NULL !==(filter_input(INPUT_GET,'method'))){
                   $method=filter_input(INPUT_GET,'method');
               if($method=='edit'){?>
            <h1><font color='blue'>  แก้ไขสัญญาเงินกู้ </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="pre_person.php"><i class="fa fa-edit"></i> สัญญาเงินกู้</a></li>
              <li class="active"><i class="fa fa-edit"></i> แก้ไขสัญญาเงินกู้</li>
               <?php }}else{?>
            <h1><img src='images/adduser.ico' width='75'><font color='blue'>  สัญญาเงินกู้ </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> เพิ่มสัญญาเงินกู้</li>
              <?php }?>
            </ol>
</section>
<?php
                                $conn_DB2= new DbPDO_mng();
                                $read="connection/conn_DB.txt";
                                $conn_DB2->para_read($read);
    if(isset($method)=='edit'){
        $edit_id=filter_input(INPUT_GET,'id');
        $sql= "select * from loan_card 
                where loan_id='$edit_id'";
                                $conn_DB2->conn_PDO();
                                //$db=$conn_DB1->getDb();
                                $conn_DB2->imp_sql($sql);
                                $edit_person=$conn_DB2->select('');
                                $conn_DB2->close_PDO();
    }
?>
<section class="content">
<div class="row">
          <div class="col-lg-12">
              <?php if(empty($method)){$coll_bos='collapsed-box';}?>
              <div class="box box-success box-solid <?= $coll_bos?>">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='images/phonebook.ico' width='25'> ข้อมูลสัญญาเงินกู้</h3>
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
<form class="navbar-form" role="form" action='index.php?page=process/prcloanAgreement' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
                    <div class="form-group"> 
                <label> สมาชิกที่ยื่นกู้ &nbsp;</label>
                        <select name="person_id" id="person_id" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = "SELECT person_id,concat(fname,' ',lname) as fullname  FROM person order by fname";
				 echo "<option value=''>เลือกบุคลากร</option>";
                $conn_DB2->conn_PDO();
                $conn_DB2->imp_sql($sql);
                $result=$conn_DB2->select('');//เรียกใช้ค่าจาก function ต้องใช้ตัวแปรรับ
                $conn_DB2->close_PDO();
        for($i=0;$i<count($result);$i++){
                                if($result[$i]['person_id']==$edit_person[0]['person_id']){$selected='selected';}else{$selected='';}
				echo "<option value='".$result[$i]['person_id']."' $selected>".$result[$i]['fullname']." </option>";
				 } ?>
			 </select>             	</div>
                    <div class="form-group"> 
                    <label>&nbsp; สัญญาเงินกู้เลขที่ &nbsp;</label>
                    <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['loan_number'];}?>' type="text" class="form-control" name="loan_number" id="loan_number" placeholder="เลขที่สัญญาเงินกู้"  required>
                    </div>
                    <div class="form-group">
         			<label>&nbsp; ประเภทเงินกู้ &nbsp;</label>
 				<select name="contract_id" id="contract_id" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = "SELECT *  FROM contract order by contract_id ";
                                $conn_DB2->conn_PDO();
                                $conn_DB2->imp_sql($sql);
                                $result=$conn_DB2->select('');
                                $conn_DB2->close_PDO();
				 echo "<option value=''>--เลือกประเภทเงินกู้--</option>";
				 for($i=0;$i<count($result);$i++){
                                if($result[$i]['contract_id']==$edit_person[0]['contract_id']){$selected='selected';}else{$selected='';}
				echo "<option value='".$result[$i]['contract_id']."' $selected>".$result[$i]['contract_name']." </option>";
				 } ?> 
			 </select>
                    </div><br><br>
                    <div class="form-group"> 
                <label> จำนวนเงินกู้ &nbsp;</label>
                <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['loan_total'];}?>' type="text" class="form-control" name="loan_total" id="loan_total" placeholder="จำนวนเงินกู้" onkeydown="return nextbox(event, 'lname')" onKeyUp="javascript:inputDigits(this);" required>
             	</div>
                    <div class="form-group"> 
                <label>&nbsp; จำนวนเงินกู้(ตัวอักษร) &nbsp;</label>
                <input value='<?php if(isset($method)=='edit'){ echo $edit_person[0]['loan_character'];}?>' type="text" class="form-control" name="loan_character" id="loan_character" placeholder="จำนวนเงินกู้(ตัวอักษร)" onkeydown="return nextbox(event, 'sex')" onKeyUp="javascript:inputString(this);" required>
             	</div>
                <div class="form-group">
                    <label>&nbsp; การนำไปใช้ประโยชน์ &nbsp;</label>
                    <textarea class="form-control" name="note" id="note" cols="50" placeholder="รายละเอียดการนำเงินไปใช้ประโยชน์"><?php if(isset($method)=='edit'){ echo $edit_person[0]['note'];}?></textarea>
                </div><br><br>
                <div class="form-group"> 
                <label> วันที่เริ่มสัญญาเงินกู้ &nbsp;</label>
                <input name="loan_startdate" type="date" id="loan_startdate"  placeholder='รูปแบบ 22/07/2557' class="form-control"  value="<?php if(isset($method)=='edit'){ echo $edit_person[0]['loan_startdate'];}?>" onkeydown="return nextbox(event, 'mstatus');"required><br>
                </div>
                <div class="form-group"> 
                <label>&nbsp; วันที่ครบกำหนดสัญญา &nbsp;</label>
                <input name="loan_enddate" type="date" id="loan_enddate"  placeholder='รูปแบบ 22/07/2557' class="form-control"  value="<?php if(isset($method)=='edit'){ echo $edit_person[0]['loan_enddate'];}?>" onkeydown="return nextbox(event, 'mstatus');"required><br>
                </div><br><br>
                <div class="form-group">
         			<label> หมายเลขสมาชิกผู้ค้ำประกันคนที่ 1 &nbsp;</label>
                        <select name="bondsman_1" id="bondsman_1" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = "SELECT person_id,concat(fname,' ',lname) as fullname  FROM person order by fname";
				 echo "<option value=''>เลือกบุคลากร</option>";
                $conn_DB2->conn_PDO();
                $conn_DB2->imp_sql($sql);
                $result=$conn_DB2->select('');//เรียกใช้ค่าจาก function ต้องใช้ตัวแปรรับ
                $conn_DB2->close_PDO();
        for($i=0;$i<count($result);$i++){
                                if($result[$i]['person_id']==$edit_person[0]['bondsman_1']){$selected='selected';}else{$selected='';}
				echo "<option value='".$result[$i]['person_id']."' $selected>".$result[$i]['fullname']." </option>";
				 } ?>
			 </select>
                </div><br><br>
                <div class="form-group">
         			<label> หมายเลขสมาชิกผู้ค้ำประกันคนที่ 2 &nbsp;</label>
                        <select name="bondsman_2" id="bondsman_2" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = "SELECT person_id,concat(fname,' ',lname) as fullname  FROM person order by fname";
				 echo "<option value=''>เลือกบุคลากร</option>";
                $conn_DB2->conn_PDO();
                $conn_DB2->imp_sql($sql);
                $result=$conn_DB2->select('');//เรียกใช้ค่าจาก function ต้องใช้ตัวแปรรับ
                $conn_DB2->close_PDO();
        for($i=0;$i<count($result);$i++){
                                if($result[$i]['person_id']==$edit_person[0]['bondsman_2']){$selected='selected';}else{$selected='';}
				echo "<option value='".$result[$i]['person_id']."' $selected>".$result[$i]['fullname']." </option>";
				 } ?>
			 </select>
                </div><br><br>
                <div class="form-group">
         			<label> หมายเลขสมาชิกผู้ค้ำประกันคนที่ 3 &nbsp;</label>
                        <select name="bondsman_3" id="bondsman_3" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = "SELECT person_id,concat(fname,' ',lname) as fullname  FROM person order by fname";
				 echo "<option value=''>เลือกบุคลากร</option>";
                $conn_DB2->conn_PDO();
                $conn_DB2->imp_sql($sql);
                $result=$conn_DB2->select('');//เรียกใช้ค่าจาก function ต้องใช้ตัวแปรรับ
                $conn_DB2->close_PDO();
        for($i=0;$i<count($result);$i++){
                                if($result[$i]['person_id']==$edit_person[0]['bondsman_3']){$selected='selected';}else{$selected='';}
				echo "<option value='".$result[$i]['person_id']."' $selected>".$result[$i]['fullname']." </option>";
				 } ?>
			 </select>
                </div>
                </div>
                </div>


          </div>
</div>
    <?php if(isset($method)=='edit'){?>
    <input type="hidden" name="method" id="method" value="edit_loanAgree">
    <input type="hidden" name="edit_id" id="edit_id" value="<?=$edit_person[0]['loan_id'];?>">
   <input class="btn btn-warning" type="submit" name="Submit" id="Submit" value="แก้ไข">
   <?php }else{?> 
   <input type="hidden" name="method" id="method" value="add_loanAgree">
   <input class="btn btn-success" type="submit" name="Submit" id="Submit" value="บันทึก">
   <?php }
   $conn_DB2->close_PDO();?>
</form>
                    <br><br>
    <?php include 'content/list_loanAgreement.php';?>
    </section>
         