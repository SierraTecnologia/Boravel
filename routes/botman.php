<?php
use Boravel\Http\Controllers\BotManController;

$botman = resolve('botman');

// $botman->hears('Hi', function ($bot) {
//     $bot->reply('Hello!');
// });
// $botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->middleware->received(new \Boravel\Http\Middleware\Botman\LoadUserMiddleware());

$botman->hears('/help|^ajuda$|(?:no se )?(?:que fer|com (?:funciona|va))', 'Boravel\Http\Controllers\HelpController@index');

$botman->hears('/station|^estaci[ó|o]$|^hola$|👋', 'Boravel\Http\Controllers\GirocletaController@greetings');
$botman->hears('/start|(?:afegir|definir|canviar?) estaci[ó|o]', 'Boravel\Http\Controllers\GirocletaController@registerConversation');
$botman->hears('(?:(?:vull)? anar de |de )?(.*) a (.*)', 'Boravel\Http\Controllers\GirocletaController@tripInformation');
$botman->receivesLocation('Boravel\Http\Controllers\GirocletaController@nearStations');

$botman->hears('^/reminders$|els meus recordatoris|recordatoris', 'Boravel\Http\Controllers\RemindersController@index');
$botman->hears('^/reminder$|(?:afegir|definir|crear) recordatori', 'Boravel\Http\Controllers\RemindersController@create');
$botman->hears('^/reminderdelete$|(?:esborrar?|treu[re]?|oblidar?) recordatori', 'Boravel\Http\Controllers\RemindersController@destroy');

$botman->hears('/aliases|els meus alias|veure alias', 'Boravel\Http\Controllers\AliasesController@index');
$botman->hears('/alias$|(?:afegir|definir|crear?) alias', 'Boravel\Http\Controllers\AliasesController@create');
$botman->hears('^/aliasdelete|(?:esborrar?|treu[re]?|oblidar?) alias', 'Boravel\Http\Controllers\AliasesController@destroy');

$botman->hears('/remove$|/forget$|/delete$|(?:borrar?|oblidar?) usuari', 'Boravel\Http\Controllers\UsersController@destroy');

$botman->fallback('Boravel\Http\Controllers\FallbackController@index');

$botman->hears('/help', \Boravel\Http\Controllers\Help\ShowController::class);

$botman->hears('/start', \Boravel\Http\Controllers\Users\StoreController::class);
$botman->hears('/token {token}', \Boravel\Http\Controllers\Token\StoreController::class);


$botman->hears('/sites', \Boravel\Http\Controllers\Sites\IndexController::class);
$botman->hears('/newsite (.*[^\s])', \Boravel\Http\Controllers\Sites\StoreController::class);
$botman->hears('/site (.*[^\s])', \Boravel\Http\Controllers\Sites\ShowController::class);
$botman->hears('/deletesite (.*[^\s])', \Boravel\Http\Controllers\Sites\DestroyController::class);
$botman->hears('/downtime (.*[^\s])', \Boravel\Http\Controllers\Downtime\ShowController::class);
$botman->hears('/uptime (.*[^\s])', \Boravel\Http\Controllers\Uptime\ShowController::class);
$botman->hears('/brokenlinks (.*[^\s])', \Boravel\Http\Controllers\BrokenLinks\ShowController::class);
$botman->hears('/mixedcontent (.*[^\s])', \Boravel\Http\Controllers\MixedContent\ShowController::class);
$botman->hears('/webhook (.*)', \Boravel\Http\Controllers\Webhook\StoreController::class);


/**
 * Payments
 */

$botman->hears('hello|/hi|Hola|👋', function ($bot) {
    $bot->reply('Hola! 👋');
});

$botman->hears(
    '(?|'.implode('|', [
        'en' => 'I owe ([0-9]+) to @([^\s]+)',
        'ca' => '(?:(?:li dec)|(?:dec)) ([0-9]+) a @([^\s]+)',
        'es' => '(?:(?:le debo)|(?:debo)) ([0-9]+) a @([^\s]+)',
    ]).')',
    'Boravel\Http\Controllers\DebtsController@createFromMe'
);

$botman->hears(
    '(?|'.implode('|', [
        'en' => '@([^\s]+) owes me ([0-9]+)',
        'ca' => '@([^\s]+) (?:(?:em deu)|(?:hem deu)|(?:deu)) ([0-9]+)',
        'es' => '@([^\s]+) (?:(?:me debe)|(?:debe)) ([0-9]+)',
    ]).')',
    'Boravel\Http\Controllers\DebtsController@createFromOthers'
);


$botman->hears(
    '(?|'.implode('|', [
        'en' => 'I paid ([0-9]+) to @([^\s]+)',
        'ca' => '(?:(?:li he pagat)|(?:he pagat)|(?:pago)) ([0-9]+) a @([^\s]+)',
        'es' => '(?:(?:le he pagado)|(?:le pago)|(?:he pagado)) ([0-9]+) a @([^\s]+)',
    ]).')',
    'Boravel\Http\Controllers\PaymentsController@createFromMe'
);

$botman->hears(
    implode('|', [
        'en' => '@([^\s]+) paid me ([0-9]+)',
        'ca' => '@([^\s]+) (?:(?:m\'ha pagat)|(?:ha pagat)|(?:em paga)|(?:paga)) ([0-9]+)',
        'es' => '@([^\s]+) (?:(?:me ha pagado)|(?:ha pagado)|(?:me paga)) ([0-9]+)'
    ]),
    'Boravel\Http\Controllers\PaymentsController@createFromOthers'
);

$botman->hears('/debt ([0-9]+) @([^\s]+)', function ($bot, $amount, $username) {
    return app(Boravel\Http\Controllers\DebtsController::class)->createFromMe($bot, $amount, $username);
});
$botman->hears('/paid ([0-9]+) @([^\s]+)', function ($bot, $amount, $username) {
    return app(Boravel\Http\Controllers\DebtsController::class)->createFromOthers($bot, $username, $amount);
});

$botman->hears('/balance|/resum|/resumen|💰|💵', 'Boravel\Http\Controllers\DebtsController@index');

$botman->hears('/register', 'Boravel\Http\Controllers\GroupsController@register');
$botman->on('group_chat_created', 'Boravel\Http\Controllers\GroupsController@registerNewGroup');
$botman->on('new_chat_members', 'Boravel\Http\Controllers\GroupsController@registerNewChatMember');