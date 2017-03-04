<?php

namespace LG\CoreBundle\Repository;

/**
 * BookingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookingRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * With this function, we can get all booking dates from today
     * @return array
     */
    public function findByDateReservation()
    {
        $dayYesterday = date('d') - 1;
        $month = date('m');
        $year = date('Y');
        // If we don't check that, we can't get date reservation after current date (for example, with 2017033 for current date, query doesn't work. We must have 20170303)
        if ($dayYesterday < 10){
            $dayYesterday = '0'.$dayYesterday;
        }
        $currentDate = $year.$month.$dayYesterday;
        
        $qd = $this->createQueryBuilder('b');
        
        $qd
            ->select('b')
            ->where('b.dateReservation > :currentDate')->setParameter('currentDate', $currentDate)
            ->andWhere('b.paymentIsSuccess = 1');
        
        return $qd->getQuery()->getResult();
    }

    /**
     * @param $token
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByToken($token) {
        $qb = $this->createQueryBuilder('b');
        $qb->select('b')
            ->where('b.token = :token')
            ->setParameter('token', $token['token']);
        return $qb->getQuery()->getOneOrNullResult();
    }
}
