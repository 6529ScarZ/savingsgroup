<div class="row">
          <div class="col-lg-12">
              <div class="box box-success box-solid">
                <div class="box-header">
                  <h3 class="box-title"><img src='images/agency.ico' width='25'> ตารางองค์กร</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                            <?php
$sql="SELECT comm.group_name,comm.reggov_code,comm.regist_date,comm.reg_gov_name,comm.comm_id as id,comm.comm_id as id2,comm.comm_id as id3
FROM community comm";
//หากเป็น TB_mng ต้องเพิ่ม id ต่อทาย 3 id เข้าไปด้วย 
$column=array("ชื่อกลุ่ม","เลขทะเบียน","วันจดทะเบียน","หน่วยงานผู้รับจดทะเบียน","รายละเอียด","แก้ไข","ลบ");//หากเป็น TB_mng ต้องเพิ่ม แก้ไข,ลบเข้าไปด้วย 
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
                $mydata->createPDO_TB_mng("comm");//ใส่ process ที่ต้องการสร้าง
                $mydata->close_PDO();
    ?>
                </div>
              </div>
          </div>
</div>
