<?php


namespace frontend\formatter;


/**
 * Класс для получения склонений существительных в зависимости от числительного перед ними
 * Class PluralizeFormatter
 * @package frontend\formatter
 */
class PluralizeFormatter
{
    private $wordFormsDto;
    private $num;

    public function __construct($num, $wordFormsDto)
    {
        $this->wordFormsDto = $wordFormsDto;
        $this->num = $num;

    }

    /**
     * Метод вычисления склонения слова в зависимости от числительного перед ним
     * @return string
     */
    public function getWordPluralize(): string
    {

        if ($this->num % 100 >= 11 && $this->num % 100 <= 19) {
            $string = $this->wordFormsDto->getRodPadegMnChislo();
        } else {
            switch ($this->num % 10) {
                case (1):
                    $string = $this->wordFormsDto->getNachPadegEdChislo();
                    break;
                case (2):
                case (3):
                case (4):
                    $string = $this->wordFormsDto->getRodPadegEdChislo();
                    break;
                default:
                    $string = $this->wordFormsDto->getRodPadegMnChislo();
            }
        }
        return "$this->num $string";
    }
}