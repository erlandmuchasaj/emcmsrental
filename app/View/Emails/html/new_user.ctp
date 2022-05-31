<center>
	<table style="margin: 0 auto" cellpadding="0" cellspacing="0" class="force-width-80">
		<tr>
			<br><br>
			<td class="mobile-resize" style="color:#172838; font-size: 20px; font-weight: 600; text-align: left; vertical-align: top;">
				<?php echo $this->Html->tag('span', __('Activate Acount'), array('class'=>'')); ?>
			</td>
		</tr>
	</table>
	<table style="margin: 0 auto;" cellspacing="0" cellpadding="0" class="force-width-80">
		<tr>
			<td style="text-align:left; color: #6f6f6f;">
				<br>
				<?php
					if (isset($content) && !empty($content)) {
						$content = explode("\n", $content);
						foreach ($content as $line):
							echo '<p> ' . $line . "</p>\n";
						endforeach;
					}
				?>
				<br>
			</td>
		</tr>
	</table>
</center>

<?php if (isset($user_activation_link) && !empty($user_activation_link)) { ?>
<table style="margin:0 auto;" cellspacing="0" cellpadding="10" width="100%">
	<tr>
		<td style="text-align:center; margin:0 auto;">
			<br>
			<div>
				<!--[if mso]>
				<v:rect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://" style="height:45px;v-text-anchor:middle;width:240px;" stroke="f" fillcolor="#f5774e">
				<w:anchorlock/>
				<center>
				<![endif]-->
				<?php
					echo $this->Html->link(__('Active Account'), $user_activation_link, array('escape' => false, 'class'=>'btn', 'style'=>"background-color:#172838;color:#ffffff;display:inline-block;font-family:'Source Sans Pro', Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;width:240px;-webkit-text-size-adjust:none; -webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;"));
				?>
				<!--[if mso]>
				</center>
				</v:rect>
				<![endif]-->
			</div>
			<br>
		</td>
	</tr>
</table>
<?php } ?>