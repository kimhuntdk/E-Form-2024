<?php
/*header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=title.doc");*/
require_once( "inc/db_connect.php" );
$mysqli = connect();
//== ขอหนังสือแต่งตั้งชื่อเรื่อง
$doc_id = base64_decode( $_GET['doc_id'] );
$sql_aa = "SELECT * FROM request_doc INNER JOIN request_appointment_advisor ON request_doc.doc_id=request_appointment_advisor.doc_id INNER JOIN request_student ON request_appointment_advisor.std_code=request_student.std_id_std WHERE request_appointment_advisor.doc_id=" . $doc_id;
$result_aa = $mysqli->query( $sql_aa );
$row_aa = $result_aa->fetch_array();
?>
<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta charset="utf-8">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 14">
<meta name=Originator content="Microsoft Word 14">
<link rel=File-List href="ts01556.files/filelist.xml">
<link rel=Edit-Time-Data href="ts01556.files/editdata.mso">
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>msu</o:Author>
  <o:Template>Normal</o:Template>
  <o:LastAuthor>kimhun-nb</o:LastAuthor>
  <o:Revision>2</o:Revision>
  <o:TotalTime>1</o:TotalTime>
  <o:LastPrinted>2018-03-13T04:14:00Z</o:LastPrinted>
  <o:Created>2020-08-04T17:21:00Z</o:Created>
  <o:LastSaved>2020-08-04T17:21:00Z</o:LastSaved>
  <o:Pages>2</o:Pages>
  <o:Words>550</o:Words>
  <o:Characters>3135</o:Characters>
  <o:Company>Mahasarakham</o:Company>
  <o:Lines>26</o:Lines>
  <o:Paragraphs>7</o:Paragraphs>
  <o:CharactersWithSpaces>3678</o:CharactersWithSpaces>
  <o:Version>14.00</o:Version>
 </o:DocumentProperties>
 <o:OfficeDocumentSettings>
  <o:TargetScreenSize>800x600</o:TargetScreenSize>
 </o:OfficeDocumentSettings>
</xml><![endif]-->
<link rel=dataStoreItem href="ts01556.files/item0001.xml"
target="ts01556.files/props002.xml">
<link rel=themeData href="ts01556.files/themedata.thmx">
<link rel=colorSchemeMapping href="ts01556.files/colorschememapping.xml">
<!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:SpellingState>Clean</w:SpellingState>
  <w:GrammarState>Clean</w:GrammarState>
  <w:DocumentProtection>ReadOnly</w:DocumentProtection>
  <w:UnprotectPassword>DD67C0C3</w:UnprotectPassword>
  <w:TrackMoves>false</w:TrackMoves>
  <w:TrackFormatting/>
  <w:DisplayHorizontalDrawingGridEvery>0</w:DisplayHorizontalDrawingGridEvery>
  <w:DisplayVerticalDrawingGridEvery>0</w:DisplayVerticalDrawingGridEvery>
  <w:UseMarginsForDrawingGridOrigin/>
  <w:ValidateAgainstSchemas/>
  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
  <w:StyleLock/>
  <w:StyleLockEnforced/>
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
  DefSemiHidden="false" DefQFormat="false" LatentStyleCount="267">
  <w:LsdException Locked="false" QFormat="true" Name="Normal"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 1"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 2"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 3"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 4"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 5"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 6"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 7"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 8"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 9"/>
  <w:LsdException Locked="false" QFormat="true" Name="caption"/>
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
 </w:LatentStyles>
</xml><![endif]-->
<style>
<!--
 /* Font Definitions */
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
	{font-family:"Cordia New";
	panose-1:2 11 3 4 2 2 2 2 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-2130706429 0 0 0 65537 0;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-520081665 -1073717157 41 0 66047 0;}
@font-face
	{font-family:"TH SarabunPSK";
	panose-1:2 11 5 0 4 2 0 2 0 3;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-1593835409 1342185562 0 0 65923 0;}
@font-face
	{font-family:AngsanaUPC;
	panose-1:2 2 6 3 5 4 5 2 3 4;
	mso-font-charset:0;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:-2130706429 0 0 0 65537 0;}
@font-face
	{font-family:"Monotype Sorts";
	panose-1:1 1 6 1 1 1 1 1 1 1;
	mso-font-charset:2;
	mso-generic-font-family:auto;
	mso-font-pitch:variable;
	mso-font-signature:0 268435456 0 0 -2147483648 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:14.0pt;
	font-family:"Cordia New","sans-serif";
	mso-fareast-font-family:"Cordia New";
	mso-bidi-font-family:"Angsana New";}
h1
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:1;
	tab-stops:42.55pt 2.0cm 70.9pt 3.0cm 99.25pt 4.0cm 127.6pt;
	font-size:16.0pt;
	font-family:"AngsanaUPC","serif";
	mso-font-kerning:0pt;
	font-weight:normal;}
h2
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin:0cm;
	margin-bottom:.0001pt;
	text-align:right;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:2;
	font-size:16.0pt;
	font-family:"AngsanaUPC","serif";}
h3
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin:0cm;
	margin-bottom:.0001pt;
	text-align:center;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:3;
	font-size:16.0pt;
	font-family:"AngsanaUPC","serif";}
h4
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:-14.2pt;
	margin-bottom:.0001pt;
	text-indent:42.55pt;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:4;
	font-size:16.0pt;
	font-family:"AngsanaUPC","serif";
	font-weight:normal;}
h5
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin-top:0cm;
	margin-right:-21.3pt;
	margin-bottom:0cm;
	margin-left:-14.2pt;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:5;
	font-size:16.0pt;
	font-family:"AngsanaUPC","serif";
	font-weight:normal;}
h6
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:-14.2pt;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:6;
	tab-stops:14.2pt;
	font-size:16.0pt;
	font-family:"AngsanaUPC","serif";
	font-weight:normal;}
p.MsoHeading7, li.MsoHeading7, div.MsoHeading7
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:144.0pt;
	margin-bottom:.0001pt;
	text-align:center;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:7;
	font-size:16.0pt;
	font-family:"AngsanaUPC","serif";
	mso-fareast-font-family:"Cordia New";}
p.MsoHeading8, li.MsoHeading8, div.MsoHeading8
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:21.8pt;
	margin-bottom:.0001pt;
	text-align:center;
	text-indent:50.2pt;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:8;
	font-size:16.0pt;
	font-family:"Angsana New","serif";
	mso-fareast-font-family:"Cordia New";
	font-weight:bold;}
p.MsoHeading9, li.MsoHeading9, div.MsoHeading9
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin:0cm;
	margin-bottom:.0001pt;
	text-indent:36.0pt;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:9;
	font-size:14.0pt;
	font-family:"Angsana New","serif";
	mso-fareast-font-family:"Cordia New";
	font-weight:bold;
	text-decoration:underline;
	text-underline:single;}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{mso-style-unhide:no;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:center 207.65pt right 415.3pt;
	font-size:16.0pt;
	font-family:"AngsanaUPC","serif";
	mso-fareast-font-family:"Cordia New";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{mso-style-unhide:no;
	mso-style-link:"ท้ายกระดาษ อักขระ";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:center 225.65pt right 451.3pt;
	font-size:14.0pt;
	mso-bidi-font-size:17.5pt;
	font-family:"Cordia New","sans-serif";
	mso-fareast-font-family:"Cordia New";
	mso-bidi-font-family:"Angsana New";}
p.MsoCaption, li.MsoCaption, div.MsoCaption
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-next:ปกติ;
	margin:0cm;
	margin-bottom:.0001pt;
	text-align:center;
	mso-pagination:widow-orphan;
	font-size:16.0pt;
	font-family:"AngsanaUPC","serif";
	mso-fareast-font-family:"Cordia New";}
p.MsoTitle, li.MsoTitle, div.MsoTitle
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	margin:0cm;
	margin-bottom:.0001pt;
	text-align:center;
	mso-pagination:widow-orphan;
	font-size:20.0pt;
	font-family:"Cordia New","sans-serif";
	mso-fareast-font-family:"Cordia New";
	mso-bidi-font-family:"Angsana New";
	font-weight:bold;}
p.MsoBodyText, li.MsoBodyText, div.MsoBodyText
	{mso-style-unhide:no;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:14.2pt;
	font-size:16.0pt;
	font-family:"AngsanaUPC","serif";
	mso-fareast-font-family:"Cordia New";}
p.MsoBodyTextIndent, li.MsoBodyTextIndent, div.MsoBodyTextIndent
	{mso-style-unhide:no;
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:-14.2pt;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:14.2pt;
	font-size:15.0pt;
	font-family:"AngsanaUPC","serif";
	mso-fareast-font-family:"Cordia New";}
p.MsoBodyText2, li.MsoBodyText2, div.MsoBodyText2
	{mso-style-unhide:no;
	margin-top:0cm;
	margin-right:-21.3pt;
	margin-bottom:0cm;
	margin-left:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:14.2pt 6.0cm;
	font-size:16.0pt;
	font-family:"AngsanaUPC","serif";
	mso-fareast-font-family:"Cordia New";}
p.MsoBodyText3, li.MsoBodyText3, div.MsoBodyText3
	{mso-style-unhide:no;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:49.65pt;
	font-size:12.0pt;
	font-family:"Angsana New","serif";
	mso-fareast-font-family:"Cordia New";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-noshow:yes;
	mso-style-unhide:no;
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:8.0pt;
	mso-bidi-font-size:9.0pt;
	font-family:"Tahoma","sans-serif";
	mso-fareast-font-family:"Cordia New";
	mso-bidi-font-family:"Angsana New";}
span.a
	{mso-style-name:"ท้ายกระดาษ อักขระ";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-parent:"";
	mso-style-link:ท้ายกระดาษ;
	mso-ansi-font-size:14.0pt;
	mso-bidi-font-size:17.5pt;}
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
 @page
	{mso-footnote-separator:url("ts01556.files/header.htm") fs;
	mso-footnote-continuation-separator:url("ts01556.files/header.htm") fcs;
	mso-endnote-separator:url("ts01556.files/header.htm") es;
	mso-endnote-continuation-separator:url("ts01556.files/header.htm") ecs;}
@page WordSection1
	{size:595.3pt 841.9pt;
	margin:35.45pt 56.65pt 7.1pt 63.8pt;
	mso-header-margin:36.0pt;
	mso-footer-margin:11.15pt;
	mso-footer:url("ts01556.files/header.htm") f1;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
 @list l0
	{mso-list-id:66615874;
	mso-list-type:simple;
	mso-list-template-ids:-1050121110;}
@list l0:level1
	{mso-level-start-at:0;
	mso-level-number-format:bullet;
	mso-level-text:-;
	mso-level-tab-stop:60.75pt;
	mso-level-number-position:left;
	margin-left:60.75pt;
	text-indent:-18.0pt;}
@list l1
	{mso-list-id:121581757;
	mso-list-type:simple;
	mso-list-template-ids:426703556;}
@list l1:level1
	{mso-level-start-at:0;
	mso-level-number-format:bullet;
	mso-level-text:-;
	mso-level-tab-stop:48.75pt;
	mso-level-number-position:left;
	margin-left:48.75pt;
	text-indent:-18.0pt;}
@list l2
	{mso-list-id:153498545;
	mso-list-type:simple;
	mso-list-template-ids:-1050121110;}
@list l2:level1
	{mso-level-start-at:0;
	mso-level-number-format:bullet;
	mso-level-text:-;
	mso-level-tab-stop:60.75pt;
	mso-level-number-position:left;
	margin-left:60.75pt;
	text-indent:-18.0pt;}
@list l3
	{mso-list-id:172035086;
	mso-list-type:simple;
	mso-list-template-ids:69074959;}
@list l3:level1
	{mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;}
@list l4
	{mso-list-id:182399986;
	mso-list-type:simple;
	mso-list-template-ids:-1050121110;}
@list l4:level1
	{mso-level-start-at:0;
	mso-level-number-format:bullet;
	mso-level-text:-;
	mso-level-tab-stop:60.75pt;
	mso-level-number-position:left;
	margin-left:60.75pt;
	text-indent:-18.0pt;}
@list l5
	{mso-list-id:185532910;
	mso-list-type:simple;
	mso-list-template-ids:-1050121110;}
@list l5:level1
	{mso-level-start-at:0;
	mso-level-number-format:bullet;
	mso-level-text:-;
	mso-level-tab-stop:60.75pt;
	mso-level-number-position:left;
	margin-left:60.75pt;
	text-indent:-18.0pt;}
@list l6
	{mso-list-id:252934717;
	mso-list-type:simple;
	mso-list-template-ids:2111097140;}
@list l6:level1
	{mso-level-text:"\(%1\)";
	mso-level-tab-stop:36.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l7
	{mso-list-id:275185850;
	mso-list-template-ids:1906336754;}
@list l7:level1
	{mso-level-start-at:2;
	mso-level-text:"\(%1\)";
	mso-level-tab-stop:102.75pt;
	mso-level-number-position:left;
	margin-left:102.75pt;
	text-indent:-18.0pt;}
@list l7:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:138.75pt;
	mso-level-number-position:left;
	margin-left:138.75pt;
	text-indent:-18.0pt;}
@list l7:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:174.75pt;
	mso-level-number-position:right;
	margin-left:174.75pt;
	text-indent:-9.0pt;}
@list l7:level4
	{mso-level-tab-stop:210.75pt;
	mso-level-number-position:left;
	margin-left:210.75pt;
	text-indent:-18.0pt;}
@list l7:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:246.75pt;
	mso-level-number-position:left;
	margin-left:246.75pt;
	text-indent:-18.0pt;}
@list l7:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:282.75pt;
	mso-level-number-position:right;
	margin-left:282.75pt;
	text-indent:-9.0pt;}
@list l7:level7
	{mso-level-tab-stop:318.75pt;
	mso-level-number-position:left;
	margin-left:318.75pt;
	text-indent:-18.0pt;}
@list l7:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:354.75pt;
	mso-level-number-position:left;
	margin-left:354.75pt;
	text-indent:-18.0pt;}
@list l7:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:390.75pt;
	mso-level-number-position:right;
	margin-left:390.75pt;
	text-indent:-9.0pt;}
@list l8
	{mso-list-id:489173272;
	mso-list-template-ids:590675362;}
@list l8:level1
	{mso-level-start-at:3;
	mso-level-text:%1;
	mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;}
@list l8:level2
	{mso-level-start-at:2;
	mso-level-text:"%1\.%2";
	mso-level-tab-stop:30.75pt;
	mso-level-number-position:left;
	margin-left:30.75pt;
	text-indent:-18.0pt;}
@list l8:level3
	{mso-level-text:"%1\.%2\.%3";
	mso-level-tab-stop:61.5pt;
	mso-level-number-position:left;
	margin-left:61.5pt;
	text-indent:-36.0pt;}
@list l8:level4
	{mso-level-text:"%1\.%2\.%3\.%4";
	mso-level-tab-stop:74.25pt;
	mso-level-number-position:left;
	margin-left:74.25pt;
	text-indent:-36.0pt;}
@list l8:level5
	{mso-level-text:"%1\.%2\.%3\.%4\.%5";
	mso-level-tab-stop:105.0pt;
	mso-level-number-position:left;
	margin-left:105.0pt;
	text-indent:-54.0pt;}
@list l8:level6
	{mso-level-text:"%1\.%2\.%3\.%4\.%5\.%6";
	mso-level-tab-stop:117.75pt;
	mso-level-number-position:left;
	margin-left:117.75pt;
	text-indent:-54.0pt;}
@list l8:level7
	{mso-level-text:"%1\.%2\.%3\.%4\.%5\.%6\.%7";
	mso-level-tab-stop:130.5pt;
	mso-level-number-position:left;
	margin-left:130.5pt;
	text-indent:-54.0pt;}
@list l8:level8
	{mso-level-text:"%1\.%2\.%3\.%4\.%5\.%6\.%7\.%8";
	mso-level-tab-stop:161.25pt;
	mso-level-number-position:left;
	margin-left:161.25pt;
	text-indent:-72.0pt;}
@list l8:level9
	{mso-level-text:"%1\.%2\.%3\.%4\.%5\.%6\.%7\.%8\.%9";
	mso-level-tab-stop:174.0pt;
	mso-level-number-position:left;
	margin-left:174.0pt;
	text-indent:-72.0pt;}
@list l9
	{mso-list-id:577447432;
	mso-list-type:simple;
	mso-list-template-ids:-2035106678;}
@list l9:level1
	{mso-level-text:"\(%1\)";
	mso-level-tab-stop:36.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l10
	{mso-list-id:650601616;
	mso-list-type:simple;
	mso-list-template-ids:69074945;}
@list l10:level1
	{mso-level-number-format:bullet;
	mso-level-text:\F0B7;
	mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;
	font-family:"Times New Roman","serif";
	mso-hansi-font-family:Symbol;}
@list l11
	{mso-list-id:713769392;
	mso-list-type:simple;
	mso-list-template-ids:69074959;}
@list l11:level1
	{mso-level-start-at:3;
	mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;}
@list l12
	{mso-list-id:857159287;
	mso-list-type:simple;
	mso-list-template-ids:69074945;}
@list l12:level1
	{mso-level-number-format:bullet;
	mso-level-text:\F0B7;
	mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;
	font-family:"Times New Roman","serif";
	mso-hansi-font-family:Symbol;}
@list l13
	{mso-list-id:913515337;
	mso-list-type:simple;
	mso-list-template-ids:-659142588;}
@list l13:level1
	{mso-level-start-at:26;
	mso-level-number-format:bullet;
	mso-level-text:\F071;
	mso-level-tab-stop:54.05pt;
	mso-level-number-position:left;
	margin-left:54.05pt;
	text-indent:-18.0pt;
	font-family:"Times New Roman","serif";
	mso-hansi-font-family:"Monotype Sorts";}
@list l14
	{mso-list-id:960183958;
	mso-list-type:simple;
	mso-list-template-ids:69074945;}
@list l14:level1
	{mso-level-number-format:bullet;
	mso-level-text:\F0B7;
	mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;
	font-family:"Times New Roman","serif";
	mso-hansi-font-family:Symbol;}
@list l15
	{mso-list-id:1029912601;
	mso-list-type:hybrid;
	mso-list-template-ids:1374586876 67698703 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l15:level1
	{mso-level-start-at:2;
	mso-level-tab-stop:36.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l15:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:72.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l15:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:108.0pt;
	mso-level-number-position:right;
	text-indent:-9.0pt;}
@list l15:level4
	{mso-level-tab-stop:144.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l15:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:180.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l15:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:216.0pt;
	mso-level-number-position:right;
	text-indent:-9.0pt;}
@list l15:level7
	{mso-level-tab-stop:252.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l15:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:288.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l15:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:324.0pt;
	mso-level-number-position:right;
	text-indent:-9.0pt;}
@list l16
	{mso-list-id:1044719772;
	mso-list-type:simple;
	mso-list-template-ids:619510228;}
@list l16:level1
	{mso-level-start-at:2;
	mso-level-number-format:bullet;
	mso-level-text:\F071;
	mso-level-tab-stop:378.05pt;
	mso-level-number-position:left;
	margin-left:378.05pt;
	text-indent:-18.0pt;
	font-family:"Times New Roman","serif";
	mso-hansi-font-family:"Monotype Sorts";}
@list l17
	{mso-list-id:1059474723;
	mso-list-type:simple;
	mso-list-template-ids:-724284696;}
@list l17:level1
	{mso-level-text:"\(%1\)";
	mso-level-tab-stop:36.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l18
	{mso-list-id:1173691657;
	mso-list-type:simple;
	mso-list-template-ids:-1050121110;}
@list l18:level1
	{mso-level-start-at:0;
	mso-level-number-format:bullet;
	mso-level-text:-;
	mso-level-tab-stop:60.75pt;
	mso-level-number-position:left;
	margin-left:60.75pt;
	text-indent:-18.0pt;}
@list l19
	{mso-list-id:1239706042;
	mso-list-type:simple;
	mso-list-template-ids:-1050121110;}
@list l19:level1
	{mso-level-start-at:0;
	mso-level-number-format:bullet;
	mso-level-text:-;
	mso-level-tab-stop:60.75pt;
	mso-level-number-position:left;
	margin-left:60.75pt;
	text-indent:-18.0pt;}
@list l20
	{mso-list-id:1269629392;
	mso-list-type:simple;
	mso-list-template-ids:69074945;}
@list l20:level1
	{mso-level-number-format:bullet;
	mso-level-text:\F0B7;
	mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;
	font-family:"Times New Roman","serif";
	mso-hansi-font-family:Symbol;}
@list l21
	{mso-list-id:1345016433;
	mso-list-type:simple;
	mso-list-template-ids:69074959;}
@list l21:level1
	{mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;}
@list l22
	{mso-list-id:1541015248;
	mso-list-type:simple;
	mso-list-template-ids:426703556;}
@list l22:level1
	{mso-level-start-at:0;
	mso-level-number-format:bullet;
	mso-level-text:-;
	mso-level-tab-stop:48.75pt;
	mso-level-number-position:left;
	margin-left:48.75pt;
	text-indent:-18.0pt;}
@list l23
	{mso-list-id:1620069017;
	mso-list-template-ids:346834850;}
@list l23:level1
	{mso-level-tab-stop:54.0pt;
	mso-level-number-position:left;
	margin-left:54.0pt;
	text-indent:-18.0pt;}
@list l23:level2
	{mso-level-legal-format:yes;
	mso-level-text:"%1\.%2";
	mso-level-tab-stop:72.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l23:level3
	{mso-level-legal-format:yes;
	mso-level-text:"%1\.%2\.%3";
	mso-level-tab-stop:108.0pt;
	mso-level-number-position:left;
	text-indent:-36.0pt;}
@list l23:level4
	{mso-level-legal-format:yes;
	mso-level-text:"%1\.%2\.%3\.%4";
	mso-level-tab-stop:126.0pt;
	mso-level-number-position:left;
	margin-left:126.0pt;
	text-indent:-36.0pt;}
@list l23:level5
	{mso-level-legal-format:yes;
	mso-level-text:"%1\.%2\.%3\.%4\.%5";
	mso-level-tab-stop:162.0pt;
	mso-level-number-position:left;
	margin-left:162.0pt;
	text-indent:-54.0pt;}
@list l23:level6
	{mso-level-legal-format:yes;
	mso-level-text:"%1\.%2\.%3\.%4\.%5\.%6";
	mso-level-tab-stop:180.0pt;
	mso-level-number-position:left;
	margin-left:180.0pt;
	text-indent:-54.0pt;}
@list l23:level7
	{mso-level-legal-format:yes;
	mso-level-text:"%1\.%2\.%3\.%4\.%5\.%6\.%7";
	mso-level-tab-stop:198.0pt;
	mso-level-number-position:left;
	margin-left:198.0pt;
	text-indent:-54.0pt;}
@list l23:level8
	{mso-level-legal-format:yes;
	mso-level-text:"%1\.%2\.%3\.%4\.%5\.%6\.%7\.%8";
	mso-level-tab-stop:234.0pt;
	mso-level-number-position:left;
	margin-left:234.0pt;
	text-indent:-72.0pt;}
@list l23:level9
	{mso-level-legal-format:yes;
	mso-level-text:"%1\.%2\.%3\.%4\.%5\.%6\.%7\.%8\.%9";
	mso-level-tab-stop:252.0pt;
	mso-level-number-position:left;
	margin-left:252.0pt;
	text-indent:-72.0pt;}
@list l24
	{mso-list-id:1685745475;
	mso-list-type:simple;
	mso-list-template-ids:69074959;}
@list l24:level1
	{mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;}
@list l25
	{mso-list-id:1806239322;
	mso-list-type:simple;
	mso-list-template-ids:-1116581946;}
@list l25:level1
	{mso-level-start-at:3;
	mso-level-text:"\(%1\)";
	mso-level-tab-stop:36.0pt;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l26
	{mso-list-id:1899167867;
	mso-list-type:simple;
	mso-list-template-ids:69074959;}
@list l26:level1
	{mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;}
@list l27
	{mso-list-id:1906716004;
	mso-list-type:simple;
	mso-list-template-ids:69074945;}
@list l27:level1
	{mso-level-number-format:bullet;
	mso-level-text:\F0B7;
	mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;
	font-family:"Times New Roman","serif";
	mso-hansi-font-family:Symbol;}
@list l28
	{mso-list-id:1923179062;
	mso-list-type:simple;
	mso-list-template-ids:69074959;}
@list l28:level1
	{mso-level-start-at:4;
	mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;}
@list l29
	{mso-list-id:1927112397;
	mso-list-type:hybrid;
	mso-list-template-ids:-770150948 67698703 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l29:level1
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l29:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l29:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	text-indent:-9.0pt;}
@list l29:level4
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l29:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l29:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	text-indent:-9.0pt;}
@list l29:level7
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l29:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	text-indent:-18.0pt;}
@list l29:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	text-indent:-9.0pt;}
@list l30
	{mso-list-id:2101874419;
	mso-list-type:simple;
	mso-list-template-ids:69074959;}
@list l30:level1
	{mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;}
@list l31
	{mso-list-id:2130930787;
	mso-list-template-ids:-919931652;}
@list l31:level1
	{mso-level-start-at:3;
	mso-level-text:%1;
	mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;}
@list l31:level2
	{mso-level-text:"%1\.%2";
	mso-level-tab-stop:30.75pt;
	mso-level-number-position:left;
	margin-left:30.75pt;
	text-indent:-18.0pt;}
@list l31:level3
	{mso-level-text:"%1\.%2\.%3";
	mso-level-tab-stop:61.5pt;
	mso-level-number-position:left;
	margin-left:61.5pt;
	text-indent:-36.0pt;}
@list l31:level4
	{mso-level-text:"%1\.%2\.%3\.%4";
	mso-level-tab-stop:74.25pt;
	mso-level-number-position:left;
	margin-left:74.25pt;
	text-indent:-36.0pt;}
@list l31:level5
	{mso-level-text:"%1\.%2\.%3\.%4\.%5";
	mso-level-tab-stop:105.0pt;
	mso-level-number-position:left;
	margin-left:105.0pt;
	text-indent:-54.0pt;}
@list l31:level6
	{mso-level-text:"%1\.%2\.%3\.%4\.%5\.%6";
	mso-level-tab-stop:117.75pt;
	mso-level-number-position:left;
	margin-left:117.75pt;
	text-indent:-54.0pt;}
@list l31:level7
	{mso-level-text:"%1\.%2\.%3\.%4\.%5\.%6\.%7";
	mso-level-tab-stop:130.5pt;
	mso-level-number-position:left;
	margin-left:130.5pt;
	text-indent:-54.0pt;}
@list l31:level8
	{mso-level-text:"%1\.%2\.%3\.%4\.%5\.%6\.%7\.%8";
	mso-level-tab-stop:161.25pt;
	mso-level-number-position:left;
	margin-left:161.25pt;
	text-indent:-72.0pt;}
@list l31:level9
	{mso-level-text:"%1\.%2\.%3\.%4\.%5\.%6\.%7\.%8\.%9";
	mso-level-tab-stop:174.0pt;
	mso-level-number-position:left;
	margin-left:174.0pt;
	text-indent:-72.0pt;}
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
	font-family:"Cordia New","sans-serif";
	mso-bidi-font-family:"Angsana New";}
table.MsoTableGrid
	{mso-style-name:เส้นตาราง;
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-unhide:no;
	border:solid windowtext 1.0pt;
	mso-border-alt:solid windowtext .5pt;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-border-insideh:.5pt solid windowtext;
	mso-border-insidev:.5pt solid windowtext;
	mso-para-margin:0cm;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Cordia New","sans-serif";
	mso-bidi-font-family:"Angsana New";}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:shapedefaults v:ext="edit" spidmax="2049"/>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <o:shapelayout v:ext="edit">
  <o:idmap v:ext="edit" data="1"/>
 </o:shapelayout></xml><![endif]-->
</head>

<body lang=EN-US style='tab-interval:36.0pt' onLoad="window.print()">

<div class=WordSection1>

<p class=MsoNormal align=center style='text-align:center'><!--[if gte vml 1]><v:shapetype
 id="_x0000_t202" coordsize="21600,21600" o:spt="202" path="m,l,21600r21600,l21600,xe">
 <v:stroke joinstyle="miter"/>
 <v:path gradientshapeok="t" o:connecttype="rect"/>
</v:shapetype><v:shape id="_x0000_s1043" type="#_x0000_t202" style='position:absolute;
 left:0;text-align:left;margin-left:344.95pt;margin-top:-16.5pt;width:162.75pt;
 height:50.05pt;z-index:251657216' stroked="f">
 <v:textbox style='mso-next-textbox:#_x0000_s1043'/>
</v:shape><![endif]--><![if !vml]>
<![endif]><span style='font-size:16.0pt;font-family:"TH SarabunPSK","sans-serif"'><!--[if gte vml 1]><v:shapetype
 id="_x0000_t75" coordsize="21600,21600" o:spt="75" o:preferrelative="t"
 path="m@4@5l@4@11@9@11@9@5xe" filled="f" stroked="f">
 <v:stroke joinstyle="miter"/>
 <v:formulas>
  <v:f eqn="if lineDrawn pixelLineWidth 0"/>
  <v:f eqn="sum @0 1 0"/>
  <v:f eqn="sum 0 0 @1"/>
  <v:f eqn="prod @2 1 2"/>
  <v:f eqn="prod @3 21600 pixelWidth"/>
  <v:f eqn="prod @3 21600 pixelHeight"/>
  <v:f eqn="sum @0 0 1"/>
  <v:f eqn="prod @6 1 2"/>
  <v:f eqn="prod @7 21600 pixelWidth"/>
  <v:f eqn="sum @8 21600 0"/>
  <v:f eqn="prod @7 21600 pixelHeight"/>
  <v:f eqn="sum @10 21600 0"/>
 </v:formulas>
 <v:path o:extrusionok="f" gradientshapeok="t" o:connecttype="rect"/>
 <o:lock v:ext="edit" aspectratio="t"/>
</v:shapetype><v:shape id="_x0000_i1025" type="#_x0000_t75" style='width:47.4pt;
 height:61.8pt' fillcolor="window">
 <v:imagedata src="ts01556.files/image003.png" o:title=""/>
</v:shape><![endif]--><![if !vml]><img width=79 height=103
src="images/image004.png" v:shapes="_x0000_i1025"><![endif]><o:p></o:p></span></p>

<p class=MsoCaption><b><span lang=TH style='font-size:14.0pt;font-family:"TH SarabunPSK","sans-serif"'>บัณฑิตวิทยาลัย<span
style='mso-spacerun:yes'>&nbsp; </span>มหาวิทยาลัยมหาสารคาม</span></b><b><span
style='font-size:14.0pt;font-family:"TH SarabunPSK","sans-serif"'><o:p></o:p></span></b></p>

<h3><span lang=TH style='font-size:14.0pt;font-family:"TH SarabunPSK","sans-serif"'>แบบขออนุมัติชื่อเรื่องวิทยานิพนธ์<span
style='mso-spacerun:yes'>&nbsp; </span>และแต่งตั้งอาจารย์ที่ปรึกษาวิทยานิพนธ์</span><span
style='font-size:14.0pt;font-family:"TH SarabunPSK","sans-serif"'><o:p></o:p></span></h3>

<p class=MsoNormal align=center style='text-align:center'><span
style='font-family:"TH SarabunPSK","sans-serif"'>-------------------------------------<o:p></o:p></span></p>

<p class=MsoNormal style='margin-right:-28.4pt'><span lang=TH style='font-family:
"TH SarabunPSK","sans-serif"'>ข้าพเจ้า<span style='mso-spacerun:yes'>&nbsp;
</span></span><span style='font-family:"TH SarabunPSK","sans-serif"'>(<span
lang=TH>นาย</span>/<span lang=TH>นาง</span>/<span lang=TH>นางสาว</span>) <?=$row_aa['std_fname_th'];?>&nbsp;<?=$row_aa['std_lname_th'];?>  <span
style='mso-spacerun:yes'>&nbsp; </span><span lang=TH>รหัส <span
style='mso-spacerun:yes'>&nbsp;</span></span> <?=$row_aa['std_id_std'];?><span lang=TH>
<o:p></o:p></span></span></p>

<p class=MsoNormal style='margin-right:-21.3pt'><span lang=TH style='font-family:
"TH SarabunPSK","sans-serif"'>นิสิตคณะ</span><span style='font-family:
"TH SarabunPSK","sans-serif"'><span style='mso-spacerun:yes'>&nbsp; </span><span style="font-family:&quot;TH SarabunPSK&quot;,&quot;sans-serif&quot;">
  <?=$row_aa['std_faculty_th'];?>
</span><span style='mso-spacerun:yes'>&nbsp;&nbsp;</span><span lang=TH>สาขาวิชา </span><span style="font-family:&quot;TH SarabunPSK&quot;,&quot;sans-serif&quot;">
<?=$row_aa['std_major_th'];?>
</span> ระบบ <span style="font-family:&quot;TH SarabunPSK&quot;,&quot;sans-serif&quot;">
<?=$row_aa['std_degree_th'];?>
</span>
<o:p></o:p></span></p>

<p class=MsoNormal style='margin-right:-21.3pt'><span lang=TH style='font-family:"TH SarabunPSK","sans-serif"'>ขออนุมัติชื่อเรื่องและแต่งตั้งอาจารย์ที่ปรึกษาวิทยานิพนธ์<span
style='mso-spacerun:yes'>&nbsp; </span></span><span style='font-family:"TH SarabunPSK","sans-serif"'>
  <o:p></o:p>
</span></p>

<p class=MsoNormal style='margin-left:-14.2pt;text-indent:28.4pt'><span
style='font-size:8.0pt;font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><b><span style='font-family:"TH SarabunPSK","sans-serif"'>1.<span
style='mso-spacerun:yes'>&nbsp; </span><span class=GramE><span lang=TH>ชื่อเรื่อง</span><span
style='font-weight:normal'><span style='mso-spacerun:yes'>&nbsp; </span></span><span
lang=TH>(</span></span><span lang=TH>ภาษาไทย</span></span></b><span
style='font-family:"TH SarabunPSK","sans-serif"'><o:p></o:p>
)
</span><span style="font-family:&quot;TH SarabunPSK&quot;,&quot;sans-serif&quot;">
<?=$row_aa['title_th'];?>
</span></p>

<p class=MsoNormal style='tab-stops:14.2pt'><span style='font-size:8.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='tab-stops:14.2pt'><span style='font-family:"TH SarabunPSK","sans-serif"'><span
style='mso-tab-count:1'>&nbsp;&nbsp;&nbsp;&nbsp; </span><b>(<span lang=TH>ภาษาอังกฤษ)</span>
  <o:p></o:p></b></span><span style="font-family:&quot;TH SarabunPSK&quot;,&quot;sans-serif&quot;">
  <?=$row_aa['title_en'];?>
  </span></p>

<p class=MsoNormal style='tab-stops:14.2pt'><span style='font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='tab-stops:14.2pt'><span style='font-size:8.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:-14.2pt'><span style='font-family:"TH SarabunPSK","sans-serif"'><span
style='mso-tab-count:5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span
lang=TH>ลงชื่อ</span><?php if($row_aa['std_signature']!="") { ?><img src="digital-e-signature/doc_signs/<?=$row_aa['std_signature'];?>.png"><?php } ?><span
style='mso-spacerun:yes'>&nbsp; </span><span lang=TH><span
style='mso-spacerun:yes'>&nbsp;&nbsp;</span>นิสิต<o:p></o:p></span></span></p>

<p class=MsoNormal style='margin-left:-14.2pt'><span style='font-family:"TH SarabunPSK","sans-serif"'><span
style='mso-tab-count:4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>(
<?=$row_aa['std_fname_th'];?>
<?=$row_aa['std_lname_th'];?>
)<span
lang=TH><span style='mso-spacerun:yes'>&nbsp;&nbsp; </span><?php echo DateThai1($row_aa['std_date_signature']);?></span></p>

<p class=MsoNormal style='margin-left:-14.2pt;tab-stops:14.2pt'><span
style='font-size:4.0pt;font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='tab-stops:14.2pt'><b><span style='font-family:"TH SarabunPSK","sans-serif"'>2.<span
style='mso-spacerun:yes'>&nbsp; </span><span lang=TH>อาจารย์ที่ปรึกษาวิทยานิพนธ์</span><o:p></o:p></span></b></p>

<p class=MsoNormal style='margin-left:-14.2pt'><span style='font-family:"TH SarabunPSK","sans-serif"'><span
style='mso-tab-count:2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><b><span
lang=TH>(<span style='mso-spacerun:yes'><?php if($row_aa['advisor_status']==1){ echo "/"; }?></span>)</span></b><span
style='mso-spacerun:yes'>&nbsp; </span><b><span lang=TH>อนุมัติ</span></b><o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:-14.2pt;text-indent:50.2pt'><b><span
lang=TH style='font-family:"TH SarabunPSK","sans-serif"'>(<span
style='mso-spacerun:yes'><?php if($row_aa['advisor_status']==2){ echo "/"; }?></span>)</span></b><span
style='font-family:"TH SarabunPSK","sans-serif"'><span
style='mso-spacerun:yes'>&nbsp; </span><b><span lang=TH>ไม่อนุมัติ</span></b><span
lang=TH> <span style='mso-spacerun:yes'>&nbsp;</span>เนื่องจาก</span><o:p></o:p></span></p>

<p class=MsoNormal style='tab-stops:14.2pt'><span style='font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:-14.2pt'><span style='font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:-14.2pt'><span style='font-family:"TH SarabunPSK","sans-serif"'><span
style='mso-tab-count:4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span
lang=TH>ลงชื่อ</span>
  <?php if($row_aa['advisor_signature']!="") { ?>
  <img src="digital-e-signature/doc_signs/<?=$row_aa['advisor_signature'];?>.png">
  <?php } ?>
  <span
style='mso-spacerun:yes'>&nbsp; </span><o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:-14.2pt'><span style='font-family:"TH SarabunPSK","sans-serif"'><span
style='mso-tab-count:3'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span><span style='mso-spacerun:yes'>&nbsp;</span>( <?php

									 $sql_advisor = "Select prefixname,advisorname,advisorsurname FROM request_advisor WHERE advisorcode = '$row_aa[advisor_code]' ";
									 $rs_advisor = $mysqli->query($sql_advisor);
									  $row_advisor = $rs_advisor->fetch_array();
										echo $row_advisor['prefixname'].$row_advisor['advisorname']." ".$row_advisor['advisorsurname'];
										echo $row['advisor_chairman'];
							
									  ?>)
<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:-14.2pt'><span style='font-family:"TH SarabunPSK","sans-serif"'><span
style='mso-tab-count:4'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span><span lang=TH><?php echo DateThai1($row_aa['advisor_date_signature']);?></span></p>

<p class=MsoNormal style='margin-left:-14.2pt'><span style='font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:-14.2pt'><span style='font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-left:36.0pt'><span style='font-size:12.0pt;
font-family:"TH SarabunPSK","sans-serif"'><o:p>&nbsp;</o:p></span></p>

<span style='font-size:12.0pt;line-height:90%;font-family:"TH SarabunPSK","sans-serif";
mso-fareast-font-family:"Cordia New";mso-ansi-language:EN-US;mso-fareast-language:
EN-US;mso-bidi-language:TH'><br clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal align=center style='margin-left:36.0pt;text-align:center;
text-indent:-36.0pt;line-height:90%'>&nbsp;</p>
</div>
</body>

</html>
