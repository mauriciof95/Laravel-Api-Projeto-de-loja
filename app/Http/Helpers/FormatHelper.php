<?php
    function dataFormat($arg, $format = 'd/m/Y')
    {
        if(empty($arg)) return '';
        return date($format, strtotime($arg));
    }

    function dinheiroFormat($arg, $mostrarZeroQuandoNull = false)
    {
        if(empty($arg) && ($arg == 0 && !$mostrarZeroQuandoNull)) return '';
        return "R$ " . number_format($arg,2,",",".");
    }


