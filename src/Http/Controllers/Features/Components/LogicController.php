<?php

namespace Boravel\Http\Controllers\Features\Components;

use Boravel\Http\Controllers\Controller as BaseController;
use Exception;
use Throwable;


class LogicController extends BaseController
{
    public static $root = 'playground';

    public function phabricatorStartup() {
        $libsDir = dirname(dirname(dirname(dirname(dirname(__FILE__))))).DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR;

        // Extra Configs
        $_SERVER['PHUTIL_LIBRARY_ROOT'] = $libsDir;
        
        // Load the PhabricatorStartup class itself.
        $t_startup = microtime(true);
        // MInha Alteração para pegar do meu diretório
        if (self::$root) {
            $root = $libsDir.self::$root;
        }
        require_once $root.'/support/startup/PhabricatorStartup.php';
        
        // Load client limit classes so the preamble can configure limits.
        require_once $root.'/support/startup/PhabricatorClientLimit.php';
        require_once $root.'/support/startup/PhabricatorClientRateLimit.php';
        require_once $root.'/support/startup/PhabricatorClientConnectionLimit.php';
        
        // If the preamble script exists, load it.
        $t_preamble = microtime(true);
        $preamble_path = $root.'/support/preamble.php';
        if (file_exists($preamble_path)) {
            require_once $preamble_path;
        }
        $t_hook = microtime(true);
        
        \PhabricatorStartup::recordStartupPhase('startup.init', $t_startup);
        \PhabricatorStartup::recordStartupPhase('preamble', $t_preamble);
        \PhabricatorStartup::recordStartupPhase('hook', $t_hook);
    }
    /**
     * Tenta capturar um token para o business via SERVER, POST, ou GET
     * Caso não ache ele usa o token padrão da passepague
     */
    public function index($route = '/')
    {
        // Iniciar o buffer
        ob_start();
        // Rotas do Phabricator
        $_REQUEST['__path__'] = $route;
        if (php_sapi_name() == 'cli-server') {
            // Compatibility with PHP 5.4+ built-in web server.
            $url = parse_url($_SERVER['REQUEST_URI']);
            define('PLAYGROUND_PATH', $url['path']);
        } else {
            define('PLAYGROUND_PATH', $route);
        }
        $this->phabricatorStartup();
        
        $fatal_exception = null;
        try {
          \PhabricatorStartup::beginStartupPhase('libraries');
          \PhabricatorStartup::loadCoreLibraries();
        
          \PhabricatorStartup::beginStartupPhase('purge');
          \PhabricatorCaches::destroyRequestCache();
        
          \PhabricatorStartup::beginStartupPhase('sink');
          $sink = new \AphrontPHPHTTPSink();
        
          // PHP introduced a "Throwable" interface in PHP 7 and began making more
          // runtime errors throw as "Throwable" errors. This is generally good, but
          // makes top-level exception handling that is compatible with both PHP 5
          // and PHP 7 a bit tricky.
        
          // In PHP 5, "Throwable" does not exist, so "catch (Throwable $ex)" catches
          // nothing.
        
          // In PHP 7, various runtime conditions raise an Error which is a Throwable
          // but NOT an Exception, so "catch (Exception $ex)" will not catch them.
        
          // To cover both cases, we "catch (Exception $ex)" to catch everything in
          // PHP 5, and most things in PHP 7. Then, we "catch (Throwable $ex)" to catch
          // everything else in PHP 7. For the most part, we only need to do this at
          // the top level.
        
          $main_exception = null;
          try {
            \PhabricatorStartup::beginStartupPhase('run');
            \AphrontApplicationConfiguration::runHTTPRequest($sink);
          } catch (Exception $ex) {
            $main_exception = $ex;
          } catch (Throwable $ex) {
            $main_exception = $ex;
          }
        
          if ($main_exception) {
            $response_exception = null;
            try {
              $response = new \AphrontUnhandledExceptionResponse();
              $response->setException($main_exception);
              $response->setShowStackTraces($sink->getShowStackTraces());
        
              \PhabricatorStartup::endOutputCapture();
              $sink->writeResponse($response);
            } catch (Exception $ex) {
              $response_exception = $ex;
            } catch (Throwable $ex) {
              $response_exception = $ex;
            }
        
            // If we hit a rendering exception, ignore it and throw the original
            // exception. It is generally more interesting and more likely to be
            // the root cause.
        
            if ($response_exception) {
              throw $main_exception;
            }
          }
        } catch (Exception $ex) {
          $fatal_exception = $ex;
        } catch (Throwable $ex) {
          $fatal_exception = $ex;
        }
        
        if ($fatal_exception) {
          \PhabricatorStartup::didEncounterFatalException(
            'Core Exception',
            $fatal_exception,
            false);
        }

        // Obter o conteúdo do buffer e encerrá-lo
        $conteudo = ob_get_clean();
        
        dd('oi', $conteudo);
    }

    
}