SET foreign_key_checks = 0;

-- Drop tables if they exist
DROP TABLE IF EXISTS demand_user;
DROP TABLE IF EXISTS demands;
DROP TABLE IF EXISTS statuses;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS profiles;

-- Create profiles table
CREATE TABLE `profiles` (
                          `id` int AUTO_INCREMENT PRIMARY KEY,
                          `name` varchar(45),
                          `create_demand` bool,
                          `edit_demand` bool,
                          `delete_demand` bool,
                          `show_all_demands` bool,
                          `id_user_created` int NOT NULL REFERENCES `users`(`id`),
                          `id_user_updated` int REFERENCES `users`(`id`),
                          `id_user_deleted` int REFERENCES `users`(`id`),
                          `created_at` datetime NOT NULL,
                          `updated_at` datetime,
                          `deleted_at` datetime
);

-- Create users table
CREATE TABLE `users` (
                       `id` int AUTO_INCREMENT PRIMARY KEY,
                       `name` VARCHAR(255) NOT NULL,
                       `email` VARCHAR(50) UNIQUE NOT NULL,
                       `encrypted_password` varchar(255) NOT NULL,
                       `profile_id` int NULL REFERENCES `profiles`(`id`) ON DELETE RESTRICT,
                       `created_at` datetime NOT NULL,
                       `updated_at` datetime,
                       `deleted_at` datetime
);

-- Create statuses table
CREATE TABLE `statuses` (
                          `id` int AUTO_INCREMENT PRIMARY KEY,
                          `name` varchar(45),
                          `id_user_created` int NOT NULL REFERENCES `users`(`id`),
                          `id_user_updated` int REFERENCES `users`(`id`),
                          `id_user_deleted` int REFERENCES `users`(`id`),
                          `created_at` datetime NOT NULL,
                          `updated_at` datetime,
                          `deleted_at` datetime
);

-- Create demands table
CREATE TABLE `demands` (
                         `id` int AUTO_INCREMENT PRIMARY KEY,
                         `title` varchar(45) NOT NULL,
                         `expected_date` date NOT NULL,
                         `path_image` varchar(255),
                         `description` varchar(255),
                         `status_id` int NOT NULL REFERENCES `statuses`(`id`) ON DELETE SET NULL,
                         `id_user_created` int NOT NULL REFERENCES `users`(`id`),
                         `id_user_updated` int REFERENCES `users`(`id`),
                         `id_user_deleted` int REFERENCES `users`(`id`),
                         `created_at` datetime NOT NULL,
                         `updated_at` datetime,
                         `deleted_at` datetime
);

-- Create demand_user table
CREATE TABLE `demand_user` (
                             `id` int AUTO_INCREMENT PRIMARY KEY,
                             `demand_id` int NOT NULL REFERENCES `demands`(`id`) ON DELETE CASCADE,
                             `user_id` int NOT NULL REFERENCES `users`(`id`) ON DELETE CASCADE,
                             `status_id` int NOT NULL REFERENCES `statuses`(`id`) ON DELETE SET NULL,
                             `id_user_created` int NOT NULL REFERENCES `users`(`id`),
                             `id_user_updated` int REFERENCES `users`(`id`),
                             `id_user_deleted` int REFERENCES `users`(`id`),
                             `created_at` datetime NOT NULL,
                             `updated_at` datetime,
                             `deleted_at` datetime
);

SET foreign_key_checks = 1;
