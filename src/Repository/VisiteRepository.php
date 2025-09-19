<?php

namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }
    
    /**
     * Retourne toutes les visites triées sur un champ
     * @param type $champ
     * @param type $ordre
     * @return Visite[]
     */
    public function findAllOrderBy($champ, $ordre) : array {
        
        /**
         * permet de créer une requête de type "select"
         */
        return $this->createQueryBuilder('v')
                
                /**
                 * permet d'ajouter l'ordre "ORDER BY" dans la requête. 2 paramètres sont attendus : le
                 * nom du champ (ici on utilise le paramètre $champ mais sans oublier de le faire précéder de l'alias
                 * de la table) et le type de tri ('ASC' ou 'DESC', là on utilise le paramètre $ordre).
                 */
                ->orderBy('v.'.$champ, $ordre)
                
                /**
                 * permet d'exécuter la requête.
                 */
                ->getQuery()
                
                /**
                 * permet de récupérer le résultat sous forme d'un tableau 
                 * d'objets du type de l'entity, donc ici, du type Visite.
                 */
                ->getResult();
    }
    
    /**
     * Enregistrements dont un champ est égal à une valeur
     * ou tous les enregistrements si la valeur est vide
     * @param type $champ
     * @param type $valeur
     * @return Visite[]
     */
    public function findByEqualValue($champ, $valeur) : array {
        if($valeur=="") {
            return $this->createQueryBuilder('v') // alias de la table
                ->orderBy('v.'.$champ, 'ASC')
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('v') // alias de la table
                ->where('v.'.$champ.'=:valeur')
                ->setParameter('valeur', $valeur)
                ->orderBy('v.datecreation', 'DESC')
                ->getQuery()
                ->getResult();  
        }
    }
    
    /**
     * Supprime une visite
     * @param Visite $visite
     * @return void
     */
    public function remove(Visite $visite): void {
        
        $this->getEntityManager()->remove($visite);
        $this->getEntityManager()->flush();
    }
    
    /**
     * Ajoute une visite
     * @param Visite $visite
     * @return void
     */
    public function add(Visite $visite): void {
        
        $this->getEntityManager()->persist($visite);
        $this->getEntityManager()->flush();   
    }
}
