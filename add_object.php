<?php
#error_reporting (E_ALL);

// ********************************************************************
// Combase v0.01
//
// A web based solution for the documentation of communication
// relations between IP systems. 
//  
// Copyright (C) 2012, Markus Groben
//
// This program is free software; you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 3 of the License, or
// (at your option) any later version.
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, see <http://www.gnu.org/licenses/>/
//
// ********************************************************************

session_start();

include ("mysql.php");
include ("functions.php");
include ("classes.php.inc");
include ("config.php");
include ("autologout.php");

if(!isset($_SESSION['UserID'])) {
	echo "Sie sind nicht eingeloggt.<br>\n".
			"Bitte <a href=\"login.php\">loggen</a> Sie sich zuerst ein.\n";
}
else{


echo '<link rel="stylesheet" type="text/css" href="layout.css">'; 


?>

<head> 
<script type='text/javascript' src="/combase/js/jquery/jquery-1.9.1.js"></script>
<script type='text/javascript'>
function FensterOeffnen1 (Adresse) {
MeinFenster1 = window.open(Adresse, 'drittfenster', 'width=400,left=150,top=250,scrollbars=yes');
MeinFenster1.focus();
}
$(document).ready(function(){
	$("#mask").hide();
	$("#maskv6").hide();
	$("#host").click(function(){
		  $("#mask").hide();
		  $("#mask").val("");
		  $("#maskv6").hide();
		  $("#maskv6").val("");
		  $("#interface").show();
		  $("#alias_name").val("");
		});

		$("#network").click(function(){
		  $("#mask").show();
		  $("#maskv6").show();
		  $("#traffic_class").val("");
		  $("#interface").hide();
		  $("#alias_name").val("NET_");
		});
	
});

function close_window() {
  {
    close();
  }
}
</script>
</head>  
<?php
$_referer = $_SERVER["HTTP_REFERER"];

echo '<img src="images/'. $logofile .'" alt="Alternativtext" ><br />
<hr>

<a href=add_application.php onclick="FensterOeffnen1(this.href); return false">ADD Application</a>&nbsp;
<a href="javascript:close_window();">CLOSE</a>&nbsp;
<a href="mailto:' . $administrator_mail . '?Subject=Add VRF" target="_top"> ADD VRF </a> &nbsp;
<a href="mailto:' . $administrator_mail . '?Subject=Add Environment" target="_top"> ADD Environment </a>&nbsp;
<a href="mailto:' . $administrator_mail . '?Subject=Add Firewall" target="_top"> ADD Firewall </a>&nbsp;
<a href=help.php> Help</a>&nbsp;';

#if (strpos($_referer, "index") !== false) {
#echo '   <a href=index.php>Home</a>'; 
#} else {
#echo "";
#}
echo'<hr>';


### delete Script ###
#
#if (isset($_GET['object_id'])){
#	$object_id = $_GET['object_id'];
#	$res = mysql_query("DELETE FROM '$dbEx'.`objects` WHERE `objects`.`object_id` = '$object_id'") or die(mysql_error());
#	echo "Object-ID " . $_GET[object_id] . " geloescht" ;
#	}	
#
##### ende delete script 
echo'
<div id="appbox">
<form action="add_object.php" method="post">
Application:*<select size="Hoehe" name="application_id">
<option value=""></option>';
include ("chosen_application.php");
echo '</select>
</div>';

echo'
<div id="envbox">
Environment:*
<select name="environment_id">" id="environment">
			<option value=""></option>';
include ("chosen_environment.php");
echo'		</select>
</div>	
<div id="vrfbox">
VRF:<select size="Hoehe" name="vrf_id">
<option value=""></option>';
include ("chosen_vrf.php");
echo '</select>
</div>';

echo'
<div id="classbox">
	<input name="radio" id="host" value="host" type="radio" checked> Host
	<input name="radio" id= "network" value="network" type="radio"> Network
</div>
<div id="ipbox">
IP-Address (IPv4):*<input type="text" size="15" maxlength="15" name="ipadd" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$">
		<select name="mask" id="mask">
			<option value="31">31</option>
			<option value="30">30</option>
			<option value="29">29</option>
			<option value="28">28</option>
			<option value="27">27</option>
			<option value="26">26</option>
			<option value="25">25</option>
			<option value="24">24</option>
			<option value="23">23</option>
			<option value="22">22</option>
			<option value="21">21</option>
			<option value="20">20</option>
			<option value="19">19</option>
			<option value="18">18</option>
			<option value="17">17</option>
			<option value="16">16</option>
			<option value="15">15</option>
			<option value="14">14</option>
			<option value="13">13</option>
			<option value="12">12</option>
			<option value="11">11</option>
			<option value="10">10</option>
			<option value="9">9</option>
			<option value="8">8</option>
		</select>
</div>
<div id="ipv6box">
IP-Address (IPv6):<input type="text" size="39" maxlength="39" name="ipv6add" pattern="((^|:)([0-9a-fA-F]{0,4})){1,8}$"> 
		<select name="maskv6" id="maskv6">
			<option value="64">64</option>
			<option value="127">127</option>
		</select>
</div>

		
<div id="namebox">
Object-Name:* (e.g. ' . $objektname_example . ')<input type="text" size="20" maxlength="32" name="alias_name" id="alias_name">
</div>
<div id="interface">
Interface:
		<select name="traffic_class" id="traffic_class">
			<option value=""></option>
			<option value="_ilom">Ilom</option>
			<option value="_oam">oam</option>
			<option value="_m2m">m2m</option>
			<option value="_cf">cf</option>
		</select>
</div>
<div id="aliasbox">			
Alias-name: (e.g. ' . $aliasname1_example . ')<input type="text" size="20" maxlength="32" name="alias_name1">
</div>
<div id="aliasbox2">
Alias-Name2: (e.g. ' . $aliasname2_example . ')<input type="text" size="20" maxlength="32" name="alias_name2">
</div>
<div id="firewallbox">
Firewall:*<select size="Hoehe" name="firewall_id">
<option value=""></option>';
include ("chosen_firewall.php");
echo '';
echo'
</select>

</div>

<p><input type="submit" name="Name" value="Submit">
<input type="reset" name="Name" value="Reset"></p>
</form>';
?>





<?php

### delete Script ###
#if (isset($_GET['object_id'])){
#	$object_id = $_GET['object_id'];
#	$res = mysql_query("DELETE FROM '$dbEx'.`objects` WHERE `objects`.`object_id` = '$object_id'") or die(mysql_error());
#	echo "<p>Object-ID " . $object_id . " geloescht</p>" ;
#}
### end delete Script ###
function get_app_name ($app_id){
require ('mysql.inc.php');
$database = new database(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DATA);
$show_application = mysql_query ("SELECT * FROM application WHERE app_id = '". $app_id ."'");
while ($zeila = mysql_fetch_object($show_application)){
echo "<td>" . $zeila->app_name . "</td>";
}
} 
#echo "Application ID: " . $_POST['application_id'] . "<br>";
#echo "VRF: " . $_POST['vrf_id'] . "<br>";
#echo "RADIO: " . $_POST['radio'] . "<br>";
#echo "Mask: " . $_POST['mask'] . "<br>";
#echo "IPv6: " . $_POST['ipv6add'] . "<br>";
#echo "Maskv6: " . $_POST['maskv6'] . "<br>";
#echo "Name: " . $_POST['alias_name'] . "<br>";
#echo "Class: " . $_POST['traffic_class'] . "<br>";
#echo "Alias-1: " . $_POST['alias_name1'] . "<br>";
#echo "Alias-2: " . $_POST['alias_name2'] . "<br>";
#echo "Firewall: " . $_POST['firewall_id'] . "<br>";






if (isset($_POST['radio']) && ($_POST['radio']) == 'host') {
	if (empty($_POST['ipv6add'])) {$maskv6 = 'NULL' ; $ipv6add= 'NULL' ;} else {
	$ipv6add=  "'" . $_POST["ipv6add"] ."'";
	$maskv6= '128';}
	if (empty($_POST['ipadd'])) {$mask = 'NULL' ; $ipadd= 'NULL' ; $longip= 'NULL';} else {
	$mask = '32';
	$ipadd = "'" . $_POST["ipadd"] ."'" ;
	$longip= ip2long($_POST["ipadd"]);
	}
	#echo "Application ID: " . $_POST['application_id'] . "<br>";
	#echo "Environment: " . $_POST['environment_id'] . "<br>";
	#echo "VRF: " . $_POST['vrf_id'] . "<br>";
	#echo "RADIO: " . $_POST['radio'] . "<br>";
	#echo "IP: " . $ipadd . "<br>";          
	#echo "Mask: " . $mask . "<br>";			
	#echo "LONG-IP: " . $longip . "<br>";	
	#echo "IPv6: " . $ipv6add . "<br>";
	#echo "Maskv6: " . $maskv6 . "<br>";
	#echo "Name: " . $_POST['alias_name'] . "<br>";
	#echo "Class: " . $_POST['traffic_class'] . "<br>";
	#echo "Alias-1: " . $_POST['alias_name1'] . "<br>";
	#echo "Alias-2: " . $_POST['alias_name2'] . "<br>";
	#echo "Firewall: " . $_POST['firewall_id'] . "<br>";
} else {
if (empty($_POST['ipv6add'])) {$maskv6 = 'NULL' ; $ipv6add= 'NULL' ;} else {
	$ipv6add=  "'" . $_POST["ipv6add"] ."'";
	$maskv6= "'" . $_POST["maskv6"] ."'";}
	if (empty($_POST['ipadd'])) {$mask = 'NULL' ; $ipadd= 'NULL' ; $longip= 'NULL';} else {
	$mask = "'" . $_POST["mask"] ."'";
	$ipadd = "'" . $_POST["ipadd"] ."'" ;
	$longip= ip2long($_POST["ipadd"]);
	
	}
	#echo "Application ID: " . $_POST['application_id'] . "<br>";
	#echo "Environment: " . $_POST['environment_id'] . "<br>";
	#echo "VRF: " . $_POST['vrf_id'] . "<br>";
	#echo "RADIO: " . $_POST['radio'] . "<br>";
	#echo "IP: " . $ipadd . "<br>";          
	#echo "Mask: " . $mask . "<br>";			
	#echo "LONG-IP: " . $longip . "<br>";	
	#echo "IPv6: " . $ipv6add . "<br>";
	#echo "Maskv6: " . $maskv6 . "<br>";
	#echo "Name: " . $_POST['alias_name'] . "<br>";
	#echo "Class: " . $_POST['traffic_class'] . "<br>";
	#echo "Alias-1: " . $_POST['alias_name1'] . "<br>";
	#echo "Alias-2: " . $_POST['alias_name2'] . "<br>";
	#echo "Firewall: " . $_POST['firewall_id'] . "<br>";
	}
	
if (isset($_POST['alias_name']) && ($_POST['ipadd']) or ($_POST['ipv6add'])) {$enter_object = "INSERT INTO objects (object_id , object_name, ip_address_dot, ip_address_long, mask, ipv6_address, ipv6_mask, comment, alias_name, alias_name2, application_id, vrf_id, firewall_id, environment, user_id) VALUES ('' , '" . $_POST["alias_name"] . "" . $_POST["traffic_class"] . "' , " . $ipadd . " , " . $longip . ", " . $mask . " , " . $ipv6add . " , " . $maskv6 . " , 'test', '". $_POST["alias_name1"]."', '". $_POST["alias_name2"]."','". $_POST["application_id"]."','" . $_POST["vrf_id"] . "', '" . $_POST["firewall_id"] . "', '" . $_POST["environment_id"] . "', '" . $_SESSION["UserID"] . "')";
#printf($enter_object);
mysql_query($enter_object) or die(mysql_error());

} else {

}

echo "<hr>
<h1>Current Objects in database:</h1>";

$show_object = mysql_query ("SELECT * FROM objects");
echo "<table><tr bgcolor='#C4C0C2'><th>ID:</th><th>Object-Name:</th><th>IPv4:</th><th>v4Mask:</th><th>IPv6:</th><th>v6Mask:</th><th>Alias-Name</th><th>Alias-Name2</th><th>Application</th><th>Firewall:</th><th>VRF:</th><th>Environment:</th><th>last modified by</th><th>last change</th><!--<th>Action</th>--></tr>";
while ($zeile = mysql_fetch_object($show_object)) {
echo "<tr><td>" . htmlspecialchars($zeile->object_id) . " </td><td>" . htmlspecialchars($zeile->object_name) ." </td><td>" . htmlspecialchars($zeile->ip_address_dot) . "</td><td>" . htmlspecialchars($zeile->mask) . "</td><td>" . htmlspecialchars($zeile->ipv6_address) . "</td><td>" . htmlspecialchars($zeile->ipv6_mask) . "</td><td>" . htmlspecialchars($zeile->alias_name) . "</td><td>" . htmlspecialchars($zeile->alias_name2) . "</td>";
if (empty($zeile->application_id)){
	echo "<td>none</td>";
} else {
get_app_name($zeile->application_id);
}

if (($zeile->firewall_id) != "0"){
getfirewallnamebyID($zeile->firewall_id);
} else {
echo "<td>none</td>";
}
if (($zeile->vrf_id) != "0"){
getvrfnamebyID($zeile->vrf_id);
} else {
echo "<td>none</td>";
}
echo "<td>" . htmlspecialchars($zeile->environment). "</td>";
getUsernamebyID($zeile->user_id);
echo "<td>" . htmlspecialchars($zeile->time) . "</td>";

### Folgende Zeilen ist auskommentiert, da noch kein sicheres Löschen implementiert ist ###
#if (($zeile->object_id) != "0") {
#echo "<td><a href=add_object.php?object_id=" . $zeile->object_id . " onclick=\"return confirm('Wirklich Loeschen');\">delete</a></td>";	
#} else {
#echo "<td></td>";
#}

echo "</tr>";
}        
echo "</table>";
   
#}
echo " 
<!--<form>
<input type='button' value='close' onClick='window.close()'>
</form>-->";}
?>


<script type="text/javascript">neuLaden();</script>

