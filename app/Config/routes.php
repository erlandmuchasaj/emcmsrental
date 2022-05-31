<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/:language',  array('admin' => false, 'controller' => 'properties', 'action' => 'index'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/', array('admin' => false, 'controller' => 'properties', 'action' => 'index'));

	// comming soon / maintenance page
	Router::connect('/:language/maintenance',  array('admin' => false, 'controller' => 'pages', 'action' => 'maintenance'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/maintenance', array('admin' => false, 'controller' => 'pages', 'action' => 'maintenance'));

	// not found page
	Router::connect('/:language/login',  array('admin' => false, 'controller' => 'users', 'action' => 'login'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/login', array('admin' => false, 'controller' => 'users', 'action' => 'login'));

	// not found page
	Router::connect('/:language/404',  array('controller' => 'errors', 'action' => 'error404'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/404', array('controller' => 'errors', 'action' => 'error404'));

	// sitemap XML
	Router::connect('/:language/sitemap.xml',  array('controller' => 'properties', 'action' => 'sitemap'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/sitemap.xml', array('controller' => 'properties', 'action' => 'sitemap'));

	// blog 
	Router::connect('/:language/blog', array('controller' => 'articles', 'action' => 'index'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/blog', array('controller' => 'articles', 'action' => 'index'));

	Router::connect('/:language/blog/article/*',  array('controller' => 'articles', 'action' => 'view'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/blog/article/*', array('controller' => 'articles', 'action' => 'view'));

	/*  Payment */
	Router::connect('/:language/paymentSuccess/*',  array('controller' => 'properties', 'action' => 'paymentSuccess'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/paymentSuccess/*', array('controller' => 'properties', 'action' => 'paymentSuccess'));

	Router::connect('/:language/paymentCancel/*',  array('controller' => 'properties', 'action' => 'paymentCancel'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/paymentCancel/*', array('controller' => 'properties', 'action' => 'paymentCancel'));

	Router::connect('/:language/paymentIpn/*',  array('controller' => 'properties', 'action' => 'paymentIpn'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/paymentIpn/*', array('controller' => 'properties', 'action' => 'paymentIpn'));

	// Social login
	Router::connect('/:language/social_login/**',  array('controller' => 'users', 'action' => 'social_login'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/social_login/**', array( 'controller' => 'users', 'action' => 'social_login'));

	Router::connect('/:language/social_endpoint/**',  array('controller' => 'users', 'action' => 'social_endpoint'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/social_endpoint/**', array( 'controller' => 'users', 'action' => 'social_endpoint'));


	// auto pages Routing
	if (Configure::read('EmcmsPages.routes.autoRouting')) {
        $ignore = 'index|add|view|edit|display|delete|maintenance|main|admin|users|blog|reviews|wishlists|experiences|faqs|login|logout';
        if (Configure::read('EmcmsPages.routes.autoRoutingIgnoreRoutes')) {
            $ignore = Configure::read('EmcmsPages.routes.autoRoutingIgnoreRoutes');
        }
        Router::connect('/:language/:route',
        	array(
        		'controller' => 'pages',
        		'action' => 'display'
        	),
        	array(
        		'route' => '(?!' . $ignore . '\b)\b[a-zA-Z0-9_-]+',
        		'pass'=>array('route'),
        		'language' => '[a-z]{2}',
        		'persist' => ['language']
        	)
        );
        Router::connect('/:route',
        	array(
        		'controller' => 'pages',
        		'action' => 'display'
        	),
	        array(
	            'route' => '(?!' . $ignore . '\b)\b[a-zA-Z0-9_-]+',
	            'pass'=>array('route')
	        )
    	);
    	unset($ignore);
    }


    /*** Admin Routing URL-s */
	$prefixes = Router::prefixes();
	foreach ($prefixes as $prefix) {
		Router::connect(
		    "/:language/{$prefix}",
		    array('controller' => 'users', 'action' => 'dashboard', 'prefix' => $prefix, $prefix => true),
		    ['language' => '[a-z]{2}', 'persist' => ['language']]
		);
		Router::connect(
		    "/{$prefix}",
		    array( 'controller' => 'users', 'action' => 'dashboard', 'prefix' => $prefix, $prefix => true)
		);

		Router::connect(
		    "/:language/{$prefix}/:controller",
		    array('action' => 'index', 'prefix' => $prefix, $prefix => true),
		    ['language' => '[a-z]{2}', 'persist' => ['language']]
		);
		Router::connect(
		    "/{$prefix}/:controller",
		    array('action' => 'index', 'prefix' => $prefix, $prefix => true)
		);

		Router::connect(
		    "/:language/{$prefix}/:controller/:action/*",
		    array('prefix' => $prefix, $prefix => true),
		    ['language' => '[a-z]{2}', 'persist' => ['language']]
		);
		Router::connect(
		    "/{$prefix}/:controller/:action/*",
		    array('prefix' => $prefix, $prefix => true)
		);

		unset($prefix);
	}
	unset($prefixes);

	/**
	 * ...and connect the rest of 'Pages' controller's URLs.
	 */
	Router::connect('/:language/pages/*', array('controller' => 'pages', 'action' => 'display'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

	Router::connect('/:language/:controller', array('action' => 'index'), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/:controller',array('action' => 'index'), array());

	Router::connect('/:language/:controller/:action/*', array(), ['language' => '[a-z]{2}', 'persist' => ['language']]);
	Router::connect('/:controller/:action/*', array());

	/*
	 * Load all plugin routes. See the CakePlugin documentation on
	 * how to customize the loading of plugin routes.
	 */
	CakePlugin::routes();

	// Router::mapResources(array('properties','users'));
	Router::parseExtensions('json');

	/*
	 * Load the CakePHP default routes. Only remove this if you do not want to use
	 * the built-in default routes.
	 */
	require CAKE . 'Config' . DS . 'routes.php';
