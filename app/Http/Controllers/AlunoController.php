<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    /**
     * Exibe a lista de alunos.
     */
    public function index()
    {
        $alunos = Aluno::all();
        return view('alunos.index', compact('alunos'));
    }

    /**
     * Exibe o formulário de criação de aluno.
     */
    public function create()
    {
        return view('alunos.create');
    }

    /**
     * Armazena um novo aluno no banco de dados.
     */
    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:alunos',
            'data_nascimento' => 'required|date',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:alunos',
        ]);

        // Define o QR Code como sendo o próprio CPF
        $qrcode = $request->cpf;

        // Cria o aluno no banco de dados
        $aluno = Aluno::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento,
            'endereco' => $request->endereco,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'qrcode' => $qrcode,
        ]);

        return redirect()->route('alunos.index')->with('success', 'Aluno cadastrado com sucesso!');
    }

    /**
     * Exibe os detalhes de um aluno específico.
     */
    public function show(Aluno $aluno)
    {
        return view('alunos.show', compact('aluno'));
    }

    /**
     * Exibe o formulário de edição de aluno.
     */
    public function edit(Aluno $aluno)
    {
        return view('alunos.edit', compact('aluno'));
    }

    /**
     * Atualiza os dados de um aluno no banco de dados.
     */
    public function update(Request $request, Aluno $aluno)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:alunos,cpf,' . $aluno->id,
            'data_nascimento' => 'required|date',
            'endereco' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:alunos,email,' . $aluno->id,
        ]);

        // Atualiza os dados do aluno
        $aluno->update($request->all());

        return redirect()->route('alunos.index')->with('success', 'Aluno atualizado com sucesso!');
    }

    /**
     * Remove um aluno do banco de dados.
     */
    public function destroy(Aluno $aluno)
    {
        // Verifica se há registros dependentes (exemplo: presenças, matrículas)
        if ($aluno->presencas()->exists()) {
            return redirect()->route('alunos.index')->with('error', 'Não é possível excluir o aluno, pois há registros de presença associados.');
        }

        $aluno->delete();
        return redirect()->route('alunos.index')->with('success', 'Aluno deletado com sucesso!');
    }

    public function buscarPorQRCode($qrcode)
    {
        $aluno = Aluno::where('qrcode', $qrcode)->first();

        if (!$aluno) {
            return response()->json(['success' => false, 'message' => 'Aluno não encontrado'], 404);
        }

        return response()->json(['success' => true, 'aluno' => $aluno]);
    }
}
