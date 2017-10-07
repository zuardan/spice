<?php
$user = "root";
$pass = "";
$database = "master";

$nama_file = "Attendance_Report.xls";

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=”.$nama_file");
header("Pragma: no-cache");
header("Expires: 0");

?>

<table border="0" width="100%" cellpadding="0" cellspacing="0">
<tr>
<th width="50">No</th>
<th width="220">Project</th>
<th width="220">SF Project ID</th>
<th width="250">Name</th>
<th width="220">SF Employee ID</th>
<th width="250">Division</th>
<th width="100">Month</th>
<th width="100">Year</th>
<th width="150">Total Hours per Month</th>
</tr>


<? if ($this->sheets) { ?>
    <? foreach ($this->sheets as $sheet) { ?>
            <tr>
                <td><? $c=$c+1; echo $c?></td>
                <td align="center"><?= $sheet['Project'] ?></td>
                <td align="center"><?= $sheet['SFProjectID'] ?></td>
                <td align="center"><?= $sheet['name'] ?></td>
                <td align="center"><?= $sheet['SF_ID'] ?></td>
                <td align="center"><?= $sheet['division'] ?></td>
                <td><?= date(m, strtotime($sheet['date'])) ?></td>
                <td><?= date(Y, strtotime($sheet['date'])) ?></td>
                <td><?= $sheet['totalhour'] + number_format(($sheet['totalminute']/60), 2) ?> </td>
                
            </tr>
                
            <? }
            }?>

</table>
