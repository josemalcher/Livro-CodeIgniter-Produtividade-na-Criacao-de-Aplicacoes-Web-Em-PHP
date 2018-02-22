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


- Documentação oficial do CI sobre a library Form Validation: https://codeigniter.com/user_guide/libraries/form_validation.html


[Voltar ao Índice](#indice)

---

## <a name="parte8">8 Enviando e-mails com a library Email</a>

- http://www.universidadecodeigniter.com.br/enviando-emailscom-a-library-nativa-do-codeigniter
- Documentação oficial do CI sobre a library Email: https://codeigniter.com/user_guide/libraries/email.html


[Voltar ao Índice](#indice)

---

## <a name="parte9">9 Gerenciando sessões com a library Session</a>

- http://www.universidadecodeigniter.com.br/trabalhando-comsessoes
- Documentação oficial do CI sobre a Library Session: https://codeigniter.com/user_guide/libraries/sessions.html
- Dica de livro sobre Redis: https://www.casadocodigo.com.br/products/livro-redis

[Voltar ao Índice](#indice)

---

## <a name="parte10">10 Upload, download e compressão de arquivos</a>

- http://www.universidadecodeigniter.com.br/upload-edownload-de-arquivos
- http://www.universidadecodeigniter.com.br/compressao-de-arquivos

- Documentação oficial do CI sobre a library File Uploading: https://codeigniter.com/user_guide/libraries/file_uploading.html
- Documentação oficial do CI sobre o helper Download: https://codeigniter.com/user_guide/helpers/download_helper.html
- Documentação oficial do CI sobre a library ZIP Encoding: https://codeigniter.com/user_guide/libraries/zip.html


[Voltar ao Índice](#indice)

---

## <a name="parte11">11 Implementando CAPTCHA nativo</a>


[Voltar ao Índice](#indice)

---

## <a name="parte12">12 Criando um encurtador de URLs ─ Parte I</a>


[Voltar ao Índice](#indice)

---

## <a name="parte12">13 Criando um encurtador de URLs ─ Parte II</a>


[Voltar ao Índice](#indice)

---

## <a name="parte14">14 Trabalhando com banco de dados</a>


### 14.3 EXECUTANDO CONSULTAS COM $THIS->DB->QUERY()

```php
$query = $this->db->query('SELECT * FROM users');
```

Com parâmetros
```php
$sql = "SELECT * FROM users WHERE id = ? AND status = ? AND name = ?";
$this->db->query($sql, array(3, 'active', 'Lamim'));
```

O retorno do método $this->db->query() é um objeto no qual você terá vários outros métodos para trabalhar com os resultados da query executada. Esses métodos vão desde o total de resultados até a obtenção de um array com a lista de resultados.
 
#### $THIS->DB

Sempre que precisar utilizar um método relacionado a banco de dados no CI, exceto para a classe Database Utility , você deverá usar $this->db , pois é a indicação da instância e da classe onde os métodos estão localizados.

#### result()

Ele retorna um array de objetos, um array vazio, ou então um erro. Ele é muito utilizado em combinação com um foreach().

```php
$query = $this->db->query("SELECT * FROM users");
    foreach ($query->result() as $row){
        echo $row->name;
        echo $row->status;
    }
    
```
Se você quiser obter uma linha específica dentro do array , basta passar como parâmetro o número da linha.

```php
$query = $this->db->query("SELECT * FROM users");
$row = $query->row(3);
    if (isset($row)){
        echo $row->name;
        echo $row->status;
    }
```

#### row()

Ele retorna uma única linha do resultado da consulta, e é sempre a primeira.

```php
$query = $this->db->query("SELECT * FROM users");
$row = $query->row();
    if (isset($row)){
        echo $row->name;
        echo $row->status;
    }
```

#### num_rows()

Ele retorna a quantidade de registros encontrados na consulta.

```php
$query = $this->db->query('SELECT * FROM users');
echo $query->num_rows();
```

### 14.4 QUERY HELPER

O Query Builder é um conjunto de métodos para obtenção de informações da query e do banco de dados.

#### insert_id()

Ele retorna o ID da última instrução INSERT executada.

```php
    $this->db->insert_id()
```

#### affected_rows()

Ele retorna o número de linhas afetadas pela instrução executada.

```php
    $this->db->affected_rows();
```

#### last_query()

Ele retorna a string da última instrução SQL executada.

```php
    $this->db->last_query();
```

#### count_all()

Ele retorna o total de registros de uma tabela. Para isso, basta passar como parâmetro o nome da tabela.

```php
$this->db->count_all('users');
```

### 14.5 QUERY BUILDER

É um conjunto de métodos nativos do CI que permite operações com banco de dados de forma mais simples, com menos código e sem a necessidade de escrever as instruções SQL manualmente.

#### get()
Executa a consulta e retorna o resultado. Pode ser usado para recuperar todos os registros de uma tabela passando como parâmetro o nome da tabela.

```php
    $query = $this->db->get('users');
    
    //Instrução equivalente: SELECT * FROM users
```
Se passar mais dois parâmetros, você consegue limitar a quantidade de registros retornados.

```php
    $query = $this->db->get('users', 5, 10);
    
    //Equivalente a: SELECT * FROM users LIMIT 10, 5
```

#### get_where()

Idêntico ao método anterior, exceto que ele permite que você adicione uma cláusula where no segundo parâmetro em vez de usar o $this->db->where . O terceiro e quarto parâmetros podem ser utilizados para determinar os limites da quantidade de registros retornados.

```php
    $query = $this->db->get_where('users', array('id' => 3), 5, 10);
    
    //Equivalente a: SELECT * FROM users WHERE id = 3 LIMIT 10, 5
```

#### select()

Método que define quais serão os campos da(s) tabela(s) a serem retornados na consulta.

```php
$this->db->select('*'); //Equivalente a: SELECT *
$this->db->select('name, status'); 

//Equivalente a: SELECT name, status
```

#### from()

Método que define a tabela na qual a consulta será realizada.

```php
    $this->db->from('users');
    $this->db->select('name, status')->from('users');
    
    //Equivalente a: SELECT name, status FROM users
```

#### join()

Método utilizado para fazer consultas onde é necessário usar a instrução SQL JOIN, que junta registros de outras tabelas na mesma consulta. Ele recebe dois parâmetros, sendo que o primeiro é o nome da tabela e o segundo são os valores que se equivalem para retorno dos dados.

```php
    $this->db->select('*');
    $this->db->from('posts');
    $this->db->join('comments', 'comments.id = posts.id');
    
    // Equivalente a: SELECT * FROM posts JOIN comments ON comments.id= posts.id
```
Ele aceita ainda um terceiro parâmetro, que pode conter os valores left ou right , que fazer com que sejam executados, respectivamente, LEFT JOIN ou RIGHT JOIN em vez de um simples JOIN .

#### where()

Esse método permite que você defina cláusulas where usando um dos quatro métodos:

- Chave/valor: onde a comparação será sempre usando o comparador = (igual).

```php
    $this->db->where('name', 'Lamim'); 
    // Equivalente a:WHERE name = "Lamim"
```
- Chave/valor customizada: onde você pode definir o operador de comparação a ser utilizado:
```php
    $this->db->where('name !=', 'Lamim'); 
    
// Equivalente a: WHERE name != "Lamim"

    $this->db->where('id >', 3); 
    
// Equivalente a: WHERE id > 3
```

- Array associativo: onde você pode utilizar um array para definir as comparações.
```php
    $array = array('name' => 'Lamim', 'status' => 'active');
    $this->db->where($array);
    
// Equivalente a: WHERE name = 'Lamim' AND status ='active'
```

- String customizada: onde você pode customizar a string da cláusula where .

```php
$where = "name='Lamim' OR status='active'";
$this->db->where($where); 

//Equivalente a: WHERE name='Lamim' OR status='active'
```

#### or_where()
É idêntico ao método anterior, mas adiciona um or à cláusula where .

```php
$this->db->where('name !=', 'Lamim');
$this->db->or_where('id >', 3); 

// Equivalente a: WHERE name != 'Lamim' OR id > 3
```

#### like()

Este método permite gerar cláusulas like , muito úteis para fazer sistemas de buscas de blogs, por exemplo.

- Chave/valor:
```php
$this->db->like('name', 'Lamim');

// Equivalente a: WHERE name LIKE '%Lamim%' ESCAPE '!'
```
- Array associativo
```php
$array = array('name' => 'Lamim', 'status' => 'active');
$this->db->like($array);

// Equivalente a: WHERE name LIKE '%Lamim%' ESCAPE '!' AND status LIKE '%active%' ESCAPE '!'
```

#### or_like()
Idem ao método anterior, porém adicionando um or à cláusula like;

```php
$this->db->like('name', 'Lamim')->or_like('status','active');

// Equivalente a: WHERE name LIKE '%Lamim%' ESCAPE '!' OR name LIKE '%Lamim%' ESCAPE '!'
```

#### not_like()
Idêntico ao like() , mas adiciona um not antes.

```php
$this->db->not_like('name', 'Lamim');

// equivalente a: WHERE name NOT LIKE '%Lamim%' ESCAPE '!'
```

#### group_by()
Esse método adiciona uma cláusula group by à consulta.
```php
$this->db->group_by("name"); 

// Equivalente a: GROUP BY name
```

Também pode ser passado um array como parâmetro:
```php
$this->db->group_by(array('name','status')); 

// Equivalente a: GROUP BY name, status

```

#### order_by()

Esse método adiciona uma cláusula order by à consulta. Ele aceita dois parâmetros: o primeiro é o nome do campo da tabela para a ordenação, e o segundo é a direção do resultado ( asc , desc ou random ).

```php
$this->db->order_by('name', 'DESC');

// Equivalente a: ORDER BY `name` DESC
```
O primeiro parâmetro também pode ser uma string com a cláusula order by já escrita:

```php
$this->db->order_by('name DESC, id ASC');

// Equivalente a: ORDER BY name DESC, id ASC
```


#### limit()
Esse método permite limitar o número de linhas retornadas pela consulta. Ele aceita até dois parâmetros: o primeiro é o número de linhas e o segundo é o deslocamento do resultado.

```php
$this->db->limit(5); // Equivalente a: LIMIT 5
$this->db->limit(5, 10); // Equivalente a: LIMIT 10, 5
```

#### count_all_results()
Esse método retorna o número de registros da consulta realizada. Você pode passar como parâmetro o nome da tabela, ou então usar de forma combinada com alguns dos métodos apresentados anteriormente.

```php
$this->db->count_all_results('users'); // Retorna um inteiro, que equivale ao total de registros na tabela users
$this->db->like('name', 'Lamim');
$this->db->from('users');
$this->db->count_all_results(); // Retorna o total de registros da tabela users que possuem Lamim no nome
```

Todos os métodos listados podem ser concatenados para que se obtenham queries mais completas e, até mesmo, mais complexas.

### Obtendo os resultados das queries executadas

Para obter os resultados de uma query, você pode combinar os métodos get() e result() e obter como retorno um array com os resultados da consulta.

```php
$this->db->select('name')
$this->db->from('users');
$this->db->like('name', 'Lamim');
$results = $this->db->get()->result();
```

### 14.6 CRUD

#### insert()

Esse método gera uma sequência de inserção com base nos dados fornecidos e executa a consulta. Você pode passar um array ou um objeto como segundo parâmetro, pois o primeiro deverá ser sempre o nome da tabela na qual o insert será executado.

```php
$data = array(
    'name' => 'Antunes',
    'status' => 'inactive'
);

$this->db->insert('users', $data);

// Equivalente a: INSERT INTO users (name, status) VALUES ('Antunes', 'inactive')
```

#### update()
Esse método gera uma sequência de atualização com base nos dados fornecidos e executa a consulta. Você pode passar um array ou um objeto como segundo parâmetro, pois o primeiro deverá ser sempre o nome da tabela na qual o update será executado.
```php
$data = array(
    'name' => 'Jonathan Lamim',
    'status' => 'active'
);

$this->db->where('id', 3);
$this->db->update('users', $data);

// Equivalente a: UPDATE users SET name = 'Jonathan Lamim', status= 'active' WHERE id = 3
```

#### delete()

Esse método gera e executa uma string para exclusão de registros do banco de dados. Ele pode receber os parâmetros da seguinte forma:

- Nome da tabela:
```php
$this->db->where('id',3);
$this->db->delete('users'); 
// Equivalente a: 
// DELETE FROM users WHERE id = 3
```

- Nome da tabela / Array com identificador do registro a ser removido:

```php
$this->db->delete('users', array('id' => 3)); 
// Equivalente a: 
// DELETE FROM users WHERE id = 3
```

### Leia mais

- http://www.universidadecodeigniter.com.br/criando-um-crudcom-codeigniter/  
- Documentação oficial do CI sobre banco de dados: https://codeigniter.com/user_guide/database/index.html  

[Voltar ao Índice](#indice)

---

## <a name="parte15">15 Paginação de resultados</a>


[Voltar ao Índice](#indice)

---

## <a name="parte16">16 Usando template parser</a>


[Voltar ao Índice](#indice)

---

## <a name="parte17">17 Manipulando imagens</a>


[Voltar ao Índice](#indice)

---

## <a name="parte18">18 Trabalhando com Composer</a>


[Voltar ao Índice](#indice)

---

## <a name="parte19">19 Poupando tempo de desenvolvimento com funcionalidades nativas do CodeIgniter</a>


[Voltar ao Índice](#indice)

---

## <a name="parte20">20 Migrando um projeto da versão 2.x para a 3.x</a>


[Voltar ao Índice](#indice)

---

## <a name="parte21">21 Mantendo a estrutura de banco de dados atualizada com Migrations</a>


[Voltar ao Índice](#indice)

---

## <a name="parte22">22 Apêndice A</a>


[Voltar ao Índice](#indice)

---

## <a name="parte23">23 Apêndice B</a>


[Voltar ao Índice](#indice)

---

## <a name="parte24">24 Apêndice C</a>


[Voltar ao Índice](#indice)

---

## <a name="parte25">25 Apêndice D</a>


[Voltar ao Índice](#indice)

---

## <a name="parte26">26 Apêndice E</a>


[Voltar ao Índice](#indice)

---

## <a name="parte27">27 Conclusão</a>


[Voltar ao Índice](#indice)

---