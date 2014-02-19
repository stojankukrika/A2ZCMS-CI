
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
(7, 'home', 'Website home', NULL, NULL, 0, '1.0', 1, NOW(), NOW(), NULL),
(8, 'menu', 'Website menu', NULL, NULL, 0, '1.0', 1, NOW(), NOW(), NULL);

--
-- Dumping data for table `plugin_functions`
--

INSERT INTO `plugin_functions` (`id`, `title`, `plugin_id`, `function`, `params`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Login form', 0, 'login', '', 'sidebar', NOW(), NOW(), NULL),
(2, 'Search Form', 0, 'search', '', 'sidebar', NOW(), NOW(), NULL),
(3, 'Content', 0, 'content', '', 'content', NOW(), NOW(), NULL),
(4, 'Side menu', 0, 'sideMenu', '', 'sidebar', NOW(), NOW(), NULL);

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `varname`, `vartitle`, `groupname`, `value`, `defaultvalue`, `type`, `rule`) VALUES
(1, 'updatetime', 'Update time', 'version', '1389785102', '1389785102', 'text', ''),
(2, 'offline', 'Offline', 'offline', 'No', 'Yes;No', 'radio', ''),
(3, 'version', 'Version', 'version', '1.0', '1.0', 'text', ''),
(4, 'offlinemessage', 'Offline message', 'offline', '<p>Sorry, the site is unavailable at the moment while we are testing some functionality.</p>', 'Sorry, the site is unavailable at the moment while we are testing some functionality.', 'textarea', ''),
(5, 'title', 'Title', 'general', 'A2Z CMS-dev', 'A2Z CMS', 'text', 'required'),
(6, 'copyright', 'Copyright', 'general', 'yoursite.com &copy; 2014', 'A2Z CMS 20134', 'text', 'required'),
(7, 'metadesc', 'Meta desc', 'metadata', '', '', 'textarea', ''),
(8, 'metakey', 'Meta key', 'metadata', '', '', 'textarea', ''),
(9, 'metaauthor', 'Meta author', 'metadata', 'http://www.yoursite.com', 'http://www.a2zcms.com', 'text', ''),
(10, 'analytics', 'Analytics', 'analitic', '', '', 'textarea', ''),
(11, 'email', 'Email', 'general', 'admin@mail.com', '', 'text', 'required|valid_email'),
(12, 'dateformat', 'Date format', 'general', 'd.m.Y', 'd.m.Y', 'text', 'required'),
(13, 'timeformat', 'Time format', 'general', ' - H:i', 'h:i A', 'text', 'required'),
(14, 'useravatwidth', 'User avatar width', 'general', '150', '150', 'text', 'required|integer'),
(15, 'useravatheight', 'User avatar height', 'general', '113', '113', 'text', 'required|integer'),
(16, 'pageitem', 'Per page item', 'general', '8', '8', 'text', 'required|integer'),
(17, 'searchcode', 'Search code', 'search', '', '', 'textarea', ''),
(18, 'sitetheme', 'Site theme', 'general', 'a2z-default', 'ASSETS_PATH_FULL', 'option', 'required'),
(19, 'pageitemadmin', 'Per page item-Admin', 'general', '10', '10', 'text', 'required|integer'),
(20, 'passwordpolicy', 'Password policy', 'password', 'No', 'Yes;No', 'radio', ''),
(21, 'minpasswordlength', 'Password length', 'password', '6', '6', 'text', 'integer'),
(22, 'minpassworddigits', 'Digits', 'password', '1', '1', 'text', 'integer'),
(23, 'minpasswordlower', 'Lowercase letters', 'password', '1', '1', 'text', 'integer'),
(24, 'minpasswordupper', 'Uppercase letters', 'password', '1', '1', 'text', 'integer'),
(25, 'minpasswordnonalphanum', 'Non-alphanumeric characters', 'password', '1', '1', 'text', 'integer');


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
(5, 'manage_navigation_groups', 'Manage navigation groups', 1, NOW(), NOW(), NULL);

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `is_admin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 1, NOW(), NOW(), NULL);

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NOW(), NOW(), NULL),
(2, 2, 1, NOW(), NOW(), NULL),
(3, 3, 1, NOW(), NOW(), NULL),
(4, 4, 1, NOW(), NOW(), NULL),
(5, 5, 1, NOW(), NOW(), NULL);

--
-- Dumping data for table `assigned_roles`
--

INSERT INTO `assigned_roles` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NOW(), NOW(), NULL);

--
-- Dumping data for table `admin_navigations`
--

INSERT INTO `admin_navigations` (`id`, `plugin_id`, `icon`, `order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'icon-globe', 1, NOW(), NOW(), NULL),
(2, 3, 'icon-user', 2, NOW(), NOW(), NULL),
(3, 4, 'icon-group', 3, NOW(), NOW(), NULL),
(4, 5, 'icon-cloud', 4, NOW(), NOW(), NULL),
(5, 2, 'icon-cogs', 5, NOW(), NOW(), NULL);
