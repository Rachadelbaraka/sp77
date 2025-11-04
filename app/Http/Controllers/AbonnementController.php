<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    public function index(Request $request)
    {
        $query = Abonnement::query();
        if ($request->filled('actif')) {
            $query->where('actif', (bool)$request->actif);
        }
        $abonnements = $query->orderBy('id','desc')->paginate(10);
        return view('abonnements.index', compact('abonnements'));
    }

    public function create()
    {
        return view('abonnements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100|unique:abonnements,nom',
            'duree_mois' => 'required|integer|min:1|max:36',
            'prix' => 'required|numeric|min:0',
            'actif' => 'sometimes|boolean',
        ]);

        $data['actif'] = $request->has('actif') ? (bool)$request->actif : true;

        Abonnement::create($data);

        return redirect()->route('abonnements.index')->with('success', 'Abonnement créé.');
    }

    public function show(Abonnement $abonnement)
    {
        return view('abonnements.show', compact('abonnement'));
    }

    public function edit(Abonnement $abonnement)
    {
        return view('abonnements.edit', compact('abonnement'));
    }

    public function update(Request $request, Abonnement $abonnement)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:100|unique:abonnements,nom,' . $abonnement->id,
            'duree_mois' => 'required|integer|min:1|max:36',
            'prix' => 'required|numeric|min:0',
            'actif' => 'sometimes|boolean',
        ]);

        $data['actif'] = $request->has('actif') ? (bool)$request->actif : false;

        $abonnement->update($data);

        return redirect()->route('abonnements.index')->with('success', 'Abonnement mis à jour.');
    }

    public function destroy(Abonnement $abonnement)
    {
        $abonnement->delete();
        return redirect()->route('abonnements.index')->with('success', 'Abonnement supprimé.');
    }
}
