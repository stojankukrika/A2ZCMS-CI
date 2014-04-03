
--
-- Dumping data for table `plugins`
--

INSERT INTO `plugins` (`id`, `name`,`title`, `function_id`, `function_grid`, 
`can_uninstall`, `pluginversion`,`active`,`created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'pages', 'Pages', NULL, NULL, 0, '1.0', 1, NOW(), NOW(), NULL),
(2, 'settings', 'Settings', NULL, NULL, 0, '1.0', 1, NOW(), NOW(), NULL),
(3, 'users', 'Users', NULL, NULL, 0, '1.0', 1, NOW(), NOW(), NULL),
(4, 'roles', 'Roles', NULL, NULL, 0,'1.0', 1, NOW(), NOW(), NULL),
(5, 'plugins', 'Plugins', NULL, NULL, 0, '1.0', 1, NOW(), NOW(), NULL),
(6, 'adminmenu', 'Admin menu', NULL, NULL, 0,'1.0', 1, NOW(), NOW(), NULL),
(7, 'menu', 'Website menu', NULL, NULL, 0, '1.0', 1, NOW(), NOW(), NULL);

--
-- Dumping data for table `plugin_functions`
--

INSERT INTO `plugin_functions` (`id`, `title`, `plugin_id`, `function`, `params`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Login form', 0, 'login_partial', '', 'sidebar', NOW(), NOW(), NULL),
(2, 'Search Form', 0, 'search', '', 'sidebar', NOW(), NOW(), NULL),
(3, 'Content', 0, 'content', '', 'content', NOW(), NOW(), NULL),
(4, 'Side menu', 0, 'sideMenu', '', 'sidebar', NOW(), NOW(), NULL);

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `varname`, `vartitle`, `groupname`, `value`, `defaultvalue`, `type`, `rule`) VALUES
(1, 'updatetime', 'Update time', 'version', '2014.04.03.', '2014.04.03.', 'text', ''),
(2, 'offline', 'Offline', 'offline', 'No', 'Yes;No', 'radio', ''),
(3, 'version', 'Version', 'version', '1.0', '1.0', 'text', ''),
(4, 'offlinemessage', 'OfflineMessage', 'offline', '<p>Sorry, the site is unavailable at the moment while we are testing some functionality.</p>', 'Sorry, the site is unavailable at the moment while we are testing some functionality.', 'textarea', ''),
(5, 'title', 'Title', 'general', 'A2Z CMS-dev', 'A2Z CMS', 'text', 'required'),
(6, 'copyright', 'Copyright', 'general', 'yoursite.com &copy; 2014', 'A2Z CMS 2014', 'text', 'required'),
(7, 'metadesc', 'MetaDescription', 'metadata', '', '', 'textarea', ''),
(8, 'metakey', 'MetaKeywords', 'metadata', '', '', 'textarea', ''),
(9, 'metaauthor', 'MetaAuthor', 'metadata', 'http://www.yoursite.com', 'http://www.a2zcms.com', 'text', ''),
(10, 'analytics', 'Analytics', 'analytic', '', '', 'textarea', ''),
(11, 'contactemail', 'ContactEmail', 'general', 'admin@mail.com', '', 'text', 'required|valid_email'),
(12, 'dateformat', 'DateFormat', 'general', 'd.m.Y', 'd.m.Y', 'text', 'required'),
(13, 'timeformat', 'TimeFormat', 'general', ' - H:i', 'h:i A', 'text', 'required'),
(14, 'timeago', 'ConvertToTimeAgo', 'general', 'No', 'Yes;No', 'radio', ''),
(15, 'useravatwidth', 'UserAvatarWidth', 'general', '150', '150', 'text', 'required|integer'),
(16, 'useravatheight', 'UserAvatarHeight', 'general', '113', '113', 'text', 'required|integer'),
(17, 'pageitem', 'PostsPerPage', 'general', '8', '8', 'text', 'required|integer'),
(18, 'searchcode', 'SearchCode', 'search', '', '', 'textarea', ''),
(19, 'sitetheme', 'SiteTheme', 'general', 'a2z-default', 'ASSETS_PATH_FULL', 'option', 'required'),
(20, 'pageitemadmin', 'PostsPerPageAdmin', 'general', '10', '10', 'text', 'required|integer'),
(21, 'passwordpolicy', 'PasswordPolicy', 'password', 'No', 'Yes;No', 'radio', ''),
(22, 'minpasswordlength', 'PasswordLength', 'password', '6', '6', 'text', 'integer'),
(23, 'minpassworddigits', 'Digits', 'password', '1', '1', 'text', 'integer'),
(24, 'minpasswordlower', 'LowercaseLetters', 'password', '1', '1', 'text', 'integer'),
(25, 'minpasswordupper', 'UppercaseLetters', 'password', '1', '1', 'text', 'integer'),
(26, 'usegravatar', 'UseGravatar', 'general', 'No', 'Yes;No', 'radio', '');

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `meta_title`, `meta_description`, `meta_keywords`, `page_css`, `page_javascript`, `sidebar`, `showtitle`, `showvote`, `showdate`, `voteup`, `votedown`, `password`, `tags`, `hits`, `showtags`, `content`, `image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Home', 'home', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0, 0, '', 'tag1', 0, 1, '<div><h1>A2Z CMS 1.0</h1><p>Welcome to your very own A2Z CMS 1.0 installation.</p></div><div><p>Login into your profile and change this page and enjoy in A2ZCMS.</p><p>If you have any questions feel free to check the <a href="https://github.com/mrakodol/A2ZCMS-CI/issues">Issues</a> at any time or create a new issue.</p><p>Enjoy A2Z CMS and welcome a board.</p><p>Kind Regards</p><p>Stojan Kukrika - A2Z CMS</p></div>', NULL, 1, NOW(), NOW(), NULL);


--
-- Dumping data for table `page_plugin_functions`
--

INSERT INTO `page_plugin_functions` (`id`, `page_id`, `plugin_function_id`, `order`, `param`, `type`, `value`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, '', '', '', NOW(), NOW(), NULL),
(2, 1, 3, 1, '', '', '', NOW(), NOW(), NULL);


--
-- Dumping data for table `navigation_groups`
--

INSERT INTO `navigation_groups` (`id`, `title`, `slug`, `showmenu`, `showfooter`, `showsidebar`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Main menu', 'main-menu', 1, 0, 0, NOW(), NOW(), NULL);


--
-- Dumping data for table `navigation_links`
--

INSERT INTO `navigation_links` (`id`, `title`, `parent`, `link_type`, `page_id`, `url`, `uri`, `navigation_group_id`, `position`, `target`, `restricted_to`, `class`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Home', NULL, 'page', 1, '', '', 1, 1, '', '', '', NOW(), NOW(), NULL);

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `is_admin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'manage_users', 'Manage users', 1, NOW(), NOW(), NULL),
(2, 'manage_roles', 'Manage roles', 1, NOW(), NOW(), NULL),
(3, 'manage_navigation', 'Manage navigation', 1, NOW(), NOW(), NULL),
(4, 'manage_pages', 'Manage pages', 1, NOW(), NOW(), NULL),
(5, 'manage_navigation_groups', 'Manage navigation groups', 1, NOW(), NOW(), NULL),
(6, 'manage_settings', 'Manage settings', 1, NOW(), NOW(), NULL),
(7, 'manage_plugins', 'Manage plugins', 1, NOW(), NOW(), NULL);

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `is_admin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Administrator', 1, NOW(), NOW(), NULL);

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NOW(), NOW(), NULL),
(2, 2, 1, NOW(), NOW(), NULL),
(3, 3, 1, NOW(), NOW(), NULL),
(4, 4, 1, NOW(), NOW(), NULL),
(5, 5, 1, NOW(), NOW(), NULL),
(6, 6, 1, NOW(), NOW(), NULL),
(7, 7, 1, NOW(), NOW(), NULL);

--
-- Dumping data for table `assigned_roles`
--

INSERT INTO `assigned_roles` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NOW(), NOW(), NULL);

--
-- Dumping data for table `admin_navigations`
--

INSERT INTO `admin_navigations` (`id`, `plugin_id`, `icon`, `background_color`,`order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'icon-globe','red',  1, NOW(), NOW(), NULL),
(2, 3, 'icon-user','yellow',  2, NOW(), NOW(), NULL),
(3, 4, 'icon-group','green',  3, NOW(), NOW(), NULL),
(4, 5, 'icon-cloud','blue',  4, NOW(), NOW(), NULL),
(5, 2, 'icon-cogs', 'orange', 5, NOW(), NOW(), NULL);

--
-- Dumping data for table `admin_subnavigations`
--

INSERT INTO `admin_subnavigations` (`id`, `admin_navigation_id`, `title`, `url`, `icon`, `order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Navigation group', 'pages/navigationgroups', 'icon-th-list', 1, NOW(), NOW(), NULL),
(2, 1, 'Pages', 'pages', 'icon-th-large', 2, NOW(), NOW(), NULL),
(3, 1, 'Navigation', 'pages/navigation', 'icon-th', 3, NOW(), NOW(), NULL);