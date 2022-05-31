<?php
    /**
     * Blog pagination view element file.
     *
     * this is a custom pagination element for the blog plugin.  you can
     * customize the entire blog pagination look and feel by modyfying this file.
     *
     * Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     *
     * Licensed under The MIT License
     * Redistributions of files must retain the above copyright notice.
     *
     * @filesource
     * @copyright     Copyright (c) 2009 Carl Sutton ( dogmatic69 )
     * @link          http://infinitas-cms.org
     * @package       blog
     * @subpackage    blog.views.elements.pagination.navigation
     * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
     */
?>
<!-- Start Results Bar -->
<!-- 
<?php // $this->Paginator->options(array('url'=>$this->passedArgs)); ?>
<ul class="pagination">
     <?php
          // if($this->Paginator->hasPrev()) :
          //      echo $this->Paginator->first('<< Start', array('tag' => 'li'), null, array('class' => 'disabled'));
          // endif;
          // echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'span'));
          // echo $this->Paginator->numbers(array(
          //      'separator' => '',
          //      'currentTag' => 'span',
          //      'currentClass' => 'active',
          //      'tag' => 'li'
          // ));
          // echo $this->Paginator->next(__('next'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'span'));

          // if ($this->Paginator->hasNext()):
          //      echo $this->Paginator->last('End >>', array('tag' => 'li'), null, array('class' => 'disabled'));
          // endif;
     ?>
</ul> -->


<?php $this->Paginator->options(array('url'=>Router::getParam('pass'))); ?>
<div class="paging">
     <div class="pagenumber">
          <ul class="pagination">
               <?php if($this->Paginator->hasPrev()): ?>
                    <li><?php echo $this->Paginator->first(__('<< Start'), null, null, array('class' => 'disabled')); ?></li>
                    <li><?php echo $this->Paginator->prev(__('Prev'), null, null, array('class' => 'disabled')); ?></li>
               <?php endif; ?>

               <?php 
               if (is_string($this->Paginator->numbers())):
                    echo $this->Paginator->numbers([
                         'separator' => '',
                         'before' => '',
                         'after' => '',
                         'tag' => 'li',
                         'currentTag' => 'span',
                         'currentClass' => 'active'
                    ]);
               endif; 
               ?>

               <?php if($this->Paginator->hasNext()): ?>
                    <li><?php echo $this->Paginator->next(__('Next'), null, null, array('class' => 'disabled')); ?></li>
                    <li><?php echo $this->Paginator->last(__('End >>'), null, null, array('class' => 'disabled')); ?></li>
               <?php endif; ?>
          </ul>
     </div>
</div>
<!-- End Results Bar -->