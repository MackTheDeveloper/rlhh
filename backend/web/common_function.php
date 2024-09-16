<?php
function pre($array, $no = ''){
    echo '<pre>';
    print_r($array);
    if(!$no)
    exit;
}

// MASTER ARRAY OF LANGUAGE

//$langArray = ['en'=>'English','ja'=>'Japanese'];
//pre($langArray);
?>
