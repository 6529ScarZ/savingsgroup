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
        require '../class/EnDeCode.php';
        $mydata= new EnDeCode();
        $read="../connection/conn_DB.txt";
        $mydata->para_read($read);
        $db=$mydata->conn_PDO();
    } else {
        $mydata= new EnDeCode();
        $read="connection/conn_DB.txt";
        $mydata->para_read($read);
        $db=$mydata->conn_PDO();
    }
    $date = new DateTime(null, new DateTimeZone('Asia/Bangkok'));//กำหนด Time zone
    if (null !== (filter_input(INPUT_POST, 'method'))) {
        $method = filter_input(INPUT_POST, 'method');
        if ($method == 'add_user'){
            $username=  trim(md5(filter_input(INPUT_POST,'user_account')));
            $pass_word=  trim(md5(filter_input(INPUT_POST,'user_pwd')));
        $data=array($username,$pass_word,$_POST['user_account'],$_POST['name'],$_POST['admin']);
        $table="member";
        $check_user=$mydata->insert($table, $data);
        if($check_user=false){
        echo "<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='?page=content/add_User&ss_id=".$_POST['name']."' >กลับ</a>";
    } else {
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=?page=content/add_User'>";
        }
        }elseif ($method == 'update_user'){
        if(!empty($_POST['user_pwd'])){
            $username=  trim(md5($_POST['user_account']));
            $pass_word=  trim(md5($_POST['user_pwd']));
        $data=array($username,$pass_word,$_POST['user_account'],$_POST['name'],$_POST['admin']);
        $table="member";
        $where="UserID=:UserID";
        $execute=array(':UserID' => $_POST['id']);
        $check_user=$mydata->update($table, $data, $where, '', $execute);
        }else{
            $username=  trim(md5($_POST['user_account']));
        $data=array($username,$_POST['user_account'],$_POST['name'],$_POST['admin']);
        $table="member";
        $where="UserID=:UserID";
        $execute=array(':UserID' => $_POST['id']);
        $field=array("Username","user_name","Name","Status","user_type");
        $check_user=$mydata->update($table, $data, $where, $field, $execute);  
        }
        if($check_user=false){
        echo "<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='?page=content/add_User&ss_id=".$_POST['name']."' >กลับ</a>";
    } else {
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=?page=content/add_User'>";
        }
    }
        
    } elseif (null !== (filter_input(INPUT_GET, 'method'))) {
        $method = filter_input(INPUT_GET, 'method');
        $del_id=  filter_input(INPUT_GET, 'del_id');
        $delete_id=$mydata->sslDec($del_id);
        if($method=='delete_user') {
        $table="member";
        $where="UserID=:UserID";
        $execute=  array(':UserID' => $delete_id);
        $del=$mydata->delete($table, $where, $execute);
        if($del=false){
        echo "<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='?page=content/add_User&id=".$delete_id."' >กลับ</a>";
    } else {
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=?page=content/add_User'>";
        }
    }
    }
    ?>
</section>