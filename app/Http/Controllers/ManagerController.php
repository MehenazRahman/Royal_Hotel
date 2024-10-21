<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\FoodGallery;
use App\Models\Menu;
class ManagerController extends Controller
{
    public function add_menu(){

        return view('manager.add_menu');
    }

    public function add_item(Request $request)
    {

        $data = new Menu();

        $data->category = $request->category;
        $data->name = $request->name;
        $image  = $request -> image;
        if ($image){
            $imagename = time().'.'.$image -> getClientOriginalExtension(

            );
            $request -> image -> move('menu', $imagename);
            $data ->image = $imagename;
        }
        $data->ingredients = $request->ingredients;
        $data->price = $request->price;
        $data->original_price= $request->original_price;
        $data->review = $request->review;

        $data->save();

        return redirect() -> back();


    }
    public function view_menu(){
        $data = Menu::all();

        return view('manager.view_menu', compact('data'));
    }

    public function item_delete($id){

        $data = Menu::find($id);

        $data -> delete();

        return redirect() -> back();
    }

    public function update_item($id){

        $data = Menu::find($id);

        return view('manager.update_item', compact('data'));
    }

    public function edit_item(Request $request, $id){
        $data = Menu::find($id);

        $data -> category = $request -> category;
        $data->name = $request->name;
        $image = $request -> image;
        if ($image){
            $imagename = time().'.'.$image -> getClientOriginalExtension(

            );
            $request -> image -> move('menu', $imagename);
            $data ->image = $imagename;
        }
        $data->ingredients = $request->ingredients;
        $data->price = $request->price;
        $data->original_price= $request->original_price;
        $data->review = $request->review;

        $data->save();

        return redirect() -> back();
    }

    public function add_food_gallery(){

        $food_gallery = FoodGallery::all();

        return view('manager.add_food_gallery', compact('food_gallery'));
    }

    public function update_gallery(Request $request){
        $data = new FoodGallery;

        $image  = $request -> image;
        if ($image){
            $imagename = time().'.'.$image -> getClientOriginalExtension(

            );
            $request -> image -> move('food_gallery', $imagename);
            $data ->image = $imagename;
        }
        $data->food_title =$request -> food_title;
        $data -> food_description = $request -> food_description;

        $data -> save();

        return redirect() -> back();
    }

    public function delete_food_image($id){

        $data = FoodGallery::find($id);

        $data -> delete();

        return redirect() -> back();
    }

    public function view_reservation(){
        $reservation = Reservation::all();
        
        return view('manager.view_reservation', compact('reservation'));
    }

    public function delete_reservation($id){

        $reservation = Reservation::find($id);

        $reservation -> delete();

        return redirect() -> back();
    }

    public function approve_reservation($id){

        $reservation = Reservation::find($id);

        $reservation -> status='approved';
        $reservation -> save();

        return redirect() -> back();
    }

    public function cancel_reservation($id){

        $reservation = Reservation::find($id);

        $reservation -> status='canceled';
        $reservation -> save();

        return redirect() -> back();
    }

}
