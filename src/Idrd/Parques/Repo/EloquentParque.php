<?php 

namespace Idrd\Parques\Repo;

use Idrd\Parques\Repo\ParqueInterface;

class EloquentParque implements ParqueInterface {

	private $app;
	private $model;

	public function __construct($app)
	{
		$this->app = $app ?: app();
	}

	public function buscar($key)
	{
		$model = $this->model();

		return $model->with('upz', 'localidad', 'tipo', 'dotaciones')->whereRaw('CONCAT (Nombre, " ", Id_IDRD) LIKE "%'.$key.'%"', array())
					->orderBy('Nombre', 'asc')
					->get();
	}

	public function todos()
	{
		$model = $this->model();
		return $model->with('upz', 'localidad', 'tipo', 'dotaciones')
					->orderBy('Nombre', 'asc')
					->get();
	}

	public function grandesEscenarios()
	{
		$model = $this->model();
		return $model->with('upz', 'localidad', 'tipo', 'dotaciones')
					->whereIn('Id', array('10765','15586','15449','15584','8449','9478','9936','10114','15440','15565'))
					->orderBy('Nombre', 'asc')
					->get();
	}

	public function obtener($id_parque)
	{
		$model = $this->model();
		return $model->with('upz', 'localidad', 'tipo', 'dotaciones')
					->find($id_parque);
	}

	public function obtenerPorTipo($id_tipo){
		$model = $this->model();
		return $model->with('upz', 'localidad', 'tipo', 'dotaciones')
					->where('Id_Tipo', $id_tipo)
					->get();
	}

	private function model()
	{
		$this->model = $this->app['config']->get('parques.modelo_parque');
		if ($this->model)
			return $this->app[$this->model];
		
		throw new \Exception("No se encuentra el modelo especificado en config/parques.php", 639);
	}
}