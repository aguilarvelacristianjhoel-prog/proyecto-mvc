<?php
class FacultadModel extends Model
{
    protected $table = 'facultad';
    public function activos(): array { return $this->where(['estado = 1'])->orderBy('nombre')->get(); }
    public function obtenerActivo(int $id) { $fila = $this->find($id); return $fila && (int)$fila['estado'] === 1 ? $fila : null; }
    public function crear(string $nombre,string $abreviatura): bool { return $this->insert(['nombre'=>$nombre,'abreviatura'=>$abreviatura,'estado'=>1]); }
    public function editar(int $id,string $nombre,string $abreviatura): bool { return $this->update($id,['nombre'=>$nombre,'abreviatura'=>$abreviatura]); }
    public function desactivar(int $id): bool { return $this->update($id,['estado'=>0]); }
}
