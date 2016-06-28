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
    if (null !== (filter_input(INPUT_POST, 'method'))) {
        $method = filter_input(INPUT_POST, 'method');
        if ($method == 'add_person') {
            if (trim($_FILES["image"]["name"] != "")) {
                include 'class/file_upload.php';
                $upload = new File_Upload("image", "photo");
                $image = $upload->upload();
            } else {
                $image = '';
            }
            $data = array($_POST['member_no'], $_POST['cid'], $_POST['pname'],
                $_POST['fname'], $_POST['lname'], $_POST['sex'], $_POST['birth'],
                $_POST['mstatus'], $_POST['member_status'], date("Y-m-d"),
                $image, $_SESSION['user'], date("Y-m-d"));
            $table = "person";
            $add_person = $mydata->insert($table, $data);
            $mydata->close_mysqli();

            if (!$add_person) {
                echo "<span class='glyphicon glyphicon-remove'></span>";
                echo "<a href='index.php?page=content/add_person' >กลับ</a>";
            } else {
                $sql = "select person_id from person order by person_id desc limit 1";
                $mydata->conn_mysqli();
                $mydata->db_m($sql);
                $person_id = $mydata->select();
                $mydata->close_mysqli();
                $data = array($person_id[0]['person_id'], $_POST['hourseno'], $_POST['village'],
                    $_POST['moo'], $_POST['district'], $_POST['amphur'], $_POST['province'],
                    $_POST['post'], $_POST['tel'], $_POST['email']);
                $table = "address";
                $mydata->conn_mysqli();
                $address = $mydata->insert($table, $data);
                $mydata->close_mysqli();
                if (!$address) {
                    echo "<span class='glyphicon glyphicon-remove'></span>";
                    echo "<a href='index.php?page=content/add_person' >กลับ</a>";
                } else {
                    echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=index.php?page=content/add_person'>";
                }
            }
        }
    } elseif (null !== (filter_input(INPUT_GET, 'method'))) {
        $method = filter_input(INPUT_GET, 'method');
    }
    ?>
</section>