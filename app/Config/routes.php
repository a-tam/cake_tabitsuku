<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'top', 'top'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/site/about', array('controller' => 'pages', 'action' => 'about'));
	Router::connect('/site/howto', array('controller' => 'pages', 'action' => 'howto'));
	Router::connect('/site/contact', array('controller' => 'pages', 'action' => 'contact'));
	Router::connect('/site/rule', array('controller' => 'pages', 'action' => 'rule'));
	Router::connect('/login_form', array('controller' => 'pages', 'action' => 'login'));
	Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
	Router::connect('/fb_auth', array('controller' => 'users', 'action' => 'fb_auth'));
	
	// 今後、JS側を修正するもの
	Router::connect('/api/spot/*', array('controller' => 'api', 'action' => 'spot_list', 'ext' => 'json'));
	Router::connect('/api/tour/*', array('controller' => 'api', 'action' => 'tour_list', 'ext' => 'json'));
	Router::connect('/user/tag/search', array('controller' => 'api', 'action' => 'tag_list', 'ext' => 'json'));
	Router::connect('/user/tour/query/*', array('controller' => 'api', 'action' => 'tour_list', 'ext' => 'json'));
	Router::connect('/user/category/node/*', array('controller' => 'api', 'action' => 'category_list', 'ext' => 'json'));
	
/**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';

	Router::mapResources('api');
	Router::parseExtensions("json", "xml");
	
	