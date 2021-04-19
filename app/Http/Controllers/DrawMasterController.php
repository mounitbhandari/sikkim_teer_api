<?php

namespace App\Http\Controllers;

use App\Models\DrawMaster;
use Illuminate\Http\Request;

class DrawMasterController extends Controller
{
    public function getActiveDrawTime(){
        $currentDraw = DrawMaster::where('active', 1)->first();;
        echo json_encode($currentDraw,JSON_NUMERIC_CHECK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DrawMaster  $drawMaster
     * @return \Illuminate\Http\Response
     */
    public function show(DrawMaster $drawMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DrawMaster  $drawMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(DrawMaster $drawMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DrawMaster  $drawMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DrawMaster $drawMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DrawMaster  $drawMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(DrawMaster $drawMaster)
    {
        //
    }
}
