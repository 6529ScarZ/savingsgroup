<?php 
if (isset($_POST['check']) == 'plus') {
    session_start(); 
        require '../class/dbPDO_mng.php';
        $mydata= new DbPDO_mng();
        $read="../connection/conn_DB.txt";
        $mydata->para_read($read);
        $db=$mydata->conn_PDO();
    } else {
        $mydata= new DbPDO_mng();
        $read="connection/conn_DB.txt";
        $mydata->para_read($read);
        $db=$mydata->conn_PDO();
    }
    echo "<section class='content'>";
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
    
    $date = new DateTime(null, new DateTimeZone('Asia/Bangkok'));//กำหนด Time zone
    if (null !== (filter_input(INPUT_POST, 'method'))) {
        $method = filter_input(INPUT_POST, 'method');
        if ($method == 'add_loanAgree') {
            $data = array($_POST['person_id'], $_POST['contract_id'], $_POST['loan_number'],
                $_POST['loan_startdate'], $_POST['loan_enddate'], $_POST['loan_total'], $_POST['loan_character'],$_POST['note'],
                $_POST['bondsman_1'], $_POST['bondsman_2'], $_POST['bondsman_3'],'W',$date->format('Y-m-d H:m:s'),$_SESSION['user']);
            $table = "loan_card";
            $add_loan = $mydata->insert($table, $data);

            if ($add_loan=false) {
                echo "<span class='glyphicon glyphicon-remove'></span>";
                echo "<a href='index.php?page=content/add_loanAgreement' >กลับ</a>";
            } else {
                    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_loanAgreement'>";
                }
        }elseif ($method == 'edit_loanAgree') {
            $loan_id=filter_input(INPUT_POST, 'edit_id',FILTER_SANITIZE_NUMBER_INT);
                
            $data = array($_POST['person_id'], $_POST['contract_id'], $_POST['loan_number'],
                $_POST['loan_startdate'], $_POST['loan_enddate'], $_POST['loan_total'], $_POST['loan_character'],$_POST['note'],
                $_POST['bondsman_1'], $_POST['bondsman_2'], $_POST['bondsman_3'],'W',$date->format('Y-m-d H:m:s'),$_SESSION['user']);
            $table = "loan_card";
            $where="loan_id=:loan_id";
            $execute=array(':loan_id' => $loan_id);
            $edit_loan=$mydata->update($table, $data, $where, '', $execute);

            if ($edit_loan=false) {
                echo "<span class='glyphicon glyphicon-remove'></span>";
                echo "<a href='index.php?page=content/add_loanAgreement' >กลับ</a>";
            } else {
                   echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_loanAgreement'>";
                }
            }elseif ($method == 'comfirm_loanAgreement') {
            $loan_id=filter_input(INPUT_POST, 'loan_id',FILTER_SANITIZE_NUMBER_INT);
                
            $data = array($_POST['confirm'],$date->format('Y-m-d H:m:s'),$_SESSION['user']);
            $table = "loan_card";
            $where="loan_id=:loan_id";
            $field=array("approve","d_update","updater");
            $execute=array(':loan_id' => $loan_id);
            $edit_loan=$mydata->update($table, $data, $where, $field, $execute);
if($_POST['confirm']=='Y'){
            if ($edit_loan=false) {
                echo "<span class='glyphicon glyphicon-remove'></span>";
                echo "<a href='../content/detial_loanAgreement.php?id=$loan_id' >กลับ</a>";
            } else {
                $month= filter_input(INPUT_POST, 'month');
                $period=  filter_input(INPUT_POST, 'period');
                  $sql="select * from loan_card where loan_id=$loan_id"; 
                  $mydata->imp_sql($sql);
                  $loan_card=$mydata->select('');
                  $data=array($loan_card[0]['person_id'],$loan_card[0]['loan_id'],$loan_card[0]['loan_total'],
                      $month,$period,1);
                  $table="loan_account";
                  $add_loanAcc=$mydata->insert($table, $data);
                  $data2=array($loan_card[0]['loan_id'],$loan_card[0]['person_id'],0,1);
                  $table2="interest";
                  $add_interest=$mydata->insert($table2, $data2);
                  
                }if ($add_loanAcc &  $add_interest =false) {
                echo "<span class='glyphicon glyphicon-remove'></span>";
                echo "<a href='../content/detial_loanAgreement.php?id=$loan_id' >กลับ</a>";
            } else {
                echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=../content/detial_loanAgreement.php?kill=kill&id=$loan_id'>";
}}  else {
                echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=../content/detial_loanAgreement.php?kill=kill&id=$loan_id'>";
}
            }
    } elseif (null !== (filter_input(INPUT_GET, 'method'))) {
        $method = filter_input(INPUT_GET, 'method');
        if($method=='delete_loanAgreement') {
            $delete_id=filter_input(INPUT_GET, 'del_id');
            $table="loan_card";
            $where="loan_id=:loan_id";
            $execute=  array(':loan_id' => $delete_id);
            $del=$mydata->delete($table, $where , $execute);
        
        if($del=false){
        echo "<span class='glyphicon glyphicon-remove'></span>";
        echo "<a href='index.php?page=content/add_loanAgreement&id=$delete_id' >กลับ</a>";
    } else {
        echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_loanAgreement'>";
        }
        }
    }
    ?>
</section>