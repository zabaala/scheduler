<?php
namespace App\Support;

class Cpf
{
    /**
     * Numero do cpf a ser retornado.
     * @var string
     */
    protected $cpf;

    /**
     * Primeiro algaritimo do novo dígito verificador.
     * @var mixed
     */
    protected $dv1;

    /**
     * Segundo algaritimo do novo dígito verificador.
     * @var mixed
     */
    protected $dv2;

    /**
     * Verifica se a requisição é de validação ou criação de um CPF.
     * @var boolean
     */
    protected $isValidation = false;

    /**
     * Método construtor.
     * @param string $cpf
     * @throws \Exception
     */
    public function __construct($cpf = '')
    {
        $this->cpf = str_pad($cpf, 11, '0');
    }

    /**
     * Retorna o CPF quando a descrição da classe for requisitada.
     * @return string
     */
    public function __toString()
    {
        return $this->get();
    }

    /**
     * Considerando que o CPF é composto por 3 blocos de
     * 3 digitos, separados por um ponto(.) e complementados por
     * um dígito verificador, este método gera números randômicos para
     * cada bloco de um CPF, caso o objetivo seja criar CPFs dinâmicos.
     *
     * @param  integer $digitos
     * @return int
     */
    private function generateBlock($digitos = 3)
    {
        $bloco = '';
        for ($i=0; $i < $digitos; $i++) {
            $bloco .= mt_rand(0, $digitos);
        }
        return $bloco;
    }

    /**
     * Cria os primeiros nove dígitos do CPF.
     *
     * @return string
     */
    private function generateFakeBlocks()
    {

        if (! empty($this->cpf)) {
            return $this->cpf;
        }
        $this->cpf = sprintf(
            '%s.%s.%s',
            $this->generateBlock(),
            $this->generateBlock(),
            $this->generateBlock()
        );
        return $this->cpf;
    }

    /**
     * Cria o primeiro algaritimo do digito verificador,
     * Baseado no CPF disponível para cálculo.
     *
     * @return integer
     */
    private function calculateDv1()
    {
        if (!empty($this->dv1)) {
            return $this->dv1;
        }
        $cpf = $this->clean();
        for ($i=0, $j=10; $i<9; $i++, $j--) {
            $arr[$i] = $cpf{$i} * $j;
        }
        $s = array_sum($arr);
        $r = $s % 11;
        if ($r<2) {
            $dv = 0;
        } else {
            $dv = 11 - $r;
        }
        return $this->dv1 = $dv;
    }

    /**
     * Cria o segundo algaritimo do digito verificador,
     * Baseado no CPF disponível para cálculo.
     *
     * @return integer
     */
    private function calculateDv2()
    {

        $cpf = $this->clean() . $this->calculateDv1();

        for ($i=0, $j=11; $i<10; $i++, $j--) {
            $arr[$i] = (int)substr($cpf, $i, 1) * $j;
        }
        $s = array_sum($arr);
        $r = $s % 11;
        if ($r < 2) {
            $dv = 0;
        } else {
            $dv = 11 - $r;
        }
        return $this->dv2 = $dv;
    }

    /**
     * Compoe o CPF com 3 blocos e dígito verificador e dois algarismos.
     * @return string
     */
    private function compose()
    {
        if ($this->isValidation) {
            $this->cpf = substr($this->cpf, 0, strlen($this->cpf)-2);
        }
        return sprintf(
            '%s-%u%u',
            $this->generateFakeBlocks(),
            $this->calculateDv1(),
            $this->calculateDv2()
        );
    }

    /**
     * Cria dinamicamente um número de CPF válido.
     *
     * @return string
     */
    public function create()
    {
        return $this->cpf = $this->compose();
    }

    /**
     * Retorna o cpf.
     *
     * @return string
     */
    public function get()
    {
        return $this->cpf;
    }

    /**
     * Remove caracteres especiais da string, deixando somente números.
     * @param  string $str
     * @return string
     */
    private function cleanify($str)
    {
        return preg_replace('/[^0-9]/ism', '', $str);
    }

    /**
     * Remove caracteres especiais do CPF.
     * @return string
     */
    public function clean()
    {
        return $this->cleanify($this->cpf);
    }

    /**
     * Efetua a validação de um número de CPF.
     * @return bool
     */
    public function validate()
    {
        $this->isValidation = true;
        $tmpCpf   = $this->cleanify($this->cpf);

        if (! is_numeric($tmpCpf)) {
            return false;
        }

        $testCpf  = $this->create();
        return $this->cleanify($tmpCpf) == $this->cleanify($testCpf);
    }
}
