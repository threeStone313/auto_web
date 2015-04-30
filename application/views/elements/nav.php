<?php 

$nav_arr = array(

	'Dashboard' => array(
				'icon' => 'icon-home',
				'url' => 'dashboard/index',
				),
	'Project' => array(
				'icon' => 'icon-tasks',
				'url' => 'project/index',
/*				'child' => array(
						'List' => array(
						'icon' => 'icon-th-list',
						'url' => 'project/index',
						),
						'Add' => array(
						'icon' => 'icon-plus',
						'url' => 'project/add',
						),
				),*/
				),
	'EleRepository' => array(

			'icon' => 'icon-compass',
			'url' => 'ele_repository/index',
			'blank'=>'1',

		),
	'PackStep' => array(
			'icon' => 'icon-smiley',
			'url' => 'pack/index',
			'blank'=>'1',

		),
	'ScreenShot' => array(
			'icon' => 'icon-smiley',
			'url' => 'result/screenshot',
			'blank' => '1',
		),
	'Report' => array(
			'icon' => 'icon-comment-alt',
			'url' => 'result/test-report/power-emailable-report.html',
			'blank' => '1',
		),
);
list($cur_c, $cur_a) = getCurrentRoute();
?>

<!-- Main navigation -->
<nav class="main-navigation main-navigation-sidebar navbar navbar-default" role="navigation">

	<!-- Collapse navigation for mobile -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".main-navigation-collapse">
			<span class="elusive icon-graph"></span> MENU
		</button>
	</div>
	<!-- /Collapse navigation for mobile -->

	<!-- Navigation -->
	<div class="main-navigation-collapse collapse navbar-collapse">

		<!-- Navigation items -->
		<ul class="nav navbar-nav">
			<?php foreach ($nav_arr as $name => $attr) :
				list($c, $a) = explode( '/', $attr['url'] );
			?>

			<?php if ( isset( $attr['child'] )):
				$active = $cur_c == $c ? 'active open' : '';
			?>
			<li class="dropdown <?php echo $active;?>">
				<a href="<?php echo '/'.$attr['url'];?>" class="dropdown-toggle" data-toggle="dropdown"><span class="elusive <?php echo $attr['icon'];?>"></span> <?php echo $name?> <b class="caret"></b></a>
				<ul class="dropdown-menu">
				<?php foreach( $attr['child'] as $child_name => $child_attr ):
					$active = ( $cur_c.'/'.$cur_a) == $child_attr['url'] ? 'active' : '';
				?>
					<li class="<?php echo $active;?>"><a href="<?php echo '/'.$child_attr['url'];?>"><span class="elusive <?php echo $child_attr['icon'];?>"></span> <?php echo $child_name?></a></li>
				<?php endforeach;?>
				</ul>
			</li>

		    <?php else:
		    	$active = $cur_c == $c ? 'active' : '';
		    	$blank = isset( $attr['blank'] ) ? ' target="_blank" ': '';
		    ?>
			<!-- Default navigation items -->
			<li class="<?php echo $active;?>">
				<a href="<?php echo '/'.$attr['url'];?>" <?php echo $blank;?>><span class="elusive <?php echo $attr['icon'];?>"></span> <?php echo $name?></a>
			</li>
			<!-- /Default navigation items -->

			<?php endif;endforeach;?>
		</ul>
		<!-- /Navigation items -->

	</div>
	<!-- /Navigation -->

</nav>
<!-- /Main navigation -->