<?php


namespace frontend\formatter;

use frontend\dto\WordFormsDto;


class YearFormatter
{
    const NACH_PADEG_ED_CHISLO = 'год';
    const ROD_PADEG_ED_CHISLO = 'года';
    const ROD_PADEG_MN_CHISLO = 'лет';

    private $wordFormsDto;
    private $num;

    public function __construct($num)
    {
        $this->wordFormsDto = new WordFormsDto(self::NACH_PADEG_ED_CHISLO, self::ROD_PADEG_ED_CHISLO, self::ROD_PADEG_MN_CHISLO);
        $this->num = $num;
    }

    public function getWordForm(): string
    {
        $formatter = new PluralizeFormatter($this->num, $this->wordFormsDto);
        return $formatter->getWordPluralize();
    }
}