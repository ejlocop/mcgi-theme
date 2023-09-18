<?php

// Get options
include(locate_template("template-parts/options/common.php", false, false));

//$classes[] = generate_column_alignment_classes($section['column_alignment']);
$classes[] = '';
?>
<div class="section-inner <?php echo implode(' ', $classes) ?>" style="<?php echo implode(';', $styles) ?>">
    <?php
    // For section background
    include(locate_template('/template-parts/sections/background-media.php', false, false));
    ?>
    <div class="<?php echo $container ?>">
        <div class="row columns">
            <?php
            $column = 1;
            $column = 'column_' . $column;

            $column_class = [
                generate_column_sizes_classes($section[$column . '_column_width']),
                generate_column_offset_classes($section[$column . '_column_offset']),
                generate_column_content_alignment_classes($section[$column . '_content_alignment']),
            ];
            ?>
            <div class="column <?php echo implode(array: $column_class, separator: ' ') ?>">
                <?php if (isset($section[$column . '_icon']) && $section[$column . '_icon']) : ?>
                    <div class="column__icon">
                        <img class="column__icon__img" src="<?php echo isset($section[$column . '_icon']['url']) ? $section[$column . '_icon']['url'] : '' ?>">
                    </div>
                <?php endif ?>

                <?php echo flexi_generate_heading(
                    'section',
                    object_val($section, $column . '_heading'),
                    object_val($section, 'html_section_heading'),
                    ['class' => 'column__heading'],
                    object_val($section, 'settings_section_title_as_h1')
                ) ?>

                <?php if (isset($section[$column . '_content']) && $section[$column . '_content']) : ?>
                    <div class="column__content block-content"><?php echo $section[$column . '_content']; ?></div>
                <?php endif ?>

                <?php
                // For section Call to Action
                include(locate_template("template-parts/sections/call-to-action.php", false, false));
                ?>
            </div>
        </div>
    </div>
</div>