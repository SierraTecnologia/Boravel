<?php

namespace Boravel\Http\Controllers\Modules\Interactions;



/**
 * Class AcordoController.
 *
 * @author Amrani Houssain <amranidev@gmail.com>
 */
class AcordoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $questions = \App\Models\User::all()->count();
        

        return view(
            'admin.dashboard.dashboard',
            compact(
                'users',
                'roles',
                'permissions',
                'entities'
            )
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function modelos($step = 3)
    {
        $questions = \App\Models\User::all()->count();
        $acordo = new \SiSeed\Human\Contratos\FullSlave\Acordo();

        // Step
        $contrato = $acordo->getSteps()[$step];
        $contratoInstance = (new $contrato())->run();


        // Mostrar Na tela
        $about = $contratoInstance->getAbout(); //array -> name, description, resumo

        // Contrato
        $juramentos = $contrato->getJuramentos();
        $vigencia = $contrato->getVigencia();
        $disponibilidade = $contrato->getDisponibilidade();
        $locals = $contrato->getLocals();
        $testemunhas = $contrato->getTestemunhas();
        $imagem = $contrato->getImagem();
        $juramentos = $contrato->getConfidencialidade();
        

        return view(
            'admin.modelos.modelos',
            compact(
                'users',
                'roles',
                'permissions',
                'entities'
            )
        );
    }
}
