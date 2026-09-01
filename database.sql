-- SmashZone Database SQL Dump
-- Database Name: smashZone

CREATE DATABASE IF NOT EXISTS `smashZone` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `smashZone`;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. USERS TABLE
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(30) DEFAULT NULL,
  `profile_picture` VARCHAR(255) DEFAULT NULL,
  `role` ENUM('customer', 'admin') NOT NULL DEFAULT 'customer',
  `status` ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Default Accounts (Customer & Admin)
INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `profile_picture`, `role`, `status`) VALUES
(1, 'Marcus', 'Vance', 'customer@smashzone.lk', '$2y$10$GXuJ5YEwtYy6yJAvsbi4U.fSraB.MR2rRd0vx0GE9X1lPHRUTZLou', '+94 77 123 4567', 'images/avatars/default-avatar.svg', 'customer', 'active'),
(2, 'SmashZone', 'Administrator', 'admin@smashzone.lk', '$2y$10$glouw5fZy3Pr9Ez9ILcvIuXpDwygOJBaRlL9W0xnS48sO3DZWK53a', '+94 11 234 5678', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80', 'admin', 'active')
ON DUPLICATE KEY UPDATE `email` = VALUES(`email`);

-- 2. CATEGORIES TABLE
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50) NOT NULL,
  `slug` VARCHAR(50) NOT NULL UNIQUE,
  `description` TEXT DEFAULT NULL,
  `image` VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed Categories
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`) VALUES
(1, 'Badminton Rackets', 'rackets', 'Professional attack, speed, and control rackets.', 'images/categories/category-rackets.png'),
(2, 'Shuttlecocks', 'shuttlecocks', 'Tournament goose feather and durable nylon shuttles.', 'images/categories/category-shuttlecocks.png'),
(3, 'Badminton Shoes', 'shoes', 'High-grip non-marking gum rubber court shoes.', 'images/categories/category-shoes.png'),
(4, 'Clothings', 'clothing', 'Breathable dry-fit jerseys, shorts, and activewear.', 'images/categories/category-clothings.png'),
(5, 'Badminton Bags', 'bags', 'Thermal-lined multi-racket bags and backpacks.', 'images/categories/category-bags.png'),
(6, 'Accessories', 'accessories', 'Overgrips, high-tension string reels, stencils, and powders.', 'images/categories/category-accessories.png')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- 3. PRODUCTS TABLE
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NOT NULL,
  `brand` VARCHAR(50) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `old_price` DECIMAL(10,2) NOT NULL,
  `badge` VARCHAR(50) DEFAULT 'NEW',
  `badge_class` VARCHAR(50) DEFAULT 'badge-new',
  `rating` DECIMAL(3,1) DEFAULT 5.0,
  `reviews` INT DEFAULT 50,
  `image` VARCHAR(255) NOT NULL,
  `spec_1` VARCHAR(50) DEFAULT NULL,
  `spec_2` VARCHAR(50) DEFAULT NULL,
  `spec_3` VARCHAR(50) DEFAULT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed 17 Badminton Rackets
INSERT INTO `products` (`id`, `category_id`, `brand`, `name`, `price`, `old_price`, `badge`, `badge_class`, `rating`, `reviews`, `image`, `spec_1`, `spec_2`, `spec_3`, `description`) VALUES
(101, 1, 'Yonex', 'Yonex Astrox 100ZZ Kurenai', 84500.00, 94000.00, 'PRO CHOICE', 'badge-hot', 5.0, 98, 'images/products/rackets/r1.png', 'Head Heavy', 'Advanced', '4U (83g)', 'Flagship Astrox 100ZZ with Hyper Slim Shaft and Namd graphite for steep smashes.'),
(102, 1, 'Yonex', 'Yonex Nanoflare 800 Game', 42900.00, 48000.00, 'POPULAR', 'badge-new', 4.8, 64, 'images/products/rackets/r2.png', 'Head Light', 'Intermediate', '4U (83g)', 'Lightning-fast drive rallies and rapid court movements.'),
(103, 1, 'Li-Ning', 'Li-Ning Axforce 90 Max Dragon', 78500.00, 86000.00, 'FLAGSHIP', 'badge-hot', 5.0, 82, 'images/products/rackets/r3.png', 'Head Heavy', 'Advanced', '4U (83g)', 'Built with M50 super high-elastic carbon fiber for explosive power.'),
(104, 1, 'Li-Ning', 'Li-Ning 3D Calibar 900B', 62000.00, 69000.00, 'TOP RATED', 'badge-new', 4.9, 59, 'images/products/rackets/r4.png', 'Even Balance', 'Advanced', '3U (87g)', '3D Calibar geometric airflow frame reduces air resistance.'),
(105, 1, 'Hundred', 'Hundred Battle 600 Power', 38500.00, 44000.00, 'POWER SMASH', 'badge-hot', 4.9, 51, 'images/products/rackets/r5.png', 'Head Heavy', 'Advanced', '3U (86g)', 'VaporShaft XS technology delivers maximum kinetic transfer.'),
(106, 1, 'Wish', 'Wish Fusion 990 Graphite', 18900.00, 22500.00, 'GREAT VALUE', 'badge-sale', 4.7, 46, 'images/products/rackets/r6.png', 'Even Balance', 'Intermediate', '4U (83g)', 'Full graphite construction for smooth control.'),
(107, 1, 'Maxbolt', 'Maxbolt Black Woven Edition', 52000.00, 59000.00, 'WOVEN TECH', 'badge-hot', 4.9, 67, 'images/products/rackets/r7.png', 'Head Heavy', 'Advanced', '4U (83g)', 'Japanese Woven Graphite for 35 lbs high tension.'),
(108, 1, 'Yonex', 'Yonex Arcsaber 11 Pro', 79000.00, 87500.00, 'BESTSELLER', 'badge-sale', 4.9, 92, 'images/products/rackets/r8.jpeg', 'Even Balance', 'Advanced', '3U (88g)', 'Decisive shuttle control and surgical precision drop shots.'),
(109, 1, 'Li-Ning', 'Li-Ning Halbertec 8000', 46500.00, 52000.00, 'NEW ARRIVAL', 'badge-new', 4.8, 41, 'images/products/rackets/r9.jpeg', 'Head Heavy', 'Intermediate', '4U (84g)', 'Balanced control and high-modulus carbon tubing.'),
(110, 1, 'Hundred', 'Hundred Atomic X 90', 24500.00, 28900.00, 'BESTSELLER', 'badge-sale', 4.8, 71, 'images/products/rackets/r10.jpeg', 'Even Balance', 'Intermediate', '4U (82g)', 'Atomic power carbon build for speed and flat drives.'),
(111, 1, 'Maxbolt', 'Maxbolt Gallant Tour', 44500.00, 51000.00, 'PRO SMASH', 'badge-new', 4.9, 50, 'images/products/rackets/r11.jpeg', 'Head Heavy', 'Advanced', '3U (87g)', 'Heavy-duty attack racquet with boxed frame profile.'),
(112, 1, 'Yonex', 'Yonex Muscle Power 29 Light', 16500.00, 19500.00, 'VALUE', 'badge-new', 4.7, 43, 'images/products/rackets/r12.jpeg', 'Even Balance', 'Beginner', '4U (83g)', 'Durable isometric frame with forgiving sweet spot.'),
(113, 1, 'Li-Ning', 'Li-Ning Windstorm 72 Ultra-Light', 29900.00, 34500.00, 'FEATHER LIGHT', 'badge-sale', 4.9, 112, 'images/products/rackets/r13.jpeg', 'Head Heavy', 'Intermediate', '6U (72g)', 'Ultra-lightweight 72g frame for fast net intercepts.'),
(114, 1, 'Hundred', 'Hundred N-Force 100 Attack', 19500.00, 23000.00, '-15%', 'badge-sale', 4.7, 38, 'images/products/rackets/r14.jpeg', 'Head Heavy', 'Intermediate', '4U (83g)', 'Heavy-head offensive design supporting string tension up to 32 lbs.'),
(115, 1, 'Wish', 'Wish Alumtec 317 Set', 8500.00, 10500.00, 'BUDGET STARTER', 'badge-sale', 4.5, 55, 'images/products/rackets/r15.jpeg', 'Head Light', 'Beginner', '5U (90g)', 'Durable aluminum-steel set for casual practice.'),
(116, 1, 'Maxbolt', 'Maxbolt Woven Tech 90', 29500.00, 34000.00, 'BESTSELLER', 'badge-sale', 4.8, 58, 'images/products/rackets/r16.jpeg', 'Even Balance', 'Intermediate', '4U (83g)', 'Snappy frame rebound and high tension capacity.'),
(117, 1, 'Wish', 'Wish X-Caliber 500', 21500.00, 25000.00, 'HOT DEAL', 'badge-hot', 4.8, 40, 'images/products/rackets/r17.jpeg', 'Head Heavy', 'Intermediate', '4U (84g)', 'Aero-dynamic frame with vibration dampening.')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Seed 9 Shuttlecocks
INSERT INTO `products` (`id`, `category_id`, `brand`, `name`, `price`, `old_price`, `badge`, `badge_class`, `rating`, `reviews`, `image`, `spec_1`, `spec_2`, `spec_3`, `description`) VALUES
(201, 2, 'Yonex', 'Yonex Aero-Sensa 50 (AS-50)', 18500.00, 21000.00, 'BWF APPROVED', 'badge-hot', 5.0, 128, 'images/products/Shuttlecocks/s1.png', 'Feather', 'Speed 77', 'BWF Tournament', 'Official BWF Grade 1 goose feather shuttlecock engineered for international tournament play.'),
(202, 2, 'Yonex', 'Yonex Aero-Sensa 30 (AS-30)', 14200.00, 16500.00, 'BESTSELLER', 'badge-sale', 4.9, 95, 'images/products/Shuttlecocks/s2.png', 'Feather', 'Speed 77', 'Club Play', 'Tournament class goose feather shuttlecock with stable flight trajectory and high durability.'),
(203, 2, 'Yonex', 'Yonex Mavis 350 Nylon (Pack of 6)', 6800.00, 7900.00, 'HIGH DURABILITY', 'badge-new', 4.8, 140, 'images/products/Shuttlecocks/s3.png', 'Nylon', 'Speed 77', 'Practice & Club', 'Worlds leading synthetic shuttlecock with patented Wing Ribbon technology for feather-like flight.'),
(204, 2, 'Li-Ning', 'Li-Ning G900 Grand Prix Feather', 17900.00, 19800.00, 'NATIONAL TEAM', 'badge-hot', 4.9, 64, 'images/products/Shuttlecocks/s4.jpeg', 'Feather', 'Speed 77', 'BWF Tournament', 'Official match shuttlecock used by the China National Badminton Team in international play.'),
(205, 2, 'Li-Ning', 'Li-Ning A+300 Premium Feather', 12800.00, 14500.00, 'POPULAR', 'badge-sale', 4.8, 58, 'images/products/Shuttlecocks/s5.jpeg', 'Feather', 'Speed 76', 'Club Play', 'Selected premium duck feather shuttlecock offering exceptional flight consistency for club matches.'),
(206, 2, 'Victor', 'Victor Master No. 1 Feather', 16900.00, 18900.00, 'TOP RATED', 'badge-hot', 4.9, 73, 'images/products/Shuttlecocks/s6.jpeg', 'Feather', 'Speed 77', 'BWF Tournament', 'BWF certified tournament goose shuttlecock with high-density natural cork base.'),
(207, 2, 'Victor', 'Victor Carbosonic CS-No1 Synthetic', 7500.00, 8800.00, 'CARBON TECH', 'badge-new', 4.7, 36, 'images/products/Shuttlecocks/s7.jpeg', 'Nylon', 'Speed 77', 'Practice', 'Revolutionary carbon foam feather stem structure delivering 300% longer practice lifespan.'),
(208, 2, 'RSL', 'RSL Tourney No. 1 Feather', 15800.00, 17900.00, 'LEGENDARY', 'badge-sale', 5.0, 110, 'images/products/Shuttlecocks/s8.jpeg', 'Feather', 'Speed 77', 'BWF Tournament', 'World renowned tournament shuttlecock engineered for maximum flight precision and durability.'),
(209, 2, 'Carlton', 'Carlton AG 50 Tournament Feather', 14900.00, 16800.00, 'NEW', 'badge-new', 4.7, 29, 'images/products/Shuttlecocks/s9.jpeg', 'Feather', 'Speed 77', 'BWF Tournament', 'British-engineered tournament feather shuttlecocks featuring anti-fracture feather spine alignment.')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Seed 14 Shoes
INSERT INTO `products` (`id`, `category_id`, `brand`, `name`, `price`, `old_price`, `badge`, `badge_class`, `rating`, `reviews`, `image`, `spec_1`, `spec_2`, `spec_3`, `description`) VALUES
(301, 3, 'Yonex', 'Yonex Power Cushion 65Z3 White/Tiger', 45900.00, 52000.00, 'PRO CHOICE', 'badge-hot', 5.0, 86, 'images/products/shoes/sh1.png', 'Power Cushion+', 'Men Fit', NULL, 'World champion choice featuring Power Cushion+ shock absorption and Radial Blade high-traction outsole.'),
(302, 3, 'Asics', 'Asics Gel-Blade 8 Court White/Blue', 36500.00, 41000.00, 'POPULAR', 'badge-sale', 4.9, 92, 'images/products/shoes/sh2.png', 'GEL Technology', 'Unisex Fit', NULL, 'Rearfoot GEL cushioning with X-GUIDANCE flex grooves for rapid diagonal court movements.'),
(303, 3, 'Yonex', 'Yonex Aerus Z2 Ultra-Light Cyan', 48500.00, 54000.00, 'LIGHTEST', 'badge-new', 4.9, 62, 'images/products/shoes/sh3.png', 'Feather Bounce', 'Unisex Fit', NULL, 'Yonex lightest badminton shoe at 240g engineered for ultra-fast footwork and jump smashes.'),
(304, 3, 'Yonex', 'Yonex Power Cushion 65Z3 Red Edition', 46900.00, 53000.00, 'TOURNAMENT', 'badge-hot', 5.0, 78, 'images/products/shoes/sh4.png', 'Power Cushion+', 'Men Fit', NULL, 'Tournament edition 65Z3 with Power Graphite Sheet for midfoot stability during high impact landings.'),
(305, 3, 'Li-Ning', 'Li-Ning Ranger VI Pro Red/Black', 39500.00, 44000.00, 'BESTSELLER', 'badge-sale', 4.9, 54, 'images/products/shoes/sh5.jpeg', 'BounSe+ Rubber', 'Men Fit', NULL, 'Carbon fiber arch support plate paired with non-marking gum rubber sole for aggressive lunges.'),
(306, 3, 'Li-Ning', 'Li-Ning Saga II SE Stability', 31000.00, 35000.00, 'HIGH STABILITY', 'badge-sale', 4.8, 41, 'images/products/shoes/sh6.jpeg', 'Cushion Foam', 'Unisex Fit', NULL, 'Lateral claw TPU stabilizer preventing ankle rolls during fast direction changes on wood/mat courts.'),
(307, 3, 'Victor', 'Victor P9200III Crown Collection', 46000.00, 51500.00, 'SUPREME CUSHION', 'badge-hot', 5.0, 79, 'images/products/shoes/sh7.jpeg', 'EnergyMax 3.0', 'Men Fit', NULL, 'Heavy cushion shock absorbing heel pod designed for maximum knee protection during jumping smashes.'),
(308, 3, 'Victor', 'Victor A970ACE All-Around Speed', 42000.00, 47000.00, 'NEW', 'badge-new', 4.8, 35, 'images/products/shoes/sh8.jpeg', 'HYPEREVA Foam', 'Women Fit', NULL, 'HYPEREVA lightweight foam mid-sole wrapped in durable micro-fiber PU leather upper.'),
(309, 3, 'Mizuno', 'Mizuno Wave Claw 2 Special Edition', 44000.00, 49000.00, 'POWER GRIP', 'badge-hot', 4.9, 58, 'images/products/shoes/sh9.jpeg', 'Mizuno Wave', 'Men Fit', NULL, 'Wave plate technology disperses impact forces evenly while maintaining maximum court response.'),
(310, 3, 'Yonex', 'Yonex Power Cushion Eclipsion Z3', 49900.00, 55000.00, 'FLAGSHIP', 'badge-hot', 5.0, 48, 'images/products/shoes/sh10.jpeg', 'Radial Blade', 'Women Fit', NULL, 'Semi-one-piece sole structure providing unmatched lateral stability and court grip.'),
(311, 3, 'Li-Ning', 'Li-Ning Halberd V Junior Court', 18500.00, 22000.00, 'JUNIOR PICK', 'badge-sale', 4.7, 29, 'images/products/shoes/sh11.jpeg', 'Non-Marking Gum', 'Junior Fit', NULL, 'Specialized junior support shoe featuring extra toe anti-abrasion rubber guards for young players.'),
(312, 3, 'Yonex', 'Yonex Court Trace All-Court Black', 29500.00, 34000.00, 'ALL COURT', 'badge-new', 4.7, 36, 'images/products/shoes/sh12.jpeg', 'Hexagrip Sole', 'Men Fit', NULL, 'Hexagrip sole pattern provides 3% more grip and is 20% lighter than standard sole materials.'),
(313, 3, 'Victor', 'Victor S82 Speed Series Gold', 43500.00, 48500.00, 'SPEED TECH', 'badge-hot', 4.9, 51, 'images/products/shoes/sh13.jpeg', 'V-Durable+', 'Unisex Fit', NULL, 'Carbon Power sheet provides midfoot torsional rigidity and instant energy return.'),
(314, 3, 'Asics', 'Asics Gel-Rocket 10 Indoor Blue', 24500.00, 28000.00, 'VALUE CHOICE', 'badge-sale', 4.8, 104, 'images/products/shoes/sh14.jpeg', 'Trusstic System', 'Men Fit', NULL, 'Multi-purpose indoor court shoe with Trusstic technology for midfoot support during quick cuts.')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Seed 16 Clothings
INSERT INTO `products` (`id`, `category_id`, `brand`, `name`, `price`, `old_price`, `badge`, `badge_class`, `rating`, `reviews`, `image`, `spec_1`, `spec_2`, `spec_3`, `description`) VALUES
(401, 4, 'Yonex', 'Yonex Pro Tournament Crew Jersey Red', 12500.00, 14500.00, 'PRO SERIES', 'badge-hot', 4.9, 64, 'images/products/clothings/c1.png', 'Match Jersey', 'Men', NULL, 'VERYCOOL dry technology lowers body heat by 3°C with micro-mesh ventilation panels.'),
(402, 4, 'Li-Ning', 'Li-Ning China National Team Match Tee', 13800.00, 16000.00, 'NATIONAL TEAM', 'badge-new', 5.0, 82, 'images/products/clothings/c2.png', 'Match Jersey', 'Unisex', NULL, 'AT-DRY fast drying technology rapidly wicks sweat during intensive multi-set matches.'),
(403, 4, 'Yonex', 'Yonex Tournament Performance Cap White', 4200.00, 5000.00, 'SUN PROTECT', 'badge-sale', 4.8, 76, 'images/products/clothings/c3.png', 'Cap / Visor', 'Unisex', NULL, 'Lightweight UV reduction sports cap with internal absorbent sweatband lining.'),
(404, 4, 'Yonex', 'Yonex High Elastic Match Shorts Black', 8900.00, 10500.00, 'BESTSELLER', 'badge-sale', 4.8, 51, 'images/products/clothings/c4.jpeg', 'Court Shorts', 'Men', NULL, 'Anti-static lightweight woven stretch shorts with ball storage pockets and elastic waist.'),
(405, 4, 'Victor', 'Victor Crown Pro Stretch Court Shorts', 9200.00, 10800.00, 'STRETCH FIT', 'badge-new', 4.7, 39, 'images/products/clothings/c5.jpeg', 'Court Shorts', 'Unisex', NULL, 'Moisture management 4-way stretch fabric engineered for wide foot split lunges.'),
(406, 4, 'Victor', 'Victor Sleeveless Training Vest Yellow', 7800.00, 9000.00, 'NEW', 'badge-new', 4.8, 34, 'images/products/clothings/c6.jpeg', 'Sleeveless Vest', 'Men', NULL, 'Zero shoulder friction design allowing full overhead smash swings and shoulder motion.'),
(407, 4, 'Hundred', 'Hundred Vapor Cool Agility Vest Blue', 6200.00, 7400.00, 'HOT DEAL', 'badge-sale', 4.7, 29, 'images/products/clothings/c7.jpeg', 'Sleeveless Vest', 'Men', NULL, 'VaporCool mesh ventilation panel on back for continuous airflow during high intensity drills.'),
(408, 4, 'Yonex', 'Yonex 3D Ergo Cushion Socks (Pack of 3)', 3900.00, 4800.00, '3D CUSHION', 'badge-hot', 5.0, 112, 'images/products/clothings/c8.jpeg', 'Court Socks', 'Unisex', NULL, 'Ankle support pod and reinforced Achilles heel cushion to absorb hard court impacts.'),
(409, 4, 'Li-Ning', 'Li-Ning Thick Towel Sole Socks Pair', 2400.00, 3000.00, 'HIGH VALUE', 'badge-sale', 4.8, 85, 'images/products/clothings/c9.jpeg', 'Court Socks', 'Unisex', NULL, 'Heavy cotton terry towel sole prevents shoe slippage during sudden court stopping movements.'),
(410, 4, 'SmashZone', 'SmashZone Official Club Jersey White/Cyan', 5800.00, 6900.00, 'EXCLUSIVE', 'badge-hot', 4.9, 94, 'images/products/clothings/c10.jpeg', 'Match Jersey', 'Unisex', NULL, 'Signature SmashZone team apparel with micro-honeycomb breathable mesh fabric.'),
(411, 4, 'Li-Ning', 'Li-Ning Breathable Mesh Court Cap Navy', 3800.00, 4500.00, 'POPULAR', 'badge-new', 4.7, 48, 'images/products/clothings/c11.jpeg', 'Cap / Visor', 'Unisex', NULL, 'Ultra-lightweight mesh side panels keep head cool during sunny outdoor or indoor court games.'),
(412, 4, 'Hundred', 'Hundred Power Motion Training Shorts', 6500.00, 7800.00, 'VALUE PICK', 'badge-sale', 4.6, 43, 'images/products/clothings/c12.jpeg', 'Court Shorts', 'Men', NULL, 'Quick dry polyester fabric with zipper side pockets and ergonomic side hem slits.'),
(413, 4, 'Victor', 'Victor Crown Pro Sun Visor Black', 3900.00, 4600.00, 'NEW', 'badge-new', 4.7, 26, 'images/products/clothings/c13.jpeg', 'Cap / Visor', 'Women', NULL, 'Open top sun visor providing glare protection without restricting overhead head heat dissipation.'),
(414, 4, 'Yonex', 'Yonex Pro Sleeveless Match Top Red', 9500.00, 11000.00, 'PRO SERIES', 'badge-hot', 4.9, 37, 'images/products/clothings/c14.jpeg', 'Sleeveless Vest', 'Men', NULL, 'Tournament grade sleeveless match shirt with Polygiene anti-odor treatment.'),
(415, 4, 'Victor', 'Victor High-Density Ankle Socks (Pack of 3)', 3500.00, 4200.00, 'COMFORT PACK', 'badge-sale', 4.8, 59, 'images/products/clothings/c15.jpeg', 'Court Socks', 'Unisex', NULL, 'High density elastic arch support band reduces foot fatigue during long training sessions.'),
(416, 4, 'Yonex', 'Yonex Women Team Skort with Inner Short', 11200.00, 13000.00, 'ELEGANT FIT', 'badge-new', 4.9, 29, 'images/products/clothings/c16.jpeg', 'Court Skort', 'Women', NULL, 'Badminton match skort featuring built-in compression inner shorts for total freedom of motion.')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Seed 7 Bags
INSERT INTO `products` (`id`, `category_id`, `brand`, `name`, `price`, `old_price`, `badge`, `badge_class`, `rating`, `reviews`, `image`, `spec_1`, `spec_2`, `spec_3`, `description`) VALUES
(501, 5, 'Yonex', 'Yonex Pro Stand-up Thermo Bag 92231', 38500.00, 44000.00, 'PRO CHOICE', 'badge-hot', 5.0, 98, 'images/products/bags/b1.png', 'Thermo 6-Racket Bag', '6 Rackets + Gear', NULL, 'Climate protective Thermo-Guard lining keeps racket strings and frames safe from heat and humidity.'),
(502, 5, 'Li-Ning', 'Li-Ning National Team 9-Racket Tournament Bag', 42000.00, 48000.00, 'TOURNAMENT', 'badge-hot', 4.9, 74, 'images/products/bags/b2.jpeg', 'Tour 9-Racket Bag', '9 Rackets + Shoes', NULL, 'Professional tour bag with dual cushioned shoulder straps, shoe tunnel, and wet clothes compartment.'),
(503, 5, 'Victor', 'Victor Supreme Thermo 6-Racket Bag Black/Gold', 32500.00, 37000.00, 'BESTSELLER', 'badge-sale', 4.9, 61, 'images/products/bags/b3.jpeg', 'Thermo 6-Racket Bag', '6 Rackets', NULL, 'Thermal foil insulation chamber with high-density polyester wear resistant fabric.'),
(504, 5, 'Hundred', 'Hundred Tour Series 6-Racket Bag Red/Black', 24900.00, 29000.00, 'VALUE CHAMP', 'badge-sale', 4.8, 43, 'images/products/bags/b4.jpeg', 'Thermo 6-Racket Bag', '6 Rackets', NULL, 'Multi-compartment racket bag with dedicated accessory organizer and padded backpack straps.'),
(505, 5, 'Li-Ning', 'Li-Ning Professional Duffel Tournament Bag Blue', 29500.00, 34000.00, 'NEW ARRIVAL', 'badge-new', 4.8, 38, 'images/products/bags/b5.jpeg', 'Tour Duffel Bag', '6 Rackets + Apparel', NULL, 'Wide-opening barrel duffel design featuring waterproof base layer and ventilated shoe pocket.'),
(506, 5, 'Victor', 'Victor Rectangular Tournament Racket Bag', 36900.00, 41500.00, 'POPULAR', 'badge-sale', 4.9, 52, 'images/products/bags/b6.jpeg', 'Tour 9-Racket Bag', '9 Rackets', NULL, 'Rectangular upright standing shape engineered for maximum court bench space saving.'),
(507, 5, 'Yonex', 'Yonex Pro Badminton Backpack 92212', 26500.00, 30000.00, 'FEATHER LIGHT', 'badge-new', 5.0, 87, 'images/products/bags/b7.png', 'Racket Backpack', '2 Rackets + Laptop', NULL, 'Ergonomic padded shoulder harness with dedicated padded racket sleeve and separate bottom shoe compartment.')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- Seed 11 Accessories
INSERT INTO `products` (`id`, `category_id`, `brand`, `name`, `price`, `old_price`, `badge`, `badge_class`, `rating`, `reviews`, `image`, `spec_1`, `spec_2`, `spec_3`, `description`) VALUES
(601, 6, 'Yonex', 'Yonex BG66 Ultimax String Reel (200m)', 34500.00, 39000.00, 'PRO CHOICE', 'badge-hot', 5.0, 145, 'images/products/accesories/a1.png', 'String Reel', '0.65mm Gauge', NULL, 'High-intensity nylon core string reel with thin 0.65mm gauge delivering maximum repulsion and crisp hitting sound.'),
(602, 6, 'Yonex', 'Yonex Super Grap Overgrip AC102 (3-Pack Yellow)', 2400.00, 2900.00, 'BESTSELLER', 'badge-sale', 5.0, 180, 'images/products/accesories/a2.jpeg', 'Overgrips', '0.6mm Tacky', NULL, 'World class polyurethane tacky overgrip absorbing sweat and preventing handle slippage during intense rallies.'),
(603, 6, 'Li-Ning', 'Li-Ning GP1000 Overgrip Box (10-Pack Assorted)', 5900.00, 6800.00, 'VALUE PACK', 'badge-sale', 4.8, 88, 'images/products/accesories/a3.jpeg', 'Overgrips', '0.6mm Perforated', NULL, 'Durable polyurethane overgrips with micro-perforations for fast moisture absorption.'),
(604, 6, 'Victor', 'Victor AC018 Cotton Sweat Headband Black', 1800.00, 2200.00, 'POPULAR', 'badge-new', 4.8, 56, 'images/products/accesories/a4.jpeg', 'Headband / Wristband', 'Elastic Terry Cotton', NULL, 'High density absorbent cotton headband preventing sweat from trickling into player eyes.'),
(605, 6, 'Yonex', 'Yonex AC489 Double Wide Wristband Pair Red', 2200.00, 2700.00, 'SWEAT SHIELD', 'badge-hot', 4.9, 67, 'images/products/accesories/a5.jpeg', 'Headband / Wristband', 'Double Wide Terry', NULL, 'Double width stretch wristband absorbing arm perspiration before reaching racket handle.'),
(606, 6, 'Yonex', 'Yonex AC470 Grip Powder Bottle (20g)', 3200.00, 3800.00, 'ANTI-SLIP', 'badge-hot', 4.9, 72, 'images/products/accesories/a6.jpeg', 'Grip Powder & Chalk', 'Anti-Slip Powder', NULL, 'Micro magnesium carbonate powder providing immediate dry grip friction for humid indoor court play.'),
(607, 6, 'Victor', 'Victor Racket Logo Stencil Card & Ink Set', 2800.00, 3400.00, 'COURT STYLE', 'badge-new', 4.7, 39, 'images/products/accesories/a7.jpeg', 'Stencil & Care', 'Card + Quick Ink', NULL, 'Quick drying water-based string stencil ink set with durable PVC brand logo template.'),
(608, 6, 'Karakal', 'Karakal Super PU Replacement Cushion Grip', 2900.00, 3500.00, 'SUPREME CUSHION', 'badge-sale', 4.9, 94, 'images/products/accesories/a8.jpeg', 'Overgrips', '1.8mm Cushion', NULL, 'Extra thick replacement base grip with non-slip PU surface and shock absorbing EVA foam backing.'),
(609, 6, 'Li-Ning', 'Li-Ning No.1 Boost String Reel 200m', 31000.00, 36000.00, 'REPULSION POWER', 'badge-hot', 4.8, 58, 'images/products/accesories/a9.jpeg', 'String Reel', '0.65mm 3D Braid', NULL, '3D BRAID technology string reel producing explosive smash sound and retention of string tension.'),
(610, 6, 'Yonex', 'Yonex AC416 Frame Guard Tape Clear', 2100.00, 2600.00, 'FRAME GUARD', 'badge-new', 4.7, 43, 'images/products/accesories/a10.jpeg', 'Stencil & Care', 'Anti-Scuff Tape', NULL, 'Transparent polyurethane frame protector tape preventing court scraping damage during low net retrieves.'),
(611, 6, 'Yonex', 'Yonex Super Grap Overgrip 30-Pack Reel White', 16500.00, 19500.00, 'CLUB BULK PACK', 'badge-sale', 5.0, 126, 'images/products/accesories/a11.png', 'Overgrips', '30-Grip Bulk Reel', NULL, '30-grip mega reel container of genuine AC102EX Super Grap for tournament players and club stringers.')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

-- 4. CONTACT MESSAGES TABLE
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT DEFAULT NULL,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `subject` VARCHAR(200) NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. ORDERS TABLE
CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `total_amount` DECIMAL(10,2) NOT NULL,
  `status` ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
  `shipping_address` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. ORDER ITEMS TABLE
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
