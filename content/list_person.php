<div class="row">
          <div class="col-lg-12">
              <div class="box box-success box-solid">
                <div class="box-header">
                  <h3 class="box-title"><img src='images/icon_set2/dolly.ico' width='25'> ตารางสมาชิก</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                            <?php
$sql="SELECT p.member_no,CONCAT(p2.pname,p.fname,' ',p.lname) AS fullname,p.regist_date,
if(p.user_type=1,'สมาชิกทั่วไป','สมาชิกสมทบ')as user_type    
,m.mem_status,
p.person_id,p.person_id as person_id2,p.person_id as person_id3
FROM person p
INNER JOIN preface p2 ON p.pname_id=p2.pname_id
INNER JOIN member_status m ON m.mem_status_id=p.mem_status_id
ORDER BY p.person_id DESC";
//หากเป็น TB_mng ต้องเพิ่ม id ต่อทาย 2 id เข้าไปด้วย 
$column=array("รหัสสมาชิก","ชื่อ-นามสกุล","วันที่ลงบันทึก","ประเภทสามชิก","สถานะการเป็นสมาชิก","รายละเอียด","แก้ไข","ลบ");//หากเป็น TB_mng ต้องเพิ่ม แก้ไข,ลบเข้าไปด้วย 
                $mydata=new TablePDO($column);
                $read="connection/conn_DB.txt";
                $mydata->para_read($read);
                $db=$mydata->conn_PDO();
                $mydata->imp_sql($sql);
                $mydata->createPDO_TB_mng('person');//ใส่ process ที่ต้องการสร้าง
    ?>
                </div>
              </div>
          </div>
</div>
