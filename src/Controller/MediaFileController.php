<?php


namespace App\Controller;


use App\Service\Command\MediaFile\CreateMediaFileCommand;
use App\Service\Command\MediaFile\DeleteMediaFileCommand;
use App\Service\Command\MediaFile\LoadMediaFileCommand;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MediaFileController extends AbstractController
{

    /**
     * @Route("/upload", name="upload", methods={"POST"})
     */
    public function upload(Request $request, CommandBus $commandBus)
    {
        $content = json_decode($request->getContent(), true);
        $url = $content['url'] ?? null;
        if (!$url) {
            return new JsonResponse('Invalid request.', 400);
        }
        $result = $commandBus->handle(new CreateMediaFileCommand($url));
        if (is_array($result)) {
            return new JsonResponse($result, 200);
        } else {
            return new JsonResponse($result, 400);
        }
    }

    /**
     * @Route("/load", name="load", methods={"POST"})
     */
    public function load(Request $request, CommandBus $commandBus)
    {
        $content = json_decode($request->getContent(), true);
        $ids = $content['ids'] ?? null;
        if (!$ids) {
            return new JsonResponse('Invalid request.', 400);
        }
        $result = $commandBus->handle(new LoadMediaFileCommand($ids));
        if ($result) {
            return new JsonResponse($result, 200);
        } else {
            return new JsonResponse($result, 204);
        }
    }

    /**
     * @Route("/delete", name="delete", methods={"POST"})
     */
    public function delete(Request $request, CommandBus $commandBus)
    {
        $content = json_decode($request->getContent(), true);
        $id = $content['id'] ?? null;
        if (!$id) {
            return new JsonResponse('Invalid request.', 400);
        }
        $result = $commandBus->handle(new DeleteMediaFileCommand($id));
        if ($result) {
            return new JsonResponse($result, 200);
        } else {
            return new JsonResponse('Что-то пошло не так, попробуйте еще раз', 400);
        }
    }

}