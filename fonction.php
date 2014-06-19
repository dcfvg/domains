<?php
$li[0] = array('a','z','e','r','t','y','u','i','o','p');
$li[1] = array('q','s','d','f','g','h','j','k','l','m');
$li[2] = array('w','x','c','v','b','n');

$lettres = array('e','r','t','y','u','i','o','p','s','d','f','g','h','j','k','l','x','c','v','b','n');
function urlToNdd($name){
	$name = str_replace("cache","",$name);
	$name = str_replace("-hd","",$name);
	$name = str_replace(".gif","",$name);
	$name = str_replace("/","",$name);
	return $name;
}
function imageRes($ndd,$libre,$hd){
	if(!$hd){
		$zoomX = 12;
		$zommY = 12;
		$decalign = 6;
		$epaisseur = 2;
		$corp = 1;
		$placeTxt = 8;
	}
	if($hd){
		$zoomX = 50;
		$zommY = 50;
		$decalign = 25;
		$epaisseur = 6;
		$corp = 2;
		$dossier = '-hd';
		
		$placeTxt = 15;
	}
	
	$y1 = 10000000;
	
	$tx = $zoomX*7;
	$ty = $zoomX*4;
	
	if($hd)$tx = $zoomX*10;
	if($hd)$ty = $zoomX*4;
	
	
	$img = imagecreate($tx,$ty);
	$blanc = imagecolorallocate ($img,255,255,255);
	$noir = imagecolorallocate ($img,0,0,0);
	$vert = imagecolorallocate($img, 40, 255, 40);
	$bleu = imagecolorallocate($img, 0, 0, 255);
	$rouge = imagecolorallocate($img, 255,0,0);
	$gris = imagecolorallocate($img, 150,150,150);
	$grisClair = imagecolorallocate($img, 200,200,200);

	imagesetthickness($img, $epaisseur);
	
	if(!$libre)$colors = array($rouge,$bleu);
	if($libre)$colors = array($vert,$bleu);
	
	$lettresNdd = str_split($ndd);
	global $lettres;

	$maxId = 0;
	
	foreach($lettresNdd as $lettre){
		$pos = lettrePos($lettre);
		$all[] = $pos[1];

	}
	
	$maxId =  max ($all);
	$minId =  max ($all);
	
	if($hd)foreach($lettres  as $lettre){ // POSER TOUTES LES LETTRES
		$pos = lettrePos($lettre);
		$ligne = $pos[0];
		$id = $pos[1];
		
		$x2 = ($id*$zoomX)+$ligne*$decalign;
		$y2 = ($ligne+1)*$zommY;
		
		imagestring($img, $corp,  $x2-1 , $y2+5, $lettre, $grisClair);
		$x1 = $x2;
		$y1 = $y2;
	}
	
	$y1 = 10000000;
	foreach($lettresNdd as $lettre){ // POSER LES TRACÉS
		
		$i++;
		$pos = lettrePos($lettre);
		
		$ligne = $pos[0];
		
		$id = $pos[1];

	
		if(!$hd)$x2 = ((($id-$maxId)+5)*$zoomX)+$ligne*$decalign;
		if($hd) $x2 = ($id*$zoomX)+$ligne*$decalign;
		
		$y2 = ($ligne+1)*$zommY;
		if($y1 < 10000 ) ImageLine ($img, $x1, $y1, $x2, $y2, $colors[$i%2]);					
		
		$x1 = $x2;
		$y1 = $y2;
	}
	
	
	if($hd)foreach($lettresNdd  as $lettre){ // POSER LES LETTRES DU NDD
		$pos = lettrePos($lettre);
		$ligne = $pos[0];
		$id = $pos[1];
		
		$x2 = ($id*$zoomX)+$ligne*$decalign;
		$y2 = ($ligne+1)*$zommY;
		
		imagestring($img, $corp,  $x2 , $y2+4, $lettre, $blanc);
		imagestring($img, $corp,  $x2-2 , $y2+6, $lettre, $blanc);
		
		imagestring($img, $corp,  $x2-2 , $y2+4, $lettre, $blanc);
		imagestring($img, $corp,  $x2, $y2+6, $lettre, $blanc);
		
		imagestring($img, $corp,  $x2-1 , $y2+5, $lettre, $noir);
		$x1 = $x2;
		$y1 = $y2;
	}
	
	
	imagesetthickness($img, $epaisseur/2);
	
	ImageLine ($img, $tx-6, $ty, $tx, $ty-12, $colors[0]);
	imagestring($img,$corp,  $tx-62 , $ty-$placeTxt, $ndd.'.com', $bleu);
	
	
	imagegif($img,'cache'.$dossier.'/'.$ndd.'.gif');

}
function autour($lettre){
	global $li;
	$pos = lettrePos($lettre);
	$ligne = $pos[0];
	$id = $pos[1];
	
	$preRes = array(
	$li[($ligne-1)][$id],
	$li[($ligne-1)][$id+1],
	
	$li[($ligne)][$id-1],
	$li[($ligne)][$id+1],
	
	$li[($ligne+1)][$id-1],
	$li[($ligne+1)][$id],
	);
	return cleanRes($preRes,$lettre);
	
} //////////////////////////////////////////////////////
function cleanRes($preRes,$lettreBase){
	foreach ($preRes as $key => $lettre) {
		if($lettre !="" 
		and $lettre !="a" 
		and $lettre !="z"
		and $lettre !="w"
		and $lettre !="q"
		and $lettre !="m"
		and $lettre != $lettreBase
		) $res[] =$lettre;
	}
	return $res;
} //////////////////////////////////////////////////////
function lettrePos($lettre){
	global $li;
	foreach ($li as $ligne => $arr) {
			$id = array_search($lettre,$arr);
			if($id)	return array($ligne,$id);
	}	
} //////////////////////////////////////////////////////
function checkDomain($domain){
		
		$server = "whois.verisign-grs.com";
		$findText = 'No match for';
		
        // Open a socket connection to the whois server
       	$con = fsockopen($server, 43);
        if (!$con) return false;
        
        // Send the requested doman name
        fputs($con, "=".$domain."\r\n");
        
        // Read and store the server response
        $response = ' :';
        while(!feof($con)) {
           $response .= fgets($con,128); 
        }
        
		//echo $response;
        // Close the connection
        fclose($con);
        // Check the response stream whether the domain is available
        if (strpos($response, $findText)){
            return true;
        }
		
} //////////////////////////////////////////////////////
?>