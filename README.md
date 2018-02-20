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

O controller é o que dá vida a uma aplicação. Ele determina o que será executado quando uma requisição HTTP é feita. Ele nada mais é do que uma classe com um ou vários métodos que podem ser acessados a partir da URL, ou que estão associados a URLs através das rotas.

```php
<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Exemplo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Examplo_model');
        $this->load->library('form_validation');
    }

    function Index(){
        $this->load->view('home');
    }
    function Login(){
        $this->load->view('login');
    }
}
```
Essa URL aciona o método Login() do controller Example , e é associada a ele pela rota $route['login'] = 'Exemplo/Login';

Sem a necessidade de uma rota associada, simplesmente definindo na própria URL, www.doma.in/example/login . Dessa forma, o primeiro segmento da URL ( example ) identifica o controller, e o segundo ( login ) identifica o método.

### 3.1 ENVIANDO PARÂMETROS POR MEIO DA URL

```php
    $this->uri->segment(posicao_do_segmento);

    //www.doma.in/user/edit/1
    //$this->uri->segment(3)
```

Documentação oficial do CI sobre Controllers: https://codeigniter.com/user_guide/general/controllers.html

Documentação oficial do CI sobre Rotas: https://codeigniter.com/user_guide/general/routing.html

[Voltar ao Índice](#indice)

---

## <a name="parte4">4 Anatomia de uma view</a>

Uma view nada mais é do que um arquivo HTML, que corresponde a uma tela da aplicação ou fragmento de conteúdo da tela, e que é chamada diretamente pelo controller através do método:
```php
$this->load->view()

$this->load->view('home');

$this->load->view('commons/header');

//Carregando muiltiplas views
$this->load->view('commons/header');
$this->load->view('home');
$this->load->view('commons/footer');
```

### 4.2 ENVIANDO DADOS PARA A VIEW

```php
$data['title'] = "Título da página";
$data['content'] = "Conteúdo da página";
$this->load->view('home', $data);
```
Ao recuperar os dados na view, eles deixam de ser um array para se tornarem variáveis simples. Então, em vez de chamar pelo índice, você chama como variável.

```php
<html>
<head>
<title><?=$title?></title>
</head>
<body>
<p><?=$content?></p>
</body>
</html>
```

#### lista de dados para a view

```php
$data['title'] = "Título da página";
$data['content'] = "Links Importantes";
$data['domains'] = array('www.casadocodigo.com.br','www.livrocodeigniter.com.br');
$this->load->view('home', $data);
```

```php
<html>
<head>
<title><?=$title?></title>
</head>
<body>
<h1><?=$content?></h1>
    <ul>
    <?php foreach($domains as $domain):?>
        <li><?=$domain?></li>
    <?php endforeach; ?>
    </ul>
</body>
</html>
```

### 4.3 RETORNANDO UMA VIEW COMO STRING

Existe um terceiro parâmetro que pode ser aplicado ao método $this->load->view() , que é do tipo booleano e determina se a view será retornada como string , ou se será renderizada no browser.

Como o terceiro parâmetro é opcional, ele tem o valor padrão FALSE , renderizando a view no browser sempre que o método $this->load->view() é chamado.

```php
$data['destinatario'] = "Jonathan Lamim Antunes";
$data['assunto'] = "Lançamento do livro 'CodeIgniter Teoria na Prá tica'";
$this->load->view('templates/email',$data, TRUE);
```

### 4.4 USANDO TEMPLATE PARSER NA VIEW

O Template Parser é uma biblioteca nativa do CI que permite usar pseudovariáveis no lugar de código PHP. Ao fazer o uso desse recurso, o método usado para carregar a view:

```php
$this->load->view() ;

$this->parser->parse();
```

```html
<html>
<head>
<title>{$title}</title>
</head>
<body>
<h1>{$content}</h1>
<ul>
{domains}
<li>{domain}</li>
{/domains}
</body>
</html>
```

Documentação oficial do CI sobre Views: https://codeigniter.com/user_guide/general/views.html

Documentação oficial do CI sobre Template Parser Library: https://codeigniter.com/user_guide/libraries/parser.html


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