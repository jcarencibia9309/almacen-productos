<?php

namespace AppBundle\Core\Util;

use DateTime;

/**
 * Class DateUtil
 * @package App\Core\Util
 */
class DateUtil
{
    const SUNDAY_DAY = 'sunday';
    const SATURDAY_DAY = 'saturday';
    const TIME_NOW = 1;
    const TIME_FIRST = 2;
    const TIME_LAST = 3;
    const FORMAT_D_M_Y = 'd/m/Y';
    const FORMAT_Y_M_D = 'Y-m-d';
    const FORMAT_M_Y = 'm/Y';
    const FORMAT_D_M_Y_H_I_AA = 'd/m/Y h:i A';
    const FORMAT_D_M_Y_H_I_SS = 'd/m/Y H:i:s'; //11/12/2020 16:17:52
    const FORMAT__D__M__Y_H_I_SS = 'd-m-Y H:i:s'; //11-12-2020 16:17:52
    const FORMAT_D_MA_Y = 'd/M/Y';
    const FORMAT_D_MA = 'd \d\e M'; //Ex: 30 de Nov
    const FORMAT_H_I = 'H:i';

    /**
     * Retorna la fecha actual
     *
     * @param null $format
     * @return DateTime|string
     * @throws \Exception
     */
    public static function actual($format = null)
    {
        $currentDate = new DateTime();

        if (!is_null($format)) {
            return $currentDate->format($format);
        } else {
            return $currentDate;
        }
    }

    /**
     * @param $day
     * @param bool|false $today
     * @return DateTime
     */
    public static function next($day, $today = true)
    {
        $dateToday = date_create(date('Y-m-d'));
        $dateNext = date_create(date('Y-m-d', strtotime("next $day")));

        if ($today && $dateToday->format('w') == $dateNext->format('w')) {
            return $dateToday;
        } else {
            return $dateNext;
        }
    }

    /**
     * @param $day
     * @param bool|false $today
     * @return DateTime
     */
    public static function last($day, $today = true)
    {
        $dateToday = date_create(date('Y-m-d'));
        $dateLast = date_create(date('Y-m-d', strtotime("last $day")));

        if ($today && $dateToday->format('w') == $dateLast->format('w')) {
            return $dateToday;
        } else {
            return $dateLast;
        }
    }

    /**
     * Retorna los dias de diferencia entre una fecha segun calendario natural
     *
     * @author Jose Carlos Arencibia Perez <jcarencibia@uci.cu>
     * @param DateTime $pfecha1
     * @param DateTime $pfecha2
     * @return mixed
     * @throws \Exception
     */
    public static function restarFechaNatural(DateTime $pfecha1, DateTime $pfecha2)
    {
        $fecha1 = DateUtil::cloneDate($pfecha1);
        $fecha2 = DateUtil::cloneDate($pfecha2);
        $fecha1->setTime(23, 0, 0);
        $fecha2->setTime(23, 0, 0);
        return $fecha1->diff($fecha2)->days;
    }

    /**
     * @param DateTime $fecha
     * @return DateTime
     * @throws \Exception
     */
    public static function cloneDate(DateTime $fecha)
    {
        $clone = new DateTime();
        $clone->setDate($fecha->format('Y'), $fecha->format('m'), $fecha->format('d'));
        $clone->setTime($fecha->format('H'), $fecha->format('i'), $fecha->format('s'));
        return $clone;
    }

    /**
     * Retorna texto de la fecha teniendo en cuenta los dias que paso
     *
     * @param DateTime $date
     * @param string $formatDay
     * @return array
     * @throws \Exception
     */
    public static function formatDayPass($date, $formatDay = DateUtil::FORMAT_D_MA_Y)
    {
        setlocale(LC_ALL, "es_ES.UTF-8");
        $now = new DateTime();
        $day = strftime("%e/%h/%Y", mktime(0, 0, 0, $date->format('m'), $date->format('d'), $date->format('Y')));
        $time = $date->format('h:i A');

        $now->setTime(23, 0, 0);
        $date->setTime(23, 0, 0);

        $diff = $date->diff($now);

        if ($diff->y == 0 && $diff->m == 0 && $date <= $now) {
            if ($diff->d == 0) {
                $day = 'Hoy';
            } elseif ($diff->d == 1) {
                $day = 'Ayer';
            }
        }
        setlocale(LC_ALL, '');

        return array(
            'day' => $day,
            'time' => $time
        );
    }

    /**
     * Retorna texto de la fecha teniendo en cuenta las horas, dias y annos que paso
     *
     * @param DateTime $date
     * @param string $formatDay
     * @return array
     * @throws \Exception
     */
    public static function formatTimePass($date, $formatDay = DateUtil::FORMAT_D_MA_Y)
    {
        setlocale(LC_ALL, "es_ES.UTF-8");
        $now = new DateTime();
        $day = strftime("%e/%h/%Y", mktime(0, 0, 0, $date->format('m'), $date->format('d'), $date->format('Y')));
        $time = $date->format('h:i A');

        $diff = $date->diff($now);

        if ($diff->y == 0 && $diff->m == 0 && $date <= $now) {
            //si es hoy
            if ($diff->d == 0 && $now->format('d') == $date->format('d')) {
                if ($diff->h != 0) {
                    if ($diff->h <= 3) {
                        $day = $diff->h == 1 ? $diff->h . ' hora' : $diff->h . ' horas';
                    } else {
                        $day = $date->format('h:i A');
                    }
                } elseif ($diff->i != 0) {
                    $day = $diff->i == 1 ? $diff->i . ' minuto' : $diff->i . ' minutos';
                } else {
                    $day = 'ahora';
                }
            } else {
                $day = $date->format(DateUtil::FORMAT_D_MA);
            }
        } elseif ($diff->y == 0 && $date <= $now) {
            $day = $date->format(DateUtil::FORMAT_D_MA);
        }
        setlocale(LC_ALL, '');

        return array(
            'day' => $day,
            'time' => $time
        );
    }

    /**
     * @author Jose Carlos Arencibia Perez <jcarencibia@uci.cu>
     * @param DateTime $fecha fecha a convertir a string
     * @return string Ejemplo  20 de agosto de 2013
     */
    public static function toString(DateTime $fecha)
    {
        if (strpos($_SERVER['SERVER_SOFTWARE'], "Win32") !== false || strpos($_SERVER['SERVER_SOFTWARE'], "Win64") !== false) {
            setlocale(LC_TIME, 'Spanish');
            $fechaStr = strftime('%d de %B de %Y', strtotime($fecha->format('Y') . '-' . $fecha->format('m') . '-' . $fecha->format('d')));
        } else {
            setlocale(LC_ALL, "es_ES.UTF-8");
            $fechaStr = strftime("%e de %B de %Y", mktime(0, 0, 0, $fecha->format('m'), $fecha->format('d'), $fecha->format('Y')));
        }
        setlocale(LC_ALL, '');

        return $fechaStr;
    }

    /**
     * Para crear el obj desde el formato que viene desde la vista
     *
     * @author Jose Carlos Arencibia Perez <jcarencibia@uci.cu>
     * @param string $date_string
     * @param integer $time
     * @param string $format
     * @return DateTime|false
     */
    public static function createFromView($date_string, $time = DateUtil::TIME_NOW, $format = DateUtil::FORMAT_D_M_Y)
    {
        $date = date_create_from_format($format, $date_string);

        if ($time == DateUtil::TIME_FIRST) {
            $date->setTime(0, 0, 0);
        } elseif ($time == DateUtil::TIME_LAST) {
            $date->setTime(23, 59, 59);
        }

        return $date;
    }

}