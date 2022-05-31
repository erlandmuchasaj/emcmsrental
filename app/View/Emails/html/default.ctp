<center>
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