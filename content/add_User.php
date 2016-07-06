  <script language="javascript">
function fncSubmit()
	{
	 if(document.form1.user_pwd.value != document.form1.user_pwd2.value)
		{
			alert('การยืนยันรหัสผ่านไม่ตรงกัน กรุณาตรวจสอบ');
			document.form1.user_pwd.focus();		
			return false;
		}else{	
			return true;
			document.form1.submit();
		}
}
</script>
<section class="content-header">
               <h1> <font color="blue">ตั้งค่าผู้ใช้งาน</font></h1>
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-gear"></i> ตั้งค่าผู้ใช้งาน</li>
            </ol>
</section>
			<?php 
                $mydata=new DbPDO_mng();
                $read='connection/conn_DB.txt';
                $mydata->para_read($read);
                
			 if(null !==(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT))){ 
			 $user_idGet=filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                          /*if(filter_input(INPUT_GET, 'method', FILTER_SANITIZE_STRING)=='update_user'){
                             $status= filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);
                         }elseif(filter_input(INPUT_GET, 'method', FILTER_SANITIZE_STRING)=='edit'){
                         $status=$_SESSION['Status'];}*/
			 $sql="select m.*,concat(p.fname,' ',p.lname) as fullname from  member m
                             inner join person p on p.person_id=m.Name where m.UserID='$user_idGet'";
			 $mydata->conn_PDO();
                         $mydata->imp_sql($sql);
                         $resultGet=$mydata->select('');
			 }
			   ?> 
<section class="content">
<div class="row">
          <div class="col-lg-12">
              <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">เพิ่มผู้ใช้งานระบบ</h3>
                    </div>
                <div class="panel-body">
                    <div class="col-lg-3 col-xs-12">
                        <div class="row well well-sm">   
                    <form name='form1' class="navbar-form navbar-left"  action='index.php?page=process/prcuser' method='post' enctype="multipart/form-data" OnSubmit="return fncSubmit();">
                        <b>ชื่อ-นามสกุล </b><br>
                        <div class="form-group">	
                        <?php if($_SESSION['Status']=='USER'){?>
                            <input type="text" name='names'   id='names' class='form-control' value='<?=$resultGet[0]['fullname']?>'  onkeydown="return nextbox(event, 'save');" readonly >
                            <input type="hidden" name="name" id="name" value="<?=$resultGet[0]['Name']?>">
                            <?php }else{?>
                         	<select name="name" id="name" required  class="form-control"  onkeydown="return nextbox(event, 'fname');"> 
				<?php	$sql = "SELECT person_id,concat(fname,' ',lname) as fullname  FROM person order by fname";
				 echo "<option value=''>เลือกบุคลากร</option>";
                $mydata->conn_PDO();
                $mydata->imp_sql($sql);
                $result=$mydata->select('');//เรียกใช้ค่าจาก function ต้องใช้ตัวแปรรับ
        for($i=0;$i<count($result);$i++){
                                if($result[$i]['person_id']==$resultGet[0]['Name']){$selected='selected';}else{$selected='';}
				echo "<option value='".$result[$i]['person_id']."' $selected>".$result[$i]['fullname']." </option>";
				 } ?>
			 </select>
                            <?php }?>
			 </div> 
                        <br>
                        <div class="form-group">
        <label>ระดับการใช้งาน &nbsp;</label><br>
                    <?php if($_SESSION['Status']=='ADMIN'){ ?>
	<select name='admin' id='admin'class='form-control' onchange="data_show(this.value,'process');"  required >
			<?php 		
				echo "<option value=''>เลือกระดับการใช้งาน</option>";			
		 		if($resultGet[0]['Status']=="ADMIN"){$ok='selected';}
				if($resultGet[0]['Status']=="USER"){$selected='selected';}
				echo "<option value='USER'  $selected>ผู้ใช้ทั่วไป</option>";	
				echo "<option value='ADMIN'  $ok >ผู้ดูแลระบบ</option>";						
				?>
			</select>
                         <?php }else{?>
                                <input type="text" name=''   id='' class='form-control'  value='<?= 'ผู้ใช้ทั่วไป'?>' readonly >
                                <input type="hidden" name="admin" id="admin" value="<?= $resultGet[0]['Status']?>">
                         <?php }?>
                        </div>
                        <br>
                        <?php if($_SESSION['Status']=='ADMIN'){
                            $read='';
                        }else{
                            $read='readonly';
                        }
?>
			<div class="form-group">	
                            <b>ชื่อผู้ใช้งาน</b><br>
                        <input type='text' name='user_account'  id='user_account' placeholder='ชื่อผู้ใช้งาน' class='form-control'  onkeydown="return nextbox(event, 'user_pwd');"   value='<?php if(!empty($user_idGet)){ echo $resultGet[0]['user_name'];}?>' required <?= $read?>>
			 </div> 
                        <br>
			<?PHP 
			if(empty($user_idGet)){
			 	$required='required';			
			}else{
				$required='';
			}
			?> 
			<div class="form-group">
                            <b>รหัสผ่าน</b><br>
			<input type="password" name='user_pwd'  id='user_pwd' placeholder='รหัสผ่าน' class='form-control'  value=''  onkeydown="return nextbox(event, 'user_pwd2');" <?= $required?>>
			 </div><br>
	 		<div class="form-group">
                            <label for="user_pwd2">ยืนยันรหัสผ่าน</label><br>
			<input type="password" name='user_pwd2' id='user_pwd2' placeholder='ยืนยันรหัสผ่าน' class='form-control'  value=''  onkeydown="return nextbox(event, 'save');" <?= $required?>>
			 </div><br>
                         <font color="red"><?php 	if(!empty($user_idGet)){echo "*หากไม่เปลี่ยนรหัสผ่านไม่ต้องแก้ไข";}?></font>
 <br>
 <?PHP 
	if(!empty($user_idGet)){
		echo "<input type='hidden' name='id' value='$user_idGet'>";
		echo "<input type='hidden' name='method' value='update_user'>";
                ?>
        <p><button  class="btn btn-warning" id='save'> แก้ไข </button > <input type='reset' class="btn btn-danger"   > </p>
	<?php }  else {?>
        <input type="hidden" name="method" value="add_user">
         <p><button  class="btn btn-success" id='save'> บันทึก </button > <input type='reset' class="btn btn-danger"   > </p>
              <?php } ?>
		</form>
                        </div>
      </div> <?php if($_SESSION['Status']=='ADMIN'){?>
                    <div class="col-lg-9 col-xs-12">
                        <div class="well well-sm">
                      <?php include 'list_user.php';?>   
                        </div></div>
      <?php}?>
    </div>
              </div>
    </div>
  </div>
        
         <?php }?>
</section>
