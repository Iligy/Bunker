<?php 
require_once('Generator/generate_func.php');

if (!empty($_POST['pnev']))
{
// majd egy komolyabb validáció
foreach ($_POST['tnev'] as $nev)
{
	if ($nev == '' || $nev == NULL)
	{
		die('Minden tábla név kitöltése kötelező!');
	}
}
// majd egy komolyabb validáció

	$projectnev = $_POST['pnev'];
	$projectnev = str_replace(' ', '', $projectnev);
	$bunkermappa = 'C:\/xampp\/htdocs\/Bunker_projektek';
	$projectmappa = $bunkermappa.'\/'.$projectnev;
	
	$tablak = $_POST['tnev'];
	ksort($tablak);
	
	$tablak_szama = count($tablak);
	$tabla_keys = array_keys($tablak);
	
	$tablanevek = array();
	$oszlopok = array();
	
	if (!file_exists($projectmappa) && !is_dir($projectmappa))
	{
		if ($tablak_szama > 0)
		{
			
			// README file-ba lépésről lépésre hogyan kell csinálni a dolgokat, szabállyal (nevek ékezet nélkül ha lehet)
			$createdb = "CREATE DATABASE IF NOT EXISTS ".mb_strtolower(trim($projectnev))." CHARACTER SET utf8 COLLATE utf8_general_ci";
			$str = "";
			
			foreach($tablak as $id => $nev)
			{
				$tablanevek[] = trim($nev);
			}
			
			for ($i = 0; $i<$tablak_szama; $i++)
			{	
				// Komolyabb validávió
				$tablak[$tabla_keys[$i]] = str_replace(' ', '', $tablak[$tabla_keys[$i]]);

				$str .= "CREATE TABLE " .$tablak[trim($tabla_keys[$i])]." ( ";	
				$jelenlegioszlop = $_POST['oszlop'.trim($tabla_keys[$i])];
				$jelenlegitipus = $_POST['tipus'.$tabla_keys[$i]];
				$jelenlegimeret = $_POST['meret'.$tabla_keys[$i]];
				
				$oszlopok_szama = count($jelenlegioszlop);
				
				for ($a = 0; $a<$oszlopok_szama; $a++)
				{
					// Minden kivan-e töltve
					Generate::hasdata($jelenlegioszlop[$a], $jelenlegitipus[$a], $jelenlegimeret[$a]);
					
					// Típus ellenörzés
					$jelenlegimeret[$a] = Generate::typecheck($jelenlegitipus[$a],$jelenlegimeret[$a]);
						
					// SQL generátor
					$str = Generate::generatesql($str, $oszlopok_szama, $a, $jelenlegioszlop, $jelenlegitipus, $jelenlegimeret);					
				}
				
				
				if ($i == 0)
				{
					// MAPPA&FILE generátor (csak amik 1x kellenek)
					try
					{
					$szukseges = Generate::generatestaticfilesfolders($bunkermappa, $projectmappa, $projectnev);
					}catch (Exception $e)
					{
						die ('Hiba: '.$e->getMessage());
					}
				}
							
				// Tartalom generálás, getter, setter
				$txt = Generate::generategettersetter($tablanevek[$i], $oszlopok_szama, $jelenlegioszlop, $szukseges[0]);
							
				// Dinamikusan generálodó mappák, fájlok
				try
				{
				Generate::generatedinamicfilesfolders($szukseges[1], $tablanevek[$i], $txt);
				}catch (Exception $e)
				{
					die ('Hiba: '.$e->getMessage());
				}
			}
		}
		else
		{
			die('Táblá létrehozása kötelező!');
		}
	}
	else
	{
		die($projectnev. 'nevű projekt már létezik, ha a meglévőt szerednéd felülírni, akkor töröld ki a: Bunker_projektek mappából.(Ilyenkor MINDEN elveszik és a 0-ról tudod újragenerálni a dolgokat!)');
	}
	
	// SQL futtatása
	require_once(__DIR__ .'\/Connect\/'.'BasicConnect.php');

	try
	{
	$basic = new BasicConnect();
	$db = $basic->getBasicConnection();
	
	$db->exec($createdb);
	$sql = 'use '.$projectnev;
	$db->exec($sql);
	
	$db->exec($str);
	$db = NULL;
	die('Projekt létrehozása sikeres!');
	}
	catch (Exception $e)
	{
		die ('Hiba: '.$e->getMessage());
	}

}
else
{
	die('Projekt név megadás kötelező!');
}


 ?> 
   