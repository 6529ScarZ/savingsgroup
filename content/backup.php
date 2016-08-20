<?php
include 'class/conn_db.php';
include 'class/Backup.php';
////////////อ่าน text
$connDB=new read_conn();
$read="connection/conn_DB.txt";
$connDB->para_read($read);
$db=$connDB->Read_Text();
////////////connect database
$connDBi=new Conn_DB($db);
$conn_i=$connDBi->conn_mysqli();
//////////backup
$backup=new Backup();
$backup->backup_tables($conn_i,'Savings');
echo "<script>alert('การสำรองข้อมูลสำเสร็จแล้วจ้า!')</script>";
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
             include 'footer.php';
?>
