<?php

namespace JamesMiranda\Controllers;

use JamesMiranda\Entities\Fantasy as FantasyModel;

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

    public function __construct()
    {
        $fantasyModel = new FantasyModel();
        $productRepository = $entityManager->getRepository('DiegoBrocanelli\Product');

        // Podemos acessar o método findAll() responsável por retornar todos os
        // registros cadastrados em nossa tabela products
        $products = $productRepository->findAll();
    }
}