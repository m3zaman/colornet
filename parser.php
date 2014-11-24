<?php
	function arrayInd($arr, $val){
		for($x = 0; $x<count($arr); $x++){
			if($val == $arr[$x])
				return $x;
		}
	}

	$nodes = array();
	$edges = array();

	$lines = file("colors.csv");
	for($i=0; $i<count($lines); $i++){
		$temp = explode(",", $lines[$i]);
		for($j=0; $j<count($temp); $j++){
			if(trim($temp[$j])!="" && !in_array(trim($temp[$j]),$nodes)){
				array_push($nodes, trim($temp[$j]));
			}
		}
	}
	
	$nodestr = "";
	for($i=0; $i<count($nodes); $i++){
		$nodestr .= nl2br(chr(9)."node\n".chr(9)."[\n".chr(9).chr(9)."id $i\n".chr(9).chr(9)."label ".$nodes[$i]."\n".chr(9)."]\n");
	}
	
	for($i=0; $i<count($nodes); $i++){
		for($j=0; $j<count($lines); $j++){
			if(strpos($lines[$j], $nodes[$i]) !== false){
				$temp = explode(",",$lines[$j]);
				for($k=0; $k<count($temp); $k++){
					if($nodes[$i] != trim($temp[$k]) && trim($temp[$k])!=""){
						if(array_key_exists("".$nodes[$i].trim($temp[$k]), $edges))
							$edges["".$nodes[$i].trim($temp[$k])]++;
						elseif(array_key_exists("".$nodes[$i].trim($temp[$k]), $edges))
							$edges["".trim($temp[$k]).$nodes[$i]]++;
						else
							$edges["".$nodes[$i].trim($temp[$k])] = 1;
					}
				}
			}
		}
	}

	$edgestr = "";
	foreach ($edges as $key => $value) {
		$edgestr .= nl2br(chr(9)."edge\n".chr(9)."[\n".chr(9).chr(9)."source ".arrayInd($nodes, substr($key, 0, 6))."\n".chr(9).chr(9)."target ".arrayInd($nodes, substr($key, 6, 6))."\n".chr(9).chr(9)."weight ".$value."\n".chr(9)."]\n");
	}

	echo nl2br("graph\n[\n\tdirected 0\n");
	echo nl2br($nodestr);
	echo nl2br($edgestr);
	echo "]";
?>
