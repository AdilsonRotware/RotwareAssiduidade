<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presenca;
use App\Models\Aluno;

class PresencaController extends Controller
{
    public function index(Request $request)
    {
        $query = Presenca::with('aluno')->orderBy('data_hora_presenca', 'desc');
    
        // Se houver um termo de pesquisa
        if ($request->has('search') && !empty($request->search)) {
            // Buscar presenças apenas se o aluno existir e tiver registros de presença
            $query->whereHas('aluno', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->search . '%');
            });
        }
    
        $presencas = $query->paginate(10);
    
        return view('presencas.index', compact('presencas'));
    }    

    public function create()
    {
        return view('presencas.create'); // Página com leitor de QR Code
    }

    public function store(Request $request)
    {
        $request->validate(['qrcode' => 'required']);

        // Localiza o aluno pelo QR Code
        $aluno = Aluno::where('qrcode', $request->qrcode)->first();

        if (!$aluno) {
            return back()->with('error', 'Aluno não encontrado!');
        }

        // Data atual no formato YYYY-MM-DD
        $hoje = now()->toDateString();

        // Buscar todos os registros de presença do aluno para hoje
        $presencasHoje = Presenca::where('aluno_id', $aluno->id)
                                 ->whereDate('data_hora_presenca', $hoje)
                                 ->get();

        // Se já houver dois registros (entrada e saída), bloquear novos registros
        if ($presencasHoje->count() >= 2) {
            return back()->with('error', 'Já foram registrados a entrada e a saída para hoje.');
        }

        // Se não houver registros ainda, registra a entrada
        if ($presencasHoje->isEmpty()) {
            Presenca::create([
                'aluno_id' => $aluno->id,
                'data_hora_presenca' => now(),
                'status' => 'entrada',
            ]);
            return redirect()->route('presencas.index')->with('success', 'Entrada registrada com sucesso!');
        }

        // Se houver apenas um registro e ele for de entrada, registra a saída
        if ($presencasHoje->count() == 1 && $presencasHoje->first()->status === 'entrada') {
            Presenca::create([
                'aluno_id' => $aluno->id,
                'data_hora_presenca' => now(),
                'status' => 'saida',
            ]);
            return redirect()->route('presencas.index')->with('success', 'Saída registrada com sucesso!');
        }

        return back()->with('error', 'Erro inesperado ao registrar presença.');
    }

    public function destroy(Presenca $presenca)
    {
        $presenca->delete();
        return redirect()->route('presencas.index')->with('success', 'Registro de presença excluído com sucesso.');
    }
}
