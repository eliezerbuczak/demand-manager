SET
foreign_key_checks = 0;

-- Drop tables if they exist
DROP TABLE IF EXISTS demand_user;
DROP TABLE IF EXISTS demands;
DROP TABLE IF EXISTS statuses;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS profiles;

-- Create profiles table
CREATE TABLE `profiles`
(
  `id`               int AUTO_INCREMENT PRIMARY KEY,
  `name`             varchar(45) NOT NULL UNIQUE,
  `create_demand`    bool        NOT NULL,
  `edit_demand`      bool        NOT NULL,
  `delete_demand`    bool        NOT NULL,
  `show_all_demands` bool        NOT NULL,
  `id_user_created`  int         NOT NULL,
  `id_user_updated`  int,
  `id_user_deleted`  int,
  `created_at`       datetime    NOT NULL,
  `updated_at`       datetime,
  `deleted_at`       datetime,
  FOREIGN KEY (`id_user_created`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`id_user_updated`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`id_user_deleted`) REFERENCES `users`(`id`) ON DELETE RESTRICT
);

-- Create users table
CREATE TABLE `users`
(
  `id`                 int AUTO_INCREMENT PRIMARY KEY,
  `name`               VARCHAR(255)       NOT NULL,
  `email`              VARCHAR(50) UNIQUE NOT NULL,
  `encrypted_password` varchar(255)       NOT NULL,
  `profile_id`         int,
  `created_at`         datetime           NOT NULL,
  `updated_at`         datetime,
  `deleted_at`         datetime,
  FOREIGN KEY (`profile_id`) REFERENCES `profiles`(`id`) ON DELETE RESTRICT
);

-- Create statuses table
CREATE TABLE `statuses`
(
  `id`              int AUTO_INCREMENT PRIMARY KEY,
  `name`            varchar(45),
  `id_user_created` int,
  `id_user_updated` int,
  `id_user_deleted` int,
  `created_at`      datetime NOT NULL,
  `updated_at`      datetime,
  `deleted_at`      datetime,
  FOREIGN KEY (`id_user_created`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`id_user_updated`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`id_user_deleted`) REFERENCES `users`(`id`) ON DELETE RESTRICT
);

-- Create demands table
CREATE TABLE `demands`
(
  `id`              int AUTO_INCREMENT PRIMARY KEY,
  `title`           varchar(45) NOT NULL,
  `expected_date`   date        NOT NULL,
  `path_image`      varchar(255),
  `description`     varchar(255),
  `status_id`       int         NOT NULL,
  `id_user_created` int         NOT NULL,
  `id_user_updated` int,
  `id_user_deleted` int,
  `created_at`      datetime    NOT NULL,
  `updated_at`      datetime,
  `deleted_at`      datetime,
  FOREIGN KEY (`status_id`) REFERENCES `statuses`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`id_user_created`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`id_user_updated`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`id_user_deleted`) REFERENCES `users`(`id`) ON DELETE RESTRICT
);

-- Create demand_user table
CREATE TABLE `demand_user`
(
  `id`              int AUTO_INCREMENT PRIMARY KEY,
  `demand_id`       int      NOT NULL,
  `user_id`         int      NOT NULL,
  `status_id`       int      NOT NULL,
  `id_user_created` int      NOT NULL,
  `id_user_updated` int,
  `id_user_deleted` int,
  `created_at`      datetime NOT NULL,
  `updated_at`      datetime,
  `deleted_at`      datetime,
  FOREIGN KEY (`demand_id`) REFERENCES `demands`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`status_id`) REFERENCES `statuses`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`id_user_created`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`id_user_updated`) REFERENCES `users`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`id_user_deleted`) REFERENCES `users`(`id`) ON DELETE RESTRICT
);

SET
foreign_key_checks = 1;
