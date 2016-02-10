<?php
error_reporting(E_ERROR);
ini_set('display_errors', 1);

$db_settings=array('dsn'=>'sqlite:mydb.sq3','u'=>null,'p'=>null);
//create DB for testing
$pdo=new PDO( $db_settings['dsn'], 	$db_settings['u'], 	$db_settings['p']	);
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
//DB set up
$sql="CREATE TABLE IF NOT EXISTS property(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    address TEXT,
    lat REAL,
    lng REAL,
    beds TEXT,
    baths INTEGER,
    `type` TEXT,
    `price` REAL,
    image TEXT,
    date_added TIMESTAMP  DEFAULT CURRENT_TIMESTAMP
    );


    INSERT INTO `property` (`name`, `address`, `lat`, `lng`, `beds`,`baths`,`type`,`price`,`image`) VALUES ('Pan Africa Market', '1521 1st Ave, Seattle, WA', '47.608941', '-122.340145', '0', '1','studio','100000','images/image1.jpg');
    INSERT INTO `property` (`name`, `address`, `lat`, `lng`, `beds`,`baths`,`type`,`price`,`image`) VALUES ('Buddha Thai & Bar', '2222 2nd Ave, Seattle, WA', '47.613591', '-122.344394', '2', '1','apartment','1200000','images/image2.jpg');
    INSERT INTO `property` (`name`, `address`, `lat`, `lng`, `beds`,`baths`,`type`,`price`,`image`) VALUES ('The Melting Pot', '14 Mercer St, Seattle, WA', '47.624562', '-122.356442', '2', '2','town house','200000','images/image3.jpg');
    INSERT INTO `property` (`name`, `address`, `lat`, `lng`, `beds`,`baths`,`type`,`price`,`image`) VALUES ('Ipanema Grill', '1225 1st Ave, Seattle, WA', '47.606366', '-122.337656', '3', '2','detached house','1300000','images/image4.jpg');
    INSERT INTO `property` (`name`, `address`, `lat`, `lng`, `beds`,`baths`,`type`,`price`,`image`) VALUES ('Sake House', '2230 1st Ave, Seattle, WA', '47.612825', '-122.34567', '3', '2','apartment','400000','images/image5.jpg');
    INSERT INTO `property` (`name`, `address`, `lat`, `lng`, `beds`,`baths`,`type`,`price`,`image`) VALUES ('Crab Pot', '1301 Alaskan Way, Seattle, WA', '47.605961', '-122.34036', '1', '1','studio','100000','images/image1.jpg');
    INSERT INTO `property` (`name`, `address`, `lat`, `lng`, `beds`,`baths`,`type`,`price`,`image`) VALUES ('Mamas Mexican Kitchen', '2234 2nd Ave, Seattle, WA', '47.613975', '-122.345467', '1', '1','apartment','100000','images/image2.jpg');
    INSERT INTO `property` (`name`, `address`, `lat`, `lng`, `beds`,`baths`,`type`,`price`,`image`) VALUES ('Wingdome', '1416 E Olive Way, Seattle, WA', '47.617215', '-122.326584', '1', '1','studio','200000','images/image3.jpg');
    INSERT INTO `property` (`name`, `address`, `lat`, `lng`, `beds`,`baths`,`type`,`price`,`image`) VALUES ('Piroshky Piroshky', '1908 Pike pl, Seattle, WA', '47.610127', '-122.342838', '3', '2','apartment','700000','images/image4.jpg');

";

echo $pdo->exec($sql);