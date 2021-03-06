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
        $mydata = new EnDeCode();
        $read = "../connection/conn_DB.txt";
        $mydata->para_read($read);
        $db = $mydata->conn_PDO();
    } else {
        $mydata = new EnDeCode();
        $read = "connection/conn_DB.txt";
        $mydata->para_read($read);
        $db = $mydata->conn_PDO();
    }
    $date = new DateTime(null, new DateTimeZone('Asia/Bangkok')); //กำหนด Time zone
    if (null !== (filter_input(INPUT_POST, 'method'))) {
        $method = filter_input(INPUT_POST, 'method');
        if ($method == 'receipts') {
            $preson_id = filter_input(INPUT_POST, 'person_id');
            $money = filter_input(INPUT_POST, 'money');
            $save_date=filter_input(INPUT_POST, 'save_date');
////////////////add statement เงินออม//////////////////
            $sql = "select account_id from saving_account where person_id=$preson_id";
            $mydata->imp_sql($sql);
            $account = $mydata->select('');
            $data = array($preson_id, $account[0]['account_id'], 1, 'null', $money, $save_date
                , $date->format('Y-m-d H:m:s'), $_SESSION['user']);
            $table = "saving_repayment";
            $add_saving = $mydata->insert($table, $data);
            if (null !== filter_input(INPUT_POST, 'repay')) {
                ////////////////add statement เงินต้น//////////////////
                $loan_id = filter_input(INPUT_POST, 'loan_id');
                $repay = filter_input(INPUT_POST, 'repay');
                $data = array($preson_id, null, 2, $loan_id, $repay, $save_date
                    , $date->format('Y-m-d H:m:s'), $_SESSION['user']);
                $table = "saving_repayment";
                $add_repay = $mydata->insert($table, $data);
                ////////////////add statement ดอกเบี่ย////////////////// 
                $witdawal = filter_input(INPUT_POST, 'witdawal');
                $data = array($preson_id, null, 3, $loan_id, $witdawal, $save_date
                    , $date->format('Y-m-d H:m:s'), $_SESSION['user']);
                $table = "saving_repayment";
                $add_witdawal = $mydata->insert($table, $data);

                if (null !== filter_input(INPUT_POST, 'fine')) {
                    ////////////////add statement ค่าปรับ//////////////////  

                    echo $fine = filter_input(INPUT_POST, 'fine');
                    $data = array($preson_id, null, 4, $loan_id, $fine, $save_date
                        , $date->format('Y-m-d H:m:s'), $_SESSION['user']);
                    $table = "saving_repayment";
                    $add_fine = $mydata->insert($table, $data);
                    
                    $total_money = $money + $repay + $witdawal + $fine;
                } else {
                    $total_money = $money + $repay + $witdawal;
                }
            } else {

                $total_money = $money;
            }

            ///////////////รายรับของกลุ่ม/////////////////
            $sql = "select comm_id from community order by comm_id desc limit 1";
            $mydata->imp_sql($sql);
            $comm_id = $mydata->select('');
            $Comm = $comm_id[0]['comm_id'];
            $sql = "select receipt from budget where comm_id=$Comm";
            $mydata->imp_sql($sql);
            $receipt = $mydata->select('');
            $receipt_money = $receipt[0]['receipt'] + $total_money;
            $data = array($receipt_money);
            $table = "budget";
            $field = array("receipt");
            $where = "comm_id=:comm_id";
            $execute = array(':comm_id' => $Comm);
            $budget = $mydata->update($table, $data, $where, $field, $execute);
            ///////////////รายการออม/////////////////////////
            $sql = "select saving_total from saving_account where person_id=$preson_id";
                $mydata->imp_sql($sql);
                $saving_total = $mydata->select('');
                $saving_total_money = $saving_total[0]['saving_total'] + $money;
                $data = array($saving_total_money);
                $table = "saving_account";
                $field = array("saving_total");
                $where = "person_id=:person_id";
                $execute = array(':person_id' => $preson_id);
                $saving_account = $mydata->update($table, $data, $where, $field, $execute);
             if((null !== filter_input(INPUT_POST, 'repay')) and ($add_repay != false)){   
            ///////////////รายการเงินกู้ของสมาชิก////////////////  
            $sql = "select loan_total from loan_account where loan_id=$loan_id";
            $mydata->imp_sql($sql);
            $loan_total = $mydata->select('');
            $loan_total_money = $loan_total[0]['loan_total'] - $repay;
            if ($loan_total_money <= 0) {
                $data = array($loan_total_money, 0);
                $field = array("loan_total", "status");
            } else {
                $data = array($loan_total_money);
                $field = array("loan_total");
            }
            $table = "loan_account";
            $where = "loan_id=:loan_id";
            $execute = array(':loan_id' => $loan_id);
            $loan_account = $mydata->update($table, $data, $where, $field, $execute);
            /////////////////รายการดอกเบี้ย///////////////////
            $sql = "select interest_total from interest where loan_id=$loan_id";
            $mydata->imp_sql($sql);
            $interest_total = $mydata->select('');
            $interest_total_money = $interest_total[0]['interest_total'] + $witdawal;
            if ($loan_total_money <= 0) {
                $data = array($interest_total_money, 0);
                $field = array("interest_total", "status");
            } else {
                $data = array($interest_total_money);
                $field = array("interest_total");
            }
            $table = "interest";
            $where = "loan_id=:loan_id";
            $execute = array(':loan_id' => $loan_id);
            $interest = $mydata->update($table, $data, $where, $field, $execute);
             }
                ?>
                <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_receipts&popup=true&popname=receipts&date=<?= $date->format('Y-m-d H:m:s')?>&id=<?php echo $mydata->sslEnc($preson_id); ?>'>
                <?php
            
        }
    } elseif ($method == 'edit_comm') {
        $comm_id = filter_input(INPUT_POST, 'edit_id', FILTER_SANITIZE_NUMBER_INT);
        if (trim($_FILES["image"]["name"] != "")) {
            include 'class/file_upload.php';
            $upload = new File_Upload("image", "logo");
            $image = $upload->upload();

            $data = array($_POST['group_name'], $_POST['hourseno'], $_POST['village'],
                $_POST['moo'], $_POST['district'], $_POST['amphur'], $_POST['province'], $_POST['post'],
                $_POST['tel'], $_POST['email'], $_POST['reggov_code'], $_POST['regist_date'], $_POST['reg_gov_name'],
                $_POST['authorized_person'], $image, $_POST['url'], $date->format('Y-m-d H:m:s'), $_SESSION['user']);
            $field = array("group_name", "hourseno", "village", "moo", "district", "amphur", "province", "post", "tel",
                "email", "reggov_code", "regist_date", "reg_gov_name", "authorized_person", "logo", "url", "d_update", "updater");
        } else {
            $image = '';

            $data = array($_POST['group_name'], $_POST['hourseno'], $_POST['village'],
                $_POST['moo'], $_POST['district'], $_POST['amphur'], $_POST['province'], $_POST['post'],
                $_POST['tel'], $_POST['email'], $_POST['reggov_code'], $_POST['regist_date'], $_POST['reg_gov_name'],
                $_POST['authorized_person'], $_POST['url'], $date->format('Y-m-d H:m:s'), $_SESSION['user']);
            $field = array("group_name", "hourseno", "village", "moo", "district", "amphur", "province", "post", "tel",
                "email", "reggov_code", "regist_date", "reg_gov_name", "authorized_person", "url", "d_update", "updater");
        }

        $table = "community";
        $where = "comm_id=:comm_id";
        $execute = array(':comm_id' => $comm_id);
        $edit_comm = $mydata->update($table, $data, $where, $field, $execute);

        if ($edit_comm = false) {
            echo "<span class='glyphicon glyphicon-remove'></span>";
            echo "<a href='index.php?page=content/add_comm' >กลับ</a>";
        } else {

            $data = array($comm_id, $_POST['budget']);
            $table = "budget";
            $field = array("comm_id", "budget");
            $where = "comm_id=:comm_id";
            $execute = array(':comm_id' => $comm_id);
            $edit_budget = $mydata->update($table, $data, $where, $field, $execute);

            if ($edit_budget = false) {
                echo "<span class='glyphicon glyphicon-remove'></span>";
                echo "<a href='index.php?page=content/add_comm' >กลับ</a>";
            } else {
                echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_comm'>";
            }
        }
    } elseif (null !== (filter_input(INPUT_GET, 'method'))) {
        $method = filter_input(INPUT_GET, 'method');
        if ($method == 'delete_comm') {
            $delete_id = filter_input(INPUT_GET, 'del_id');
            $table = "community";
            $table2 = "budget";
            $where = "comm_id=:comm_id";
            $execute = array(':comm_id' => $delete_id);
            $del = $mydata->delete($table, $where, $execute);
            $del2 = $mydata->delete($table2, $where, $execute);

            if ($del & $del2 == false) {
                echo "<span class='glyphicon glyphicon-remove'></span>";
                echo "<a href='index.php?page=content/add_comm&id=$delete_id' >กลับ</a>";
            } else {
                echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_comm'>";
            }
        }
    }
    ?>
</section>