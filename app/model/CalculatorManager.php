<?php


namespace App\Model;

use App\Helper\NumericHelper;
use Exception;

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
        $this->calc->setOperator(CalculatorManager::INPUT_CONTROLS[$operator]);
        $this->calc->setAccumulator(Calculator::INIT_VALUE);
    }

    /**
     * Effectue une opération simple (addition, soustraction, multiplication, division)
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
                }
                $result = $firstOperand / $secondOperand;
                break;
            default:
                throw new Exception('La fonction n\'est pas encore implémentée');
        }
        $this->calc->setInput($this->getInput() . $this->calc->getOperator() . $this->calc->getAccumulator());
        $this->calc->setAccumulator(round($result, 8));
    }

    /**
     * Effectue le pourcentage du dernier opérande
     */
    public function percentage()
    {
        $result = (floatval($this->calc->getAccumulator())) / 100;
        $this->calc->setAccumulator(round($result, 8));
    }

    /**
     * Ajoute le point à l'accumulateur si celui-ci n'en contient pas déjà un
     * @throws Exception
     */
    public function middot()
    {
        $accumulator = $this->calc->getAccumulator();
        if (is_numeric(strpos($accumulator, '.'))) {
            throw new Exception('L\'accumulateur contient déjà un point');
        }
        $this->calc->setAccumulator($accumulator . '.');
    }

    /**
     * Ajoute le signe moins au début de l'accumulateur s'il n'est pas déjà présent, sinon l'envève
     * Permet de passer d'un nombre négatif à un nombre positif, et vice-versa
     */
    public function plusMinus()
    {
        $accumulator = $this->calc->getAccumulator();
        if ($accumulator == '0') {
            throw new Exception('L\'accumulateur contient zéro');
        }
        if (!is_numeric(strpos($accumulator, '-'))) {
            $this->calc->setAccumulator('-' . $accumulator);
        } else {
            $this->calc->setAccumulator(str_replace('-', '', $accumulator));
        }
    }

}
