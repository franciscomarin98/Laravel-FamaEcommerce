<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Foto;
use App\Marca;
use App\Producto;
use App\SubCategoria;
use App\Submarca;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos = Producto::with('categoria', 'marca', 'fotos')
            ->join('subcategoria', 'subcategoria.categoria_id', '=', 'productos.categoria_id')
            ->join('subcategoria2', 'subcategoria.id', '=', 'subcategoria2.subcategoria_id')->get();

        //  return $datos;
        return view('AdminLTE\Productos\index', compact('datos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marcas = SubCategoria::all();
        $categorias = Categoria::all();
        $subcat = Marca::all();
        $subcat1 = Submarca::all();
        return view('AdminLTE\Productos\create', compact('marcas', 'categorias', 'subcat', 'subcat1'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return $request;
        $this->validate($request, ['nombre' => 'required',
            'descripcion' => 'required',
            'codigo' => 'required',
            'fecha' => 'required',
            'categoria' => 'required',
            'marca' => 'required',
            'precio' => 'required',
            'imagenes' => 'required',
            'subcategoria' => 'required',
            'subcategoria1' => 'required',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $producto = new Producto();
        $producto->nombre_producto = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->codigo_unico = $request->codigo;
        $producto->precio = $request->precio;
        $producto->publicado = Carbon::parse($request->fecha);
        $producto->categoria_id = Categoria::find($cat = $request->categoria) ? $cat : Categoria::create(['nombre_categoria' => $cat])->id;
        $producto->subcategoria_id = SubCategoria::find($sub = $request->marca) ? $sub : SubCategoria::create(['nombre_sub' => $sub])->id;
        $producto->save();
        foreach ($request->file('imagenes') as $foto) {
            $fotos = new Foto();
            $fotos->producto_id = $producto->id;
            $fotos->url = $foto->store('product_img');
            $fotos->save();
            $optima = Image::make(Storage::get($fotos->url));
            $optima->widen(600)->encode();
            Storage::put($fotos->url, (string) $optima);
        }
        $y = Marca::find($marca = $request->subcategoria) ? $marca : $y = Marca::create(['nombre_marca' => $marca, 'categoria_id' => $producto->categoria_id])->id;
        Submarca::find($smarca = $request->subcategoria1) ? $smarca : Submarca::create(['nombre_submarca' => $smarca, 'marca_id' => $y])->id;
        return back()->with('success', 'El producto ha sido registrado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        $marcas = SubCategoria::all();
        $categorias = Categoria::all();
        $subcat = Marca::all();
        $subcat1 = Submarca::all();

        $editado = Producto::with('categoria', 'subcategoria', 'fotos')->find($producto->id);
        // return $editado;
        return view('AdminLTE\Productos\edit', compact('editado', 'marcas', 'categorias', 'subcat', 'subcat1'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $this->validate($request, ['nombre' => 'required',
            'descripcion' => 'required',
            'codigo' => 'required',
            'fecha' => 'required',
            'categoria' => 'required',
            'marca' => 'required',
            'precio' => 'required',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($request->file('imagenes')) {
            foreach ($request->file('imagenes') as $foto) {
                $fotos = new Foto();
                $fotos->producto_id = $producto->id;
                $fotos->url = $foto->store('product_img');
                $fotos->save();
                $optima = Image::make(Storage::get($fotos->url));
                $optima->widen(600)->encode();
                Storage::put($fotos->url, (string) $optima);
            }
        }
        $producto->nombre_producto = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->codigo_unico = $request->codigo;
        $producto->precio = $request->precio;
        $producto->publicado = Carbon::parse($request->fecha);
        $producto->categoria_id = Categoria::find($cat = $request->categoria) ? $cat : Categoria::create(['nombre_categoria' => $cat])->id;
        $producto->subcategoria_id = SubCategoria::find($sub = $request->marca) ? $sub : SubCategoria::create(['nombre_sub' => $sub])->id;
        $producto->save();
        return back()->with('success', 'El producto ha sido actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return back();
    }
}
