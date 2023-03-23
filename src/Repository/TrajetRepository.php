<?php

namespace App\Repository;

use App\Entity\Trajet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trajet>
 *
 * @method Trajet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trajet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trajet[]    findAll()
 * @method Trajet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrajetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trajet::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Trajet $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Trajet $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findAllGreaterThanDateNow () : array
    {
        $entityManager = $this->getEntityManager();

        $date = date("Y-m-d H:i:s");

        $query = $entityManager ->createQuery(
            'SELECT t.id, IDENTITY(t.idUtilisateurAuteur) as auteur, t.villeDepart, t.villeArrivee, t.dateHeure, t.voiture, t.nbPlace, t.prix 
            FROM  App\Entity\Trajet t
            WHERE t.dateHeure > :date
            ORDER BY t.dateHeure'
        )->setParameter('date', $date);

        return $query->getArrayResult();
    }

    public function findAllLowerThanDateNow () : array
    {
        $entityManager = $this->getEntityManager();

        $date = date("Y-m-d H:i:s");

        $query = $entityManager ->createQuery(
            'SELECT t.id, IDENTITY(t.idUtilisateurAuteur) as auteur, t.villeDepart, t.villeArrivee, t.dateHeure, t.voiture, t.nbPlace, t.prix 
            FROM  App\Entity\Trajet t
            WHERE t.dateHeure < :date
            ORDER BY t.dateHeure'
        )->setParameter('date', $date);

        return $query->getArrayResult();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findAllTrajet () : array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager ->createQuery(
            'SELECT t.id, IDENTITY(t.idUtilisateurAuteur) as auteur, t.villeDepart, t.villeArrivee, t.dateHeure, t.voiture, t.nbPlace, t.prix 
            FROM  App\Entity\Trajet t
            ORDER BY t.id'
        );

        return $query->getArrayResult();
    }

    // /**
    //  * @return Trajet[] Returns an array of Trajet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trajet
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
