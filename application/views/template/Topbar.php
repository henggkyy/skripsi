<div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-lg welcome-message"><span style="font-weight: bold;">You're logged in as :</span> <?php echo $this->session->userdata('nama');?> (<?php echo $this->session->userdata('email');?>)</span>
                </li>
                <li>
                    <a href="<?php echo base_url();?>logout">
                        <i class="fas fa-sign-out-alt"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
        
        
