<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename=certificate-advisor.doc");
require_once( "inc/db_connect.php" );
$mysqli = connect();

//== 
 $doc_id = base64_decode( $_REQUEST[ id ] );
  $sql_aa = "SELECT * FROM request_doc INNER JOIN request_certificate_thesis_advisor ON request_doc.doc_id=request_certificate_thesis_advisor.doc_id WHERE request_certificate_thesis_advisor.doc_id=" . $doc_id;
$result_aa = $mysqli->query( $sql_aa );
$row_aa = $result_aa->fetch_array();
//===
  $sql_name = "Select std_id_std,std_fname_th,std_lname_th,std_degree_th,std_major_th,std_faculty_th FROM request_student WHERE std_id_std = '$row_aa[doc_std_id]' ";
  $rs_name = $mysqli->query($sql_name);
  $row_name = $rs_name->fetch_array();
?>
<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta charset="utf-8">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 15">
<meta name=Originator content="Microsoft Word 15">
<link rel=File-List href="Test001_files/filelist.xml">
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>NRCT</o:Author>
  <o:Template>Normal</o:Template>
  <o:LastAuthor>kimhun-nb</o:LastAuthor>
  <o:Revision>2</o:Revision>
  <o:TotalTime>0</o:TotalTime>
  <o:LastPrinted>2020-12-26T07:55:00Z</o:LastPrinted>
  <o:Created>2021-03-30T06:58:00Z</o:Created>
  <o:LastSaved>2021-03-30T06:58:00Z</o:LastSaved>
  <o:Pages>1</o:Pages>
  <o:Words>141</o:Words>
  <o:Characters>806</o:Characters>
  <o:Company>Hewlett-Packard Company</o:Company>
  <o:Lines>6</o:Lines>
  <o:Paragraphs>1</o:Paragraphs>
  <o:CharactersWithSpaces>946</o:CharactersWithSpaces>
  <o:Version>16.00</o:Version>
 </o:DocumentProperties>
 <o:OfficeDocumentSettings>
  <o:RelyOnVML/>
  <o:AllowPNG/>
 </o:OfficeDocumentSettings>
</xml><![endif]-->
<link rel=themeData href="Test001_files/themedata.thmx">
<link rel=colorSchemeMapping href="Test001_files/colorschememapping.xml">
<!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:SpellingState>Clean</w:SpellingState>
  <w:GrammarState>Clean</w:GrammarState>
  <w:TrackMoves>false</w:TrackMoves>
  <w:TrackFormatting/>
  <w:PunctuationKerning/>
  <w:ValidateAgainstSchemas/>
  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
  <w:DoNotPromoteQF/>
  <w:LidThemeOther>EN-US</w:LidThemeOther>
  <w:LidThemeAsian>X-NONE</w:LidThemeAsian>
  <w:LidThemeComplexScript>TH</w:LidThemeComplexScript>
  <w:Compatibility>
   <w:BreakWrappedTables/>
   <w:SnapToGridInCell/>
   <w:ApplyBreakingRules/>
   <w:WrapTextWithPunct/>
   <w:UseAsianBreakRules/>
   <w:DontGrowAutofit/>
   <w:SplitPgBreakAndParaMark/>
   <w:EnableOpenTypeKerning/>
   <w:DontFlipMirrorIndents/>
   <w:OverrideTableStyleHps/>
  </w:Compatibility>
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
  DefSemiHidden="false" DefQFormat="false" DefPriority="99"
  LatentStyleCount="371">
  <w:LsdException Locked="false" Priority="0" QFormat="true" Name="Normal"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 1"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 2"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 3"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 4"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 5"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 6"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 7"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 8"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 9"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 6"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 7"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 8"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 9"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 1"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 2"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 3"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 4"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 5"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 6"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 7"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 8"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 9"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Normal Indent"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="footnote text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="annotation text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="header"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="footer"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index heading"/>
  <w:LsdException Locked="false" Priority="35" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="caption"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="table of figures"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="envelope address"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="envelope return"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="footnote reference"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="annotation reference"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="line number"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="page number"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="endnote reference"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="endnote text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="table of authorities"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="macro"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="toa heading"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number 5"/>
  <w:LsdException Locked="false" Priority="10" QFormat="true" Name="Title"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Closing"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Signature"/>
  <w:LsdException Locked="false" Priority="1" SemiHidden="true"
   UnhideWhenUsed="true" Name="Default Paragraph Font"/>
  <w:LsdException Locked="false" Priority="0" SemiHidden="true"
   UnhideWhenUsed="true" Name="Body Text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text Indent"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Message Header"/>
  <w:LsdException Locked="false" Priority="11" QFormat="true" Name="Subtitle"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Salutation"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Date"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text First Indent"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text First Indent 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Note Heading"/>
  <w:LsdException Locked="false" Priority="0" SemiHidden="true"
   UnhideWhenUsed="true" Name="Body Text 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text Indent 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text Indent 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Block Text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Hyperlink"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="FollowedHyperlink"/>
  <w:LsdException Locked="false" Priority="22" QFormat="true" Name="Strong"/>
  <w:LsdException Locked="false" Priority="20" QFormat="true" Name="Emphasis"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Document Map"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Plain Text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="E-mail Signature"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Top of Form"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Bottom of Form"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Normal (Web)"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Acronym"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Address"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Cite"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Code"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Definition"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Keyboard"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Preformatted"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Sample"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Typewriter"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Variable"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Normal Table"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="annotation subject"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="No List"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Outline List 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Outline List 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Outline List 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Simple 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Simple 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Simple 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Classic 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Classic 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Classic 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Classic 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Colorful 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Colorful 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Colorful 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 6"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 7"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 8"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 6"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 7"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 8"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table 3D effects 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table 3D effects 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table 3D effects 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Contemporary"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Elegant"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Professional"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Subtle 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Subtle 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Web 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Web 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Web 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Balloon Text"/>
  <w:LsdException Locked="false" Priority="39" Name="Table Grid"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Theme"/>
  <w:LsdException Locked="false" SemiHidden="true" Name="Placeholder Text"/>
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
  <w:LsdException Locked="false" SemiHidden="true" Name="Revision"/>
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
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-536870145 1073786111 1 0 415 0;}
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
	{font-family:"TH SarabunIT๙";
	mso-font-alt:"TH SarabunPSK";
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:0 1342185562 0 0 65923 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:8.0pt;
	margin-left:0cm;
	line-height:107%;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	mso-bidi-font-size:14.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Cordia New";
	mso-bidi-theme-font:minor-bidi;}
p.MsoBodyText, li.MsoBodyText, div.MsoBodyText
	{mso-style-unhide:no;
	mso-style-link:"Body Text Char";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:14.2pt;
	font-size:16.0pt;
	font-family:"AngsanaUPC",serif;
	mso-fareast-font-family:"Cordia New";}
p.MsoBodyText2, li.MsoBodyText2, div.MsoBodyText2
	{mso-style-unhide:no;
	mso-style-link:"Body Text 2 Char";
	margin-top:0cm;
	margin-right:-21.3pt;
	margin-bottom:0cm;
	margin-left:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:14.2pt 6.0cm;
	font-size:16.0pt;
	font-family:"AngsanaUPC",serif;
	mso-fareast-font-family:"Cordia New";}
p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
	{mso-style-priority:34;
	mso-style-unhide:no;
	mso-style-qformat:yes;
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:8.0pt;
	margin-left:36.0pt;
	mso-add-space:auto;
	line-height:107%;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	mso-bidi-font-size:14.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Cordia New";
	mso-bidi-theme-font:minor-bidi;}
p.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst
	{mso-style-priority:34;
	mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-type:export-only;
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:36.0pt;
	margin-bottom:.0001pt;
	mso-add-space:auto;
	line-height:107%;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	mso-bidi-font-size:14.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Cordia New";
	mso-bidi-theme-font:minor-bidi;}
p.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle
	{mso-style-priority:34;
	mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-type:export-only;
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:36.0pt;
	margin-bottom:.0001pt;
	mso-add-space:auto;
	line-height:107%;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	mso-bidi-font-size:14.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Cordia New";
	mso-bidi-theme-font:minor-bidi;}
p.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast
	{mso-style-priority:34;
	mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-type:export-only;
	margin-top:0cm;
	margin-right:0cm;
	margin-bottom:8.0pt;
	margin-left:36.0pt;
	mso-add-space:auto;
	line-height:107%;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	mso-bidi-font-size:14.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Cordia New";
	mso-bidi-theme-font:minor-bidi;}
span.BodyTextChar
	{mso-style-name:"Body Text Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-link:"Body Text";
	mso-ansi-font-size:16.0pt;
	mso-bidi-font-size:16.0pt;
	font-family:"AngsanaUPC",serif;
	mso-ascii-font-family:AngsanaUPC;
	mso-fareast-font-family:"Cordia New";
	mso-hansi-font-family:AngsanaUPC;
	mso-bidi-font-family:AngsanaUPC;}
span.BodyText2Char
	{mso-style-name:"Body Text 2 Char";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-link:"Body Text 2";
	mso-ansi-font-size:16.0pt;
	mso-bidi-font-size:16.0pt;
	font-family:"AngsanaUPC",serif;
	mso-ascii-font-family:AngsanaUPC;
	mso-fareast-font-family:"Cordia New";
	mso-hansi-font-family:AngsanaUPC;
	mso-bidi-font-family:AngsanaUPC;}
span.apple-converted-space
	{mso-style-name:apple-converted-space;
	mso-style-unhide:no;
	mso-style-parent:"";}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Cordia New";
	mso-bidi-theme-font:minor-bidi;}
.MsoPapDefault
	{mso-style-type:export-only;
	margin-bottom:8.0pt;
	line-height:107%;}
@page WordSection1
	{size:595.3pt 841.9pt;
	margin:72.0pt 72.0pt 49.5pt 72.0pt;
	mso-header-margin:35.4pt;
	mso-footer-margin:35.4pt;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
 @list l0
	{mso-list-id:214388122;
	mso-list-type:hybrid;
	mso-list-template-ids:-1353546676 -269612964 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l0:level1
	{mso-level-number-format:thai-2;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:90.0pt;
	text-indent:-18.0pt;
	mso-ascii-font-family:"TH SarabunPSK";
	mso-fareast-font-family:"Cordia New";
	mso-hansi-font-family:"TH SarabunPSK";
	mso-bidi-font-family:"TH SarabunPSK";}
@list l0:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:126.0pt;
	text-indent:-18.0pt;}
@list l0:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:162.0pt;
	text-indent:-9.0pt;}
@list l0:level4
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:198.0pt;
	text-indent:-18.0pt;}
@list l0:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:234.0pt;
	text-indent:-18.0pt;}
@list l0:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:270.0pt;
	text-indent:-9.0pt;}
@list l0:level7
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:306.0pt;
	text-indent:-18.0pt;}
@list l0:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:342.0pt;
	text-indent:-18.0pt;}
@list l0:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:378.0pt;
	text-indent:-9.0pt;}
@list l1
	{mso-list-id:393700777;
	mso-list-type:hybrid;
	mso-list-template-ids:2127199508 -960183918 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l1:level1
	{mso-level-number-format:thai-2;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:90.0pt;
	text-indent:-18.0pt;
	mso-ascii-font-family:"TH SarabunPSK";
	mso-fareast-font-family:"Cordia New";
	mso-hansi-font-family:"TH SarabunPSK";
	mso-bidi-font-family:"TH SarabunPSK";}
@list l1:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:126.0pt;
	text-indent:-18.0pt;}
@list l1:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:162.0pt;
	text-indent:-9.0pt;}
@list l1:level4
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:198.0pt;
	text-indent:-18.0pt;}
@list l1:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:234.0pt;
	text-indent:-18.0pt;}
@list l1:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:270.0pt;
	text-indent:-9.0pt;}
@list l1:level7
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:306.0pt;
	text-indent:-18.0pt;}
@list l1:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:342.0pt;
	text-indent:-18.0pt;}
@list l1:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:378.0pt;
	text-indent:-9.0pt;}
@list l2
	{mso-list-id:461507750;
	mso-list-type:hybrid;
	mso-list-template-ids:2127199508 -960183918 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l2:level1
	{mso-level-number-format:thai-2;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:90.0pt;
	text-indent:-18.0pt;
	mso-ascii-font-family:"TH SarabunPSK";
	mso-fareast-font-family:"Cordia New";
	mso-hansi-font-family:"TH SarabunPSK";
	mso-bidi-font-family:"TH SarabunPSK";}
@list l2:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:126.0pt;
	text-indent:-18.0pt;}
@list l2:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:162.0pt;
	text-indent:-9.0pt;}
@list l2:level4
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:198.0pt;
	text-indent:-18.0pt;}
@list l2:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:234.0pt;
	text-indent:-18.0pt;}
@list l2:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:270.0pt;
	text-indent:-9.0pt;}
@list l2:level7
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:306.0pt;
	text-indent:-18.0pt;}
@list l2:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:342.0pt;
	text-indent:-18.0pt;}
@list l2:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:378.0pt;
	text-indent:-9.0pt;}
@list l3
	{mso-list-id:725298178;
	mso-list-type:hybrid;
	mso-list-template-ids:-1652805334 -551665938 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l3:level1
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:103.05pt;
	text-indent:-18.0pt;}
@list l3:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:139.05pt;
	text-indent:-18.0pt;}
@list l3:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:175.05pt;
	text-indent:-9.0pt;}
@list l3:level4
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:211.05pt;
	text-indent:-18.0pt;}
@list l3:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:247.05pt;
	text-indent:-18.0pt;}
@list l3:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:283.05pt;
	text-indent:-9.0pt;}
@list l3:level7
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:319.05pt;
	text-indent:-18.0pt;}
@list l3:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:355.05pt;
	text-indent:-18.0pt;}
@list l3:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:391.05pt;
	text-indent:-9.0pt;}
@list l4
	{mso-list-id:1050574062;
	mso-list-type:hybrid;
	mso-list-template-ids:-1353546676 -269612964 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l4:level1
	{mso-level-number-format:thai-2;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:90.0pt;
	text-indent:-18.0pt;
	mso-ascii-font-family:"TH SarabunPSK";
	mso-fareast-font-family:"Cordia New";
	mso-hansi-font-family:"TH SarabunPSK";
	mso-bidi-font-family:"TH SarabunPSK";}
@list l4:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:126.0pt;
	text-indent:-18.0pt;}
@list l4:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:162.0pt;
	text-indent:-9.0pt;}
@list l4:level4
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:198.0pt;
	text-indent:-18.0pt;}
@list l4:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:234.0pt;
	text-indent:-18.0pt;}
@list l4:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:270.0pt;
	text-indent:-9.0pt;}
@list l4:level7
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:306.0pt;
	text-indent:-18.0pt;}
@list l4:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:342.0pt;
	text-indent:-18.0pt;}
@list l4:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:378.0pt;
	text-indent:-9.0pt;}
@list l5
	{mso-list-id:1188448409;
	mso-list-type:hybrid;
	mso-list-template-ids:-1353546676 -269612964 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l5:level1
	{mso-level-number-format:thai-2;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:90.0pt;
	text-indent:-18.0pt;
	mso-ascii-font-family:"TH SarabunPSK";
	mso-fareast-font-family:"Cordia New";
	mso-hansi-font-family:"TH SarabunPSK";
	mso-bidi-font-family:"TH SarabunPSK";}
@list l5:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:126.0pt;
	text-indent:-18.0pt;}
@list l5:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:162.0pt;
	text-indent:-9.0pt;}
@list l5:level4
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:198.0pt;
	text-indent:-18.0pt;}
@list l5:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:234.0pt;
	text-indent:-18.0pt;}
@list l5:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:270.0pt;
	text-indent:-9.0pt;}
@list l5:level7
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:306.0pt;
	text-indent:-18.0pt;}
@list l5:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:342.0pt;
	text-indent:-18.0pt;}
@list l5:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:378.0pt;
	text-indent:-9.0pt;}
@list l6
	{mso-list-id:1555505225;
	mso-list-type:hybrid;
	mso-list-template-ids:-994403082 444891544 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l6:level1
	{mso-level-number-format:thai-2;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:90.0pt;
	text-indent:-18.0pt;
	mso-ascii-font-family:"TH SarabunPSK";
	mso-fareast-font-family:"Cordia New";
	mso-hansi-font-family:"TH SarabunPSK";
	mso-bidi-font-family:"TH SarabunPSK";}
@list l6:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:126.0pt;
	text-indent:-18.0pt;}
@list l6:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:162.0pt;
	text-indent:-9.0pt;}
@list l6:level4
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:198.0pt;
	text-indent:-18.0pt;}
@list l6:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:234.0pt;
	text-indent:-18.0pt;}
@list l6:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:270.0pt;
	text-indent:-9.0pt;}
@list l6:level7
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:306.0pt;
	text-indent:-18.0pt;}
@list l6:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:342.0pt;
	text-indent:-18.0pt;}
@list l6:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:378.0pt;
	text-indent:-9.0pt;}
@list l7
	{mso-list-id:1696689773;
	mso-list-type:hybrid;
	mso-list-template-ids:-1652805334 -551665938 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l7:level1
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:103.05pt;
	text-indent:-18.0pt;}
@list l7:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:139.05pt;
	text-indent:-18.0pt;}
@list l7:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:175.05pt;
	text-indent:-9.0pt;}
@list l7:level4
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:211.05pt;
	text-indent:-18.0pt;}
@list l7:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:247.05pt;
	text-indent:-18.0pt;}
@list l7:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:283.05pt;
	text-indent:-9.0pt;}
@list l7:level7
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:319.05pt;
	text-indent:-18.0pt;}
@list l7:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:355.05pt;
	text-indent:-18.0pt;}
@list l7:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:391.05pt;
	text-indent:-9.0pt;}
@list l8
	{mso-list-id:1781103337;
	mso-list-type:hybrid;
	mso-list-template-ids:2127199508 -960183918 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l8:level1
	{mso-level-number-format:thai-2;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:90.0pt;
	text-indent:-18.0pt;
	mso-ascii-font-family:"TH SarabunPSK";
	mso-fareast-font-family:"Cordia New";
	mso-hansi-font-family:"TH SarabunPSK";
	mso-bidi-font-family:"TH SarabunPSK";}
@list l8:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:126.0pt;
	text-indent:-18.0pt;}
@list l8:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:162.0pt;
	text-indent:-9.0pt;}
@list l8:level4
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:198.0pt;
	text-indent:-18.0pt;}
@list l8:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:234.0pt;
	text-indent:-18.0pt;}
@list l8:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:270.0pt;
	text-indent:-9.0pt;}
@list l8:level7
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:306.0pt;
	text-indent:-18.0pt;}
@list l8:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:342.0pt;
	text-indent:-18.0pt;}
@list l8:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:378.0pt;
	text-indent:-9.0pt;}
@list l9
	{mso-list-id:1937979955;
	mso-list-type:hybrid;
	mso-list-template-ids:-1353546676 -269612964 67698713 67698715 67698703 67698713 67698715 67698703 67698713 67698715;}
@list l9:level1
	{mso-level-number-format:thai-2;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:90.0pt;
	text-indent:-18.0pt;
	mso-ascii-font-family:"TH SarabunPSK";
	mso-fareast-font-family:"Cordia New";
	mso-hansi-font-family:"TH SarabunPSK";
	mso-bidi-font-family:"TH SarabunPSK";}
@list l9:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:126.0pt;
	text-indent:-18.0pt;}
@list l9:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:162.0pt;
	text-indent:-9.0pt;}
@list l9:level4
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:198.0pt;
	text-indent:-18.0pt;}
@list l9:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:234.0pt;
	text-indent:-18.0pt;}
@list l9:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:270.0pt;
	text-indent:-9.0pt;}
@list l9:level7
	{mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:306.0pt;
	text-indent:-18.0pt;}
@list l9:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:left;
	margin-left:342.0pt;
	text-indent:-18.0pt;}
@list l9:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:none;
	mso-level-number-position:right;
	margin-left:378.0pt;
	text-indent:-9.0pt;}
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
	{mso-style-name:"Table Normal";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-parent:"";
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-para-margin-top:0cm;
	mso-para-margin-right:0cm;
	mso-para-margin-bottom:8.0pt;
	mso-para-margin-left:0cm;
	line-height:107%;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	mso-bidi-font-size:14.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:shapedefaults v:ext="edit" spidmax="1026"/>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <o:shapelayout v:ext="edit">
  <o:idmap v:ext="edit" data="1"/>
 </o:shapelayout></xml><![endif]-->
</head>

<body lang=EN-US style='tab-interval:36.0pt'>

<div class=WordSection1>

<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
text-align:center;line-height:normal'><b><span style='font-size:16.0pt;
font-family:"TH SarabunPSK",sans-serif;mso-fareast-font-family:"Cordia New";
color:black'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
text-align:center;line-height:normal'><b><span lang=TH style='font-size:16.0pt;
font-family:"TH SarabunPSK",sans-serif;mso-fareast-font-family:"Cordia New";
color:black'>หนังสือรับรองการเป็นอาจารย์ที่ปรึกษาวิทยานิพนธ์หลัก</span></b><b><span
style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;mso-fareast-font-family:
"Cordia New";color:black'><o:p></o:p></span></b></p>

<p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
text-align:center;line-height:normal'><span style='font-size:16.0pt;font-family:
"TH SarabunPSK",sans-serif;mso-fareast-font-family:"Cordia New";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:216.0pt;margin-bottom:.0001pt;text-indent:36.0pt;line-height:normal'><span
lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'>บัณฑิตวิทยาลัย
มหาวิทยาลัยมหาสารคาม</span><span style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:216.0pt;margin-bottom:.0001pt;text-indent:36.0pt;line-height:normal'><span
lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'>ตำบลขามเรียง อำเภอกันทรวิชัย</span><span
style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;mso-fareast-font-family:
"Cordia New";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:216.0pt;margin-bottom:.0001pt;text-indent:36.0pt;line-height:normal'><span
lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'>จังหวัดมหาสารคาม 44150<o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:180.0pt;margin-bottom:.0001pt;text-indent:36.0pt;line-height:normal'><span
style='font-size:8.0pt;font-family:"TH SarabunPSK",sans-serif;mso-fareast-font-family:
"Cordia New";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:180.0pt;margin-bottom:.0001pt;text-indent:36.0pt;line-height:normal'><span
lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp; </span><span
style='mso-spacerun:yes'>&nbsp;</span><span
style='mso-spacerun:yes'>&nbsp;</span><?=DateThai12($row_aa['std_date_signature']);?></span><span
style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;mso-fareast-font-family:
"Cordia New";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
normal'><span style='font-size:8.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
normal'><b><span lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'>เรื่อง</span></b><span
lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><span style='mso-tab-count:
1'>&nbsp;&nbsp;&nbsp; </span>รับรองการเป็นอาจารย์ที่ปรึกษาวิทยานิพนธ์หลัก<o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
normal'><span style='font-size:8.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
normal'><b><span lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'>เรียน</span></b><span
lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><span style='mso-tab-count:
1'>&nbsp;&nbsp;&nbsp; </span>ผู้อำนวยการสำนักงานการวิจัยแห่งชาติ/ผู้อำนวยการสำนักงานพัฒนาวิทยาศาสตร์และเทคโนโลยี<span
style='mso-spacerun:yes'>&nbsp; </span></span><span style='font-size:16.0pt;
font-family:"TH SarabunPSK",sans-serif;mso-fareast-font-family:"Cordia New";
color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
normal'><span lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><span
style='mso-spacerun:yes'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>(สวทช.) <o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify;text-justify:inter-cluster;line-height:115%'><span lang=TH
style='font-size:16.0pt;line-height:115%;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><span style='mso-tab-count:
1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><span
style='font-size:16.0pt;line-height:115%;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify;text-justify:inter-cluster;text-indent:36.0pt;line-height:115%'><span
lang=TH style='font-size:16.0pt;line-height:115%;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'>บัณฑิตวิทยาลัย<span
style='mso-spacerun:yes'>&nbsp; </span>มหาวิทยาลัยมหาสารคาม ขอรับรองว่า <?=$row_aa['advisor_name'];?>
สังกัดคณะ <?=$row_aa['advisor_faculty'];?> มหาวิทยาลัยมหาสารคาม เป็นที่ปรึกษาวิทยานิพนธ์ เรื่อง </span><span
lang=TH style='font-size:16.0pt;line-height:115%;font-family:"TH SarabunPSK",sans-serif'>“</span><span
lang=TH style='font-size:16.0pt;line-height:115%;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><?=$row_aa['subject'];?>”
<br>ซึ่งมี </span><span style='font-size:16.0pt;line-height:115%;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><o:p></o:p></span><span lang=TH
style='font-size:16.0pt;line-height:115%;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><?php echo $row_name['std_fname_th'];?>&nbsp;<?php echo $row_name['std_lname_th'];?>
&nbsp;&nbsp;นิสิตระดับ<?=$row_name['std_degree_th'];?> <?=$row_name['std_faculty_th'];?> มหาวิทยาลัยมหาสารคาม ตลอดระยะเวลาดำเนินการวิจัย ทั้งนี้จะให้คำปรึกษาในด้านการวิจัยสำหรับนิสิตระดับบัณฑิตศึกษา
</span></p>

<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;text-align:
justify;text-justify:inter-cluster;line-height:115%'><span lang=TH
style='font-size:16.0pt;line-height:115%;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><span style='mso-tab-count:
2'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></span><span
style='font-size:16.0pt;line-height:115%;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-top:0cm;margin-right:0cm;margin-bottom:0cm;
margin-left:72.0pt;margin-bottom:.0001pt;text-align:justify;text-justify:inter-cluster;
line-height:normal'><span style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal align=center style='margin-top:0cm;margin-right:0cm;
margin-bottom:0cm;margin-left:72.0pt;margin-bottom:.0001pt;text-align:center;
line-height:normal'><span lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'>ขอแสดงความนับถือ</span><span
style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;mso-fareast-font-family:
"Cordia New";color:black'><o:p></o:p></span></p>

<p class=MsoNormal align=center style='margin-top:0cm;margin-right:0cm;
margin-bottom:0cm;margin-left:72.0pt;margin-bottom:.0001pt;text-align:center;
line-height:normal'><span style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal align=center style='margin-top:0cm;margin-right:0cm;
margin-bottom:0cm;margin-left:72.0pt;margin-bottom:.0001pt;text-align:center;
line-height:normal'><span style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal align=center style='margin-top:0cm;margin-right:0cm;
margin-bottom:0cm;margin-left:72.0pt;margin-bottom:.0001pt;text-align:center;
line-height:normal'><span style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal align=center style='margin-top:0cm;margin-right:0cm;
margin-bottom:0cm;margin-left:72.0pt;margin-bottom:.0001pt;text-align:center;
line-height:normal'><span style='font-size:8.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal align=center style='margin-top:0cm;margin-right:0cm;
margin-bottom:0cm;margin-left:72.0pt;margin-bottom:.0001pt;text-align:center;
line-height:normal'><span lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'>(รองศาสตราจารย์ ดร.ชลธี<span
style='mso-spacerun:yes'>&nbsp; </span>โพธิ์ทอง)</span><span style='font-size:
16.0pt;font-family:"TH SarabunPSK",sans-serif;mso-fareast-font-family:"Cordia New";
color:black'><o:p></o:p></span></p>

<p class=MsoNormal align=center style='margin-top:0cm;margin-right:0cm;
margin-bottom:0cm;margin-left:72.0pt;margin-bottom:.0001pt;text-align:center;
line-height:normal'><span lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'>รองคณบดีบัณฑิตวิทยาลัยฝ่ายบริหาร
ปฏิบัติราชการแทน</span><span style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'><o:p></o:p></span></p>

<p class=MsoNormal align=center style='margin-top:0cm;margin-right:0cm;
margin-bottom:0cm;margin-left:72.0pt;margin-bottom:.0001pt;text-align:center;
line-height:normal'><span lang=TH style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:"Cordia New";color:black'>คณบดีบัณฑิตวิทยาลัย</span><span
style='font-size:16.0pt;font-family:"TH SarabunPSK",sans-serif;mso-fareast-font-family:
"Cordia New";color:black'><o:p></o:p></span></p>

<p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
normal'><span style='font-size:14.0pt;font-family:"TH SarabunPSK",sans-serif;
mso-fareast-font-family:Calibri;color:black'><o:p>&nbsp;</o:p></span></p>

</div>

</body>

</html>
