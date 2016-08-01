<div class="row">
          <div class="col-lg-12">
              <div class="box box-success box-solid">
                <div class="box-header">
                  <h3 class="box-title"><img src='images/icon_set2/dolly.ico' width='25'> ตารางสมาชิก</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                            <?php
$sql="SELECT p.member_no,CONCAT(p2.pname,p.fname,' ',p.lname) AS fullname,
if(p.user_type=1,'สมาชิกทั่วไป','สมาชิกสมทบ')as user_type    
,m.mem_status,
p.person_id as id,la.loan_id as id2
FROM person p
INNER JOIN preface p2 ON p.pname_id=p2.pname_id
INNER JOIN member_status m ON m.mem_status_id=p.mem_status_id
INNER JOIN loan_account la ON la.person_id=p.person_id
WHERE la.check_pay='Y' AND la.status=1
ORDER BY p.person_id DESC";
//หากเป็น TB_mng ต้องเพิ่ม id ต่อทาย 2 id เข้าไปด้วย 
$column=array("รหัสสมาชิก","ชื่อ-นามสกุล","ประเภทสามชิก","สถานะการเป็นสมาชิก","รายละเอียด","คืนเงินกู้");//หากเป็น TB_mng ต้องเพิ่ม แก้ไข,ลบเข้าไปด้วย 
                $mydata=new TablePDO($column);
                $read="connection/conn_DB.txt";
                $mydata->para_read($read);
                $db=$mydata->conn_PDO();
                $mydata->imp_sql($sql);
                $mydata->createPDO_TB_ED('repay');//ใส่ process ที่ต้องการสร้าง
                $mydata->close_PDO();
    ?>
                </div>
              </div>
          </div>
</div>
