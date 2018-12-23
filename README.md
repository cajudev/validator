Bem vindo ao Validator
======================

[![](https://img.shields.io/packagist/v/cajudev/validator.svg)](https://packagist.org/packages/cajudev/validator)
[![](https://img.shields.io/packagist/dt/cajudev/validator.svg)](https://packagist.org/packages/cajudev/validator)
[![](https://img.shields.io/github/license/cajudev/validator.svg)](https://raw.githubusercontent.com/cajudev/validator/master/LICENSE)
[![](https://img.shields.io/travis/cajudev/validator.svg)](https://travis-ci.org/cajudev/validator)
[![](https://coveralls.io/repos/github/cajudev/validator/badge.svg?branch=master)](https://coveralls.io/github/cajudev/validator)
[![](https://img.shields.io/github/issues/cajudev/validator.svg)](https://github.com/cajudev/validator/issues)
[![](https://img.shields.io/github/contributors/cajudev/validator.svg)](https://github.com/cajudev/validator/graphs/contributors)

Não perca tempo pesquisando como validar informações como datas, documentos ou cartões de crédito.

Essa biblioteca possui um conjunto de validações prontas para uso.

Veja a documentação completa em: https://doc-validator.readthedocs.io

Características
---------------

* Padrão PSR-4
* Testes unitários com PHPUnit

Sumário
-------

1. [Data](#validação-de-data)
2. [CPF](#validação-de-cpf)
3. [CNPJ](#validação-de-cnpj)
4. [RG](#validação-de-rg)
4. [Cartão de Crédito](#validação-de-cartão-de-crédito)

Validação de Data
-----------------

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
  
Validação de CNPJ
-----------------

  ```php
  validate (string $subject)
  ```
  
Retorna um objeto Cnpj contendo um número válido. Retorna false se o cnpj for inválido.

  ```php
  use Cajudev\Validator\Cnpj;
  
  if($cnpj = Cnpj::validate("60.342.988/0001-07")) {
  
      // por padrão, getNumber() retorna o número formatado, caso queira o número limpo, insira como argumento "false";
      
      $cnpj->getNumber();        // 60.342.988/0001-07
      $cnpj->getNumber(false);   // 60342988000107
      
  }else {
      ...
  }
  ```
  
  ```php
  validateArray (array $subjects)
  ```
  Retorna um array de objetos com os cnpj's válidos. Retorna um array vazio caso nenhuma ocorrência seja válida.
  
  ```php
  use Cajudev\Validator\Cnpj;
  
  $array = array(
    "58.929.896/0001-78",
    "57.806.461/0001-74",
    "09.475.795/0001-69",
    "60.184.969/0001-81",
    "87.048.150/0001-53"
  );
  
  if($cnpjs = Cnpj::validateArray($array)) {
      print_r($cnpjs);
  }else {
      ...
  }
  
  /** Saída **/
  
  Array
  (
      [0] => Cajudev\Validator\Cnpj Object
          (
              [number:Cajudev\Validator\Cnpj:private] => 58929896000178
          )

      [1] => Cajudev\Validator\Cnpj Object
          (
              [number:Cajudev\Validator\Cnpj:private] => 09475795000169
          )

      [2] => Cajudev\Validator\Cnpj Object
          (
              [number:Cajudev\Validator\Cnpj:private] => 87048150000153
          )

  )
  ```

Validação de RG
---------------

Importante destacar que no Brasil não existe uma formalização nacional do RG, essa validação apenas verifica matematicamente se o dígito verificador 'bate' com o número inserido.

Atualmente suporta Rg's terminados em 'x'.

  ```php
  validate (string $subject)
  ```

Retorna um objeto Rg contendo um número válido. Retorna false se o rg for inválido.

  ```php
  use Cajudev\Validator\Rg;
  
  if($rg = Rg::validate("43.230.115-X")) {
  
      // por padrão, getNumber() retorna o número formatado, caso queira o número limpo, insira como argumento "false";
      
      $rg->getNumber();        // 43.230.115-X
      $rg->getNumber(false);   // 43230115X
      
  }else {
      ...
  }
  ```
  
  ```php
  validateArray (array $subjects)
  ```
  Retorna um array de objetos com os rg's válidos. Retorna um array vazio caso nenhuma ocorrência seja válida.
  
  ```php
  use Cajudev\Validator\Rg;
  
  $array = array(
    "32.331.620-7",
		"43.513.112-6",
		"26.178.384-1",
		"15.978.609-7",
		"43.230.111-X",
		"37.802.977-1",
  );
  
  if($rgs = Rg::validateArray($array)) {
      print_r($rgs);
  }else {
      ...
  }
  
  /** Saída **/
  
  Array
  (
      [0] => Cajudev\Validator\Rg Object
          (
              [number:Cajudev\Validator\Rg:private] => 323316207
          )

      [1] => Cajudev\Validator\Rg Object
          (
              [number:Cajudev\Validator\Rg:private] => 435131126
          )

      [2] => Cajudev\Validator\Rg Object
          (
              [number:Cajudev\Validator\Rg:private] => 261783841
          )

  )
  ```

Validação de Cartão de Crédito
------------------------------

Realizamos a validação utilizando o algoritmo de Luhn e as tabelas de bin's disponibilizadas pelas operadoras

  ```php
  validate (string $subject)
  ```

Retorna um objeto CreditCard contendo o número e a bandeira do cartão. Retorna false se o número for inválido.

  ```php
  use Cajudev\Validator\CreditCard;
  
  if($cc = CreditCard::validate("5277887630105547")) {
  
      // por padrão, getNumber() retorna o número formatado, caso queira o número limpo, insira como argumento "false";
      
      $cc->getNumber();        // 5277 8876 3010 5547
      $cc->getNumber(false);   // 5277887630105547
      $cc->getFlag()           // mastercard
      
  }else {
      ...
  }
  ```
  
  ```php
  validateArray (array $subjects)
  ```
  Retorna um array de objetos com os cc's válidos. Retorna um array vazio caso nenhuma ocorrência seja válida.
  
  ```php
  use Cajudev\Validator\CreditCard;
  
  $array = array(
    "5307 9584 2290 0132",
    "5307 9584 2290 0133",
    "4532 6941 9414 4788",
    "4532 6941 9414 4787",
    "3775 247152 71460",
    "3775 247152 71461"
  );
  
  if($ccs = CreditCard::validateArray($array)) {
      print_r($ccs);
  }else {
      ...
  }
  
  /** Saída **/
  
  Array
  (
      [0] => Cajudev\Validator\CreditCard Object
          (
              [number:Cajudev\Validator\CreditCard:private] => 5307958422900132
              [flag:Cajudev\Validator\CreditCard:private] => mastercard
          )

      [1] => Cajudev\Validator\CreditCard Object
          (
              [number:Cajudev\Validator\CreditCard:private] => 4532694194144787
              [flag:Cajudev\Validator\CreditCard:private] => visa
          )

      [2] => Cajudev\Validator\CreditCard Object
          (
              [number:Cajudev\Validator\CreditCard:private] => 377524715271460
              [flag:Cajudev\Validator\CreditCard:private] => amex
          )

  )
  ```
