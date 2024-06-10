<?php

$memoryLimit = ini_get('memory_limit');
if (strtolower($memoryLimit) === '256m' || intval($memoryLimit) < 256 * 1024 * 1024) {
    throw new Exception('Erreur : La valeur de memory_limit est inférieure à 256M');
}
