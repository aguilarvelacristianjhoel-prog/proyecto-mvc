<?php

class HomeController extends Controller
{
    public function index($params = '')
    {
        $data = [
            'titulo' => 'Proyecto MVC',
            'subtitulo' => 'Gestión de facultades y docentes',
        ];

        $this->views->render($this, 'index', $data);
    }
}
