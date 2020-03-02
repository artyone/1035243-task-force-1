<?php


namespace frontend\formatter;

use frontend\dto\WordFormsDto;


class FeedbacksFormatter
{
    const NACH_PADEG_ED_CHISLO = 'отзыв';
    const ROD_PADEG_ED_CHISLO = 'отзыва';
    const ROD_PADEG_MN_CHISLO = 'отзывов';

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