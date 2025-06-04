<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class EventController extends Controller
{
   
    public function update(Request $request, $id)
{
    $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'nullable|string',
        'date' => 'required|date',
        'acces_parents' => 'nullable|boolean',
        'acces_enseignants' => 'nullable|boolean',
        'acces_eleves' => 'nullable|boolean',
    ]);

    $event = Event::findOrFail($id);
    $event->update([
        'titre' => $request->titre,
        'description' => $request->description,
        'date' => $request->date,
        'acces_parents' => $request->has('acces_parents'),
        'acces_enseignants' => $request->has('acces_enseignants'),
        'acces_eleves' => $request->has('acces_eleves'),
    ]);

    return redirect()->route('events.index')->with('success', 'Événement mis à jour avec succès.');
}
public function destroy($id)
{
    $event = Event::findOrFail($id);
    $event->delete();

    return redirect()->route('events.index')->with('success', 'Événement supprimé avec succès.');
}
public function edit($id)
{
    $event = Event::findOrFail($id);
    return view('events.edit', compact('event'));
}
   public function participate($id)
{
    $event = Event::findOrFail($id);
    $event->participants()->attach(auth()->id());

    return back()->with('success', 'Inscription réussie !');
}

  public function index()
{
    $user = Auth::user();

    if ($user->isAdmin()) {
        $events = Event::with('participants')->get(); // admin voit tout
    } elseif ($user->isEnseignant()) {
        $events = Event::where('acces_enseignants', true)->get();
    } elseif ($user->isParent()) {
        $events = Event::where('acces_parents', true)->get();
    } elseif ($user->isEleve()) {
        $events = Event::where('acces_eleves', true)->get();
    } else {
        $events = collect(); // aucun accès
    }

    return view('events.index', compact('events'));
}


public function create()
{
    if (!auth()->user()->isAdmin()) {
        abort(403);
    }
    return view('events.create');
}

public function store(Request $request)
{
    $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'date' => 'required|date|after_or_equal:today',
    ]);

    Event::create([
        'titre' => $request->titre,
        'description' => $request->description,
        'date' => $request->date,
        'acces_parents' => $request->has('acces_parents'),
        'acces_enseignants' => $request->has('acces_enseignants'),
        'acces_eleves' => $request->has('acces_eleves'),
    ]);

    return redirect()->route('events.index')->with('success', 'Événement créé avec succès.');
}


}
