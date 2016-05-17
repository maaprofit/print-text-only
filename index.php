<?php
include "text-only.class.php";

$text = new TextOnly(48);

$text->addRow("DOCUMENTO NÃO FISCAL");
$text->addRow("CUPOM DE TESTE");
$text->addHorizontalLine();
$text->addRow("PEDIDO #123");
$text->addRow("RUA DA AVENIDA, 123");
$text->addRow("(13) 3333-3333");
$text->addHorizontalLine();

$tableHeader = array(
  "QTDE" => 6,
  "PRODUTO" => 42
);

$tableContent = array(
  array("01", "ARROZ E FEIJOADA")
);

$text->addTable($tableHeader, $tableContent);

// Save into print.txt
$text->saveFile();
?>
