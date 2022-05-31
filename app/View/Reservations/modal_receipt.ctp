<?php 
	if (isset($reservation) && !empty($reservation)) {
		echo $this->element('invoice', [
			'reservation'=> $reservation,
		]);
	}
?>
<script>
	function print_confirmation() {
	    var myElement = document.getElementById("print_receipt").innerHTML;
	    var myWindow;
	    myWindow=window.open('','_blank','width=800,height=500');
	    myWindow.document.write(myElement);
	    myWindow.print();
	}
</script>
