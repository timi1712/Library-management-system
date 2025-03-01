<?php

class Category extends Model
{
    protected $table = "categories";

    public function getAllCategories()
    {
        return $this->findAll();
    }
}
