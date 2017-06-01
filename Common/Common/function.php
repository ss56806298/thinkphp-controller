<?php
	function csvLoader($fileName) {
		$fileName = CSV_PATH."/".$fileName;
		$fileContent = file_get_contents("{$fileName}");
		$file = preg_replace("/\r\n|\r|\n/", "\r\n", $fileContent);
	
		$fp = tmpfile();
		fputs($fp, $file);
		fseek($fp, 0);
		
		if ($fp !== FALSE) {
			$header_array = fgetcsv($fp);
			$csv = [];
			while ($field_array = fgetcsv($fp)) {
				$csv[$field_array[0]] = array_combine($header_array, $field_array);
			}
			fclose($fp);
			return $csv;
		}
		return null;
	}
	
	function is_ajax(){
		if(!IS_AJAX){
			echo "error";	
			return false;
		}else{
			return true;	
		}
	}

	function v($var, $exit = 1){
		var_dump($var);
		if($exit){
			exit;	
		}
	}
	
	function p($arr, $exit = 1){
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
		if($exit){
			exit;	
		}
	}
?>