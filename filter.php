	<?php
	//ask user about priority
	$priority="";
	while (!$priority){
		echo "\nPlease specify the priority for which you want to filter entries (minor, normal, major)\n";
		$priority=trim(fgets(STDIN));
	}
	$json=json_decode(file_get_contents("testcases.json"), TRUE);
	$teststeps=$json[1]["testcase"]["teststeps"];
	$countsteps=count($teststeps);
	$results=array();
	for ($i=1; $i<=$countsteps; $i++){
		if ($teststeps[$i]["priority"]==$priority) {
			$results[]=$teststeps[$i];
		}
	}
	print_r($results);
	file_put_contents("results.json",json_encode($results,JSON_HEX_QUOT));
	//checking errors	
	switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo "\nJSON-file with results is succesfully created.\n";
        break;
        default:
            echo "\nDuring creating JSON-file error was occurred.\n";
        break; 
	}
	?>
