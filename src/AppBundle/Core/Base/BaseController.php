<?php

namespace AppBundle\Core\Base;

use AppBundle\Service\CategoriaService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    /**
     * @return CategoriaService
     */
    public function getCategoriaSrv() {
        return $this->get('app.categoria');
    }
}
