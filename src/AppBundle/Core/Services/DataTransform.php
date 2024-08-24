<?php

namespace AppBundle\Core\Services;

use AppBundle\Core\Enum\DataType;
use AppBundle\Core\Util\DateUtil;

class DataTransform {
    public function transform($data, $type = DataType::STRING) {
        if (is_null($data) || $data == '') {
            return '';
        }
        switch ($type) {
            case DataType::BOOLEAN:
                return $this->_boolTransform($data);
            case DataType::NOMENCLATOR:
                return $this->_nomTransform($data);
            case DataType::DATE:
                return $this->_dateTransform($data);
            default:
                return $data;
        }
    }

    private function _boolTransform($data) {
        return $data ? 'Sí' : 'No';
    }

    private function _nomTransform($data) {
        return $data->getNombre();
    }

    private function _dateTransform(\DateTime $date) {
        return $date->format(DateUtil::FORMAT_D_M_Y);
    }
}