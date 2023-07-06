<?php

$links = get_field('social_network_links', 'options');

?>

<?php if(!empty($links)): ?>
	<ul class="block-socials">
		<?php foreach($links as $link): ?>
			<li class="block-socials__item">
				<a href="<?php echo $link['url'] ?>" title="<?php echo $link['display_name'] ?>" target="_blank">
					<span class="block-socials__item__title"><?php echo $link['display_name'] ?></span>
					<i class="block-socials__item__icon fa fa-<?php echo $link['label'] ?>"></i>
				</a>
			</li>
		<?Php endforeach ?>
	</ul>
<?Php endif ?>