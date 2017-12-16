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
	$xml= new SimpleXMLElement($xmlfile);//getting content of xml-file
	$name = $xml->attributes();//getting name of testcase
	
	$teststeps=array();
	$teststep=array();
	$testcase=array("name"=>$name->__toString());
		
	$count=$xml->count();
	$i=0;
	do {
		//getting array for current tepstep
		$arr=array();
		$c=	$xml->teststep[$i]->__toString();
		$arr["description"]=$c;
		foreach($xml->teststep[$i]->attributes() as $a => $b){			
			$b=$b->__toString();
			$arr[$a]=$b;			
			$teststeps[$i+1]=$arr; //adding array for current teststep to array with all tepsteps
		}
		$i++;
	} while($i<$count);
	$testcase["teststeps"]=$teststeps; //adding array with all tepsteps to array with current testcase
	$testcases["testcase"]=$testcase; //adding array with current testcase to array with all testcases
	$table=array(1=>$testcases); //create grobal array with all information
	file_put_contents("testcases.json",json_encode($table,JSON_HEX_QUOT));
	//checking errors	
	switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo 'JSON-file is succesfully created.';
        break;
        default:
            echo 'During creating JSON-file error was occurred.';
        break;
    }
}
?>
