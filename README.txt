Ez a program biztosít neked egy CRUD-ot.
Frontend oldalon (index.php) ki kell töltened minden mezõt, ékezetek nélkül. (került a php számára zavaró neveket pl: date).
Ha ez megtörtént akkor, legenerálódik neked: connect, controller, crud, model, view mappa, és melette egy adatbázis is. (Entitás osztályok lesznek)
Az adatbázis neve megfog egyezni a projekt nevével. 
Az adatbázisban lévõ táblák megegyeznek a frontendrõl felvitt táblák neveivel.
A model mappába a táblák mindegyike kap egy modelt benne legenerálódott setterekkel, getterekkel, kiterjesztve a Crud.php-t.
A program ide tárolja a projektjeidet: C:\xampp\htdocs\Bunker_projektek


Functionok és használatuk:

	create:

		 Ez egy dinamikus function használatához a modelben található setterekkel be kell állítanod a tulajdonságokat.
			 Pl:($pelda = new Pelda(); $pelda->setNev('Nev'); $pelda->create();).

	read:

		 Ez egy statikus function tehát osztályra kell meghívni, eredménye: minden adat lejön abból a táblából amelyik megegyezik a használt osztályal.
			Pl:($minden = Pelda::read(), ilyenkor a pelda táblából jönnek le az adatok).
		
		 A leérkezõ adatok mindegyike egy object lesz és annak az osztálynak a példánya amire a funkciót hívtad, így ezekre megtudod hívni az osztályban található funkciókat.
			Pl:(foreach ($minden as $egyedul) {echo $egyedul->getName();}, ilyenkor a Pelda osztály funkcióit használhatod);

	readonebyid:

		 Ez egy statikus function tehát osztályra kell meghívni, eredménye: a bevitt id alapján leérkezik egy érték. 
			Pl:($kivalsztott = Pelda::readone(1);).
	
		A leérkezõ adat egy object lesz és annak az osztálynak a példánya amire a funkciót hívtad, így megtudod hívni az osztályban található funkciókat.
			Pl:(foreach ($minden as $egyedul) {echo $egyedul->getName();}, ilyenkor a Pelda osztály funkcióit használhatod );

	update:

		Ez egy dinamikus function, használatához a modelben található setterekkel be kell állítanod a tulajdonságokat.
		(Tegyük fel hogy a $pelda-t az elözõekben már lekérdeztük) 
		Pl: ($pelda->setNev("Updated nev"); $pelda->update();)

	destroy:

		Ez egy statikus function tehát osztályra kell meghívni, eredménye: a bevitt id alapján törlõdik egy érték. 
			Pl:($kivalsztott = Pelda::destroy(1); pelda táblából törlõdik a rekord).