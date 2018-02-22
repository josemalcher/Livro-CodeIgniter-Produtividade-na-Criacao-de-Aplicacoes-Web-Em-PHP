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
Essa URL aciona o método Login() do controller Example , e é associada a ele pela rota:

```php
    $route['login'] = 'Exemplo/Login';
```

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
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function compress()
{
    ini_set("pcre.recursion_limit", "16777");
    $CI = & get_instance();
    $buffer = $CI->output->get_output();
    $re = '%(?>[^\S ]\s*| \s{2,})(?=[^<]*+(?:<(?!/?(?:textarea|pre|script)\b)[^<]*+)*+(?:<(?>textarea|pre|script)\b| \z))%Six';
    $new_buffer = preg_replace($re, " ", $buffer);
    if ($new_buffer === null) {
        $new_buffer = $buffer;
    }
    $CI->output->set_output($new_buffer);
    $CI->output->_display();
}
```

- Documentação oficial do CI sobre Controllers: https://codeigniter.com/user_guide/general/controllers.html

- Documentação oficial do CI sobre o Helper URL: https://codeigniter.com/user_guide/helpers/url_helper.html

- Documentação oficial do CI sobre Hooks: https://codeigniter.com/user_guide/general/hooks.html

- Documentação oficial do CI sobre Sessions: https://codeigniter.com/user_guide/libraries/sessions.html

- Documentação oficial do CI sobre Views: https://codeigniter.com/user_guide/general/views.html

- Detalhes sobre Compress HTML Output: https://github.com/bcit-ci/CodeIgniter/wiki/Compress-HTML-output.

[Voltar ao Índice](#indice)

---

## <a name="parte6">6 Criando um site institucional ─ Parte II</a>

#### Como o cache do CodeIgniter funciona?

O cache é individual, por página, e você poderá definir por quanto tempo cada página deverá permanecer em cache sem que tenha o seu conteúdo atualizado. Ao ser carregada pela primeira vez, o arquivo de cache é gerado e salvo em application/cache .

Já nos demais acessos à página, esse arquivo salvo será recuperado e exibido para o usuário. Caso ele tenha expirado, o arquivo será removido e atualizado antes de ser exibido para o usuário.

- De forma individual para cada método, você deverá inserir a chamada $this->output->cache($n) em cada controller cuja view de saída você queira armazenar em cache.

O $n é o tempo em minutos.

```php
public function index()
{
    $this->output->cache(1440); //Corresponde a 24 horas até o cache ser atualizado

    $data['title'] = "LCI | Home";
    $data['description'] = "Exercício de exemplo do capítulo 5 do
    livro CodeIgniter";
    $this->load->view('home',$data);
}

```

- todos os métodos de uma classe que possuem views como saída. Para isso,   você vai criar um método __construct() na classe em que quer   configurar o cache de forma global.

```php
public function __construct()
{
    parent::__construct();
    $this->output->cache(1440);
}
```
- Se um método não possui uma view como saída, por exemplo, um método private usado para tratar algum dado no controller, que retorna um valor específico, ele não será armazenado em cache. 
- Se você alterar opções de configuração que afetem a saída (HTML), será necessário excluir manualmente os arquivos armazenados em cache para que essas mudanças sejam
aplicadas às views.

#### Excluindo caches

Você pode excluir os caches manualmente, removendo os arquivos do diretório application/cache , mas também pode utilizar o método delete_cache() , que é capaz de remover todos os arquivos de cache e ele não será mais atualizado após expirar.

```php
// Removendo todos os arquivos:
    $this->output->delete_cache();
// Removendo o arquivo de cache da página de serviços:
    $this->output->delete_cache('servicos');
```

#### Validando o formulário de contato

```php
public function FaleConosco(){
        $data['title'] = "LCI | Fale Conosco";
        $data['description'] = "Exercício de exemplo do capítulo 5 do livro CodeIgniter";

        // Validadores
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('assunto', 'Assunto', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('mensagem', 'Mensagem', 'trim|required|min_length[30]');

        if($this->form_validation->run() == FALSE){
            $data['formErrors'] = validation_errors();
        }else{
            $data['formErrors'] = null;
        }

        $this->load->view('commons/header', $data);
        $this->load->view('fale-conosco',$data);
        $this->load->view('commons/footer');
    }
```


```
$this->form_validation->set_rules(nome_do_campo, descricao_do_campo, regras_de_validacao_aninhadas);
```
- nome_do_campo : é o nome especificado no atributo name do input ;
- descricao_do_campo : é o nome do campo que será exibido na mensagem de erro;
- regras_de_validacao_aninhadas : são as regras que devem ser aplicadas em cada campo.

Com o código que foi escrito até o momento, o processo de validação do formulário já está funcionando. Ele está, inclusive, passando para a view as informações em caso de erro, passadas pela variável $data['formErrors'] , que recebe os dados retornados de validation_errors() ─ método responsável por recuperar as mensagens logo após as regras de validação serem executadas em $this->form_validation->run() .

```php
if($this->form_validation->run() == FALSE){
            $data['formErrors'] = validation_errors();
        }else{
            $this->session->set_flashdata('success_msg', 'Contato recebido com sucesso!');
            $data['formErrors'] = null;
        }
```
Caso o formulário seja enviado com sucesso, está sendo criada uma session pelo método set_flashdata , que recebe dois parâmetros. O primeiro é o identificador da session, que será usado para recuperar essa informação na view, e o segundo é o valor da session, nesse caso a mensagem a ser exibida para o usuário.

#### site-institucional/application/views/fale-conosco.php

```php
            <?php if($formErrors){?>
                <div class="alert alert-danger">
                    <?=$formErrors?>
                </div>
            <?php }else{
                if($this->session->flashdata('success_msg')) {?>
                    <div class="alert alert-success">
                        <?=$this->session->flashdata('success_msg')?>
                    </div>
            <?php } } ?>
                

```

#### A DIFERENÇA ENTRE SET_FLASHDATA() E FLASHDATA()

set_flashdata() é usado para setar o valor da session temporária, enquanto flashdata() é utilizado para recuperar o valor dessa session.

#### set_value()

```php
<form class="form-horizontal" method="POST" action="">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="nome">Nome</label>
                    <div class="col-md-8">
                        <input id="nome" name="nome" placeholder="Nome" class="form-control input-md" required="" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="nome">Nome</label>
                    <div class="col-md-8">
                        <input id="nome" name="nome" placeholder="Nome" class="form-control input-md" required="" type="text" value="<?= set_value('nome') ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="email">Email</label>
                    <div class="col-md-8">
                        <input id="email" name="email" placeholder="Email" class="form-control input-md" required="" type="text" value="<?= set_value('email') ?>">
                        <span class="help-block">Ex.: email@example.com</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="assunto">Assunto</label>
                        <div class="col-md-8">
                            <input id="assunto" name="assunto" placeholder="Assunto" class="form-control input-md" required="" type="text" value="<?= set_value('assunto')?>">
                        </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="mensagem">Mensagem</label>
                        <div class="col-md-8">
                            <textarea class="form-control" id="mensagem" name="mensagem" rows="10"><?= set_value('mensagem') ?></textarea>
                        </div>
                </div>
        </div>
```

### 6.4 ENVIANDO OS DADOS DO FORMULÁRIO DE CONTATO POR E-MAIL

```php
 public function SendEmailToAdmin($from, $fromName, $to, $toName, $subject, $message, $reply = null, $replyName = null){
        $this->load->library('email');

        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'smtp.seudominio.com.br';
        $config['smtp_user'] = 'user@seudominio.com.br';
        $config['smtp_pass'] = 'suasenha';
        $config['newline'] = '\r\n';

        $this->email->initialize($config);
        $this->email->from($from, $fromName);
        $this->email->to($to, $toName);

        if($reply){
            $this->email->reply_to($reply, $replyName);
        }
        $this->email->subject($subject);
        $this->email->message($message);
        if($this->email->send())
            return true;
        else
            return false;
    }
    
   public function FaleConosco(){
        $data['title'] = "LCI | Fale Conosco";
        $data['description'] = "Exercício de exemplo do capítulo 5 do livro CodeIgniter";

        // Validadores
        $this->form_validation->set_rules('nome', 'Nome', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('assunto', 'Assunto', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('mensagem', 'Mensagem', 'trim|required|min_length[30]');

        if($this->form_validation->run() == FALSE)
        {
            $data['formErrors'] = validation_errors();
        }
        else
        {
            $formData = $this->input->post();
            $emailStatus = $this->SendEmailToAdmin($formData['email'],$formData['nome'],"to@domain.com","To Name", $formData['assunto'], $formData['mensagem'],$formData['email'],$formData['nome']);

            if($emailStatus)
            {
                $this->session->set_flashdata('success_msg', 'Contato recebido com sucesso!');
            }
            else
            {
                $data['formErrors'] = "Desculpe! Não foi possível enviar o seu contato. tente novamente mais tarde.";
            }
        }


        $this->load->view('commons/header', $data);
        $this->load->view('fale-conosco',$data);
        $this->load->view('commons/footer');
    }
    public function TrabalheConosco(){
        $data['title'] = "LCI | Trabalhe Conosco";
        $data['description'] = "Exercício de exemplo do capítulo 5 do livro CodeIgniter";

        $this->load->view('commons/header', $data);
        $this->load->view('trabalhe-conosco',$data);
        $this->load->view('commons/footer');
    }
```
    
    
### $THIS->INPUT->POST()

É um método muito importante quando se trabalha com formulários no CI. Além de recuperar todos os dados do formulário, é possível recuperar campos específicos, passando o nome do campo como parâmetro.
Por exemplo, se você quisesse recuperar apenas o campo email do formulário de contato, bastaria chamar $this->input->post('email') .

Atenção: esse método não recupera informações de campos do tipo file .

6.5 CRIANDO A PÁGINA DO TRABALHE CONSOCO

```html 
<!-- <form class="form-horizontal" method="POST" action="<?=base_url('trabalhe-conosco')?>"> -->
<?= form_open_multipart(base_url('trabalhe-conosco'), array("class" => "form-horizontal", "method"=>"POST")); ?>
...
<!-- </form> -->
<?= form_close(); ?>
```
Veja que, para o base_url() , foi passado como parâmetro 'trabalhe-conosco' em vez de 'fale-conosco'. Isso foi feito pois estamos trabalhando no formulário da tela 'Trabalhe Conosco', e vamos utilizar uma rota diferente para acesso e processamento dos dados a serem enviados.

```html

<!-- <input id="nome" name="nome" placeholder="Nome" class="form-control input-md" required="" type="text" value="<?=set_value('nome')?>"> -->
<?= form_input(array("name"=>"nome","id"=>"nome"),set_value('nome'),array("class"=>"form-control input-md","required"=>"","type"=>"text","placeholder"=>"Nome")); ?>

```

```php

            <?= form_open_multipart(base_url('trabalhe-conosco'), array("class" => "form-horizontal", "method" => "POST")); ?>

            <div class="form-group">
                <label class="col-md-2 control-label" for="nome">Nome</label>
                <div class="col-md-8">
                    <?= form_input(array("name" => "nome", "id" => "nome"), set_value('nome'), array("class" => "form-control input-md", "required" => "", "type" => "text", "placeholder" => "Nome")); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="email">Email</label>
                <div class="col-md-8">
                    <?= form_input(array("name" => "email", "id" => "email"), set_value('email'), array("class" => "form-control input-md", "required" => "", "type" => "text", "placeholder" => "Email")); ?>
                    <span class="help-block">Ex.: email@example.com</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="telefone">Telefone de Contato</label>
                <div class="col-md-8">
                    <?= form_input(array("name" => "telefone", "id" => "telefone"), set_value('telefone'), array("class" => "form-control input-md", "required" => "", "type" => "text", "placeholder" => "Telefone de Contato")); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="mensagem">Mensagem</label>
                <div class="col-md-8">
                    <?= form_textarea(array("name" => "mensagem", "id" => "mensagem"), set_value('mensagem'), array("class" => "form-control input-md", "required" => "", "type" => "text", "placeholder" => "Mensagem")); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label" for="curriculo">Currículo</label>
                <div class="col-md-8">
                    <?= form_upload(array("name" => "curriculo", "id" => "curriculo"), set_value('curriculo'), array("class" => "input-file", "required" => "")); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-10">
                    <?= form_submit(array("name" => "Enviar", "id" => "enviar"), "Enviar", array("class" => "btn btn-default pull-right")); ?>
                </div>
            </div>

            <?= form_close(); ?>

```

- form_open() e form_open_multipart() :   
form_open([$action = ''[, $attributes = ''[,$hidden = array()]]])  
form_open_multipart([$action = ''[,$attributes = array()[, $hidden = array()]])  
    - $action (string) – URL para execução do "action".  
    - $attributes (array) – Atributos HTML.  
    - $hidden (array) – Lista com campos do tipo hidden .  

form_input() , form_upload() , form_textarea() e form_submit() :   
form_input([$data = ''[, $value = ''[, $extra= '']])  
form_upload([$data = ''[, $value = ''[,$extra = '']])  
form_textarea([$data = ''[, $value = ''[,$extra = '']]])  
form_submit([$data = ''[, $value = ''[,$extra = '']]])  
    - $data (array) – Atributos do campo.  
    - $value (string) – Valor do campo.  
    - $extra (mixed) – Atributos extras, podendo ser um array ou string literal.  

### 6.5 CRIANDO A PÁGINA DO TRABALHE CONSOCO    

```php
public function TrabalheConosco(){
        $data['title'] = "LCI | Trabalhe Conosco";
        $data['description'] = "Exercício de exemplo do capítulo 5 do livro CodeIgniter";
        $data['formErrors'] = null;

        $this->form_validation->set_rules('nome', 'Nome', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('telefone', 'Telefone', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('mensagem', 'Mensagem', 'trim|required|min_length[30]');

        if($this->form_validation->run() == FALSE)
        {
            $data['formErrors'] = validation_errors();
        }
        else
        {
            $uploadCurriculo = $this->UploadFile('curriculo');

            if($uploadCurriculo['error'])
            {
                $data['formErrors'] = $uploadCurriculo['message'];
            }
            else
            {
                $formData = $this->input->post();
                $emailStatus = $this->SendEmailToAdmin($formData['email'],$formData['nome'],"to@domain.com","To Name", "Trabalhe Conosco", $formData['mensagem'],$formData['email'],$formData['nome'],$uploadCurriculo['fileData']['full_path']);

                if($emailStatus)
                {
                    $this->session->set_flashdata('success_msg', 'Contato recebido com sucesso!');
                }
                else
                {
                    $data['formErrors'] = "Desculpe! Não foi possível enviar o seu contato. tente novamente mais tarde.";
                }
            }
        }



        $this->load->view('commons/header', $data);
        $this->load->view('trabalhe-conosco',$data);
        $this->load->view('commons/footer');
    }
```

### DO_UPLOAD()

O método do_upload() recebe como parâmetro o nome do campo tipo file usado no formulário. No exemplo, ele recebe uma variável $inputFileName , que é o parâmetro do método UploadFile() . Assim, sempre que precisar fazer um upload de arquivo, basta chamar esse método informando o nome do campo.    

O retorno do método upload->data() é um array similar ao do exemplo a seguir, trazendo informações bem específicas sobre o arquivo.

```php
Array
(
    [file_name] => mypic.jpg
    [file_type] => image/jpeg
    [file_path] => /path/to/your/upload/
    [full_path] => /path/to/your/upload/jpg.jpg
    [raw_name] => mypic
    [orig_name] => mypic.jpg
    [client_name] => mypic.jpg
    [file_ext] => .jpg
    [file_size] => 22.2
    [is_image] => 1
    [image_width] => 800
    [image_height] => 600
    [image_type] => jpeg
    [image_size_str] => width="800" height="200"
)
```

Bootstrap: http://getbootstrap.com  
Documentação oficial do CI sobre o Helper Form: https://codeigniter.com/user_guide/helpers/form_helper.html  
Documentação oficial do CI sobre a Library Email: https://codeigniter.com/user_guide/libraries/email.html  
Documentação oficial do CI sobre a Library File Uploading: https://codeigniter.com/user_guide/libraries/file_uploading.html  
Documentação oficial do CI sobre a Library Form Validation: https://codeigniter.com/user_guide/libraries/form_validation.html  



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