<nav id="offcanvas_navigation" class="nav nav-side-menu offcanvas_navigation">
    <div class="brand"><?php echo Configure::read('Website.name');?></div>
    <ul class="menu-content">
        <li>
            <?php
            echo $this->Html->link(
                    $this->Html->tag('i','', ['class'=>'fa fa-home', 'aria-hidden'=>'true']).
                    __('Home'),
                    array('controller' => 'properties', 'action' => 'index'),
                    array('escape' => false, 'class'=>'')
                );
            ?>
        </li>

        <li>
            <?php
            echo $this->Html->link(
                    $this->Html->tag('i','', ['class'=>'fa fa-plus', 'aria-hidden'=>'true']).
                    __('List your space'),
                    array('controller' => 'properties', 'action' => 'add'),
                    array('escape' => false, 'class'=>'')
                );
            ?>
        </li>
        <?php if (!AuthComponent::user()) { ?>
        <!-- 
        <li data-toggle="collapse" data-target="#help_subpages_nav" class="collapsed">
            <a href="javascript:;">
                <i class="fa fa-life-ring"></i>
                Help<span class="sub-menu-arrow"></span>
            </a>
            <ul class="sub-menu collapse" id="help_subpages_nav">
                <li><a href="#0">Need help on this page?</a></li>
                <li><a href="#0">How to become a host?</a></li>
                <li><a href="#0">FAQ-s</a></li>
            </ul>
        </li>
        -->

        <li>
            <?php
            echo $this->Html->link(
                    $this->Html->tag('i','', ['class'=>'fa fa-sign-in', 'aria-hidden'=>'true']).
                    __('Sign in'),
                    array('controller' => 'users', 'action' => 'login', 'admin'=>false, 'user'=>false),
                    array('escape' => false, 'class'=>'')
                );
            ?>
        </li>
        <li>
            <?php
            echo $this->Html->link(
                    $this->Html->tag('i','', ['class'=>'fa fa-user-plus', 'aria-hidden'=>'true']).
                    __('Sign up'),
                    array('controller' => 'users', 'action' => 'signup', 'admin'=>false, 'user'=>false),
                    array('escape' => false, 'class'=>'')
                );
            ?>
        </li>
    	<?php } ?>

        <?php if (AuthComponent::user()): ?>
        <?php $messages = $this->requestAction('/messages/getCount'); ?>
        <li>
            <a href="<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'index', 'all'), true); ?>">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <?php echo __('Messages');?>
                <span class="label em-message-count pull-right"><?php echo ($messages > 0) ? $messages : ''; ?></span>
            </a>
        </li>
        <li data-toggle="collapse" data-target="#user_profile_nav" class="collapsed">
            <a href="javascript:;">
                <i class="fa fa-user" aria-hidden="true"></i>
                <?php echo h(AuthComponent::user('name'));?><span class="sub-menu-arrow"></span>
            </a>
            <ul class="sub-menu collapse" id="user_profile_nav">
                <li>
                <?php
                    echo $this->Html->link(__('Dashboard'), ['controller' => 'users', 'action' => 'dashboard'],array('escape' => false, 'class'=>''))
                ?>
                </li>
                <li>
                <?php
                    echo $this->Html->link(__('Your Listings'), ['controller' => 'properties', 'action' => 'listings'],array('escape' => false, 'class'=>''))
                ?>
                </li>
                <li>
                <?php
                    echo $this->Html->link(__('Your Reservations'), ['controller' => 'reservations', 'action' => 'my_reservations'],array('escape' => false, 'class'=>''))
                ?>
                </li>
                <li>
                <?php
                    echo $this->Html->link(__('Your Trips'), ['controller' => 'reservations', 'action' => 'my_trips'],array('escape' => false, 'class'=>''))
                ?>
                </li>
                <li>
                <?php
                    echo $this->Html->link(__('Wish List'), ['controller' => 'wishlists', 'action' => 'index'],array('escape' => false, 'class'=>''))
                ?>
                </li>
                <li>
                <?php
                    echo $this->Html->link(__('Reviews'), ['controller' => 'reviews', 'action' => 'index'],array('escape' => false, 'class'=>''))
                ?>
                </li>
                <li>
                <?php
                    echo $this->Html->link(__('Edit Profile'),array('controller' => 'users', 'action' => 'edit', AuthComponent::user('id')),array('escape' => false, 'class'=>''))
                ?>
                </li>
                <li>
                <?php 
                    echo $this->Html->link(__('Change password'),array('controller' => 'users', 'action' => 'changepassword', AuthComponent::user('id')),array('escape' => false, 'class'=>'')); 
                ?>
                </li>
                
                <?php if (AuthComponent::user('role') === 'admin'): ?>
                <li>
                <?php
                     echo $this->Html->link(__('Admin Panel'),['admin'=>true,'controller' => 'users', 'action' => 'dashboard'],array('escape' => false, 'class'=>''))
                ?>
                </li>
                <?php endif ?>
                <li>
                <?php
                    echo $this->Html->link(__('Sign Out'),array('controller' => 'users', 'action' => 'logout', 'admin'=>false),array('escape' => false, 'class'=>''));
                ?>
                </li>
            </ul>
        </li>
        <?php endif ?>

        <li class="dropdown">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-file-text" aria-hidden="true"></i><?php echo __('Pages') ?><span class="sub-menu-arrow"></span>
            </a>
            <?php echo $this->element('menu', array('ul' => array('class' => 'dropdown-menu pull-right'))); ?>
        </li>

        <?php if (isset($global_languages) && count($global_languages) > 1) { ?>
        <li class="language_select">
        	<select id="language_drop" class="dropdown-select language-drop js-language-switch">
    		<?php
                $passedArgs = $this->request->params['named']+$this->request->params['pass'];
    			foreach ($global_languages as $language) {
                    $retVal = ($language_code == $language['Language']['language_code']) ? 'selected="selected"' : '' ;

                    $option = [
                        'language' => $language['Language']['language_code'], 
                        '?' => $this->request->query
                    ] + $passedArgs;

                    $url = $this->Html->url($option,  true);

    				echo "<option value='".$language['Language']['language_code']."' ".$retVal."  data-url='".$url."' >".h($language['Language']['name']). "</option>";
    			}
    		?>
        	</select>
        </li>
        <?php } ?>

        <?php if (isset($global_currencies) && count($global_currencies) > 1) { ?>
        <li class="currency_select">
        	<select id="currency_drop" class="dropdown-select currency-drop js-currency-switch">
    		<?php
    			foreach ($global_currencies as $currency) {
    				$retVal = ($localeCurrency === $currency['Currency']['code']) ? 'selected' : '';
    				echo "<option value='".$currency['Currency']['code']."' ".$retVal.">".h($currency['Currency']['name']). "</option>";
    			}
    		?>
        	</select>
        </li>
        <?php } ?>
    </ul>
</nav>
<div class="ssm-overlay ssm-toggle-nav"></div>

<svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="0" class="blurme-svg">
  <filter id="myblurfilter" width="110%" height="100%">
    <feGaussianBlur stdDeviation="3" result="blur" />
  </filter>
</svg>
<!-- <div class="swipe-area noselect"></div> -->