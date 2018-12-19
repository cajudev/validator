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
  validate (string $subject, string $format)
  ```
  
Retorna um objeto Date contendo as informações referentes à data recebida. Retorna false se a data for inválida.
  
| Caractere | Descrição | intervalo |
|-----------|-----------|-----------|
| d         | dia       | 01-31     |
| D         | dia       | 1-31      |
| m         | mês       | 01-12     |
| M         | mês       | 1-12      |
| y         | ano       | 00-99     |
| Y         | ano       | 1900-2099 |

  ```php
  use Cajudev\Validator\Date;
  
  if($date = Date::validate('2018-12-19', 'Y-m-d')) {
      $date->getDate();        //retornará 2018-12-19
      $date->getDay();         //retornará 19
      $date->getMonth();       //retornará 12
      $date->getYear();        //retornará 2018
  }else {
      ...
  }
  ```
