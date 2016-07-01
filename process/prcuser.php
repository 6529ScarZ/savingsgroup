<section class="content">
    <?php
    echo "<p>&nbsp;</p>	";
    echo "<p>&nbsp;</p>	";
    echo "<div class='bs-example'>
	  <div class='progress progress-striped active'>
	  <div class='progress-bar' style='width: 100%'></div>
</div>";
    echo "<div class='alert alert-dismissable alert-success'>
	  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
	  <a class='alert-link' target='_blank' href='#'><center>กำลังดำเนินการ</center></a> 
</div>";
    if (isset($_POST['check']) == 'plus') {
        require '../class/db_mng.php';
        $mydata = new Db_mng();
        $mydata->read = "../connection/conn_DB.txt";
        $mydata->config();
        $mydata->conn_mysqli();
    } else {
        $mydata = new Db_mng();
        $mydata->read = "connection/conn_DB.txt";
        $mydata->config();
        $mydata->conn_mysqli();
    }
    $date = new DateTime(null, new DateTimeZone('Asia/Bangkok'));//กำหนด Time zone
    if (null !== (filter_input(INPUT_POST, 'method'))) {
        $method = filter_input(INPUT_POST, 'method');
        if ($method == 'add_user'){
            $username=  trim(md5(filter_input(INPUT_POST,'user_account')));
            $pass_word=  trim(md5(filter_input(INPUT_POST,'user_pwd')));
        $data=array($username,$pass_word,$_POST['user_account'],$_POST['name'],$_POST['admin'],$_POST['user_type']);
        $table="member";
        $check_user=$mydata->insert($table, $data);
        $mydata->close_mysqli();
        if(!$check_user){
        echo "<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=content/add_User' >กลับ</a>";
    } else {
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_User'>";
        }
        }elseif ($method == 'update_user'){
        if(!empty($_POST['user_pwd'])){
            $username=  trim(md5($_POST['user_account']));
            $pass_word=  trim(md5($_POST['user_pwd']));
        $data=array($username,$pass_word,$_POST['user_account'],$_POST['name'],$_POST['admin'],$_POST['user_type']);
        $table="member";
        $where="UserID='".$_POST['ID']."'";
        $check_user=$mydata->update($table, $data, $where, '');
        }else{
            $username=  trim(md5($_POST['user_account']));
        $data=array($username,$_POST['user_account'],$_POST['name'],$_POST['admin'],$_POST['user_type']);
        $table="member";
        $where="UserID='".$_POST['ID']."'";
        $field=array("Username","user_name","Name","Status","user_type");
        $check_user=$mydata->update($table, $data, $where, $field);  
        }
        $mydata->close_mysqli();
        if(!$check_user){
        echo "<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=content/add_User' >กลับ</a>";
    } else {
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_User&ss_id=".$_POST['name']."'>";
        }
    }
        
    } elseif (null !== (filter_input(INPUT_GET, 'method'))) {
        $method = filter_input(INPUT_GET, 'method');
        if($method=='delete_user') {
        $table="member";
        $where="UserID='".$_GET['ID']."'";
        $del=$mydata->delete($table, $where);
        if($del==false){
        echo "<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=content/add_User&id=".$_GET['id']."' >กลับ</a>";
    } else {
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_User'>";
        }
    }
    }
    ?>
</section>