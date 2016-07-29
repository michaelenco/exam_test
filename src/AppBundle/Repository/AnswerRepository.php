<?php

namespace AppBundle\Repository;

/**
 * AnswerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnswerRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $userId
     * @return int
     */
    public function getErrorsCount($userId) {
        return (int)$this->getEntityManager()
            ->createQuery("select count(a.id) from AppBundle:Answer a where a.userId = :uid and a.enId <> a.ruId")
            ->setParameter("uid", $userId)
            ->getSingleScalarResult();
    }
    public function getAskedQuestions($userId) {
        $res = $this->getEntityManager()
            ->createQuery("select a.enId from AppBundle:Answer a where a.userId = :uid group by a.id")
            ->setParameter("uid", $userId)
            ->getResult();
        return array_map(function($i) {
                return $i['enId'];
            }, $res);
    }
    public function getScore($userId) {
        return (int)$this->getEntityManager()
            ->createQuery("select count(a.id) from AppBundle:Answer a where a.userId = :uid and a.enId = a.ruId")
            ->setParameter("uid", $userId)
            ->getSingleScalarResult();
    }
}