<?php  
	require_once __DIR__ . '/vendor/autoload.php';
	
	$pdf_header = "<div style='display: block;text-align: center;font-size: 26px;'>
                        <center>
                            <font>
                                <b>
                                    Report for '".$_POST['file_name'].".".$_POST['file_ext']."'
                                </b>
                            </font>
                        </center>
                    </div><hr><br><br>";	

	$html_content = $_POST["html_text"];

	$pdf_name = "Report_".$_POST['file_name'].".pdf";

	$mpdf = new \Mpdf\Mpdf();

	$mpdf->WriteHTML($pdf_header.$html_content, 2);

	$mpdf->Output($pdf_name,"D");
?>
