<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\FinancialOperation;

class FinancialOperationFixtures extends Fixture
{

    public function createRecurssion(ObjectManager $manager, FinancialOperation $operation)
    {
        for ($i = 1; $i < $operation->getRecurssDuration(); $i++) {
            $operationRecursse = unserialize(serialize($operation));
            $operationRecursse->getDate()->add(new \DateInterval('P'.$i.'M'));
            $operationRecursse->setMensualityNumber($i+1);
            $operationRecursse->setFinancialstatus('waiting');

            //mensuality managment
            if($operation->getRecurssive() && $operation->getIsAllMensualityequals()){
                $operation->setMensualityCost($operation->getPrice());
                $operation->setTotalCost($operation->getRecurssDuration()*$operation->getPrice());
                $operationRecursse->setTotalCost($operation->getTotalCost());
            }else if($operation->getRecurssive() && !$operation->getIsAllMensualityequals()){
                $operation->setMensualityCost($operation->getPrice());
                $lastMensuality =$operation->getPrice()-($operation->getPrice()/10);
                $operation->setLastMensuality($lastMensuality);
                if($i === $operation->getRecurssDuration()-1)$operationRecursse->setPrice($operation->getLastMensuality());
                $operation->setTotalCost((($operation->getRecurssDuration()-1)*$operation->getPrice())+$lastMensuality);
            }
            $manager->persist($operationRecursse);
        }
        $operation->setMensualityNumber(1);
    }

    public function load(ObjectManager $manager)
    {
        $status = ['paid', 'unpaid', 'waiting'];

        $faker = Factory::create('fr_FR');
        for ($c = 0; $c < 30; $c++) {
            $operation = new FinancialOperation();
            $operation->setTitle("oper" . $c);
            $operation->setPrice(mt_rand(100, 25000) / 100);
            $operation->setDetail($faker->text());
            $operation->setSide(mt_rand(0, 1) ? false : true);
            $year = "2022";
            $month = mt_rand(3, 6);
            $day = mt_rand(1, 30);
            $date = date($year . "-" . $month . "-" . $day);
            $operation->setDate(new \DateTime($date));
            $operation->setCreationDate(new \DateTime($date));
            $operation->setEndDate(new \DateTime($date));
            $recurssivity = mt_rand(0, 1) ? false : true;

            $operation->setRecurssive($recurssivity);
            if($recurssivity){
                $duration = mt_rand(2, 6);
                $operation->setRecurssDuration($operation->getRecurssive() ? $duration : 1);
            }
            $operation->setMensualityNumber(1);

            $hazard = mt_rand(0, 1);
            $operation->setIsAllMensualityequals($hazard?true:false);
            if($recurssivity)$operation->setTotalCost($operation->getPrice());


            $hazard = mt_rand(0, 2);
            $operation->setFinancialStatus($status[$hazard]);
            $manager->persist($operation);
            if ($operation->getRecurssive()) {
                $this->createRecurssion($manager, $operation);
            }
        }
        $manager->flush();
    }
}