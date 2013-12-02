<?php

use StaticFunctions as f;

$array_1_8  = array(array(0, 1, 2), array(3, 4, 5), array(6, 7, 8));
$array_6_14 = array(array(6, 7, 8), array(9, 10, 11), array(12, 13, 14));

include 'classes/static_functions.php';
include 'classes/arr_double.php';

$diff_key = md5(microtime());
$switch_value = md5(microtime());

$arrays = new ArrDouble($array_1_8, $array_6_14);
$arrays->set_diff_key($diff_key);
$arrays->set_unique_value('1');
$arrays->set_switch_value($switch_value);
$arrays->key_value('set');
$arrays->compare_arrays();
$arrays->key_value('remove');
$arrays->key_value('unset');
$arrays->merge();
?>
<!doctype html>
<html>
<head>
</head>
<body>    
<style type="text/css">
   td {
       vertical-align: top;
       border:1px solid #e4e4e4;
       padding: 5px;
   }
</style>
<table>
    <tr>
        <td>Массив 1<br /><br /><?php f::dump($array_1_8); ?></td>
        <td>Массив 2<br /><br /><?php f::dump($array_6_14); ?></td>
        <td>Результат<br /><br /><?php $arrays->dump_result();; ?></td>
    </tr>
</table>
</body>
</html>
    
