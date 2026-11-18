<?php
class DocenteModel extends Model
{
    protected $table = 'docente';
    // La relación se consulta desde la capa de modelo, nunca desde la vista.
    public function activosConFacultad(): array
    {
        return $this->select('docente.*, facultad.nombre AS facultad_nombre')
          ->joinFacultad()->where(['docente.estado = 1'])->orderBy('docente.apellidos')->get();
    }
    public function joinFacultad(): self
    {
        $this->joins[] = 'INNER JOIN facultad ON facultad.id = docente.id_facultad';
        return $this;
    }
    public function obtenerActivo(int $id) { $fila=$this->find($id); return $fila && (int)$fila['estado'] === 1 ? $fila : null; }
    public function crear(array $campos): bool { $campos['estado']=1; return $this->insert($campos); }
    public function editar(int $id,array $campos): bool { return $this->update($id,$campos); }
    public function desactivar(int $id): bool { return $this->update($id,['estado'=>0]); }
}
