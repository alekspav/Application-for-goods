<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OrderResource::collection(Order::with('partner')->paginate(25));
    }

    /**
     * Получить заказ по области видимости
     *
     * @param $scopeType Тип области
     */
    public function getScopedOrders($scopeType)
    {
        if ($scopeType == 0) {
            return OrderResource::collection(Order::with('partner')->back()->get());
        } else if ($scopeType == 1) {
            return OrderResource::collection(Order::with('partner')->actual()->get());
        } else if ($scopeType == 2) {
            return OrderResource::collection(Order::with('partner')->new()->get());
        } else if ($scopeType == 3) {
            return OrderResource::collection(Order::with('partner')->success()->get());
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Order = Order::create($request->all());
        return $Order;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Order = Order::findOrFail($id);
        $Order->update($request->all());

        return $Order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Order = Order::findOrFail($id);
        $Order->delete();
        return '';
    }
}
