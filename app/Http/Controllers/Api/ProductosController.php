<?php

namespace App\Http\Controllers\Api;

use App\Models\Productos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductos;
use App\Http\Controllers\Api\Messages\MessageController;

class ProductosController extends MessageController
{
    public $productos;

    public function __construct()
    {
        $this->productos = new Productos();
    }
    public function index()
    {
        return $this->sendSuccess($this->productos->paginate(10),'Todos los productos');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\StoreProductos  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductos $request)
    {
        $producto = new Productos();
        $producto->fill($request->all());
        $producto->imagen = $producto->storeImagen($request->file('imagen'));
        
        if($producto->save())
        {
            return $this->sendSuccess($this->productos->paginate(10),'Producto Creado Correctamente');
        }else{
            return $this->sendError('¡Error al guardar!', [] , 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function show($producto)
    {
        $producto = Productos::find($producto);

        if($producto)
        {
            return $this->sendSuccess($producto,'Producto Encontrado :)');
        }else{
            return $this->sendError('¡No se encontro ningún producto!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Productos  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$producto)
    {
        $data = Productos::find($producto);

        if(!$data) //se puede hacer está validación por las mismas reglas de validación de laravel, pero me parece mejor de esta forma.
        {
            return $this->sendError('Producto no encontrado :(');
        }

        $request->validate([
            'codigo' => 'required|unique:productos,id,'.$producto,
            'nombre' => 'required|unique:productos,id,'.$producto,
            'descripcion' => 'required|max:255',
            'precio' => 'required',
            'stock' => 'required|integer',
            'imagen' => 'mimes:jpeg,jpg,png,gif|image|max:7000',
        ]);

        $data->fill($request->all());

        if ($request->hasFile('imagen')) {
            $data->imagen = $this->productos->storeImagen($request->file('imagen'));
        }

        if($data->save())
        {
            return $this->sendSuccess($this->productos->paginate(10),'Producto Editado Correctamente');
        }else{
            return $this->sendError('¡Error al guardar!', [] , 401);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Productos  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($producto)
    {
        $data = Productos::find($producto);

        if(!$data)
        {
            return $this->sendError('Producto no encontrado :(');
        }

        if($data->delete())
        {
            return $this->sendSuccess($this->productos->paginate(10),'Producto Eliminado Correctamente');
        }else{
            return $this->sendError('¡Error al guardar!', [] , 401);
        }
    }
}
