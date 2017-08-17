
	$(function() {

		// 회원 노출 설정 이벤트
		$('[name=priceShowMember]').click(function() {
			
			var strChecked = $(this).attr('checked');
			var isDisabled = false;
			if(strChecked != 'checked') isDisabled = true;

			$('[name^=priceShowGroup]').attr('disabled', isDisabled);
		});

	});