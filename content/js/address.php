<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

</head>
<body>
 
  
<?php //include'connection/connect.php';?>
	<script language="JavaScript">

function Check_txt(){
	if(document.getElementById('province').value==""){
		alert("กรุณาระบุ จังหวัด ด้วย");
		document.getElementById('province').focus();
		return false;
	}
	if(document.getElementById('amphur').value=='No'){
		alert("กรุณาระบุ อำเภอ ด้วย");
		document.getElementById('amphur').focus();
		return false;
	}
	
	if(document.getElementById('district').value==""){
		alert("กรุณาระบุ ตำบล ด้วย");
		document.getElementById('district').focus();
		return false;
	}
}
</script>
    <div class="form-group"> 
                    <label>จังหวัด &nbsp;</label>
	<select class="form-control" name='province' id='province' onchange="data_show(this.value,'amphur');">
		<option value="">---โปรดเลือกจังหวัด---</option>
		<?php
		$sql="select * from province Order By PROVINCE_NAME ASC";
                                //$conn_DB3=new Db_mng;
                                //$conn_DB3->read="connection/conn_DB.txt";
                                //conn_DB3->config();
                                $conn_DB2->conn_mysqli();
                                $conn_DB2->db_m($sql);
                                $result=$conn_DB2->select();
                                $conn_DB2->close_mysqli();
                                for($i=0;$i<count($result);$i++){
                    if($result[$i]['PROVINCE_ID']==$edit_person[0]['provice']){$selected='selected';}else{$selected='';}
		echo "<option value='".$result[$i]['PROVINCE_ID']."' $selected>".$result[$i]['PROVINCE_NAME']."</option>";
		}?>
	</select>
    </div>
      <div class="form-group">
        <label>อำเภอ &nbsp;</label>
	<select class="form-control" name='amphur' id='amphur'onchange="data_show(this.value,'district');">
            <?php if(isset($method)=='edit'){
                $rstTemp = mysql_query("select * from amphur where AMPHUR_ID='$edit_person[empure]'");
                while ($arr_2 = mysql_fetch_array($rstTemp)){
                if($arr_2[AMPHUR_ID]==$edit_person[empure]){$selected='selected';}else{$selected='';}
                echo "<option value='$arr_2[AMPHUR_ID]' $selected>$arr_2[AMPHUR_NAME]</option>";
                
                } }  else {?>
            <option value="">---โปรดเลือกอำเภอ---</option>
            <?php }?>
	</select>
	</div>
        <div class="form-group">
        <label>ตำบล &nbsp;</label>  
	<select class="form-control" name='district' id='district'>
            <?php if(isset($method)=='edit'){
                $rstTemp = mysql_query("select * from district where DISTRICT_ID='$edit_person[tambol]'");
                while ($arr_2 = mysql_fetch_array($rstTemp)){
                if($arr_2[DISTRICT_ID]==$edit_person[tambol]){$selected='selected';}else{$selected='';}
                echo "<option value='$arr_2[DISTRICT_ID]' $selected>$arr_2[DISTRICT_NAME]</option>";
                
                } }  else {?>
		<option value="">---โปรดเลือกตำบล---</option>
                <?php }?>
	</select>
        </div>

<script language="javascript">
// Start XmlHttp Object
function uzXmlHttp(){
    var xmlhttp = false;
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(e){
            xmlhttp = false;
        }
    }
 
    if(!xmlhttp && document.createElement){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
// End XmlHttp Object

function data_show(select_id,result){
	var url = 'content/js/address2.php?select_id='+select_id+'&result='+result;
	//alert(url);
	
    xmlhttp = uzXmlHttp();
    xmlhttp.open("GET", url, false);
	xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
    xmlhttp.send(null);
	document.getElementById(result).innerHTML =  xmlhttp.responseText;
}
//window.onLoad=data_show(5,'amphur'); 
</script>

