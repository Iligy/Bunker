<?php

Class Generate
{
	// Van-e érték megadva
	public static function hasdata($jelenlegioszlop, $jelenlegitipus, $jelenlegimeret)
	{
		if (trim($jelenlegioszlop) == '' || trim($jelenlegitipus) == '' || trim($jelenlegimeret) == '')
		{
			die('Minden adat kitöltése kötelező!');
		}
	}
	
	// Tipus ellenörzés
	public static function typecheck($jelenlegitipus, $jelenlegimeret)
	{
		if ($jelenlegitipus == 'TINYINT')
		{
			return $jelenlegimeret = 1;
		}
		elseif ($jelenlegitipus == 'TEXT')
		{
			return $jelenlegimeret = 300;
		}
		elseif ($jelenlegitipus == 'DATETIME' && $jelenlegimeret > 6)
		{
			die('DATETIME típus mérete maximum 6 lehet!');
		}
		elseif ($jelenlegitipus == 'INT' && $jelenlegimeret > 100)
		{
			die('INTEGER típus mérete maximum 100 lehet!');
		}
		elseif ($jelenlegitipus == 'VARCHAR' && $jelenlegimeret > 255)
		{
			die('VARCHAR típus mérete maximum 255 lehet!');
		}
		return $jelenlegimeret;
	}
	
	// SQL generátor
	public static function generatesql($str, $oszlopok_szama, $a, $jelenlegioszlop, $jelenlegitipus, $jelenlegimeret)
	{
		if ($oszlopok_szama > 1 && $a !== $oszlopok_szama - 1)
		{
			if (mb_strtolower($jelenlegioszlop[$a]) == 'id')
			{
				$str .= mb_strtolower($jelenlegioszlop[$a])." ".$jelenlegitipus[$a]."(".$jelenlegimeret[$a].") NOT NULL AUTO_INCREMENT PRIMARY KEY , ";
			}
			else
			{
				$str .= mb_strtolower($jelenlegioszlop[$a])." ".$jelenlegitipus[$a]."(".$jelenlegimeret[$a].") NOT NULL , ";
			}
		}
		if ($oszlopok_szama > 1 && $a == $oszlopok_szama - 1)
		{
			if (mb_strtolower($jelenlegioszlop[$a]) == 'id')
			{
				$str .= mb_strtolower($jelenlegioszlop[$a])." ".$jelenlegitipus[$a]."(".$jelenlegimeret[$a].") NOT NULL AUTO_INCREMENT PRIMARY KEY);";
			}
			else
			{
			$str .= mb_strtolower($jelenlegioszlop[$a])." ".$jelenlegitipus[$a]."(".$jelenlegimeret[$a].") NOT NULL );";
			}
		}
		if ($oszlopok_szama == 1)
		{
			if(mb_strtolower($jelenlegioszlop[$a]) == 'id')
			{
				$str .= mb_strtolower($jelenlegioszlop[$a])." ".$jelenlegitipus[$a]."(".$jelenlegimeret[$a].") NOT NULL AUTO_INCREMENT PRIMARY KEY);";
			}
			else
			{
				$str .= mb_strtolower($jelenlegioszlop[$a])." ".$jelenlegitipus[$a]."(".$jelenlegimeret[$a].") NOT NULL );";
			}
		}
		return $str;	
	}
	
	// Tartalom generálás, getter, setter
	public static function generategettersetter($tablaelem, $oszlopok_szama, $jelenlegioszlop, $crudfile)
	{
		$classneve = mb_strtolower($tablaelem);
		$classneve = str_replace(' ', '', $classneve);
		$classneve = mb_convert_case($classneve, MB_CASE_TITLE, "UTF-8");
			
		$tulajdonságok = "";
		$getterek = "";
		$setterek = "";
			
		for ($e = 0; $e<$oszlopok_szama; $e++)
		{
			$tulajdonságok.= 'private $'.$jelenlegioszlop[$e].";\n";
			$getterek .= 'public function get'.mb_convert_case($jelenlegioszlop[$e], MB_CASE_TITLE, "UTF-8").'(){'."\n".' return $this->'.$jelenlegioszlop[$e].';'."\n".'}'."\n";
			
			if (mb_convert_case($jelenlegioszlop[$e], MB_CASE_TITLE, "UTF-8") == 'Id')
			{
				continue;
			}
			else
			{
				$setterek .= 'public function set'.mb_convert_case($jelenlegioszlop[$e], MB_CASE_TITLE, "UTF-8").'($'.$jelenlegioszlop[$e].'){'."\n".' return $this->'.$jelenlegioszlop[$e].' = $'.$jelenlegioszlop[$e].';'."\n".'}'."\n";	
			}
		}
		$txt = "<?php";
		$txt .= '
		'."\n".'require_once("'.$crudfile.'");
		'."\n".'class '.$classneve. ' extends CRUD'
		."\n".'{
		'."\n".$tulajdonságok.'
		'."\n".$getterek.'
		'."\n".$setterek.'
		'."\n".'}
		'."\n".'?>';
		
		return $txt;
	}
	
	// MAPPA&FILE generátor (csak amik 1x kellenek)
	public static function generatestaticfilesfolders($bunkermappa, $projectmappa, $projectnev)
	{

		$szukseges = [];
		
		$connectmappa = $projectmappa.'\/'.'Connect';
		$modelmappa = $projectmappa.'\/'.'Model';
		$viewmappa = $projectmappa.'\/'.'View';
		$controllermappa = $projectmappa.'\/'.'Controller';
		$crudmappa = $projectmappa.'\/'.'Crud';
		
		if (!file_exists($bunkermappa) && !is_dir($bunkermappa))
		{
			mkdir($bunkermappa);
		}
			
		mkdir(mb_convert_case($projectmappa, MB_CASE_TITLE, "UTF-8"));
		mkdir($connectmappa);
		mkdir($modelmappa);
		mkdir($viewmappa);
		mkdir($controllermappa);
		mkdir($crudmappa);

				
		$connectfile = $connectmappa.'\/'.'Connect.php';
		$viewfile = $viewmappa.'\/'.'View.php';
		$controllerfile = $controllermappa.'\/'.'Controller.php';
		$crudfile = $crudmappa.'\/'.'Crud.php';

		$openedview = fopen($viewfile,'w');
		fclose($openedview);
		copy(dirname(__DIR__, 1).'\/View\/'.'View.php',$viewfile);
				
		$openedcontroller = fopen($controllerfile,'w');
		fclose($openedcontroller);
		copy(dirname(__DIR__, 1).'\/Controller\/'.'Controller.php',$controllerfile);
				
		$openedcrud = fopen($crudfile,'w');
		fclose($openedcrud);
		copy(dirname(__DIR__, 1).'\/Crud\/'.'Crud.php',$crudfile);
				
		$openedconn = fopen($connectfile,'w');
		fclose($openedconn);
					
		$meglevoconn = file_get_contents(dirname(__DIR__, 1).'\/Connect\/'.'Connect.php');
		$megfeleloconn = str_replace('alapdb', mb_strtolower($projectnev), $meglevoconn);
		file_put_contents($connectfile, $megfeleloconn);
		
		$szukseges[] = $crudfile;
		$szukseges[] = $modelmappa;
		
		return $szukseges;
	}
	
	
	// Dinamikusan generálodó mappák, fájlok
	public static function generatedinamicfilesfolders($modelmappa, $tablaelem, $txt)
	{
		$mappak = $modelmappa.'\/'.mb_convert_case($tablaelem, MB_CASE_TITLE, "UTF-8");
		$mappak = str_replace(' ', '', $mappak);
		mkdir($mappak);
		$modelfiletwo = fopen($mappak.'\/'.mb_convert_case($tablaelem, MB_CASE_TITLE, "UTF-8").'Model.php','w');
		$modelfiletwo = str_replace(' ', '', $modelfiletwo);
		fwrite($modelfiletwo,$txt);
		fclose($modelfiletwo);
	}
}


?>