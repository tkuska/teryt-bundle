<?php

namespace Tkuska\TerytBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\AbstractQuery;

/**
 * GminaRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GminaRepository extends EntityRepository
{
    /**
     * Funkcja pobiera jako parametr nazwę województwa bądź jej część i zwraca wszystki pasujące rekordy.
     *
     * @param string $name
     * @param string $wojewodztwo
     *
     * @return DoctrineCollection
     */
    public function getGminaByName($name, $wojewodztwo = null, $powiat = null)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('g.nazwa, g.nazdod, g.gmi, g.woj, g.pow, g.rodz, p.nazwa as powiat, w.nazwa as wojewodztwo')
                ->from('TkuskaTerytBundle:Gmina', 'g')
                ->leftJoin('g.wojewodztwo', 'w')
                ->leftJoin('g.powiat', 'p')
                ->where('g.nazwa like :nazwa');
        if ($wojewodztwo) {
            $qb->andWhere('g.woj = :wojewodztwo')
                         ->setParameter('wojewodztwo', $wojewodztwo);
        }
        if ($powiat) {
            $qb->andWhere('g.pow = :powiat')
                        ->setParameter('powiat', $powiat);
        }
        $qb->setParameter('nazwa', $name.'%')
                ->orderBy('g.nazwa');

        return $qb->getQuery()
                ->useQueryCache(true)
                ->useResultCache(true)
                ->getResult(AbstractQuery::HYDRATE_ARRAY);
    }

    /**
     * Zapytanie dołączające gminy do województw.
     *
     * @return \Doctrine\ORM\NativeQuery
     */
    public function dolaczGminyDoWojewodztw()
    {
        $rsm = new ResultSetMapping();
        $this->_em->createNativeQuery('UPDATE teryt_gminy g 
            SET  wojewodztwo_id = ( 
            SELECT  id
            FROM  teryt_wojewodztwa w
            WHERE w.WOJ = g.WOJ)', $rsm)
                ->getResult(AbstractQuery::HYDRATE_SCALAR);
    }

    /**
     * Zapytanie dołączające gminy do powiatów.
     *
     * @return \Doctrine\ORM\NativeQuery
     */
    public function dolaczGminyDoPowiatow()
    {
        $rsm = new ResultSetMapping();
        $this->_em->createNativeQuery('UPDATE teryt_gminy g 
            SET  powiat_id = ( 
            SELECT  id 
            FROM  teryt_powiaty p
            WHERE p.WOJ = g.WOJ AND p.POW = g.POW)', $rsm)
                ->getResult(AbstractQuery::HYDRATE_SCALAR);
    }
}
