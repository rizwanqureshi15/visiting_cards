
<html>
	<head>
		<script type="text/javascript">
			function submitForm()
			{
				var postForm = document.forms.postForm;
				postForm.submit();
			}
		</script>
	</head>
	<body onload="submitForm()">
		<div class="container">
			<div class="row">
				<form name="postForm" method="POST" action="https://test.payu.in/_payment">
					<div class="col-md-12">
						<input name="key" type="hidden" value="{{ $details['key'] }}">
					</div>
					<div class="col-md-12">
						<input name="txnid" type="hidden" value="{{ $details['txnid'] }}">
					</div>
					<div class="col-md-12">
						<input name="amount" type="hidden" value="{{ $details['amount'] }}">
					</div>
					<div class="col-md-12">
						<input name="firstname" type="hidden" value="{{ $details['firstname'] }}">
					</div>
					<div class="col-md-12">
						<input name="email" type="hidden" value="{{ $details['email'] }}">
					</div>
					<div class="col-md-12">
						<input name="phone" type="hidden" value="{{ $details['phone'] }}">
					</div>
					<div class="col-md-12">
						<input name="productinfo" type="hidden" value="{{ $details['productinfo'] }}">
					</div>
					<div class="col-md-12">
						<input name="surl" type="hidden" value="{{ $details['surl'] }}">
					</div>
					<div class="col-md-12">
						<input name="furl" type="hidden" value="{{ $details['furl'] }}">
					</div>
					<div class="col-md-12">
						<input name="service_provider" type="hidden" value="{{ $details['service_provider'] }}">
					</div>
					<div class="col-md-12">
						<input name="hash" type="hidden" value="{{ $details['hash'] }}">
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
