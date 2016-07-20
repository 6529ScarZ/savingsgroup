<div class="row">
          <div class="col-lg-12">
              <div class="box box-success box-solid">
                <div class="box-header">
                  <h3 class="box-title"><img src='images/icon_set2/dolly.ico' width='25'> ตารางองค์กร</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                            <?php
$sql="SELECT lc.loan_number,CONCAT(p.fname,' ',p.lname) AS fullname,lc.loan_startdate,lc.loan_enddate,
lc.loan_id AS id ,lc.loan_id AS id2 ,lc.loan_id AS id3 
FROM loan_card lc 
INNER JOIN person p ON p.person_id=lc.person_id";
//หากเป็น TB_mng ต้องเพิ่ม id ต่อทาย 3 id เข้าไปด้วย 
$column=array("เลขที่สัญญาเงินกู้","ผู้กู้","วันที่เริ่มสัญญา","วันที่ครบกำหนด","รายละเอียด","แก้ไข","ลบ");//หากเป็น TB_mng ต้องเพิ่ม แก้ไข,ลบเข้าไปด้วย 
///////วิธีเตรียมข้อมูลหัวตารางแบบมีคอลัมบ์ย่อย//////////////
/*$column= array(
                            "column1"=>array(0=>"sub_column1_1", 1=>"sub_column1_2", 2=>"sub_column1_3"),
                            "column2"=>array(0=>"sub_column2_1", 1=>"sub_column2_2", 2=>"sub_column2_3"),
                            "column3"=>array(0=>"sub_column3_1", 1=>"sub_column3_2", 2=>"sub_column3_3")  
                );  */              
                $mydata=new TablePDO($column);
                $read="connection/conn_DB.txt";
                $mydata->para_read($read);
                $db=$mydata->conn_PDO();
                $mydata->imp_sql($sql);
                $mydata->createPDO_TB_mng("loanAgreement");//ใส่ process ที่ต้องการสร้าง
                $mydata->close_PDO();
    ?>
                </div>
              </div>
          </div>
</div>
