<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Email;
use App\Models\Telefone;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return Usuario::with(['emails', 'telefones'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $request->validate([
            'nome' => 'required|string',
            'data_nascimento' => 'required|date',
            'emails' => 'nullable|array',
            'emails.*' => 'email',
            'telefones' => 'nullable|array',
            'telefones.*' => 'string|max:11',
        ]);

        $usuario = Usuario::create([
            'nome' => $data['nome'],
            'data_nascimento' => $data['data_nascimento']
        ]);

        if (!empty($data['emails'])) {
            foreach ($data['emails'] as $email) {
                $usuario->emails()->create(['email' => $email]);
            }
        }

        if (!empty($data['telefones'])) {
            foreach ($data['telefones'] as $telefone) {
                $usuario->telefones()->create(['telefone' => $telefone]);
            }
        }

        return $usuario->load(['emails', 'telefones']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        return Usuario::with(['emails', 'telefones'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        $usuario = Usuario::findOrFail($id);

        $data = $request->validate([
            'nome' => 'required|string',
            'data_nascimento' => 'required|date',
            'emails' => 'nullable|array',
            'emails.*' => 'email',
            'telefones' => 'nullable|array',
            'telefones.*' => 'string|max:11',
        ]);

        $usuario->update([
            'nome' => $data['nome'],
            'data_nascimento' => $data['data_nascimento']
        ]);

        $usuario->emails()->delete();
        if (!empty($data['emails'])) {
            foreach ($data['emails'] as $email) {
                $usuario->emails()->create(['email' => $email]);
            }
        }

        $usuario->telefones()->delete();
        if (!empty($data['telefones'])) {
            foreach ($data['telefones'] as $telefone) {
                $usuario->telefones()->create(['telefone' => $telefone]);
            }
        }
        

        return $usuario->load(['emails', 'telefones']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return response()->json(['message' => 'Deletado']);
    }
}
