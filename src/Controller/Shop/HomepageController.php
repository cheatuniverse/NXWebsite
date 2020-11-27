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

use App\Entity\Launcher;
use App\Repository\LauncherRepository;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class HomepageController
{
    /** @var EngineInterface */
    private $templatingEngine;

    /** @var LauncherRepository */
    private $repository;

    public function __construct(EngineInterface $templatingEngine, LauncherRepository $repository)
    {
        $this->templatingEngine = $templatingEngine;
        $this->repository = $repository;
    }

    public function indexAction(): Response
    {
        $latestLauncher = $this->repository->findOneBy([], ['id' => 'ASC']);

        if (!$latestLauncher instanceof Launcher) {
            $latestLauncher = new Launcher();
            $latestLauncher->setLink('#');
            $latestLauncher->setVersion('');
        }

        return $this->templatingEngine->renderResponse(
            'bundles/SyliusShopBundle/Layout/Homepage/index.html.twig',
            ['launcher' => $latestLauncher]
        );
    }
}
