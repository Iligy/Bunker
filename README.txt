Ez a program biztos�t neked egy CRUD-ot.
Frontend oldalon (index.php) ki kell t�ltened minden mez�t, �kezetek n�lk�l. (ker�lt a php sz�m�ra zavar� neveket pl: date).
Ha ez megt�rt�nt akkor, legener�l�dik neked: connect, controller, crud, model, view mappa, �s melette egy adatb�zis is. (Entit�s oszt�lyok lesznek)
Az adatb�zis neve megfog egyezni a projekt nev�vel. 
Az adatb�zisban l�v� t�bl�k megegyeznek a frontendr�l felvitt t�bl�k neveivel.
A model mapp�ba a t�bl�k mindegyike kap egy modelt benne legener�l�dott setterekkel, getterekkel, kiterjesztve a Crud.php-t.
A program ide t�rolja a projektjeidet: C:\xampp\htdocs\Bunker_projektek


Functionok �s haszn�latuk:

	create:

		 Ez egy dinamikus function haszn�lat�hoz a modelben tal�lhat� setterekkel be kell �ll�tanod a tulajdons�gokat.
			 Pl:($pelda = new Pelda(); $pelda->setNev('Nev'); $pelda->create();).

	read:

		 Ez egy statikus function teh�t oszt�lyra kell megh�vni, eredm�nye: minden adat lej�n abb�l a t�bl�b�l amelyik megegyezik a haszn�lt oszt�lyal.
			Pl:($minden = Pelda::read(), ilyenkor a pelda t�bl�b�l j�nnek le az adatok).
		
		 A le�rkez� adatok mindegyike egy object lesz �s annak az oszt�lynak a p�ld�nya amire a funkci�t h�vtad, �gy ezekre megtudod h�vni az oszt�lyban tal�lhat� funkci�kat.
			Pl:(foreach ($minden as $egyedul) {echo $egyedul->getName();}, ilyenkor a Pelda oszt�ly funkci�it haszn�lhatod);

	readonebyid:

		 Ez egy statikus function teh�t oszt�lyra kell megh�vni, eredm�nye: a bevitt id alapj�n le�rkezik egy �rt�k. 
			Pl:($kivalsztott = Pelda::readone(1);).
	
		A le�rkez� adat egy object lesz �s annak az oszt�lynak a p�ld�nya amire a funkci�t h�vtad, �gy megtudod h�vni az oszt�lyban tal�lhat� funkci�kat.
			Pl:(foreach ($minden as $egyedul) {echo $egyedul->getName();}, ilyenkor a Pelda oszt�ly funkci�it haszn�lhatod );

	update:

		Ez egy dinamikus function, haszn�lat�hoz a modelben tal�lhat� setterekkel be kell �ll�tanod a tulajdons�gokat.
		(Tegy�k fel hogy a $pelda-t az el�z�ekben m�r lek�rdezt�k) 
		Pl: ($pelda->setNev("Updated nev"); $pelda->update();)

	destroy:

		Ez egy statikus function teh�t oszt�lyra kell megh�vni, eredm�nye: a bevitt id alapj�n t�rl�dik egy �rt�k. 
			Pl:($kivalsztott = Pelda::destroy(1); pelda t�bl�b�l t�rl�dik a rekord).