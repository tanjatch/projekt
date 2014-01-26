CREATE DATABASE IF NOT EXISTS Movie;
 
USE Movie;
 
--
-- Create table for my own movie database
--
DROP TABLE IF EXISTS Movie;
CREATE TABLE Movie
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  title VARCHAR(100) NOT NULL,
  director VARCHAR(100),
  LENGTH INT DEFAULT NULL, -- Length in minutes
  YEAR INT NOT NULL DEFAULT 1900,
  plot TEXT, -- Short intro to the movie
  image VARCHAR(100) DEFAULT NULL, -- Link to an image
  subtext CHAR(3) DEFAULT NULL, -- swe, fin, en, etc
  speech CHAR(3) DEFAULT NULL, -- swe, fin, en, etc
  quality CHAR(3) DEFAULT NULL,
  format CHAR(3) DEFAULT NULL -- mp4, divx, etc
) ENGINE INNODB CHARACTER SET utf8;
 
 
SHOW CHARACTER SET;
SHOW COLLATION LIKE 'utf8%';
 
DELETE FROM Movie;
 
INSERT INTO Movie (title, YEAR, image) VALUES
  ('Pulp fiction', 1994, 'img/movie/pulp-fiction.jpg'),
  ('American Pie', 1999, 'img/movie/american-pie.jpg'),
  ('Pokémon The Movie 2000', 1999, 'img/movie/pokemon.jpg'),  
  ('Kopps', 2003, 'img/movie/kopps.jpg'),
  ('From Dusk Till Dawn', 1996, 'img/movie/from-dusk-till-dawn.jpg')
;
 
SELECT * FROM Movie;