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
        $content = mb_strtoupper($content);
        $rowContent = substr($content, ($this->maxLength * $i), $this->maxLength);

        $contentLength = strlen($rowContent) % 2;
        $padded  = ($contentLength > 0) ? " " : "";
        $padded .= str_pad($rowContent, $this->maxLength, " ", STR_PAD_BOTH);

        $this->fileContent .= ($padded . "\n");

        if ((strlen($content) - ($this->maxLength * $i)) > $this->maxLength) {
            $this->addRow($content, ($i + 1));
        }
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
                if (strlen($name) < $spaces) {
                    $name = str_pad($name, $spaces, " ", STR_PAD_RIGHT);
                }

                $head .= $name;
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

    public function saveFile($path = "print.txt")
    {
        $handle = fopen($path, "w");
        fwrite($handle, $this->fileContent);
        fclose($handle);
    }
}
