<?php

namespace Idrd\Parques\Repo;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Config as Config;

class Upz extends Eloquent {
	
	protected $table = 'upz';
	protected $primaryKey = 'cod_upz';
	protected $fillable = ['Upz', 'cod_upz'];
	protected $connection = '';
	public $timestamps = false;

	public function __construct()
	{
		$this->connection = config('parques.conexion');
	}

	public function localidad()
	{
		return $this->belongsTo(config('parques.modelo_localidad'), 'IdLocalidad');
	}

	public function parques()
	{
		return $this->hasMany(config('parques.modelo_parque'), 'Upz');
	}

	public function barrios()
	{
		return $this->hasMany(config('parques.modelo_barrio'), 'CodUpz', 'cod_upz');
	}
}