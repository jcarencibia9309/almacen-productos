<?php

namespace AppBundle\Core\Services;

use AppBundle\Core\Enum\DataType;

class DataTransform {
    public function transform($data, $type = DataType::STRING) {
        switch ($type) {
            case DataType::BOOLEAN:
                return $this->_boolTransform($data);
            default:
                return $data;
        }
    }

    private function _boolTransform($data) {
        return $data ? 'Sí' : 'No';
    }
}