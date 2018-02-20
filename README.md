# CodeIgniter - Produtividade na criação de aplicações web em PHP

Link: https://www.casadocodigo.com.br/pages/sumario-code-igniter

Kanban: https://josemalcher.net/kanban/public/task/241/c1b8680b9e2b4305daf46fb0f202491ea8b958010a14999aebf4e6238976

Repsitório: https://github.com/josemalcher/Livro-CodeIgniter-Produtividade-na-Criacao-de-Aplicacoes-Web-Em-PHP

---

## <a name="indice">Índice</a>

- [1 Introdução ao CodeIgniter](#parte1)   
- [2 Anatomia de um model](#parte2)   
- [3 Anatomia de um controller](#parte3)   
- [4 Anatomia de uma view](#parte4)   
- [5 Criando um site institucional ─ Parte I](#parte5)   
- [6 Criando um site institucional ─ Parte II](#parte6)   
- [7 Validando formulários](#parte7)   
- [8 Enviando e-mails com a library Email](#parte8)   
- [9 Gerenciando sessões com a library Session](#parte9)   
- [10 Upload, download e compressão de arquivos](#parte10)   
- [11 Implementando CAPTCHA nativo](#parte11)   
- [12 Criando um encurtador de URLs ─ Parte I](#parte12)   
- [13 Criando um encurtador de URLs ─ Parte II](#parte13)   
- [14 Trabalhando com banco de dados](#parte14)   
- [15 Paginação de resultados](#parte15)   
- [16 Usando template parser](#parte16)   
- [17 Manipulando imagens](#parte17)   
- [18 Trabalhando com Composer](#parte18)   
- [19 Poupando tempo de desenvolvimento com funcionalidades nativas do CodeIgniter](#parte19)   
- [20 Migrando um projeto da versão 2.x para a 3.x](#parte20)   
- [21 Mantendo a estrutura de banco de dados atualizada com Migrations](#parte21)   
- [22 Apêndice A](#parte22)   
- [23 Apêndice B](#parte23)   
- [24 Apêndice C](#parte24)   
- [25 Apêndice D](#parte25)   
- [26 Apêndice E](#parte26)   
- [27 Conclusão](#parte27)   



---

## <a name="parte1">1 Introdução ao CodeIgniter</a>
 
Repo: https://github.com/bcit-ci/CodeIgniter

1Site: https://codeigniter.com/

Arquivos do projeto do livro: https://github.com/jlamim/livro-codeigniter

Traduções: https://github.com/bcit-ci/codeigniter3-translations

#### \projeto01\index.php
```php
/*
 *---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" directory.
 * Set the path if it is not in the same directory as this file.
 */
	$system_path = '../system';
```
#### \projeto01\application\config\config.php
```php
*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
|
| This determines which set of language files should be used. Make sure
| there is an available translation if you intend to use something other
| than english.
|
*/
$config['language']	= 'portuguese';
```



[Voltar ao Índice](#indice)

---

## <a name="parte2">2 Anatomia de um model</a>

Um model é uma classe para trabalhar com as informações do banco de dados. Nela você executa todas as ações necessárias de pesquisa ( SELECT ), adição ( INSERT ), atualização ( UPDATE ) e exclusão ( DELETE ) de informações.

EXEMPO DE MODEL

```php
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Examplo_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }

    function Save($data){
        $this->db->insert('table',$data);
        if($this->db->insert_id()){
            return true;
        }
        else{
            return FALSE;
        }
    }
}
```
### 2.1 COMO CARREGAR UM MODEL

```php
    $this->load->model('NomeDoModel');
    $this->load->model('NomeDoModel','ApelidoDoModel');
```

### 2.2 CARREGANDO UM MODEL NO AUTOLOAD

#### application/config/autoload.php

```php
    $autoload['model'] = array('nome_do_model' => 'novo_nome_do_model');
```

SABER MAIS: https://codeigniter.com/user_guide/general/models.html



[Voltar ao Índice](#indice)

---

## <a name="parte3">3 Anatomia de um controller</a>


[Voltar ao Índice](#indice)

---

## <a name="parte4">4 Anatomia de uma view</a>


[Voltar ao Índice](#indice)

---

## <a name="parte5">5 Criando um site institucional ─ Parte I</a>


[Voltar ao Índice](#indice)

---

## <a name="parte6">6 Criando um site institucional ─ Parte II</a>


[Voltar ao Índice](#indice)

---

## <a name="parte7">7 Validando formulários</a>


[Voltar ao Índice](#indice)

---

## <a name="parte8">8 Enviando e-mails com a library Email</a>


[Voltar ao Índice](#indice)

---

## <a name="parte9">9 Gerenciando sessões com a library Session</a>


[Voltar ao Índice](#indice)

---

## <a name="parte10">10 Upload, download e compressão de arquivos</a>


[Voltar ao Índice](#indice)

---

## <a name="parte11"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte12"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte32"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte14"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte15"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte16"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte17"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte18"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte19"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte20"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte21"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte22"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte23"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte24"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte25"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte26"></a>


[Voltar ao Índice](#indice)

---

## <a name="parte27"></a>


[Voltar ao Índice](#indice)

---