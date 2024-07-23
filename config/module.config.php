<?php
/**
 * module.config.php - Faq Config
 *
 * Main Config File for Faq Module
 *
 * @category Config
 * @package Faq
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Faq;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    # Faq Module - Routes
    'router' => [
        'routes' => [
            # Module Basic Route
            'faq-admin' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/faq-admin[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\FaqController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'faq-web' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/faq[/:action[/:id]]',
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
            'faq' => __DIR__ . '/../view',
        ],
    ],
];
