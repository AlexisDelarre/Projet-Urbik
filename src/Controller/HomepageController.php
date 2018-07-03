<?php
/**
 * Created by PhpStorm.
 * User: helorion
 * Date: 03/07/18
 * Time: 15:27
 */

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{

    /**
     * @Route(
     *     path="",
     *     name="homepage"
     * )
     */
    public function index()
    {


        return $this->render('Homepage/homepage.html.twig');
    }


}