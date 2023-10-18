<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\History;

#[Route('/api', name: 'api_')]
class HistoryController extends AbstractController
{
    #[Route('/exchange/values', name: 'history_index', methods:['get'] )]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $products = $doctrine
            ->getRepository(History::class)
            ->findAll();
   
        $data = [];
   
        foreach ($products as $product) {
           $data[] = [
               'id' => $product->getId(),
               'first_in' => $product->getFirstIn(),
               'second_in' => $product->getSecondIn(),
               'first_out' => $product->getSecondIn(),
               'second_out' => $product->getFirstIn(),
               'data_utworzenia' => $product->getDataUtworzenia(),
               'data_aktualizacji' => $product->getDataAktualizacji(),
           ];
        }
   
        return $this->json($data);
    }

    #[Route('/exchange/values', name: 'history_create', methods:['post'])]
    public function create(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $history = new History();
        $history->setFirstIn($request->request->get('first_in'));
        $history->setSecondIn($request->request->get('second_in'));
        $history->setFirstOut($request->request->get('second_in'));
        $history->setSecondOut($request->request->get('first_in'));

        $entityManager->persist($history);
        $entityManager->flush();

        $data =  [
            'id' => $history->getId(),
            'first_in' => $history->getFirstIn(),
            'second_in' => $history->getSecondIn(),
            'first_out' => $history->getSecondIn(),
            'second_out' => $history->getFirstIn(),
            'data_utworzenia' => $history->getDataUtworzenia(),
            'data_aktualizacji' => $history->getDataAktualizacji(),
        ];
           
        return $this->json($data);
    }

    #[Route('/exchange/values/{id}', name: 'history_show', methods:['get'] )]
    public function show(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $history = $doctrine->getRepository(History::class)->find($id);
   
        if (!$history) {
   
            return $this->json('No history found for id ' . $id, 404);
        }
   
        $data =  [
            'id' => $history->getId(),
            'first_in' => $history->getFirstIn(),
            'second_in' => $history->getSecondIn(),
            'first_out' => $history->getSecondIn(),
            'second_out' => $history->getFirstIn(),
            'data_utworzenia' => $history->getDataUtworzenia(),
            'data_aktualizacji' => $history->getDataAktualizacji(),
        ];
           
        return $this->json($data);
    }

    #[Route('/exchange/values/{id}', name: 'history_update', methods:['put', 'patch'] )]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $history = $entityManager->getRepository(History::class)->find($id);
   
        if (!$history) {
            return $this->json('No history found for id' . $id, 404);
        }
   
        $history->setFirstIn($request->request->get('first_in'));
        $history->setSecondIn($request->request->get('second_in'));
        $history->setFirstOut($request->request->get('second_in'));
        $history->setSecondOut($request->request->get('first_in'));
        $history->setDataAktualizacji(new \DateTime());
        $entityManager->flush();
   
        $data =  [
            'id' => $history->getId(),
            'first_in' => $history->getFirstIn(),
            'second_in' => $history->getSecondIn(),
            'first_out' => $history->getSecondIn(),
            'second_out' => $history->getFirstIn(),
            'data_utworzenia' => $history->getDataUtworzenia(),
            'data_aktualizacji' => $history->getDataAktualizacji(),
        ];
           
        return $this->json($data);
    }
 
    #[Route('/exchange/values/{id}', name: 'history_delete', methods:['delete'] )]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $history = $entityManager->getRepository(History::class)->find($id);
   
        if (!$history) {
            return $this->json('No history found for id' . $id, 404);
        }
   
        $entityManager->remove($history);
        $entityManager->flush();
   
        return $this->json('Deleted a history successfully with id ' . $id);
    }
}
