<?php

namespace App\Http\Controllers;

use App\Models\Stockist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MaxTable;
use Exception;

class StockistController extends Controller
{
    public function getAllStockists(){
        $allStockists = Stockist::select('id','stockist_unique_id','stockist_name','user_id','user_password','serial_number','current_balance','user_type_id')
            ->where('inforce',1)->get();
        return json_encode($allStockists,JSON_NUMERIC_CHECK);
    }

    public function selectNextStockistId(){
        $stockist = DB::select(DB::raw("select max(current_value+1) as current_value from max_tables where user_type_id=4"));
        $stockist = $stockist[0];

        if(isset($stockist) && !empty($stockist->current_value)){
            $currentValue = $stockist->current_value;
        }else{
            $currentValue = 1;
        }
        $stockistUserId = 'ST'.str_pad($currentValue,4,"0",STR_PAD_LEFT);
        return json_encode($stockistUserId,JSON_NUMERIC_CHECK);
    }

    public function saveNewStockist(request $request){
        $requestedData = (object)($request->json()->all());
        $objCentralFunctionCtrl = new CentralFunctionController();
        $financial_year = $objCentralFunctionCtrl->get_financial_year();
        try
        {
            DB::insert("insert into max_tables (subject_name,user_type_id,current_value, prefix, financial_year)
            values('stockist',4,1,'S',?)
            on duplicate key UPDATE id=last_insert_id(id), current_value=current_value+1", [$financial_year]);
            $lastInsertId = DB::getPdo()->lastInsertId();
            $max_table_data = MaxTable::where('id',$lastInsertId)->first();
            $stockistObj = new Stockist();
            $stockistObj->stockist_unique_id = $requestedData->stockist['user_id'];
            $stockistObj->stockist_name = $requestedData->stockist['stockist_name'];
            $stockistObj->user_id = $requestedData->stockist['user_id'];
            $stockistObj->user_password = $requestedData->stockist['user_password'];
            $stockistObj->serial_number = $max_table_data->current_value;
            $stockistObj->user_type_id = 4;
            $stockistObj->save();
            $lastStockistId = DB::getPdo()->lastInsertId();
            DB::commit();
        }

        catch (Exception $e)
        {
            DB::rollBack();
            return response()->json(array('success' => 0, 'message' => $e->getMessage().'<br>File:-'.$e->getFile().'<br>Line:-'.$e->getLine()),401);
        }
        return response()->json(array('success' => 1, 'message' => 'Successfully recorded', 'stockist_id' => $lastStockistId,'user_id' => $requestedData->stockist['user_id']),200);
    }

    public function updateStockistDetails(request $request){
        $requestedData = (object)($request->json()->all());
        $id = $requestedData->stockist['id'];
        $stockist_name = $requestedData->stockist['stockist_name'];
        $user_id = $requestedData->stockist['user_id'];
        $user_password = $requestedData->stockist['user_password'];

        try
        {
            $updateStockist = Stockist::where('id',$id)->update(['stockist_name'=> $stockist_name,'user_password'=> $user_password]);
            DB::commit();
        }

        catch (Exception $e)
        {
            DB::rollBack();
            return response()->json(array('success' => $updateStockist, 'message' => $e->getMessage().'<br>File:-'.$e->getFile().'<br>Line:-'.$e->getLine()),401);
        }
        return response()->json(array('success' => $updateStockist, 'message' => 'Successfully recorded', 'stockist_id' => $id,'user_id' => $user_id),200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stockist  $stockist
     * @return \Illuminate\Http\Response
     */
    public function edit(Stockist $stockist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stockist  $stockist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stockist $stockist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stockist  $stockist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stockist $stockist)
    {
        //
    }
}
