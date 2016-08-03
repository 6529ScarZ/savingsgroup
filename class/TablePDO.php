<?php
require 'EnDeCode.php';
include 'plugins/funcDateThai.php';

class TablePDO extends EnDeCode {

    public $column;

    public function __construct($column) {
        $this->column = $column;
    }

    public function createPDO_TB() {
        $query = $this->select('');
        $field = $this->listfield('');
        $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
        echo "<div class='table-responsive'>";
        echo "<table id='example1' class='table table-bordered table-hover'>";
        echo "<thead><tr align='center' bgcolor='#898888'>";
        echo "<th align='center' width='5%'>ลำดับ</th>";
        foreach ($this->column as $key => $value) {
            echo "<th align='center'>$value</th>";
        }
        echo "</tr></thead><tbody>";
        $c = 0;
        $C = 1;
        for ($I = 0; $I < count($query); $I++) {
            $num_field = $this->count_field();
            echo "<tr class='" . $code_color[$I] . "'>";
            echo "<td align='center'>" . $C . "</td>";
            for ($i = 0; $i < ($num_field); $i++) {
               if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                                            echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                                        } else {
                                            echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
                                        }
            }
            $c++;
            $C++;
            echo "</tr>";
        }
        echo "</tbody>";
        echo "<tfoot><tr align='center' bgcolor='#898888'>";
        echo "<th align='center' width='5%'>ลำดับ</th>";
        foreach ($this->column as $key => $value) {
            echo "<th align='center'>$value</th>";
        }
        echo "</tr></tfoot></table></div>";
    }

    public function createPDO_TB_mng($process) {
        $this->process = $process;
        $query = $this->select('');
        $field = $this->listfield('');
        $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
        echo "<div class='table-responsive'>";
        echo "<table id='example1' class='table table-bordered table-hover'>";
        echo "<thead><tr align='center' bgcolor='#898888'>";
        echo "<th align='center' width='5%'>ลำดับ</th>";
        foreach ($this->column as $key => $value) {
            echo "<th align='center'>$value</th>";
        }
        echo "</tr></thead><tbody>";
        $c = 0;
        $C = 1;
        for ($I = 0; $I < count($query); $I++) {
            $num_field = $this->count_field();
            echo "<tr class='" . $code_color[$I] . "'>";
            echo "<td align='center'>" . $C . "</td>";
            for ($i = 0; $i < ($num_field); $i++) {
                if ($i < ($num_field - 3)) {
                    if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                        echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                    } else { 
                        if($i==0){?>
<td align='center'><a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c]['id']);?>', '', 'width=650,height=400');
                                return false;" title="รายละเอียด">  <?= $query[$c][$field[$i]]?></td>
                        <?php }  else {
                            echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
 }}
                } else {
                    if ($i = ($num_field - 3)) {
                        echo "<td align='center'>";
                        ?>
<a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c][$field[$i]]);?>', '', 'width=650,height=400');
                                return false;" title="รายละเอียด">     
                                <?php
                                echo "<img src='images/icon_set1/document.ico' width='25'></a></td>";
                            }
                            if ($i = ($num_field - 2)) {
                                echo "<td align='center'>"
                                . "<a href='index.php?page=content/add_" . $this->process . "&method=edit&id=" . $this->sslEnc($query[$c][$field[$i]]) . "'>"
                                . "<img src='images/icon_set1/document_edit.ico' width='25'></a></td>";
                            }
                            if ($i = ($num_field - 1)) {

                                echo "<td align='center'>";
                                ?>
                            <a href="index.php?page=process/prc<?= $this->process ?>&method=delete_<?= $this->process ?>&del_id=<?php echo $this->sslEnc($query[$c][$field[$i]]); ?>" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')">
                                <?php
                                echo "<img src='images/icon_set1/document_delete.ico' width='25'></a></td>";
                            }
                        }
                    }
                    $c++;
                    $C++;
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "<tfoot><tr align='center' bgcolor='#898888'>";
                echo "<th align='center' width='5%'>ลำดับ</th>";
                foreach ($this->column as $key => $value) {
                    echo "<th align='center'>$value</th>";
                }
                echo "</tr></tfoot></table></div>";
            }

            public function createPDO_TB_PDF($process) {
                $this->process = $process;
                $query = $this->select('');
                $field = $this->listfield('');
                $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
                echo "<div class='table-responsive'>";
                echo "<table id='example1' class='table table-bordered table-hover'>";
                echo "<thead><tr align='center' bgcolor='#898888'>";
                echo "<th align='center' width='5%'>ลำดับ</th>";
                foreach ($this->column as $key => $value) {
                    echo "<th align='center'>$value</th>";
                }
                echo "</tr></thead><tbody>";
                $c = 0;
                $C = 1;
                for ($I = 0; $I < count($query); $I++) {
                    $num_field = $this->count_field();
                    echo "<tr class='" . $code_color[$I] . "'>";
                    echo "<td align='center'>" . $C . "</td>";
                    for ($i = 0; $i < ($num_field); $i++) {
                        if ($i < ($num_field - 2)) {
                            if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                                echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                            } else {
                                echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
                            }
                        } else {
                            if ($i = ($num_field - 2)) {
                                echo "<td align='center'>";
                                ?>
                                <a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?= $query[$c][$field[$i]] ?>', '', 'width=650,height=400');
                                        return false;" title="รายละเอียด">     
                                        <?php
                                        echo "<img src='images/icon_set1/document.ico' width='25'></a></td>";
                                    }
                                    if ($i = ($num_field - 1)) {
                                        echo "<td align='center'>";
                                        ?>
                                    <a href="#" onClick="window.open('content/<?= $this->process ?>_PDF.php?id=<?= $query[$c][$field[$i]] ?>', '', 'width=550,height=700');
                                            return false;" title="รายละเอียด">     
                                        <?php
                                        echo "<img src='images/printer.ico' width='25'></a></td>";
                                    }
                                }
                            }
                            $c++;
                            $C++;
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "<tfoot><tr align='center' bgcolor='#898888'>";
                        echo "<th align='center' width='5%'>ลำดับ</th>";
                        foreach ($this->column as $key => $value) {
                            echo "<th align='center'>$value</th>";
                        }
                        echo "</tr></tfoot></table></div>";
                    }

                    public function createPDO_TB_Detial($process) {
                        $this->process = $process;
                        $query = $this->select('');
                        $field = $this->listfield('');
                        $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
                        echo "<div class='table-responsive'>";
                        echo "<table id='example1' class='table table-bordered table-hover'>";
                        echo "<thead><tr align='center' bgcolor='#898888'>";
                        echo "<th align='center' width='5%'>ลำดับ</th>";
                        foreach ($this->column as $key => $value) {
                            echo "<th align='center'>$value</th>";
                        }
                        echo "</tr></thead><tbody>";
                        $c = 0;
                        $C = 1;
                        for ($I = 0; $I < count($query); $I++) {
                            $num_field = $this->count_field();
                            echo "<tr class='" . $code_color[$I] . "'>";
                            echo "<td align='center'>" . $C . "</td>";
                            for ($i = 0; $i < ($num_field); $i++) {
                                if ($i < ($num_field - 1)) {
                                    if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                                        echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                                    } else {
                                        echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
                                    }
                                } else {
                                    if ($i = ($num_field - 1)) {
                                        echo "<td align='center'>";
                                        ?>
                                        <a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?= $query[$c][$field[$i]] ?>', '', 'width=650,height=400');
                                                return false;" title="รายละเอียด">     
                                            <?php
                                            echo "<img src='images/icon_set1/document.ico' width='25'></a></td>";
                                        }
                                    }
                                }
                                $c++;
                                $C++;
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "<tfoot><tr align='center' bgcolor='#898888'>";
                            echo "<th align='center' width='5%'>ลำดับ</th>";
                            foreach ($this->column as $key => $value) {
                                echo "<th align='center'>$value</th>";
                            }
                            echo "</tr></tfoot></table></div>";
                        }

                        public function createPDO_TB_edit($process) {
                            $this->process = $process;
                            $query = $this->select('');
                            $field = $this->listfield('');
                            $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
                            echo "<div class='table-responsive'>";
                            echo "<table id='example1' class='table table-bordered table-hover'>";
                            echo "<thead><tr align='center' bgcolor='#898888'>";
                            echo "<th align='center' width='5%'>ลำดับ</th>";
                            foreach ($this->column as $key => $value) {
                                echo "<th align='center'>$value</th>";
                            }
                            echo "</tr></thead><tbody>";
                            $c = 0;
                            $C = 1;
                            for ($I = 0; $I < count($query); $I++) {
                                $num_field = $this->count_field();
                                echo "<tr class='" . $code_color[$I] . "'>";
                                echo "<td align='center'>" . $C . "</td>";
                                for ($i = 0; $i < ($num_field); $i++) {

                                    if ($i < ($num_field - 2)) {
                                        if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                                            echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                                        } else {
                                            echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
                                        }
                                    } else {
                                        if ($i = ($num_field - 2)) {
                                            echo "<td align='center'>"
                                            . "<a href='index.php?page=content/add_" . $this->process . "&method=edit&id=" . $this->sslEnc($query[$c][$field[$i]]) . "'>"
                                            . "<img src='images/icon_set1/document_edit.ico' width='25'></a></td>";
                                        }
                                        if ($i = ($num_field - 1)) {

                                            echo "<td align='center'>";
                                            ?>
                                            <a href="index.php?page=process/prc<?= $this->process ?>&method=delete_<?= $this->process ?>&del_id=<?php echo $this->sslEnc($query[$c][$field[$i]]); ?>" onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')">
                                                <?php
                                                echo "<img src='images/icon_set1/document_delete.ico' width='25'></a></td>";
                                            }
                                        }
                                    }
                                    $c++;
                                    $C++;
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "<tfoot><tr align='center' bgcolor='#898888'>";
                                echo "<th align='center' width='5%'>ลำดับที่</th>";
                                foreach ($this->column as $key => $value) {
                                    echo "<th align='center'>$value</th>";
                                }
                                echo "</tr></tfoot></table></div>";
                            }

                            public function createPDO_TB_Head() {
                                $query = $this->select('');
                                $field = $this->listfield('');
                                $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
                                echo "<div class='table-responsive'>";
                                echo "<table id='example1' class='table table-bordered table-hover'>";
                                echo "<thead bgcolor='#898888'><tr align='center'>";
                                echo "<th align='center' width='5%' rowspan='2'>ลำดับ</th>";

                                foreach ($this->column as $key => $value) {
                                    $colspan = count($value);
                                    if ($colspan == 0) {
                                        echo "<th align='center' rowspan='2'>$key</th>";
                                    } else {
                                        echo "<th align='center' colspan='$colspan'>$key</th>";
                                    }
                                }
                                echo "</tr><tr>";
                                foreach ($this->column as $key => $value) {
                                    foreach ($value as $keys => $values) {
                                        echo "<th align='center'>$values</th>";
                                    }
                                }
                                echo "</tr></thead><tbody>";
                                $c = 0;
                                $C = 1;
                                for ($I = 0; $I < count($query); $I++) {
                                    $num_field = $this->count_field();
                                    echo "<tr class='" . $code_color[$I] . "'>";
                                    echo "<td align='center'>" . $C . "</td>";
                                    for ($i = 0; $i < ($num_field); $i++) {
                                        if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                                            echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                                        } else {
                                            echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
                                        }
                                    }
                                    $c++;
                                    $C++;
                                    echo "</tr>";
                                }
                                echo "</tbody></table></div>";
                            }
    public function createPDO_TB_ED($process) {
        $this->process = $process;
        $query = $this->select('');
        $field = $this->listfield('');
        $code_color = array("0" => "default", "1" => "success", "2" => "warning", "3" => "danger", "4" => "info");
        echo "<div class='table-responsive'>";
        echo "<table id='example1' class='table table-bordered table-hover'>";
        echo "<thead><tr align='center' bgcolor='#898888'>";
        echo "<th align='center' width='5%'>ลำดับ</th>";
        foreach ($this->column as $key => $value) {
            echo "<th align='center'>$value</th>";
        }
        echo "</tr></thead><tbody>";
        $c = 0;
        $C = 1;
        for ($I = 0; $I < count($query); $I++) {
            $num_field = $this->count_field();
            echo "<tr class='" . $code_color[$I] . "'>";
            echo "<td align='center'>" . $C . "</td>";
            for ($i = 0; $i < ($num_field); $i++) {
                if ($i < ($num_field - 2)) {
                    if ($this->validateDate($query[$c][$field[$i]], 'Y-m-d')) {
                        echo "<td align='center'>" . DateThai1($query[$c][$field[$i]]) . "</td>";
                    } else { 
                        if($i==0){?>
                        <td align='center'><a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c]['id']); ?>', '', 'width=650,height=400');
                                return false;" title="รายละเอียด">  <?= $query[$c][$field[$i]]?></td>
                        <?php }  else {
                            echo "<td align='center'>" . $query[$c][$field[$i]] . "</td>";
 }}
                } else {
                    if ($i = ($num_field - 2)) {
                        echo "<td align='center'>";
                        ?>
                        <a href="#" onClick="window.open('content/detial_<?= $this->process ?>.php?id=<?php echo $this->sslEnc($query[$c][$field[$i]]); ?>', '', 'width=650,height=400');
                                return false;" title="รายละเอียด">     
                                <?php
                                echo "<img src='images/icon_set1/document.ico' width='25'></a></td>";
                            }
                            if ($i = ($num_field - 1)) {
                                echo "<td align='center'>"
                                . "<a href='index.php?page=content/add_" . $this->process . "&method=edit&id=" . $this->sslEnc($query[$c][$field[$i]]) . "'>"
                                . "<img src='images/icon_set1/document_edit.ico' width='25'></a></td>";
                            }
                        }
                    }
                    $c++;
                    $C++;
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "<tfoot><tr align='center' bgcolor='#898888'>";
                echo "<th align='center' width='5%'>ลำดับ</th>";
                foreach ($this->column as $key => $value) {
                    echo "<th align='center'>$value</th>";
                }
                echo "</tr></tfoot></table></div>";
            }
                        }
                        