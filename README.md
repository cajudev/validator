Bem vindo ao Validator
======================

Não perca tempo pesquisando como validar cpf, cnpj, cartões de crédito, etc.
Essa biblioteca que possui um conjunto de validações prontas para uso.

Características
---------------

* Padrão PSR-4
* Testes unitários com PHPUnit
* Documentação clara e objetiva

Validação de Datas
------------------

  ```php
  use Cajudev\Validator\Date;
  
  $string = '2018-12-19';
  if($date = Date::validate($string, 'Y-m-d')) {
      $date->getDate();        //retornará 2018-12-19
      $date->getDay();         //retornará 19
      $date->getMonth();       //retornará 12
      $date->getYear();        //retornará 2018
  }else {
      ...
  }
