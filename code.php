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
	
	$teststeps=array();
	$teststep=array();
	$testcase=array("name"=>$name->__toString());
	$count=$xml->count();
	$i=0;
	$z='"';
	$arr=array();
	do {
		file_put_contents("testcases.json", "{",FILE_APPEND);	
		foreach($xml->teststep[$i]->attributes() as $a => $b){			
			$b=$b->__toString();
			$arr[$a]=$b;			
			$teststeps[$i]=$arr;
		}
		$i++;
	} while($i<$count);
	$testcase["teststeps"]=$teststeps;
	$testcases["testcase"]=$testcase;
	$table=array(0=>$testcases);
	file_put_contents("testcases.json",json_encode($table,JSON_HEX_QUOT));	

}

?>
