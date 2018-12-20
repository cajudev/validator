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
      $date->getTimestamp()    // 1545177600
      
  }else {
      ...
  }
  ```
  
  
  ```php
  validateArray (array $subjects, string $format)
  ```
  Retorna um array de objetos Date contendo as informações referentes à cada data recebida. Retorna um array vazio caso nenhuma ocorrência seja válida.
  
  ```php
  use Cajudev\Validator\Date;
  
  $array = $array('2018-12-19', '12/05/2018', '14-02-18', '2018/01/05', '1995-02-18', '20.08.2000');
  
  if($date = Date::validateArray($array, 'Y-m-d')) {
      print_r($array);
  }else {
      ...
  }
  
  /** Saída ******************************************************************* 
  
    Array
  (
      [0] => Cajudev\Validator\Date Object
          (
              [date:Cajudev\Validator\Date:private] => 2018-12-19
              [day:Cajudev\Validator\Date:private] => 19
              [month:Cajudev\Validator\Date:private] => 12
              [year:Cajudev\Validator\Date:private] => 2018
              [timestamp:Cajudev\Validator\Date:private] => 1545177600
          )

      [1] => Cajudev\Validator\Date Object
          (
              [date:Cajudev\Validator\Date:private] => 1995-02-18
              [day:Cajudev\Validator\Date:private] => 18
              [month:Cajudev\Validator\Date:private] => 02
              [year:Cajudev\Validator\Date:private] => 1995
              [timestamp:Cajudev\Validator\Date:private] => 793065600
          )

  ) 
  
  /****************************************************************************
  ```
