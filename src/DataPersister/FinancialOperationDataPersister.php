<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\FinancialOperation;
use App\Repository\FinancialOperationRepository;
use Symfony\Component\HttpFoundation\Response;

final class FinancialOperationDataPersister implements ContextAwareDataPersisterInterface
{
    private ?FinancialOperationRepository $financialOperationrepository=null;

    public function  __construct(FinancialOperationRepository $financialOperationRepository){
        $this->financialOperationrepository = $financialOperationRepository;

    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof FinancialOperation;
    }

    public function persist($data, array $context = [])
    {
// call your persistence layer to save $data
        $referenceData =$data;
        $this->financialOperationrepository->add($data);
        $data->setTotalCost($data->getPrice() * $data->getRecurssDuration() + $data->getLastMensuality());

        if($data->getRecurssive()){
            $referenceDate = $data->getDate();
            for($i = 1 ; $i < $data->getRecurssDuration(); $i++){
                $operationRecurentItem = clone $data;

                $operationRecurentItem->setDate($referenceDate->add(new \DateInterval('P'.'1'.'M')));
                $operationRecurentItem->setMensualityNumber($i+1);
                if($data->getRecurssDuration()-1 === $i){
                    $operationRecurentItem->setPrice($data->getLastMensuality());
                }
                $this->financialOperationrepository->add($operationRecurentItem);
            }
        }

        return new Response(json_encode( $data->getDate()));
        //  return $data;
    }

    public function remove($data, array $context = [])
    {
// call your persistence layer to delete $data
    }
}