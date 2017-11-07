CREATE TABLE `flg_agenda` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime DEFAULT NULL,
  `description` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `flg_agendaCategory` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `flg_album` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` int(11) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `private` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `flg_albumCategory` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `flg_download` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('report','newsletter') NOT NULL DEFAULT 'report',
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `flg_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `flg_menu` (
  `id` int(11) NOT NULL,
  `parentId` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `type` enum('page','album','calender','group','download','url') NOT NULL,
  `value` varchar(255) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `flg_news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `published` datetime NOT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `flg_page` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `header` varchar(255) NOT NULL,
  `isHomepage` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `flg_permission` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `flg_picture` (
  `id` int(11) NOT NULL,
  `albumId` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `flg_role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `flg_rolePermission` (
  `id` int(11) NOT NULL,
  `roleId` int(11) NOT NULL,
  `permissionId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `flg_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `flg_userRole` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `roleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ADD INDEXES

ALTER TABLE `flg_agenda`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flg_agendaCategory`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flg_album`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flg_albumCategory`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flg_download`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flg_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `flg_menu`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flg_news`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flg_page`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flg_permission`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flg_picture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `albumId` (`albumId`);

ALTER TABLE `flg_role`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flg_rolePermission`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flg_settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `flg_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `flg_userRole`
  ADD PRIMARY KEY (`id`);

-- ADD AUTO_INCREMENTS

ALTER TABLE `flg_agenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_agendaCategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_albumCategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_download`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_rolePermission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `flg_userRole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;