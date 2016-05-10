<?php
include "text-only-class.php";

$text = new TextOnly(50);

$text->addRow("DOCUMENTO NÃO FISCAL");
$text->addRow("CUPOM PARA COZINHA");
$text->addHorizontalLine();
$text->addRow("PEDIDO #247");
$text->addRow("RUA CARCINO, 135");
$text->addRow("(11) 94704-0324");
$text->addHorizontalLine();

$tableHeader = array(
  "QTDE" => 6,
  "PRODUTO" => 44
);

$tableContent = array(
  array("01", "FEIJOADA (MARMITEX)"),
  array("01", "COMIDA JAPONESA COM MUITO MOLHO SHOYO (MEIA MARMITA)")
);

$text->addTable($tableHeader, $tableContent);

// Save into print.txt
$text->saveFile();
?>
