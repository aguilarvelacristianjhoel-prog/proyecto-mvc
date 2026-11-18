<?php
class FacultadController extends Controller
{
    public function index($params=''): void { $this->views->render($this,'index',['filas'=>$this->model->activos()]); }
    public function crear($params=''): void { $this->views->render($this,'form',['fila'=>null,'errores'=>[]]); }
    public function guardar($params=''): void
    {
        requirePost();
        $nombre=trim((string)($_POST['nombre']??''));$abreviatura=trim((string)($_POST['abreviatura']??''));
        $errores=[];
        if ($nombre==='' || mb_strlen($nombre)>120) $errores[]='Nombre obligatorio (máx. 120 caracteres).';
        if ($abreviatura==='' || mb_strlen($abreviatura)>20) $errores[]='Abreviatura obligatorio (máx. 20 caracteres).';
        if ($errores) { $this->views->render($this,'form',['fila'=>['nombre'=>$nombre,'abreviatura'=>$abreviatura],'errores'=>$errores]);return; }
        $this->model->crear($nombre,$abreviatura);redirectTo('Facultad');
    }
    public function editar($params=''): void
    {
        $fila=$this->model->obtenerActivo((int)$params);
        if (!$fila) {http_response_code(404);exit('Facultad no encontrado');}
        $this->views->render($this,'form',['fila'=>$fila,'errores'=>[]]);
    }
    public function actualizar($params=''): void
    {
        requirePost();$id=(int)($_POST['id']??0);$fila=$this->model->obtenerActivo($id);
        if (!$fila) {http_response_code(404);exit('Facultad no encontrado');}
        $nombre=trim((string)($_POST['nombre']??''));$abreviatura=trim((string)($_POST['abreviatura']??''));$errores=[];
        if ($nombre==='' || mb_strlen($nombre)>120) $errores[]='Nombre obligatorio (máx. 120 caracteres).';
        if ($abreviatura==='' || mb_strlen($abreviatura)>20) $errores[]='Abreviatura obligatorio (máx. 20 caracteres).';
        if ($errores) {$this->views->render($this,'form',['fila'=>['id'=>$id,'nombre'=>$nombre,'abreviatura'=>$abreviatura],'errores'=>$errores]);return;}
        $this->model->editar($id,$nombre,$abreviatura);redirectTo('Facultad');
    }
    public function eliminar($params=''): void
    {
        requirePost();$id=(int)($_POST['id']??0);
        if ($this->model->obtenerActivo($id)) $this->model->desactivar($id);
        redirectTo('Facultad');
    }
}
