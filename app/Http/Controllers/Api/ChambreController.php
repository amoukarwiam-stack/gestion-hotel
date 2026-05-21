<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chambre;
use Illuminate\Http\Request;

class ChambreController extends Controller
{
     public function index()
    {
        return Chambre::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|unique:chambres',
            'type' => 'required',
            'prix' => 'required|numeric',
            'disponible' => 'required|boolean'
        ]);

        $chambre = Chambre::create($request->all());

        return response()->json($chambre, 201);//json pour frontend
    }

    public function update(Request $request, $id)
    {
        $chambre = Chambre::findOrFail($id);

        $chambre->update($request->all());

        return response()->json($chambre);
    }

    public function destroy($id)
    {
        $chambre = Chambre::findOrFail($id);
        $chambre->delete();

        return response()->json(['message' => 'Chambre supprimée']);
    }
}
