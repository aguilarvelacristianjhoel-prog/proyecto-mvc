<?php
require_once ROOT_PATH . '/Models/FacultadModel.php';
class DocenteController extends Controller
{
    private const CATEGORIAS=['AUXILIAR','ASOCIADO','PRINCIPAL'];
    private const DEDICACIONES=['DEDICACION EXCLUSIVA-DE','TIEMPO COMPLETO-TC','TIEMPO PARCIAL-TP'];
    public function index($params=''): void { $this->views->render($this,'index',['filas'=>$this->model->activosConFacultad()]); }
    private function mostrarFormulario($fila=null,array $errores=[]): void
    {
        $facultads=(new FacultadModel())->activos();
        $this->views->render($this,'form',['fila'=>$fila,'errores'=>$errores,'facultads'=>$facultads,'categorias'=>self::CATEGORIAS,'dedicaciones'=>self::DEDICACIONES]);
    }
    public function crear($params=''): void { $this->mostrarFormulario(); }
    public function editar($params=''): void
    {
        $fila=$this->model->obtenerActivo((int)$params);
        if (!$fila) {http_response_code(404);exit('Docente no encontrado');}
        $this->mostrarFormulario($fila);
    }
    private function datosValidados(array &$errores): array
    {
        $datos=[];
        foreach (['dni','apellidos','nombres','correo','categoria','dedicacion'] as $c) $datos[$c]=trim((string)($_POST[$c]??''));
        $datos['id_facultad']=(int)($_POST['id_facultad']??0);
        if (!preg_match('/^[0-9]{8}$/D',$datos['dni'])) $errores[]='DNI: exactamente 8 dígitos.';
        foreach (['apellidos'=>100,'nombres'=>100] as $c=>$max) if ($datos[$c]==='' || mb_strlen($datos[$c])>$max) $errores[]="$c: obligatorio (máx. $max caracteres).";
        if (!filter_var($datos['correo'],FILTER_VALIDATE_EMAIL) || mb_strlen($datos['correo'])>150) $errores[]='Correo inválido.';
        if (!in_array($datos['categoria'],self::CATEGORIAS,true)) $errores[]='Categoría inválido.';
        if (!in_array($datos['dedicacion'],self::DEDICACIONES,true)) $errores[]='Dedicación inválida.';
        if (!(new FacultadModel())->obtenerActivo($datos['id_facultad'])) $errores[]='Selecciona un facultad activo.';
        return $datos;
    }
    public function guardar($params=''): void
    {
        requirePost();$errores=[];$datos=$this->datosValidados($errores);
        if ($errores) {$this->mostrarFormulario($datos,$errores);return;}
        $this->model->crear($datos);redirectTo('Docente');
    }
    public function actualizar($params=''): void
    {
        requirePost();$id=(int)($_POST['id']??0);
        if (!$this->model->obtenerActivo($id)) {http_response_code(404);exit('Docente no encontrado');}
        $errores=[];$datos=$this->datosValidados($errores);
        if ($errores) {$this->mostrarFormulario(array_merge($datos,['id'=>$id]),$errores);return;}
        $this->model->editar($id,$datos);redirectTo('Docente');
    }
    public function eliminar($params=''): void
    {
        requirePost();$id=(int)($_POST['id']??0);
        if ($this->model->obtenerActivo($id)) $this->model->desactivar($id);
        redirectTo('Docente');
    }
}
