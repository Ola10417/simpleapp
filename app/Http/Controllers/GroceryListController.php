<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grocery;
use Illuminate\Http\Response;
class GroceryListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Grocery::all()->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $grocery=new Grocery();
        $grocery->name=$request->input('name');
        $grocery->price=$request->input('price');
        $grocery->amount=$request->input('amount');
        $grocery->save();
        //dd($request);
        return response($grocery->jsonSerialize(), Response::HTTP_CREATED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $grocery=Grocery::where('id',$id)->get();
        return response($grocery->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $grocery=Grocery::findOrFail($id);
        $name=$request->input('name');
        $price=$request->input('price');
        $amount=$request->input('amount');
        if($name!=$grocery->name)
        {
            $grocery->name=$name;
        }
        if($price!=$grocery->price)
        {
            $grocery->price=$price;
        }
        if($amount!=$grocery->amount)
        {
            $grocery->amount=$amount;
        }
        $grocery->save();
        return response(null, Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grocery=Grocery::findOrFail($id);
        $grocery->delete();
        return response(null, Response::HTTP_OK);

    }
}
