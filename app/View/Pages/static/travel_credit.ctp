<div class="media-photo media-photo-block referrals-hero" style="margin-top: 85px;">
  <div class="media-cover media-cover-dark referrals-bg-img"></div>

  <div class="row row-table row-full-height">
    <div class="col-sm-12 col-middle text-center text-contrast">
      <h1 class="referrals-heading text-special row-space-3 hidden-sm hidden-xs">
        <?php echo __('Earn free %s coupons!<br>Get up to $100 for every friend you invite.', Configure::read('Website.name')); ?>
      </h1>
      <h3 class="referrals-heading text-special row-space-3 visible-sm visible-xs">
        <?php echo __('Earn up to $100 for everyone you invite.'); ?>
      </h3>
      <div class="em-container hidden-sm hidden-xs">
        <?php
          echo $this->Html->link(__('Log in to invite friends'),
            array('controller' => 'users', 'action' => 'login', 'admin'=>false, 'user'=>false),
            array('escape' => false, 'class'=>'btn btn-primary btn-large book-now-btn')
          );
        ?>
        <p class="text-white h3">
          <?php echo __("Don't have an account?"); ?>
          <?php
            echo $this->Html->link(__('Sign up.'),
              array('controller' => 'users', 'action' => 'signup', 'admin'=>false, 'user'=>false),
              array('escape' => false, 'class'=>'text-red')
            );
          ?>
        </p>
      </div>
    </div>
  </div>
</div>

<?php if (!empty($page['Page']['content'])) {
  // echo getDescriptionHtml($page['Page']['content']);
} ?>


<section class="em-container row-space-8 row-space-top-4">
  <div class="row">
    <div class="col-sm-12 text-center">
      <div class="text-justified visible-sm visible-xs">
        <br>
        <?php
          echo $this->Html->link(__('Log in to invite friends'),
            array('controller' => 'users', 'action' => 'login', 'admin'=>false, 'user'=>false),
            array('escape' => false, 'class'=>'btn btn-primary btn-large book-now-btn')
          );
        ?>
        <p class="text-lead h3">
         <?php echo __("Don't have an account?"); ?><?php
            echo $this->Html->link(__('Sign up.'),
              array('controller' => 'users', 'action' => 'signup', 'admin'=>false, 'user'=>false),
              array('escape' => false, 'class'=>'text-red')
            );
          ?>
        </p>
      </div>

      <?php echo $this->Html->tag('span',__('Invite your friends to %1$s via email, or share your referral code on Facebook or Twitter. <br>When you send a friend $20 in %1$s credit, you\'ll get $20 when they travel and $80 when they host. <br>Your available travel credit automatically appears on the checkout page in the form of a coupon.', Configure::read('Website.name')),array('class' => 'text-lead'));
      ?>
    </div>
  </div>
</section>
