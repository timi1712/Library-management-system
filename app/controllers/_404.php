<?php

class _404
{
    use controller;

    public function index()
    {
        $this->view("errors/404");
    }
}
