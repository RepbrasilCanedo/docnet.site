<?php

namespace Core;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Configurações básicas do site.
 *
  * @author Daniel Canedo - docan2006@gmail.com
 */

abstract class Config
{
    /**
     * Possui as constantes com as configurações.
     * Configurações de endereço do projeto.
     * Página principal do projeto.
     * Credenciais de acesso ao banco de dados
     * E-mail do administrador.
     * 
     * @return void
     *'"
     */
    protected function configAdm(): void
    {
        define('URL', 'http://localhost/docnet.site/');
        define('URLADM', 'http://localhost/docnet.site/');        
        define('URLSTS', 'http://localhost/docnet.site/');

        define('CONTROLLER', 'Login');
        define('METODO', 'index');
        define('CONTROLLERERRO', 'Login');

        define('HOST', 'localhost');
        define('USER', 'root');
        define('PASS', '');
        define('DBNAME', 'docnet05_docnet_site');
        define('PORT', 3306);

        define('EMAILADM', 'docan2006@gmail.com');
    }
}
