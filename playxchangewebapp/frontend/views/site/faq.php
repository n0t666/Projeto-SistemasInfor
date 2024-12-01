<?php

use yii\helpers\Html;

$this->title = 'FAQs';

$this->registerCssFile('@web/css/faq.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::className()]]);

?>

<div class="container py-2">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card card-style1 border-0">
                <div class="card-body p-4 p-md-5 p-xl-6">
                    <div class="text-center mb-2-3 mb-lg-6">
                        <span class="section-title text-primary">FAQ's</span>
                        <h2 class="h1 mb-0 text-secondary">Frequently Asked Questions</h2>
                    </div>
                    <div id="accordion" class="accordion-style">
                        <?php foreach ($faqs as $index => $faq): ?>
                            <div class="card mb-3">
                                <div class="card-header" id="heading<?= $index ?>">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link <?= $index === 0 ? '' : 'collapsed' ?>" data-bs-toggle="collapse" data-bs-target="#collapse<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $index ?>">
                                            <span class="text-theme-secondary me-2">Q.</span> <?= Html::encode($faq->pergunta) ?>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse<?= $index ?>" class="collapse <?= $index === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $index ?>" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <?= Html::encode($faq->descricao) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
