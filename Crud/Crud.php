<?php

require_once(dirname(__DIR__, 1).'\/Connect\/Connect.php');

class CRUD{
	
	//Teszt
	public function create(){
		
		$database = new Connect();
		$db = $database->getConnection();
		
		$default_obj_attr = (array)$this;
		$classname = get_class($this);
		
		$oszlopok = array();
		$ertekek = array();

		foreach ($default_obj_attr as $key => $value)
		{
			if (strpos($key,mb_convert_case($classname, MB_CASE_TITLE, "UTF-8")) !== false){
			$key = substr($key,strlen($classname)+2);

			if ($key == 'id')
			{
				continue;
			}
		$oszlopok[]= $key;
		$ertekek[] = $value;
			}
		}
		$classname = mb_strtolower($classname);

		$kiegesztitettparam = array();
		
		foreach ($oszlopok as $parameter)
			{
				$kiegesztitettparam[] = ':'.$parameter;  
			}
			
		$oszlopok = implode(', ',$oszlopok);
		$megfeleloparam = implode(', ',$kiegesztitettparam);
		
		$sql = 'INSERT INTO '.$classname.' ('.$oszlopok .') VALUES ('.$megfeleloparam.')';

		$bindparam = str_replace(' ','',$megfeleloparam);
		$bindparam = explode(',',$bindparam);
		
		$obj_tul = str_replace(' ','',$oszlopok);
		$obj_tul = explode(',',$obj_tul);
	
		$stmt = $db->prepare($sql);
		
		for ($i = 0; $i<count($bindparam);$i++)
		{	
			$megfelelogetter = 'get'.mb_convert_case(($obj_tul[$i]), MB_CASE_TITLE, "UTF-8");
			$objectbol_ertek_getter_altal = $this->$megfelelogetter();
			$stmt->BindValue($bindparam[$i],$objectbol_ertek_getter_altal);	
		}
		try{
			$stmt->execute();
			$db = null;
		}
		catch(Exception $e) {
		die('Titkos üzenet: ' .$e->getMessage());
		}	
	}

	public static function read(){
		
		$database = new Connect();
		$db = $database->getConnection();
		
		$classname = get_called_class();
		$classname = mb_strtolower($classname);
		 
		$sql = 'SELECT * FROM '.$classname;

		$stmt = $db->query($sql);
		
		try
		{
		$adatok = $stmt->fetchAll(PDO::FETCH_CLASS, $classname);
		}
		catch(Exception $e) 
		{
			die('Titkos üzenet: ' .$e->getMessage());
		}
		$db = null;
		return $adatok;
		
	}
	public function update(){
		
		$database = new Connect();
		$db = $database->getConnection();
		
		$default_obj_attr = (array)$this;
		$classname = get_class($this);
		$classname = mb_strtolower($classname);
		
		$set = "";
		$oszlopok = array();
		$ertekek = array();
		
		foreach ($default_obj_attr as $key => $value)
		{
			if (strpos($key,mb_convert_case($classname, MB_CASE_TITLE, "UTF-8")) !== false){
			$key = substr($key,strlen($classname)+2);

			if ($key == 'id')
			{
				$updaterekordid = $value;
				continue;
			}
	
		$set .= $key." = ".':'.$key.', ';
		$oszlopok[] = ':'.$key;
		$getter = 'get'.mb_convert_case($key, MB_CASE_TITLE, "UTF-8");
		$value = $this->$getter();
		$ertekek[] = $value;
			}
		}
		$set = substr($set,0,-2);
		$sql = 'UPDATE '.$classname.' SET '.$set.' WHERE '.$classname.'.id = :id';
		$stmt = $db->prepare($sql);
		
		for ($i = 0; $i<count($oszlopok); $i++)
		{
			$stmt->BindValue($oszlopok[$i],$ertekek[$i]);
		}
		
		$stmt->BindValue(':id',$updaterekordid);

		try{
			$stmt->execute();
			$db = null;
		}
		catch(Exception $e) {
		die('Titkos üzenet: ' .$e->getMessage());
		}	
		
	}
	public static function destroy($deleterekordid){
		
		$database = new Connect();
		$db = $database->getConnection();
			
		$classname = get_called_class();
		$classname = mb_strtolower($classname);
		
		$sql = 'DELETE FROM '.$classname.' WHERE '.$classname.'.id = :id';
		$stmt = $db->prepare($sql);
		$stmt->BindParam(':id',$deleterekordid);
		
		try{
			$stmt->execute();
			$db = null;
		}
		catch(Exception $e) {
		die('Titkos üzenet: ' .$e->getMessage());
		}	
	}
	public static function readonebyid($id){
		
		$database = new Connect();
		$db = $database->getConnection();
		

		$classname = get_called_class();
		$classname = mb_strtolower($classname);
		
		$sql = 'SELECT * FROM '.$classname.' WHERE '.$classname.'.id = :id';
		$stmt = $db->prepare($sql);
		$stmt->BindParam(':id',$id);
		
		try{
			$stmt->setFetchMode(PDO::FETCH_CLASS, $classname);
			$stmt->execute();
			$object = $stmt->fetch();
			$db = null;
			return $object;
		}
		catch(Exception $e) {
		die( 'Titkos üzenet: ' .$e->getMessage());
		}
	}
}
?>