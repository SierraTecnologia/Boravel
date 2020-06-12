<?php
/**
 * Armazena os tipos de pagamentos para moedas fiat
 */

namespace Boravel\Models\Actions\Event;

use Illuminate\Support\Facades\Hash;

use Boravel\Models\Model;
class PaymentType  extends Model
{

    /**
     *
     * @var array
     */
    public static $SALARIO_ID = 1;


    /**
     * Pagamentos Fixos
     *
     * @var array
     */
    public static $FIX_PAYS = 2;


    /**
     * Mercado - Compras
     *
     * @var array
     */
    public static $PAY_IN_MARKET = 3;


    /**
     * ROUPAS
     *
     * @var array
     */
    public static $ROUPAS = 4;


    /**
     * ROUPAS
     *
     * @var array
     */
    public static $ROUPAS_MARCAS = 5;



    /**
     * DRUGS
     *
     * @var array
     */
    public static $DRUGS = 6;

}