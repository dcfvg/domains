<?php
include('fonction.php');
if(isset($_GET['idL'])) {
	$idL = $_GET['idL'];
	$echo .= '<meta http-equiv="refresh" content="10; URL=letters.php?idL='.($idL+1).'">';
}
if(!isset($_GET['idL'])) $idL = date("G")%count($lettres); // refresh on letter everyhours
//foreach ($lettres as $L1) {
	$L1 = $lettres[$idL%count($lettres)];
	echo '<h1>idL:'.$idL.'/'.count($lettres).'</h1>';
	foreach (autour($L1) as $L2) {
		if($L2 != $L1) foreach (autour($L2) as $L3) {					
			if($L3 != $L1 and $L3 != $L2) foreach (autour($L3) as $L4) {
				if($L4 != $L1 and $L4 != $L2 and $L4 != $L3) foreach (autour($L4) as $L5) {
					if($L5 != $L1 and $L5 != $L2 and $L5 != $L3 and $L5 != $L4) {
							$ndd = $L1.$L2.$L3.$L4.$L5;
							$toCheck = $ndd.'.com';
							$result = checkDomain($toCheck);
							$echo .= '<img src="cache-hd/'.$ndd.'.gif"><img src="cache/'.$ndd.'.gif"><br/>';
							imageRes($ndd,$result,true);
							imageRes($ndd,$result,false);
							$nb++;
					}
				}
			}
		}
	}
//}
echo '<h2>'.$nb.'</h2>';
echo $echo;
?>
