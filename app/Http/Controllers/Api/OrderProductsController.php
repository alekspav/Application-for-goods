<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OrderProduct;
use App\Http\Resources\OrderProductResource;

class OrderProductsController extends Controller
{

    /**
     * Получить продукты по идентификатору заказа
     *
     * @param $order_id Идентификатор заказа
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Коллекция
     */
    public function getOrderProduct($order_id)
    {
        return OrderProductResource::collection(OrderProduct::with('Product')->where(['order_id' => $order_id])->get());
    }


    /**
     * Создать продукт
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $OrderProduct = OrderProduct::create($request->all());
        return $OrderProduct;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return OrderProduct::findOrFail($id);
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
        $OrderProduct = OrderProduct::findOrFail($id);
        $OrderProduct->update($request->all());

        return $OrderProduct;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $OrderProduct = OrderProduct::findOrFail($id);
        $OrderProduct->delete();
        return '';
    }
}
