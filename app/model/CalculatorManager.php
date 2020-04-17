<?php


namespace App\Model;

use App\Helper\NumericHelper;
use Exception;
use const http\Client\Curl\Versions\CURL;

/**
 * Classe CalculatorManager, pilote la calculatrice.
 *
 *
 * De plus, la classe doit disposer de différentes méthodes permettant d'effectuer les opérations
 *
 * @package App\Model
 */
class CalculatorManager
{
    const INPUT_CONTROLS = [
        'divide' => Calculator::DIVIDE,
        'times' => Calculator::TIMES,
        'minus' => Calculator::MINUS,
        'plus' => Calculator::PLUS
    ];

    private $calc;

    /**
     * CalculatorManager constructor.
     * @param $calc
     */
    public function __construct(Calculator $calc)
    {
        $this->calc = $calc;
    }

    /**
     * @return bool
     */
    public function isAccumulateState(): bool
    {
        return $this->calc->getState() == strval(Calculator::ACCUMULATE_STATE);
    }

    /**
     * @return bool
     */
    public function isResultState(): bool
    {
        return $this->calc->getState() === strval(Calculator::RESULT_STATE);
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->calc->getResult();
    }

    /**
     * @return string
     */
    public function getInput(): string
    {
        return $this->calc->getInput();
    }

    /**
     * @return string
     */
    public function getAccumulator(): string
    {
        return $this->calc->getAccumulator();
    }

    /**
     * Concatène les chiffres (string) dans l'accumulateur
     * @param $value
     * @throws Exception
     */
    public function append(string $value)
    {
        $before = $this->calc->getAccumulator();
        if ($before == '0') {
            $before = '';
        }
        $after = $before . $value;
        $this->calc->setAccumulator($after);
    }

    /**
     * Réinitialise la calculatrice
     * @throws Exception
     */
    public function reset()
    {
        $this->calc->setResult(Calculator::RESULT_STATE);
        $this->calc->setInput('');
        $this->calc->setAccumulator(Calculator::INIT_VALUE);
        $this->calc->setOperator(Calculator::OPERATOR_INIT_VALUE);
        $this->calc->setState(Calculator::ACCUMULATE_STATE);
    }

}