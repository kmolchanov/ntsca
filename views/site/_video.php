<?php

/** @var app\models\Video $model */

use app\models\Video;

$description = $model->description;
$player = $model->youtubePlayerHtml;
?>

<?php if ($player): ?>
    <section class="page-video my-5">
        <?php if ($model->description_position == Video::DESCRIPTION_POSITION_TOP && $description): ?>
            <div class="mb-4">
                <?= $description ?>
            </div>
        <?php endif; ?>

        <?php if (in_array($model->description_position, [Video::DESCRIPTION_POSITION_LEFT, Video::DESCRIPTION_POSITION_RIGHT], true)): ?>
            <div class="row align-items-center">
                <?php if ($model->description_position == Video::DESCRIPTION_POSITION_LEFT): ?>
                    <div class="col-md-5">
                        <?= $description ?>
                    </div>
                    <div class="col-md-7">
                        <?= $player ?>
                    </div>
                <?php else: ?>
                    <div class="col-md-7">
                        <?= $player ?>
                    </div>
                    <div class="col-md-5">
                        <?= $description ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?= $player ?>
        <?php endif; ?>

        <?php if ($model->description_position == Video::DESCRIPTION_POSITION_BOTTOM && $description): ?>
            <div class="mt-4">
                <?= $description ?>
            </div>
        <?php endif; ?>

    </section>
<?php endif; ?>
