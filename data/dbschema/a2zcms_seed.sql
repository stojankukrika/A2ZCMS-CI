
--
-- Dumping data for table `plugins`
--

INSERT INTO `plugins` (`id`, `content`, `function_id`, `function_grid`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Blog', 'getBlogId', 'getBlogGroupId', NOW(), NOW(), NULL),
(2, 'Gallery', 'getGalleryId', NULL, NOW(), NOW(), NULL),
(3, 'Custom form', 'getCustomFormId', NULL, NOW(), NOW(), NULL),
(4, 'To-do list', NULL, NULL, NOW(), NOW(), NULL),
(5, 'Pages', NULL, NULL, NOW(), NOW(), NULL),
(6, 'Settings', NULL, NULL, NOW(), NOW(), NULL),
(7, 'Users', NULL, NULL, NOW(), NOW(), NULL);
--
-- Dumping data for table `plugin_functions`
--

INSERT INTO `plugin_functions` (`id`, `title`, `plugin_id`, `function`, `params`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Login form', 0, 'login', '', 'sidebar', NOW(), NOW(), NULL),
(2, 'Search Form', 0, 'search', '', 'sidebar', NOW(), NOW(), NULL),
(3, 'New gallerys', 2, 'newGallerys', 'sort:asc;order:id;limit:5;', 'sidebar', NOW(), NOW(), NULL),
(4, 'New blogs', 1, 'newBlogs', 'sort:asc;order:id;limit:5;', 'sidebar', NOW(), NOW(), NULL),
(5, 'Content', 0, 'content', '', 'content', NOW(), NOW(), NULL),
(6, 'Display gallery', 2, 'showGallery', 'id;sort;order;limit;', 'content', NOW(), NOW(), NULL),
(7, 'Display blogs', 1, 'showBlogs', 'id;sort;order;limit;', 'content', NOW(), NOW(), NULL),
(8, 'Display custom form', 3, 'showCustomFormId', 'id;', 'content', NOW(), NOW(), NULL),
(9, 'Side menu', 0, 'sideMenu', '', 'sidebar', NOW(), NOW(), NULL);

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `varname`, `vartitle`, `groupname`, `value`, `defaultvalue`,`type`,`rule`) VALUES
(1, 'updatetime','Update time', 'version', '1389785102', '1389785102','text',''),
(2, 'offline', 'Offline', 'offline', 'No', 'Yes;No','radio',''),
(3, 'version', 'Version', 'version', '1.0', '1.0','text',''),
(4, 'offlinemessage', 'Offline message', 'offline', '<p>Sorry, the site is unavailable at the moment while we are testing some functionality.</p>', 'Sorry, the site is unavailable at the moment while we are testing some functionality.','textarea',''),
(5, 'title', 'Title', 'general', 'A2Z CMS', 'A2Z CMS','text','required'),
(6, 'copyright', 'Copyright', 'general', 'yoursite.com &copy; 2013', 'A2Z CMS 2013','text','required'),
(7, 'metadesc', 'Meta desc', 'metadata', '', '','textarea',''),
(8, 'metakey', 'Meta key', 'metadata', '', '','textarea',''),
(9, 'metaauthor', 'Meta author', 'metadata', 'http://www.yoursite.com', 'http://www.a2zcms.com','text',''),
(10, 'analytics', 'Analytics', 'analitic', '', '','textarea',''),
(11, 'email', 'Email', 'settings', 'admin@mail.com', '','text','required|valid_email'),
(12, 'dateformat', 'Date format', 'settings', 'd.m.Y', 'd.m.Y','text','required'),
(13, 'timeformat', 'Time format', 'settings', ' - H:i', 'h:i A','text','required'),
(14, 'useravatwidth', 'User avatar width', 'settings', '150', '150','text','required|integer'),
(15, 'useravatheight', 'User avatar height', 'settings', '113', '113','text','required|integer'),
(16, 'pageitem', 'Per page item', 'settings', '8', '8','text','required|integer'),
(17, 'searchcode', 'Search code', 'search', '', '','textarea',''),
(18, 'sitetheme', 'Site theme', 'settings', '', 'ASSETS_PATH_FULL','option','required'),
(19, 'pageitemadmin','Per page item-Admin', 'settings', '10', '10','text','required|integer');

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2013_02_05_024934_confide_setup_users_table', 1),
('2013_02_08_031702_entrust_setup_tables', 1),
('2013_05_21_024934_entrust_permissions', 1),
('2013_09_30_010232_create_blog_categories_table', 1),
('2013_09_30_043505_create_blogs_table', 1),
('2013_09_30_044505_create_blog_comments_table', 1),
('2013_10_10_090639_create_settings_table', 1),
('2013_10_16_052712_create_pages_table', 1),
('2013_10_16_162713_create_navigation_table', 1),
('2013_10_17_135949_create_gallery_table', 1),
('2013_10_17_142524_create_gallery_images_table', 1),
('2013_10_17_142615_create_gallery_images_comments_table', 1),
('2013_10_23_153357_create_todolist_table', 1),
('2013_10_24_081325_create_plugins_table', 1),
('2013_10_24_081555_create_tags_table', 1),
('2013_10_30_084015_add_metadata_to_pages', 1),
('2013_10_30_135348_add_show_in_footer_and_header_blogs', 1),
('2013_10_31_062801_create_messages_table', 1),
('2013_10_31_081145_add_finished_to_todolist_table', 1),
('2013_11_06_154522_add_deleted_at_into_pages', 1),
('2013_11_06_182351_create_pluginfunctions_table', 1),
('2013_11_08_151733_pivot_page_plugin_functions_table', 1),
('2013_11_13_120738_create_custom_form_table', 1),
('2013_11_13_120910_create_custom_form_fields_table', 1),
('2013_11_20_122919_add_avatar_into_users', 1),
('2013_11_22_185550_pivot_blog_blog_category_table', 1),
('2013_11_27_143419_add_is_admin_into_roles', 1),
('2013_11_29_122310_create_content_votes_table', 1),
('2013_12_02_103419_add_last_login_into_users', 1),
('2013_12_02_105010_create_user_login_historys_table', 1),
('2013_02_05_024934_confide_setup_users_table', 1),
('2013_02_08_031702_entrust_setup_tables', 1),
('2013_05_21_024934_entrust_permissions', 1),
('2013_09_30_010232_create_blog_categories_table', 1),
('2013_09_30_043505_create_blogs_table', 1),
('2013_09_30_044505_create_blog_comments_table', 1),
('2013_10_10_090639_create_settings_table', 1),
('2013_10_16_052712_create_pages_table', 1),
('2013_10_16_162713_create_navigation_table', 1),
('2013_10_17_135949_create_gallery_table', 1),
('2013_10_17_142524_create_gallery_images_table', 1),
('2013_10_17_142615_create_gallery_images_comments_table', 1),
('2013_10_23_153357_create_todolist_table', 1),
('2013_10_24_081325_create_plugins_table', 1),
('2013_10_24_081555_create_tags_table', 1),
('2013_10_30_084015_add_metadata_to_pages', 1),
('2013_10_30_135348_add_show_in_footer_and_header_blogs', 1),
('2013_10_31_062801_create_messages_table', 1),
('2013_10_31_081145_add_finished_to_todolist_table', 1),
('2013_11_06_154522_add_deleted_at_into_pages', 1),
('2013_11_06_182351_create_pluginfunctions_table', 1),
('2013_11_08_151733_pivot_page_plugin_functions_table', 1),
('2013_11_13_120738_create_custom_form_table', 1),
('2013_11_13_120910_create_custom_form_fields_table', 1),
('2013_11_20_122919_add_avatar_into_users', 1),
('2013_11_22_185550_pivot_blog_blog_category_table', 1),
('2013_11_27_143419_add_is_admin_into_roles', 1),
('2013_11_29_122310_create_content_votes_table', 1),
('2013_12_02_103419_add_last_login_into_users', 1),
('2013_12_02_105010_create_user_login_historys_table', 1),
('2014_01_29_085350_create_admin_navigations_table',1),
('2014_01_29_090312_create_admin_subnavigations_table',1);


--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `meta_title`, `meta_description`, `meta_keywords`, `page_css`, `page_javascript`, `sidebar`, `showtitle`, `showvote`, `showdate`, `voteup`, `votedown`, `password`, `tags`, `hits`, `showtags`, `content`, `image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Home', 'home', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, 0, 0, '', 'tag1', 0, 1, '<div><h1>A2Z CMS 1.0</h1><p>Welcome to your very own A2Z CMS 1.1 installation.</p></div><div><p>Login into your profile and change this page and enjoy in A2ZCMS.</p><p>If you have any questions feel free to check the <a href="https://github.com/mrakodol/A2ZCMS/issues">Issues</a> at any time or create a new issue.</p><p>Enjoy A2Z CMS and welcome a board.</p><p>Kind Regards</p><p>Stojan Kukrika - A2Z CMS</p></div>', NULL, 1, NOW(), NOW(), NULL);


--
-- Dumping data for table `page_plugin_functions`
--

INSERT INTO `page_plugin_functions` (`id`, `page_id`, `plugin_function_id`, `order`, `param`, `type`, `value`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 1, '', '', '', NOW(), NOW(), NULL),
(2, 1, 5, 1, '', '', '', NOW(), NOW(), NULL);


--
-- Dumping data for table `navigation_groups`
--

INSERT INTO `navigation_groups` (`id`, `title`, `abbrev`, `showmenu`, `showfooter`, `showsidebar`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Main menu', 'main-menu', 1, 0, 0, NOW(), NOW(), NULL);


--
-- Dumping data for table `navigation_links`
--

INSERT INTO `navigation_links` (`id`, `title`, `parent`, `link_type`, `page_id`, `url`, `uri`, `navigation_group_id`, `position`, `target`, `restricted_to`, `class`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Home', NULL, 'page', 1, '', '', 1, 1, '', '', '', NOW(), NOW(), NULL);



--
-- Dumping data for table `custom_forms`
--

INSERT INTO `custom_forms` (`id`, `user_id`, `title`, `recievers`, `message`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Standard contact form', 'admin@mail.com', '<p>Thank you for contact us, we will get back to you as soon as we can.</p>', NOW(), NOW(), NULL);

--
-- Dumping data for table `custom_form_fields`
--

INSERT INTO `custom_form_fields` (`id`, `custom_form_id`, `user_id`, `name`, `options`, `type`, `order`, `mandatory`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Name', '', 1, 1, 1, NOW(), NOW(), NULL),
(2, 1, 1, 'Email', '', 1, 2, 4, NOW(), NOW(), NULL),
(3, 1, 1, 'Phone', '', 1, 3, 2, NOW(), NOW(), NULL),
(4, 1, 1, 'Message', '', 2, 4, 1, NOW(), NOW(), NULL);

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `is_admin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'manage_blogs', 'Manage blogs', 1, NOW(), NOW(), NULL),
(2, 'manage_blog_categris', 'Manage blog categris', 1, NOW(), NOW(), NULL),
(3, 'manage_comments', 'Manage comments', 1, NOW(), NOW(), NULL),
(4, 'manage_users', 'Manage users', 1, NOW(), NOW(), NULL),
(5, 'manage_roles', 'Manage roles', 1, NOW(), NOW(), NULL),
(6, 'post_blog_comment', 'Post blog comment', 0, NOW(), NOW(), NULL),
(7, 'manage_navigation', 'Manage navigation', 1, NOW(), NOW(), NULL),
(8, 'manage_pages', 'Manage pages', 1, NOW(), NOW(), NULL),
(9, 'manage_navigation_groups', 'Manage navigation groups', 1, NOW(), NOW(), NULL),
(10, 'manage_galleries', 'Manage galleries', 1, NOW(), NOW(), NULL),
(11, 'manage_gallery_images', 'Manage gallery images', 1, NOW(), NOW(), NULL),
(12, 'manage_gallery_imagecomments', 'Manage gallery image comments', 1, NOW(), NOW(), NULL),
(13, 'post_gallery_comment', 'Post gallery comment', 0, NOW(), NOW(), NULL),
(14, 'manage_customform', 'Manage custom forms', 1, NOW(), NOW(), NULL),
(15, 'manage_settings', 'Manage settings', 1, NOW(), NOW(), NULL),
(16, 'manage_todolists', 'Manage todolists', 1, NOW(), NOW(), NULL),
(17, 'post_page_vote', 'Post page vote', 0, NOW(), NOW(), NULL),
(18, 'post_blog_vote', 'Post blog vote', 0, NOW(), NOW(), NULL),
(19, 'post_image_vote', 'Post image vote', 0, NOW(), NOW(), NULL);


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
(5, 5, 1, NOW(), NOW(), NULL),
(6, 6, 1, NOW(), NOW(), NULL),
(7, 7, 1, NOW(), NOW(), NULL),
(8, 8, 1, NOW(), NOW(), NULL),
(9, 9, 1, NOW(), NOW(), NULL),
(10, 10, 1, NOW(), NOW(), NULL),
(11, 11, 1, NOW(), NOW(), NULL),
(12, 12, 1, NOW(), NOW(), NULL),
(13, 13, 1, NOW(), NOW(), NULL),
(14, 14, 1, NOW(), NOW(), NULL),
(15, 15, 1, NOW(), NOW(), NULL),
(16, 16, 1, NOW(), NOW(), NULL),
(17, 17, 1, NOW(), NOW(), NULL),
(18, 18, 1, NOW(), NOW(), NULL),
(19, 19, 1, NOW(), NOW(), NULL);

--
-- Dumping data for table `assigned_roles`
--

INSERT INTO `assigned_roles` (`id`, `user_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, NOW(), NOW(), NULL);

--
-- Dumping data for table `admin_navigations`
--

INSERT INTO `admin_navigations` (`id`, `plugin_id`, `title`, `url`, `icon`, `order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 4, 'To-do list', 'todolist', 'icon-bell', 1, NOW(), NOW(), NULL),
(2, 3, 'Custom forms', 'customforms', 'icon-list-alt', 2, NOW(), NOW(), NULL),
(3, 5, 'Pages', 'pages', 'icon-globe', 3, NOW(), NOW(), NULL),
(4, 1, 'Blog', 'blogs', 'icon-external-link', 4, NOW(), NOW(), NULL),
(5, 2, 'Gallery', 'galleries', 'icon-camera', 5, NOW(), NOW(), NULL),
(6, 7, 'Users', 'users', 'icon-group', 6, NOW(), NOW(), NULL),
(7, 6, 'Settings', 'settings', 'icon-cogs', 7, NOW(), NOW(), NULL);

--
-- Dumping data for table `admin_subnavigations`
--

INSERT INTO `admin_subnavigations` (`id`, `admin_navigation_id`, `title`, `url`, `icon`, `order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'Navigation group', 'pages/navigationgroups', 'icon-th-list', 1, NOW(), NOW(), NULL),
(2, 3, 'Pages', 'pages', 'icon-th-large', 2, NOW(), NOW(), NULL),
(3, 3, 'Navigation', 'pages/navigation', 'icon-th', 3, NOW(), NOW(), NULL),
(4, 4, 'Blog categorys', 'blogs/blogcategorys', 'icon-rss', 1, NOW(), NOW(), NULL),
(5, 4, 'Blog', 'blogs', 'icon-book', 2, NOW(), NOW(), NULL),
(6, 4, 'Blog comments', 'blogs/blogcomments', 'icon-comment-alt', 3, NOW(), NOW(), NULL),
(7, 5, 'Gallery images', 'galleries/galleryimages', 'icon-rss', 1, NOW(), NOW(), NULL),
(8, 5, 'Galleries', 'galleries', 'icon-camera-retro', 2, NOW(), NOW(), NULL),
(9, 5, 'Gallery comments', 'galleries/galleryimagecomments', 'icon-comments-alt', 3, NOW(), NOW(), NULL),
(10, 6, 'Users', 'users', 'icon-user', 1, NOW(), NOW(), NULL),
(11, 6, 'Roles', 'roles', 'icon-user-md', 2, NOW(), NOW(), NULL);
