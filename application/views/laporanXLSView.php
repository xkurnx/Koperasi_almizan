<?php 
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$title.'.xls');
?>
<style>
table {font-size : 12px}
</style>
<?php
echo $html_table;
?>		
