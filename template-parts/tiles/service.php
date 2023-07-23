<?php
$acf_fields = get_fields($tile->ID);
$tile_data = [
    'title'      => $acf_fields['name'],
    'content'    => $acf_fields['description'],
    'excerpt'    => $acf_fields['description'],
    'thumbnail'  => $acf_fields['image']
];
// $date = new DateTime($tile->post_date);
// echo '<pre>';
// print_r($acf_fields);
// echo '</pre>';
// die;
?>

<div class="tiles__item --card --revealed">

    <?php if (!is_null($tile_data['thumbnail'])) : ?>
        <div class="tiles__item__thumbnail">
            <img class="tiles__item__thumbnail__img" src="<?php echo $tile_data['thumbnail'] ?>">
        </div>
    <?php endif ?>

    <div class="tiles__item__content">
        <?php echo flexi_generate_heading(
            'tile',
            object_val($tile_data, 'title'),
            'h4',
            ['class' => 'tiles__item__heading']
        ) ?>
        <?php if ($tile_data['excerpt']) : ?>
            <div class="tiles__item__description"><?php echo $tile_data['excerpt'] ?></div>
        <?php endif ?>
    </div>
</div>