<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    public function index()
    {
        return Order::all();
    }

    public function show($id)
    {
        return Order::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $Order = Order::findOrFail($id);
        $Order->update($request->all());

        return $Order;
    }

    public function store(Request $request)
    {
        $Order = Order::create($request->all());
        return $Order;
    }

    public function destroy($id)
    {
        $Order = Order::findOrFail($id);
        $Order->delete();
        return '';
    }
}
