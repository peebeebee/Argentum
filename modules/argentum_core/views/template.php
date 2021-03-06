<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
	<head>
		<meta http-equiv="content-language" content="en" />
		<meta http-equiv="content-type" content="charset=utf-8" />
		<title><?=$title?></title>
		<?=html::stylesheet(array('css/reset', 'css/layout', 'css/style', 'css/print', 'css/colorbox', 'css/colorbox-custom'),
		                    array('', '', '', 'print', '', ''))?>
		<?php if (Auth::instance()->logged_in()) page::render('stylesheet')?>

		<?=html::script('js/lib/jquery')?>
		<?=html::script('js/lib/colorbox')?>
		<?=html::script('js/lib/livequery')?>
		<?=html::script('js/lib/form')?>
		<?=html::script('js/lib/jquery.tablesorter.min')?>
		<?=html::script('js/effects')?>
		<?php if (Auth::instance()->logged_in()) page::render('javascript')?>
	</head>
	<body>
		<div id="body">
			<div id="header">
				<a href="<?=url::base(TRUE)?>"><?=html::image(array('src' => 'images/argentum_logo_tagline.png', 'alt' => 'Argentum', 'class' => 'clear'))?></a>
			</div>
			<div id="navigation">
				<?php if (Auth::instance()->logged_in()):?><ul id="nav">
					<li><?=html::anchor('', 'Home')?></li>
					<li><?=html::anchor('client', 'Clients')?></li>
					<li><?=html::anchor('project', 'Projects')?></li>
					<li><?=html::anchor('invoice', 'Invoices')?></li>
					<?php Event::run('argentum.nav_links_display')?>
					<li class="small"><?=html::anchor('user/index', 'My Account')?></li><?php if (Auth::instance()->logged_in('admin')):?>
					<li class="small"><?=html::anchor('admin/settings', 'Settings')?></li><?php endif; ?>
					<li class="small"><?=html::anchor('user/logout', 'Logout')?></li>
				</ul><?php endif;?>
			</div>
			<div id="quicksearch">
				<?php if (Auth::instance()->logged_in()):?><?=form::open('project/search', array('method' => 'get'))?>
					<p><?=form::input('term')?> <?=form::submit('submit', 'Search Projects')?></p>
				</form><?php endif;?>
			</div>
			<div class="clear">
				&nbsp;
			</div>
			<div id="content">
				<?=$content?>
				<?php if (Auth::instance()->logged_in()) Event::run('argentum.body_display')?>
			</div>
			<div id="footer">
				&copy; 2009 Argentum Team
			</div>
			
			
		</div>
	</body>
</html>
