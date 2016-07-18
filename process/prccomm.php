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
        require '../class/dbPDO_mng.php';
        $mydata= new dbPDO_mng();
        $read="../connection/conn_DB.txt";
        $mydata->para_read($read);
        $db=$mydata->conn_PDO();
    } else {
        $mydata= new dbPDO_mng();
        $read="connection/conn_DB.txt";
        $mydata->para_read($read);
        $db=$mydata->conn_PDO();
    }
    $date = new DateTime(null, new DateTimeZone('Asia/Bangkok'));//กำหนด Time zone
    if (null !== (filter_input(INPUT_POST, 'method'))) {
        $method = filter_input(INPUT_POST, 'method');
        if ($method == 'add_comm') {
            if (trim($_FILES["image"]["name"] != "")) {
                include 'class/file_upload.php';
                $upload = new File_Upload("image", "logo");
                $image = $upload->upload();
            } else {
                $image = '';
            }
            $data = array($_POST['group_name'], $_POST['hourseno'], $_POST['village'],
                $_POST['moo'], $_POST['district'], $_POST['amphur'], $_POST['province'],$_POST['post'],
                $_POST['tel'], $_POST['email'], $_POST['reggov_code'],$_POST['regist_date'],$_POST['reg_gov_name'],
                $_POST['authorized_person'],$image,$_POST['url'],$date->format('Y-m-d H:m:s'),$_SESSION['user']);
            $table = "community";
            $add_comm = $mydata->insert($table, $data);
            if ($add_comm = false) {
                echo "<span class='glyphicon glyphicon-remove'></span>";
                echo "<a href='index.php?page=content/add_comm' >กลับ</a>";
            } else {
                $sql = "select comm_id from community order by comm_id desc limit 1";
                $mydata->imp_sql($sql);
                $comm_id = $mydata->select('');
               
                $data = array($comm_id[0]['comm_id'], $_POST['budget'], 0,0);
                $table = "budget";
                $budget = $mydata->insert($table, $data);
                
                if ($budget=false) {
                    echo "<span class='glyphicon glyphicon-remove'></span>";
                    echo "<a href='index.php?page=content/add_comm' >กลับ</a>";
                } else {
                    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_comm'>";
                }
            }
        }elseif ($method == 'edit_comm') {
            $comm_id=filter_input(INPUT_POST, 'edit_id',FILTER_SANITIZE_NUMBER_INT);
            if (trim($_FILES["image"]["name"] != "")) {
                include 'class/file_upload.php';
                $upload = new File_Upload("image", "logo");
                $image = $upload->upload();
                
                $data = array($_POST['group_name'], $_POST['hourseno'], $_POST['village'],
                $_POST['moo'], $_POST['district'], $_POST['amphur'], $_POST['province'],$_POST['post'],
                $_POST['tel'], $_POST['email'], $_POST['reggov_code'],$_POST['regist_date'],$_POST['reg_gov_name'],
                $_POST['authorized_person'],$image,$_POST['url'],$date->format('Y-m-d H:m:s'),$_SESSION['user']);
                $field=array("group_name","hourseno","village","moo","district", "amphur", "province","post", "tel", 
                    "email","reggov_code","regist_date","reg_gov_name","authorized_person", "logo","url","d_update","updater");
            } else {
                $image = '';
                
                $data = array($_POST['group_name'], $_POST['hourseno'], $_POST['village'],
                $_POST['moo'], $_POST['district'], $_POST['amphur'], $_POST['province'],$_POST['post'],
                $_POST['tel'], $_POST['email'], $_POST['reggov_code'],$_POST['regist_date'],$_POST['reg_gov_name'],
                $_POST['authorized_person'],$_POST['url'],$date->format('Y-m-d H:m:s'),$_SESSION['user']);
                $field=array("group_name","hourseno","village","moo","district", "amphur", "province","post", "tel", 
                    "email","reggov_code","regist_date","reg_gov_name","authorized_person","url","d_update","updater");
            }
            
            $table = "community";
            $where="comm_id=:comm_id";
            $execute=array(':comm_id' => $comm_id);
            $edit_comm=$mydata->update($table, $data, $where, $field, $execute);

            if ($edit_comm=false) {
                echo "<span class='glyphicon glyphicon-remove'></span>";
                echo "<a href='index.php?page=content/add_comm' >กลับ</a>";
            } else {
                              
                     $data = array($comm_id, $_POST['budget']);
                $table = "budget";
                $field=array("comm_id","budget");
                $where="comm_id=:comm_id";
                $execute=array(':comm_id' => $comm_id);
                $edit_budget = $mydata->update($table, $data, $where, $field, $execute);
                
                if ($edit_budget=false) {
                    echo "<span class='glyphicon glyphicon-remove'></span>";
                    echo "<a href='index.php?page=content/add_comm' >กลับ</a>";
                } else {
                   echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_comm'>";
                }
            }
        }
    } elseif (null !== (filter_input(INPUT_GET, 'method'))) {
        $method = filter_input(INPUT_GET, 'method');
        if($method=='delete_comm') {
            $delete_id=filter_input(INPUT_GET, 'del_id');
            $table="community";
            $table2="budget";
            $where="comm_id=:comm_id";
            $execute=  array(':comm_id' => $delete_id);
            $del=$mydata->delete($table, $where , $execute);
            $del2=$mydata->delete($table2, $where, $execute);
        
        if($del&$del2==false){
        echo "<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=content/add_comm&id=$delete_id' >กลับ</a>";
    } else {
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_comm'>";
        }
        }
    }
    ?>
</section>