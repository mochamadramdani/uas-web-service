<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// GET route
$app->get(
    '/',
    function () {
		$html = <<<HTM
			<h1>PHP Micro Frameworks Database</h1>
			<p>
				A tool for the rapid development of web applications & APIs. 
				The focus is on providing a core structure that enables requests to the API 
				to be properly <i>routed</i> - i.e. sent on to the correct handler - along with some extra features such as logging, caching, error handling etc. 
				A plugin architecture ensures that additional capabilities such as high level database access.
			</p>
HTM;
		echo $html;
    }
);

$app->get(
	'/laptop',
	'\App\Routes\Laptop:index'
);
$app->get(
	'/laptop/find',
	'\App\Routes\Laptop:find'
);
$app->get(
	'/laptop/:id',
	'\App\Routes\Laptop:view'
);
$app->post(
	'/laptop',
	'\App\Routes\Laptop:create'
);
$app->put(
	'/laptop',
	'\App\Routes\Laptop:update'
);
$app->delete(
	'/laptop',
	'\App\Routes\Laptop:delete'
);


$app->get(
	'/part_categories',
	'\App\Routes\PartsCategories:index'
);
$app->get(
	'/part_categories/find',
	'\App\Routes\PartsCategories:find'
);
$app->get(
	'/part_categories/:id',
	'\App\Routes\PartsCategories:view'
);
$app->post(
	'/part_categories',
	'\App\Routes\PartsCategories:create'
);
$app->put(
	'/part_categories',
	'\App\Routes\PartsCategories:update'
);
$app->delete(
	'/part_categories',
	'\App\Routes\PartsCategories:delete'
);

$app->get(
	'/parts',
	'\App\Routes\Parts:index'
);
$app->get(
	'/parts/find',
	'\App\Routes\Parts:find'
);
$app->get(
	'/parts/:id',
	'\App\Routes\Parts:view'
);
$app->post(
	'/parts',
	'\App\Routes\Parts:create'
);
$app->put(
	'/parts',
	'\App\Routes\Parts:update'
);
$app->delete(
	'/parts',
	'\App\Routes\Parts:delete'
);


/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
