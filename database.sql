-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2022 at 12:05 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Table structure for table `nova_boards`
--

CREATE TABLE `nova_boards`
(
    `id`          int(10) UNSIGNED NOT NULL,
    `name`        text             NOT NULL,
    `icon`        text             NOT NULL,
    `slug`        text             NOT NULL,
    `description` longtext         NOT NULL,
    `visibility`  int(10)          NOT NULL,
    `rules`       longtext         NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `nova_boards`
--

INSERT INTO `nova_boards` (`id`, `name`, `icon`, `slug`, `description`, `visibility`, `rules`)
VALUES (1, 'Feature Requests', 'comments', 'feature-requests', 'Help us with feedback!', 2, '[\"*@google.com\"]'),
       (2, 'Integrations', 'puzzle-piece', 'integrations',
        'Have new features you\'d like to see? Let us know and provide us with all the details.', 2,
        '[\"test.user@google.com\"]'),
       (3, 'Bug Reports', 'bug', 'bugs', '', 1, '[]'),
       (4, 'Languages', 'globe', 'languages', 'Provide us with new languages you\'re looking to be translated!', 1,
        '[]'),
       (5, 'Profiles', 'user', 'profiles', '', 1, '[]'),
       (6, 'Others', 'question', 'others', '', 1, '[]'),
       (7, 'Marketing', 'robot', 'marketing', 'fgd', 0, '[]'),
       (8, 'Community', 'smile', 'community', 'Share thank here', 1, '[]'),
       (9, 'Subscriptions', 'crown', 'subscriptions', '', 0, '[]');

-- --------------------------------------------------------

--
-- Table structure for table `nova_comments`
--

CREATE TABLE `nova_comments`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `post_id`    int(10) UNSIGNED NOT NULL,
    `user_id`    int(10) UNSIGNED NOT NULL,
    `content`    text             NOT NULL,
    `created_at` datetime         NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `nova_comments`
--

INSERT INTO `nova_comments` (`id`, `post_id`, `user_id`, `content`, `created_at`)
VALUES (1, 1, 1, 'I love this idea!', '2022-04-16 15:54:31');

-- --------------------------------------------------------

--
-- Table structure for table `nova_posts`
--

CREATE TABLE `nova_posts`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `user_id`    int(10) UNSIGNED NOT NULL,
    `title`      text             NOT NULL,
    `slug`       text             NOT NULL,
    `content`    text             NOT NULL,
    `board_id`   int(10) UNSIGNED NOT NULL,
    `status_id`  int(10) UNSIGNED          DEFAULT NULL,
    `updated_at` timestamp        NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `created_at` timestamp        NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `nova_posts`
--

INSERT INTO `nova_posts` (`id`, `user_id`, `title`, `slug`, `content`, `board_id`, `status_id`, `updated_at`,
                          `created_at`)
VALUES (1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
        'lorem-ipsum-dolor-sit-amet-consectetur-adipiscing-elit-7767',
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nisl nisi scelerisque eu ultrices vitae auctor eu augue ut. Ante metus dictum at tempor commodo ullamcorper. Facilisis volutpat est velit egestas dui id. Nec sagittis aliquam malesuada bibendum arcu vitae elementum curabitur vitae. Venenatis tellus in metus vulputate. Maecenas sed enim ut sem. Nec tincidunt praesent semper feugiat nibh. Enim nunc faucibus a pellentesque. Fermentum posuere urna nec tincidunt praesent semper feugiat nibh sed. Urna porttitor rhoncus dolor purus non enim praesent elementum. Pulvinar mattis nunc sed blandit libero volutpat. Bibendum enim facilisis gravida neque convallis a cras semper. Cursus turpis massa tincidunt dui. Vulputate odio ut enim blandit volutpat maecenas volutpat blandit. Enim sed faucibus turpis in. Maecenas pharetra convallis posuere morbi leo.',
        1, 1, '2022-04-16 20:59:00', '2022-04-16 20:54:06');

-- --------------------------------------------------------

--
-- Table structure for table `nova_settings`
--

CREATE TABLE `nova_settings`
(
    `id`      int(10) UNSIGNED NOT NULL,
    `setting` text             NOT NULL,
    `value`   longtext         NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `nova_settings`
--

INSERT INTO `nova_settings` (`id`, `setting`, `value`)
VALUES (1, 'site_title', 'Actionmarks'),
       (2, 'accent_color', '#4cbc59'),
       (3, 'feed_type', '1'),
       (4, 'site_desc', 'We\'re here to build a better experience for you.');

-- --------------------------------------------------------

--
-- Table structure for table `nova_statuses`
--

CREATE TABLE `nova_statuses`
(
    `id`    int(10) UNSIGNED NOT NULL,
    `name`  text             NOT NULL,
    `color` text             NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `nova_statuses`
--

INSERT INTO `nova_statuses` (`id`, `name`, `color`)
VALUES (1, 'In Progress', '#29bfff'),
       (2, 'Planned', '#ff0081');

-- --------------------------------------------------------

--
-- Table structure for table `nova_upvotes`
--

CREATE TABLE `nova_upvotes`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `post_id`    int(10) UNSIGNED NOT NULL,
    `user_id`    int(10) UNSIGNED NOT NULL,
    `created_at` datetime         NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `nova_upvotes`
--

INSERT INTO `nova_upvotes` (`id`, `post_id`, `user_id`, `created_at`)
VALUES (1, 1, 1, '2022-04-16 15:54:17');

-- --------------------------------------------------------

--
-- Table structure for table `nova_users`
--

CREATE TABLE `nova_users`
(
    `id`         int(10) UNSIGNED NOT NULL,
    `first_name` text             NOT NULL,
    `last_name`  text             NOT NULL,
    `username`   text             NOT NULL,
    `email`      text             NOT NULL,
    `password`   text             NOT NULL,
    `is_admin`   int(10)          NOT NULL,
    `created_at` timestamp        NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `nova_users`
--

INSERT INTO `nova_users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `is_admin`, `created_at`)
VALUES (1, 'Test', 'User', 'test', 'test@dudzik.dev', '$2y$10$YojrSIjuZ48RueJsvrlEzuHaR9pMlG1njDx0h4jeMyLuAOENPTI1a', 1,
        '2022-04-16 20:27:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nova_boards`
--
ALTER TABLE `nova_boards`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nova_comments`
--
ALTER TABLE `nova_comments`
    ADD PRIMARY KEY (`id`),
    ADD KEY `post_id` (`post_id`),
    ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `nova_posts`
--
ALTER TABLE `nova_posts`
    ADD PRIMARY KEY (`id`),
    ADD KEY `user_id` (`user_id`),
    ADD KEY `board_id` (`board_id`),
    ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `nova_settings`
--
ALTER TABLE `nova_settings`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nova_statuses`
--
ALTER TABLE `nova_statuses`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nova_upvotes`
--
ALTER TABLE `nova_upvotes`
    ADD PRIMARY KEY (`id`),
    ADD KEY `user_id` (`user_id`),
    ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `nova_users`
--
ALTER TABLE `nova_users`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nova_boards`
--
ALTER TABLE `nova_boards`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 11;

--
-- AUTO_INCREMENT for table `nova_comments`
--
ALTER TABLE `nova_comments`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `nova_posts`
--
ALTER TABLE `nova_posts`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `nova_settings`
--
ALTER TABLE `nova_settings`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT for table `nova_statuses`
--
ALTER TABLE `nova_statuses`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT for table `nova_upvotes`
--
ALTER TABLE `nova_upvotes`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT for table `nova_users`
--
ALTER TABLE `nova_users`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nova_comments`
--
ALTER TABLE `nova_comments`
    ADD CONSTRAINT `nova_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `nova_posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT `nova_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `nova_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `nova_posts`
--
ALTER TABLE `nova_posts`
    ADD CONSTRAINT `nova_posts_ibfk_1` FOREIGN KEY (`board_id`) REFERENCES `nova_boards` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT `nova_posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `nova_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT `nova_posts_ibfk_3` FOREIGN KEY (`status_id`) REFERENCES `nova_statuses` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `nova_upvotes`
--
ALTER TABLE `nova_upvotes`
    ADD CONSTRAINT `nova_upvotes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `nova_posts` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    ADD CONSTRAINT `nova_upvotes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `nova_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;
