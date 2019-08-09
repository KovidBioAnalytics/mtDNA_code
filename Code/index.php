<!DOCTYPE html>
<!--PHP Code for the python file exec -->


<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Kovid Bioanalytics | Upload</title>
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
	
  </head>

  <body oncontextmenu="return false;">
  
  <?php	
		$output = "";
		$check = 0;
		if(isset($_FILES["fastafile"])){
			$check = 1;
		// Where the file is going to be stored
        try{
		
                //$target_dir = "/usr/local/mtDNATest/";
				$target_dir = "/upload";
                $file = $_FILES['fastafile']['name'];
                $path = pathinfo($file);
                $filename = $path['filename'];
                $ext = $path['extension'];
                $temp_name = $_FILES['fastafile']['tmp_name'];
                $path_filename_ext = $target_dir.$filename.".".$ext;

                move_uploaded_file($temp_name,$path_filename_ext);

                //$cmd = 'python3 '.$target_dir.'workflow_test.py '.$path_filename_ext.' '.$target_dir;
				$cmd = 'ipconfig';
                $output .= "<pre>";
                $output .= shell_exec($cmd);
                $output .= "</pre>";
				
        }catch(Exception $e){
                echo "Exception: ".$e->getMessage();
        }
		}
		?>
  
  <!-- Modal to Display Output -->
	<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="display: block">
		  <center><h4 class="modal-title"><b>OUTPUT</b></h4></center>
        </div>
        <div class="modal-body" style="display: block">
			<center><font style="font-size: 18px;font-color: green;" id="fontID"><?php echo $output;?></font></center>
        </div>
        <div class="modal-footer"style="display: block">
          <center><button type="button" class="btn btn-default" onclick="window.location=''">Close</button></center>
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
                <h2 class="tm-block-title mb-4">Upload file here</h2>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-12">
                <form method="post" class="tm-login-form" enctype="multipart/form-data">
					<div class="form-group">
						<p class="text-center text-white mb-0 px-4 small"><b>Note* : Only .fasta file is allowed</b></p>
					</div>
					<div class="form-group">
						<p id="error1" style="display:none; color:#FF0000; text-align: center;">
							<b>Invalid file format. File must be fasta file.</b>
						</p>
					</div>
					<div class="form-group">
						<input class="btn btn-primary btn-block text-uppercase" type="file" name="fastafile" id="fastafile" required>
					</div>
					<div class="form-group">
						<input  class="mt-2 btn btn-primary btn-block text-uppercase" type="submit" value="Upload File" name="submit" id='uploadfile'>
					</div>
					
					<button data-toggle="modal" data-target="#myModal" id="hdBTNID" style="display:none;">Maaaaa</button>
					
					<div class="col-12 font-weight-light mt-5">
						<p class="text-center text-white mb-0 px-4 small">
						  Copyright &copy; <b>2019</b> All rights reserved. 
						  
						  <br>Powered by: <a target= '_blank' rel="nofollow noopener" href="https://kovidbioanalytics.com" class="tm-footer-link"><b>Kovid BioAnalytics <sup>&reg;</sup></b></a>
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
if ($.inArray(ext, ['fasta']) == -1){
	$('#error1').slideDown("slow");
	$('#fastafile').val('');
	//$('input:submit').attr('disabled',false);
	a=0;
	}else{
	a=1;	
	$('#error1').slideUp("slow");
	if (a==1){
		$('input:submit').attr('disabled',false);
		}
	}
});

<?php
	if($check == 1){
?>
	$(document).ready(function(){
		$("#hdBTNID").click();
<?php
		if(empty($output)){
?>
	$("#fontID").css("color","red");
	$("#fontID").html("Error processing file.");
<?php
		}
?>
	});
<?php
	}
?>
</script>
<!--End of Script ot check file type -->	
    <!-- https://getbootstrap.com/ -->
  </body>
</html>
