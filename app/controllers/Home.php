<?php

class Home
{
    use Controller;
    public function index() {
        $data['content'] = $this->view("home", [], true);
        $this->view("layouts/main", $data);
    }
}
?>