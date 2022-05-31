<!-- Content -->
<div id="print_receipt" class="em-container make-top-spacing">
	<?php 
		if (isset($reservation) && !empty($reservation)) {
			echo $this->element('invoice', [
				'reservation'=> $reservation,
			]);
		}
	?>
</div>
<div class="seperator-xl"></div>
<div dir="ltr" style="text-align: left;" trbidi="on">
    <script>
        (function(d, s, id){
            var js, ref = d.getElementsByTagName(s)[0];
            if (!d.getElementById(id)){
                js = d.createElement(s); js.id = id; js.async = true;
                js.src = "https://www.paypal.com/webapps/merchantboarding/js/lib/lightbox/partner.js";
                ref.parentNode.insertBefore(js, ref);
            }
        }(document, "script", "paypal-js"));
    </script>
</div>
