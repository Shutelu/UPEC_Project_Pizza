# UPEC Project Restaurant

Description :<br>
This is one of my university project at UPEC (Université Paris-Est Créteil) in 2021-2022.
The goal of the project is to create a website that can place pizza orders.<br>
This project is done by using the framework LARAVEL, it contains PHP/HTML/CSS codes and files.
It uses PHP version 8.1.0 and LARAVEL version 9.1.0.

You will need composer https://getcomposer.org/ to open this project.<br>
You will also need a database to work with the project (see the SQL codes below).<br>
Please use sqlite https://www.sqlite.org/index.html for more simplicity (you can still use MySQL,etc..)

To open and use this project correctly:
- Step 1:<br>
You can either use "git clone https://github.com/Shutelu/UPEC_Project_restaurant.git"<br>
Or if you download it manually you will need to unzip it and place it into a directory.
- Step 2:<br>
Open a CMD, Git Bash, Terminal, etc.. at the directory and enter "composer update", it will download the necessary files for the project to work.
- Step 3:<br>
Open the directory with a text-editor and go to the database directory and place your database here.
- Step 4:<br>
Duplicate the .env.example and rename it to .env then go to .env file.<br>
At line 11 replace the text after equal to sqlite/mysql/others , example : DB_CONNECTION=sqlite<br>
If you're using sqlite, at line 14 write the absolute path to the database, example: DB_DATABASE=C:\my\absolute\path\database\filename.sqlite
- Step 5:<br>
Enter "php artisan key:generate" in the CMD, Git Bash, Terminal, others that you have opened in step 2.

Finally, you can open the web application with the internal PHP server by using the command "php artisan serve" 
And open your favorite web browser and enter in the URL "localhost:8000/".

The administrator is already created (login = admin, password = admin)
<br>
<br>
!!! This project is already finished and will no longer be update
<br>
<br>
<br>
Author : Changkai WANG<br>
Contact : https://www.linkedin.com/in/changkai-wang-691465236/
<br>
<br>
<br>

SQL codes for the database, 
Save this code into a file with .sql extension then open a CMD, Git Bash, Terminal on the location of the file 
and enter "sqlite3 filename.sqlite < filename.sql" to create a sqlite database:
```
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` integer NOT NULL /*!40101 AUTO_INCREMENT */,
  `nom` varchar(40),
  `prenom` varchar(40),
  `login` varchar(30) NOT NULL UNIQUE,
  `mdp` varchar(60) NOT NULL,
  `type` varchar(5) NOT NULL DEFAULT 'user',
            check (type in ('user','admin','cook')), 
  PRIMARY KEY (`id`)
) /*!40101 AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 */;

INSERT INTO `users` (`id`, `nom`, `prenom`,`login`, `mdp`, `type`) VALUES 
('1', 'Admin', 'User', 'admin', '$2y$10$OgGilVcpTrARPRsrx8YZf.GRCGW3EAugei7htlwYaGDdbROVRY2pu', 'admin'), 
('2', 'Cook', 'user', 'cook', '$2y$10$/gM6HwqNSQFvY9DNc9dZWeQXHOd2nR4iFmJYNj1NNO2Tb2R.5RD5a', 'cook');


DROP TABLE IF EXISTS `pizzas`;
CREATE TABLE IF NOT EXISTS `pizzas` (
  `id` integer NOT NULL /*!40101 AUTO_INCREMENT */,
  `nom` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal (5,2) NOT NULL, 
  `created_at` datetime, 
  `updated_at` datetime, 
  `deleted_at` datetime,
  PRIMARY KEY (`id`)
) /*!40101 AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 */;

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` integer NOT NULL /*!40101 AUTO_INCREMENT */,
  `user_id` integer NOT NULL,
  `statut` varchar(10) NOT NULL,
  `created_at` datetime, 
  `updated_at` datetime, 
    CHECK (statut IN ('envoye','traitement','pret','recupere')), 
    FOREIGN KEY(`user_id`) REFERENCES `users`(`id`),
  PRIMARY KEY (`id`)
) /*!40101 AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 */;

DROP TABLE IF EXISTS `commande_pizza`;
CREATE TABLE IF NOT EXISTS `commande_pizza` (
  `commande_id` integer NOT NULL,
  `pizza_id` integer NOT NULL,
  `qte` integer DEFAULT 1 NOT NULL,
    FOREIGN KEY(`commande_id`) REFERENCES `commandes`(`id`),
    FOREIGN KEY(`pizza_id`) REFERENCES `pizzas`(`id`),
  PRIMARY KEY (`commande_id`,`pizza_id`)
) /*!40101 DEFAULT CHARSET=utf8mb4 */;
```
