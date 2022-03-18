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


        if($data->getRecurssive()){
            for($i = 1 ; $i <= $data->getRecurssDuration(); $i++){
                $operationRecurentItem = clone $data;
                $operationRecurentItem->setDate($data->getDate()->add(new \DateInterval('P'.$i.'M')));
                $this->financialOperationrepository->add($operationRecurentItem);
            }
        }
        $this->financialOperationrepository->add($data);
        return new Response(json_encode( $data->getDate()));
        //  return $data;
    }

    public function remove($data, array $context = [])
    {
// call your persistence layer to delete $data
    }
}