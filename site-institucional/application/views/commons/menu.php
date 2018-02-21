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
