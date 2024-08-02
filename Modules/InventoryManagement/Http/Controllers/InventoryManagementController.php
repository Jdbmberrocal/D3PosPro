<?php

namespace Modules\InventoryManagement\Http\Controllers;

use App\Product;
use App\Variation;
use App\Transaction;
// FIles
use App\PurchaseLine;
use App\BusinessLocation;
use App\Utils\ModuleUtil;
use App\Utils\ProductUtil;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Utils\TransactionUtil;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\PurchaseLine as productQuantity;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Modules\InventoryManagement\Entities\inventoryProducts;
use Modules\InventoryManagement\Entities\InventoryTransaction;
use Modules\InventoryManagement\Entities\Inventory as InventoryModel;


// use App\BusinessLocation;



class InventoryManagementController extends Controller
{
    private $duplicatedBranchProducts = array();
    protected $productUtil;
    protected $transactionUtil;
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ProductUtil $productUtil, TransactionUtil $transactionUtil, ModuleUtil $moduleUtil)
    {
        $this->productUtil = $productUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
    }
    public function updateStatus($id,Request $request){
            $inventory =  InventoryModel::business()->with("products","products.variations")->where("id" , $id)->firstOrFail();
            $validated = $request->validate(['new_status' => 'required|boolean']);
            $inventory->update(['status'=> request('new_status')]);
            return response()->json(['status'=>true,'msg'=>__('inventorymanagement::inventory.inv_updated')]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');
        $branches = BusinessLocation::where('business_id',$business_id)->get();
        
        return view('inventorymanagement::index',compact('branches'));
    }
    


    public function createNewInventory(Request $request){

        $branchId = $request->branch;
        $inventoryStartDate = $request->inventory_start_date;
        $inventoryEndDate = $request->inventory_end_date;
        $business_id = request()->session()->get('user.business_id');
        $locations = BusinessLocation::where('business_id', $business_id)->where('id',$branchId)->exists();
        // as we create new inventory we will mark it as opened always till the user close it.
         $openCaseStatus = 1;
         if($locations){

             InventoryModel::create([
                     "branch_id" => $branchId ,
                     "created_at" => $inventoryStartDate,
                     "end_date" => $inventoryEndDate,
                     "status" => $openCaseStatus
                 ]
             );
         }
        
        return redirect(action('\Modules\InventoryManagement\Http\Controllers\InventoryManagementController@showInventoryList'));
    }
    
    public function showInventoryList(){
        $business_id = request()->session()->get('user.business_id');
        $inventories = InventoryModel::business()->with('branch')->orderBy('id','desc')->get();
        return view("inventorymanagement::showInventoryList" , compact("inventories"));
    }


    public function makeInevtory($id){
        //
        $duplicatedProductQuantity = array();
        $quantityProductsArray = array();
        $business_id = request()->session()->get('user.business_id');

        $inventories =  InventoryModel::business()->with("products")->where("id" , $id)->firstOrFail();

        if($inventories){
            $location_id = $inventories->branch_id;
            $location_content = $inventories->id .'_'. $inventories->branch_id;
            $productsIds = $inventories->products->pluck('id'); 
            $vairationsIds = $inventories->products->pluck('pivot.variation_id'); 
            // dd($productsIds);
            $products = Product::whereIn('products.id', $productsIds)
            ->join('variations as vrs','products.id','=','vrs.product_id')
            ->whereIn('vrs.id',$vairationsIds)
            ->leftjoin('variation_location_details as vrs_branch','vrs.id','vrs_branch.variation_id')
            ->where('vrs_branch.location_id',$location_id)
            ->select(
            'vrs_branch.qty_available as qty_left',
            'vrs.id as var_id',
            'vrs.name as var_name',
            'products.id as id',
            'products.sku as sku',
            'products.type as type',
            'vrs.sub_sku as sub_sku',
            'products.name as name',
            )
            ->ForLocation($location_id)
            ->get();
                // dd($products);
        foreach ($inventories->products as $product){


            if(Session::has("duplicatedProductsPerBranch") && !empty(Session::get('duplicatedProductsPerBranch')[$location_content])){
                $needle[$location_content] = Session::get('duplicatedProductsPerBranch')[$location_content];
            }else{
                $needle[$location_content] = [];
            }



            $variations = Variation::where('product_id', $product->id)
            ->whereHas('variation_location_details' , function ($q) use ($location_id) {
                $q->where('location_id', $location_id);
            })->with(['product_variation','variation_location_details' => function ($q) use ($location_id) {
                        $q->where('location_id', $location_id);}])->first();


            if($variations->count()){
                $product_qty = $variations->variation_location_details[0]->qty_available;


                    $productQuantity = intval($product_qty);


                if(! in_array($variations->id , $needle[$location_content])){
                    array_push($needle[$location_content] , $variations->id);
                    Session::put("duplicatedProductsPerBranch" , $needle);
                }
            }
        }




    }
        if($inventories->status){
            
            return view("inventorymanagement::makeInventory",
            compact("id" , "inventories" , "quantityProductsArray",'products'));
        }else{
            return view("inventorymanagement::closed",
            compact("id" , "inventories" , "quantityProductsArray",'products'));
        }
    }

    /**
     * Retrieves product list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProductData(Request $request)
    {
        try{
            $values = Crypt::decrypt($request->values);
                //inv_id,var_id,product_inv_id
            // dump($values);
            $inventory = InventoryModel::business()->where('id',$values['inv_id'])->with('branch','products')->orderBy('id','desc')->firstOrFail();
            // dump($inventory->products);
            $location_id = $inventory->branch_id;

            $productVar = $inventory->products->where('pivot.variation_id',$values['var_id'])->first();

            $variation = Variation::where('id', $values['var_id'])
                ->whereHas('variation_location_details' , function ($q) use ($location_id) {
                    $q->where('location_id', $location_id);
                })
                    ->with([
                        'product_variation',
                        'variation_location_details' => function ($q) use ($location_id) {
                            $q->where('location_id', $location_id);
                        }
                        
                    ])->first();

            $product_qty = $variation->variation_location_details[0]->qty_available;
            //
            $productname =  $productVar->name . ($productVar->type == 'single'?'':' ( '. $variation->name .' )');

            return response()->json([
                'diff_product'=>($productVar->pivot->amount_after_inventory - $productVar->pivot->qty_before),
                'product_name'=>$productname,
                'qty_before'=>intval($productVar->pivot->qty_before),
                'qty_now'=>intval($product_qty),
                'qty_after'=>intval($productVar->pivot->amount_after_inventory),
            ]);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    public function getProducts($id)
    {
        $business_id = request()->session()->get('user.business_id');
        
        $inventoryModel  = InventoryModel::business()->with('products')->findOrFail($id);
        $locations = BusinessLocation::where('business_id', request()->session()->get('user.business_id'))->get();
        $business_id = $inventoryModel->branch_id;
        $variationsIds = $inventoryModel->products->pluck('pivot.variation_id');
        // dd();
        if (request()->ajax()) {
            $term = request()->term;

            $check_enable_stock = true;
            if (isset(request()->check_enable_stock)) {
                $check_enable_stock = filter_var(request()->check_enable_stock, FILTER_VALIDATE_BOOLEAN);
            }

            $only_variations = false;
            if (isset(request()->only_variations)) {
                $only_variations = filter_var(request()->only_variations, FILTER_VALIDATE_BOOLEAN);
            }

            if (empty($term)) {
                return response()->json(["NotFound" => true,'status'=>false]);
            }
            $location_content = request()->input("inventory_id") .'_'. $business_id;
            $getSessionVariations = Session::get('duplicatedProductsPerBranch') ?? [];
            // dd($business_id);
            $q = Product::leftJoin(
                'variations',
                'products.id',
                '=',
                'variations.product_id'
            )->leftJoin(
                'product_locations',
                'products.id',
                '=',
                'product_locations.product_id'
            )
            ->whereNotIn('variations.id',$variationsIds)
            ->where('product_locations.location_id',$business_id)
                ->where(function ($query) use ($term) {
                    $query->where('products.name', 'like', '%' . $term .'%');
                    $query->orWhere('sku', 'like', '%' . $term .'%');
                    $query->orWhere('sub_sku', 'like', '%' . $term .'%');
                })
                ->active()
                ->where('business_id', request()->session()->get('user.business_id'))
                ->whereNull('variations.deleted_at')
                ->where('products.enable_stock',1)
                ->select(
                    'products.id as product_id',
                    'products.name',
                    'products.type',
                    'products.enable_stock',

                    'variations.id as variation_id',
                    'variations.name as variation',
                    'variations.sub_sku as sub_sku'
                )
                ->groupBy('variation_id');

            if ($check_enable_stock) {
                $q->where('enable_stock', 1);
            }

            if (!empty(request()->location_id)) {
                $q->ForLocation($locations->pluck('id'));
            }
            $products = $q->get();
            // dd($products);
            $products_array = [];
            foreach ($products as $product) {
                $products_array[$product->product_id]['name'] = $product->name;
                $products_array[$product->product_id]['sku'] = $product->sub_sku;
                $products_array[$product->product_id]['type'] = $product->type;
                // if($product->type == 'variable')
                $products_array[$product->product_id]['variations'][]
                    = [
                    'variation_id' => $product->variation_id,
                    'variation_name' => $product->variation,
                    'sub_sku' => $product->sub_sku
                ];
            }

            $result = [];
            $i = 1;
            $no_of_records = $products->count();
            // dd($products_array);
            if (!empty($products_array)) {
                foreach ($products_array as $key => $value) {
                    $name = $value['name'];
                    if ($value['type'] != 'variable') {
                        // dd($value['variations']);
                        $result[] = [ 
                            'id' => $i,
                            'text' => $name . ' - ' . $value['sku'],
                            'variation_id' => $value['variations'][0]['variation_id'],
                            'product_id' => $key
                        ];
                    }elseif($value['type'] == 'variable'){
                        foreach ($value['variations'] as $variation) {
                            $text = $name;
                            if ($value['type'] == 'variable') {
                                $text = $text . ' (' . $variation['variation_name'] . ')';
                            }
                            $i++;
                            $result[] = [ 
                                'id' => $i,
                                'text' => $text . ' - ' . $variation['sub_sku'],
                                'product_id' => $key ,
                                'variation_id' => $variation['variation_id'],
                            ];
                        }
                    }
                    
                    $i++;
                }
            }else{
                $result  = [["NotFound" => true,'status'=>false]];
            }

            // dd(response()->json($products));
            return response()->json($result);
        }
        
    }

    /**
     * Retrieves products list.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPurchaseEntryRow(Request $request)
    {
        if (request()->ajax()) {
            $product_id = $request->input('product_id');
            $currentBussiness = request()->session()->get('user.business_id');

            $variation_id = $request->input('variation_id');
            $business_id  = InventoryModel::business()->find($request->input("inventory_id"));
            $location_id = $business_id->branch_id;







            if (!empty($product_id)) {

                $product = Product::where('business_id',$currentBussiness)->where('id', $product_id)
                    ->first();

        


                $query = Variation::where('product_id', $product_id)
                ->whereHas('variation_location_details' , function ($q) use ($location_id) {
                    $q->where('location_id', $location_id);
                })
                    ->with([
                        'product_variation',
                        'variation_location_details' => function ($q) use ($location_id) {
                            $q->where('location_id', $location_id);
                        }
                        
                    ]);
                if ($variation_id !== '0') {$query->where('id', $variation_id);}
                $variations = $query->first();
                if($variations->count()){
                    $product_qty = $variations->variation_location_details[0]->qty_available;

                    $productQuantity = $variations;
    
                    if($variations->count() && $product_qty > 0){
                        $productQuantity = intval($product_qty);
                    }else{
                        return response()->json([
                             'msg' => [
                                'title'=>__('inventorymanagement::inventory.empty_qty_product'),
                                'text'=>__('inventorymanagement::inventory.plz_add_qty_product')
                                ],
                            'status' => false
                        ]);
                    }
    
                    $location_content = $request->input("inventory_id") .'_'. $location_id;
                    if(Session::has("duplicatedProductsPerBranch") && !empty(Session::get('duplicatedProductsPerBranch')[$location_content])){
                        $needle[$location_content] = Session::get('duplicatedProductsPerBranch')[$location_content];
                    }else{
                        $needle[$location_content] = array();
                    }
                    if(! in_array($variations->id , $needle[$location_content])){
                        array_push($needle[$location_content] , $variations->id);
                        Session::put("duplicatedProductsPerBranch" , $needle);
                    }else{
                        return response()->json(['msg'=>[
                            'title'=>__('inventorymanagement::inventory.oops'),
                            'text'=>__('inventorymanagement::inventory.product_al_exists')
                    ],'status'=>false]);
                    }
                    Session::remove('duplicatedProductsPerBranch');
                    return view('inventorymanagement::partials.tablerow',compact(
                        'product',
                        'variations',
                        "productQuantity"
                    ));
                }else{
                    return response()->json(['msg'=>['title'=>__('inventorymanagement::inventory.oops'),'text'=>__('inventorymanagement::inventory.notfound')],'status'=>false]);
                }

            }
        }
    }

    public function updateProductQuantity(Request $request){
        if (request()->ajax()) {
            try{
                DB::beginTransaction();

                $values = Crypt::decrypt($request->values);
                $newQty = request('new_qty');
                    //inv_id,var_id,product_inv_id
                // dump($values);
                $inventory = InventoryModel::business()->where('id',$values['inv_id'])->with('branch','products')->orderBy('id','desc')->firstOrFail();
                // dump($inventory->products);

                $location_id = $inventory->branch_id;
    
                $productVar = $inventory->products->where('pivot.variation_id',$values['var_id'])->first();
                // dd($productVar->pivot->id);
                $product_inventory = inventoryProducts::whereId($productVar->pivot->id)->first();
                // dd($inventory->products);
                $product_id = $product_inventory->product_id;
                $variation_id = $values['var_id'];
                $variation = Variation::where('id', $values['var_id'])
                    ->whereHas('variation_location_details' , function ($q) use ($location_id) {
                        $q->where('location_id', $location_id);
                    })
                        ->with([
                            'product_variation',
                            'variation_location_details' => function ($q) use ($location_id) {
                                $q->where('location_id', $location_id);
                            }
                            
                        ])->first();
    
                $product_qty = $variation->variation_location_details[0]->qty_available;
                $numberDifference = $newQty - $product_qty ;
                $inventory_type = 'inventory_' . ($newQty < $product_qty ? 'decrease':'increase') ;

                $product_inventory->update([
                        'inventory_type' => $inventory_type,
                        'amount_after_inventory' => $newQty,
                        'qty_before' => $product_qty,
                        'Amount_difference' => $numberDifference,
                    ]);

                if($numberDifference > 0){
                    $updateQty =  $this->productUtil->updateProductQuantity($location_id, $product_id, $variation->id, $numberDifference);

                }else{
                    $updateQty = $this->productUtil->decreaseProductQuantity(
                        $product_id,
                        $variation_id,
                        $location_id,
                        abs($numberDifference)
                    );

                }
                DB::commit();
                return response()->json([
                    'status'=>true,
                    'msg'=>'Updated',
                ]);
            }catch (\Exception $e){
                DB::beginTransaction();
                return $e->getMessage();
            }
        }
    }

    public function saveInventoryProducts(Request $request){


        $data = $request->input("info");
        $getBranch = null;
        for($x = 0 ; $x < count($data ?? []); $x++){
            if( $data[$x]["amountAfterInventory"] <= 0 ){ continue; }
            
            try{
                $getBranch = InventoryModel::where('id',$data[$x]["inventory_id"])->firstOrFail()->branch_id;
                DB::beginTransaction();
                $product_id = $data[$x]["product_id"];
                $user_id = $request->session()->get('user.id');  
                $business_id =  $request->session()->get('user.business_id');



                
                $product = Product::where('business_id', $request->session()->get('user.business_id'))
                ->where('id', $product_id)
                ->with(['variations', 'product_tax'])->first();

    
        
                if (!empty($product) && $product->enable_stock == 1) {

                    $product_variation = Variation::where('id',$data[$x]["variation_id"])->where('product_id', $product_id)
                    ->with([
                        'product_variation',
                        'variation_location_details' => function ($q) use ($getBranch) {
                            $q->where('location_id', $getBranch);
                        }
                    ])->first();
    
                    $product_qty = $product_variation->variation_location_details[0]->qty_available;
    
                    $newQty = $data[$x]["amountAfterInventory"];
                    $numberDifference = $newQty - $product_qty;
    
                    
                    $inventory_type = 'inventory_' . ($newQty < $product_qty  ? 'decrease':'increase') ;
    
                    
                    $transaction = Transaction::create([
                        'business_id'=>$business_id,
                        'created_by'=>$user_id,
                        'transaction_date'=>now(),
                        'status'=>'final',
                        'type'=>'inventory',
                        'location_id'=>$getBranch,
                    ]);
    
                    $inventoryManagement = inventoryProducts::create([
                        "inventory_id" => $data[$x]["inventory_id"],
                        "product_id" => $data[$x]["product_id"],
                        "Amount_difference" => $numberDifference,
                        "amount_after_inventory" => $data[$x]["amountAfterInventory"],
                        "inventory_type" => $inventory_type,
                        "qty_before" => $product_qty,
                        "transaction_id" => $transaction->id,
                        "variation_id" => $product_variation->id,
                    ]);
                    

                    if($numberDifference > 0){
                        $updateQty =  $this->productUtil->updateProductQuantity($getBranch, $data[$x]['product_id'], $data[$x]['variation_id'], $numberDifference);

                    }else{
                        $updateQty = $this->productUtil->decreaseProductQuantity(
                            $data[$x]["product_id"],
                            $data[$x]["variation_id"],
                            $getBranch,
                            abs($numberDifference)
                        );

                    }
                    }
                    

                DB::commit();
                
            }catch(\Exception $e){
                DB::rollBack();
                // dd($e,$e->getMessage());
                return $e->getMessage();
            }
        }
        Session::forget("duplicatedProductsPerBranch");
        return response()->json([
            "status" => 200
        ]);
    }

    public function showInventoryReports ($id , $branch_id){
        $duplicatedProductQuantity = [];
        $inventories =  InventoryModel::with("products")->business()->where("id" , $id)->first();

        $branch = BusinessLocation::where('business_id', request()->session()->get('user.business_id'))->findOrFail($branch_id);
        $notExistProductIds = $inventories->products->pluck('pivot.variation_id');
        $location_id = $branch->id;

        $variationsIn = Variation::whereIn('id', $inventories->products->pluck('pivot.variation_id'))
            ->whereHas('variation_location_details' , function ($q) use ($location_id) {
                $q->where('location_id', $location_id);
            })
            ->with(['variation_location_details' => function ($q) use ($location_id) {
                        $q->where('location_id', $location_id);}
                ])->get();
        $notExistsProducts = Product::join('variations as vrs','products.id','=','vrs.product_id')
        ->whereNotIn('vrs.id', $notExistProductIds)
        ->leftjoin('variation_location_details as vrs_branch','vrs.id','vrs_branch.variation_id')
        ->where('vrs_branch.location_id',$location_id)
        ->select(
        'vrs_branch.qty_available as qty_left',
        'vrs.id as var_id',
        'vrs.name as var_name',
        'products.id as id',
        'products.sku as sku',
        'products.type as type',
        'vrs.sub_sku as sub_sku',
        'products.name as name',
        )
        ->ForLocation($location_id)
        ->get();
            // dd($notExistsProducts);
        return view("inventorymanagement::showInventoryReports" ,
        compact("inventories" , "notExistsProducts" ,'variationsIn'));
    }

    public function inventoryIncreaseReports($inventory_id , $branch_id){

        $increaseProductReport = array();

        $inventories =  InventoryModel::business()->with("products")->where("id" , $inventory_id)->first();

        $location_id = $inventories->branch_id;
        $increaseProductReport = $inventories->products->where('pivot.inventory_type','inventory_increase');

        $vairationsIds = $increaseProductReport->pluck('pivot.variation_id');
        
        $variations = Variation::whereIn('id',$vairationsIds)
        ->whereHas('variation_location_details', function ($q) use ($location_id) {
            $q->where('location_id', $location_id);
        })
        ->with(['product_variation','variation_location_details' => function ($q) use ($location_id) {
                    $q->where('location_id', $location_id);}
            ])->get();

        return view("inventorymanagement::increaseReports" , compact("increaseProductReport",'variations'));
    }

    public function inventoryDisabilityReports($inventory_id , $branch_id){


        $inventories =  InventoryModel::business()->with("products")->where("id",$inventory_id)->first();
        $location_id = $inventories->branch_id;
        $disabilityProductReport = $inventories->products->where('pivot.inventory_type','inventory_decrease');
        $vairationsIds = $disabilityProductReport->pluck('pivot.variation_id');
        
        $variations = Variation::whereIn('id',$vairationsIds)->whereHas('variation_location_details' , function ($q) use ($location_id) {
            $q->where('location_id', $location_id);
        })->with(['product_variation','variation_location_details' => function ($q) use ($location_id) {
                    $q->where('location_id', $location_id);}
            ])->get();


        return view("inventorymanagement::disabilityReports" , compact("disabilityProductReport" ,"variations"));
    }
}
