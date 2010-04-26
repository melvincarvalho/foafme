<?php

	$polish = array(	
		/*Settings*/
			/*Points*/
			'vazco_karma:settings:login' => 'Ustawienai logowania',
			'vazco_karma:settings:period:notlogin' => 'A period in days user has to login to not to receive penalty:',
			'vazco_karma:settings:points:notlogin' => 'Penalty for not logging in for a given amount of time (you should put negative points here):',
			'vazco_karma:settings:period:login'=>'A period in days user can log in to receive reward:',
			'vazco_karma:settings:points:login'=>'Reward for logging in frequently:',
			'vazco_karma:settings:points:wire'=>'Reward/Penalty for posting on the wire:',
			'vazco_karma:settings:points:photo'=>'Reward/Penalty for uploading a photo:',
			'vazco_karma:settings:points:photo:change'=>'Reward/Penalty for editing a photo:',
			'vazco_karma:settings:points:blog:change'=>'Reward/Penalty for editing a blog:',
			'vazco_karma:settings:points:invite'=>'Reward/Penalty for inviting new users:',
			'vazco_karma:settings:activity' => 'Activity settings',
			'vazco_karma:settings:inbox:send' => 'Reward/penalty for sending messages:',
			'vazco_karma:settings:inbox:receive' => 'Reward/penalty for receiving messages:',
			'vazco_karma:settings:polls' => 'Reward/penalty for voting in polls:',
			'vazco_karma:settings:rating:self' => 'Reward/penalty for being rated:',
			'vazco_karma:settings:rating:others' => 'Reward/penalty for rating users:',
			'vazco_karma:settings:misc' => 'Miscellaneous settings',
			'vazco_karma:settings:points:group:users' => 'Reward/penalty for every user of your group:',
			'vazco_karma:settings:points:group:forum' => 'Reward/penalty for forum posts on your group:',
			'vazco_karma:settings:points:friendof' => 'Reward/penalty for being a friend of someone:',
			'vazco_karma:settings:points:friend' => 'Reward/penalty for someone being your friend:',
			'vazco_karma:settings:debugmode' => 'Turn debug mode on (membership of new users will last only 15 minutes)',
			'vazco_karma:settings:rank:admin' => 'Admin ma zawsze najwyższą rangę:',
	
			/*Settings actual*/
	      	'vazco_karma:settings:showPointsOnProfile' => 'Show karma points on profile page',
			'vazco_karma:settings:showPointsOnListings' => 'Show karma points on user listings',
			'vazco_karma:settings:ranks' => 'Set ranks for users',
			'vazco_karma:settings:ranks:desc' => 'Ranks have to be set in format:<br/>
Rank name|100|icon.gif<br/>
<br/>
where:<br/>
- Rank name is the public name of the rank<br/>
- 100 is the number of points needed to get to this rank<br/>
- icon.gif is the name of the icon from the mod/vazco_karma/rank_icons/ directory (icons are not required). <br/>
<br/>
Ranks have to be set from the lowest to the highest.',
		
	
		/*Comunicates*/
		'vazco_karma:nopointsuser' => 'Nie wybrano użytkownika, więc nie przydzielono punktów.',
		'vazco_karma:pointsgiven' => 'Użytkownik %s otrzymał %s punktów.',
	
		'vazco_karma:givepoints' => 'Zarządzaj punktami',
	
		/*Titles*/
		'vazco_karma:userpoints' => 'Punkty użytkownika',
		'vazco_karma:userpoints:current' => 'Użytkownik %s ma %s punktów.',
		'vazco_karma:userpoints:points' => 'Liczba punktów do dodania/usunięcia:',
		'vazco_karma:userpoints:points:desc' => 'Ta strona pozwala ci dodawać oraz odbierać punkty wybranym użytkownikom. Wpisz liczbę punktów którą chcesz dodać/odebrać i wciśnij \'Zapisz\' ( wpisz negatywną wartość aby usunąć punkty).',
	
		/*User's profile page*/
		'vazco_karma:profile:points' => 'Punkty:',
		'vazco_karma:profile:rank' => 'Ranga:',
		'vazco_karma:exception:wrongparams' => 'Zły parametr rang. Rangi muszą być w formacie: NazwaRangi|PunktyRangi',
	
		/*Listing page*/
		'vazco_karma:listing:points' => 'Punkty:',
		'vazco_karma:listing:rank' => 'Ranga:',
	
		/*Members list*/
		'members:sort:newest'	=> "Najnowsi",
		'members:sort:popular'	=> "Najpopularniejsi",
		'members:sort:active'	=> "Zalogowani",
		'members:sort:karma'	=> "Najwyżsi rangą",
		'members:sort:map' => 'Mapa członków',	
	
		'vazco_karma:settings:updateranks' => 'Zaktualizuj rangi użytkowników (przydatne przy zmianie rangi)',
		'vazco_karma:updaterankssuccess' => 'Punkty zaktualizowane pomyślnie',
	
		/*History of points*/
		'vazco_karma:history:menu' => 'Historia punktów',
		'vazco_karma:history' => 'Historia punktów',
		'vazco_karma:history:desc' => 'Na tej stronie możesz zobaczyć za co przydzielono ci poszczególne punkty',
		'vazco_karma:history:user' => 'Użytkownik: <b>%s</b>',
		'vazco_karma:history:total' => 'Całkowita liczba punktów: <b>%s</b>',
	
		'vazco_karma:history:notlogin' => 'Za nie logowanie się przez długi czas:',
		'vazco_karma:history:login'=>'Za częste logowanie się:',
		'vazco_karma:history:wire'=>'Za uzupełnianie statusu:',
		'vazco_karma:history:photo'=>'Za zamieszczone zdjęcia:',
		'vazco_karma:history:photo:change'=>'Za edycję zdjęć:',
		'vazco_karma:history:blog:change'=>'Za edycję bloga:',
		'vazco_karma:history:blog:add' => 'Za dodawanie postów na blogu:',
		'vazco_karma:history:invite'=>'Za zapraszanie nowych użytkowników:',
		'vazco_karma:history:inbox:send' => 'Za wysyłanie wiadomości:',
		'vazco_karma:history:inbox:receive' => 'Za otrzymywanie wiadomości:',
		'vazco_karma:history:polls' => 'Za głosowanie w sondażach:',
		'vazco_karma:history:rating:self' => 'Za bycie ocenianym:',
		'vazco_karma:history:rating:others' => 'Za ocenianie innych:',
		'vazco_karma:history:group:users' => 'Za każdego członka Twojego rejsu:',
		'vazco_karma:history:group:forum' => 'Za posty na twoich rejsach:',
		'vazco_karma:history:friendof' => 'Za bycie czyimś znajomym:',
		'vazco_karma:history:friend' => 'Za kogoś będącego Twoim znajomym:',
		'vazco_karma:history:misc' => 'Inne:',	
		'vazco_karma:history:group:create' => 'Za tworzenie nowydch grup:',
		'vazco_karma:menu:history' => 'Moje punkty',
		'vazco_karma:history:comments' => 'Za komentarze:',
	);
					
	add_translation("pl", $polish);

?>
