<?php
/**
 * Zend Framework Brasil
 *
 * @category  Zfb
 * @package   Zfb_Validate
 * @version   $Id$
 */

require_once 'Zend/Validate/Abstract.php';

/**
 * Validador para fazer a valida��o de CNPJ (Cadastro de Pessoas Juridicas)
 *
 * @category Zfb
 * @package  Zfb_Validate
 * @uses     Zend_Validate_Abstract
 * @author   Diego Tremper <diegotremper@gmail.com>
 */
class Zfb_Validate_Cnpj extends Zend_Validate_Abstract
{
    const INVALID_DIGITS = 'i_number';

    const INVALID_FORMAT = 'i_format';

    protected $_messageTemplates = array (
                    self::INVALID_DIGITS => "O CNPJ '%value%' não é válido",
                    self::INVALID_FORMAT => "O formato do CNPJ '%value%' não é válido"
              );

    private $_pattern = '/(\d{2})\.(\d{3})\.(\d{3})\/(\d{4})-(\d{2})/i';

    private $_skipFormat = false;

    /**
     * Inicializa a inst�ncia do validador
     *
     * @param bool $skipFormat ignorar valida��o no formato?
     */
    public function __construct($skipFormat = false)
    {
        $this->_skipFormat = $skipFormat;
    }

    /**
     * verifica se o cnpj � v�lido
     *
     * @param string $value cnpj a ser validado
     * @return bool
     */
    public function isValid($value)
    {
        $this->_setValue ( $value );

        if (!$this->_skipFormat && preg_match($this->_pattern, $value) == false) {
            $this->_error(self::INVALID_FORMAT);
            return false;
        }

        $digits = preg_replace('/[^\d]+/i', '', $value);
        $firstSum = 0;
        $secondSum = 0;

        $firstSum += (5*$digits{0}) + (4*$digits{1}) + (3*$digits{2}) + (2*$digits{3});
        $firstSum += (9*$digits{4}) + (8*$digits{5}) + (7*$digits{6}) + (6*$digits{7});
        $firstSum += (5*$digits{8}) + (4*$digits{9}) + (3*$digits{10}) + (2*$digits{11});

        $firstDigit = 11 - fmod($firstSum, 11);

        if ($firstDigit>= 10) {
            $firstDigit = 0;
        }

        $secondSum += (6*$digits{0}) + (5*$digits{1}) + (4*$digits{2}) + (3*$digits{3});
        $secondSum += (2*$digits{4}) + (9*$digits{5}) + (8*$digits{6}) + (7*$digits{7});
        $secondSum += (6*$digits{8}) + (5*$digits{9}) + (4*$digits{10}) + (3*$digits{11});
        $secondSum += ($firstDigit*2);

        $secondDigit = 11 - fmod($secondSum, 11);

        if ($secondDigit>= 10) {
            $secondDigit = 0;
        }

        if (substr($digits, -2) != ($firstDigit . $secondDigit)) {
            $this->_error(self::INVALID_DIGITS);
            return false;
        }

        return true;
    }
}