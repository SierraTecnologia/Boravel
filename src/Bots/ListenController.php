<?php

namespace Boravel\Logic;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tratar Mensagem Recebida
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($message)
    {
        // É uma pergunta ?
        if ($this->isQuestion()) {
            
        }

        // É um pedido ?
        if ($this->isPedido()) {

        }

        // Pedindo Autorização ?
        if ($this->pedindoAutorizacao('posso')) {

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
