<?php

namespace App\Http\Controllers;

use App\Models\credittransactions;
use App\Models\transactiontosuplliers;
use App\Models\acounts_type;

use App\Models\customers;
use App\Models\financial_accounts;
use App\Models\Expenses_reasons;
use App\Models\expenses;
use App\Models\supllier;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization as LaravelLocalization;


class CredittransactionsController extends Controller
{
    
             public function get_And_Delete_delyrecord( $request)
    { 
$credittransactions=credittransactions::where('dely_record',$request)->get();  
          $credittransactions_data=$credittransactions;

foreach($credittransactions as $item){
  
    


        
            $financial_accounts= financial_accounts::find($item->customer_id);
$depit_credit=credittransactions::find($item->id);
         financial_accounts::find($item->customer_id)->update(
     [
         'debtor_current'=>$financial_accounts->debtor_current-$depit_credit->debtor,
         'creditor_current'=>$financial_accounts->creditor_current-$depit_credit->creditor,
     ]
     );  
     
     
             $financial_accounts= financial_accounts::find($item->customer_id);
             
             if($financial_accounts->parent_account_number)
{   
  credittransactions::where('customer_id',$financial_accounts->parent_account_number)->where('parent_dely_record',$item->dely_record)->update(['save'=> 0]);
        $depit_credit= credittransactions::where('customer_id',$financial_accounts->parent_account_number)->where('parent_dely_record',$item->dely_record)->first();
         $financial_accounts= financial_accounts::find($financial_accounts->parent_account_number);
    financial_accounts::find($financial_accounts->id)->update(
     [
         'debtor_current'=>$financial_accounts->debtor_current-$depit_credit->debtor,
         'creditor_current'=>$financial_accounts->creditor_current-$depit_credit->creditor,
     ]
     );  
}

credittransactions::find($item->id)->delete();

}
        $items=[];
        
        foreach($credittransactions_data as $item){
               $items []= [

            'id' => $item->id,
            'name' => $item->financial_accounts_data->name,
            'depit' => $item->debtor ,
            'credit' => $item->creditor ,


        ];
            
        }
        $data=['id'=>$request,'items'=>$items];
        
        
   
     
    
    
     
        return 1;
        
        
        
    }



         public function getAndUpdate_delyrecord( $request)
    {
        
$credittransactions=credittransactions::where('dely_record',$request)->get();  
          $credittransactions_data=$credittransactions;

foreach($credittransactions as $item){
  
    


credittransactions::find($item->id)->update(['save'=> 0]);
        
            $financial_accounts= financial_accounts::find($item->customer_id);
$depit_credit=credittransactions::find($item->id);
         financial_accounts::find($item->customer_id)->update(
     [
         'debtor_current'=>$financial_accounts->debtor_current-$depit_credit->debtor,
         'creditor_current'=>$financial_accounts->creditor_current-$depit_credit->creditor,
     ]
     );  
     
     
             $financial_accounts= financial_accounts::find($item->customer_id);
             
             if($financial_accounts->parent_account_number)
{   
  credittransactions::where('customer_id',$financial_accounts->parent_account_number)->where('parent_dely_record',$item->dely_record)->update(['save'=> 0]);
        $depit_credit= credittransactions::where('customer_id',$financial_accounts->parent_account_number)->where('parent_dely_record',$item->dely_record)->first();
         $financial_accounts= financial_accounts::find($financial_accounts->parent_account_number);
    financial_accounts::find($financial_accounts->id)->update(
     [
         'debtor_current'=>$financial_accounts->debtor_current-$depit_credit->debtor,
         'creditor_current'=>$financial_accounts->creditor_current-$depit_credit->creditor,
     ]
     );  
}


}
        $items=[];
        
        foreach($credittransactions_data as $item){
               $items []= [

            'id' => $item->id,
            'name' => $item->financial_accounts_data->name,
            'account_id' => $item->financial_accounts_data->id,
            'depit' => $item->debtor ,
            'credit' => $item->creditor ,


        ];
            
        }
        $data=['id'=>$request,'items'=>$items];
        
        
   
     
    
    
     
        return $data;
        
        
        
    }






    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        app()->setLocale(LaravelLocalization::getCurrentLocale());
        
        return view('acountes.Daily_record');
       

    }


    public function Opening_entry()
    {
        
        app()->setLocale(LaravelLocalization::getCurrentLocale());
        
        return view('acountes.Opening_entry');
       

    }
    
    
    
     public function delete_record_by_id( $request)
{
    $credittransaction = credittransactions::find($request);
             $financial_accounts= financial_accounts::find($credittransaction->customer_id);
             if($financial_accounts->parent_account_number)
{   
  credittransactions::where('customer_id',$financial_accounts->parent_account_number)->where('parent_dely_record',$credittransaction->dely_record)->delete();
        
       
}
  
       credittransactions::find($request)->delete();

        $items=[];
        
        $credittransactions=credittransactions::where('dely_record',$credittransaction->dely_record)->get();
        foreach($credittransactions as $item){
               $items []= [

            'id' => $item->id,
            'name' => $item->financial_accounts_data->name,
            'depit' => $item->debtor ,
            'credit' => $item->creditor ,


        ];
            
        }
        $data=['id'=>$credittransaction->dely_record,'items'=>$items];
        
        
   
     
    
    
     
        return $data;
}




 public function updatedelyrecord(Request $request)
{
    $credittransaction = credittransactions::find($request->transactionId);
     credittransactions::find($request->transactionId)->update(
            [
                'recive_amount'=> $request->debit_update+$request->credit_update,
                'debtor'=> $request->debit_update,
                'creditor'=>$request->credit_update,
                'customer_id'=>$request->clientnamesearch_update,

            ]
        );
             $financial_accounts= financial_accounts::find($credittransaction->customer_id);
             if($financial_accounts->parent_account_number)
{   
  credittransactions::where('customer_id',$financial_accounts->parent_account_number)->where('parent_dely_record',$credittransaction->dely_record)->update(
            [
        
                  'recive_amount'=> $request->debit_update+$request->credit_update,
                'debtor'=> $request->debit_update,
                'creditor'=>$request->credit_update
            ]
        );
        
       
}
  
        $items=[];
        
        $credittransactions=credittransactions::where('dely_record',$credittransaction->dely_record)->get();
        foreach($credittransactions as $item){
               $items []= [

            'id' => $item->id,
            'name' => $item->financial_accounts_data->name,
            'depit' => $item->debtor ,
            'credit' => $item->creditor ,


        ];
            
        }
        $data=['id'=>$credittransaction->dely_record,'items'=>$items];
        
        
   
     
    
    
     
        return $data;
}
 public function print_Opening_entry(Request $request)
{
         app()->setLocale(LaravelLocalization::getCurrentLocale());

$credittransactions=credittransactions::where( 'Opening_entry' ,$request->record_id_print)->where( 'parent_Opening_entry' ,0)->get();
$data=[];
$date='';
      foreach($credittransactions as $item){
          $date=$item->created_at;
               $data []= [

            'id' => $item->id,
            'name' => $item->financial_accounts_data->name,
            'depit' => $item->debtor ,
            'credit' => $item->creditor ,
            'note' => $item->note


        ];
            
        }



        
        return view('acountes.print_Opening_entry',compact('data'))->with('date',$date)->with('dely_record',$request->print_record);
    
}


 public function print_daily_record(Request $request)
{
         app()->setLocale(LaravelLocalization::getCurrentLocale());

$credittransactions=credittransactions::where( 'dely_record' ,$request->record_id_print)->get();
$data=[];
$date='';
      foreach($credittransactions as $item){
          $date=$item->created_at;
               $data []= [

            'id' => $item->id,
            'name' => $item->financial_accounts_data->name,
            'depit' => $item->debtor ,
            'credit' => $item->creditor ,
'created_at' => $item->created_at,
'date' => $item->created_at,
                'date_export' => $item->date_export, 

        ];
            
        }


        
        return view('acountes.print_daily_record',compact('data'))->with('date',$date)->with('dely_record',$request->record_id_print);
    
}

 public function save_Opening_entry( $dely_record_id){
  
                $credittransactions=credittransactions::where( 'Opening_entry' ,$dely_record_id)->get();
            $credit_sum=0;
             $debit_sum=0;
        

        foreach($credittransactions as $item){
                  $credit_sum+= $item->creditor ;
                  $debit_sum+=$item->debtor ;
         
        }  
        if($credit_sum==$debit_sum){ 

    foreach($credittransactions as $item){

        if($item->financial_accounts_data->account_type==1||$item->financial_accounts_data->account_type==4){
                    
                    if($item->debtor){
    $financial_accounts= financial_accounts::find($item->customer_id);
    financial_accounts::find($item->customer_id)->update(
     [
         'current_balance'=>$financial_accounts->current_balance+$item->debtor,
         'debtor_current'=>$financial_accounts->debtor_current+$item->debtor,
         'debtor_opening'=>$item->debtor,
     ]
     );
     credittransactions::where( 'Opening_entry' ,$dely_record_id)->where('customer_id',$item->customer_id)->update([
                     'currentblance'=>$financial_accounts->current_balance+$item->debtor,
     ]);
     




     
    if($financial_accounts->orginal_type==2){
        $supplier_data = supllier::where('id', $financial_accounts->orginal_id)->first();
     $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->update(
        [
            'In_debt' => $supplier_data->In_debt+$item->debtor ,
            'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
            'opeing_blance' =>$item->debtor,


        ]
    );
    }
        if($financial_accounts->orginal_type==1){
            $customers=customers::where('id', $financial_accounts->orginal_id)->first();
    customers::where('id', $financial_accounts->orginal_id)->update(
        [
            'Balance' => $customers->Balance+$item->debtor,
            'opeing_blance' =>$item->debtor,

        ]
    );
        }

     
     }
     if($item->creditor){
                        
    $financial_accounts= financial_accounts::find($item->customer_id);
    financial_accounts::find($item->customer_id)->update(
     [
         'current_balance'=>$financial_accounts->current_balance-$item->creditor ,
         'creditor_current'=>$financial_accounts->creditor_current+$item->creditor ,
         'creditor_opening'=>$item->creditor ,


     ]
     ); 
          credittransactions::where( 'dely_record' ,$dely_record_id)->where('customer_id',$item->customer_id)->update([
                     'currentblance'=>$financial_accounts->current_balance-$item->creditor ,
     ]);
     

          


   if($financial_accounts->orginal_type==2){
    $supplier_data = supllier::where('id', $financial_accounts->orginal_id)->first();

     $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->update(
        [
            'In_debt' => $supplier_data->In_debt-$item->creditor,
            'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
            'opeing_blance' =>$item->creditor,


        ]
    );
    }
        if($financial_accounts->orginal_type==1){
    $customers=customers::where('id', $financial_accounts->orginal_id)->first();

    customers::where('id', $financial_accounts->orginal_id)->update(
        [
            'Balance' => $customers->Balance-$item->creditor,
            'opeing_blance' =>$item->creditor,

        ]
    );
        }
}
}else{
    
                       
                    if($item->debtor){
    $financial_accounts= financial_accounts::find($item->customer_id);
    financial_accounts::find($item->customer_id)->update(
     [
         'current_balance'=>$financial_accounts->current_balance-$item->debtor ,
         'debtor_current'=>$financial_accounts->debtor_current+$item->debtor ,
        'debtor_opening'=>$item->debtor ,

     ]
     ); 
            credittransactions::where( 'dely_record' ,$dely_record_id)->where('customer_id',$item->customer_id)->update([
                     'currentblance'=>$financial_accounts->current_balance-$item->debtor ,
     ]);
     
   if($financial_accounts->orginal_type==2){
    $supplier_data = supllier::where('id', $financial_accounts->orginal_id)->first();

     $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->update(
        [
            'In_debt' => $supplier_data->In_debt-$item->debtor,
            'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
            'opeing_blance' =>$item->debtor,


        ]
    );
    }
        if($financial_accounts->orginal_type==1){
            $customers=customers::where('id', $financial_accounts->orginal_id)->first();

    customers::where('id', $financial_accounts->orginal_id)->update(
        [
            'Balance' =>$customers->Balance-$item->debtor,
            'opeing_blance' =>$item->debtor,

        ]
    );
        }
     }

     if($item->creditor){
                        
    $financial_accounts= financial_accounts::find($item->customer_id);
    financial_accounts::find($item->customer_id)->update(
     [
         'current_balance'=>$financial_accounts->current_balance+$item->creditor ,
         'creditor_current'=>$financial_accounts->creditor_current+$item->creditor ,
                  'creditor_opening'=>$item->creditor ,


     ]
     ); 
            credittransactions::where( 'dely_record' ,$dely_record_id)->where('customer_id',$item->customer_id)->update([
                     'currentblance'=>$financial_accounts->current_balance+$item->creditor,
     ]);
    if($financial_accounts->orginal_type==2){
        $supplier_data = supllier::where('id', $financial_accounts->orginal_id)->first();

     $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->update(
        [
            'In_debt' => $supplier_data->In_debt+$item->creditor,
            'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
            'opeing_blance' =>$item->creditor,

        ]
    );
    }
        if($financial_accounts->orginal_type==1){
            $customers=customers::where('id', $financial_accounts->orginal_id)->first();

    customers::where('id', $financial_accounts->orginal_id)->update(
        [
            'Balance' =>$customers->Balance+$item->creditor,
            'opeing_blance' =>$item->creditor,
        ]
    );
        }
          }


 
    
    
}
            
            
                
                         }    
         $credittransactions=credittransactions::where( 'Opening_entry' ,$dely_record_id)->update(['save'=>1]);
            
            return [1,"  تم حفظ القيد بنجاح  \n The entry has been saved successfully"];
       
 }else
        {
            
            return  [0, "يجب ان يكون طرفي القيد  متساوين نرجو منك المراجعة قبل الضغط علي حفظ مجددا \n   Both sides of the entry must be equal. Please review before clicking Save again"];
        }
        
        
        
}



 public function save_Daily_record( $dely_record_id){
     $credit_sum=0;
     $debit_sum=0;

        $credittransactions=credittransactions::where( 'dely_record' ,$dely_record_id)->get();
       
             foreach($credittransactions as $item){
           
          $credit_sum+= $item->creditor ;
          $debit_sum+=$item->debtor ;


 
            
        }  
        
        if($credit_sum==$debit_sum){
                         foreach($credittransactions as $item){

        if($item->financial_accounts_data->account_type==1||$item->financial_accounts_data->account_type==4){
                    
                    if($item->debtor){
    $financial_accounts= financial_accounts::find($item->customer_id);
    financial_accounts::find($item->customer_id)->update(
     [
         'current_balance'=>$financial_accounts->current_balance+$item->recive_amount ,
         'debtor_current'=>$financial_accounts->debtor_current+$item->recive_amount ,
     ]
     );
     
     
     credittransactions::where( 'dely_record' ,$dely_record_id)->where('customer_id',$item->customer_id)->update([
                     'currentblance'=>$financial_accounts->current_balance+$item->recive_amount ,
     ]);
     
     if($financial_accounts->parent_account_number)
{   
    $financial_account= financial_accounts::find($financial_accounts->parent_account_number);
    financial_accounts::find($financial_accounts->parent_account_number)->update(
     [
         'current_balance'=>$financial_account->current_balance+$item->recive_amount ,
         'debtor_current'=>$financial_account->debtor_current+$item->recive_amount ,
     ]
     ); 
          credittransactions::where( 'parent_dely_record' ,$dely_record_id)->where('customer_id',$item->parent_account_number)->update([
                     'currentblance'=>$financial_account->current_balance+$item->recive_amount,
     ]);
}
     
     }else{
                        
    $financial_accounts= financial_accounts::find($item->customer_id);
    financial_accounts::find($item->customer_id)->update(
     [
         'current_balance'=>$financial_accounts->current_balance-$item->recive_amount ,
         'creditor_current'=>$financial_accounts->creditor_current+$item->recive_amount ,

     ]
     ); 
     
     
          credittransactions::where( 'dely_record' ,$dely_record_id)->where('customer_id',$item->customer_id)->update([
                     'currentblance'=>$financial_accounts->current_balance-$item->recive_amount ,
     ]);
     
          if($financial_accounts->parent_account_number)
{   
    $financial_account= financial_accounts::find($financial_accounts->parent_account_number);
    financial_accounts::find($financial_accounts->parent_account_number)->update(
     [
         'current_balance'=>$financial_account->current_balance-$item->recive_amount ,
         'creditor_current'=>$financial_account->creditor_current+$item->recive_amount ,

     ]
     ); 
     
            credittransactions::where( 'parent_dely_record' ,$dely_record_id)->where('customer_id',$item->parent_account_number)->update([
                     'currentblance'=>$financial_account->current_balance-$item->recive_amount,
     ]);
}
          }




}else{
    
                       
                    if($item->debtor){
    $financial_accounts= financial_accounts::find($item->customer_id);
    financial_accounts::find($item->customer_id)->update(
     [
         'current_balance'=>$financial_accounts->current_balance-$item->recive_amount ,
         'debtor_current'=>$financial_accounts->debtor_current+$item->recive_amount ,
     ]
     ); 
            credittransactions::where( 'dely_record' ,$dely_record_id)->where('customer_id',$item->customer_id)->update([
                     'currentblance'=>$financial_accounts->current_balance-$item->recive_amount ,
     ]);
     
          if($financial_accounts->parent_account_number)
{   
    $financial_account= financial_accounts::find($financial_accounts->parent_account_number);
    financial_accounts::find($financial_accounts->parent_account_number)->update(
     [
          'current_balance'=>$financial_account->current_balance-$item->recive_amount ,
         'debtor_current'=>$financial_account->debtor_current+$item->recive_amount ,
     ]
     ); 
     
            credittransactions::where( 'parent_dely_record' ,$dely_record_id)->where('customer_id',$financial_accounts->parent_account_number)->update([
                     'currentblance'=>$financial_account->current_balance-$item->recive_amount,
     ]);
}
     }else{
                        
    $financial_accounts= financial_accounts::find($item->customer_id);
    financial_accounts::find($item->customer_id)->update(
     [
         'current_balance'=>$financial_accounts->current_balance+$item->recive_amount ,
         'creditor_current'=>$financial_accounts->creditor_current+$item->recive_amount ,

     ]
     ); 
            credittransactions::where( 'dely_record' ,$dely_record_id)->where('customer_id',$item->customer_id)->update([
                     'currentblance'=>$financial_accounts->current_balance+$item->recive_amount,
     ]);
          if($financial_accounts->parent_account_number)
{   
    $financial_account= financial_accounts::find($financial_accounts->parent_account_number);
    financial_accounts::find($financial_accounts->parent_account_number)->update(
     [
         'current_balance'=>$financial_account->current_balance+$item->recive_amount ,
         'creditor_current'=>$financial_account->creditor_current+$item->recive_amount ,

     ]
     ); 
     
            credittransactions::where( 'parent_dely_record' ,$dely_record_id)->where('customer_id',$financial_accounts->parent_account_number)->update([
            'currentblance'=>$financial_accounts->current_balance+$item->recive_amount,
     ]);
}
          }


 
    
    
}
            
            
                
                         }    
         $credittransactions=credittransactions::where( 'dely_record' ,$dely_record_id)->update(['save'=>1]);
            
            return [1,"  تم حفظ القيد بنجاح  \n The entry has been saved successfully"];
        }else
        {
            
            return  [0, "يجب ان يكون طرفي القيد  متساوين نرجو منك المراجعة قبل الضغط علي حفظ مجددا \n   Both sides of the entry must be equal. Please review before clicking Save again"];
        }
        
        
        
        }
     
 


 public function create_Opening_entry(Request $request)
 {
     
     
     
$the_file_path_1='';
$the_file_path_2='';
if ($request->has('attachments_1')) {
$folder='assets//attachments';
$image=$request->attachments_1;
$extension = $image->extension();
$the_file_path_1  = time() . rand(100, 999) . '.' . $extension;
$image->getClientOriginalName = $the_file_path_1;
$image->move($folder, $the_file_path_1);
}



        $clientId = $request->clientnamesearch_1;

     $financial_accounts= financial_accounts::find($clientId);

     if($request->record_id==0)
     
    {
 $dely_record=credittransactions::where('Opening_entry','!=',0)->orderBy('id', 'desc')->first();
 $dely_record_count=1;
 if($dely_record){
        $dely_record_count=$dely_record->Opening_entry+1;

 }
 
        $credittransactions = credittransactions::create(
            [
        
                'attachments'=>$the_file_path_1,
                'orginal_type'=>$financial_accounts->orginal_type??0,
                'user_id' => Auth()->user()->id,
                'customer_id' =>  $clientId,
                'branchs_id' => Auth()->user()->branchs_id,
                'pay_method' => 'Cash',
                'note' =>  $request->notes.'  |  قيد افتتاحي :  '.(string)$dely_record_count??'  |  قيد افتتاحي رقم :  '.(string)$dely_record_count,
                'currentblance'=>$financial_accounts->current_balance,
                'Pay_Method_Name' => 'Cash',
                'created_at'  =>  $request->date,
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>$financial_accounts->orginal_id??0,
                'recive_amount'=> $request->debit_1+$request->credit_1,
                'debtor'=> $request->debit_1,
                'creditor'=>$request->credit_1,
                'Opening_entry'=>$dely_record_count,
                'save'=>0,


            ]
        );
        

        
           
    }
    else{
        
        
    $dely_record_count= $request->record_id;
    $financial_accounts= financial_accounts::find($clientId);
    $createTransaction =   credittransactions::create(
            [
                'attachments'=>$the_file_path_1,
                'orginal_type'=>$financial_accounts->orginal_type??0,
                'user_id' => Auth()->user()->id,
                'customer_id' =>  $clientId,
                'branchs_id' => Auth()->user()->branchs_id,
                'pay_method' => 'Cash',
'note' =>  $request->notes.'  |  قيد يومي رقم :  '.(string)$dely_record_count,
                'currentblance'=>$financial_accounts->current_balance,
                'Pay_Method_Name' => 'Cash',
                'created_at'  =>  $request->date,
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>$financial_accounts->orginal_id??0,
                'debtor'=> $request->debit_1,
                'creditor'=>$request->credit_1,
                'Opening_entry'=>$dely_record_count,
                'save'=>0,
                'recive_amount'=> $request->debit_1+$request->credit_1,

            ]
        );
        

          
    }
        
        $items=[];
        
        $credittransactions=credittransactions::where( 'Opening_entry' ,$dely_record_count)->where( 'parent_Opening_entry' ,0)->get();
        foreach($credittransactions as $item){
               $items []= [

            'id' => $item->id,
            'name' => $item->financial_accounts_data->name,
            'depit' => $item->debtor ,
            'credit' => $item->creditor ,


        ];
            
        }
        
        
        $data=['id'=>$dely_record_count,'items'=>$items];
        
        
   
     
    
    
     
        return $data;
    
        
    
     
 }





 public function daily_record(Request $request)
    {
$the_file_path_1='';
$the_file_path_2='';
if ($request->has('attachments_1')) {
$folder='assets//attachments';
$image=$request->attachments_1;
$extension = $image->extension();
$the_file_path_1  = time() . rand(100, 999) . '.' . $extension;
$image->getClientOriginalName = $the_file_path_1;
$image->move($folder, $the_file_path_1);
}



        $clientId = $request->clientnamesearch_1;

     $financial_accounts= financial_accounts::find($clientId);
         $date = $request->date;

     if($request->record_id==0)
     
    {
 $dely_record=credittransactions::where('dely_record','!=',0)->orderBy('id', 'desc')->first();
 $dely_record_count=1;
 if($dely_record){
        $dely_record_count=$dely_record->dely_record+1;

 }

        $credittransactions = credittransactions::create(
            [
        
                'attachments'=>$the_file_path_1,
                'orginal_type'=>$financial_accounts->orginal_type??0,
                'user_id' => Auth()->user()->id,
                'customer_id' =>  $clientId,
                'branchs_id' => Auth()->user()->branchs_id,
                'pay_method' => 'Cash',
'note' =>  $request->notes_1.'  |  قيد يومي رقم :  '.(string)$dely_record_count,
                'currentblance'=>$financial_accounts->current_balance,
                'Pay_Method_Name' => 'Cash',
                'created_at' => $date != '0' ? $date . ' ' . substr(\Carbon\Carbon::now()->addHours(3), 12) : \Carbon\Carbon::now()->addHours(3),
                'date_export'  =>  $request->date,
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>$financial_accounts->orginal_id??0,
                'recive_amount'=> $request->debit_1+$request->credit_1,
                'debtor'=> $request->debit_1,
                'creditor'=>$request->credit_1,
                'dely_record'=>$dely_record_count,
                'save'=>0

            ]
        );
        
       
             if($financial_accounts->parent_account_number)
{   
    $financial_accounts= financial_accounts::find($financial_accounts->parent_account_number);
  credittransactions::create(
            [
        
                'attachments'=>$the_file_path_1,
                'orginal_type'=>$financial_accounts->orginal_type??0,
                'user_id' => Auth()->user()->id,
                'customer_id' =>  $financial_accounts->id,
                'branchs_id' => Auth()->user()->branchs_id,
                'pay_method' => 'Cash',
'note' =>  $request->notes_1.'  |  قيد يومي رقم :  '.(string)$dely_record_count,
                'currentblance'=>$financial_accounts->current_balance,
                'Pay_Method_Name' => 'Cash',
                'created_at' => $date != '0' ? $date . ' ' . substr(\Carbon\Carbon::now()->addHours(3), 12) : \Carbon\Carbon::now()->addHours(3),
                'date_export'  =>  $request->date,
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>$financial_accounts->orginal_id??0,
                'recive_amount'=> $request->debit_1+$request->credit_1,
                'debtor'=> $request->debit_1,
                'creditor'=>$request->credit_1,
                'save'=>0,
                                'parent_dely_record'=>$dely_record_count,


            ]
        );
        
       
}
        
           
    }
    else{
        
        
    $dely_record_count= $request->record_id;
    $financial_accounts= financial_accounts::find($clientId);
    $createTransaction =   credittransactions::create(
            [
                'attachments'=>$the_file_path_1,
                'orginal_type'=>$financial_accounts->orginal_type??0,
                'user_id' => Auth()->user()->id,
                'customer_id' =>  $clientId,
                'branchs_id' => Auth()->user()->branchs_id,
                'pay_method' => 'Cash',
'note' =>  $request->notes_1.'  |  قيد يومي رقم :  '.(string)$dely_record_count,
                'currentblance'=>$financial_accounts->current_balance,
                'Pay_Method_Name' => 'Cash',
                'created_at' => $date != '0' ? $date . ' ' . substr(\Carbon\Carbon::now()->addHours(3), 12) : \Carbon\Carbon::now()->addHours(3),
                'date_export'  =>  $request->date,
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>$financial_accounts->orginal_id??0,
                'debtor'=> $request->debit_1,
                'creditor'=>$request->credit_1,
                'dely_record'=>$dely_record_count,
                'save'=>0,
                'recive_amount'=> $request->debit_1+$request->credit_1,

            ]
        );
        
       if($financial_accounts->parent_account_number)
{   
    $financial_accounts= financial_accounts::find($financial_accounts->parent_account_number);
  credittransactions::create(
            [
        
                   'attachments'=>$the_file_path_1,
                'orginal_type'=>$financial_accounts->orginal_type??0,
                'user_id' => Auth()->user()->id,
                'customer_id' =>  $financial_accounts->id,
                'branchs_id' => Auth()->user()->branchs_id,
                'pay_method' => 'Cash',
'note' =>  $request->notes_1.'  |  قيد يومي رقم :  '.(string)$dely_record_count,
                'currentblance'=>$financial_accounts->current_balance,
                'Pay_Method_Name' => 'Cash',
                'created_at' => $date != '0' ? $date . ' ' . substr(\Carbon\Carbon::now()->addHours(3), 12) : \Carbon\Carbon::now()->addHours(3),
                'date_export'  =>  $request->date,
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>$financial_accounts->orginal_id??0,
                'debtor'=> $request->debit_1,
                'creditor'=>$request->credit_1,
                'save'=>0,
                'recive_amount'=> $request->debit_1+$request->credit_1,
                                'parent_dely_record'=>$dely_record_count,

            ]
        );
        
       
}

          
    }
        
        $items=[];
        
        $credittransactions=credittransactions::where( 'dely_record' ,$dely_record_count)->get();
        foreach($credittransactions as $item){
               $items []= [

            'id' => $item->id,
            'name' => $item->financial_accounts_data->name,
            'depit' => $item->debtor ,
            'credit' => $item->creditor ,
            'account_id' => $item->financial_accounts_data->id,



        ];
            
        }
        $data=['id'=>$dely_record_count,'items'=>$items];
        
        
   
     
    
    
     
        return $data;
    
        
    }








    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     

    public function updateVoncher(Request $request)
    {
        app()->setLocale(LaravelLocalization::getCurrentLocale());

       $transaction= credittransactions::find($request->transactionId);        //    return $clientId;
         $type=$request->pay_type_desc;
        $clientId=$transaction->customer_id;
        $newcustomer=$request->payupdate;
        $financial_accounts= financial_accounts::find($newcustomer);

        $payment_new_text=$financial_accounts->name;    

        $decument_id_recipt= $transaction->sent_abd_count;
        $financial_accounts= financial_accounts::where('name',$transaction->Pay_Method_Name)->first();
        $old_payment_id=$financial_accounts->id;
        $parent_payment_old=$financial_accounts->parent_account_number;
   
      {

        $financial_accounts= financial_accounts::where('name',$transaction->Pay_Method_Name)->first();
        financial_accounts::find($financial_accounts->id)->update(
                [
                   'current_balance'=> $financial_accounts->current_balance-$transaction->recive_amount ,
                   'debtor_current'=>$financial_accounts->debtor_current- $transaction->recive_amount ,

               ]
               ); 
               $financial_accounts= financial_accounts::find( $parent_payment_old);
               financial_accounts::find($parent_payment_old)->update(
       [
               'current_balance'=> $financial_accounts->current_balance-$transaction->recive_amount ,
                'debtor_current'=>$financial_accounts->debtor_current- $transaction->recive_amount ,

       ]
       ); 
       
       
       
       
       
       credittransactions::where('customer_id',$old_payment_id)->where('decument_id',$request->transactionId)->update(
        [
               
            'customer_id' => $newcustomer,
            'recive_amount' => $request->cashreceivedupdate,
                'Pay_Method_Name' => $payment_new_text,
                'pay_method' => $payment_new_text,

                'debtor'=> $request->cashreceivedupdate, 
'type'=>$type,


            ]
        );
        
        $financial_accounts_new= financial_accounts::where('id',$newcustomer)->first();
        credittransactions::where('customer_id',$parent_payment_old)->where('decument_id',$request->transactionId)->update(
            [
               
                'customer_id' => $financial_accounts_new->parent_account_number,
                'recive_amount' => $request->cashreceivedupdate,
                'Pay_Method_Name' => $payment_new_text,
                'pay_method' => $payment_new_text,
                'debtor'=> $request->cashreceivedupdate, 
'type'=>$type,


            ]
        );
        
        
        
       
            }
           




            $financial_accounts= financial_accounts::find($request->payupdate);
            financial_accounts::find($request->payupdate)->update(
               [
                'current_balance'=> $financial_accounts->current_balance+$request->cashreceivedupdate,
                'debtor_current'=>$financial_accounts->debtor_current+$request->cashreceivedupdate,
        
               ]
               ); 
        $parent_new_id=$financial_accounts->parent_account_number;
                
            $financial_accounts= financial_accounts::find($parent_new_id)->first();
            financial_accounts::find($parent_new_id)->update(
               [
                'current_balance'=> $financial_accounts->current_balance+$request->cashreceivedupdate,
                'debtor_current'=>$financial_accounts->debtor_current+$request->cashreceivedupdate,
        
               ]
               ); 
         
            
     

      
   //    return $clientId;
        $customerdata = financial_accounts::find($clientId);

     
    if($customerdata->account_type==1||$customerdata->account_type==4){

     
    $financial_accounts= financial_accounts::find($clientId);
    financial_accounts::find($clientId)->update(
     [
         'current_balance'=>$financial_accounts->current_balance+$transaction->recive_amount ,
        'creditor_current'=>$financial_accounts->creditor_current-$transaction->recive_amount ,

     ]
     ); 
     
 
     }
     
     else{
             
    $financial_accounts= financial_accounts::find($clientId);
    financial_accounts::find($clientId)->update(
     [
         'current_balance'=>$financial_accounts->current_balance+$transaction->recive_amount ,
         'debtor_current'=>$financial_accounts->debtor_current-$transaction->recive_amount,

     ]
     ); 
     
   
     }
     
     
     
    if($financial_accounts->orginal_type==2){
     $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->update(
        [
            'In_debt' => $customerdata->current_balance +$transaction->recive_amount ,
            'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),

        ]
    );
    }
        if($financial_accounts->orginal_type==1){

    customers::where('id', $financial_accounts->orginal_id)->update(
        [
            'Balance' => $customerdata->current_balance+$transaction->recive_amount ,
        ]
    );
        }


  








        $customerdata = financial_accounts::find($request->clientnamesearch_update);

     
    if($customerdata->account_type==1||$customerdata->account_type==4){

     
    $financial_accounts=  financial_accounts::find($request->clientnamesearch_update);
    financial_accounts::find($request->clientnamesearch_update)->update(
     [
         'current_balance'=>$financial_accounts->current_balance- $request->cashreceivedupdate,
        'creditor_current'=>$financial_accounts->creditor_current + $request->cashreceivedupdate,

     ]
     ); 
     
           credittransactions::where('id',$request->transactionId)->update(
            [
                
                'customer_id'=>$request->clientnamesearch_update,
                'recive_amount' => $request->cashreceivedupdate,
                'Pay_Method_Name' => $payment_new_text,
                'pay_method' => $payment_new_text,
                'creditor'=> $request->cashreceivedupdate, 
                'type'=>$type,

            ]
        );
     }
     
     else{
             
    $financial_accounts=  financial_accounts::find($request->clientnamesearch_update);
    financial_accounts::find($request->clientnamesearch_update)->update(
     [
         'current_balance'=>$financial_accounts->current_balance- $request->cashreceivedupdate,
         'debtor_current'=>$financial_accounts->debtor_current+ $request->cashreceivedupdate,

     ]
     ); 
     
           credittransactions::where('id',$request->transactionId)->update(
            [
                'customer_id'=>$request->clientnamesearch_update,
                'recive_amount' => $request->cashreceivedupdate,
                'Pay_Method_Name' => $payment_new_text,
                'pay_method' => $payment_new_text,
                'debtor'=> $request->cashreceivedupdate, 
                'type'=>$type,

            ]
        );
     }
     
     
     
    if($financial_accounts->orginal_type==2){
     $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->update(
        [
            'In_debt' => $customerdata->current_balance - $request->cashreceivedupdate,
            'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),

        ]
    );
    }
        if($financial_accounts->orginal_type==1){

    customers::where('id', $financial_accounts->orginal_id)->update(
        [
            'Balance' => $customerdata->current_balance- $request->cashreceivedupdate,
        ]
    );
        }

 
        
        
$credittransactions=credittransactions::where( 'sent_abd_count' ,$decument_id_recipt)->get();
$data=[];
$pay='';
      foreach($credittransactions as $item){
     
          $date=$item->created_at;
               $data []=[
                'sent_abd_count'=>$decument_id_recipt,
                'id' =>  $item->id,
                'name' => $item->financial_accounts_data->name,
                'method_pay' => $item->Pay_Method_Name,
                'paid_amount' => $item->recive_amount,
                                'recipt_id' => $item->financial_accounts_data->id,

        

        ];
            
        }

        return $data;
    
      
    }
        public function search_by_decoumentNo_send_abd( $request){
            
        $data =credittransactions::where('note', 'LIKE', '%' . 'سند قبض' . '%')->where('branchs_id', Auth()->user()->branchs_id)->where('decument_id', 0)->where('sent_abd_count',$request)->paginate(3);

                    return view('sant_abd_ajax', compact('data'));

            
        }
        
             public function search_by_decoumentNo_send_serf( $request){

        $data =credittransactions::where('type_decument', 2)->where('branchs_id', Auth()->user()->branchs_id)->where('decument_id', 0)->where('sent_serf_count',$request)->paginate(3);

                    return view('sant_serf_ajax', compact('data'));

            
        }
        
              public function delete_voncher( $request)
    {
                $createTransaction =credittransactions::where('decument_id', 0)->where('sent_abd_count',$request)->first();
               credittransactions::where('note',$createTransaction->note)->delete();
        
           $data= credittransactions::where('branchs_id',Auth()->user()->branchs_id)->where('note', 'LIKE', '%' . 'سند قبض' . '%')->where('decument_id', 0)->orderby('id', 'desc')->paginate(3);
        return view('sant_abd_ajax', compact('data'));
        
    }
        public function getAndUpdatevoncher( $request)
    {
        app()->setLocale(LaravelLocalization::getCurrentLocale());
 
        $createTransaction =credittransactions::where('decument_id', 0)->where('sent_abd_count',$request)->get();
        
    if($createTransaction==NULL){
        
        return 0;
    }
    $data=[];
          foreach($createTransaction as $item){
         
              $date=$item->created_at;
                   $data []=[
                    'sent_abd_count'=>$request,
                    'id' =>  $item->id,
                    'name' => $item->financial_accounts_data->name,
                    'method_pay' => $item->Pay_Method_Name,
                    'paid_amount' => $item->recive_amount,
                                    'recipt_id' => $item->financial_accounts_data->id,

            
    
            ];
                
            }
    
        return $data;
    }

    public function create(Request $request)
    {
        
        app()->setLocale(LaravelLocalization::getCurrentLocale());
        
        //
        $this->validate($request, [
            'cashreceived' => 'required|numeric  ',

        ]);
 $type=$request->pay;
       
$the_file_path='';
if ($request->has('attachments')) {
// $request->validate([
// 'Item_img' => 'required|mimes:png,jpg,jpeg,pdf|max:2000',
// ]);
$folder='assets//attachments';
$image=$request->attachments;
$extension = $image->extension();
$the_file_path  = time() . rand(100, 999) . '.' . $extension;
$image->getClientOriginalName = $the_file_path
;
$image->move($folder, $the_file_path
);
}





        $clientId = $request->clientnamesearch;

$financial_accounts= financial_accounts::find($request->paymentmethod);
$payment_name=$financial_accounts->name;
$sent_abd_count=$request->id_create;
$recent_id= credittransactions::where('note', 'LIKE', '%' . 'سند قبض' . '%')->where('decument_id', 0)->orderby('id', 'desc')->first();
if($recent_id!=NULL && $sent_abd_count==1)
{
$sent_abd_count=$recent_id->sent_abd_count+1;
}

        $customerdata = financial_accounts::find($clientId);
        $payment_id=$request->paymentmethod;

     if($customerdata->account_type==1||$customerdata->account_type==4){
        $financial_accounts= financial_accounts::find($clientId);
    financial_accounts::find($clientId)->update(
     [
          'current_balance'=> $financial_accounts->debtor_current-($financial_accounts->creditor_current+ $request->cashreceived),
          'creditor_current'=>$financial_accounts->creditor_current+ $request->cashreceived,

     ]
     );  
     
     
                $customerdata = $financial_accounts;

     $createTransaction =   credittransactions::create(
            [
                'attachments'=>$the_file_path,
                'orginal_type'=>$financial_accounts->orginal_type??0,
                'user_id' => Auth()->user()->id,
                'customer_id' =>  $clientId,
                'recive_amount' => $request->cashreceived,
                'branchs_id' => Auth()->user()->branchs_id,
                'pay_method' => $payment_name,
                'created_at'  =>  \Carbon\Carbon::now()->addHours(3),      
                'date_export'  =>  $request->date,
'note' =>  $request->notes.'|  سند قبض  | '.' : '.(string)$sent_abd_count,
                'currentblance'=>$financial_accounts->debtor_current-($financial_accounts->creditor_current+ $request->cashreceived),
                'Pay_Method_Name' =>$payment_name,
                'created_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>$financial_accounts->orginal_id??0,
                 'debtor'=> 0,
                 'creditor'=>$request->cashreceived,
                                 'sent_abd_count'=>$sent_abd_count,
'type'=>$type,

                
            ]
        );
     
     
     
     
     
     
     }
  else{
      
      
        $financial_accounts= financial_accounts::find($clientId);
    financial_accounts::find($clientId)->update(
     [
         'current_balance'=> ($financial_accounts->debtor_current+ $request->cashreceived)-($financial_accounts->creditor_current),
         'creditor_current'=>$financial_accounts->debtor_current+ $request->cashreceived,

     ]
     ); 
     
     
     
     
                $customerdata = $financial_accounts;

     $createTransaction =   credittransactions::create(
            [
                'attachments'=>$the_file_path,
                'orginal_type'=>$financial_accounts->orginal_type??0,
                'user_id' => Auth()->user()->id,
                'customer_id' =>  $clientId,
                'recive_amount' => $request->cashreceived,
                'branchs_id' => Auth()->user()->branchs_id,
                'pay_method' => $payment_name,
                                'created_at'  =>  \Carbon\Carbon::now()->addHours(3),                 'date_export'  =>  $request->date,

'note' =>  $request->notes.'|  سند قبض  | '.' : '.(string)$sent_abd_count,
                'currentblance'=>($financial_accounts->debtor_current+ $request->cashreceived)-($financial_accounts->creditor_current),
                'Pay_Method_Name' => $payment_name,
                'created_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>$financial_accounts->orginal_id??0,
                 'creditor'=> $request->cashreceived, 
                 'debtor'=>0,
                'sent_abd_count'=>$sent_abd_count,
                'type'=>$type,


            ]
        );
     
     
  }
     
     
     
 {

    $financial_accounts= financial_accounts::find($payment_id);
    $parent_account_number=$financial_accounts->parent_account_number;

    financial_accounts::find( $payment_id)->update(
       [
        'current_balance'=> ($financial_accounts->debtor_current+ $request->cashreceived)-($financial_accounts->creditor_current),
         'debtor_current'=>$financial_accounts->debtor_current+ $request->cashreceived,
       ]
       );
       
             credittransactions::create(
            [
                'attachments'=>$the_file_path,
                'orginal_type'=>0,
                'user_id' => Auth()->user()->id,
                'customer_id' => $payment_id,
                'recive_amount' => $request->cashreceived,
                'branchs_id' => Auth()->user()->branchs_id,
                'pay_method' => $payment_name,
                'note' =>  $request->notes.'|  سند قبض  | '.' : '.(string)$sent_abd_count,
                'currentblance'=>($financial_accounts->debtor_current+ $request->cashreceived)-($financial_accounts->creditor_current),
                'Pay_Method_Name' => $payment_name,
                'created_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'date_export'  =>  $request->date,
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>$financial_accounts->orginal_id??0,
                 'debtor'=> $request->cashreceived, 
                 'creditor'=>0,
                 'decument_id'=>$createTransaction->id,
                 'type'=>$type,

            ]
        );
        $financial_accounts= financial_accounts::where('id',$parent_account_number)->first();
        financial_accounts::where('id',$parent_account_number)->update(
            [
            'current_balance'=> ($financial_accounts->debtor_current+ $request->cashreceived)-($financial_accounts->creditor_current)
           ,'debtor_current'=>$financial_accounts->debtor_current+ $request->cashreceived,

       ]
       ); 
   credittransactions::create(
            [
                'attachments'=>$the_file_path,
                'orginal_type'=>0,
                'user_id' => Auth()->user()->id,
                'customer_id' => $parent_account_number,
                'recive_amount' => $request->cashreceived,
                'branchs_id' => Auth()->user()->branchs_id,
                'pay_method' =>$payment_name,
                'note' =>  $request->notes.'|  سند قبض  | '.' : '.(string)$sent_abd_count,
                'currentblance'=>($financial_accounts->debtor_current+ $request->cashreceived)-($financial_accounts->creditor_current),
                'Pay_Method_Name' =>$payment_name,
                'created_at'  =>  \Carbon\Carbon::now()->addHours(3),
               'date_export'  =>  $request->date,
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>$financial_accounts->orginal_id??0,
                 'debtor'=> $request->cashreceived, 
                 'creditor'=>0,
                 'decument_id'=>$createTransaction->id,
                 'type'=>$type,

            ]
        );
    }
   

    $financial_accounts= financial_accounts::find($clientId);


    if($financial_accounts->orginal_type==2){
     $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->update(
        [
            'In_debt' => $financial_accounts->current_balance,
            'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),

        ]
    );
    }
        if($financial_accounts->orginal_type==1){

    customers::where('id', $financial_accounts->orginal_id)->update(
        [
            'Balance' => $financial_accounts->current_balance,
        ]
    );
        }
        
        

               if($financial_accounts->orginal_type==3){
                   
    $reason_data=Expenses_reasons::find($financial_accounts->orginal_id);


  $expense=  expenses::create([
            'attachments'=>$the_file_path,
            'user_id'=>Auth()->user()->id,
            'Pay_Method_Name'=>$payment_name,
            'branchs_id'=>Auth()->user()->branchs_id,
            'Reasonforspendingmoney'=>$reason_data->expenses_reason,
            'reasonId_id'=>$financial_accounts->orginal_id,
            'notes'=>$request->notes??'-' ,
            'expensesAvt'=>$reason_data->expensesAvt ,
            'created_at'  =>  \Carbon\Carbon::now()->addHours(3), 
            'updated_at'  =>  \Carbon\Carbon::now()->addHours(3), 
            'Theـamountـpaid'=>$request->cashreceived*(-1),
            'Transaction_id'=>$createTransaction->id,
        ]);
        }
 
   
     
    
   
  
        
$credittransactions=credittransactions::where( 'sent_abd_count' ,$sent_abd_count)->get();
$data=[];
$pay='';
      foreach($credittransactions as $item){
     
          $date=$item->created_at;
               $data []=[
                'sent_abd_count'=>$sent_abd_count,
                'id' =>  $item->id,
                'name' => $item->financial_accounts_data->name,
                'recipt_id' => $item->financial_accounts_data->id,
                'method_pay' => $item->Pay_Method_Name,
                'paid_amount' => $item->recive_amount
        

        ];
            
        }

        return $data;
    
        
    }




     public function getAndUpdate_reciptdecument( $request)
    {
        app()->setLocale(LaravelLocalization::getCurrentLocale());

        $createTransaction =   credittransactions::where('type_decument',2)->where('sent_serf_count',$request)->get();
     
            if($createTransaction==NULL){
        
        return 0;
    }
$data=[];
$pay='';
      foreach($createTransaction as $item){
     
          $date=$item->created_at;
               $data []=[
                'sent_serf_count'=>$request,
                'id' =>  $item->id,
                'name' => $item->financial_accounts_data->name,
                'method_pay' => $item->Pay_Method_Name,
                'paid_amount' => $item->recive_amount
        

        ];
            
        }

         return $data;
    
    }





    public function store(Request $request)
    {
        //
        // return $request;
        app()->setLocale(LaravelLocalization::getCurrentLocale());
    
                $the_file_path='';
if ($request->has('attachments')) {
// $request->validate([
// 'Item_img' => 'required|mimes:png,jpg,jpeg,pdf|max:2000',
// ]);
$folder='assets//attachments';
$image=$request->attachments;
$extension = $image->extension();
$the_file_path  = time() . rand(100, 999) . '.' . $extension;
$image->getClientOriginalName = $the_file_path
;
$image->move($folder, $the_file_path
);
}
$financial_accounts= financial_accounts::find($request->paymentmethod);
$payment_name=$financial_accounts->name;
$type=$request->pay;
$payment_id=$request->paymentmethod;
$breanchas_id=$financial_accounts->branchs_id;

        $suplliertId = $request->clientnamesearch;
        $clientId = $request->clientnamesearch;
  
  
  
    $customerdata = financial_accounts::find($clientId);

     
 $financial_accounts= financial_accounts::find($clientId);
 $sent_serf_count=$request->id_create;
 $recent_id=credittransactions::where('type_decument',2)->where('decument_id',0)->orderby('id', 'desc')->first();
 if($recent_id!=NULL && $sent_serf_count==1)
 {
 $sent_serf_count=$recent_id->sent_serf_count+1;
 }
 
     if($customerdata->account_type==1||$customerdata->account_type==4){
        $financial_accounts= financial_accounts::find($clientId);
    financial_accounts::find($clientId)->update(
     [
         'current_balance'=>$financial_accounts->current_balance+$request->cashreceived,
          'debtor_current'=>$financial_accounts->debtor_current+ $request->cashreceived,

     ]
     );  
     
                     $customerdata = $financial_accounts;

     $createTransaction =   credittransactions::create(
            [
                'attachments'=>$the_file_path,
                'orginal_type'=>$financial_accounts->orginal_type??0,
                'user_id' => Auth()->user()->id,
                'customer_id' =>  $clientId,
                'recive_amount' => $request->cashreceived,
                'branchs_id' =>  $breanchas_id,
                'pay_method' => $payment_name,
                'note' =>  $request->notes.'|  سند صرف  | '.' : '.(string)$sent_serf_count,
                'currentblance'=>$customerdata->current_balance+$request->cashreceived,
                'Pay_Method_Name' => $payment_name,
                'created_at'  =>  \Carbon\Carbon::now()->addHours(3),    
                'date_export'  =>  $request->date,
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>$financial_accounts->orginal_id??0,
                 'creditor'=> 0,
                 'debtor'=>$request->cashreceived,
                'vat'=>$request->AVT,
                'type_decument'=>2,
                'sent_serf_count'=>$sent_serf_count,
'type'=>$type,
'cost_center'=>$request->cost_center,

                
            ]
        );
     
     
     
     
     
     
     }
  else{
      
      
        $financial_accounts= financial_accounts::find($clientId);
    financial_accounts::find($clientId)->update(
     [
         'current_balance'=>$financial_accounts->current_balance- $request->cashreceived,
         'debtor_current'=>$financial_accounts->debtor_current+ $request->cashreceived,

     ]
     ); 
     
     
                     $customerdata = $financial_accounts;

     

     $createTransaction =   credittransactions::create(
            [
                'attachments'=>$the_file_path,
                'orginal_type'=>$financial_accounts->orginal_type??0,
                'user_id' => Auth()->user()->id,
                'customer_id' =>  $clientId,
                'recive_amount' => $request->cashreceived,
                'branchs_id' =>  $breanchas_id,
                'pay_method' => $payment_name,
                'note' =>  $request->notes.'|  سند صرف  | '.' : '.(string)$sent_serf_count,
                'currentblance'=>$financial_accounts->current_balance- $request->cashreceived,
                'Pay_Method_Name' => $payment_name,
                'created_at'  =>  \Carbon\Carbon::now()->addHours(3),                 'date_export'  =>  $request->date,
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>$financial_accounts->orginal_id??0,
                 'debtor'=> $request->cashreceived, 
                 'creditor'=>0,
                 'name'=> $request->name_buyer??'-', 
                 'tax'=> $request->TaxـNumber??'0', 
                 'vat'=> $request->AVT, 
                 'type_decument'=>2,
                'sent_serf_count'=>$sent_serf_count,
'type'=>$type,
'cost_center'=>$request->cost_center,



            ]
        );
     
     
  }
     
     
     if( $request->AVT)
     {
         
         $total_value=$request->cashreceived;
         
  $financial_accounts= financial_accounts::find(102);
    financial_accounts::find(102)->update(
     [
        'current_balance'=>  ($financial_accounts->debtor_current+$total_value-($total_value*100/115))- ($financial_accounts->creditor_current),
        //  'current_balance'=> $financial_accounts->current_balance+$total_value-($total_value*100/115),
         'debtor_current'=>$financial_accounts->debtor_current+$total_value-($total_value*100/115),

     ]
     ); 

                $customerdata = $financial_accounts;


 credittransactions::create(
            [
                // 'attachments'=>$the_file_path_2??'-',
                'user_id' => Auth()->user()->id,
                'customer_id' =>  102,
                'recive_amount' => $total_value-($total_value*100/115),
                'branchs_id' =>  $breanchas_id,
                'pay_method' =>  $payment_name,
                'note' =>  $request->notes.'|  سند صرف  | '.' : '.(string)$sent_serf_count,
                'currentblance'=>  ($financial_accounts->debtor_current+$total_value-($total_value*100/115))- ($financial_accounts->creditor_current),
                'Pay_Method_Name' =>$payment_name,
                'created_at'  =>  \Carbon\Carbon::now()->addHours(3),                 'date_export'  =>  $request->date,
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>0,
                'debtor'=> $total_value-($total_value*100/115),
                'creditor'=>0,
                'vat'=>1,
                'name'=> $request->name_buyer??'-', 
                 'tax'=> $request->TaxـNumber??'0', 
                 'decument_id'=>$createTransaction->id,
'type'=>$type,


            ]
        );
          $financial_accounts= financial_accounts::where('parent_account_number',102)->where('branchs_id', Auth()->user()->branchs_id)->first();
    financial_accounts::where('parent_account_number',102)->where('branchs_id', Auth()->user()->branchs_id)->update(
       [
        'current_balance'=>  ($financial_accounts->debtor_current+$total_value-($total_value*100/115))- ($financial_accounts->creditor_current),
         'debtor_current'=>$financial_accounts->debtor_current+$total_value-($total_value*100/115),

       ]
       ); 

 credittransactions::create(
            [
                // 'attachments'=>$the_file_path_2??'-',
                'user_id' => Auth()->user()->id,
                'customer_id' =>  $financial_accounts->id,
                'recive_amount' => $total_value-($total_value*100/115),
                'branchs_id' =>  $breanchas_id,
                'pay_method' =>  $payment_name,
                'note' =>  $request->notes.'|  سند صرف  | '.' : '.(string)$sent_serf_count,
                'currentblance'=>($financial_accounts->debtor_current+$total_value-($total_value*100/115))- ($financial_accounts->creditor_current),
                'Pay_Method_Name' =>  $payment_name,
                'created_at'  =>  \Carbon\Carbon::now()->addHours(3),  
                'date_export'  =>  $request->date,
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>0,
                'debtor'=> $total_value-($total_value*100/115),
                'creditor'=>0,
                'vat'=>1,
                'name'=> $request->name_buyer??'-', 
                 'tax'=> $request->TaxـNumber??'0', 
                 'decument_id'=>$createTransaction->id,
'type'=>$type,


            ]
        );
     }
     
     


    $financial_accounts= financial_accounts::find($payment_id);
    $parent_account_number=$financial_accounts->parent_account_number;

    financial_accounts::find($payment_id)->update(
       [
           'current_balance'=> $financial_accounts->debtor_current-($financial_accounts->creditor_current+ $request->cashreceived)
           ,'creditor_current'=>$financial_accounts->creditor_current+ $request->cashreceived,

       ]
       );
       
             credittransactions::create(
            [
                'attachments'=>$the_file_path,
                'orginal_type'=>0,
                'user_id' => Auth()->user()->id,
                'customer_id' =>  $payment_id,
                'recive_amount' => $request->cashreceived,
                'branchs_id' =>  $breanchas_id,
                'pay_method' => $payment_name,
                'note' =>  $request->notes.'|  سند صرف  | '.' : '.(string)$sent_serf_count,
                'currentblance'=> $financial_accounts->debtor_current-($financial_accounts->creditor_current+ $request->cashreceived),
                'Pay_Method_Name' =>$payment_name,
                'created_at'  =>  \Carbon\Carbon::now()->addHours(3),                 'date_export'  =>  $request->date,
                'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                'orginal_id'=>$financial_accounts->orginal_id??0,
                 'creditor'=> $request->cashreceived, 
                 'name'=> $request->name_buyer??'-', 
                 'tax'=> $request->TaxـNumber??'0', 
                 'debtor'=>0,
                 'decument_id'=>$createTransaction->id,
                 'type'=>$type,

            ]
        );

        if($parent_account_number!=NULL){
            $financial_accounts= financial_accounts::where('id',$parent_account_number)->first();
            financial_accounts::where('id',$parent_account_number)->update(
               [
                   'current_balance'=> $financial_accounts->debtor_current-($financial_accounts->creditor_current+ $request->cashreceived)
                   ,'creditor_current'=>$financial_accounts->creditor_current+ $request->cashreceived,
        
               ]
               ); 
                          credittransactions::create(
                    [
                        'attachments'=>$the_file_path,
                        'orginal_type'=>0,
                        'user_id' => Auth()->user()->id,
                        'customer_id' => $parent_account_number,
                        'recive_amount' => $request->cashreceived,
                        'branchs_id' =>  $breanchas_id,
                        'pay_method' =>$payment_name,
                        'note' =>  $request->notes.'|  سند صرف  | '.' : '.(string)$sent_serf_count,
                        'currentblance'=> $financial_accounts->debtor_current-($financial_accounts->creditor_current+ $request->cashreceived),
                        'Pay_Method_Name' => $payment_name,
                        'created_at'  =>  \Carbon\Carbon::now()->addHours(3),                 'date_export'  =>  $request->date,
                        'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),
                        'orginal_id'=>$financial_accounts->orginal_id??0,
                         'creditor'=> $request->cashreceived, 
                         'name'=> $request->name_buyer??'-', 
                         'tax'=> $request->TaxـNumber??'0', 
                         'debtor'=>0,
                         'decument_id'=>$createTransaction->id,
                         'type'=>$type,

                    ]
                );
        }
        


     
    $financial_accounts= financial_accounts::find($clientId);
    if($financial_accounts->orginal_type==2){
     $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->update(
        [
            'In_debt' =>$financial_accounts->current_balance,
            'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),

        ]
    );
    
 
    }
  
     $customerdata = financial_accounts::find($clientId);

  


               if($financial_accounts->orginal_type==3){
   
    $reason_data=Expenses_reasons::find($financial_accounts->orginal_id);


  $expense=  expenses::create([
            'attachments'=>$the_file_path,
            'user_id'=>Auth()->user()->id,
            'Pay_Method_Name'=>$type,
            'branchs_id' =>  $breanchas_id,
            'Reasonforspendingmoney'=>$reason_data->expenses_reason,
            'reasonId_id'=>$financial_accounts->orginal_id,
            'notes'=> $request->notes.'|  سند صرف  | '.' : '.(string)$sent_serf_count,
            'expensesAvt'=>$reason_data->expensesAvt ,
            'created_at'  =>  \Carbon\Carbon::now()->addHours(3),   
            'date_export'  =>  $request->date,
            'updated_at'  =>  \Carbon\Carbon::now()->addHours(3), 
            'Theـamountـpaid'=>$request->cashreceived,
            'type'=>2,

        ]);
        }
 
   
     
  
  

        
$credittransactions=credittransactions::where( 'sent_serf_count' ,$sent_serf_count)->where('type_decument',2)->get();
$data=[];
$pay='';
      foreach($credittransactions as $item){
     
          $date=$item->created_at;
               $data []=[
                'customer_id'=>$item->customer_id,
                'sent_serf_count'=>$sent_serf_count,
                'id' =>  $item->id,
                'name' => $item->financial_accounts_data->name,
                'method_pay' => $item->Pay_Method_Name,
                'paid_amount' => $item->recive_amount
        

        ];
            
        }

         return $data;
    }



    public function updaterecieptdecoument(Request $request)
    {
        //
        app()->setLocale(LaravelLocalization::getCurrentLocale());

  $newcustomer=$request->payupdate;
    

   
    //   return $newcustomer;
$type=$request->pay_type_desc;

 $transaction= credittransactions::find($request->transactionId);        //    return $clientId;
 
 if($request->clientnamesearch_update==$transaction->customer_id){
     
 }else{
     
         $customerdata_old_account = financial_accounts::find($transaction->customer_id);
         $customerdata_new_account = financial_accounts::find($request->clientnamesearch_update);


     credittransactions::find($request->transactionId)->update([
         'customer_id'=>$request->clientnamesearch_update
         ]);
     
     
      
         if($customerdata_new_account->account_type==1||$customerdata_new_account->account_type==4){
    $financial_accounts= financial_accounts::find($request->clientnamesearch_update);
    financial_accounts::find($request->clientnamesearch_update)->update(['debtor_current'=>$financial_accounts->debtor_current + $request->cashreceivedupdate,]); 
     }else{
    $financial_accounts= financial_accounts::find($request->clientnamesearch_update);
    financial_accounts::find($request->clientnamesearch_update)->update(['debtor_current'=>$financial_accounts->debtor_current+ $request->cashreceivedupdate,]); 
     }
           if($financial_accounts->orginal_type==2){
               $customerdata = supllier::where('id', $financial_accounts->orginal_id)->first();
     $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->update(
        ['In_debt' => $customerdata->In_debt +$request->cashreceivedupdate,
        'updated_at'  =>  \Carbon\Carbon::now()->addHours(3)]);
    }
        if($financial_accounts->orginal_type==3){
          $expense=  expenses::where('type',2)->where('Transaction_id',$request->transactionId)->update(['reasonId_id'=>$financial_accounts->orginal_id]);
        }
           if($customerdata_old_account->account_type==1||$customerdata_old_account->account_type==4){
                  $financial_accounts= financial_accounts::find($transaction->customer_id);
    financial_accounts::find($transaction->customer_id)->update(['debtor_current'=>$financial_accounts->debtor_current-$transaction->recive_amount ,]); 
            if($financial_accounts->orginal_type==2){
    $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->first();
    $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->update(
        ['In_debt' => $customerdata->In_debt -$transaction->recive_amount,
        'updated_at'  =>  \Carbon\Carbon::now()->addHours(3)]); 
           }
           }
           else{
    $financial_accounts= financial_accounts::find($transaction->customer_id);
    financial_accounts::find($transaction->customer_id)->update(['debtor_current'=>$financial_accounts->debtor_current-$transaction->recive_amount ,]); 
            if($financial_accounts->orginal_type==2){
    $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->first();
    $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->update(
        ['In_debt' => $updateCustomer->In_debt -$transaction->recive_amount,
        'updated_at'  =>  \Carbon\Carbon::now()->addHours(3)]);
    }
       
      
     }
        


 }
 
 
 
 
$decument_id_recipt= $transaction->sent_serf_count;
        $clientId=$transaction->customer_id;
   $suplliertId = $transaction->customer_id;
   $financial_accounts= financial_accounts::find($newcustomer);

$payment_new_text=$financial_accounts->name;

            $financial_accounts= financial_accounts::where('name',$transaction->Pay_Method_Name)->first();
            $old_payment_id=$financial_accounts->id;
            $parent_payment_old=$financial_accounts->parent_account_number;
            financial_accounts::find($financial_accounts->id)->update(
               [
                 'current_balance'=> $financial_accounts->current_balance+$transaction->recive_amount ,
                'creditor_current'=>$financial_accounts->creditor_current- $transaction->recive_amount ,

               ]
               ); 
          $financial_accounts= financial_accounts::find( $parent_payment_old);
    financial_accounts::find($parent_payment_old)->update(
       [
              'current_balance'=> $financial_accounts->current_balance+$transaction->recive_amount ,
                'creditor_current'=>$financial_accounts->creditor_current- $transaction->recive_amount ,

       ]
       ); 
       
     
       
        credittransactions::where('customer_id',$old_payment_id)->where('decument_id',$request->transactionId)->update(
            [
               
                'customer_id' => $newcustomer,
                'recive_amount' => $request->cashreceivedupdate,
                'Pay_Method_Name' => $payment_new_text,
                'creditor'=> $request->cashreceivedupdate, 
'type'=>$type,


            ]
        );
        
            $financial_accounts_new= financial_accounts::where('id',$newcustomer)->first();
            credittransactions::where('customer_id',$parent_payment_old)->where('decument_id',$request->transactionId)->update(
            [
               
                'customer_id' => $financial_accounts_new->parent_account_number,
                'recive_amount' => $request->cashreceivedupdate,
                'Pay_Method_Name' => $payment_new_text,
                'creditor'=> $request->cashreceivedupdate, 

'type'=>$type,

            ]
        );
        
        
        
        
            
         
        


 
     if( $transaction->vat)
     {
         
         $total_value_old=$transaction->recive_amount ;
         $total_value=$request->cashreceivedupdate;
         
  $financial_accounts= financial_accounts::find(102);
    financial_accounts::find(102)->update(
     [
         
                 'current_balance'=>  ($financial_accounts->debtor_current+($total_value-($total_value*100/115))-($total_value_old-($total_value_old*100/115)))- ($financial_accounts->creditor_current),

            // 'current_balance'=> $financial_accounts->current_balance+($total_value-($total_value*100/115))-($total_value_old-($total_value_old*100/115)),
         'debtor_current'=>$financial_accounts->debtor_current+($total_value-($total_value*100/115))-($total_value_old-($total_value_old*100/115)),

     ]
     ); 

 credittransactions::where('customer_id',102)->where('decument_id',$request->transactionId)->update(
            [
               
                'recive_amount' => $total_value-($total_value*100/115),
                'pay_method' => $payment_new_text,
                'currentblance'=> ($financial_accounts->debtor_current+($total_value-($total_value*100/115))-($total_value_old-($total_value_old*100/115)))- ($financial_accounts->creditor_current),

                'Pay_Method_Name' => $payment_new_text,
                'debtor'=> $total_value-($total_value*100/115),
               'type'=>$type,



            ]
        );
          $financial_accounts= financial_accounts::where('parent_account_number',102)->where('branchs_id', Auth()->user()->branchs_id)->first();
    financial_accounts::where('parent_account_number',102)->where('branchs_id', Auth()->user()->branchs_id)->update(
       [
            'current_balance'=> $financial_accounts->current_balance+($total_value-($total_value*100/115))-($total_value_old-($total_value_old*100/115)),
         'debtor_current'=>$financial_accounts->debtor_current+($total_value-($total_value*100/115))-($total_value_old-($total_value_old*100/115)),

       ]
       ); 


     }



     

    $financial_accounts= financial_accounts::find($request->payupdate);
    financial_accounts::find($request->payupdate)->update(
       [
           'current_balance'=> $financial_accounts->current_balance-$request->cashreceivedupdate,
           'creditor_current'=>$financial_accounts->creditor_current+$request->cashreceivedupdate,

       ]
       ); 
$parent_new_id=$financial_accounts->parent_account_number;
        
    $financial_accounts= financial_accounts::find($parent_new_id)->first();
    financial_accounts::find($parent_new_id)->update(
       [
           'current_balance'=> $financial_accounts->current_balance-$request->cashreceivedupdate,
           'creditor_current'=>$financial_accounts->creditor_current+$request->cashreceivedupdate,

       ]
       ); 
 
    
   
      
      
   //    return $clientId;
        $customerdata = financial_accounts::find($clientId);

     
    if($customerdata->account_type==1||$customerdata->account_type==4){

     
    $financial_accounts= financial_accounts::find($clientId);
    financial_accounts::find($clientId)->update(
     [
         'current_balance'=>$financial_accounts->current_balance-$transaction->recive_amount+$request->cashreceivedupdate,
        'debtor_current'=>$financial_accounts->debtor_current-$transaction->recive_amount + $request->cashreceivedupdate,

     ]
     ); 
     
           credittransactions::where('id',$request->transactionId)->update(
            [
                'recive_amount' => $request->cashreceivedupdate,
                'currentblance'=>$financial_accounts->current_balance-$transaction->recive_amount + $request->cashreceivedupdate,
                'Pay_Method_Name' => $payment_new_text,
                'debtor'=> $request->cashreceivedupdate, 
                'type'=>$type,

            ]
        );
     }
     
     else{
             
    $financial_accounts= financial_accounts::find($clientId);
    financial_accounts::find($clientId)->update(
     [
         'current_balance'=>$financial_accounts->current_balance+$transaction->recive_amount - $request->cashreceivedupdate,
         'debtor_current'=>$financial_accounts->debtor_current-$transaction->recive_amount + $request->cashreceivedupdate,

     ]
     ); 
     
           credittransactions::where('id',$request->transactionId)->update(
            [
                'recive_amount' => $request->cashreceivedupdate,
                'currentblance'=>$financial_accounts->current_balance+$transaction->recive_amount - $request->cashreceivedupdate,
                'Pay_Method_Name' => $payment_new_text,
                'debtor'=> $request->cashreceivedupdate, 
                'type'=>$type,

            ]
        );
     }
     
     
     














    if($financial_accounts->orginal_type==2){
     $updateCustomer = supllier::where('id', $financial_accounts->orginal_id)->update(
        [
            'In_debt' => $customerdata->current_balance +$transaction->recive_amount-$request->cashreceivedupdate,
            'updated_at'  =>  \Carbon\Carbon::now()->addHours(3),

        ]
    );
    
 
    }
    
               if($financial_accounts->orginal_type==3){
                   


  $expense=  expenses::where('type',2)->where('Transaction_id',$request->transactionId)->update([
           
            'Pay_Method_Name'=>$payment_new_text,
            'updated_at'  =>  \Carbon\Carbon::now()->addHours(3), 
            'Theـamountـpaid'=>$request->cashreceivedupdate,
         
        ]);
        }
 
    
    
  

        $credittransactions=credittransactions::where( 'sent_serf_count' ,$decument_id_recipt)->where('type_decument',2)->get();
        $data=[];
        $pay='';
              foreach($credittransactions as $item){
             
                  $date=$item->created_at;
                       $data []=[
                        'sent_serf_count'=>$decument_id_recipt,
                        'id' =>  $item->id,
                        'name' => $item->financial_accounts_data->name,
                        'method_pay' => $item->Pay_Method_Name,
                        'paid_amount' => $item->recive_amount
                
        
                ];
                    
                }
        
                 return $data;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\credittransactions  $credittransactions
     * @return \Illuminate\Http\Response
     */
    public function show(credittransactions $credittransactions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\credittransactions  $credittransactions
     * @return \Illuminate\Http\Response
     */
    public function edit(credittransactions $credittransactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\credittransactions  $credittransactions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, credittransactions $credittransactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\credittransactions  $credittransactions
     * @return \Illuminate\Http\Response
     */
    public function destroy(credittransactions $credittransactions)
    {
        //
    }
}