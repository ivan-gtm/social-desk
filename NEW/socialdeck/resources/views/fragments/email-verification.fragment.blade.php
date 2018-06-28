        <div id="checkout-result" class="minipage">
            <div class="inner">
                <span class="icon">
                    <span class="sli sli-like color-success"></span>
                </span>
                <h1 class="page-primary-title"><?= __('Success!') ?></h1>
                <p>
                    <?= __("You've successfully verified the your email address.") ?>
                </p>

                <?php if ($AuthUser): ?>
                    <a href="<?= Config::get('constants.APPURL')."/post" ?>" class="small button"><?= __("Add post") ?></a>
                    <a href="<?= Config::get('constants.APPURL')."/profile" ?>" class="small button button--simple"><?= __('Go to Account') ?></a>
                <?php else: ?>
                    <a href="<?= Config::get('constants.APPURL')."/login" ?>" class="small button"><?= __("Login") ?></a>
                <?php endif ?>
            </div>
        </div>