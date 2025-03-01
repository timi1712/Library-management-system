<?php

class CategoryController
{
    public function index()
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories();
        $data = ["categories" => $categories];

        // Load the home view with categories
        view("home", $data);
    }
}
