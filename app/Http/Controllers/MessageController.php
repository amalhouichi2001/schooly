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
    if ($user->id === Auth::id()) {
        abort(403, 'Vous ne pouvez pas discuter avec vous-même.');
    }

    // Marquer comme lus les messages reçus et non lus
    Message::where('sender_id', $user->id)
        ->where('receiver_id', Auth::id())
        ->where('status', 'sent') // tu peux aussi vérifier le statut "sent" au lieu de lu false
        ->update(['status' => 'read']);

    // Récupérer les messages entre l'utilisateur connecté et l'autre utilisateur avec pagination
    $messages = Message::where(function ($query) use ($user) {
        $query->where('sender_id', Auth::id())
              ->where('receiver_id', $user->id);
    })->orWhere(function ($query) use ($user) {
        $query->where('sender_id', $user->id)
              ->where('receiver_id', Auth::id());
    })
    ->orderBy('created_at', 'asc')
    ->paginate(20);

    return view('messages.chat', compact('user', 'messages'));
}

    /**
     * Enregistre un nouveau message envoyé à un utilisateur.
     */
    public function store(Request $request, User $user)
{
    if ($user->id === Auth::id()) {
        abort(403, 'Vous ne pouvez pas vous envoyer un message.');
    }

    $validated = $request->validate([
        'contenu' => 'required|string|max:1000',
    ]);

    Message::create([
        'sender_id' => Auth::id(),
        'receiver_id' => $user->id,
        'content' => $validated['contenu'],
        'status' => 'sent',
    ]);

    return redirect()->route('messages.show', $user->id)
                     ->with('success', 'Message envoyé.');
}

}
