<?php


namespace App\Model;


use Exception;

/**
 * Class Calculator
 * @package App\Model
 *  Un calculatrice pour fonctionner doit disposer :
 *
 * - d'un accumulateur qui, par concaténation des différentes saisies utilisateur permet d'obtenir un nouvel opérande
 * - d'un opérateur pour le calcul courant (+, -, x, ...)
 * - d'un résultat qui représente la première opérande de l'opération en cours
 * - d'un historique des opérations effectuées.
 */
class Calculator
{
    public const ACCUMULATE_STATE = 0;
    public const RESULT_STATE = 1;
    public const INIT_VALUE = '0';
    public const PERCENT = '/100';
    public const DIVIDE = '/';
    public const TIMES = 'x';
    public const MINUS = '-';
    public const PLUS = '+';
    public const OPERATOR_INIT_VALUE = null;

    /**
     * Calculator constructor.
     */
    public function __construct()
    {
        if (!array_key_exists('result', $_SESSION)) {
            $_SESSION['result'] = self::INIT_VALUE;
        }
        if (!array_key_exists('input', $_SESSION)) {
            $_SESSION['input'] = '';
        }
        if (!array_key_exists('accumulator', $_SESSION)) {
            $_SESSION['accumulator'] = self::INIT_VALUE;
        }
        if (!array_key_exists('operator', $_SESSION)) {
            $_SESSION['operator'] = self::OPERATOR_INIT_VALUE;
        }
        if (!array_key_exists('state', $_SESSION)) {
            $this->setState(Calculator::ACCUMULATE_STATE);
        }
    }

    /**
     * Renvoie le résultat de la calculette
     * @return string
     */
    public function getResult(): string
    {
        return $_SESSION['result'];
    }

    /**
     * @param int|double $result
     * @throws Exception
     */
    public function setResult($result)
    {
        if (is_numeric($result)) {
            $_SESSION['result'] = $result;
        } else {
            throw new Exception('## Erreur : le résultat doit être une valeur numérique ##');
        }
    }

    /**
     * Renvoie l'historique des opérations effectuées
     * @return string l'ensemble des opérations effectuées
     */
    public function getInput(): string
    {
        return $_SESSION['input'];
    }

    /**
     * Définit l'historique des opérations
     * @param string $input
     */
    public function setInput(string $input)
    {
        $_SESSION['input'] = $input;
    }

    /**
     * Renvoie la valeur de l'accumulateur
     * @return string l'opération courante
     */
    public function getAccumulator(): string
    {
        return $_SESSION['accumulator'];
    }

    /**
     * Définit l'accumulateur
     * @param string $current la nouvelle valeur de l'accumulateur
     * @throws Exception
     */
    public function setAccumulator(string $current)
    {
        if (is_numeric($current)) {
            $_SESSION['accumulator'] = $current;
        } else {
            throw new Exception('## Erreur : une valeur non numérique a été soumise à l\'accumulateur ##');
        }
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $_SESSION['state'];
    }

    /**
     * @param string $state
     */
    public function setState(string $state)
    {
        $_SESSION['state'] = $state;
    }

    /**
     * Renvoie l'opérateur courant
     * @return string
     */
    public function getOperator(): ?string
    {
        return $_SESSION['operator'];
    }

    /**
     * Définit l'opérateur courant
     * @param string $operator
     * @throws Exception
     */
    public function setOperator(?string $operator)
    {
        $_SESSION['operator'] = $operator;
    }
}