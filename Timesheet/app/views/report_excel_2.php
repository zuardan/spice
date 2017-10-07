<?

$string .= "No\tName\tProject\tPeriod\tDays\tIDR\tTotal\n";
if (count($this->sheets) > 0) {
    foreach ($this->sheets as $value) {
        $project = $value['project'];

        unset($strings);
		$c = $c+1;
        $strings[] = $c;
        $strings[] = $this->employee[$value['NIK']]['name'];
        $strings[] = $this->projectResult[$value['projectID']]['Project'];		
		IF($value['period'] == '1'){ $months = 'Jan';}
		IF($value['period'] == '2'){ $months = 'Feb';}
		IF($value['period'] == '3'){ $months = 'Mar';}
		IF($value['period'] == '4'){ $months = 'Apr';}
		IF($value['period'] == '5'){ $months = 'May';}
		IF($value['period'] == '6'){ $months = 'Jun';}
		IF($value['period'] == '7'){ $months = 'Jul';}
		IF($value['period'] == '8'){ $months = 'Aug';}
		IF($value['period'] == '9'){ $months = 'Sep';}
		IF($value['period'] == '10'){ $months = 'Oct';}
		IF($value['period'] == '11'){ $months = 'Nov';}
		IF($value['period'] == '12'){ $months = 'Dec';}			
        $strings[] = $months.' '.$value['year'];
		$strings[] = $value['days'];
        $strings[] = $array[$value['projectID']]['total'] = ($this->projectResult[$value['projectID']]['value'] * $value['days']);
//        $strings[] = $this->approverID[$value['approve_id']]['name'];
 //       $strings[] = date('d-m-Y', strtotime($value['approve_date']));
        //  if ($project == $value['project']) {
        $strings[] = array_sum($this->subtotal[$value['projectID']]['subtotal']);
        // }

        $string .= implode("\t", $strings);
        $string .= "\n";
    }
}



echo $string;