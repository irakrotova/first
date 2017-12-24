<?php
require_once 'json/JSON.php';
$file="";
while (!$file){
	echo "Please enter path to your xml-file\n";
	$file=trim(fgets(STDIN));
}
	$xmlfile=file_get_contents($file);
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
            echo "JSON-file is succesfully created.\n";
        break;
        default:
            echo "During creating JSON-file error was occurred.\n";
        break; 
	}
	echo "Do you want filter teststeps? (Yes or no)\n";
	$answer=trim(fgets(STDIN));
	if($answer=="yes"|$answer=="Yes"|$answer=="y"|$answer=="Y"){
		include 'filter.php';
	}	
?>
