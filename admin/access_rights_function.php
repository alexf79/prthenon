<?
	function GetAccessRights($MenuID){

		include('../global.php');

		$Operations = array();

		 $query = "SELECT * FROM ".$tbname."_accessright
				WHERE _MID = '".$MenuID."'
				AND _UserID = '".$_SESSION["levelid"]."'";

		//echo $query;
		//exit();

		$row = mysql_query($query,$connect)or die(mysql_error());

		if(mysql_num_rows($row)>0){
			while($data = mysql_fetch_assoc($row)){
				array_push($Operations, $data["_Operation"]);
			}
		}

		return $Operations;
	}
	
	
	function commonaccess($MenuID){

		include('../global.php');

		$Operations = array();

		 $query = "SELECT * FROM ".$tbname."_accessright
				WHERE _MID = '".$MenuID."'
				AND _UserID = '".$_SESSION["levelid"]."'";

		//echo $query;
		//exit();

		$row = mysql_query($query,$connect)or die(mysql_error());
		$numrows = mysql_num_rows($row);
		if(mysql_num_rows($row)>0){
			while($data = mysql_fetch_assoc($row)){
				array_push($Operations, $data["_Operation"]);
			}
		}

		return $numrows;
	}
	
?>