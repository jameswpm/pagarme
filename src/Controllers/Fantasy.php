<?php

namespace JamesMiranda\Controllers;
use Doctrine\ORM\EntityManager;

/**
 * Class Fantasy
 * @package JamesMiranda\Controllers
 */
class Fantasy
{
    /**
     * @var array $fantasies
     */
    private $fantasies;

    public function __construct(EntityManager $em)
    {
        $fantasyRepository = $em->getRepository('JamesMiranda\Entities\Fantasy');

        // Podemos acessar o método findAll() responsável por retornar todos os
        // registros cadastrados em nossa tabela products
        $this->fantasies = $fantasyRepository->findAll();
    }

    /**
     * @return array
     */
    public function allFantasies()
    {
        return ($this->fantasies);
    }
}