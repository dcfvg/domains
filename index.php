<?php 
include('fonction.php');
?>
<style>
@import('http://dcfvg.com/lib/css/baseline.reset.css');
* {
	margin:0;
	padding:0;
}
li {
	list-style:decimal-leading-zero;
	background:#CCC;
	padding:10px;
}
#result {
	padding-left:0;
	padding-right:50px;
}
#result p {
	font-size:12px;
	padding:20px 0 0px 60px;
}
/*#result p img {
	border:2px dotted #FFF;
}
#result p img:hover {
	border:2px dotted #00F;
}*/
#zoom {
	width:100%;
	height:250px;
}

#zoom  p {
	padding:0;
}
.num {
	margin-left:21px;
}
.num a { border:1px solid blue; padding:5px;}
 p {
	
	text-align:left;
	font-family:Arial, Helvetica, sans-serif;
	font-size:9px;
}
/*img {border:#666 1px solid;}*/
#preload {
	position:absolute;
	width:500px;
	left:-10000px;
}

a {
	text-decoration:none;
	color:#00F;
}
a:hover {
	color:#00F;
}
.Ron ,.num a:hover {
	background-color:#00F;
	color:white;
}
.explain { width:150px; position:absolute; top:50px; right:80px;}

.num .incactiv,.num .incactiv:hover {color:#e9e9e9; background-color:#FFF; border-color:#e9e9e9; }
</style>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>domains</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script language="javascript">
$(document).ready(function(){$("#result img").mouseover(function(){$("#zoom #big").attr('src','cache-hd/'+$(this).attr('id')+'.gif');})})
</script>
</head>
<body>
<div id="zoom">
<p><a href="http://domains.dcfvg.com"><img src="cache-hd/dcfvg.gif" id="big"/></a></p>

  <p class="explain">

<img src="clavier-mac.gif" /><br /><br />
Some domain names are more typed than pronounced.
  <br />  <br />
Here is all 5 char .com possible domain names using only the closest letters.

<br />
<br />
<strong><span style="color:#F00;">RED</span></strong> = already taken <br />
<strong><span style="color:#0F0;">GREEN</span></strong> = for sale <br />
<br />
<em>Note that the availability is checked once a day.</em> 
    
  <p> 
</div>
<?php
			$dossier = glob("cache/*.gif");
			$lettreCrs = "d";
			if(isset($_GET['l']))$lettreCrs = $_GET['l'];
			//$dossier = array_reverse($dossier);
			$nb = 0;
			$nbParPg = 200;
			foreach ($dossier as $key=>$filename) {
				$ndd = urlToNdd($filename);
				$nb++;
				if(substr ($ndd,0,1) == $lettreCrs) $echo .= '<a href="http://'.$ndd.'.com" target="_blank" rel="nofollow"><img id="'.$ndd.'" alt="'.$ndd.'" title="'.$ndd.'.com / last update '.date ("d F Y H:i:s", filemtime($filename)).'" src="cache/'.$ndd.'.gif" ></a>';
				//$prelad .= '<img src="cache/'.$ndd.'.gif">'; 
			}
			$lettresOrdre = range('a', 'z');
			sort ($lettresOrdre); 
			foreach ($lettresOrdre as $key=>$lettre) {
				unset($classOn);
				
				if(!array_search($lettre,$lettres)) {
					$navNum .= '<a title="this letter has not the same place on a azerty and a qwerty keyboard" href="#" class="incactiv" '.$classOn.'>'.strtoupper ($lettre).'</a> ';
				}else{
					if($lettre == $lettreCrs) $classOn ='class="Ron"';
						$navNum .= '<a href="?l='.$lettre.'" '.$classOn.'>'.strtoupper ($lettre).'</a> ';
				}
			}
	//echo '<div id="preload"><p>'.$prelad.'</p></div>';
    echo '<div id="result">
	<p class="num"> '.$navNum.'</p>
	<p>'.$echo.'</p>
	<p class="num">'.$navNum.'</p></div>';
	include('../../credit.php'); 
    ?>
</body>
</html>