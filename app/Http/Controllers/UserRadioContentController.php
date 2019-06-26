<?php

namespace App\Http\Controllers;

use App\Models\Radio;
use App\Repositories\Promotions\PromotionAnswer;
use App\Repositories\Promotions\PromotionLink;
use App\Repositories\Promotions\PromotionTest;
use Illuminate\Http\Request;

class UserRadioContentController extends Controller
{
    private $radio;

    public function __construct()
    {
        dd(session()->all());
        $this->radio = Radio::findOrFail(session('radio_id'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.radio-content.all', [
            'radio' => $this->radio
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typeContent = PromotionLink::getType();
        if (request()->has(PromotionTest::getType())) {
            $typeContent = PromotionTest::getType();
        } else if (request()->has(PromotionAnswer::getType())) {
            $typeContent = PromotionAnswer::getType();
        }
        return view('user.radio-content.create', [
            'radio' => $this->radio,
            'typeContent' => $typeContent,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
