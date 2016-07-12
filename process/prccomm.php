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
            print_r($add_comm);
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
        }elseif ($method == 'edit_person') {
            $person_id=filter_input(INPUT_POST, 'edit_id',FILTER_SANITIZE_NUMBER_INT);
            if (trim($_FILES["image"]["name"] != "")) {
                include 'class/file_upload.php';
                $upload = new File_Upload("image", "logo");
                $image = $upload->upload();
                
                $data = array($_POST['member_no'], $_POST['cid'], $_POST['pname'],
                $_POST['fname'], $_POST['lname'], $_POST['sex'], $_POST['birth'],$_POST['user_type'],
                $_POST['mstatus'], $_POST['member_status'],  $_POST['regist_date'],
                $image);
                $field=array("member_no","cid","pname_id","fname","lname", "sex", "birth","user_type", "mstatus_id", "mem_status_id",
                "regist_date", "photo");
            } else {
                $image = '';
                
                $data = array($_POST['member_no'], $_POST['cid'], $_POST['pname'],
                $_POST['fname'], $_POST['lname'], $_POST['sex'], $_POST['birth'],$_POST['user_type'],
                $_POST['mstatus'], $_POST['member_status'],  $_POST['regist_date']);
                $field=array("member_no","cid","pname_id","fname","lname","sex","birth","user_type","mstatus_id","mem_status_id",
                "regist_date");
            }
            
            $table = "person";
            $where="person_id=:person_id";
            $execute=array(':person_id' => $person_id);
            $edit_person=$mydata->update($table, $data, $where, $field, $execute);

            if ($edit_person=false) {
                echo "<span class='glyphicon glyphicon-remove'></span>";
                echo "<a href='index.php?page=content/add_person' >กลับ</a>";
            } else {
                              
                     $data = array($_POST['hourseno'], $_POST['village'],
                    $_POST['moo'], $_POST['district'], $_POST['amphur'], $_POST['province'],
                    $_POST['post'], $_POST['tel'], $_POST['email'],$_SESSION['user'], $date->format('Y-m-d H:m:s'));
                $table = "address";
                $field=array("hourseno","village","moo","district","amphur","province","post","tel","email","updater","d_update");
                $where="person_id=:person_id";
                $execute=array(':person_id' => $person_id);
                $edit_address = $mydata->update($table, $data, $where, $field, $execute);
                
                if ($edit_address=false) {
                    echo "<span class='glyphicon glyphicon-remove'></span>";
                    echo "<a href='index.php?page=content/add_person' >กลับ</a>";
                } else {
                   echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_person'>";
                }
            }
        }
    } elseif (null !== (filter_input(INPUT_GET, 'method'))) {
        $method = filter_input(INPUT_GET, 'method');
        if($method=='delete_person') {
            $delete_id=filter_input(INPUT_GET, 'del_id');
            $table="person";
            $table2="address";
            $table3="saving_account";
            $where="person_id=:delete_id";
            $execute=  array(':delete_id' => $delete_id);
            $del=$mydata->delete($table, $where , $execute);
            $del2=$mydata->delete($table2, $where, $execute);
            $del3=$mydata->delete($table3, $where, $execute);
        
        if($del&$del2&$del3==false){
        echo "<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=content/add_person&id=$delete_id' >กลับ</a>";
    } else {
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_person'>";
        }
        }
    }
    ?>
</section>