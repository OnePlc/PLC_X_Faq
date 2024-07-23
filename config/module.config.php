<?php
/**
 * module.config.php - Blog Config
 *
 * Main Config File for Blog Module
 *
 * @category Config
 * @package Blog
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Blog;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    # Blog Module - Routes
    'router' => [
        'routes' => [
            # Module Basic Route
            'blog-admin' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/blog-admin[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\BlogController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'blog-web' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/blog[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\WebController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'blog' => __DIR__ . '/../view',
        ],
        'template_map' => [
            'layout/web'           => __DIR__ . '/../view/layout/web.phtml',
        ],
    ],
];
