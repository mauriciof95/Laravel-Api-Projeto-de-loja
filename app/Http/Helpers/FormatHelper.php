<?php
    function dinheiroFormat($arg, $mostrarZeroQuandoNull = false)
    {
        if(empty($arg) && ($arg == 0 && !$mostrarZeroQuandoNull)) return '';
        return "R$ " . number_format($arg,2,",",".");
    }


