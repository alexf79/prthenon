<?php 
require_once '../../global.php';
require_once '../../include/functions.php';

$output = '';
$month = $_GET['month'];
$year = $_GET['year'];
	
if($month == '' && $year == '') { 
	$time = time();
	$month = date('n',$time);
    $year = date('Y',$time);
}

$date = getdate(mktime(0,0,0,$month,1,$year));
$today = getdate();
$hours = $today['hours'];
$mins = $today['minutes'];
$secs = $today['seconds'];

if(strlen($hours)<2) $hours="0".$hours;
if(strlen($mins)<2) $mins="0".$mins;
if(strlen($secs)<2) $secs="0".$secs;

$days=date("t",mktime(0,0,0,$month,1,$year));
$start = $date['wday']+1;
$name = $date['month'];
$year2 = $date['year'];
$offset = $days + $start - 1;
 
if($month==12) { 
	$next=1; 
	$nexty=$year + 1; 
} else { 
	$next=$month + 1; 
	$nexty=$year; 
}

if($month==1) { 
	$prev=12; 
	$prevy=$year - 1; 
} else { 
	$prev=$month - 1; 
	$prevy=$year; 
}

if($offset <= 28) $weeks=28; 
elseif($offset > 35) $weeks = 42; 
else $weeks = 35; 

$output .= "
<table class='cal' cellspacing='1'>
<tr>
	<td colspan='7'>
		<table class='calhead'>
		<tr>
			<td>
				<a href='javascript:navigate($prev,$prevy)'><img src='admin/calender/images/calLeft.gif'></a> 
				<a href='javascript:navigate(\"\",\"\")'><img src='admin/calender/images/calCenter.gif'></a>
				<a href='javascript:navigate($next,$nexty)'><img src='admin/calender/images/calRight.gif'></a>
			</td>
			<td align='right'>
				<div style='color:#fff;'>$name $year2</div>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tr class='dayhead'>
	<td width='7%'>Sun</td>
	<td width='7%'>Mon</td>
	<td width='7%'>Tue</td>
	<td width='7%'>Wed</td>
	<td width='7%'>Thu</td>
	<td width='7%'>Fri</td>
	<td width='7%'>Sat</td>
</tr>";

$col=1;
$cur=1;
$next=0;

for($i=1;$i<=$weeks;$i++) { 
	if($next==3) $next=0;
	if($col==1) $output.="<tr class='dayrow'>"; 
  	
	$output.="<td valign='top' onMouseOver=\"this.className='dayover'\" onMouseOut=\"this.className='dayout'\">";

	if($i <= ($days+($start-1)) && $i >= $start) {
		$output.="<div class='day'>";

		/* START CODE FOR TOOLTIP */
		$sql = "SELECT _EventName FROM " . $tbname . "_events WHERE _Status = 'S' ";
		if($cur != ""){
			$sql .= " AND EXTRACT(DAY FROM _EventDate) = ".replaceSpecialChar($cur);
		}
		if($month != ""){
			$sql .= " AND EXTRACT(MONTH FROM _EventDate) = ".replaceSpecialChar($month);
		}
		if($year != ""){
			$sql .= " AND EXTRACT(YEAR FROM _EventDate) = ".replaceSpecialChar($year);
		}
		$res = mysql_query($sql);	
		$event = "";			
		if(mysql_num_rows($res) > 0){
			$event .= "<ul>";
			while($rec = mysql_fetch_array($res)){
				$event .= "<li type='square' style='padding:5px;'>".$rec['_EventName']."</li>";
			}
			$event .= "</ul>";
		}
		/* END CODE FOR TOOLTIP */
		
		$date = $year."-".$month."-".$cur;				
		
		if($event != ""){
			if(($cur==$today[mday]) && ($name==$today[month]))
				$output .= "<b><a class='tooltip' href='events.php?date=$date'><div style='text-decoration:underline; color:#C00;'>$cur</div><span class='classic'><b>$event</b></span></a></b></div></td>";
			else
				$output .= "<b><a class='tooltip' href='events.php?date=$date'><div style='text-decoration:underline;'>$cur</div><span class='classic'>$event</span></a></b></div></td>";
		}
		else{
			if(($cur==$today[mday]) && ($name==$today[month]))
				$output .= "<span style='color:#C00'>$cur</span></div></td>";
			else
				$output .= "$cur</div></td>";
			
		}
		
		//$output .= ">$cur<span class='classic'>$event</span></b></div></a></td>";	
		//$output .= "><a rel='tooltip' title='$event'>$cur</a></b></div></td>";

		$cur++; 
		$col++; 
		
	} else { 
		$output.="&nbsp;</td>"; 
		$col++; 
	}  
	    
    if($col==8) { 
	    $output.="</tr>"; 
	    $col=1; 
    }
}

$output.="</table>";
  
echo $output;

?>
