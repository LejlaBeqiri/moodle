

-- -----------------------------------------------------
-- Schema moodle
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `moodle` ;

-- -----------------------------------------------------
-- Schema moodle
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `moodle` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
USE `moodle` ;

-- -----------------------------------------------------
-- Table `moodle`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `moodle`.`roles` ;

CREATE TABLE IF NOT EXISTS `moodle`.`roles` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `role_name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP(2) NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `moodle`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `moodle`.`users` ;

CREATE TABLE IF NOT EXISTS `moodle`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(55) NOT NULL,
  `last_name` VARCHAR(55) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `document_id` VARCHAR(55) NOT NULL,
  `role_id` INT(11) NOT NULL,
  `admin` TINYINT(4) NULL DEFAULT 0,
  `created_at` TIMESTAMP(2) NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_User_Role_idx` (`role_id` ASC)  ,
  CONSTRAINT `fk_User_Role`
    FOREIGN KEY (`role_id`)
    REFERENCES `moodle`.`roles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `moodle`.`courses`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `moodle`.`courses` ;

CREATE TABLE IF NOT EXISTS `moodle`.`courses` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `semester` ENUM('1', '2', '3', '4', '5', '6') NOT NULL,
  `professor_id` INT(11) NOT NULL,
   `created_at` TIMESTAMP(2) NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_courses_users1_idx` (`professor_id` ASC)  ,
  CONSTRAINT `fk_courses_users1`
    FOREIGN KEY (`professor_id`)
    REFERENCES `moodle`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `moodle`.`professor_assignment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `moodle`.`professor_assignment` ;

CREATE TABLE IF NOT EXISTS `moodle`.`professor_assignment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NULL DEFAULT NULL,
  `description` LONGTEXT NULL DEFAULT NULL,
  `professor_id` INT(11) NOT NULL,
  `course_id` INT(11) NOT NULL,
  `due` TIMESTAMP(2) NULL DEFAULT NULL,
   `created_at` TIMESTAMP(2) NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (`id`),
  INDEX `fk_professor_assignment_users1_idx` (`professor_id` ASC)  ,
  INDEX `fk_professor_assignment_courses1_idx` (`course_id` ASC)  ,
  CONSTRAINT `fk_professor_assignment_courses1`
    FOREIGN KEY (`course_id`)
    REFERENCES `moodle`.`courses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_professor_assignment_users1`
    FOREIGN KEY (`professor_id`)
    REFERENCES `moodle`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `moodle`.`student_assignment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `moodle`.`student_assignment` ;

CREATE TABLE IF NOT EXISTS `moodle`.`student_assignment` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `student_id` INT(11) NOT NULL,
  `title` VARCHAR(255) NULL DEFAULT NULL,
  `description` LONGTEXT NULL DEFAULT NULL,
  `score` INT(11) NULL DEFAULT NULL,
   `semester` ENUM('1', '2', '3', '4', '5', '6') NOT NULL,
  `professor_assignment_id` INT(11) NOT NULL,
  `evaluated` TINYINT(4) NULL DEFAULT NULL,
    `created_at` TIMESTAMP(2) NOT NULL DEFAULT CURRENT_TIMESTAMP(2) ON UPDATE CURRENT_TIMESTAMP(2),
  PRIMARY KEY (`id`),
  INDEX `fk_home_work_users1_idx` (`student_id` ASC)  ,
  INDEX `fk_student_assignment_professor_assignment1_idx` (`professor_assignment_id` ASC)  ,
  CONSTRAINT `fk_home_work_users1`
    FOREIGN KEY (`student_id`)
    REFERENCES `moodle`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_assignment_professor_assignment1`
    FOREIGN KEY (`professor_assignment_id`)
    REFERENCES `moodle`.`professor_assignment` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `moodle`.`assignment_media`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `moodle`.`assignment_media` ;

CREATE TABLE IF NOT EXISTS `moodle`.`assignment_media` (
  `id` VARCHAR(191) NOT NULL,
  `student_assignment_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP(2) NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_media_student_assignment1_idx` (`student_assignment_id` ASC)  ,
  CONSTRAINT `fk_media_student_assignment10`
    FOREIGN KEY (`student_assignment_id`)
    REFERENCES `moodle`.`student_assignment` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `moodle`.`comments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `moodle`.`comments` ;

CREATE TABLE IF NOT EXISTS `moodle`.`comments` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `comment` MEDIUMTEXT NULL DEFAULT NULL,
  `user_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP(2) NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (`id`),
  INDEX `fk_comments_users1_idx` (`user_id` ASC)  ,
  CONSTRAINT `fk_comments_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `moodle`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


-- -----------------------------------------------------
-- Table `moodle`.`posts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `moodle`.`posts` ;

CREATE TABLE IF NOT EXISTS `moodle`.`posts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `question` LONGTEXT NULL DEFAULT NULL,
  `professor_assignment_id` INT(11) NOT NULL,
  `comment_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP(2) NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_faq_users1_idx` (`user_id` ASC)  ,
  INDEX `fk_faq_professor_assignment1_idx` (`professor_assignment_id` ASC)  ,
  INDEX `fk_faq_comments1_idx` (`comment_id` ASC)  ,
  CONSTRAINT `fk_faq_comments1`
    FOREIGN KEY (`comment_id`)
    REFERENCES `moodle`.`comments` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_faq_professor_assignment1`
    FOREIGN KEY (`professor_assignment_id`)
    REFERENCES `moodle`.`professor_assignment` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_faq_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `moodle`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;


INSERT INTO roles (role_name)
VALUES ('Professor');

INSERT INTO roles (role_name)
VALUES ('Student');


-- -----------------------------------------------------
-- Table `moodle`.`posts_media`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `moodle`.`posts_media` ;

CREATE TABLE IF NOT EXISTS `moodle`.`posts_media` (
  `id` VARCHAR(191) NOT NULL,
  `posts_id` INT(11) NOT NULL,
  `created_at` TIMESTAMP(2) NULL  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `fk_posts_media_posts1_idx` (`posts_id` ASC)  ,
  CONSTRAINT `fk_posts_media_posts1`
    FOREIGN KEY (`posts_id`)
    REFERENCES `moodle`.`posts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_bin;
