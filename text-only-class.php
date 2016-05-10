<?php
// TODO: Document it and put it on PSR style
class TextOnly {
    private $maxLength;
    private $fileContent;
    private $headParams;

    public function __construct($maxLength)
    {
        $this->maxLength = $maxLength;
        return $this->initiateFile();
    }

    private function initiateFile()
    {
        $this->fileContent = "";
        return $this->fileContent;
    }

    public function addRow($content)
    {
        $contentLength = strlen($content) % 2;
        $padded  = ($contentLength > 0) ? " " : "";
        $padded .= str_pad($content, $this->maxLength, " ", STR_PAD_BOTH);

        $this->fileContent .= ($padded . "\n");
    }

    public function addHorizontalLine()
    {
        $this->fileContent .= str_pad("", $this->maxLength, "-") . "\n";
    }

    private function getTableIterateNumber($tableRow)
    {
        $maxCount = 0;
        foreach ($tableRow as $key => $row) {
            $spaces = $this->headParams[$key];
            $iteration = ceil(strlen($row) / $spaces);

            if ($iteration > $maxCount) {
                $maxCount = $iteration;
            }
        }

        return $maxCount;
    }

    public function addTable($header, $content)
    {
        $head = "";
        $this->headParams = array();

        if (!empty($header) && is_array($header)) {
            foreach ($header as $name => $spaces) {
                $head .= str_pad($name, $spaces);
                $this->headParams[] = $spaces;
            }

            $this->addRow($head);
        }

        if (!empty($content) && !empty($this->headParams)) {
            $rowsToAdd = array();
            foreach ($content as $row => $rows) {
                $done = false;
                $iterateUntil = $this->getTableIterateNumber($rows);

                for ($i = 0; $i < $iterateUntil; $i++) {
                    $_content = "";
                    foreach ($rows as $key => $item) {
                        $spaces = $this->headParams[$key];
                        $initial = $spaces * $i;

                        $_content .= str_pad(
                            substr($item, $initial, $spaces),
                            $spaces
                        );
                    }

                    $this->addRow($_content);
                }
            }
        }
    }

    public function saveFile()
    {
        $handle = fopen("print.txt", "w");
        fwrite($handle, $this->fileContent);
        fclose($handle);
    }
}
