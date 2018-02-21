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

Controller ─ Responsável por interpretar os dados enviados pelo usuário e efetuar o tratamento necessário, repassando esses dados para a view ou para o model.  
Model ─ Responsável pelo gerenciamento de dados, podendo repassar esses dados para a view.  
View ─ Responsável por exibir os dados obtidos e tratados para o usuário.  

#### \site-institucional\application\controllers\Institucional.php
```php
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Institucional extends CI_Controller
{
    public function index()
    {
        $this->load->view('home');
    }
}
?>
```

### O MÉTODO $THIS->LOAD->VIEW() DO CODEIGNITER

#### $this->load->view('view_file', 'data','return_as_data');

- view_file : é a localização do arquivo da view dentro do diretório application/views . Pode estar dividido em subdiretórios, e não é necessário informar a extensão do arquivo.
- data : é a variável ( array ou object ) contendo os dados dinâmicos que serão exibidos na view.
- return_as_data : é um booleano ( TRUE ou FALSE ) que informa se a saída do método vai ser impressa na tela ( FALSE ), ou se vai ser um retorno com o conteúdo da view ( TRUE ). Se não informar esse parâmetro, o conteúdo da view será impresso na tela.

#### \site-institucional\application\views\home.php

```html
<!DOCTYPE html>
<html lang="pt_BR">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-sca le=1">
<meta name="description" content="Exercício de exemplo do capítulo 5 do livro CodeIgniter">
<meta name="author" content="Jonathan Lamim Antunes">
<title>Site Institucional</title>
<link href="<?=base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/css/ie10-viewport-bug-workaround.css')?>" rel="stylesheet">
<link href="<?=base_url('assets/css/home.css') ?>" rel="stylesheet">
<!--[if lt IE 9]><script src="http://getbootstrap.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="http://getbootstrap.com/assets/js/ie-emulation-modes-warning.js"></script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
	<div class="site-wrapper">
		<div class="site-wrapper-inner">
			<div class="cover-container">
				<div class="masthead clearfix">
					<div class="inner">
						<h1 class="masthead-brand">LCI</h1>
						<nav>
							<ul class="nav masthead-nav">
								<li class="active"><a href="#">Home</a></li>
								<li><a href="#">A Empresa</a></li>
								<li><a href="#">Serviços</a></li>
								<li><a href="#">Trabalhe Conosco</a></li>
								<li><a href="#">Fale Conosco</a></li>
							</ul>
						</nav>
					</div>
				</div>
				<div class="inner cover">
					<h1 class="cover-heading">Ensinando através da prática</h1>
					<p class="lead">Até aqui você aprendeu como criar um <i>controller</i>, uma <i>view</i> e a usar a função <i>base_url</i> do helper <i>url</i> utilizando o livro "CodeIgniter: Produtivida de na criação de aplicações web em PHP".</p>
				</div>
			</div>
		</div>
	</div>
<script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
<script src="<?=base_url('assets/js/ie10-viewport-bug-workaround.js')?>"></script>
</body>
</html>
```

#### O MÉTODO BASE_URL()

Para utilizar as funções do helper URL, é preciso abrir o arquivo application/config/autoload.php , e inserir o nome do helper no array com os helpers a serem carregados.
#### application/config/autoload.php

```php
$autoload['helper'] = array('url');
```

#### SOBRE AS ROTAS

São os caminhos das páginas de um site que podem ser configurados para executar um método de um controller específico, cujo nome é diferente do usado na URL.

```
http://url.com/class/method/variable  
http://localhost/exemplos-livro-ci/site-institucional/institucional/empresa  
```
#### application/config/routes.php
```php
$route['default_controller'] = 'Institucional';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['empresa'] = "Institucional/Empresa";
$route['servicos'] = "Institucional/Servicos";
```
As rotas no CI são informadas em um array , no qual seu índice corresponde ao termo que será utilizado na URL.

#### .htaccess

```
<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?$1 [L]
</IfModule>
```
Esse código só será executado caso o mod_rewrite esteja ativado ( <IfModule mod_rewrite.c> ) no Apache; se não estiver, as rotas não vão funcionar. Veja a seguir uma explicação sobre cada linha desse arquivo:
- Linha 2: ativa a engine de reescrita das URLs;
- Linhas 3 e 4: se o arquivo com o nome especificado no navegador não existir, procede com a regra de reescrita da linha 5;
- Linha 5: regra de reescrita da URL, onde ele recupera o valor passado logo após o domínio.

#### site-institucional\application\views\commons\menu.php

```php
<?php 
    if ($this->router->fetch_class() == 'Institucional' && $this -> router->fetch_method() == 'index') { ?>
        <ul class="nav masthead-nav">
<?php 
    }else{ 
?>
        <ul class="nav navbar-nav">
<?php } ?>
            <li class="<?= ($this->router->fetch_class() == 'Institucional' && $this->router->fetch_method() == 'index') ? 'active' : null; ?>"><a href="<?= base_url() ?>" >Home</a></li>
            <li class="<?= ($this->router->fetch_class() == 'Institucional' && $this->router->fetch_method() == 'Empresa') ? 'active' : null; ?>"><a href="<?= base_url('empresa') ?>" >A Empresa</a></li>
            <li class="<?= ($this->router->fetch_class() == 'Institucional' && $this->router->fetch_method() == 'Servicos') ? 'active' : null; ?>"><a href="<?= base_url('servicos') ?>" >Serviços</a></li>
            <li><a href="<?= base_url('trabalhe-conosco') ?>">Trabalhe Conosco</a></li>
            <li><a href="<?= base_url('fale-conosco') ?>">Fale Conosco</a></li>
        </ul>

```
Na primeira linha, temos um if responsável por verificar se a classe chamada ( $this->router->class ) é a Institucional , e se o método é o index . Se for, então a página carregada é a home e o menu recebe as classes para ser formatado no padrão do layout da home. Se for outra classe ou outro método, então é uma página interna e recebe a classe de formatação para as páginas internas.

### 5.5 PASSANDO DADOS DO CONTROLLER PARA A VIEW

```php
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Institucional extends CI_Controller
{
    public function index(){
        $data['title'] = "LCI | HOME";
        $data['description'] = "Exercício de exemplo do capítulo 5 do livro CodeIgniter";

        $this->load->view('home',$data);
    }
    public function Empresa(){
        $data['title'] = "LCI | A Empresa";
        $data['description'] = "Informações sobre a empresa";

        $this->load->view('commons/header', $data);
        $this->load->view('empresa');
        $this->load->view('commons/footer');
    }
    public function Servicos(){
        $data['title'] = "LCI | Serviços";
        $data['description'] = "Informações sobre os serviços prestados";

        $this->load->view('commons/header', $data);
        $this->load->view('servicos');
        $this->load->view('commons/footer');
        
    }
}
?>
```
Qualquer dado que for preciso passar do controller para a view deve ser armazenado em uma variável do tipo Array , e essa variável passada como segundo parâmetro do método $this->load->view() . Assim você poderá fazer a exibição dessas informações dentro da view.


### 5.6 COMPRIMINDO O HTML DE SAÍDA COM UM HOOK DO CI

Para esse exemplo, você vai minificar o HTML de saída das páginas do site que está criando. A minificação do HTML ajuda a deixar o carregamento da página mais rápido.

#### application/config/config.php
```php
$config['enable_hooks'] = FALSE;

//Ajustar para
$config['enable_hooks'] = TRUE;
```

#### application/config/hooks.php
```php
$hook['display_override'][] = array(
'class' => '',
'function' => 'compress',
'filename' => 'compress.php',
'filepath' => 'hooks'
);
```
#### site-institucional\application\hooks\compress.php

```php
<?php if (!defined('BASEPATH')) exit('No direct script access a
llowed');
function compress()
{
    ini_set("pcre.recursion_limit", "16777");
    $CI = &get_instance();
    $buffer = $CI->output->get_output();
    $re = '%
(?>
[^\S ]\s*
| \s{2,}
)
(?=
[^<]*+
(?:
<
(?!/?(?:textarea|pre|script)\b)
[^<]*+
)*+
(?:
<
(?>textarea|pre|script)\b
| \z
)
)
%Six';
    $new_buffer = preg_replace($re, " ", $buffer);
    if ($new_buffer === null) {
        $new_buffer = $buffer;
    }
    $CI->output->set_output($new_buffer);
    $CI->output->_display();
}
```

- Documentação oficial do CI sobre Controllers:
https://codeigniter.com/user_guide/general/controllers.html

- Documentação oficial do CI sobre o Helper URL:
https://codeigniter.com/user_guide/helpers/url_helper.html

- Documentação oficial do CI sobre Hooks:
https://codeigniter.com/user_guide/general/hooks.html

- Documentação oficial do CI sobre Sessions:
https://codeigniter.com/user_guide/libraries/sessions.html

- Documentação oficial do CI sobre Views:
https://codeigniter.com/user_guide/general/views.html

- Detalhes sobre Compress HTML Output:
https://github.com/bcit-ci/CodeIgniter/wiki/Compress-HTML-output.

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