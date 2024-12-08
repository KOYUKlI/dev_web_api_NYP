-- SQL Script to create and populate the database

CREATE DATABASE IF NOT EXISTS vikings;
USE vikings;

-- Table Weapon
CREATE TABLE IF NOT EXISTS weapon (
  id INT NOT NULL AUTO_INCREMENT,
  type VARCHAR(50) NOT NULL,
  damage INT NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

-- Table Viking
CREATE TABLE IF NOT EXISTS viking (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  attack INT NOT NULL,
  defense INT NOT NULL,
  health INT NOT NULL,
  weaponId INT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (weaponId) REFERENCES weapon(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Sample data for Weapon
INSERT INTO weapon (type, damage) VALUES
('Sword', 50),
('Axe', 60),
('Bow', 40);

-- Sample data for Viking
INSERT INTO viking (name, attack, defense, health, weaponId) VALUES
('Ragnar', 200, 150, 300, 1),
('Floki', 150, 80, 350, 2),
('Lagertha', 300, 200, 200, 3),
('Björn', 350, 200, 100, NULL);
