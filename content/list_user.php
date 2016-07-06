<?php
     $sql="SELECT CONCAT(p.fname,' ',p.lname) AS fullname,
IF(m.`Status`='ADMIN','ผู้ดูแลระบบ','ผู้ใช้งานทั่วไป')as status_name,
IF(p.user_type=1,'สมาชิกสามัญ','สมาชิกสมทบ')AS user_type,m.user_name,m.UserID,m.UserID as UserID2
FROM member m
INNER JOIN person p ON p.person_id=m.`Name`
order by fullname "; 
                $column=array("ชื่อ-นามสกุล","ระดับการใช้งาน","ประเภทสมาชิก","ชื่อที่ใช้งาน","แก้ไข","ลบ");//หากเป็น TB_mng ต้องเพิ่ม แก้ไข,ลบเข้าไปด้วย 
                $mydata=new TablePDO($column);
                $read="connection/conn_DB.txt";
                $mydata->para_read($read);
                $mydata->imp_sql($sql);
        $result=$mydata->select('');//เรียกใช้ค่าจาก function ต้องใช้ตัวแปรรับ
        $mydata->createPDO_TB_edit('user');//ใส่ process ที่ต้องการสร้าง
     ?>

<!--<table id="example1" class="table table-bordered table-striped">
                            <thead> <TR bgcolor='#898888'>
					<th width='5%'><CENTER><p>ลำดับ</p></CENTER></th>
					<th width='25%'><CENTER>ชื่อ - นามสกุล</CENTER></th>
					<th width='15%'><CENTER>ระดับการใช้งาน</CENTER></th>
                                        <th width='15%'><CENTER>ประเภทสมาชิก</CENTER></th>
					<th width='15%'><CENTER>ชื่อที่ใช้งาน</CENTER></th>
					<th width='5%'><CENTER>แก้ไข</CENTER></th>
                                        <th width='5%'><CENTER>ลบ</CENTER></th>
 </TR>
  </thead>
                       <tbody>
<?php //$I=1;
//for($i=0;$i<count($result);$i++){?>  
 					<tr >	    
				    <TD height="20" align="center" ><?= $I?></TD>
					<TD><?=$result[$i]['fullname']; ?></TD>
					<TD align="center"><?= $result[$i]['status_name']?></TD>
                                        <td align="center"><?= $result[$i]['user_type']?></td>
					<TD align="center"><?=$result[$i]['user_name']; ?></TD>
 					<TD align="center">
                                        <a href='index.php?page=content/add_User&method=update_user&id=<?=$result[$i]['ID']?>&status=<?=$result[$i]['Status']?>&ID=<?= $result[$i]['UserID']?>' >
                                        <img src="images/icon_set1/document_edit.ico" width="25"></a> 
                                        </td>
                                        <td align="center">
					<a href='index.php?page=process/prcuser&method=delete_user&d=<?=$result[$i]['ID']?>&ID=<?= $result[$i]['UserID']?>'  title="confirm" onclick="if(confirm('ยืนยันการลบ <?= $result[$i]['fullname']?>&nbsp;ออกจากรายการ ')) return true; else return false;">   
					<img src="images/icon_set1/document_delete.ico" width="25"></a>
                                        </td>
					</tr> 
 
  			 
 		 <?php// $I++; } ?>
 		 
</tbody>
                         <tfoot>
                      <tr align="center" bgcolor="#898888">
                                <th width='5%'><CENTER>
                                        <p>ลำดับ</p></CENTER></th>
					<th width='25%'><CENTER>ชื่อ - นามสกุล</CENTER></th>
					<th width='15%'><CENTER>ระดับการใช้งาน</CENTER></th>
                                        <th width='15%'><CENTER>ประเภทสมาชิก</CENTER></th>
					<th width='15%'><CENTER>ชื่อที่ใช้งาน</CENTER></th>
					<th width='5%'><CENTER>แก้ไข</CENTER></th>
                                        <th width='5%'><CENTER>ลบ</CENTER></th>
                      </tr>
                    </tfoot>
</table>-->

