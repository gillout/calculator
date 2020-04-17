<?php


namespace App\Controller;

use App\Model\Calculator;
use App\Model\CalculatorManager;
use Exception;

/**
 * Class AppController
 * @package App\Controller
 */
class AppController
{
    /**
     * @var CalculatorManager
     */
    private $manager;

    /**
     * AppController constructor.
     * @param CalculatorManager $manager
     */
    public function __construct(CalculatorManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transmet les données à la vue
     * @param string $result valeur à afficher dans l'élément result-screen
     * @param string $inputs valeur à afficher dans l'élément input-screens
     */
    private function render(string $result, string $inputs)
    {
        require ROOT . '/app/view/calculator.php';
    }

    /**
     * Affiche la calculette
     */
    public function index()
    {
        $result = $this->manager->getAccumulator();
        $inputs = $this->manager->getInput();
        $this->render($result, $inputs);
    }

    /**
     * Affiche la calculette dans le cas d'une erreur
     * @param string $input le message d'erreur
     */
    public function error(string $input)
    {
        $this->render($this->manager->getAccumulator(), $input);
    }

    /**
     * Ajoute la valeur à l'accumulateur
     * @param string $value valeur numérique
     * @throws Exception
     */
    public function accumulate(string $value)
    {
        try {
            $this->manager->append($value);
            $chaine = $this->manager->getAccumulator();
            $this->index($chaine);
        } catch(Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Lance une action (opération, égal, pourcentage, ...)
     * @param string $action
     */
    public function action(string $action)
    {
        switch($action) {
            case 'clear';
                $this->manager->reset();
                break;
            default;
        }
        $this->index();
    }
}