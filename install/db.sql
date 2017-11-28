CREATE TABLE IF NOT EXISTS `agenda` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime DEFAULT NULL,
  `description` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `agendaCategory` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` int(11) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `private` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `albumCategory` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `download` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('report','newsletter') NOT NULL DEFAULT 'report',
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL,
  `parentId` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `type` enum('page','album','calender','group','download','url') NOT NULL,
  `value` varchar(255) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `published` datetime NOT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `header` varchar(255) NOT NULL,
  `isHomepage` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `picture` (
  `id` int(11) NOT NULL,
  `albumId` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `rolePermission` (
  `id` int(11) NOT NULL,
  `roleId` int(11) NOT NULL,
  `permissionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `userRole` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `roleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ADD INDEXES

ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `agendaCategory`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `albumCategory`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `download`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `albumId` (`albumId`);

ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rolePermission`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `userRole`
  ADD PRIMARY KEY (`id`);

-- ADD AUTO_INCREMENTS

ALTER TABLE `agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `agendaCategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `albumCategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `download`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `rolePermission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `userRole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;