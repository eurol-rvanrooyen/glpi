<?php
/*
 
 ----------------------------------------------------------------------
GLPI - Gestionnaire libre de parc informatique
 Copyright (C) 2002 by the INDEPNET Development Team.
 http://indepnet.net/   http://glpi.indepnet.org
 ----------------------------------------------------------------------
 Based on:
IRMA, Information Resource-Management and Administration
Christian Bauer, turin@incubus.de 

 ----------------------------------------------------------------------
 LICENSE

This file is part of GLPI.

    GLPI is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    GLPI is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with GLPI; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 ----------------------------------------------------------------------
 Original Author of file:
 Purpose of file:
 ----------------------------------------------------------------------
*/
 

include ("_relpos.php");
include ($phproot . "/glpi/includes.php");
include ($phproot . "/glpi/includes_computers.php");
include ($phproot . "/glpi/includes_networking.php");
include ($phproot . "/glpi/includes_monitors.php");
include ($phproot . "/glpi/includes_printers.php");
include ($phproot . "/glpi/includes_tracking.php");
include ($phproot . "/glpi/includes_software.php");

if (isset($_POST["add"])) {
	checkAuthentication("admin");
	addComputer($_POST);
	logEvent(0, "computers", 4, "inventory", $_SESSION["glpiname"]." added ".$_POST["name"].".");
	header("Location: $_SERVER[HTTP_REFERER]");
} else if (isset($_POST["delete"])) {
	checkAuthentication("admin");
	deleteComputer($_POST);
	logEvent($_POST["ID"], "computers", 4, "inventory", $_SESSION["glpiname"]." deleted item.");
	header("Location: ".$cfg_install["root"]."/computers/");
} else if (isset($_POST["update"])) {
	if(empty($_POST["show"])) $_POST["show"] = "";
	if(empty($_POST["contains"])) $_POST["contains"] = "";
	checkAuthentication("admin");
	updateComputer($_POST);
	logEvent($_POST["ID"], "computers", 4, "inventory", $_SESSION["glpiname"]."updated item.");
	commonHeader("Computers",$_SERVER["PHP_SELF"]);
	showComputerForm(0,$_SERVER["PHP_SELF"],$_POST["ID"]);
	showPorts($_POST["ID"], 1);
	showPortsAdd($_POST["ID"],1);
	showJobList($_SESSION["glpiname"],$_POST["show"],$_POST["contains"],$_POST["ID"]);
	showSoftwareInstalled($_POST["ID"]);
	commonFooter();
} else {

	checkAuthentication("normal");
	//print_r($_GET);
	commonHeader("Computers",$_SERVER["PHP_SELF"]);
	if (isset($_GET["withtemplate"]))
	{
		showComputerForm($_GET["withtemplate"],$_SERVER["PHP_SELF"],$_GET["ID"]);
	}
	else
	{
		if (showComputerForm(0,$_SERVER["PHP_SELF"],$_GET["ID"])) {
	
			showPorts($_GET["ID"], 1);
			
			showPortsAdd($_GET["ID"],1);
		
			showConnections($_GET["ID"]);
		
			showJobList($_SESSION["glpiname"],"","",$_GET["ID"]);
	
			showOldJobListForItem($_SESSION["glpiname"],"",$_GET["ID"]);
	
			showSoftwareInstalled($_GET["ID"]);
		}
	}
	commonFooter();
}


?>
