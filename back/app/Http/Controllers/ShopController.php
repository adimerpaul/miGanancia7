<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ShopController extends Controller{
    public function index(Request $request){ return Shop::where('user_id',$request->user()->id)->get(); }
    public function show(Shop $shop,Request $request){
        $shop = Shop::where('id',$shop->id)->first();
        $shops = Shop::where('user_id',$request->user()->id)->get();
        return response()->json(['shop'=>$shop,'shops'=>$shops]);
    }
    public function store(Request $request){
        $request['avatar']=$request->user()->shopAvatar;
        if ($request['avatar']==null) {
            $request['avatar']='logo.png';
        }
        $shop=Shop::create($request->all());
        $this->shopStatusActive($request,$shop->id);
        $shops=Shop::where('user_id',$request->user()->id)->get();
        return response()->json([
            'shop' => Shop::find($shop->id),
            'shops' => $shops
        ]);
    }
    public function update(Request $request, Shop $shop){
        $shop->update($request->all());
        return $shop;
    }
    public function destroy(Shop $shop,Request $request){
        $shopCount=Shop::where('user_id',$request->user()->id)->count();
        if ($shopCount==1) {
            return response()->json([
                'message' => 'No puedes eliminar tu unica tienda'
            ], 401);
        }
        $shop->delete();
        $shops=Shop::where('user_id',$request->user()->id)->get();
        $shop=$shops[0];
        $this->shopStatusActive($request,$shop->id);
        return response()->json([
            'shops' => $shops,
            'shop' => $shop
        ]);
    }
    public function shopStatusActive(Request $request,$id){
        $user=User::find($request->user()->id);
        $user->shopAvatar=null;
        $user->shop_id=$id;
        $user->save();
        $shops=Shop::where('user_id',$request->user()->id)->get();
        foreach ($shops as $shop){
            $shop->status='inactive';
            $shop->save();
        }
        $shop=Shop::find($id);
        $shop->status='active';
        $shop->save();
    }
}
