<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rental;
use JWTAuth;
use Auth;

class RentalsController extends Controller
{
    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }


    public function add(Request $request) //fungsi untuk input rentalan baru
    {
        $rental = new Rental();
        $rental->nama_rental = $request->nama_rental;
        $rental->owner = $request->owner;
        $rental->alamat = $request->alamat;
        $rental->nomorhp = $request->nomorhp;
        $rental->email = $request->email;
        $rental->map = $request->map;
        $rental->save();

        if ($rental->save())
            return response()->json([
                'success' => true,
                'rental' => $rental,
            ]);
        else
            return response()->json([
                'success' => false,
                'rental' => 'Sorry bro salah nglebokne paling, nek ra yo rangerti'
            ], 500);
        }

    public function all() {
        $rental = Rental::get(['id','nama_rental', 'owner'])->toArray();
        $name = Auth::user()->name;
        return response()->json([
            'admin' => $name,
            'Hasil' => $rental
        ],200);
    }

    public function detail($id)
    {
        $rental = Rental::find($id);

        if (!$rental) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }

        return response()->json($rental);
    }

    public function edit(Request $request, $id) //fungsi untuk update rentalan
    {
        $rental = $this->find($id);

        if (!$rental) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, rentalan with id ' . $id . ' cannot be found'
            ], 400);
        }

        $updated = $rental->fill($request->all())->save();

        if ($updated) {
            return response()->json([
                'success' => true,
                'hasil' => $rental,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sorry bro raiso di update hehe'
            ], 500);
        }
    }

    public function destroy($id) //delete rentalan dengan parameter id
    {  $rental = Rental::find($id);


        if (!$rental) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, rental with id ' . $id . ' cannot be found'
            ], 400);
        }

        if ($rental->delete()) {
            return response()->json([
                'success' => 'berhasil dihapus dari peradaban bung!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'raiso dihapus je, ketoke salah'
            ], 500);
        }
    }
}
