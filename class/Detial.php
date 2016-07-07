<?php

require 'DbPDO_mng.php';

class Detial extends DbPDO_mng {
    
function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
    public function create_Detial($title) {
        $this->title = $title;

        $query = $this->select('');
        $field = $this->listfield('');

        echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
        $i = 0;
        foreach ($this->title as $key => $val) {
            $title_detial = $val;
            echo "<tr>";
            echo "<td align='right' valign='middle'>" . $title_detial . "</td>";
            echo "<td align='center' valign='middle'>&nbsp;:&nbsp;</td>";
            if($this->validateDate($query[0][$field[$i]],'Y-m-d')){
                $detial=DateThai1($query[0][$field[$i]]);
            }  else {
            $detial=$query[0][$field[$i]];
             }
            echo "<td align='left' valign='middle'><b>" . $detial . "</b></td>";
            echo "</tr>";
            $i++;
        }
        echo "</table>";
    }
public function create_Detial_photo($title,$fol) {
        $this->title = $title;
        $this->fol = $fol;

        $query = $this->select('');
        $field = $this->listfield('');
        $photo_person=  $this->fol.$query[0][$field[0]]; 
        echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
        echo "<tr><td colspan='3' align='center' valign='middle'><img src='$photo_person' height='150'></td></tr>";
        echo "<tr><td colspan='3' align='center' valign='middle'>&nbsp;</td></tr>";
        $i = 0;
        array_shift($query[0]);
        array_shift($field);
        foreach ($this->title as $key => $val) {
            $title_detial = $val;
            echo "<tr>";
            echo "<td align='right' valign='middle' width='49%'>" . $title_detial . "</td>";
            echo "<td align='center' valign='middle' width='2%'>&nbsp;:&nbsp;</td>";
            if($this->validateDate($query[0][$field[$i]],'Y-m-d')){
                $detial=DateThai1($query[0][$field[$i]]);
            }  else {
            $detial=$query[0][$field[$i]];
             }
            echo "<td align='left' valign='middle' width='49%'><b>" . $detial . "</b></td>";
            echo "</tr>";
            $i++;
        }
        echo "</table>";
    }
}
