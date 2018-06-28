        <nav>
            <div class="nav-logo-wrapper">
                <a href="{{ url('/post') }}">
                    <img src="{{ Config::get('constants.logomark') ? Config::get('constants.logomark') : url('/img/logomark.png') }}" 
                         alt="{{ Config::get('constants.site_name') }}">
                </a>
            </div>

            <div class="nav-menu">
                <div>
                    <ul>
                        <li class="<?= $Nav->activeMenu == "post" ? "active" : "" ?>">
                            <a href="{{ url('/post') }}">
                                <span class="sli sli-plus menu-icon"></span>
                                <span class="label"><?= __('Add Post') ?></span>

                              <span class="tooltip tippy" 
                                    data-position="right"
                                    data-delay="100" 
                                    data-arrow="true"
                                    data-distance="-1"
                                    title="<?= __('Add Post') ?>"></span>
                            </a>
                        </li>

                        <li class="<?= $Nav->activeMenu == "calendar" ? "active" : "" ?>">
                            <a href="{{ url('/calendar') }}">
                                <span class="sli sli-calendar menu-icon"></span>
                                <span class="label"><?= __('Calendar') ?></span>

                                <span class="tooltip tippy" 
                                      data-position="right"
                                      data-delay="100" 
                                      data-arrow="true"
                                      data-distance="-1"
                                      title="<?= __('Calendar') ?>"></span>
                            </a>
                        </li>

                        <li class="<?= $Nav->activeMenu == "captions" ? "active" : "" ?>">
                            <a href="{{ url('/captions') }}">
                                <span class="sli sli-grid menu-icon"></span>
                                <span class="label"><?= __('Captions') ?></span>

                                <span class="tooltip tippy" 
                                      data-position="right"
                                      data-delay="100" 
                                      data-arrow="true"
                                      data-distance="-1"
                                      title="<?= __('Captions') ?>"></span>
                            </a>
                        </li>

                        <li class="<?= $Nav->activeMenu == "accounts" ? "active" : "" ?>">
                            <a href="{{ url('/accounts') }}">
                                <span class="sli sli-social-instagram menu-icon"></span>
                                <span class="label"><?= __('Accounts') ?></span>

                                <span class="tooltip tippy" 
                                      data-position="right"
                                      data-delay="100" 
                                      data-arrow="true"
                                      data-distance="-1"
                                      title="<?= __('Accounts') ?>"></span>
                            </a>
                        </li>

                        <li class="<?= $Nav->activeMenu == "auto-follow" ? "active" : "" ?>">
                            <a href="{{ action('AutoFollowController@index') }}">
                                <span class="sli sli-social-instagram menu-icon"></span>
                                <span class="label"><?= __('auto follow') ?></span>

                                <span class="tooltip tippy" 
                                      data-position="right"
                                      data-delay="100" 
                                      data-arrow="true"
                                      data-distance="-1"
                                      title="<?= __('auto follow') ?>"></span>
                            </a>
                        </li>

                        <li class="<?= $Nav->activeMenu == "statistics" ? "active" : "" ?>">
                            <a href="{{ url('/statistics') }}">
                                <span class="sli sli-chart menu-icon"></span>
                                <span class="label"><?= __('Statistics') ?></span>

                                <span class="tooltip tippy" 
                                      data-position="right"
                                      data-delay="100" 
                                      data-arrow="true"
                                      data-distance="-1"
                                      title="<?= __('Statistics') ?>"></span>
                            </a>
                        </li>

                        
                    </ul>

                    <ul>
                        
                    </ul>

                    <?php 
                    //if ($AuthUser->isAdmin()): 
                    ?>
                    @if($AuthUser->isAdmin($AuthUser) == true)
                        <ul>
                            <li class="<?= $Nav->activeMenu == "plugins" ? "active" : "" ?>">
                                <a href="{{ url('/plugins') }}">
                                    <span class="sli sli-puzzle menu-icon"></span>
                                    <span class="label"><?= __('Modules') ?></span>

                                    <span class="tooltip tippy" 
                                          data-position="right"
                                          data-delay="100" 
                                          data-arrow="true"
                                          data-distance="-1"
                                          title="<?= __('Modules') ?>"></span>
                                </a>
                            </li>

                            <li class="<?= $Nav->activeMenu == "packages" ? "active" : "" ?>">
                                <a href="{{ url('/packages') }}">
                                    <span class="sli sli-present menu-icon"></span>
                                    <span class="label"><?= __('Packages') ?></span>

                                    <span class="tooltip tippy" 
                                          data-position="right"
                                          data-delay="100" 
                                          data-arrow="true"
                                          data-distance="-1"
                                          title="<?= __('Packages') ?>"></span>
                                </a>
                            </li>

                            <li class="<?= $Nav->activeMenu == "users" ? "active" : "" ?>">
                                <a href="{{ url('/users') }}">
                                    <span class="sli sli-people menu-icon"></span>
                                    <span class="label"><?= __('Users') ?></span>

                                    <span class="tooltip tippy" 
                                          data-position="right"
                                          data-delay="100" 
                                          data-arrow="true"
                                          data-distance="-1"
                                          title="<?= __('Users') ?>"></span>
                                </a>
                            </li>

                            <?php //\Event::trigger("navigation.add_admin_menu", $Nav, $AuthUser) 
                            ?>

                            <li class="<?= $Nav->activeMenu == "settings" ? "active" : "" ?>">
                                <a href="{{ url('/settings') }}">
                                    <span class="sli sli-settings menu-icon"></span>
                                    <span class="label"><?= __('Settings') ?></span>

                                    <span class="tippy" 
                                          data-position="right"
                                          data-delay="100" 
                                          data-arrow="true"
                                          data-distance="-1"
                                          title="<?= __('Settings') ?>"></span>
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </nav>