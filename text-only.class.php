<?php
// TODO: Document it and put it on PSR style
class TextOnly {
    private $maxLength;
    private $fileContent;
    private $headParams;
    private $bottomMargin = 3;

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

    private function filterSpecialCharacters($content)
    {
        $unwanted_array = array(
            'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A',
            'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N',
            'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a',
            'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
            'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y'
        );

        $str = strtr($content, $unwanted_array);
        return $str;
    }

    public function addRow($content, $i = 0)
    {
        // Convert everything to upper
        $content = mb_strtoupper($content);
        $content = $this->filterSpecialCharacters($content);
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

    private function endFile()
    {
        for ($i = 0; $i < $this->bottomMargin; $i++) {
            $this->addRow("");
        }
    }

    public function saveFile($path = "print.txt")
    {
        // End file with bottom margin
        $this->endFile();

        // Save file into specified path
        $handle = fopen($path, "w");
        fwrite($handle, $this->fileContent);
        fclose($handle);
    }
}
