<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['404_override'] = "errors/error_404";

$route['default_controller'] = "pages/articles";

$route['articles']        = 'pages/articles';
$route['articles/(:any)'] = 'pages/articles/$1';

$route['contact']        = 'pages/contact';
$route['contact/(:any)'] = 'pages/contact/$1';

$route['jottings']        = 'pages/jottings';
$route['jottings/(:any)'] = 'pages/jottings/$1';

$route['article/(:any)'] = 'pages/article/$1';
$route['jotting/(:any)'] = 'pages/jotting/$1';

$route['rss.xml'] = 'feed/view/feed';

// Because of external links, redirect to updated location
$route['jotting/2013_10_gamedev01'] = 'pages/article/2013_10_gamedev01';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
