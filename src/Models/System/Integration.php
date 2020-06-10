<?php

namespace Boravel\Models\System;

/**
 * Class Responsável por separar acessos e regras de negócios.
 * 
 * Hierarquia:
 * -> Deus (Controle os admins e seus acessos)
 * -> Admin (Tem acessos aos usuários do payment, com as diferentes regras de negócio)
 * -> User (Diferentes braços e parcerias da empresa, com proprios gateways, contratos e tokens)
 * -> Client (Cliente do User, quem irá receber o dinheiro)
 * -> Customer (Consumidor Final, pagando e adquirindo os produtos do cliente)
 */

use Boravel\Models\Model; 

class Integration extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cpf',
        'time_init',
        'time_payed',
        'role_id'
    ];

    protected $mappingProperties = array(
        /**
         * User Info
         */
        'name' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'cpf' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
        'email' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],

        /**
         * Grupo de Usuário:
         * 
         * 3 -> Usuário de Produtora
         * Default: 3
         */
        'role_id' => [
            'type' => 'string',
            "analyzer" => "standard",
        ],
    );

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'customer_id', 'id');
    }

    public function analysis()
    {
        return $this->hasMany('App\Models\Analysi', 'analysi_id', 'id');
    }

    /**
     * Get the tokens record associated with the user.
     */
    public function customerTokens()
    {
        return $this->hasMany('App\Models\CustomerToken', 'customer_id', 'id');
    }

    /**
     * Recupera os tokens de gateways desse usuário
     */
    public function gatewayCustomers()
    {
        return $this->hasMany('App\Models\GatewayCustomer', 'customer_id', 'id');
    }
}