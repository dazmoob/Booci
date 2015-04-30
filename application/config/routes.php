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

$route['default_controller'] = "login";
$route['404_override'] = 'error';

// Backend - User
$route['login/user/(:any)'] = 'login/user/$1';

// Backend - Profile
$route['profile/update/(:any)'] = 'profile/update/$1';
$route['profile/(:any)/edit'] = 'profile/edit/$1';
$route['profile/(:any)'] = 'profile/index/$1';
$route['profile/uploadPicture'] = 'profile/uploadPicture';

// Backend - User
$route['user/(:any)/edit'] = 'user/edit/$1';

// Article
// Front End
$route['article'] = 'article/index';
$route['article/index'] = 'article/index';
$route['article/(:num)'] = 'article/index/$1';

// Back End
$route['article/all'] = 'article/all';
$route['article/add'] = 'article/add';
$route['article/all/index'] = 'article/all';
$route['article/all/list'] = 'article/all';
$route['article/all/publish'] = 'article/all/$1';
$route['article/all/draft'] = 'article/all/$1';
$route['article/all/trash'] = 'article/all/$1';

$route['article/(:any)/edit'] = 'article/edit/$1';

$route['article/restore/(:any)'] = 'article/status/$1/restore';
$route['article/trash/(:any)'] = 'article/status/$1/trash';
$route['article/draft/(:any)'] = 'article/status/$1/draft';
$route['article/publish/(:any)'] = 'article/status/$1/publish';
$route['article/delete/(:any)'] = 'article/delete/$1';

$route['article/(:any)/draft'] = 'article/show/$1/draft';
$route['article/(:any)'] = 'article/show/$1';

// Media
// Backend
$route['media'] = 'media';

// Frontend
// $route['login/admin/(:num)'] = 'login/admin/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */