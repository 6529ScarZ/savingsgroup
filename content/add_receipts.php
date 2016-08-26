<section class="content-header">
               <?php 
               if(NULL !==(filter_input(INPUT_GET,'method'))){
                   $method=filter_input(INPUT_GET,'method');
               if($method=='edit'){?>
            <h1><font color='blue'>  การรับเงิน </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li><a href="?page=content/add_receipts"><i class="fa fa-edit"></i> การรับเงิน</a></li>
              <li class="active"><i class="fa fa-edit"></i> การลงบันทึกรับเงิน</li>
               <?php }}else{?>
            <h1><img src='images/money_plus.ico' width='35'><font color='blue'>  การรับเงิน </font></h1> 
            <ol class="breadcrumb">
              <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
              <li class="active"><i class="fa fa-edit"></i> การรับเงิน</li>
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
        
        $sql= "select p.*,concat(p2.pname,p.fname,'  ',p.lname) as fullname,sa.saving_total,
            IF (p.sex=1,'ชาย',IF (p.sex=2,'หญิง','UNKNOW')) as sex_name,
            IF (p.user_type=1,'สมาชิกทั่วไป','สมาชิกสมทบ')as user_type_name,m.mem_status,sa.saving_limit,
            (select lc.loan_id from loan_card lc 
            left outer join loan_account la on la.loan_id=lc.loan_id
            where lc.person_id='$edit_id' and la.check_pay='Y' AND la.`status`=1)as loan_id
            from person p 
            left outer join loan_card lc on p.person_id=lc.person_id
            left outer join loan_account la on la.loan_id=lc.loan_id
            inner join saving_account sa on sa.person_id=p.person_id
            inner join preface p2 on p2.pname_id=p.pname_id
            INNER JOIN member_status m ON m.mem_status_id=p.mem_status_id
                where p.person_id='$edit_id' GROUP BY p.person_id";
        $conn_DB2->imp_sql($sql);
        $edit_person=$conn_DB2->select('');
        $conn_DB2->close_PDO();
        
        if(!empty($edit_person[0]['loan_id'])){
        $sql= "select lc.loan_id, lc.loan_number,con.contract_name,con.witdawal,lc.loan_total,la.loan_total as loan_acc,
		la.`month`,la.period,ROUND(((con.witdawal/12)*la.loan_total)/100,2) AS witd
                from loan_card lc 
		INNER JOIN loan_account la ON la.loan_id=lc.loan_id
		INNER JOIN contract con ON con.contract_id=lc.contract_id
                WHERE la.loan_id='".$edit_person[0]['loan_id']."' and la.check_pay='Y' AND la.`status`=1";
                                
                                $conn_DB2->conn_PDO();
                                $conn_DB2->imp_sql($sql);
                                $edit_loan=$conn_DB2->select('');
                                $conn_DB2->close_PDO();
        }                
                                $photo_person="photo/".$edit_person[0]['photo'];
    }
?>
<section class="content">
 <?php if(!empty($method)){?>    
<div class="row">
          <div class="col-lg-12">
              <?php if(empty($method)){$coll_bos='collapsed-box';}?>
              <div class="box box-info box-solid <?= $coll_bos?>">
                <div class="box-header with-border">
                  <h3 class="box-title"><img src='images/money_plus.ico' width='25'> การรับเงิน</h3>
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                  </div><!-- /.box-tools -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <form class="navbar-form" name="form" role="form" action='index.php?page=process/prcreceipts' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
    <div class="col-lg-2">
        <img src="<?= $photo_person?>" height="200">
    </div>    
    <div class="col-lg-10">
        <h4>เงินออม</h4>
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
                <label>ประเภทสมาชิก &nbsp;</label>
                <?php if(isset($method)=='edit'){ echo $edit_person[0]['user_type_name'];}?>
                </div>
                <div class="form-group">
         			<label> สถานะการเป็นสมาชิก &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_person[0]['mem_status'];}?>
                </div><br>
                <div class="form-group">
         			<label> ยอดเงินออมทั้งหมด &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_person[0]['saving_total'];}?> &nbsp;บาท
                </div><br>
                <div class="form-group">
         			<label> จำนวนเงินที่ต้องการออม &nbsp;</label>
                                <input type="text" name="money" id="money" placeholder="จำนวนเงิน" required="" value="<?php if(isset($method)=='edit'){ echo $edit_person[0]['saving_limit'];}?>">
                </div>&nbsp;<br>
                <?php if(!empty($edit_person[0]['loan_id'])){?>
                <h4>เงินกู้</h4>
                <div class="form-group">
         			<label> เลขที่เงินกู้ &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_loan[0]['loan_number'];}?> &nbsp; 
                </div>
                <div class="form-group">
         			<label> กู้ประเภท &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_loan[0]['contract_name'];}?> &nbsp;
                </div>
                <div class="form-group">
         			<label> ดอกเบี่ยร้อยละ &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_loan[0]['witdawal'];}?> &nbsp;บาท/ปี &nbsp;
                </div>
                    <div class="form-group">
         			<label> จำนวนเงินที่กู้ไป &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_loan[0]['loan_total'];}?> &nbsp;บาท &nbsp;
                </div>
                <div class="form-group">
         			<label> จำนวนงวดที่ต้องจ่าย &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_loan[0]['month'];}?> &nbsp;เดือน &nbsp;
                </div>
                <div class="form-group">
         			<label> งวดละ &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_loan[0]['period'];}?> &nbsp;บาท &nbsp;
                </div>
                <div class="form-group">
         			<label> เงินกู้คงเหลือ &nbsp;</label>
                                <?php if(isset($method)=='edit'){ echo $edit_loan[0]['loan_acc'];}?> &nbsp;บาท &nbsp;
                </div><br>
                <div class="form-group">
         			<label> จำนวนเงินที่ส่งคืน &nbsp;</label>
                                <input type="text" name="repay" id="repay" placeholder="จำนวนเงิน" required="" value="<?php if(isset($method)=='edit'){ echo $edit_loan[0]['period'];}?>">
                                <input type="hidden" name="loan_id" id="loan_id" value="<?php if(isset($method)=='edit'){ echo $edit_loan[0]['loan_id'];}?>">
                </div>&nbsp;
                <div class="form-group">
         			<label> ดอกเบี่ย &nbsp;</label>
                                <input type="text" name="witdawal" id="witdawal" placeholder="จำนวนเงิน" required="" value="<?php if(isset($method)=='edit'){ echo $edit_loan[0]['witd'];}?>">
                </div>&nbsp;
                <script language=JavaScript>
function calculate()
{
	var req; 
	if (window.XMLHttpRequest) { 
		// For Netscape, FireFox and not IE
          		req = new XMLHttpRequest();
	}
	else if(window.ActiveXObject){ 
		// For IE
          		req = new ActiveXObject("Microsoft.XMLHTTP"); 
	}
	else {
		alert("Browser error");
		return false;
	}
	req.onreadystatechange = function()
	{
		if(req.readyState == 4)	
			document.form.sum.value = req.responseText;
                }
                var num1, num2,num3,num4, query;
	num1 = document.form.money.value;
	num2 = document.form.repay.value;
        num3 = document.form.witdawal.value;
        num4 = document.form.fine.value;
	query = "?";
	query+="money="+num1;
	query+="&";
	query+="repay="+num2;
        query+="&";
	query+="witdawal="+num3;
        query+="&";
	query+="fine="+num4;
                req.open("GET", "content/js/calculate.php"+query, true);
	req.send(null); 
            }
        </script>
                <a class="" role="button" data-toggle="collapse" href="#collapse" aria-expanded="false" aria-controls="collapseExample">
  ค่าปรับ
</a>
<div class="collapse" id="collapse">
  <div class="well">
    <div class="form-group">
         			<label> ค่าปรับ &nbsp;</label>
                                <input type="text" name="fine" id="fine" placeholder="จำนวนเงินค่าปรับ">
                </div>
  </div>
</div><p>
      <div class="form-group">
            <input class="btn btn-success" type="button" name="button" id="button" value="คำนวณเงิน" onClick="calculate();">
            </div>
        <p>
<div class="form-group">
         			<label> รวม &nbsp;</label>
                                <input type="text" name="sum" id="sum" placeholder="" value="<?php if(isset($method)=='edit'){ echo $edit_person[0]['saving_limit']+$edit_loan[0]['period']+$edit_loan[0]['witd'];}?>">
                                &nbsp;บาท
</div><br><br>
   
                <?php } ?>
                <div class="form-group">
         			<label> วันที่ออมเงิน &nbsp;</label>
                                <input type="date" name="save_date" id="save_date" placeholder="" value="<?= date('Y-m-d')?>">
                </div><br>
<?php
                if(isset($method)=='edit'){?>
    <input type="hidden" name="method" id="method" value="receipts">
    <input type="hidden" name="person_id" id="person_id" value="<?=$edit_person[0]['person_id'];?>">
    <input type="hidden" name="repay_id" id="repay_id" value="<?= $edit_id?>">
   <input class="btn btn-primary" type="submit" name="Submit" id="Submit" value="บันทึกการรับเงิน">
   <?php }
   $conn_DB2->close_PDO(); ?>
    </div>
   </form>
                </div>
                </div>
          </div>
</div>
 <?php }?> 
    <?php include 'content/list_receipts.php';?>
    </section>
         