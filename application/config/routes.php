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
$route['profile/changePassword'] = 'profile/changePassword';
$route['profile/uploadPicture'] = 'profile/uploadPicture';
$route['profile/(:any)'] = 'profile/index/$1';

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
$route['article/getImage'] = 'article/getImage';
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

// Page
// Front End

// Back End
$route['page'] = 'page/all';
$route['page/index'] = 'page/all';
$route['page/all'] = 'page/all';
$route['page/(:num)'] = 'page/all/$1';
$route['page/add'] = 'page/add';
$route['page/create'] = 'page/create';
$route['page/getImage'] = 'page/getImage';
$route['page/all/index'] = 'page/all';
$route['page/all/list'] = 'page/all';
$route['page/all/list/(:num)'] = 'page/all/list/$1';
$route['page/all/publish'] = 'page/all/$1';
$route['page/all/publish/(:num)'] = 'page/all/publish/$1';
$route['page/all/draft'] = 'page/all/$1';
$route['page/all/draft/(:num)'] = 'page/all/draft/$1';
$route['page/all/trash'] = 'page/all/$1';
$route['page/all/trash/(:num)'] = 'page/all/trash/$1';
$route['page/changeState'] = 'page/changeState';

$route['page/(:any)/edit'] = 'page/edit/$1';
$route['page/update/(:any)'] = 'page/update/$1';

$route['page/restore/(:any)'] = 'page/status/$1/restore';
$route['page/trash/(:any)'] = 'page/status/$1/trash';
$route['page/draft/(:any)'] = 'page/status/$1/draft';
$route['page/publish/(:any)'] = 'page/status/$1/publish';
$route['page/delete/(:any)'] = 'page/delete/$1';

$route['page/(:any)/draft'] = 'page/show/$1/draft';
$route['page/(:any)'] = 'page/show/$1';

// Media
// Backend
$route['media/index'] = 'media/index/image';
$route['media/image'] = 'media/index/image';
$route['media/file'] = 'media/index/file';
$route['media/audio'] = 'media/index/audio';
$route['media/video'] = 'media/index/video';
$route['media/image/(:num)'] = 'media/index/image/$1';
$route['media/file/(:num)'] = 'media/index/file/$1';
$route['media/audio/(:num)'] = 'media/index/audio/$1';
$route['media/video/(:num)'] = 'media/index/video/$1';
$route['media/update/(:any)'] = 'media/update/$1';
$route['media/delete/(:any)'] = 'media/delete/$1';

// Message
// Backend
$route['message/all'] = 'message/all';
$route['message/all/list'] = 'message/all';
$route['message/all/read'] = 'message/all/$1';
$route['message/all/unread'] = 'message/all/$1';
$route['message/all/solve'] = 'message/all/$1';
$route['message/all/unsolve'] = 'message/all/$1';
$route['message/all/list/(:num)'] = 'message/all/list/$1';
$route['message/all/read/(:num)'] = 'message/all/read/$1';
$route['message/all/unread/(:num)'] = 'message/all/unread/$1';
$route['message/all/solve/(:num)'] = 'message/all/solve/$1';
$route['message/all/unsolve/(:num)'] = 'message/all/unsolve/$1';

// Slideshow
$route['slideshow/all'] = 'slideshow/index';
$route['slideshow/(:any)/edit'] = 'slideshow/edit/$1';

// Frontend
// $route['login/admin/(:num)'] = 'login/admin/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */