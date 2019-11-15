<!DOCTYPE html>
<!--PHP Code for the python file exec -->
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>
            Kovid Bioanalytics | Upload
        </title>
        <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Roboto:400,700"
        />
        <!-- https://fonts.google.com/specimen/Open+Sans -->
        <link rel="stylesheet" href="css/fontawesome.min.css" />
        <!-- https://fontawesome.com/ -->
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <!-- https://getbootstrap.com/ -->
        <link rel="stylesheet" href="css/templatemo-style.css">
        <!--
Product Admin CSS Template
https://templatemo.com/tm-524-product-admin
-->
    <script>
	function disableButton(btnID){
		$("#"+btnID).attr("disabled",true);
		$("#"+btnID).css("cursor","not-allowed");
$("#fastafile").attr("disbled",true);
        $("#fastafile").css("cursor","not-allowed");
        $(".loadingImage").show();
        $(".container").css("opacity","0.1");
       
		return true;
	}	
    </script>

    <style type="text/css">
        .loadingImage{
            position: absolute;
            width: 100px; /*the image width*/
            height: 100px; /*the image height*/
            left: 50%;
            top: 50%;
            margin-left: -50px; /*half the image width*/
            margin-top: -50px; /*half the image height*/
            
        }
   </style>

    </head>
    <body oncontextmenu="return false;">

    <!-- Loading image start -->
        <img src="images/loading.gif" alt="Loading..." class="loadingImage" style="z-index:1;display: none;">
    <!-- Loading image end -->

        <?php	
$output = "";
$check = 0;
$json_output="";
$final_result = "";

/*Creating multi dimensional array of haplogroup and their subclades in order to cleck whether haplogroup, retrived from python script, represents the Indian sample*/
$indian_haplo_arr = array(
    "L3" => array(
        "variants" => array(
            "A769G","A1018G","C16311T"
        ),
        "lineage" => "",
        "subclades" => array(
           "M","N" 
        ),
    ),
    "M" => array(
        "variants" => array(
            "T489C","C10400T","T14783C","G15043A"
        ),
        "lineage" => "L3",
        "subclades" => array(
            "M2","M2a'b","M2a","M2a1","M2a1a","M2a1a1","M2a1a1a","M2a1a1a1","M2a1a1b","M2a1a1b1","M2a1a2","M2a1a2a","M2a1a2a1","M2a1a2a1a","M2a1a3","M2a1a3a","M2a1a3a1","M2a1a3b","M2a1b","M2a1c","M2a2","M2a2a","M2a3","M2a3a","M2b","M2b1","M2b1a","M2b1b","M2b2","M2b3","M2b3a","M2b4","M2c","M3","M3a","M3a1","M3a1a","M3a1b","M3a2","M3a2a","M3b","M3c","M3c1","M3c1a","M3c1b","M3c1b1","M3c1b1a","M3c1b1b","M3c2","M3d","M3d1","M3d1a","M3d1a1","M4'67","M4","M4a","M4b","M65","M65a","M65a1","M65a2","M65b","M67","M5","M5a'd","M5a","M5a1","M5a1a","M5a1b","M5a2","M5a2a","M5a2a1","M5a2a1a","M5a2a1a1","M5a2a1a2","M5a2a2","M5a2a3","M5a2a4","M5a3","M5a3a","M5a3b","M5a4","M5a5","M5d","M5b'c","M5b","M5b1","M5b2","M5b2a","M5b2b","M5b2b1","M5b2b1a","M5c","M5c1","M5c2","M6","M6a","M6a1","M6a1a","M6a1b","M6a2","M6b","M8","CZ","C4a1a","C4a2c1","C5","M10","M10a","M10a1","M10a1b","M12'G","G","G2a1d2","G2a1h","G2b1b","G2b2a","G3b1","G2b2a","G3b1","M13'46'61","M13","M13a'b","M13a","M13a1","M13b","M13b1","M14","M19'53","M53","M21b2","M18'38","M18","M18a","M18b","M18c","M38","M38a","M38b","M38c","M38d","M38e","M25","M30","M30a","M30a1","M30a2","M30b","M30c","M30c","M30c1","M30c1a","M30c1a1","M30d","M30d1","M30d2","M30e","M30f","M30g","M31","M31a","M31a1","M31a1a","M31a1b","M31a2","M31b'c","M31b","M31b1","M31b2","M31c","M32a","M33","M33a","M33a1","M33a1a","M33a1b","M33a2'3","M33a2","M33a2a","M33a3","M33a3a","M33b","M33b1","M33b2","M33c","M33d","M34'57","M34","M34a","M34a1","M34a1a","M34a2","M34b","M57","M57a","M57b","M57b1","M35","M35a","M35a1","M35a1a","M35a2","M35b","M35b1","M35b2","M35b3","M35b4","M35c","M36","M36a","M36b","M36c","M36d","M36d1","M37","M37a","M37a1","M37d","M37e","M37e2","M39","M39a","M39a1","M39a2","M39b","M39b1","M39b2","M39c","M40","M40a","M40a1","M40a1a","M40a1b","M41","M41a","M41a1","M41b","M41c","M42","M42b","M42b1","M42b1a","M42b2","M43","M43a","M43a1","M43b","M44","M44a","M44a1","M45","M45a","M48","M49","M49a","M49a1","M49a2","M49c","M49c1","M49d","M49e","M49e1","M50","M50a","M50a1","M50a2","M53","M53b","M54","M55","M56","M57","M57a","M57b","M57b1","M58","M59","M60","M61","M61a","M62","M62a","M62b","M62b1","M62b1a","M62b1a1","M62b2","M63","M64","M20"
        ),
    ),
    "N" => array(
        "variants" => array(
            "G8701A","C9540T","G10398A","C10873T","A15301G!"
        ),
        "lineage" => "L3",
        "subclades" => array(
            "N1'5","N5","N5a","N22","N22a","R"
        ),
    ),
    "R" => array(
        "variants" => array(
            "T12705C","T16223C"
        ),
        "lineage" => "N",
        "subclades" => array(
            "R0","R0a'b","R0a","R0a1","R0a1a","R0a1a1","R0a1a1a","R0a1a2","R0a1a3","R0a1a4","R0a1b","R0a2'3","R0a2","R0a2a","R0a2a1","R0a2b","R0a2c","R0a2d","R0a2e","R0a2f","R0a2f1","R0a2f1a","R0a2f1b","R0a2g","R0a2h","R0a2i","R0a2j","R0a2k","R0a2k1","R0a2l","R0a2m","R0a2n","R0a3","R0a3a","R0a4","HV","HV1","HV2","H","R1","R1a","R2'JT","R2","JT","J","R5","R5a","R5a1","R5a1a","R5a2","R5a2a","R5a2b","R5a2b1","R5a2b2","R5a2b3","R5a2b4","R6","R6a","R6a1","R6a2","R6b","R7","R7a'b","R7a","R7a1","R7a1a","R7a1b","R7a1b1","R7a1b2","R7b","R7b1","R7b1a","R7b1a1","R7b2","R8","R8a","R8a1","R8a1a","R8a1a1","R8a1a1a","R8a1a1a1","R8a1a1a1a","R8a1a1a2","R8a1a1b","R8a2","R8b","R8b1","R8b1a","R8b2","R9","F","F1","F1a'c'f","F1c","F1c1","F1c1a","F1c1a1","F1c1a1a","F1c1a1b","F1c1a2","R11'B6","R11","B4a1c","B4b1a2","B5a1a","B5a1a1","R30","R30a","R30a1","R30a1a","R30a1b","R30a1b1","R30a1c","R30b","R30b1","R30b2","R30b2a","R31","R31a","R31a1","R31b","U","P"
        ),
    ),
    "U" => array(
        "variants" => array(
            "A11467G","A12308G","G12372A"
        ),
        "lineage" => "R",
        "subclades" => array(
            "U1","U1a","U5","U5a'b","U7","U7a","U2","U2a","U2b","U2c'd","U2c","U2d","U3","U4'9","U4","U8","U6","U2'3'4'7'8'9"
        ),
    ),
    "New" => array(
        "variants" => "",
        "lineage" => "",
        "subclades" => array(
            "D","D4","D4b","D4b2","D4b2a","D4b2b","D4b2b1","D4b2b4","D4b2b5","D4j","D4j1","D4j1a","D4j1b","D4j1b1","D4j1b2","D4p","D4q","D5","D5a'b","D5a","D5a2","D5a2a","D5a2b"
        ),
    )
);
if(isset($_FILES["fastafile"])){
    $check = 1;
    try{
	/*Locatin of the input file to be stored and python script to be executed*/
        $target_dir = "/home/ubuntu/mtDNA/";

	/*The input field name and name of the file which is uploading*/
        $file = $_FILES['fastafile']['name'];

	/*Path of the file with the directory name and base name and extension*/
        $path = pathinfo($file);
	
	/*Getting the filename from the path*/
        $filename = $path['filename'];

	/*Getting the file extension from the path*/
        $ext = $path['extension'];

	/*This contain the temporary file name of the file. This is just a placeholder until the file is processed*/
        $temp_name = $_FILES['fastafile']['tmp_name'];

	/*Getting the file with full path and extension*/
        $path_filename_ext = $target_dir.$filename.".".$ext;
	
	/*This function stores the user uploaded input fasta file to the defined location: $path_filename_ext */
        move_uploaded_file($temp_name,$path_filename_ext);

	/*Creating the variable of the python command to be executed to retrieve the variants list from the selected sample.*/
        $cmd = 'python3 '.$target_dir.'workflow_test.py '.$path_filename_ext.' '.$target_dir;
	
	/*HTML tag for preformatted text*/
        //$output .= "<pre>";

	/*Execute command via shell and return the complete output as a string*/
        $output = shell_exec($cmd);

	/*End of HTML tag for preformatted text*/
        //$output .= "</pre>";
	
	/*Replaces the Error text in putput with '' as Error text gets automatically appended to the output*/
        $output = str_replace('Error', '', $output);
	
	// splitting output variable by new line in order to get Total variant result and variant found result seperate
	$output_arr = explode("\n",$output);

	/*Creates array of the input variants*/
        $variant_array = [];

	/*Variable for the input haplogroup*/
        $haplogroup = "";

	/*Output file from the python code*/
        $output_file = $target_dir."vars.txt";

	/*Check whether file exist or not if exist proceed further*/
        if(file_exists($output_file)){

	/*Open the output file for read only purpose*/
            $fn = fopen($output_file,"r");

	/*Checks if pointer is not at End of File*/
            while(! feof($fn))  {

	/*Gets line from file*/
                $result = fgets($fn);

    $percentage_match = 0;
		
	/*checking whether result is empty or not, if not then only proceeding further to push those values into array else skipping the empty value*/
		if(!(empty($result))){
	
	/*Creates the array of strings seperated by tab space*/
                	$result_arr =  explode("\t",$result);
                //echo "variant: ".$result_arr[0]." ... haplogroup: ".$result_arr[1];

	/*Pushes the $result_arr[0] in $variant_array*/
                	array_push($variant_array,$result_arr[0]);

	/*Stores the first element of $result_arr in variable $haplogroup*/
                	$haplogroup = $result_arr[1];

                    $percentage_match = $result_arr[3];
		}
                //echo "<br>";
            }
	/*Closes the file*/
            fclose($fn);

	/*Creates the hash for specific haplogroup as key and $variant_array as values*/
            $variant_hash = array(
                $haplogroup=>$variant_array
            );

	/*Initializing the final_output array*/
            $final_output_arr = [];

	/*Sets the total count of $indian_haplo_arr to $indian_haplo_count*/
            $indian_haplo_count = count($indian_haplo_arr);

	/*Till each key value pair in variant_hash the loop executes*/
            foreach($variant_hash as $key=>$value){

	/*Initialize  $final_haplo_array as array*/
                $final_haplo_array = [];

	/*Key stored in varaible*/
                $input_subclade = $key;

	
	/*Returns values form single column 'subclades' of array $indian_haplo_arr*/
                $arr = array_column($indian_haplo_arr, 'subclades');
	/*Declare variable current_key*/
                $current_key = "-1";

	/*Till each key value pair in arr the loop executes. This is to check whether subclades from python script output exists into the Indian haplogroup list and if exists, retrieve it's key index in order to retrieve it's parent haplogroup*/
                foreach($arr as $k => $v){

	/*Checks the value of $v in array $input_subclade*/
                    if(in_array($input_subclade, $v)){

	/*If the above condition satisfies the value of current key becomes the value of $v and loop breaks*/
                        $current_key = $k;
                        break;
                    }    
                }

        $conclusion = "";
        $indian_origin = "";
        $var_table_check = 0;

		if($input_subclade == ""){
	           $haplo_key = "Empty";
               $conclusion_check = "Case3";
	/*If $current_key is blank the $haplo_key becomes 'Not found' which means it is not an Indian sample*/
                }else if($current_key == "-1"){
                    $haplo_key = "NotFound";
                    $conclusion_check = "Case2";
	/*If $indian_haplo_count is $current_key+1 the $haplo_key becomes 'New found' which means it is an Indian sample by not in a pre-defined list but predicted to be Indian sample by latest research*/
                }else if($indian_haplo_count == ($current_key+1)){
                    $haplo_key = "NewFound";
                    $conclusion_check = "Case1";
	/*If both the above conditions are false then else executes which means subclade found to be Indian sample*/
                }else{
                    $conclusion_check = "Case1";
	/*Return all the keys or a subset of the keys to $key_array of $indian_haplo_arr*/
                    $key_array = array_keys($indian_haplo_arr);

	/*Matches the current key from array and finds haplo_key from the ARRAY*/
                    $haplo_key = $key_array[$current_key];
                }
	/*Matches the case and executes code accordingly*/
                switch ($haplo_key) {

		    case "Empty":
		    $final_result .= "<ul>";
                    //$final_result .= "<li>Did not find any 'Indian' related haplogroup, so the sample variants does not belong to Indian origin variants.</li>";
                    $final_result .= "<li>No variants in sample are predominantly seen in Indian population. So, no haplogroup from Indian ancestry predicted.</li>";
                    $final_result .= "</ul>";
		    break;

	/*If $haplo_key is NotFound executes the $inal result below the case "NotFound": and breaks the loop*/
                    case "NotFound":
                    $final_result .= "<ul>";
                    $final_result .= "<li>The predicted haplogroup <b>".$input_subclade."</b> is not predominantly found in India.</li>";
                    $final_result .= "</ul>";
                    break;

	/*If $haplo_key is NewFound executes the $inal result below the case "NewFound": and breaks the loop*/
                    case "NewFound":
                    $final_result .= "<ul>";
                    $final_result .= "<li>Recent mtDNA studies mentions that, the haplogroup <b>".$input_subclade."</b> is found in India (with lower frequency).</li>";
                    $final_result .= "<li>Overview of the evolution of the predicted lineage L3 --> M --> ".$input_subclade."</li>";
                    $final_result .= "</ul>";
                    break;

		    case "L3":
 		    $final_result .= "<ul>";
                    $final_result .= "<li>Haplogroup predicted is <b>".$input_subclade."</b>, which is a descendant of haplogroup <b>".$haplo_key."</b> predominantly found in India.</li>";
                    $final_result .= "<li>The most common recent ancestor of the input sample is  ".$input_subclade.".</li>";
                    $final_result .= "<li>Overview of the evolution of the predicted lineage L3 --> ".$input_subclade."</li>";
                    $final_result .= "</ul>";
                    break;

	/*If $haplo_key is M executes the $inal result below the case "M": and breaks the loop*/
                    case "M":
                    $final_result .= "<ul>";
                    $final_result .= "<li>Haplogroup predicted is <b>".$input_subclade."</b>, which is sublineage of haplogroup <b>".$haplo_key."</b> predominantly found in India.</li>";
                    $final_result .= "<li>The most common recent ancestor of the input sample is  ".$input_subclade.".</li>";
                    $final_result .= "<li>Overview of the evolution of the predicted lineage L3 --> ".$haplo_key." --> ".$input_subclade."</li>";
                    $final_result .= "</ul>";
                    break;

	/*If $haplo_key is N executes the $inal result below the case "N": and breaks the loop*/
                    case "N":
                    $final_result .= "<ul>";
                    $final_result .= "<li>Haplogroup predicted is <b>".$input_subclade."</b>, which is sublineage of haplogroup <b>".$haplo_key."</b> predominantly found in India.</li>";
                    $final_result .= "<li>The most common recent ancestor of the input sample is  ".$input_subclade.".</li>";
                    $final_result .= "<li>Overview of the evolution of the predicted lineage L3 --> ".$haplo_key." --> ".$input_subclade."</li>";
                    $final_result .= "</ul>";
                    break;

	/*If $haplo_key is R executes the $inal result below the case "R": and breaks the loop*/
                    case "R":
                    $final_result .= "<ul>";
                    $final_result .= "<li>Haplogroup predicted is <b>".$input_subclade."</b>, which is sublineage of haplogroup <b>".$haplo_key."</b> predominantly found in India.</li>";
                    $final_result .= "<li>The most common recent ancestor of the input sample is  ".$input_subclade.".</li>";
                    $final_result .= "<li>Overview of the evolution of the predicted lineage L3 --> N --> ".$haplo_key." --> ".$input_subclade."</li>";
                    $final_result .= "</ul>";
                    break;

	/*If $haplo_key is U executes the $inal result below the case "U": and breaks the loop*/
                    case "U":
                    $final_result .= "<ul>";
                    $final_result .= "<li>Haplogroup predicted is <b>".$input_subclade."</b>, which is sublineage of haplogroup <b>".$haplo_key."</b> predominantly found in India.</li>";
                    $final_result .= "<li>The most common recent ancestor of the input sample is  ".$input_subclade.".</li>";
                    $final_result .= "<li>Overview of the evolution of the predicted lineage L3 --> N --> R --> ".$haplo_key." --> ".$input_subclade."</li>";
                    $final_result .= "</ul>";
                    break;

                }

                // switch case for conclusion and indian origin check
                switch($conclusion_check){
                    case "Case1":
                        $var_table_check = 1;
                        $conclusion = "A total $percentage_match% sample variants are predominantly seen in Indian population, and the predicted haplogroup shows Indian ancestry.";
                        $indian_origin = "Yes";
                        break;

                    case "Case2":
                        $var_table_check = 1;
                        $conclusion = "Although $percentage_match% sample variants are predominantly seen in Indian population, the predicted haplogroup does not show Indian ancestry.";
                        $indian_origin = "No";
                        break;

                    case "Case3":
                        $var_table_check = 0;
                        $conclusion = "No sample variants from Indian population/ancestry found.";
                        $indian_origin = "No";
                        break;
                }
            }

	/*If the file does not exist the "file not found" will be printed*/
        }else{
            echo "file not found";
        }
    }catch(Exception $e){
        echo "Exception: ".$e->getMessage();
    }
}

/*Returns values from specified key within the multidimensional  array */
/*function array_column(array $input, $columnKey, $indexKey = null) {
    $array = array();
    foreach ($input as $value) {
        if ( !array_key_exists($columnKey, $value)) {
            trigger_error("Key \"$columnKey\" does not exist in array");
            return false;
        }
        if (is_null($indexKey)) {
            $array[] = $value[$columnKey];
        }
        else {
            if ( !array_key_exists($indexKey, $value)) {
                trigger_error("Key \"$indexKey\" does not exist in array");
                return false;
            }
            if ( ! is_scalar($value[$indexKey])) {
                trigger_error("Key \"$indexKey\" does not contain scalar value");
                return false;
            }
            $array[$value[$indexKey]] = $value[$columnKey];
        }
    }
    return $array;
}*/
$html_text = "<div class='modal-body' style='display: block'>
                            <font style='font-size: 17px;' id=''><b>".$output_arr[1]."</b></font>
                            <br>";

            if($var_table_check){

              $html_text .= "<div class='row' style='margin-top: 15px;margin-bottom: 15px;'>
                                <div class='col-md-12 col-sm-12 col-sm-12 col-xs-12' id=''>
                                    <table border='1' style='border-collapse: collapse;width: 100%;'>
                                        <thead>
                                            <tr>
                                                <th style='text-align: center;'>Variant</th>
                                                <th style='text-align: center;'>Reference Nucleotide</th>
                                                <th style='text-align: center;'>Sample Nucleotide</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                                              
                                        for($i = 0; $i < sizeof($variant_array);$i++){
                                            $variant = $variant_array[$i];

                                            // getting the reference Nucleotide which is the first character of $variant string
                                            $ref_nucleotide = substr($variant,0,1);

                                            // getting the sample Nucleotide which is the last character of $variant string
					    $sam_nucleotide = preg_replace('/[0-9]+/', '', substr($variant,1));

                             $html_text .= "<tr>
                                                <td style='text-align: center;'>".$variant."</td>
                                                <td style='text-align: center;'>".$ref_nucleotide."</td>
                                                <td style='text-align: center;'>".$sam_nucleotide."</td>
                                            </tr>";
 
                                                }
                                            
                        $html_text .= "</tbody>
                                    </table>
                                </div>
                            </div>";
                            
                                }else{
                            
                        $html_text .= "<br>";
                              
                                }
                            
                $html_text .= "<font style='font-size: 17px;' id=''><b>".$output_arr[0]."</b></font>
                            <br>
                            <br>
                            <font style='font-size: 17px;' id=''><b>Haplogorup:</b></font>
                            <br>
                            <font style='font-size: 17px;' id=''>".$final_result."</font>
                            <font style='font-size: 17px;' id=''><b>Conclusion:</b></font>
                            <br>
                            <font style='font-size: 17px;' id=''>".$conclusion."</font>
                            <br>
                            <br>
                            <font style='font-size: 17px;' id=''><b>Indian Origin:</b> ".$indian_origin."</font>
                        </div>";
        ?>
        <!-- Modal to Display Output -->
        <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="display: block">
                        <center>
                            <h4 class="modal-title">
                                <b>
                                    Report for '<?php echo $filename.".".$ext;?>'
                                </b>
                            </h4>
                        </center>
                    </div>
                    <?php echo $html_text; ?>
                    <div class="modal-footer"style="display: block">
                        <form action="print_report.php" method="POST">
                        <textarea hidden="hidden" name="html_text"><?php echo htmlentities($html_text);?></textarea>
                        <input type="hidden" name="file_name" value="<?php echo $filename;?>">
                        <input type="hidden" name="file_ext" value="<?php echo $ext;?>">
                        <center>
                            <button type="button" class="btn btn-default" onclick="window.location=''">Close</button>&nbsp;&nbsp;
                            <button type="submit" class="btn btn-success" id="printBtnID">Download</button>
                        </center>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- End Of Modal to Display Output -->
        <div class="container tm-mt-big tm-mb-big">
            <div class="row" style="
margin-top: 12%;">
    <div class="col-12 mx-auto tm-login-col">
        <div class="tm-bg-primary-dark tm-block tm-block-h-auto" style="padding-bottom: 10px;">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="tm-block-title mb-4">
                        Upload file here
                    </h2>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <form method="post" class="tm-login-form" onsubmit="return disableButton('uploadfile');" enctype="multipart/form-data">
                        <div class="form-group">
                            <p class="text-center text-white mb-0 px-4 small">
                                <b>
                                    Note* : Only .fasta, .fa & .fastq file is allowed
                                </b>
                            </p>
                        </div>
                        <div class="form-group">
                            <p id="error1" style="display:none; color:#FF0000; text-align: center;">
                                <b>
                                    Invalid file format. File must be either fasta or fastq file.
                                </b>
                            </p>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary btn-block text-uppercase" type="file" name="fastafile" id="fastafile" required>
                        </div>
                        <div class="form-group">
                            <input  class="mt-2 btn btn-primary btn-block text-uppercase" type="submit" value="Upload File" name="submit" id='uploadfile'>
                        </div>
                        <button data-toggle="modal" type="button" data-target="#myModal" id="hdBTNID" style="display:none;">Maaaaa</button>
                        <div class="col-12 font-weight-light mt-5">
                            <p class="text-center text-white mb-0 px-4 small">
                                Copyright &copy; 
                                <b>
                                    2019
                                </b>
                                All rights reserved. 
                                <br>
                                Powered by: 
                                <a target= '_blank' rel="nofollow noopener" href="https://kovidbioanalytics.com" class="tm-footer-link"><b>
                                    Kovid BioAnalytics 
                                    <sup>&reg;</sup>
                                    </b></a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
            </div>
        </div>
        <script src="js/jquery-3.3.1.min.js"></script>
        <!-- https://jquery.com/download/ -->
        <script src="js/bootstrap.min.js"></script>
        <!--Script ot check file type -->	
        <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
        <script>

            $('input[type="submit"]').prop("disabled", true);
            var a=0;
            //binds to onchange event of your input field
            $('#fastafile').bind('change', function() {
                if ($('input:submit').attr('disabled',false)){
                    $('input:submit').attr('disabled',true);
                }
                var ext = $('#fastafile').val().split('.').pop().toLowerCase();
console.log(ext);
                if ($.inArray(ext, ['fasta']) == 0 || $.inArray(ext, ['fastq']) == 0
			|| $.inArray(ext, ['fa']) == 0){
                    $('#error1').slideUp("slow");
                    //$('#fastafile').val('');
                    //$('input:submit').attr('disabled',false);
                    a=1;
		    if (a==1){
                        $('input:submit').attr('disabled',false);
                    }

                }
                else{
                    a=0;
                    $('#error1').slideDown("slow");
		    $('#fastafile').val('');
                }
            }
                                );
            <?php
/*Checking whether python script executed successfully or not by checking value of variable $check(1='Successful execution' 0='Unsuccessful execution') and depending upon this displaying the modal of output*/
if($check == 1){
            ?>
            $(document).ready(function(){
                $("#hdBTNID").click();
            }
                             );
            <?php
}
            ?>
        </script>
        <!--End of Script ot check file type -->	
        <!-- https://getbootstrap.com/ -->
    </body>
</html>
