<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Controller\Shop;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HomepageController
{
    /** @var EngineInterface */
    private $templatingEngine;

    /** @var EntityManagerInterface */
    private $manager;

    public function __construct(EngineInterface $templatingEngine, EntityManagerInterface $manager)
    {
        $this->templatingEngine = $templatingEngine;
        $this->manager = $manager;
    }

    public function indexAction(Request $request): Response
    {
        return $this->templatingEngine->renderResponse('bundles/SyliusShopBundle/Layout/Homepage/index.html.twig');
    }
}
