<?php

namespace App\View\Components;

use Illuminate\View\Component;

class cardProducto extends Component
{

    public $nombreProducto;
    public $idProducto;
    public $precio;
    public $descuento;
    public $stock;
    public $totalLikes;
    public $imagenDefault;

    public function __construct($nombreProducto, $idProducto, $precio, $descuento, $stock, $totalLikes, $imagenDefault)
    {
        $this->nombreProducto = $nombreProducto;
        $this->idProducto = $idProducto;
        $this->precio = $precio;
        $this->descuento = $descuento;
        $this->stock = $stock;
        $this->totalLikes = $totalLikes;
        $this->imagenDefault = $imagenDefault;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cards.cardProducto');
    }
}
