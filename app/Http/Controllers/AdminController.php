<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ManagerController;
use App\Models\Discount;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\Bookings;
use App\Models\Gallery;
use App\Models\Contact;
use App\Models\FoodGallery;
use App\Models\Menu;


class AdminController extends Controller
{
    public function index(){

        if(Auth::id())
        {
            $usertype = Auth() -> user() -> usertype;

            if ($usertype == 'user'){
                
                $room = Room::all();
                $gallery= Gallery::all();
                $food_gallery= FoodGallery::all();
                $discount= Discount::all();

                return view('home.index', compact('room', 'gallery', 'food_gallery', 'discount'));
            }

            else if ($usertype == 'admin'){
                return view('admin.index');
            }

            else if ($usertype == 'manager'){
                return view('manager.index');
            }

            else{
                return redirect() -> back();
            }
        }
    }

    public function home(){
        $room = Room::all();

        $gallery= Gallery::all();

        $discount= Discount::all();

        return view('home.index',  compact('room','gallery', 'discount'));
    }

   

    public function create_room(){
        return view('admin.create_room');
    }


    public function add_room(Request $request){
        $data = new Room();

        $data -> room_title = $request -> title;
        $data -> bed = $request -> bed;
        $data -> size = $request -> size;
        $data -> bath = $request -> bath;
        $data -> price = $request -> price;
        $data -> room_type = $request -> type;

        $image = $request -> image;
        if ($image){
            $imagename = time().'.'.$image -> getClientOriginalExtension(

            );
            $request -> image -> move('room', $imagename);
            $data ->image = $imagename;
        }

        $data -> save();

        return redirect() -> back();
    }

    public function view_room(){
        $data = Room::all();
        return view('admin.view_room', compact('data'));
    }


    public function room_delete($id){

        $data = Room::find($id);

        $data -> delete();

        return redirect() -> back();
    }

    public function room_update($id){

        $data = Room::find($id);

        return view('admin.update_room', compact('data'));
    }

    public function edit_room(Request $request, $id){
        $data = Room::find($id);

        $data -> room_title = $request -> title;
        $data -> bed = $request -> bed;
        $data -> size = $request -> size;
        $data -> bath = $request -> bath;
        $data -> price = $request -> price;
        $data -> room_type = $request -> type;

        $image = $request -> image;
        if ($image){
            $imagename = time().'.'.$image -> getClientOriginalExtension(

            );
            $request -> image -> move('room', $imagename);
            $data ->image = $imagename;
        }

        $data -> save();

        return redirect() -> back();
    }

    public function bookings(){
        $data = Bookings::all();
        return view('admin.bookings', compact('data'));
    }

    public function delete_booking($id){

        $data = Bookings::find($id);

        $data -> delete();

        return redirect() -> back();
    }

    public function approve_booking($id){

        $data = Bookings::find($id);

        $data -> status='approved';
        $data -> save();

        return redirect() -> back();
    }

    public function cancel_booking($id){

        $data = Bookings::find($id);

        $data -> status='canceled';
        $data -> save();

        return redirect() -> back();
    }

    public function view_gallery(){
        $gallery = Gallery::all();

        return view('admin.view_gallery', compact('gallery'));
    }


    public function upload_gallery(Request $request){
        $data = new Gallery;

        $image  = $request -> image;
        if ($image){
            $imagename = time().'.'.$image -> getClientOriginalExtension(

            );
            $request -> image -> move('gallery', $imagename);
            $data ->image = $imagename;
        }

        $data -> save();

        return redirect() -> back();
    }

    public function delete_image($id){

        $data = Gallery::find($id);

        $data -> delete();

        return redirect() -> back();
    }
    

    public function all_messages(){

        $data = Contact::all();

        return view('admin.all_messages', compact('data'));
    }

    public function send_mail(){

        $data = Contact::all();

        return view('admin.send_mail');
    }

    public function add_offer(){
        $discount= Discount::all();
        return view('admin.add_offer', compact('discount'));
    }


    public function add_discount(Request $request){
        $data = new Discount();

        $data -> percentage= $request -> percentage;
        $data -> time = $request -> time;

        $data -> save();

        return redirect() -> back();
    }
    public function delete_discount($id){

        $discount = Discount::find($id);

        $discount -> delete();

        return redirect() -> back();
    }
}
