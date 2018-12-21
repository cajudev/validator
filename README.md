
Bem vindo ao Validator
======================

Não perca tempo pesquisando como validar informações como datas, documentos ou cartões de crédito.

Essa biblioteca possui um conjunto de validações prontas para uso.

Veja a documentação completa em: https://doc-validator.readthedocs.io

Características
---------------

* Padrão PSR-4
* Testes unitários com PHPUnit

Sumário
-------

1. [Data](#validação-de-datas)
2. [CPF](#validação-de-cpf)

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
  Retorna um array de objetos Date contendo as informações referentes à cada data válida recebida. Retorna um array vazio caso nenhuma ocorrência seja válida.
  
  ```php
  use Cajudev\Validator\Date;
  
  $array = array('2018-12-19', '12/05/2018', '14-02-18', '2018/01/05', '1995-02-18', '20.08.2000');
  
  if($dates = Date::validateArray($array, 'Y-m-d')) {
      print_r($dates);
  }else {
      ...
  }
  
  /** Saída **/
  
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
  ```
  
Validação de CPF
----------------

  ```php
  validate (string $subject)
  ```
  
Retorna um objeto Cpf contendo um número válido. Retorna false se o cpf for inválido.

  ```php
  use Cajudev\Validator\Cpf;
  
  if($cpf = Cpf::validate("590.887.600-39")) {
  
      // por padrão, getNumber() retorna o número formatado, caso queira o número limpo, insira como argumento "false";
      
      $cpf->getNumber();        // 590.887.600-39
      $cpf->getNumber(false);   // 59088760039
      
  }else {
      ...
  }
  ```
  
  ```php
  validateArray (array $subjects)
  ```
  Retorna um array de objetos com os cpf's válidos. Retorna um array vazio caso nenhuma ocorrência seja válida.
  
  ```php
  use Cajudev\Validator\Cpf;
  
  $array = array("438.784.570-81", "231.803.290-41", "477.107.930-69", "041.830.100-04", "769.611.670-55");
  
  if($cpfs = Cpf::validateArray($array)) {
      print_r($cpfs);
  }else {
      ...
  }
  
  /** Saída **/
  
  Array
  (
      [0] => Cajudev\Validator\Cpf Object
          (
              [number:Cajudev\Validator\Cpf:private] => 43878457081
          )

      [1] => Cajudev\Validator\Cpf Object
          (
              [number:Cajudev\Validator\Cpf:private] => 23180329041
          )

      [2] => Cajudev\Validator\Cpf Object
          (
              [number:Cajudev\Validator\Cpf:private] => 04183010004
          )

  )
  ```
