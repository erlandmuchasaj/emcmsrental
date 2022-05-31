<?php // echo $this->Html->css('clock', null, array('block'=>'cssMiddle'));?>
<?php // debug($getActiveUsers); ?>
<?php //echo $this->Html->breadcrumbs(); ?>

<div class="row">
    <div class="col-sm-4 col-xs-12">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3 data-name="users">--</h3>
          <p><?php echo __('Total Users'); ?></p>
        </div>
        <div class="icon">
        	<i class="fa fa-users" aria-hidden="true"></i>
        </div>
        <?php
        	echo $this->Html->link(__('More info ').$this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right', 'aria-hidden'=>'true')),array('controller' => 'users', 'action' => 'index'), array('escape' => false, 'class' => 'small-box-footer'));
        ?>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-sm-4 col-xs-12">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3 data-name="reservations">--</h3>
          <p><?php echo __('Total Reservations'); ?></p>
        </div>
        <div class="icon">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
        </div>
        <?php
        	echo $this->Html->link(__('More info ').$this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right', 'aria-hidden'=>'true')),array('controller' => 'reservations', 'action' => 'index'), array('escape' => false, 'class' => 'small-box-footer'));
		?>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-sm-4 col-xs-12">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3 data-name="properties">--</h3>
          <p><?php echo __('Total Rooms'); ?></p>
        </div>
        <div class="icon">
          <i class="fa fa-home" aria-hidden="true"></i>
        </div>
        <?php
        	echo $this->Html->link(__('More info ').$this->Html->tag('i', '', array('class' => 'fa fa-arrow-circle-right', 'aria-hidden'=>'true')),array('controller' => 'properties', 'action' => 'index'), array('escape' => false, 'class' => 'small-box-footer'));
        ?>
      </div>
    </div>
</div>

<!-- Info boxes -->
<div class="row">
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="fa fa-gear" aria-hidden="true"></i></span>
			<div class="info-box-content">
				<span class="info-box-text"><?php echo __('Platform'); ?></span>
				<span class="info-box-number"><small><?php echo getUserPlatform();?></small></span>
				<span class="progress-description">
					<?php echo getUserBrowser();?>
				</span>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-red"><i class="fa fa-tasks" aria-hidden="true"></i></span>
			<div class="info-box-content">
				<span class="info-box-text"><?php echo __('PHP version'); ?></span>
				<span class="info-box-number"><?php echo checkPhpVersion(); ?></span>
				<span class="progress-description">
					<?php echo __('Memory limit: %s', ini_get('memory_limit'));?>
				</span>

			</div>
		</div>
	</div>

	<!-- fix for small devices only -->
	<div class="clearfix visible-sm-block"></div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-green"><i class="fa fa-server" aria-hidden="true"></i></span>
			<div class="info-box-content">
				<span class="info-box-text"><?php echo __('IP - Server'); ?></span>
				<span class="info-box-number"><?php echo getRemoteAddr();?></span>
				<span class="progress-description">
					<?php echo getServerName();?>
				</span>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-yellow"><i class="fa fa-users" aria-hidden="true"></i></span>
			<div class="info-box-content">
				<span class="info-box-text"><?php echo __('Active Users'); ?></span>
				<span class="info-box-number"><?php echo h($countActiveUsers); ?></span>
			</div>
		</div>
	</div>
</div>

<!-- Main row -->
<div class="row">
	<div class="col-md-7">
		<!-- TABLE: LATEST RESERVATIONS -->
		<div class="box box-info">
			<div class="box-header with-border">
				<?php echo $this->Html->tag('h3',__('Reservations'),array('class' => 'box-title')) ?>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" aria-hidden="true"></i></button>
				</div>
			</div>
			<?php 
				$reservation_statuses = [
					'payment_pending' 			=> 'label-warning',
					'pending_approval' 			=> 'label-warning',	
					'declined' 					=> 'label-danger',			
					'accepted'  				=> 'label-success',			 
					'expired' 					=> 'label-danger',				
					'payment_completed'			=> 'label-info', 
					'payment_error'				=> 'label-danger', 
					'canceled_by_host' 			=> 'label-danger', 
					'canceled_by_traveler' 		=> 'label-danger',
					'awaiting_checkin' 			=> 'label-default',
					'checkin'  					=> 'label-info',				
					'awaiting_traveler_review'  => 'label-warning',
					'awaiting_host_review' 		=> 'label-warning',
					'completed' 				=> 'label-success'
				];
			?>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="table-responsive">
					<table class="table no-margin">
						<thead>
							<tr>
								<th><?php echo __('Booking Nr.'); ?></th>
								<th><?php echo __('Details'); ?></th>	
								<th><?php echo __('Price'); ?></th>						
								<th><?php echo __('Status'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($reservations as $reservation): ?>
								<?php $status = EMCMS_strtolower($reservation['Reservation']['reservation_status']); ?>
								<tr>
									<td><?php echo h($reservation['Reservation']['confirmation_code']); ?>&nbsp;</td>
									<td>
									<?php 
										echo $this->Time->format('F jS, Y', $reservation['Reservation']['checkin']);
										echo " - ";
										echo $this->Time->format('F jS, Y', $reservation['Reservation']['checkout']);
										echo "<br>";
										echo $this->Html->link($reservation['Property']['address'], array('admin'=>false,'controller' => 'properties', 'action' => 'view', $reservation['Property']['id']),array('escape' => false,'target'=>'_blank'));
									?>
									</td>

									<td>
									<?php 
										echo $this->Number->currency($reservation['Reservation']['total_price'], $reservation['Reservation']['currency']);
									?>
									</td>

									<td>
										<span class="<?php echo $this->Html->getReservationLabel($status); ?>">
										<?php echo Inflector::humanize($status);?>
										</span>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="box-footer clearfix">
				<?php 
					echo $this->Html->link(__('View All Reservations'), array('controller'=>'reservations','action' => 'index'), array('escape' => false, 'class'=>"btn btn-sm btn-info btn-flat pull-right")); 
				?>
			</div>
			<!-- /.box-footer -->
		</div>
	</div>
	<div class="col-md-5">
		<!-- Properties LIST -->
		<div class="box box-primary">
			<div class="box-header with-border">
				<?php echo $this->Html->tag('h3',__('Recently Added Properties'),array('class' => 'box-title')) ?>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" aria-hidden="true"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<ul class="products-list product-list-in-box">
					<?php foreach ($properties as $property): ?>
					<li class="item">
						<a class="product-img" href="<?php echo $this->Html->url(array("controller" => "properties","action" => "view", $property['Property']['id']), true); ?>">
							<?php
								$directorySmURL = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'Property'.DS.$property['Property']['id'].DS.'PropertyPicture'.DS.'small'.DS;
								$directorySmPATH = 'uploads/Property/'.$property['Property']['id'].'/PropertyPicture/small/';
								$base64 = 'default.gif';

								if (file_exists($directorySmURL.$property['Property']['thumbnail']) && is_file($directorySmURL .$property['Property']['thumbnail'])) { 	
									$base64 = $directorySmPATH . $property['Property']['thumbnail'];
								}
							?>
							<?php echo $this->Html->image($base64, array('alt' => 'Product image', 'class'=>'product')); ?>
						</a>
						<div class="product-info">
							<a class="product-title"  href="<?php echo $this->Html->url(array("controller" => "users","action" => "view", $property['User']['id']), true); ?>" >
								<?php
									echo h($property['User']['name'].' '.$property['User']['surname']);
								?>
								<span class="label label-info pull-right">
									<?php echo Inflector::humanize($property['Property']['contract_type']); ?>
								</span>
							</a>
							<span class="product-description">
								<?php
									if (isset($property['PropertyTranslation']['title'])) {	
										echo getDescriptionHtml($property['PropertyTranslation']['title']);	
									}
								?>
							</span>
						</div>
					</li>
					<?php endforeach; ?>
					<!-- /.item -->
				</ul>
			</div>
			<!-- /.box-body -->
			<div class="box-footer text-center">
				<?php 
					echo $this->Html->link(__('View All Properties'), array('controller'=>'properties','action' => 'index'), array('escape' => false, 'class'=>"btn btn-sm btn-info btn-flat pull-right")); 
				?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<!-- Left col -->
	<div class="col-md-4">	
		<!-- USERS Online -->
		<div class="box box-danger">
			<div class="box-header with-border">
				<?php echo $this->Html->tag('h3', __('Online Members'), array('class'=>'box-title'))?>
				<div class="box-tools pull-right">
					<span class="label label-danger"><?php echo __('%s Online Members',h($countActiveUsers)) ?></span>
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus" aria-hidden="true"></i>
					</button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body no-padding">
				<ul class="users-list clearfix">
					<?php 
						if (!empty($getActiveUsers)) {
							$directorySM = Configure::read('App.www_root'). 'img' .DS. 'uploads' .DS. 'User'. DS.'small'.DS;
							$avatar = 'avatars/avatar.jpg';
							foreach ($getActiveUsers as $key => $user) {
								echo '<li>';
									if (file_exists($directorySM.$user['image_path']) && is_file($directorySM.$user['image_path'])) { 
										$avatar = 'uploads/User/small/'. $user['image_path'];
									}
									echo $this->Html->image($avatar, array('alt' => 'user image', 'class'=>'avatar', 'fullBase'=>true));
									echo $this->Html->link(h($user['name']), array('admin'=>true,'controller' => 'users','action' => 'view', $user['id']), array('class'=>'users-list-name')); 
									echo $this->Html->tag('span', __('Today'), array('class'=>'users-list-date'));
								echo '</li>';
							}
						}
					?>
				</ul>
			</div>
			<!-- /.box-body -->
			<div class="box-footer text-center">
				<?php 
					// echo $this->Html->link(__('View All users'), array('controller' => 'users','action' => 'index'), array('class'=>'uppercase'));
				?>
				<?php 
					echo $this->Html->link(__('View All users'), array('controller'=>'users','action' => 'index'), array('escape' => false, 'class'=>"btn btn-sm btn-info btn-flat pull-right")); 
				?>
			</div>
		</div>
		<!-- /.box -->
	</div>
	<!-- /.col -->

	<div class="col-md-8">
		<!-- USERS table -->
		<div class="box box-warning">
			<div class="box-header">
				<h3 class="box-title"><?php echo __('All users'); ?></h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<table id="users_table" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th><?php echo __('Name'); ?></th>
							<th><?php echo __('Email'); ?></th>
							<th><?php echo __('Role'); ?></th>
							<th><?php echo __('Created'); ?></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					<tfoot>
					    <tr>
							<th><?php echo __('Name'); ?></th>
							<th><?php echo __('Email'); ?></th>
							<th><?php echo __('Role'); ?></th>
							<th><?php echo __('Created'); ?></th>
					    </tr>
					</tfoot>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
	</div>
	<!-- /.col -->
</div>

<?php if (false): ?>
<!-- Info boxes -->
<div class="row">
	<div class="col-md-3">
		<!-- Info Boxes Style 2 -->
		<div class="info-box bg-yellow">
			<span class="info-box-icon"><i class="fa fa-tags" aria-hidden="true"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Inventory</span>
				<span class="info-box-number">5,200</span>

				<div class="progress">
					<div class="progress-bar" style="width: 50%"></div>
				</div>
				<span class="progress-description">
					50% Increase in 30 Days
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
	</div>
	<div class="col-md-3">
		<!-- /.info-box -->
		<div class="info-box bg-green">
			<span class="info-box-icon"><i class="fa fa-heart" aria-hidden="true"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">Mentions</span>
				<span class="info-box-number">92,050</span>

				<div class="progress">
					<div class="progress-bar" style="width: 20%"></div>
				</div>
				<span class="progress-description">
					20% Increase in 30 Days
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
	</div>
	<div class="col-md-3">
		<!-- /.info-box -->
		<div class="info-box bg-red">
			<span class="info-box-icon"><i class="fa fa-download" aria-hidden="true"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">Downloads</span>
				<span class="info-box-number">114,381</span>

				<div class="progress">
					<div class="progress-bar" style="width: 70%"></div>
				</div>
				<span class="progress-description">
					70% Increase in 30 Days
				</span>
			</div>
		<!-- /.info-box-content -->
		</div>
	</div>
	<div class="col-md-3">
		<!-- /.info-box -->
		<div class="info-box bg-aqua">
			<span class="info-box-icon"><i class="fa fa-comments-o" aria-hidden="true"></i></span>

			<div class="info-box-content">
				<span class="info-box-text">Direct Messages</span>
				<span class="info-box-number">163,921</span>

				<div class="progress">
					<div class="progress-bar" style="width: 40%"></div>
				</div>
				<span class="progress-description">
					40% Increase in 30 Days
				</span>
			</div>
			<!-- /.info-box-content -->
		</div>
	</div>
</div>
<?php endif ?>
	
<?php
	echo $this->Html->script("admin/jquery.dataTables.min", array("block"=>"scriptBottomMiddle"));
	$this->Html->scriptBlock("
		(function($){
			$(document).ready(function() {
				'use strict';


				$.ajax({
					url: fullBaseUrl+'/users/getStatistics',
					type: 'GET',
					dataType: 'json',
					success: function(data, textStatus, xhr) {
						//called when successful
						if (textStatus =='success') {
							var response = $.parseJSON(JSON.stringify(data));
							$('[data-name=\"properties\"]').html(response.properties);
							$('[data-name=\"users\"]').html(response.users);
							$('[data-name=\"reservations\"]').html(response.reservations);
							
						}
					}
				});

				var userDataTable = $('#users_table').DataTable({
					'bProcessing': true,
					'bServerSide': true,
					'sAjaxSource': fullBaseUrl+'/admin/users/ajaxindex',
					'aoColumns': [
						{mData:'User.name'},
						{mData:'User.email'},
						{mData:'User.role'},
						{mData:'User.created'}
					],
					'fnCreatedRow': function(nRow, aData, iDataIndex){
						// console.log(nRow);
						// console.log(aData);
						// console.log(iDataIndex);
					}
				});

				$('#users_table tbody').on('click', 'tr', function () {
					var data = userDataTable.row(this).data();
					// console.log(data.User.id);
				});
			});
		})(jQuery);
	", array('block' => 'scriptBottom'));
?>
