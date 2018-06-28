        <div class="asidenav">
            <div class="asidenav-group">
                <div class="asidenav-title"><?= __("General Settings") ?></div>
                <ul>
                    <li class="<?= $page == "site" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/site" ?>"><?= __("Site Settings") ?></a></li>
                    <li class="<?= $page == "logotype" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/logotype" ?>"><?= __("Logotype") ?></a></li>
                    <li class="<?= $page == "other" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/other" ?>"><?= __("Other Settings") ?></a></li>
                    <li class="<?= $page == "experimental" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/experimental" ?>"><?= __("Experimental Features") ?></a></li>
                </ul>
            </div>

            <div class="asidenav-group">
                <div class="asidenav-title"><?= __("Proxy") ?></div>
                <ul>
                    <li class="<?= $page == "proxy" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/proxy" ?>"><?= __("Settings") ?></a></li>
                    <li><a href="<?= Config::get('constants.APPURL')."/proxies" ?>"><?= __("Proxy Addresses") ?></a></li>
                </ul>
            </div>

            <div class="asidenav-group">
                <div class="asidenav-title"><?= __("Email") ?></div>
                <ul>
                    <li class="<?= $page == "smtp" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/smtp" ?>"><?= __("SMTP") ?></a></li>
                    <li class="<?= $page == "notifications" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/notifications" ?>"><?= __("Email Notifications") ?></a></li>
                </ul>
            </div>

            <div class="asidenav-group">
                <div class="asidenav-title"><?= __("Integrations") ?></div>
                <ul>
                    <li class="<?= $page == "google-analytics" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/google-analytics" ?>"><?= __("Google Analytics") ?></a></li>
                    <li class="<?= $page == "google-drive" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/google-drive" ?>"><?= __("Google Drive Picker") ?></a></li>
                    <li class="<?= $page == "dropbox" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/dropbox" ?>"><?= __("Dropbox Chooser") ?></a></li>
                    <li class="<?= $page == "onedrive" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/onedrive" ?>"><?= __("OneDrive File Picker") ?></a></li>
                    <li class="<?= $page == "paypal" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/paypal" ?>"><?= __("PayPal Integration") ?></a></li>
                    <li class="<?= $page == "stripe" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/stripe" ?>"><?= __("Stripe Integration") ?></a></li>
                    <li class="<?= $page == "facebook" ? "active" : "" ?>"><a href="<?= Config::get('constants.APPURL')."/settings/facebook" ?>"><?= __("Facebook Login") ?></a></li>
                </ul>
            </div>
        </div>