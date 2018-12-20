Bem vindo ao Validator
======================

Não perca tempo pesquisando como validar informações como datas, documentos ou cartões de crédito.

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
  
| Caractere | Descrição | intervalo                                   |
|-----------|-----------|---------------------------------------------|
| d         | dia       | 01-31                                       |
| j         | dia       | 1-31                                        |
| m         | mês       | 01-12                                       |
| n         | mês       | 1-12                                        |
| y         | ano       | 00-99 (20xx entre 00-69 e 19xx entre 70-99) |
| Y         | ano       | 1970-2099                                   |

  ```php
  use Cajudev\Validator\Date;
  
  if($date = Date::validate('2018-12-19', 'Y-m-d')) {
  
      // caso nenhum pattern seja fornecido, getDate() retorna a data no formato em que foi recebida
      
      $date->getDate();        // 2018-12-19
      $date->getDate('d/m/y'); // 19/12/18
      $date->getDay();         // 19
      $date->getMonth();       // 12
      $date->getYear();        // 2018
  }else {
      ...
  }
  ```
