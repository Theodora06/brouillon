-- MySQL Script generated by MySQL Workbench
-- Thu Feb 15 12:50:53 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`utilisateurs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`utilisateurs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(150) NOT NULL,
  `prenom` VARCHAR(150) NOT NULL,
  `pseudo` VARCHAR(100) NOT NULL,
  `email` VARCHAR(200) NOT NULL,
  `tel` VARCHAR(10) NULL,
  `code_postal` VARCHAR(5) NOT NULL,
  `ville` VARCHAR(150) NOT NULL,
  `adresse` VARCHAR(300) NULL,
  `mdp` VARCHAR(255) NULL,
  `date_inscription` TIMESTAMP NOT NULL DEFAULT CURRENT TIMESTAMP,
  `token` VARCHAR(250) NULL,
  `date_naissance` DATE NULL,
  `sexe` TINYINT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`statut`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`statut` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`annonces`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`annonces` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_statut` INT NOT NULL,
  `titre` VARCHAR(150) NOT NULL,
  `contenu` VARCHAR(255) NOT NULL,
  `date_publication` TIMESTAMP NOT NULL DEFAULT CURRENT TIMESTAMP,
  `date_fin` DATE NULL,
  `prix_vente` VARCHAR(45) NULL,
  `cout_annonce` INT NULL,
  `frais_port` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_annonces_utilisateurs1_idx` (`id_user` ASC) VISIBLE,
  INDEX `fk_annonces_statut1_idx` (`id_statut` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`photos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`photos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(200) NOT NULL,
  `id_ann` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_photos_annonces1_idx` (`id_ann` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`categories_annonces`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`categories_annonces` (
  `id_cat` INT NOT NULL,
  `id_ann` INT NOT NULL,
  INDEX `fk_categories_annonces_annonces1_idx` (`id_ann` ASC) VISIBLE,
  INDEX `fk_categories_annonces_categories1_idx` (`id_cat` ASC) VISIBLE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;