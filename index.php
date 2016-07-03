<?php require 'header.php';?>
<!-- Content Header (Page header) -->
    <?php
    if(isset($_SESSION['user'])){
        if(NULL !==(filter_input(INPUT_GET,'page'))){
       $page=filter_input(INPUT_GET,'page');
        require 'class/render.php';
      $render_php=new render($page);
      $render=$render_php->getRenderedPHP();
      echo $render;
    }else{?>
    
               <section class="content-header">
            <div>
              <ol class="breadcrumb">
            <!--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>-->
                  <li class="active"><i class="glyphicon glyphicon-home"></i> หน้าหลัก</li>
          </ol>  
            </div>
     </section>
<section class="content">
       <?php
    echo $_SESSION['user']."<br>";
    echo $_SESSION['fullname']."<br>";
    echo $_SESSION['Status']."<br>";
    
    //include 'connection/connect.php';
  //require 'class/db_mng.php';
    
    //$sql="select * from community";
    //$myconn->db_m($sql);
       ?>
     
</section>
    <?php }}else{?>
        

        <!-- Main content -->
<section class="content">
   <?php if($db==false){
        $check =  md5(trim('check'));
    ?>
<center>
    <h3>ยังไม่ได้ตั้งค่า Config <br>กรุณาตั้งค่า Config เพื่อเชื่อมต่อฐานข้อมูล</h3>
    <a href="#" class="btn btn-danger" onClick="return popup('set_conn_db.php?method=<?= $check?>', popup, 400, 515);" title="Config Database">Config Database</a>
    
</center> 
     <?php }?>
 NO LOGIN.           
            
</section>
    <?php }?>


<?php require 'footer.php';?>