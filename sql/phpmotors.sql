SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `carclassification` (
  `classificationId` int(11) NOT NULL,
  `classificationName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `carclassification` (`classificationId`, `classificationName`) VALUES
(1, 'SUV'),
(2, 'Classic'),
(3, 'Sports'),
(4, 'Trucks'),
(5, 'Used');

CREATE TABLE `clients` (
  `clientId` int(10) UNSIGNED NOT NULL,
  `clientFirstName` varchar(15) NOT NULL,
  `clientLastName` varchar(25) NOT NULL,
  `clientEmail` varchar(40) NOT NULL,
  `clientPassword` varchar(255) NOT NULL,
  `clientLevel` enum('1','2','3') NOT NULL DEFAULT '1',
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `clients` (`clientId`, `clientFirstName`, `clientLastName`, `clientEmail`, `clientPassword`, `clientLevel`, `comment`) VALUES
(1, 'Diego', 'Silva', 'diego@email.com', '$2y$10$9I11tr1vlIjT7J.TXFDQ9OGIGRU2wvUAXgRubCAHjkWor5dsLQ8Mq', '3', NULL),
(2, 'carlos', 'souza', 'carlos@email.com', '$2y$10$0SeHS1xdASuNpmU.K6xxmeGqF3tOOQ5PZlzXZnb91wxOD.60HPh/K', '1', NULL);

CREATE TABLE `images` (
  `imgId` int(11) NOT NULL,
  `invId` int(11) NOT NULL,
  `imgName` varchar(100) CHARACTER SET utf8 NOT NULL,
  `imgPath` varchar(150) CHARACTER SET utf8 NOT NULL,
  `imgDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `imgPrimary` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `images` (`imgId`, `invId`, `imgName`, `imgPath`, `imgDate`, `imgPrimary`) VALUES
(1, 12, 'hummer.jpg', '/phpmotors/images/vehicles/hummer.jpg', '2021-12-10 23:20:03', 1),
(2, 12, 'hummer-tn.jpg', '/phpmotors/images/vehicles/hummer-tn.jpg', '2021-12-10 23:20:03', 1),
(3, 12, 'hummer-aux.jpg', '/phpmotors/images/vehicles/hummer-aux.jpg', '2021-12-10 23:20:58', 0),
(4, 12, 'hummer-aux-tn.jpg', '/phpmotors/images/vehicles/hummer-aux-tn.jpg', '2021-12-10 23:20:58', 0),
(5, 12, 'hummer-car.jpg', '/phpmotors/images/vehicles/hummer-car.jpg', '2021-12-10 23:21:11', 0),
(6, 12, 'hummer-car-tn.jpg', '/phpmotors/images/vehicles/hummer-car-tn.jpg', '2021-12-10 23:21:11', 0),
(7, 9, 'crown_victoria.jpg', '/phpmotors/images/vehicles/crown_victoria.jpg', '2021-12-11 20:59:45', 1),
(8, 9, 'crown_victoria-tn.jpg', '/phpmotors/images/vehicles/crown_victoria-tn.jpg', '2021-12-11 20:59:45', 1),
(9, 16, 'tesla_sedan.jpg', '/phpmotors/images/vehicles/tesla_sedan.jpg', '2021-12-11 21:01:46', 1),
(10, 16, 'tesla_sedan-tn.jpg', '/phpmotors/images/vehicles/tesla_sedan-tn.jpg', '2021-12-11 21:01:46', 1);

CREATE TABLE `inventory` (
  `invId` int(11) NOT NULL,
  `invMake` varchar(30) NOT NULL,
  `invModel` varchar(30) NOT NULL,
  `invDescription` text NOT NULL,
  `invImage` varchar(50) NOT NULL,
  `invThumbnail` varchar(50) NOT NULL,
  `invPrice` decimal(10,0) NOT NULL,
  `invStock` smallint(6) NOT NULL,
  `invColor` varchar(20) NOT NULL,
  `classificationId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `inventory` (`invId`, `invMake`, `invModel`, `invDescription`, `invImage`, `invThumbnail`, `invPrice`, `invStock`, `invColor`, `classificationId`) VALUES
(1, 'Jeep ', 'Wrangler', 'The Jeep Wrangler is small and compact with enough power to get you where you want to go. It is great for everyday driving as well as off-roading whether that be on the rocks or in the mud!', '/images/jeep-wrangler.jpg', '/images/jeep-wrangler-tn.jpg', '28045', 4, 'Orange', 1),
(2, 'Ford', 'Model T', 'The Ford Model T can be a bit tricky to drive. It was the first car to be put into production. You can get it in any color you want if it is black.', '/images/ford-modelt.jpg', '/images/ford-modelt-tn.jpg', '30000', 2, 'Black', 2),
(3, 'Lamborghini', 'Adventador', 'This V-12 engine packs a punch in this sporty car. Make sure you wear your seatbelt and obey all traffic laws.', '/images/lambo-Adve.jpg', '/images/lambo-Adve-tn.jpg', '417650', 1, 'White', 3),
(4, 'Monster', 'Truck', 'Most trucks are for working, this one is for fun. This beast comes with 60 inch tires giving you the traction needed to jump and roll in the mud.', '/images/monster.jpg', '/images/monster-tn.jpg', '900002', 3, 'pink', 2),
(5, 'Mechanic', 'Special', 'Not sure where this car came from. However, with a little tender loving care it will run as good a new.', '/images/ms.jpg', '/images/ms-tn.jpg', '100', 1, 'Rust', 5),
(6, 'Batmobile', 'Custom', 'Ever want to be a superhero? Now you can with the bat mobile. This car allows you to switch to bike mode allowing for easy maneuvering through traffic during rush hour.', '/images/bat.jpg', '/images/bat-tn.jpg', '65000', 1, 'Black', 3),
(7, 'Mystery', 'Machine', 'Scooby and the gang always found luck in solving their mysteries because of their 4 wheel drive Mystery Machine. This Van will help you do whatever job you are required to with a success rate of 100%.', '/images/mm.jpg', '/images/mm-tn.jpg', '10000', 12, 'Green', 1),
(8, 'Spartan', 'Fire Truck', 'Emergencies happen often. Be prepared with this Spartan fire truck. Comes complete with 1000 ft. of hose and a 1000-gallon tank.', '/images/fire-truck.jpg', '/images/fire-truck-tn.jpg', '50000', 1, 'Red', 4),
(9, 'Ford', 'Crown Victoria', 'After the police force updated their fleet these cars are now available to the public! These cars come equipped with the siren which is convenient for college students running late to class.', '/images/crown-vic.jpg', '/images/crown-vic-tn.jpg', '10000', 5, 'White', 5),
(10, 'Chevy', 'Camaro', 'If you want to look cool this is the car you need! This car has great performance at an affordable price. Own it today!', '/images/camaro.jpg', '/images/camaro-tn.jpg', '25000', 10, 'Silver', 3),
(11, 'Cadillac', 'Escalade', 'This styling car is great for any occasion from going to the beach to meeting the president. The luxurious inside makes this car a home away from home.', '/images/escalade.jpg', '/images/escalade-tn.jpg', '75195', 4, 'Black', 1),
(12, 'GM', 'Hummer', 'Do you have 6 kids and like to go off-roading? The Hummer gives you the small interiors with an engine to get you out of any muddy or rocky situation.', '/images/hummer.jpg', '/images/hummer-tn.jpg', '58800', 5, 'Yellow', 5),
(13, 'Aerocar International', 'Aerocar', 'Are you sick of rush hour traffic? This car converts into an airplane to get you where you are going fast. Only 6 of these were made, get this one while it lasts!', '/images/aerocar.jpg', '/images/aerocar-tn.jpg', '1000000', 1, 'Red', 2),
(14, 'FBI', 'Surveillance Van', 'Do you like police shows? You will feel right at home driving this van. Comes complete with surveillance equipment for an extra fee of $2,000 a month. ', '/images/fbi.jpg', '/images/fbi-tn.jpg', '20000', 1, 'Green', 1),
(16, 'Tesla', 'Sedan', 'The best car ever', '/images/no-image.png', '/images/no-image.png', '15000', 3, 'Black', 3),
(17, 'ter', 'erer', 'reerg', '/images/no-image.png', '/images/no-image.png', '15000', 12, 'Black', 3),
(19, 'Tesla', 'Model x', 'teste few fw wfew fwgwefwfw fwfefwefwefwewef fwefwefwefwefwef', '/images/no-image.png', '/images/no-image.png', '150000', 2, 'Blue', 3);

CREATE TABLE `reviews` (
  `reviewId` int(10) NOT NULL,
  `reviewText` text NOT NULL,
  `reviewDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `invId` int(11) NOT NULL,
  `clientId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `reviews` (`reviewId`, `reviewText`, `reviewDate`, `invId`, `clientId`) VALUES
(3, 'I loved it', '2021-12-11 20:24:47', 12, 2),
(4, 'Great', '2021-12-11 20:27:45', 12, 1),
(5, 'perfect', '2021-12-11 21:02:00', 16, 1),
(6, 'ejifwuiofn iwbefw fowebfiw bfuiwebf iwbfuiw bfiwebif bweibfwibfiw', '2021-12-11 21:02:24', 16, 1);

ALTER TABLE `carclassification`
  ADD PRIMARY KEY (`classificationId`);

ALTER TABLE `clients`
  ADD PRIMARY KEY (`clientId`),
  ADD UNIQUE KEY `clientEmail` (`clientEmail`);

ALTER TABLE `images`
  ADD PRIMARY KEY (`imgId`),
  ADD KEY `FK_inv_images` (`invId`);

ALTER TABLE `inventory`
  ADD PRIMARY KEY (`invId`),
  ADD KEY `classificationId` (`classificationId`);

ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `FK_reviews_inventory` (`invId`);

ALTER TABLE `carclassification`
  MODIFY `classificationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `clients`
  MODIFY `clientId` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `images`
  MODIFY `imgId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `inventory`
  MODIFY `invId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

ALTER TABLE `reviews`
  MODIFY `reviewId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `images`
  ADD CONSTRAINT `FK_inv_images` FOREIGN KEY (`invId`) REFERENCES `inventory` (`invId`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`classificationId`) REFERENCES `carclassification` (`classificationId`);

ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_reviews_inventory` FOREIGN KEY (`invId`) REFERENCES `inventory` (`invId`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_reviews_client` FOREIGN KEY (`clientId`) REFERENCES `clients` (`clientId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;