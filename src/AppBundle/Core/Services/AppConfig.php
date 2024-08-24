<?php

namespace AppBundle\Core\Services;

class AppConfig {

    private $kernel;

    public function __construct($kernel) {
        $this->kernel = $kernel;
    }

    public function getSideNav() {
        return $this->_readConfig('nav/sidenav.json');
    }

    private function _readConfig($relativePath) {
        $fullPath = $this->kernel->getBundle('AppBundle')->getPath() . '/Resources/config/' . $relativePath;
        return (array) json_decode(
            file_get_contents($fullPath), true
        );
    }
}