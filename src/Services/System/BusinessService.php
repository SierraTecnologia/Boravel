<?php

namespace Boravel\Services\System;

use App\Models\Negocios\Business;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use App\Jobs\RoutineOrganizerCreateJob;
use App\Models\Setting;

class BusinessService extends Service
{
    private $business = false;
    public $features = [];

    public function __construct()
    {
        if (!VersionService::isInstall() || !$this->business = $this->detectedBusiness()) {
            return false;
        }

        // Get Settings
        Setting::all()->each(function ($item) {
            Log::debug('[Negocio] Setting Configurado:'. print_r($item->getAppAtribute('config'), true). print_r($item->value, true));
            if (!empty($item->getAppAtribute('config'))) {
                Config::set($item->getAppAtribute('config'), $item->value);
            }
        });

        $this->features = $this->business->features->all();
    }

    private function detectedBusiness()
    {
        $domainSlug = \SiUtils\Helper\General::getSlugForUrl(Request::root());

        /**
         * Localhost ou terminal, retorna o padrao
         */
        if ($domainSlug == 'localhost' || app()->runningInConsole()) {
            return $this->getDefault();
        }

        if (!$business = \App\Models\Negocios\Business::where('code', $domainSlug)->first()) {
            // return $this->getDefault(); // @todo
            return false;
        }
        return $business;
    }

    private function getDefault()
    {
        if (!$default = CacheService::getUniversal('business-default')){
            $default = 'HotelByNow';
        }
        if (!$business = \App\Models\Negocios\Business::where('code', $default)->first()) {
            return false;
        }
        return $business;
    }

    /**
     * Faz o business padrão voltar a ser o original do sistema
     *
     * @return void
     */
    public function clearDefault()
    {
        CacheService::clearUniversal('business-default');
        return true;
    }

    /**
     * Transforma no Business padrão do Sistema
     *
     * @return void
     */
    public function makeDefault(Business $business)
    {
        CacheService::setUniversal('business-default', $business->code);
        $this->business = $business;
        return true;
    }

    public function isDefault(Business $business)
    {
        return $business->code === $this->getBusiness()->code;
    }

    public function userAsColaborator(User $user)
    {
        // @todo Fazer 
        return true;
    }

    public function hasFeature(string $key)
    {
        if (!empty($this->features)) {
            foreach ($this->features as $feature) {
                if ($feature->code === $key) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getCode()
    {
        return $this->business->code;
    }

    public function getBusiness()
    {
        return $this->business;
    }

    public function userHasPermission($user)
    {
        
    }


    // Ignora as urls mencionadas
    public static $IGNORE_URLS = [
        '',
        '/',
        'login'
    ];

    // Ignora as urls que começam com
    public static $IGNORE_PARTIAL_URLS = [
        'admin',
        'services',
        'assets',
        'horizon',
        'vendor'
    ];

    // Urls Bloqueadas
    public static $BLOCK_PARTIAL_URLS = [
        'cgi-bin/webcm',
    ];

    /**
     * Identifica o negócio da empresa de acordo com o token secreto
     */
    public static function getBusinessUser()
    {
        //@todo Mudar
        if (\App::runningInConsole() ){
            Log::notice('Rodando em Console');
            return null;
        }
        $business = self::getViaParamsToken();

        if (!$business && self::isBlockUrl()){
            return abort(403);
        }

        return $business;
    }


    public static function isBlockUrl()
    {
        if (in_array(Request::path(), self::$IGNORE_URLS)) {
            return null;
        }
        if (!empty(self::$BLOCK_PARTIAL_URLS)) {
            foreach(self::$BLOCK_PARTIAL_URLS as $value) {
                // Verifica se a url começa com o path mencionado
                if (substr(Request::path(),0,strlen($value))==$value) {
                    return true;
                }
            }
        }
        return false; 
    }


    /**
     * Identifica o negócio da empresa de acordo com o token secreto
     */
    public static function getViaParamsToken()
    {
        if(!empty($_SERVER['HTTP_BUSINESS_TOKEN'])) {
        
            // Log::info(
            //     '[Aleluia] Consegui usar business' . print_r($_GET, true) . print_r($_POST, true)
            //     . print_r($_SERVER, true)
            // );
            return User::where('token', $_SERVER['HTTP_BUSINESS_TOKEN'])->first();
        }
        
        if(!empty($_POST['business_token'])) {
        
            // Log::info(
            //     '[Aleluia] Consegui usar business' . print_r($_GET, true) . print_r($_POST, true)
            //     . print_r($_SERVER, true)
            // );
            return User::where('token', $_POST['business_token'])->first();
        }
        
        if(!empty($_POST['BUSINESS_TOKEN'])) {
        
            // Log::info(
            //     '[Aleluia] Consegui usar business' . print_r($_GET, true) . print_r($_POST, true)
            //     . print_r($_SERVER, true)
            // );
            return User::where('token', $_POST['BUSINESS_TOKEN'])->first();
        }
        
        if(!empty($_GET['business_token'])) {
        
            // Log::info(
            //     '[Aleluia] Consegui usar business' . print_r($_GET, true) . print_r($_POST, true)
            //     . print_r($_SERVER, true)
            // );
            return User::where('token', $_GET['business_token'])->first();
        }
        
        if(!empty($_GET['BUSINESS_TOKEN'])) {
        
            // Log::info(
            //     '[Aleluia] Consegui usar business' . print_r($_GET, true) . print_r($_POST, true)
            //     . print_r($_SERVER, true)
            // );
            return User::where('token', $_GET['BUSINESS_TOKEN'])->first();
        }

        return null;
        //return User::where('token', config('business.default'))->first();
        // bilo -> 3a0cafad9715806584cf60bf6c04200a
        // Passepague -> config('business.default')
    }

    /**
     * Cria base de Organizações clientes do negócio da empresa
     * em cima dos tokens públicos enviados pelos apps.
     */
    public static function createIfNotExist(Order $order)
    {
        if (empty($order->company_token)) {
            return true;
        }

        if ($found = User::where('token_public', $order->company_token)->first()){
            return true;
        }

        return RoutineOrganizerCreateJob::dispatch($order->user, $order->company_token);
    }

    /**
     * Retorna Serviço de acordo com o Usuario
     */
    public static function getBusinessServiceForUser(User $businessUser, $companyToken = false)
    {
        if (empty($businessUser->business) || empty($businessUser->businessUrl)) {
            Log::notice('Business não configurado para usuário de negócio: '.$businessUser->id);
            return false;
        }

        $class = "\\App\\Integrations\\Business\\".$businessUser->business;
        return new $class($businessUser->businessUrl, $companyToken, $businessUser->token);
    }

}
