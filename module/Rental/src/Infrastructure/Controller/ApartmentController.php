<?php

namespace Rental\Infrastructure\Controller;

use Laminas\Json\Json;
use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\JsonModel;
use Rental\Application\Service\ApartmentService;

class ApartmentController extends AbstractRestfulController
{
    private ApartmentService $apartmentService;

    public function __construct(ApartmentService $apartmentService)
    {
        $this->apartmentService = $apartmentService;
    }

    public function create($data): JsonModel
    {
        $content = $this->getRequest()->getContent();
        $data = Json::decode($content, Json::TYPE_ARRAY);

        $this->apartmentService->add(
            $data['ownerId'],
            $data['street'],
            $data['postalCode'],
            $data['houseNumber'],
            $data['apartmentNumber'],
            $data['city'],
            $data['country'],
            $data['description'],
            $data['rooms']
        );

        return new JsonModel([
            'status' => 'OK'
        ]);
    }
}