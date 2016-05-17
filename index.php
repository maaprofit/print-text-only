<?php
include "text-only.class.php";

$text = new TextOnly(48);

$text->addRow("DOCUMENTO NÃO FISCAL");
$text->addRow("CUPOM PARA COZINHA");
$text->addHorizontalLine();
$text->addRow("PEDIDO #247");
$text->addRow("AVENIDA FIORELLI PECCICACCO, 312 - 46° DISTRITO POLICIAL - PERTO DAS COMIDAS ONDE TEM FELICIDADE");
$text->addRow("(11) 94704-0324");
$text->addHorizontalLine();

$tableHeader = array(
  "QTDE" => 6,
  "PRODUTO" => 42
);

$tableContent = array(
  array("01", "FEIJOADA (MARMITEX)"),
  array("01", "TEMAKI DE FRANGO COM CACHORRO QUENTE COM MUITO SHOYO")
);

$text->addTable($tableHeader, $tableContent);

// Save into print.txt
$text->saveFile();
?>
