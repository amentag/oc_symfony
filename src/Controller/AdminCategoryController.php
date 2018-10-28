<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminCategoryController
 * @package App\Controller
 *
 * @Route("/admin/category")
 */
class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/new", name="admin_category")
     */
    public function new(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // todo : save category
            dd($category);
        }

        return $this->render('admin_category/new.html.twig', [
            'controller_name' => 'AdminCategoryController',
            'form' => $form->createView(),
        ]);
    }
}
