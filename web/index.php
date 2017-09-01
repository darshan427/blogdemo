<?php 

require_once __DIR__.'/../vendor/autoload.php';
// use Silex\Application\;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Silex\Application\UrlGeneratorTrait;


$app = new Silex\Application;
$app['debug'] = true;
$app['base_url'] = "http://".$_SERVER['SERVER_NAME'].'/blogapi/';


// $app->error(function (\Exception $e, Request $request, $code) use ($app) {
//     switch ($code) {
//         case 404:
//             $subRequest = Request::create('/', 'GET');
//             return $app->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
//             break;
//         default:
//             $message = 'We are sorry, but something went terribly wrong.';
//     }

//     return new Response($message);
// });

$app->register(new Silex\Provider\TwigServiceProvider,[
    'twig.path' => __DIR__. '/../view'
]);

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'host'     => 'localhost',
        'dbname'   => 'blog'

    ),
));


$app->get('/',function() use ($app) {
    return $app['twig']->render('index.twig', array(
        'base_url' => $app['base_url'],
    ));
})
->bind('homepage');



$app->get('/api/user', function() use ($app) {
    $sql = "select * from blog_user";
    $users = $app['db']->fetchAll($sql);
    return $app->json($users);
});

$app->get('/api/blog_post', function() use ($app) {
    $sql = "select * from blog_post";
    $posts = $app['db']->fetchAll($sql);
    return $app->json($posts);
});

$app->run();