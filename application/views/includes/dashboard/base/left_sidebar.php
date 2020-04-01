<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url($this->uri->segment(1))?>">
  <div class="sidebar-brand-icon rotate-n-15">
	<i class="fas fa-laugh-wink"></i>
  </div>
  <div class="sidebar-brand-text mx-3">Codeigniter 3 </div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
  <a class="nav-link" href="<?php echo base_url($this->uri->segment(1))?>">
	<i class="fas fa-fw fa-tachometer-alt"></i>
	<span>Başlangıç</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  Etkinlikler
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
	<i class="fas fa-fw fa-cog"></i>
	<span>Sayfa</span>
  </a>
	<?php 
		if ($category=="pages"){
			echo ' <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionSidebar">';
		}
		else{
			echo ' <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">';

		}

	?>
	<div class="bg-white py-2 collapse-inner rounded">
	  <a class="collapse-item" href="<?php echo base_url($this->uri->segment(1) . "/page/ekle")?>">Yeni Sayfa Oluşturun</a>
	  <a class="collapse-item" href="<?php echo base_url($this->uri->segment(1) . "/page")?>">Sayfaları Listeleyin</a>
	</div>
  </div>

</li>
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
	<i class="fas fa-fw fa-cog"></i>
	<span>Ortam</span>
  </a>
	<?php 
		if ($category=="media"){
			echo ' <div id="collapseFour" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionSidebar">';
		}
		else{
			echo ' <div id="collapseFour" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">';

		}

	?>
	<div class="bg-white py-2 collapse-inner rounded">
	  <a class="collapse-item" href="<?php echo base_url($this->uri->segment(1) . "/media/ekle")?>">Yeni Ortam Ekleyin</a>
	  <a class="collapse-item" href="<?php echo base_url($this->uri->segment(1) . "/media")?>">Ortamları Listeleyin</a>
	</div>
  </div>

</li>


<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTicket" aria-expanded="true" aria-controls="collapseTicket">
	<i class="fas fa-fw fa-cog"></i>
	<span>Mesaj</span>
  </a>
	<?php 
		if ($category=="ticket"){
			echo ' <div id="collapseTicket" class="collapse show" aria-labelledby="headingTicket" data-parent="#accordionSidebar">';
		}
		else{
			echo ' <div id="collapseTicket" class="collapse" aria-labelledby="headingTicket" data-parent="#accordionSidebar">';

		}

	?>
	<div class="bg-white py-2 collapse-inner rounded">
	  <a class="collapse-item" href="<?php echo base_url($this->uri->segment(1) . "/ticket/ekle")?>">Yeni Mesaj Ekleyin</a>
	  <a class="collapse-item" href="<?php echo base_url($this->uri->segment(1) . "/ticket")?>">Mesajları Listeleyin</a>
	</div>
  </div>

</li>


<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNotification" aria-expanded="true" aria-controls="collapseNotification">
	<i class="fas fa-fw fa-cog"></i>
	<span>Bildirim</span>
  </a>
	<?php 
		if ($category=="notification"){
			echo ' <div id="collapseNotification" class="collapse show" aria-labelledby="headingNotification" data-parent="#accordionSidebar">';
		}
		else{
			echo ' <div id="collapseNotification" class="collapse" aria-labelledby="headingNotification" data-parent="#accordionSidebar">';

		}

	?>
	<div class="bg-white py-2 collapse-inner rounded">
		<a class="collapse-item" href="<?php echo base_url($this->uri->segment(1) . "/notification/")?>">Bildirim Listele</a>
	</div>
  </div>

</li>
<!-- Divider -->
<hr class="sidebar-divider">

<!-- Nav Item - Charts -->
<li class="nav-item">
  <a class="nav-link" href="<?php echo base_url("logout")?>">
	<i class="fas fa-fw fa-chart-area"></i>
	<span>Çıkış Yap</span></a>
</li>


<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
