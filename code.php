<?php
require_once 'json/JSON.php';
$xmlfile=0;
if ($argc<=1) {
	echo "Please enter your xml-file, e.g. php ";
	echo $argv[0];
	echo " file.xml\n";
}
else {
	$xmlfile=file_get_contents($argv[1]);
	$xml= new SimpleXMLElement($xmlfile);
	$parent=$xml->getName();
	$name = $xml->attributes();
	$child = $xml->children()->getName();
	file_put_contents("testcases.json",'[{ "'.$parent.'": { "name":"'.$name.'","'.$child.'s":[');
	//foreach($xml->testcase[0]->attributes() as $a => $b) {
	//	$pd = $z.$a.'": "'.$b.'", ';
	//	file_put_contents("testcases.json",$pd,FILE_APPEND);
	//}
	echo "\n";
	$count=$xml->count();
	$i=0;
	$z='"';
	do {
		file_put_contents("testcases.json", "{",FILE_APPEND);
		
		foreach($xml->teststep[$i]->attributes() as $a => $b){
			$str = $z.$a.'": "'.$b.'", ';
			file_put_contents("testcases.json",json_encode($str),FILE_APPEND);
		}
		file_put_contents("testcases.json", "}\n",FILE_APPEND);
		$i++;
	} while($i<$count);
	echo "\n";
	file_put_contents("testcases.json","]}}]",FILE_APPEND);
	//echo $currentxml;
	//echo "\n";
	//$json = json_encode($xml);
	//echo "\n";
	//file_put_contents("testcases.json", $json, FILE_APPEND);
}

?>
