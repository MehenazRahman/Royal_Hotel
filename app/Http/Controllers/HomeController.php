<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\FoodGallery;
use App\Models\Gallery;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Menu;

class HomeController extends Controller
{
    public function room_details($id)
    {

        $room = Room::find($id);

        return view('home.room_details', compact('room'));

    }


    public function add_booking(Request $request, $id)
    {

        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'date|after::check_in',
        ]);

        $data = new Bookings;
        $data->room_id = $id;

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->rooms_no = $request->rooms_no;
        $data->children = $request->children;

        $check_in = $request->check_in;
        $check_out = $request->check_out;

        $isBooked = Bookings::where('room_id', $id)
            ->where('check_in', '<=', $check_out)
            ->where('check_out', '>=', $check_in)->exists();

        if ($isBooked) {
            return redirect()->back()->with('message', 'The room is already booked! Please try another date.');
        } else {
            $data->check_in = $request->check_in;
            $data->check_out = $request->check_out;
            $data->save();

            return redirect()->back()->with('message', 'Room Booked Successfully');
        }

    }


    public function contact(Request $request)
    {

        $contact = new Contact();

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;

        $contact->save();

        return redirect()->back()->with('message', 'Message Send Successfully');
    }


    public function our_room()
    {

        $room = Room::all();

        return view('home.our_room', compact('room'));

    }
    public function about_us()
    {

        return view('home.about_us');

    }
    public function our_gallery()
    {

        $gallery = Gallery::all();

        return view('home.our_gallery', compact('gallery'));

    }

    public function faq()
    {

        return view('home.faq');

    }
    public function restaurant()
    {
        $food_gallery = FoodGallery::all();
        $menu = Menu::all();

        return view('home.restaurant', compact('food_gallery', 'menu'));

    }
    public function services()
    {

        return view('home.services');

    }
    public function contact_us()
    {

        return view('home.contact_us');

    }

    public function food_gallery()
    {

        $food_gallery = FoodGallery::all();

        return view('home.restaurant', compact('food_gallery'));

    }

    public function reservation(Request $request)
    {

        $data = new Reservation();

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->date = $request->date;
        $data->time = $request->time;
        $data->person = $request->person;

        $data->save();

        return redirect()->back()->with('reservation_message', 'Table Booked Successfully');


    }

    public function check_booking(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'date|after::check_in',
            'adults' => 'nullable|integer|min:1',
            'children' => 'nullable|integer|min:0',
        ]);


        $check_in = $request->check_in;
        $check_out = $request->check_out;

        $isAvailable = Bookings::where('check_in', '<=', $check_out)
            ->where('check_out', '>=', $check_in)->exists();

        if ($isAvailable) {
            return redirect()->back()->with('messages', 'The room is already booked! Please try another date.');
        } 
        else {
            return redirect()->back()->with('messages', 'Rooms are available!');
        }
    }






}
