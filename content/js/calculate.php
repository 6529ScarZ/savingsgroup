<?php
    $money = $_GET['money'];
    $repay = $_GET['repay'];
    $witdawal = $_GET['witdawal'];
    $fine = $_GET['fine'];
    $sum = $money+$repay+$witdawal+$fine;
    echo $sum;
?>

