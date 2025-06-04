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
// App\Http\Controllers\MessageController.php

public function show($id)
{
    $currentUser = Auth::user();

    // Récupérer l'utilisateur avec qui on discute
    $user = User::findOrFail($id);

    // Récupérer tous les utilisateurs avec qui le user peut avoir des conversations
    $users = User::where('id', '!=', $currentUser->id)->get();

    // Récupérer les messages entre les deux utilisateurs
    $messages = Message::where(function ($query) use ($currentUser, $id) {
        $query->where('sender_id', $currentUser->id)
              ->where('receiver_id', $id);
    })->orWhere(function ($query) use ($currentUser, $id) {
        $query->where('sender_id', $id)
              ->where('receiver_id', $currentUser->id);
    })->orderBy('created_at', 'asc')->paginate(20);

    return view('messages.chat', compact('user', 'users', 'messages'));
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
