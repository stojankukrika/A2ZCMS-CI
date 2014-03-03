# A2ZCMS - CI
![logo](http://i44.tinypic.com/igi5uq.jpg)

======
<!-- DONATE/ -->
[![Gittip donate button](http://img.shields.io/gittip/mrakodol.png)](https://www.gittip.com/mrakodol/ "Donate weekly to this project using Gittip")
[![Flattr donate button](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=mrakodol&url=https%3A%2F%2Fgithub.com%2Fmrakodol%2FA2ZCMS)
[![BitCoin donate button](http://img.shields.io/bitcoin/donate.png?color=yellow)](https://coinbase.com/checkouts/4d0769619eaebde35c378920a895596e "Donate once-off to this project using BitCoin")
<!-- /DONATE -->
<!-- /DONATE -->
======
## A2Z CMS based on Laravel 4.1
* [A2Z CMS Features](#feature1)
* [Requirements](#feature2)
* [How to install](#feature3)
* [Application Structure](#feature4)
* [License](#feature5)
* [How CMS is look like](#feature6)

<a name="feature1"></a>
## A2Z CMS Features:
* Codeigniter 2.1.4
* Twitter Bootstrap 3.0.0
* Back-end
	* Automatic install and settup website.
	* User and Role management.
	* View user login history.
	* Manage blog posts and comments.
	* Manage gallery pictures and comments.
	* Manage custom forms.
	* Manage pages aranged into cateogry and possition.
	* Manage to-do list.
    * DataTables dynamic table sorting and filtering.
    * Colorbox Lightbox jQuery modal popup.
    * Add Summernote WYSIWYG in textareas.
    * soon will be more...
* Front-end
	* User login, registration, forgot password
	* Blog,Gallery,Messages and more functionality
	* Voting content(Blog,Gallery,Page) and voting comments
	* Custom themes
	* User can use avatar
	* Add Summernote WYSIWYG in textareas
	* soon will be more...
	
-----
<a name="feature2"></a>
##Requirements

	PHP version 5.1.6 or newer.
  A Database is required for most web application programming. Current supported databases are MySQL (4.1+), MySQLi, MS SQL, Postgres, Oracle, SQLite, and ODBC.


-----
<a name="feature3"></a>
##How to install:
* [Step 1: Get the code](#step1)
* [Step 2: Install CMS](#step2)
* [Step 3: Start Page](#step3)

-----
<a name="step1"></a>
### Step 1: Get the code
#### Option 1: Git Clone

	git clone git://github.com/mrakodol/A2ZCMS-CI.git a2zcms

#### Option 2: Download the repository

    https://github.com/mrakodol/A2ZCMS-CI/archive/master.zip

-----
<a name="step2"></a>
### Step 2: Install CMS

Now that you have the environment configured, you need to create a database configuration for it. 
Create database on your phpMyAdmin to CMS can use it.
If you install A2ZCMS on your localhost in folder a2zcms, you can type on web browser: 
	http://localhost/a2zcms/install
And than finish the installation. Instalation would populate a database with tables and start-up data(you can delete that data later).

<a name="step3"></a>
### Step 3: Start Page

####Admin login
You can login to admin part of A2ZCMS:

    username: username_from_install_proces
    password: password_from_install_proces


-----
<a name="feature4"></a>
## Application Structure

The structure of this CMS based on HMVC patern in Codeigniter. That means that every modole is not depents on any other module in CMS, so user can add his own modules and use it on CMS as he like.

Controllers is located in a2zcms/modules/name_of_module. Here is admin controller and site part controller that has name of module. Admin controller extends Administrator_Controller, site part controller extends Website_Controller.

CMS have a custom make a page using custom function for main content and sidebar.
Implementation custom function for pages is located in site controller in modules and can(but not need to) shows in all pages, depends on which function user choose on creating specific page. 
When user go to some non-custom page(edit profile, messages,...) user get sidebar from first page.

-----
<a name="feature5"></a>
## License

This is free software distributed under the terms of the MIT license

-----
<a name="feature6"></a>
##How CMS is look like

![Install](http://oi41.tinypic.com/2my907n.jpg)
![First page](http://oi39.tinypic.com/15661qw.jpg)
![Messages](http://oi39.tinypic.com/2ajdwl2.jpg)
![Admin page](http://oi44.tinypic.com/eu2ffc.jpg)
