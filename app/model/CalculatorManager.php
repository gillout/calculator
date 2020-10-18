<?php


namespace App\Model;

use App\Helper\NumericHelper;
use Exception;
use http\Message;

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
        $this->calc->setResult(Calculator::INIT_VALUE);
        $this->calc->setInput('');
        $this->calc->setAccumulator(Calculator::INIT_VALUE);
        $this->calc->setOperator(Calculator::OPERATOR_INIT_VALUE);
        $this->calc->setState(Calculator::ACCUMULATE_STATE);
    }

    /**
     * Sauvegarde l'opérateur et initialise l'accumulateur
     * @param string $operator
     * @throws Exception
     */
    public function operator(string $operator)
    {
        $this->calc->setInput($this->calc->getAccumulator());
        foreach (CalculatorManager::INPUT_CONTROLS as $key => $value) {
            if ($operator === $key) {
                $this->calc->setOperator($value);
            }
        }
        $this->calc->setAccumulator(Calculator::INIT_VALUE);
    }

    /**
     * Effectue une opération simple (addition, soustraction, multiplication, division)
     * @param $operator
     * @throws Exception
     */
    public function calculate()
    {
        $operator = $this->calc->getOperator();
        $firstOperand = floatval($this->calc->getInput());
        $secondOperand = floatval($this->calc->getAccumulator());
        $result = 0;
        switch ($operator) {
            case Calculator::PLUS:
                $result = $firstOperand + $secondOperand;
                break;
            case Calculator::MINUS:
                $result = $firstOperand - $secondOperand;
                break;
            case Calculator::TIMES:
                $result = $firstOperand * $secondOperand;
                break;
            case Calculator::DIVIDE:
                if ($secondOperand == 0) {
                    throw new Exception('Division par zéro impossible');
                } else {
                    $result = $firstOperand / $secondOperand;
                }
                break;
            default:
        }
        $this->calc->setInput($this->getInput() . $this->calc->getOperator() . $this->calc->getAccumulator());
        $this->calc->setAccumulator(round($result, 8));
    }

}