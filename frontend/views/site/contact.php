<?php

    /**
     * @var yii\web\View                 $this
     * @var \frontend\models\ContactForm $feedback
     */
    use macgyer\yii2materializecss\widgets\form\ActiveForm;

?>
<?php if($this->beginCache('contact', ['dependency' => ['class' => 'yii\caching\FileDependency', 'fileName' => __DIR__.'/contact.php']])): ?>
    <div class="sectionWithBg fullHeight scrollspy" id="contacts">
        <div class="sectionWithBg-wrap valign-wrapper">
            <div class="container valign">
                <div class="row contact-info mypallete-text">
                    <div class="col s12 m12 l5">
                        <div class="row center-on-small-only">
                            <ul class="contact-list">
                                <li>
                                    <i class="material-icons">phone_in_talk</i>
                                    <div class="contact-item">
                                        <p class="flow-text"><span class="bold">8 (495) 769 99 76</span></p>
                                        <p class="flow-text"><span class="bold">8 (925) 519 59 09</span></p>
                                    </div>
                                </li>
                                <li>
                                    <i class="material-icons">mail</i>
                                    <div class="contact-item">
                                        <p class="flow-text"><span class="bold">sales<span class="r">@</span>newadres.house</span></p>
                                    </div>
                                </li>
                                <li>
                                    <i class="material-icons">place</i>
                                    <div class="contact-item">
                                        <p>Московская область, Дмитровский район, поселок городского типа Деденево, Московское шоссе дом 1</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="map-address">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2217.517202627858!2d37.52238054379776!3d56.234576986342184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTbCsDE0JzA0LjUiTiAzN8KwMzEnMjcuMiJF!5e0!3m2!1sru!2sua!4v1475492688769"
                                    width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 m12 l7">
                        <div class="hide-on-med-and-down">
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                        </div>
                        <p class="flow-text center">Если у Вас остались вопросы, напишите нам!</p>
                        <?php $feedbackForm = ActiveForm::begin([
                                                                    'action'  => [
                                                                        'site/send-mail',
                                                                    ],
                                                                    'options' => [
                                                                        'class' => 'feedback-email',
                                                                        'id'    => 'sendMail-form',
                                                                    ],

                                                                ]) ?>
                        <?= $feedbackForm->field($feedback, 'name', ['options' => ['class' => 'input-field col s12 m6']]) ?>
                        <?= $feedbackForm->field($feedback, 'email', ['options' => ['class' => 'input-field col s12 m6']]) ?>
                        <?= $feedbackForm->field($feedback, 'subject', ['options' => ['class' => 'input-field col s12']]) ?>
                        <?= $feedbackForm->field($feedback, 'body', ['options' => ['class' => 'input-field col s12']])
                                         ->textarea(['class' => 'materialize-textarea']) ?>
                        <div class="input-field col s12">
                            <button class="btn fullWidth mypallete waves-effect waves-light">Отправить сообщение</button>
                        </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endCache() ?>
<?php endif; ?>
