<?php
/**
 * Created by IntelliJ IDEA.
 * User: Johannes
 * Date: 17.07.2018
 * Time: 15:24
 */

$fakevars = [

        'maleForeNames'=>['Timo','Levi','Nico','Finnian','Lorian','Waldo','Adrien','Jovin','Urban','Levian','Ethan','Vito','Cla','Bernhardin','Gioele','Gabriele','Othmar','Jürg','Jacopo','Petri','Beat','Franklin','Urs','Simon','David','Aaron','Léon','Dylan','Siad','Mathias'],
        'femaleForeNames'=>['Eleonora','Käthi','Judith','Livia','Moesha','Nora','Inja','Nela','Lana','Arianna','Maike','Ava','Elva','Lia','Nola','Marei','Ladina','Anna','Severine','Nadine','Abeline','Marei','Madlaina','Julie','Stefanie','Heda','Sara','Dilan','Erina','Beatriz'],
        'surNames'=>['Oertli','Brassel','Tschanz','Dätwyler','Beiner','Dietrich','Greuter','Bessan','Stauffacher','Käufeler','Doderer','Imdorf','Marolf','Stähli','Füllemann','Ruffner','Bodon','Güdel','Wohlgemuth','Looser','Schiefer','Schläpfer','Wolfensberger','Wittwer','Werder','Ruch','Romer','Rietmann','Gilgen','Gaschen','Winkler','Munz','Preisig','Lamm','Brenzikofer','Teufenauer','Bosshard','Hammer','Nüssli','Zehndbauer','Löpfe','Knutti','Bächi','Hertig','Grossmann','Teuscher','Fawer','Wermuth','Bleuer','Ins','Zopfi','Bläuer','Schalker','Nebiker','Bührer','Würmli','Benoit','Gempeler'],

        'adult_discounts'=>['Mitglieder'=> 0.85,'Heinzelmännchen'=>0,'AHV'=>0.65,'Steuerkarte'=>0.65],
        'child_discounts'=>['Mitglieder'=> 0.85,'Heinzelmännchen'=>0,'Steuerkarte'=>0.65,'Kurskind'=>0],
        'group_discounts'=>['Hort'=>['description'=>'Eintritt 9.-, Pro 6 Kinder eine Begleitperson gratis.','adults'=>'(adults-min(adults,children\6+1)*9.00)','children'=>'children*9.0']],

        'bookingMeans'=>['tel','mail','web','pers','other'],

        'areaCodes'=>['075','077','076','079','078'],
        'specialAreaCodes'=>['075','077','076','079','078'],

        'emailNames'=>['info','mail','buero','office'],
        'emailProviders'=>['bluewin.ch','sunrise.ch','gmail.com','hotmail.com','me.com','hispeed.ch','gmx.net','yahoo.de'],

        'topLevelDomains'=>['ch','de','com','net','org','tv'],

        'bookingRemarks'=>['Kommt sehr kanpp. Bitte Ticket aufbewahren','Nicht klar, ob die kommen','schon oft nicht gekommen','ACHTUNG: Heinzelmännchen','ROLLSTUHL: unbedingt mit Saalverantwortlicher vorbesprechen'],
        'bookingPersons'=>['Monika','Claudia','Catherine','Jo','Küde'],

        'otherBookingContacts'=>['Per SMS']
    ];
}
