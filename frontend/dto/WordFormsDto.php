<?php


namespace frontend\dto;


class WordFormsDto
{
    private $nachPadegEdChislo;
    private $rodPadegEdChislo;
    private $rodPadegMnChislo;

    public function __construct(string $nachPadegEdChislo, string $rodPadegEdChislo, string $rodPadegMnChislo)
    {
        $this->nachPadegEdChislo = $nachPadegEdChislo;
        $this->rodPadegEdChislo = $rodPadegEdChislo;
        $this->rodPadegMnChislo = $rodPadegMnChislo;
    }

    public function getNachPadegEdChislo()
    {
        return $this->nachPadegEdChislo;
    }

    public function getRodPadegEdChislo()
    {
        return $this->rodPadegEdChislo;
    }

    public function getRodPadegMnChislo()
    {
        return $this->rodPadegMnChislo;
    }

}