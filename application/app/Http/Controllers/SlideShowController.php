<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SlideShow;
use Illuminate\Support\Facades\File;

class SlideShowController extends Controller
{
    // Exibe todos os slides
    public function index()
    {
        $slideshow = SlideShow::all();
        return view('celotex/slides', compact('slideshow')); // Assumindo que você tenha uma view chamada 'slides.index'
    }

    public function getSlides()
    {
        // Retorna todos os slides em formato JSON
        $slides = SlideShow::all(); // Obtenha todos os slides do banco de dados
        return response()->json($slides);
    }

    // Exibe o formulário para upload de slides
    public function update(Request $request, $id)
    {
        $slide = SlideShow::findOrFail($id);
    
        // Atualiza o status "ativo"
        $slide->ativo = $request->input('ativo');
    
        // Verifica se há uma nova imagem sendo enviada
        if ($request->hasFile('imagem')) {
            // Valida a imagem
            $request->validate([
                'imagem' => 'image|mimes:jpeg,png,jpg,gif|max:10048',
            ]);
    
            // Apaga a imagem antiga, se existir
            $caminhoCompleto = public_path($slide->caminho_imagem);
            if (File::exists($caminhoCompleto)) {
                File::delete($caminhoCompleto);
            }
    
            // Faz o upload da nova imagem
            $caminho = 'vendor/img/celotex/informativos';
            $nomeArquivo = time() . '.' . $request->imagem->extension();
            $request->imagem->move(public_path($caminho), $nomeArquivo);
            $slide->caminho_imagem = $caminho . '/' . $nomeArquivo;
        }
    
        // Salva as alterações
        $slide->save();
    
        return response()->json(['message' => 'Slide atualizado com sucesso!']);
    }
    
    public function getActiveSlides()
    {
        // Buscar slides com 'ativo' = 'SIM'
        $slides = SlideShow::where('ativo', 'SIM')->pluck('caminho_imagem');

        return response()->json($slides);
    }

    // Salva uma nova imagem de slide
    public function store(Request $request)
    {
        // Valida a imagem
        $request->validate([
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048',
        ]);

        if ($request->hasFile('imagem')) {
            // Caminho de armazenamento
            $caminho = 'vendor/img/celotex/informativos';

            // Gera um nome único para a imagem
            $nomeArquivo = time() . '.' . $request->imagem->extension();

            // Move o arquivo para o diretório especificado
            $request->imagem->move(public_path($caminho), $nomeArquivo);

            // Cria um novo registro no banco de dados
            SlideShow::updateOrCreate([
                'caminho_imagem' => $caminho . '/' . $nomeArquivo,
                'ativo' => 'SIM', // Definir como ativo ou conforme necessidade
            ]);

            return redirect()->route('slides.index')->with('success', 'Slide salvo com sucesso!');
        }

        return back()->with('error', 'Nenhuma imagem foi enviada.');
    }

    // Deleta um slide
    public function destroy($id)
    {
        $slide = SlideShow::findOrFail($id);

        // Remove a imagem do sistema de arquivos
        $caminhoCompleto = public_path($slide->caminho_imagem);
        if (File::exists($caminhoCompleto)) {
            File::delete($caminhoCompleto);
        }

        // Remove o registro do banco de dados
        $slide->delete();

        return back()->with('success', 'Slide removido com sucesso!');
    }
}
