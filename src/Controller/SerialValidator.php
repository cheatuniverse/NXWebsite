<?php


namespace App\Controller;


use App\Entity\License;
use App\Repository\LicenseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SerialValidator
{
    /** @var EntityManagerInterface */
    private $manager;

    /** @var LicenseRepository */
    private $repository;

    public function __construct(EntityManagerInterface $manager, LicenseRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    public function __invoke(Request $request) {
        try {
            $content = \json_decode($request->getContent());
            $serial = $content->serial;
            $hwid = $content->hwid;

            $dbSerial = $this->repository->findOneBy([
                'licenseKey' => $serial,
            ]);

            if (!$dbSerial instanceof License) {
                throw new BadRequestHttpException();
            }

            if (null === $dbSerial->getHwid()) {
                $dbSerial->setHwid($hwid);
                $this->manager->flush();
            }

            if ($dbSerial->getHwid() !== $hwid) {
                throw new BadRequestHttpException();
            }

            return new JsonResponse([
                'serial' => $dbSerial->getLicenseKey(),
                'hwid' => $dbSerial->getHwid(),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }
    }
}
