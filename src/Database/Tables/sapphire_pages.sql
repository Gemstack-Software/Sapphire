CREATE TABLE `sapphire_pages` ( `id` INT NOT NULL AUTO_INCREMENT , `parent_id` INT NOT NULL , `name` TEXT NOT NULL , `subname` TEXT NOT NULL , `content` TEXT NOT NULL , `url` TEXT NOT NULL , `layout` TEXT NOT NULL , `is_home` INT NOT NULL , `created_at` TEXT NOT NULL , `created_by` INT NOT NULL , `updated_at` TEXT NOT NULL , `updated_by` INT NOT NULL , PRIMARY KEY (`id`))