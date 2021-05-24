<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    use HasFactory;
    protected $fillable=['nombre', 'localidad', 'direccion', 'email'];

    public function trabajadores(){
        return $this->hasMany(Trabajador::class);
    }

    public static function getArrayIdNombre(){
        $tiendas=Tienda::orderBy('nombre')->get();
        $miArray=[];
        foreach($tiendas as $item){
            $miArray[$item->id]=$item->nombre;
        }
        return $miArray;
    }
    //Scopes --------------------------
    public function scopeLocalidad($query, $v){
        if($v!="%"){
            return $query->where('localidad', $v);
        }
        //return $query->where('localidad', 'like', $v);
        return $query->where('localidad', 'like', $v);
    }
}
