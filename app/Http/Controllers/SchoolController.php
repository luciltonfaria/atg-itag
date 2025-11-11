<?php

namespace App\Http\Controllers;

use App\Models\Escola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = Escola::orderBy('nome')->paginate(15);
        return view('schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('schools.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:escolas',
            'address' => 'nullable|string|max:500',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'active' => 'boolean',
        ]);

        // Upload do logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('schools/logos', 'public');
            $validated['logo'] = $logoPath;
        }

        $validated['active'] = $request->has('active');

        Escola::create($validated);

        return redirect()->route('schools.index')
            ->with('success', 'Escola cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Escola $escola)
    {
        $school = $escola; // Alias para manter compatibilidade com as views
        return view('schools.show', compact('school'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Escola $escola)
    {
        $school = $escola; // Alias para manter compatibilidade com as views
        return view('schools.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Escola $escola)
    {
        Log::info('========== INÍCIO DO UPDATE ==========');
        Log::info('Escola ID: ' . $escola->id);
        Log::info('Escola Nome Atual: ' . $escola->nome);
        Log::info('Escola Logo Atual: ' . ($escola->logo ?? 'SEM LOGO'));
        Log::info('Dados recebidos no request: ' . json_encode($request->all()));
        Log::info('Arquivos recebidos: ' . json_encode($request->allFiles()));

        // Validação: não valide 'logo' como imagem se não houver upload
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            // 'active' pode vir como "on"; vamos tratar abaixo
        ]);
        if ($request->hasFile('logo')) {
            $validator->addRules([
                'logo' => 'file|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);
        }
        $validated = $validator->validate();

        Log::info('Validação passou! Dados validados: ' . json_encode($validated));

        // Preparar dados para atualização (sem o code que vem da API)
        $updateData = [
            'nome' => $validated['nome'],
            'address' => $validated['address'],
            'active' => $request->has('active'),
        ];

        Log::info('Dados preparados para update: ' . json_encode($updateData));

        // Upload do novo logo
        if ($request->hasFile('logo')) {
            Log::info('[OK] Logo detectada - iniciando upload');

            // Deletar logo antigo se existir
            if ($escola->logo && Storage::disk('public')->exists($escola->logo)) {
                Storage::disk('public')->delete($escola->logo);
                Log::info('[OK] Logo antiga deletada: ' . $escola->logo);
            }

            $logoPath = $request->file('logo')->store('schools/logos', 'public');
            $updateData['logo'] = $logoPath;

            Log::info('[OK] Nova logo salva em: ' . $logoPath);
            Log::info('[OK] updateData com logo: ' . json_encode($updateData));
        } else {
            Log::info('[WARN] Nenhuma logo detectada no request');
        }

        Log::info('Executando $escola->update() com dados: ' . json_encode($updateData));

        $result = $escola->update($updateData);

        Log::info('Resultado do update: ' . ($result ? 'SUCESSO' : 'FALHOU'));
        Log::info('Escola após update - Nome: ' . $escola->nome);
        Log::info('Escola após update - Address: ' . ($escola->address ?? 'NULL'));
        Log::info('Escola após update - Logo: ' . ($escola->logo ?? 'NULL'));
        Log::info('Escola após update - Active: ' . ($escola->active ? 'true' : 'false'));
        Log::info('========== FIM DO UPDATE ==========');

        return redirect()->route('schools.index')
            ->with('success', 'Escola atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Escola $escola)
    {
        // Deletar logo se existir
        if ($escola->logo && Storage::disk('public')->exists($escola->logo)) {
            Storage::disk('public')->delete($escola->logo);
        }

        $escola->delete();

        return redirect()->route('schools.index')
            ->with('success', 'Escola excluída com sucesso!');
    }
}
