<?php
declare(strict_types=1);

use App\Models\Product;
use App\Transformers\ProductOutputTransformer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Views\PhpRenderer;

return function (App $app) {

    /*
     * Index page
     */

    $app->get('/', function (Request $request, Response $response) {

        $renderer = new PhpRenderer('../src/Templates/');
        return $renderer->render($response, 'home.php');

    });

    /*
     * Return all products
     */

    $app->get('/products', function (Request $request, Response $response) {

        $products = new Product();
        $productTransformer = new ProductOutputTransformer($products);

        $response
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $productTransformer->getAll()
                )
            );

        return $response;

    });

    /*
     * Return one product
     */

    $app->get('/product/{id}', function (Request $request, Response $response, array $args) {

        $product = new Product();
        $productTransformer = new ProductOutputTransformer($product);
        $response
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $productTransformer->get((int)$args['id'])
                )
            );
        return $response;

    });

    /*
     * Create New Product
     */

    $app->post('/product/new', function (Request $request, Response $response) {

        $args = $request->getParsedBody();

        $product = new Product();
        $response
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $product->updateOrCreate((string)$args['description'], (float)$args['price'])
                )
            );
        return $response;

    });


    /*
     * Update Existing Product
     */

    $app->post('/product/update', function (Request $request, Response $response) {

        $args = $request->getParsedBody();

        $product = new Product();
        $response
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $product->updateOrCreate((string)$args['description'], (float)$args['price'], (integer)$args['id'])
                )
            );
        return $response;

    });

    /*
     * Delete Product
     */

    $app->delete('/product/{id}', function (Request $request, Response $response, array $args) {

        $product = new Product();
        $response
            ->withHeader('Content-type', 'application/json')
            ->getBody()
            ->write(
                json_encode(
                    $product->destroy((integer)$args['id'])
                )
            );
        return $response;

    });


};
