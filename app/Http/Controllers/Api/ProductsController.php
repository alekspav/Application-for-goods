<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OrderProduct;

class ProductsController extends Controller
{
    /**
     * Получить все продукты
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Коллекция
     */
    public function index()
    {
        return ProductResource::collection(Product::with('vendor')->orderBy('name', 'asc')->paginate(25));
    }

    /**
     * Получить продукты по идентификатору заказа
     *
     * @param $order_id Идентификатор заказа
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection Коллекция
     */
    public function getOrderProduct($order_id)
    {
        return ProductResource::collection(OrderProduct::with('product')->where(['order_id' => $order_id])->get());
    }


    /**
     * Создать продукт
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $Product = Product::create($request->all());
        return $Product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::findOrFail($id);
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
        $Product = Product::findOrFail($id);
        $Product->update($request->all());

        return $Product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Product = Product::findOrFail($id);
        $Product->delete();
        return '';
    }
}
