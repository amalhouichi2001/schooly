<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Affiche la liste des utilisateurs pour démarrer une conversation.
     */
    public function index()
    {
        // Exclure l'utilisateur connecté de la liste
        $users = User::where('id', '!=', Auth::id())->get();
        return view('messages.index', compact('users'));
    }

    /**
     * Affiche les messages échangés avec un utilisateur donné.
     */
    public function show(User $user)
    {
        // Empêche l'utilisateur de discuter avec lui-même
        if ($user->id === Auth::id()) {
            abort(403, 'Vous ne pouvez pas discuter avec vous-même.');
        }

        // Marquer comme lus les messages reçus et non lus
        Message::where('from_id', $user->id)
            ->where('to_id', Auth::id())
            ->where('lu', false)
            ->update(['lu' => true]);

        // Récupérer les messages entre l'utilisateur connecté et l'autre utilisateur avec pagination
        $messages = Message::where(function ($query) use ($user) {
            $query->where('from_id', Auth::id())
                  ->where('to_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('from_id', $user->id)
                  ->where('to_id', Auth::id());
        })
        ->orderBy('created_at', 'asc')
        ->paginate(20); // Paginer les messages

        return view('messages.chat', compact('user', 'messages'));
    }

    /**
     * Enregistre un nouveau message envoyé à un utilisateur.
     */
    public function store(Request $request, User $user)
    {
        // Empêche l'envoi de messages à soi-même
        if ($user->id === Auth::id()) {
            abort(403, 'Vous ne pouvez pas vous envoyer un message.');
        }

        // Validation du contenu du message
        $validated = $request->validate([
            'contenu' => 'required|string|max:1000',
        ]);

        // Création du message
        Message::create([
            'from_id' => Auth::id(),
            'to_id' => $user->id,
            'contenu' => $validated['contenu'],
            'lu' => false,
        ]);

        // Redirection vers la conversation
        return redirect()->route('messages.show', $user->id)
                         ->with('success', 'Message envoyé.');
    }
}
