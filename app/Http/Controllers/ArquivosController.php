<?php

namespace App\Http\Controllers;

use Alert;
use App\Arquivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArquivosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $requestData = $request->all();
        $extensao = $requestData['file']->getClientOriginalExtension();
        $fileHash = $requestData['file']->hashName();
        try {
            if ($this->checarExtensao($extensao)) {
                $nomeArquivo = $fileHash . '.' . $extensao;
                if(empty($requestData['file']->extension()))
                    $path = Storage::putFileAs(Arquivo::UPLOAD_FOLDER_DEFAULT, $request->file, $nomeArquivo);
                else
                    $path = Storage::putFile(Arquivo::UPLOAD_FOLDER_DEFAULT, $request->file, 'private');

                $meta = Storage::getMetaData($path);
                if (!empty($path)) {
                    $requestData['extensao'] = $extensao;
                    $requestData['mime_type'] = $requestData['file']->getMimeType();
                    $requestData['tamanho'] = $meta['size'];
                    $requestData['nome'] = $requestData['file']->getClientOriginalName();
                    $requestData['arquivo'] = $path;
                    $mapeamentoArquivo = Arquivo::create($requestData);
                    if (!empty($mapeamentoArquivo)) {
                        Alert::success('CRIADO');
                        return redirect('/home');
                    }
                }
            }
            Alert::error('Tipo de Arquivo não permitido');
            return redirect('/home');
        } catch (\Exception $e) {
            Alert::error('Deu ruim');
            return redirect('/home');
        }
    }

    /**
     * @param Arquivo $arquivo
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function remover($id)
    {
        $arquivo = Arquivo::find($id);
        try
        {
            $arquivoBanco = $arquivo;
            if ($arquivo->delete()) {
                Storage::disk('local')->delete( $arquivoBanco->arquivo);
                Alert::success('DELETADO');
                return redirect('/home');
            }
        }catch (\Exception $exception)
        {
            Alert::error('Erro');
            return redirect('/home');
        }
        Alert::error('Erro');
        return redirect('/home');

    }

    public function listar(Request $request)
    {

        $arquivo = Arquivo::filterBy($filters); //filtros entidade_id, entidade_nome, user_id


        $arquivoResult = $arquivo->get();


        return view('/home', compact('arquivoResult'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checarExtensao($extensao)
    {
        if (in_array($extensao, Arquivo::TIPOS_PERMITIDOS)) {
            return true;
        }
        return false;
    }

    public function perfil()
    {
        $user_id = Auth::id();

        $fotoPerfil  = Arquivo::where('user_id', $user_id)->latest('created_at')->first();
        dd($fotoPerfil);
        return view('perfil', compact(''));
    }


    public function alert($AlertType){
        switch ($AlertType) {
            case 'success':
                Alert::success('this is success alert');
                return redirect('/');
                break;
            case 'info':
                Alert::info('this is info alert');
                return redirect('/');
                break;
            case 'warning':
                Alert::warning('this is warning alert');
                return redirect('/');
                break;
            case 'error':
                Alert::error('this is error alert');
                return redirect('/');
                break;
            case 'message':
                Alert::message('this is message alert');
                return redirect('/');
                break;

            default:
                return redirect('/');
                break;
        }
    }
}
