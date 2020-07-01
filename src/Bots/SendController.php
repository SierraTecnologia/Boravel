<?php

namespace Boravel\Bots;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SendController extends Controller
{
    public $user = false;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Exibir Casinha
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function makeContact()
    {
        // Caso não seja registrado, exibe a pagina inicial para se cadastrar ou dar seu numero
        if (!Auth::user()) {
            return view('home');
        }

        //
    }

    /**
     * Exibir dashboards e relatórios
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function metrics()
    {
        // Exibe
        return view('home');
    }

    /**
     * Exibir dashboards e relatórios
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function reports()
    {
        // Exibe o Progresso por Hora


        // Exibe o Progresso do Dia!


        // Exibe o Progresso do Mes! (Caso Mais de Um Mes)

        // Exibe o Progresso 
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function reply()
    {
        // Verifica se tem algum processo em aberto se tiver Inicia Ele
        // @todo 
        
        // Nunca respondeu uma pergunta ?
        // Iniciar Perguntas do Inicio

        // Esta busca de coleira/encoleirado ?
        // Se sim


        return view('home');
    }

    /**
     * Endereço para Fazer Algo
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function make()
    {
        return view('home');
    }
}
