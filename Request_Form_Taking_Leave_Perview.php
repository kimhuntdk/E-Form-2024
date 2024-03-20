<?php
	
//require_once('thaipdf.php');
ob_start();
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=testing.doc");
require_once( "inc/db_connect.php" );
$mysqli = connect();
//require_once('thaipdf.php');
$doc_id = base64_decode($_REQUEST[doc_id]);
/*header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=testing.doc");*/
//header("Content-type: application/vnd.ms-excel"); 
//header("Content-type: application/vnd.pdf"); 
// header('Content-type: application/csv'); //*** CSV ***// 
//header("Content-Disposition: attachment; filename=testing.xls"); 
//header("Content-Disposition: attachment; filename=Blue-Screen.pdf");

		//date_default_timezone_set("Asia/Bangkok");
		


 
		
		 $q="
			SELECT request_taking_leave.doc_id , semester , academic , because , std_signature , std_date_signature , finished_assigment , 
			unfinished_assignment , unstarting_assignment , advisor_chairman , advisor_chairman_status , advisor_chairman_signature,
			argument , advisor_chairman_date , staff_grad_node , staff_grad_approve_disapprove , dean_admin , dean_admin_approve_disapprove,dean_admin_signature,
			dean_admin_node , dean_admin_date , doc_std_id , doc_date 
			FROM request_taking_leave , request_doc WHERE request_doc.doc_id = request_taking_leave.doc_id and  request_doc.doc_id = $doc_id ";

			 $result = $mysqli->query($q);
			 $rs = $result->fetch_array();
		 
				
				$doc_id=$rs['doc_id'];
				$doc_std_id=$rs['doc_std_id'];
				$doc_date=$rs['doc_date'];
				$semester=$rs['semester'];
				$academic=$rs['academic'];
				$because= $rs['because'];
				$std_signature=$rs['std_signature'];
				$std_date_signature=$rs['std_date_signature'];
				$finished_assigment=$rs['finished_assigment'];
				$unfinished_assignment=$rs['unfinished_assignment'];
				$unstarting_assignment=$rs['unstarting_assignment'];
				$advisor_chairman=$rs['advisor_chairman'];
				$advisor_chairman_status=$rs['advisor_chairman_status'];
				$advisor_chairman_signature=$rs['advisor_chairman_signature'];
				$argument=$rs['argument'];
				$advisor_chairman_date=$rs['advisor_chairman_date'];
				$staff_grad_node=$rs['staff_grad_node'];
				$staff_grad_approve_disapprove=$rs['staff_grad_approve_disapprove'];
				$dean_admin=$rs['dean_admin'];
				$dean_admin_approve_disapprove=$rs['dean_admin_approve_disapprove'];
				$dean_admin_node=$rs['dean_admin_node'];
				$dean_admin_date=$rs['dean_admin_date'];

				



		$url = "http://202.28.34.2/webservice/JsonStudent.php?studentcode=" . $doc_std_id;
		//echo $url;
		$contents = file_get_contents($url); 
		$contents = utf8_encode($contents); 
		$results = json_decode($contents); 
		foreach ($results as $key => $value) { 
		//echo "<h2>$key</h2>";
		foreach ($value as $k => $v) { 

			$vv = $v;

			if($k=='prefixname'){
				$prefixname = $vv;
			}

			if($k=='studentname'){
				$studentname = $vv;
			}


			if($k=='studentsurname'){
				$studentsurname = $vv;
			}

			if($k=='facultyname'){
				$facultyname = $vv;
			}

			if($k=='programname'){
				$programname = $vv;
			}

			if($k=='levelname'){
				$levelname = $vv;
			}

			if($k=='campusname'){
				$campusname = "วิทยาเขต " . $vv;
			}

		}
		}			


		$studentnamex = $prefixname."".$studentname."  ".$studentsurname ; 

	$vofficercode = $advisor_chairman;

	$url = "http://202.28.34.2/webservice/JsonOfficergardtostudent.php?officercode=" . $vofficercode;
	$contents = file_get_contents($url); 
	$contents = utf8_encode($contents); 
	$results = json_decode($contents); 
	foreach ($results as $key => $value) { 
    //echo "<h2>$key</h2>";
    foreach ($value as $k => $v) { 
        $vv = $v;

			if($k=='prefixname'){
				$oprefixname = $vv;
			}

			if($k=='officername'){
				$officername = $vv;
			}


			if($k=='officersurname'){
				$officersurname = $vv;
			}
    }
	}


	$officernamex = $oprefixname."".$officername."  ".$officersurname ; 

		 $q1="
			SELECT staff_name , staff_position
			FROM  request_staff WHERE staff_id = " . $dean_admin ;
 			 $result1 = $mysqli->query($q1);
			 $rs1 = $result1->fetch_array();  
				
				$dean_adminname = $rs1['staff_name'];
				$dean_adminposition = $rs1['staff_position'];
				
			


?>




<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta charset="utf-8">
<meta name=ProgId content=Word.Document>

<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
<title>คําร้องขอลาพักการเรียน</title>
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>นางอรอนงค์  เมฆพรรณโอภาส</o:Author>
  <o:LastAuthor>diskko</o:LastAuthor>
  <o:Revision>4</o:Revision>
  <o:TotalTime>24</o:TotalTime>
  <o:LastPrinted>2017-10-27T04:49:00Z</o:LastPrinted>
  <o:Created>2018-08-15T01:58:00Z</o:Created>
  <o:LastSaved>2018-08-15T02:15:00Z</o:LastSaved>
  <o:Pages>1</o:Pages>
  <o:Words>288</o:Words>
  <o:Characters>1645</o:Characters>
  <o:Company>Registra</o:Company>
  <o:Lines>13</o:Lines>
  <o:Paragraphs>3</o:Paragraphs>
  <o:CharactersWithSpaces>1930</o:CharactersWithSpaces>
  <o:Version>15.00</o:Version>
 </o:DocumentProperties>
 <o:OfficeDocumentSettings>
  <o:TargetScreenSize>800x600</o:TargetScreenSize>
 </o:OfficeDocumentSettings>
</xml><![endif]-->

<!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:View>Print</w:View>
  <w:SpellingState>Clean</w:SpellingState>
  <w:GrammarState>Clean</w:GrammarState>
  <w:TrackMoves>false</w:TrackMoves>
  <w:TrackFormatting/>
  <w:DisplayHorizontalDrawingGridEvery>0</w:DisplayHorizontalDrawingGridEvery>
  <w:DisplayVerticalDrawingGridEvery>0</w:DisplayVerticalDrawingGridEvery>
  <w:UseMarginsForDrawingGridOrigin/>
  <w:ValidateAgainstSchemas/>
  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
  <w:DoNotPromoteQF/>
  <w:LidThemeOther>EN-US</w:LidThemeOther>
  <w:LidThemeAsian>X-NONE</w:LidThemeAsian>
  <w:LidThemeComplexScript>TH</w:LidThemeComplexScript>
  <w:Compatibility>
   <w:FootnoteLayoutLikeWW8/>
   <w:ShapeLayoutLikeWW8/>
   <w:AlignTablesRowByRow/>
   <w:ForgetLastTabAlignment/>
   <w:LayoutRawTableWidth/>
   <w:LayoutTableRowsApart/>
   <w:UseWord97LineBreakingRules/>
   <w:SelectEntireFieldWithStartOrEnd/>
   <w:ApplyBreakingRules/>
   <w:UseWord2002TableStyleRules/>
   <w:UseWord2010TableStyleRules/>
   <w:DontUseIndentAsNumberingTabStop/>
   <w:FELineBreak11/>
   <w:WW11IndentRules/>
   <w:DontAutofitConstrainedTables/>
   <w:AutofitLikeWW11/>
   <w:HangulWidthLikeWW11/>
   <w:UseNormalStyleForList/>
   <w:DontVertAlignCellWithSp/>
   <w:DontBreakConstrainedForcedTables/>
   <w:DontVertAlignInTxbx/>
   <w:Word11KerningPairs/>
   <w:CachedColBalance/>
  </w:Compatibility>
  <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>
  <m:mathPr>
   <m:mathFont m:val="Cambria Math"/>
   <m:brkBin m:val="before"/>
   <m:brkBinSub m:val="&#45;-"/>
   <m:smallFrac m:val="off"/>
   <m:dispDef/>
   <m:lMargin m:val="0"/>
   <m:rMargin m:val="0"/>
   <m:defJc m:val="centerGroup"/>
   <m:wrapIndent m:val="1440"/>
   <m:intLim m:val="subSup"/>
   <m:naryLim m:val="undOvr"/>
  </m:mathPr></w:WordDocument>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="false"
  DefSemiHidden="false" DefQFormat="false" LatentStyleCount="371">
  <w:LsdException Locked="false" QFormat="true" Name="Normal"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 1"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 2"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 3"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="heading 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="heading 6"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="heading 7"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="heading 8"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="heading 9"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="caption"/>
  <w:LsdException Locked="false" QFormat="true" Name="Title"/>
  <w:LsdException Locked="false" QFormat="true" Name="Subtitle"/>
  <w:LsdException Locked="false" QFormat="true" Name="Strong"/>
  <w:LsdException Locked="false" QFormat="true" Name="Emphasis"/>
  <w:LsdException Locked="false" Priority="99" SemiHidden="true"
   Name="Placeholder Text"/>
  <w:LsdException Locked="false" Priority="1" QFormat="true" Name="No Spacing"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 1"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 1"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 1"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 1"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 1"/>
  <w:LsdException Locked="false" Priority="99" SemiHidden="true" Name="Revision"/>
  <w:LsdException Locked="false" Priority="34" QFormat="true"
   Name="List Paragraph"/>
  <w:LsdException Locked="false" Priority="29" QFormat="true" Name="Quote"/>
  <w:LsdException Locked="false" Priority="30" QFormat="true"
   Name="Intense Quote"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 1"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 1"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 1"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 1"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 1"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 1"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 2"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 2"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 2"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 2"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 2"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 2"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 2"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 2"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 3"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 3"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 3"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 3"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 3"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 3"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 3"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 3"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 4"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 4"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 4"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 4"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 4"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 4"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 4"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 4"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 5"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 5"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 5"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 5"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 5"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 5"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 5"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 5"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 6"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 6"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 6"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 6"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 6"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 6"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 6"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 6"/>
  <w:LsdException Locked="false" Priority="19" QFormat="true"
   Name="Subtle Emphasis"/>
  <w:LsdException Locked="false" Priority="21" QFormat="true"
   Name="Intense Emphasis"/>
  <w:LsdException Locked="false" Priority="31" QFormat="true"
   Name="Subtle Reference"/>
  <w:LsdException Locked="false" Priority="32" QFormat="true"
   Name="Intense Reference"/>
  <w:LsdException Locked="false" Priority="33" QFormat="true" Name="Book Title"/>
  <w:LsdException Locked="false" Priority="37" SemiHidden="true"
   UnhideWhenUsed="true" Name="Bibliography"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="TOC Heading"/>
  <w:LsdException Locked="false" Priority="41" Name="Plain Table 1"/>
  <w:LsdException Locked="false" Priority="42" Name="Plain Table 2"/>
  <w:LsdException Locked="false" Priority="43" Name="Plain Table 3"/>
  <w:LsdException Locked="false" Priority="44" Name="Plain Table 4"/>
  <w:LsdException Locked="false" Priority="45" Name="Plain Table 5"/>
  <w:LsdException Locked="false" Priority="40" Name="Grid Table Light"/>
  <w:LsdException Locked="false" Priority="46" Name="Grid Table 1 Light"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark"/>
  <w:LsdException Locked="false" Priority="51" Name="Grid Table 6 Colorful"/>
  <w:LsdException Locked="false" Priority="52" Name="Grid Table 7 Colorful"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 1"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 1"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 1"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 1"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 1"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 1"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 2"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 2"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 2"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 2"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 2"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 2"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 3"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 3"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 3"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 3"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 3"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 3"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 4"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 4"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 4"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 4"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 4"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 4"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 5"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 5"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 5"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 5"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 5"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 5"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 6"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 6"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 6"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 6"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 6"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 6"/>
  <w:LsdException Locked="false" Priority="46" Name="List Table 1 Light"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark"/>
  <w:LsdException Locked="false" Priority="51" Name="List Table 6 Colorful"/>
  <w:LsdException Locked="false" Priority="52" Name="List Table 7 Colorful"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 1"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 1"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 1"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 1"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 1"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 1"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 2"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 2"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 2"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 2"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 2"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 2"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 3"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 3"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 3"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 3"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 3"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 3"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 4"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 4"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 4"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 4"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 4"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 4"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 5"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 5"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 5"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 5"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 5"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 5"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 6"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 6"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 6"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 6"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 6"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 6"/>
 </w:LatentStyles>
</xml><![endif]-->
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;
	mso-font-charset:2;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:0 268435456 0 0 -2147483648 0;}
@font-face
	{font-family:"Angsana New";
	panose-1:2 2 6 3 5 4 5 2 3 4;
	mso-font-charset:0;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:-2130706429 0 0 0 65537 0;}
@font-face
	{font-family:"Cordia New";
	panose-1:2 11 3 4 2 2 2 2 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-2130706429 0 0 0 65537 0;}
@font-face
	{font-family:"Cambria Math";
	panose-1:2 4 5 3 5 4 6 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:-536870145 1107305727 0 0 415 0;}
@font-face
	{font-family:"TH SarabunPSK";
	panose-1:2 11 5 0 4 2 0 2 0 3;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-1593835409 1342185562 0 0 65923 0;}
@font-face
	{font-family:"TH Sarabun New";
	mso-font-alt:"TH SarabunPSK";
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:0 1342185562 0 0 65923 0;}
@font-face
	{font-family:DilleniaUPC;
	panose-1:2 2 6 3 5 4 5 2 3 4;
	mso-font-charset:0;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:-2130706429 0 0 0 65537 0;}
@font-face
	{font-family:AngsanaUPC;
	panose-1:2 2 6 3 5 4 5 2 3 4;
	mso-font-charset:0;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:-2130706429 0 0 0 65537 0;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-520081665 -1073717157 41 0 66047 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:14.0pt;
	font-family:"Cordia New",sans-serif;
	mso-fareast-font-family:"Cordia New";
	mso-bidi-font-family:"Angsana New";}
h1
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin:0cm;
	margin-bottom:.0001pt;
	text-align:justify;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:1;
	tab-stops:0.7cm;
	font-size:12.0pt;
	font-family:"AngsanaUPC",serif;
	mso-font-kerning:0pt;
	text-decoration:underline;
	text-underline:single;}
h2
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin:0cm;
	margin-bottom:.0001pt;
	text-align:center;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:2;
	font-size:14.0pt;
	font-family:"AngsanaUPC",serif;
	text-decoration:underline;
	text-underline:single;}
h3
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin:0cm;
	margin-bottom:.0001pt;
	text-align:justify;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:3;
	tab-stops:0.7cm;
	font-size:14.0pt;
	font-family:"AngsanaUPC",serif;
	text-decoration:underline;
	text-underline:single;}
h4
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:4;
	font-size:16.0pt;
	font-family:"Angsana New",serif;}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{mso-style-unhide:no;
	mso-style-link:"หัวกระดาษ อักขระ";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:center 225.65pt right 451.3pt;
	font-size:14.0pt;
	mso-bidi-font-size:17.5pt;
	font-family:"Cordia New",sans-serif;
	mso-fareast-font-family:"Cordia New";
	mso-bidi-font-family:"Angsana New";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{mso-style-unhide:no;
	mso-style-link:"ท้ายกระดาษ อักขระ";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:center 225.65pt right 451.3pt;
	font-size:14.0pt;
	mso-bidi-font-size:17.5pt;
	font-family:"Cordia New",sans-serif;
	mso-fareast-font-family:"Cordia New";
	mso-bidi-font-family:"Angsana New";}
p.MsoTitle, li.MsoTitle, div.MsoTitle
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-link:"ชื่อเรื่อง อักขระ";
	margin:0cm;
	margin-bottom:.0001pt;
	text-align:center;
	mso-pagination:widow-orphan;
	font-size:16.0pt;
	font-family:"AngsanaUPC",serif;
	mso-fareast-font-family:"Cordia New";
	font-weight:bold;}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-unhide:no;
	mso-style-link:"ข้อความบอลลูน อักขระ";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:8.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Tahoma",sans-serif;
	mso-fareast-font-family:"Cordia New";
	mso-bidi-font-family:"Angsana New";}
span.a
	{mso-style-name:"ชื่อเรื่อง อักขระ";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:ชื่อเรื่อง;
	mso-ansi-font-size:16.0pt;
	mso-bidi-font-size:16.0pt;
	font-family:"AngsanaUPC",serif;
	mso-ascii-font-family:AngsanaUPC;
	mso-hansi-font-family:AngsanaUPC;
	mso-bidi-font-family:AngsanaUPC;
	font-weight:bold;}
span.a0
	{mso-style-name:"หัวกระดาษ อักขระ";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:หัวกระดาษ;
	mso-ansi-font-size:14.0pt;
	mso-bidi-font-size:17.5pt;}
span.a1
	{mso-style-name:"ท้ายกระดาษ อักขระ";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:ท้ายกระดาษ;
	mso-ansi-font-size:14.0pt;
	mso-bidi-font-size:17.5pt;}
span.a2
	{mso-style-name:"ข้อความบอลลูน อักขระ";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:ข้อความบอลลูน;
	mso-ansi-font-size:8.0pt;
	font-family:"Tahoma",sans-serif;
	mso-ascii-font-family:Tahoma;
	mso-hansi-font-family:Tahoma;}
span.SpellE
	{mso-style-name:"";
	mso-spl-e:yes;}
span.GramE
	{mso-style-name:"";
	mso-gram-e:yes;}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	mso-ascii-font-family:"Cordia New";
	mso-fareast-font-family:"Cordia New";
	mso-hansi-font-family:"Cordia New";
	mso-bidi-font-family:"Angsana New";}
 /* Page Definitions */

@page WordSection1
	{size:595.3pt 841.9pt;
	margin:21.25pt 19.3pt 45.1pt 36.0pt;
	mso-header-margin:36.0pt;
	mso-footer-margin:36.0pt;

	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
 @list l0
	{mso-list-id:1544903034;
	mso-list-type:hybrid;
	mso-list-template-ids:1546578904 -1448457128 67698691 67698693 67698689 67698691 67698693 67698689 67698691 67698693;}
@list l0:level1
	{mso-level-start-at:0;
	mso-level-number-format:bullet;
	mso-level-text:\F0F0;
	mso-level-tab-stop:53.45pt;
	mso-level-number-position:left;
	margin-left:53.45pt;
	text-indent:-18.0pt;
	font-family:Symbol;
	mso-fareast-font-family:"Cordia New";
	mso-bidi-font-family:AngsanaUPC;}
@list l0:level2
	{mso-level-number-format:bullet;
	mso-level-text:o;
	mso-level-tab-stop:89.45pt;
	mso-level-number-position:left;
	margin-left:89.45pt;
	text-indent:-18.0pt;
	font-family:"Courier New";
	mso-bidi-font-family:"Times New Roman";}
@list l0:level3
	{mso-level-number-format:bullet;
	mso-level-text:\F0A7;
	mso-level-tab-stop:125.45pt;
	mso-level-number-position:left;
	margin-left:125.45pt;
	text-indent:-18.0pt;
	font-family:Wingdings;}
@list l0:level4
	{mso-level-number-format:bullet;
	mso-level-text:\F0B7;
	mso-level-tab-stop:161.45pt;
	mso-level-number-position:left;
	margin-left:161.45pt;
	text-indent:-18.0pt;
	font-family:Symbol;}
@list l0:level5
	{mso-level-number-format:bullet;
	mso-level-text:o;
	mso-level-tab-stop:197.45pt;
	mso-level-number-position:left;
	margin-left:197.45pt;
	text-indent:-18.0pt;
	font-family:"Courier New";
	mso-bidi-font-family:"Times New Roman";}
@list l0:level6
	{mso-level-number-format:bullet;
	mso-level-text:\F0A7;
	mso-level-tab-stop:233.45pt;
	mso-level-number-position:left;
	margin-left:233.45pt;
	text-indent:-18.0pt;
	font-family:Wingdings;}
@list l0:level7
	{mso-level-number-format:bullet;
	mso-level-text:\F0B7;
	mso-level-tab-stop:269.45pt;
	mso-level-number-position:left;
	margin-left:269.45pt;
	text-indent:-18.0pt;
	font-family:Symbol;}
@list l0:level8
	{mso-level-number-format:bullet;
	mso-level-text:o;
	mso-level-tab-stop:305.45pt;
	mso-level-number-position:left;
	margin-left:305.45pt;
	text-indent:-18.0pt;
	font-family:"Courier New";
	mso-bidi-font-family:"Times New Roman";}
@list l0:level9
	{mso-level-number-format:bullet;
	mso-level-text:\F0A7;
	mso-level-tab-stop:341.45pt;
	mso-level-number-position:left;
	margin-left:341.45pt;
	text-indent:-18.0pt;
	font-family:Wingdings;}
ol
	{margin-bottom:0cm;}
ul
	{margin-bottom:0cm;}
-->
</style>
<!--[if gte mso 10]>
<style>
 /* Style Definitions */
 table.MsoNormalTable
	{mso-style-name:ตารางปกติ;
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-parent:"";
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-para-margin:0cm;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Cordia New",sans-serif;
	mso-bidi-font-family:"Angsana New";}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:shapedefaults v:ext="edit" spidmax="1133"/>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <o:shapelayout v:ext="edit">
  <o:idmap v:ext="edit" data="1"/>
 </o:shapelayout></xml><![endif]-->
</head>

<body lang=EN-US style='tab-interval:36.0pt'>

<div class=WordSection1>

<p class=MsoNormal style='tab-stops:159.0pt'><!--[if gte vml 1]><v:shapetype
 id="_x0000_t202" coordsize="21600,21600" o:spt="202" path="m,l,21600r21600,l21600,xe">
 <v:stroke joinstyle="miter"/>
 <v:path gradientshapeok="t" o:connecttype="rect"/>
</v:shapetype><v:shape id="กล่องข้อความ_x0020_2" o:spid="_x0000_s1132" type="#_x0000_t202"
 style='position:absolute;margin-left:394.2pt;margin-top:-32.65pt;width:115.2pt;
 height:34pt;z-index:251659264;visibility:visible;mso-width-relative:margin;
 mso-height-relative:margin' o:gfxdata="UEsDBBQABgAIAAAAIQC2gziS/gAAAOEBAAATAAAAW0NvbnRlbnRfVHlwZXNdLnhtbJSRQU7DMBBF
90jcwfIWJU67QAgl6YK0S0CoHGBkTxKLZGx5TGhvj5O2G0SRWNoz/78nu9wcxkFMGNg6quQqL6RA
0s5Y6ir5vt9lD1JwBDIwOMJKHpHlpr69KfdHjyxSmriSfYz+USnWPY7AufNIadK6MEJMx9ApD/oD
OlTrorhX2lFEilmcO2RdNtjC5xDF9pCuTyYBB5bi6bQ4syoJ3g9WQ0ymaiLzg5KdCXlKLjvcW893
SUOqXwnz5DrgnHtJTxOsQfEKIT7DmDSUCaxw7Rqn8787ZsmRM9e2VmPeBN4uqYvTtW7jvijg9N/y
JsXecLq0q+WD6m8AAAD//wMAUEsDBBQABgAIAAAAIQA4/SH/1gAAAJQBAAALAAAAX3JlbHMvLnJl
bHOkkMFqwzAMhu+DvYPRfXGawxijTi+j0GvpHsDYimMaW0Yy2fr2M4PBMnrbUb/Q94l/f/hMi1qR
JVI2sOt6UJgd+ZiDgffL8ekFlFSbvV0oo4EbChzGx4f9GRdb25HMsYhqlCwG5lrLq9biZkxWOiqY
22YiTra2kYMu1l1tQD30/bPm3wwYN0x18gb45AdQl1tp5j/sFB2T0FQ7R0nTNEV3j6o9feQzro1i
OWA14Fm+Q8a1a8+Bvu/d/dMb2JY5uiPbhG/ktn4cqGU/er3pcvwCAAD//wMAUEsDBBQABgAIAAAA
IQCzU/PLVAIAAGoEAAAOAAAAZHJzL2Uyb0RvYy54bWysVM2O0zAQviPxDpbvNGna7k/UdLV0KUJa
fqSFB3Adp7FwbGO7TcptERLwGBwQJy6csm+TR2HsdLvl74LIwZrx2J+/+WYm07OmEmjDjOVKZng4
iDFikqqcy1WGX71cPDjByDoicyKUZBneMovPZvfvTWudskSVSuTMIACRNq11hkvndBpFlpasInag
NJMQLJSpiAPXrKLckBrQKxElcXwU1crk2ijKrIXdiz6IZwG/KBh1z4vCModEhoGbC6sJ69Kv0WxK
0pUhuuR0R4P8A4uKcAmP7qEuiCNobfhvUBWnRllVuAFVVaSKglMWcoBshvEv2VyVRLOQC4hj9V4m
+/9g6bPNC4N4nuFRfIyRJBUUqWuvu/ZLd/Oxa7917YeufdfdfAr2+6792rXfu/YzSrx2tbYpQFxp
AHHNQ9VADwQdrL5U9LVFUs1LIlfs3BhVl4zkwH3ob0YHV3sc60GW9VOVAwWydioANYWpvLAgFQJ0
qOF2XzfWOERhMxkdj5OjCUYUYsNxPDo9mYQ3SHp7XRvrHjNVIW9k2EBjBHiyubTO0yHp7RH/mlWC
5wsuRHDMajkXBm0INNEifDv0n44JieoMn06SSa/AXyHi8P0JouIOpkHwKsMn+0Mk9bo9knnoVUe4
6G2gLOROSK9dr6Jrlk2oZ1DZi7xU+RaUNapvfhhWMEpl3mJUQ+Nn2L5ZE8MwEk8kVOd0OB77SQnO
eHKcgGMOI8vDCJEUoDLsMOrNuQvTFXTT51DFBQ/63jHZUYaGDrLvhs9PzKEfTt39ImY/AAAA//8D
AFBLAwQUAAYACAAAACEA/S8y1tsAAAAFAQAADwAAAGRycy9kb3ducmV2LnhtbEyPwU7DMBBE70j8
g7VI3KiTFBVI41RVBNdKbZG4buNtErDXIXbS8PcYLnBZaTSjmbfFZrZGTDT4zrGCdJGAIK6d7rhR
8Hp8uXsE4QOyRuOYFHyRh015fVVgrt2F9zQdQiNiCfscFbQh9LmUvm7Jol+4njh6ZzdYDFEOjdQD
XmK5NTJLkpW02HFcaLGnqqX64zBaBeOx2k77Knt/m3b6frd6RovmU6nbm3m7BhFoDn9h+MGP6FBG
ppMbWXthFMRHwu+N3vJh+QTipCDL0hRkWcj/9OU3AAAA//8DAFBLAQItABQABgAIAAAAIQC2gziS
/gAAAOEBAAATAAAAAAAAAAAAAAAAAAAAAABbQ29udGVudF9UeXBlc10ueG1sUEsBAi0AFAAGAAgA
AAAhADj9If/WAAAAlAEAAAsAAAAAAAAAAAAAAAAALwEAAF9yZWxzLy5yZWxzUEsBAi0AFAAGAAgA
AAAhALNT88tUAgAAagQAAA4AAAAAAAAAAAAAAAAALgIAAGRycy9lMm9Eb2MueG1sUEsBAi0AFAAG
AAgAAAAhAP0vMtbbAAAABQEAAA8AAAAAAAAAAAAAAAAArgQAAGRycy9kb3ducmV2LnhtbFBLBQYA
AAAABAAEAPMAAAC2BQAAAAA=
" stroked="f">
 <v:textbox style='mso-next-textbox:#กล่องข้อความ_x0020_2'/>
</v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;position:
relative;z-index:251659264'><span style='position:absolute;left:526px;
top:0px;width:157px;height:50px'>

<table cellpadding=0 cellspacing=0>
 <tr>
  <td width=157 height=50 bgcolor=white style='vertical-align:top;background:
  white'><![endif]><![if !mso]><span style='position:absolute;mso-ignore:vglayout;
  z-index:251659264'>
  <table cellpadding=0 cellspacing=0 width="100%">
   <tr>
    <td><![endif]>
    <div v:shape="กล่องข้อความ_x0020_2" style='padding:3.6pt 7.2pt 3.6pt 7.2pt'
    class=shape>
    <p class=MsoNormal align=right style='text-align:right'><span class=SpellE><span
    lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif'>ทบ.มมส</span></span><span
    lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif'>/โท-เอก
    03</span><span style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif'><o:p></o:p></span></p>
    <p class=MsoNormal align=right style='text-align:right'><span lang=TH
    style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif'><o:p>&nbsp;</o:p></span></p>
    </div>
    <![if !mso]></td>
   </tr>
  </table>
  </span><![endif]><![if !mso & !vml]>&nbsp;<![endif]><![if !vml]></td>
 </tr>
</table>

</span></span><![endif]><span style='font-family:"TH SarabunPSK",sans-serif'><o:p>&nbsp;</o:p></span></p>

<br style='mso-ignore:vglayout' clear=ALL>

<p class=MsoTitle style='text-align:justify'><!--[if gte vml 1]><v:shape id="_x0000_s1130"
 type="#_x0000_t202" style='position:absolute;left:0;text-align:left;
 margin-left:-2pt;margin-top:-6.35pt;width:70.65pt;height:81.45pt;z-index:251657216;
 mso-wrap-style:none' stroked="f">
 <v:textbox style='mso-next-textbox:#_x0000_s1130;mso-fit-shape-to-text:t'/>
</v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;position:
relative;z-index:251657216'><span style='left:0px;position:absolute;left:-3px;
top:-8px;width:99px;height:112px'>

<table cellpadding=0 cellspacing=0>
 <tr>
  <td width=99 height=112 bgcolor=white style='vertical-align:top;background:
  white'><![endif]><![if !mso]><span style='position:absolute;mso-ignore:vglayout;
  left:0pt;z-index:251657216'>
  <table cellpadding=0 cellspacing=0 width="100%">
   <tr>
    <td><![endif]>
    <div v:shape="_x0000_s1130" style='padding:3.6pt 7.2pt 3.6pt 7.2pt'
    class=shape>
    <p class=MsoNormal><span style='font-size:22.0pt;font-family:"Times New Roman",serif;
    mso-hansi-font-family:DilleniaUPC;mso-bidi-font-family:DilleniaUPC'>
    </v:shape><![endif]--><![if !vml]><img width=75 height=99
    src="http://202.28.32.211/eform/grad03.files/image002.gif"><![endif]></span></p>
    </div>
    <![if !mso]></td>
   </tr>
  </table>
  </span><![endif]><![if !mso & !vml]>&nbsp;<![endif]><![if !vml]></td>
 </tr>
</table>

</span></span><![endif]><span style='font-size:30.0pt;font-family:"TH SarabunPSK",sans-serif'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:20.0pt;font-family:"TH SarabunPSK",sans-serif'><o:p></o:p></span></p>

<p class=MsoTitle style='margin-left:108.0pt;text-align:justify;text-indent:
36.0pt'><span lang=TH style='font-size:26.0pt;font-family:"TH SarabunPSK",sans-serif'><span
style='mso-spacerun:yes'>&nbsp;</span>คำร้องขอลาพักการเรียน</span><span
style='font-size:25.0pt;font-family:"TH SarabunPSK",sans-serif'><span
style='mso-spacerun:yes'>&nbsp; </span></span><span lang=TH style='font-family:
"TH SarabunPSK",sans-serif'>(ระดับบัณฑิตศึกษา)</span><span lang=TH
style='font-size:14.0pt;font-family:"TH SarabunPSK",sans-serif'> </span><span
style='font-size:14.0pt;font-family:"TH SarabunPSK",sans-serif'><o:p></o:p></span></p>

<p class=MsoTitle align=left style='text-align:left'><span style='font-size:
14.0pt;font-family:"TH SarabunPSK",sans-serif'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-family:"TH SarabunPSK",sans-serif;font-weight:
normal'>Request Form for Taking a Leave (Graduate Student)<span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br>
</span><span style='font-size:14.0pt;font-family:"TH SarabunPSK",sans-serif;
font-weight:normal'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style='font-family:"TH SarabunPSK",sans-serif;
font-weight:normal'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span><span style='font-size:13.0pt;font-family:"TH SarabunPSK",sans-serif'><o:p></o:p></span></p>

<p class=MsoTitle align=left style='text-align:left'><span style='font-size:
6.0pt;font-family:"TH SarabunPSK",sans-serif'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='tab-stops:0.7cm'><b><span lang=TH style='font-family:
"TH SarabunPSK",sans-serif'><span style='mso-tab-count:1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>ข้าพเจ้า
</span></b><span style='font-family:"TH SarabunPSK",sans-serif'>………<?php echo $studentnamex ; ?>……<o:p></o:p>
</span> <span class="MsoTitle" style="text-align:left"><span style='font-size:14.0pt;font-family:"TH SarabunPSK",sans-serif;
font-weight:normal'><b>เลขประจำตัวนิสิต</b></span><span
style='font-family:"TH SarabunPSK",sans-serif;font-weight:normal'>/ </span><span
style='font-size:12.0pt;tab-stops:0.7cm;font-family:"TH SarabunPSK",sans-serif;font-weight:
normal'>Student ID. <font size="+1"><?php echo $doc_std_id ; ?></font></span><span style='font-family:"TH SarabunPSK",sans-serif;
font-weight:normal'><span style='mso-spacerun:yes'>&nbsp;</span><span
style='mso-spacerun:yes'>&nbsp;</span></span></span></p>

<p class=MsoNormal style='tab-stops:0.7cm'><b><span lang=TH style='font-family:
"TH SarabunPSK",sans-serif'>คณะ</span></b><b><span style='font-family:"TH SarabunPSK",sans-serif'>/
</span></b><span style='font-family:"TH SarabunPSK",sans-serif'>Faculty …<?php echo $facultyname ; ?>… <b><span
lang=TH>สาขาวิชา</span>/ </b>Major….<?php echo $programname ; ?>….<o:p></o:p></span></p>

<p class=MsoNormal><b><span lang=TH style='font-family:"TH SarabunPSK",sans-serif'>เป็นนิสิตศึกษาอยู่ที่</span></b><b><span
style='font-family:"TH SarabunPSK",sans-serif'>/ </span></b><span
style='font-family:"TH SarabunPSK",sans-serif'>study at<b><span lang=TH> </span></b><span
style='mso-spacerun:yes'>&nbsp;</span><?php echo $levelname ; ?><o:p></o:p></span></p>

<p class=MsoNormal><span style='font-family:"TH SarabunPSK",sans-serif'><span
style='mso-tab-count:3'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span><?php echo $campusname ; ?></span><span
style='font-size:13.0pt;font-family:"TH SarabunPSK",sans-serif'><o:p></o:p></span></p>
<p class=MsoNormal><b><span lang=TH style='font-size:8.0pt;font-family:"TH SarabunPSK",sans-serif'><o:p>&nbsp;</o:p></span></b></p>
<p class=MsoNormal style='text-indent:36.0pt'><b><span lang=TH
style='font-family:"TH SarabunPSK",sans-serif'>มีความประสงค์ขอลาพักการเรียน/ </span></b><span
style='font-family:"TH SarabunPSK",sans-serif'>Would like to take a leave in:<span
style='mso-spacerun:yes'>&nbsp;&nbsp; </span><o:p></o:p></span></p>

<p class=MsoNormal><span style='font-family:"TH SarabunPSK",sans-serif'><?php if($semester=='1'){ echo "<input type='checkbox' checked>" ;} else { echo "<input type='checkbox'>" ; } ; ?><b><span lang=TH>ภาคต้น</span></b><span
lang=TH>/ </span>1<sup>st</sup> semester<span
style='mso-spacerun:yes'></span><?php if($semester=='2'){ echo "<input type='checkbox' checked>" ;} else { echo "<input type='checkbox'>" ; } ; ?> <b><span lang=TH>ภาคปลาย</span></b><span
lang=TH>/ </span>2<sup>nd </sup>semester<span
style='mso-spacerun:yes'></span><?php if($semester=='3'){ echo "<input type='checkbox' checked>" ;} else { echo "<input type='checkbox'>" ; } ; ?> <b><span lang=TH>ภาคการศึกษาพิเศษ</span></b><span
lang=TH>/ </span>3<sup>nd </sup>semester<span style='mso-spacerun:yes'>&nbsp;
</span><b><span lang=TH>ปีการศึกษา</span></b><span lang=TH>/</span> Academic
year …<?php echo $academic ; ?>…<o:p></o:p></span></p>

<p class=MsoNormal style='tab-stops:0.7cm'><b><span lang=TH style='font-family:
"TH SarabunPSK",sans-serif'>เนื่องจาก</span></b><span style='font-family:"TH SarabunPSK",sans-serif'>/
because…………<?php echo $because ; ?>……….<o:p></o:p></span></p>

<p class=MsoNormal style='tab-stops:0.7cm'><span style='font-family:"TH SarabunPSK",sans-serif'><span
style='mso-tab-count:1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><b><span
lang=TH>กรณีได้อนุมัติให้ทำวิทยานิพนธ์</span>/<span lang=TH>การศึกษาค้นคว้าอิสระ</span></b>/
Getting the approval to do<span lang=TH> </span>thesis/independent study<o:p></o:p></span></p>

<p class=MsoNormal style='tab-stops:0.7cm'><span style='font-family:"TH SarabunPSK",sans-serif'><span
style='mso-tab-count:2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><?php if($finished_assigment<>''){ echo "<input type='checkbox' checked>" ;} else { echo "<input type='checkbox'>" ; } ; ?><span
style='mso-spacerun:yes'>&nbsp; </span><span
style='mso-spacerun:yes'>&nbsp;</span><span lang=TH>งานที่ทำแล้วเสร็จ</span>/ <span
class=GramE>The</span> finished assignment: ……<?php echo $finished_assigment ; ?>….<o:p></o:p></span></p>

<p class=MsoNormal style='tab-stops:0.7cm'><span style='font-family:"TH SarabunPSK",sans-serif'><span
style='mso-tab-count:2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><?php if($unfinished_assignment<>''){ echo "<input type='checkbox' checked>" ;} else { echo "<input type='checkbox' >" ; } ; ?>
<span style='mso-spacerun:yes'>&nbsp;&nbsp;</span><span lang=TH>งานที่กำลังทำ /
</span><span class=GramE>The</span> unfinished assignment: ……<?php echo $unfinished_assignment ; ?>....<o:p></o:p></span></p>

<p class=MsoNormal style='tab-stops:0.7cm'><span lang=TH style='font-family:
"TH SarabunPSK",sans-serif'><span style='mso-tab-count:2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><span
style='font-family:"TH SarabunPSK",sans-serif'><?php if($unstarting_assignment<>''){ echo "<input type='checkbox' checked>" ;} else { echo "<input type='checkbox' >" ; } ; ?><span lang=TH><span
style='mso-spacerun:yes'>&nbsp;&nbsp; </span>งานที่ยังไม่ทำ/ </span><span
class=GramE>The</span> unstarting assignment: ……<?php echo $unstarting_assignment ; ?>....<o:p></o:p></span></p>

<p class=MsoNormal style='tab-stops:0.7cm'><span style='font-size:7.0pt;
font-family:"TH SarabunPSK",sans-serif'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;tab-stops:0.7cm'><span
style='font-size:13.0pt;font-family:"TH SarabunPSK",sans-serif'><span
style='mso-tab-count:4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span
style='mso-tab-count:1'>&nbsp;&nbsp;&nbsp;&nbsp; </span><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span><span
style='font-family:"TH SarabunPSK",sans-serif'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;</span><b><span lang=TH><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>ลงชื่อ</span></b>/Signature
<img src="https://grad.msu.ac.th/electronic/digital-e-signature/doc_signs/<?=$std_signature.".png";?>" width="150"><b><span lang=TH>ผู้ยื่นคำร้อง</span></b>/ 
Applicant
<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:6.0pt;tab-stops:0.7cm'><span lang=TH
style='font-family:"TH SarabunPSK",sans-serif'><span style='mso-tab-count:8'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>(</span><span style='font-family:"TH SarabunPSK",sans-serif'>…<?php echo $studentnamex ; ?>…<span
lang=TH>)</span></span><span lang=TH style='font-size:10.0pt;font-family:"TH SarabunPSK",sans-serif'>
</span><span style='font-family:"TH SarabunPSK",sans-serif'>.……../……../……….
<o:p></o:p></span></p>


<div align="left">
<p align="left" class=MsoNormal style='tab-stops:0.7cm'><b><u><span style='font-size:5.0pt;
font-family:"TH SarabunPSK",sans-serif'><o:p><span style='text-decoration:none'>&nbsp;</span></o:p></span></u></b><b><u><span
lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif'>&nbsp;ขั้นตอนการลงความเห็น</span></u></b><b><u><span
style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif'>/<span lang=TH>การอนุมัติ</span></span></u></b><b><u><span
style='font-family:"TH SarabunPSK",sans-serif'><span
style='mso-spacerun:yes'>&nbsp; </span></span></u></b><u><span
style='font-family:"TH SarabunPSK",sans-serif'>Comment/Approval 
      <o:p></o:p>
</span></u></p>

<p class=MsoNormal style='text-align:justify;tab-stops:0.7cm'><span
style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif'><span
style='mso-tab-count:2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><span
style='font-size:6.0pt;font-family:"TH SarabunPSK",sans-serif'><o:p></o:p></span></p>
</div>
<div align="left">

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=0
 style='width:517.75pt;border-collapse:collapse;border:none;mso-border-alt:
 solid windowtext .5pt;mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
 mso-border-insideh:.5pt solid windowtext;mso-border-insidev:.5pt solid windowtext'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=336 colspan=2 valign=top style='width:252.0pt;border:solid windowtext 1.0pt;
  border-right:none;mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:
  solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;padding:
  0cm 5.4pt 0cm 5.4pt'>
  <h1><span style='font-size:14.0pt;font-family:Wingdings;mso-ascii-font-family:
  "TH SarabunPSK";mso-fareast-font-family:"Cordia New";mso-hansi-font-family:
  "TH SarabunPSK";mso-bidi-font-family:"TH SarabunPSK";mso-char-type:symbol;
  mso-symbol-font-family:Wingdings;font-weight:normal'><span style='mso-char-type:
  symbol;mso-symbol-font-family:Wingdings'></span></span><span
  style='font-size:14.0pt;font-family:"TH SarabunPSK",sans-serif;mso-fareast-font-family:
  "Cordia New";font-weight:normal'> </span><span lang=TH style='font-size:14.0pt;
  font-family:"TH SarabunPSK",sans-serif;mso-fareast-font-family:"Cordia New"'>ความเห็นอาจารย์ที่ปรึกษา</span><span
  style='font-size:14.0pt;font-family:"TH SarabunPSK",sans-serif;mso-fareast-font-family:
  "Cordia New"'>/<span lang=TH>ประธานควบคุมวิทยานิพนธ์</span><o:p></o:p></span></h1>
  <p class=MsoNormal><span style='font-family:"TH SarabunPSK",sans-serif'><span
  style='mso-spacerun:yes'>&nbsp;</span>(Advisor/Chairman of the thesis)<o:p></o:p></span></p>
  <p class=MsoNormal><span style='font-family:"TH SarabunPSK",sans-serif'>………………………………………………………………………………….…<o:p></o:p></span></p>
  <p class=MsoNormal><span style='font-family:"TH SarabunPSK",sans-serif'>……………………………………………………………………….……………<o:p></o:p></span></p>
  <p class=MsoNormal><b><span lang=TH style='font-family:"TH SarabunPSK",sans-serif'>ลงชื่อ</span></b><span
  style='font-family:"TH SarabunPSK",sans-serif'>/ Signature <img src="https://grad.msu.ac.th/electronic/digital-e-signature/doc_signs/<?=$advisor_chairman_signature.".png";?>" width="150"></span></p>
  <p class=MsoNormal style='text-align:justify;tab-stops:0.7cm'><span
  style='font-family:"TH SarabunPSK",sans-serif'><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>(.<?php echo $officernamex ; ?>.)</span><b><span style='font-size:13.0pt;font-family:"TH SarabunPSK",sans-serif'><o:p></o:p></span></b></p>
  </td>
  <td width=354 colspan=2 valign=top style='width:265.75pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <h1><span style='font-size:14.0pt;mso-bidi-font-size:16.0pt;font-family:Wingdings;
  mso-ascii-font-family:"TH SarabunPSK";mso-fareast-font-family:"Cordia New";
  mso-hansi-font-family:"TH SarabunPSK";mso-bidi-font-family:"TH SarabunPSK";
  mso-char-type:symbol;mso-symbol-font-family:Wingdings;font-weight:normal'><span
  style='mso-char-type:symbol;mso-symbol-font-family:Wingdings'></span></span><span
  style='mso-bidi-font-size:14.0pt;font-family:"TH SarabunPSK",sans-serif;
  mso-fareast-font-family:"Cordia New";font-weight:normal'> </span><span
  lang=TH style='font-size:14.0pt;font-family:"TH SarabunPSK",sans-serif;
  mso-fareast-font-family:"Cordia New"'>ความเห็นคณบดีบัณฑิตวิทยาลัย</span><span
  lang=TH style='font-size:14.0pt;mso-ansi-font-size:12.0pt;font-family:"TH Sarabun New",sans-serif;
  mso-fareast-font-family:"Cordia New";text-decoration:none;text-underline:
  none'> </span><span style='font-size:14.0pt;font-family:"TH SarabunPSK",sans-serif;
  mso-fareast-font-family:"Cordia New";font-weight:normal;text-decoration:none;
  text-underline:none'>(Dean of Graduate school)</span><span style='mso-bidi-font-size:
  14.0pt;font-family:"TH Sarabun New",sans-serif;mso-fareast-font-family:"Cordia New"'><o:p></o:p></span></h1>
  <p class=MsoNormal><span style='font-family:"TH SarabunPSK",sans-serif'>……………………………………………………………………..………………………….<span
  lang=TH><o:p></o:p></span></span></p>
  <p class=MsoNormal><span style='font-family:"TH SarabunPSK",sans-serif'><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp; </span>[<span
  style='mso-spacerun:yes'>&nbsp;&nbsp; </span>]<span
  style='mso-spacerun:yes'>&nbsp; </span><b><span lang=TH>อนุมัติ</span></b>/ Approve<span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp; </span>[<span
  style='mso-spacerun:yes'>&nbsp;&nbsp; </span>]<span
  style='mso-spacerun:yes'>&nbsp; </span><b><span lang=TH>ไม่อนุมัติ</span></b>/
  Disapprove<o:p></o:p></span></p>
  <p class=MsoNormal><span lang=TH style='font-family:"TH SarabunPSK",sans-serif'>ลงชื่อ</span><span
  style='font-family:"TH SarabunPSK",sans-serif'>/ Signature <img src="https://grad.msu.ac.th/electronic/digital-e-signature/doc_signs/<?=$rs['dean_admin_signature'].".png";?>" width="150"></span></p>
   <p class=MsoNormal><span style='font-family:"TH SarabunPSK",sans-serif'><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>(…<?php echo $dean_adminname ; ?>…)</span><b><u><span
  style='font-size:13.0pt;font-family:"TH SarabunPSK",sans-serif'><o:p></o:p></span></u></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1;mso-yfti-lastrow:yes;page-break-inside:avoid'>
  <td width=158 valign=top style='width:118.8pt;border:none;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-right-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><span style='font-size:13.0pt;font-family:"TH SarabunPSK",sans-serif'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=338 colspan=2 valign=top style='width:253.5pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><b><span style='font-family:Wingdings;mso-ascii-font-family:
  "TH SarabunPSK";mso-hansi-font-family:"TH SarabunPSK";mso-bidi-font-family:
  "TH SarabunPSK";mso-char-type:symbol;mso-symbol-font-family:Wingdings'><span
  style='mso-char-type:symbol;mso-symbol-font-family:Wingdings'></span></span></b><b><span
  style='font-family:"TH SarabunPSK",sans-serif'> <span lang=TH>เจ้าหน้าที่กองทะเบียนและประมวลผล</span></span></b><span
  style='font-family:"TH SarabunPSK",sans-serif'><o:p></o:p></span></p>
  <p class=MsoNormal><span style='font-family:"TH SarabunPSK",sans-serif'>(The
  Officer of the Division of Registrar)<o:p></o:p></span></p>
  <p class=MsoNormal><span lang=TH style='font-family:"TH SarabunPSK",sans-serif'>ลงชื่อ</span><span
  style='font-family:"TH SarabunPSK",sans-serif'>/ Signature </span></p>
  <p class=MsoNormal><span style='font-family:"TH SarabunPSK",sans-serif'><span
  style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  </span>(……………….…………………)</span><span style='font-size:13.0pt;font-family:
  "TH SarabunPSK",sans-serif'><o:p></o:p></span></p>
  </td>
  <td width=194 valign=top style='width:145.45pt;border:none;mso-border-top-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><span style='font-family:"TH SarabunPSK",sans-serif'><o:p>&nbsp;</o:p></span></p>
  </td>
 </tr>
 <![if !supportMisalignedColumns]>
 <tr height=0>
  <td width=158 style='border:none'></td>
  <td width=178 style='border:none'></td>
  <td width=160 style='border:none'></td>
  <td width=194 style='border:none'></td>
 </tr>
 <![endif]>
</table>

</div>

<p class=MsoNormal><span style='mso-bidi-font-size:12.0pt'><o:p>&nbsp;</o:p></span></p>

</div>

</body>

</html>



