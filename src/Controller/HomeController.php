<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;


use App\Model\AttributeManager;
use App\Model\CardManager;
use App\Model\WitchAttributeManager;
use App\Model\WitchManager;
class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $witchManager = new WitchManager();
        $witches = $witchManager->selectAll();
        $attributeManager = new AttributeManager();
        $attributes = $attributeManager->selectAll();

        return $this->twig->render('/Home/index.html.twig', [
            'witches' => $witches,
            'attributes' => $attributes,
        ]);
        header('Location: /');
    }

    public function add()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $witchManager = new WitchManager();
            $witch = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],

            ];
            $witchAttributeManager = new WitchAttributeManager();
            $attributes = $_POST['attribute'];
            $idwitch = ($witchManager->insert($witch));
            foreach ($attributes as $attribute) {
                $witchAttributeManager->insertAttribute($attribute, $idwitch);
            }
            header('Location: /');
        }
    }
    public function addlike()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $witchid = $_POST['id'];
            $cardManager = new CardManager('witch');
            $cardManager->addLike($witchid);
        }
        header('location:/#vote');
    }
    public function deletelike()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $witchid = $_POST['id'];
            $cardManager = new CardManager('witch');
            $cardManager->deleteLike($witchid);
        }
        header('location:/#vote');
    }
}
