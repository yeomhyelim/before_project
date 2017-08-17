
	function goProductCateMenuSelectSkinReadyMoveEvent(strAppID) {

		var objTarget = $('#' + strAppID);

		objTarget.find('select').change(function() {
			
			// 기본설정
			var strName = $(this).attr('name');
			var strCate1 = objTarget.find('[name=selectCate1]').val();
			var strCate2 = objTarget.find('[name=selectCate2]').val();
			var strCate3 = objTarget.find('[name=selectCate3]').val();
			var strCate4 = objTarget.find('[name=selectCate4]').val();

			// 선택된 카테고리 다음부터 카테고리 정보 삭제
			if(strName == 'selectCate1') strCate2 = strCate3 = strCate4 = '';
			if(strName == 'selectCate2') strCate3 = strCate4 = '';
			if(strName == 'selectCate3') strCate4 = '';

			// 이동
			var data = new Object();
			data['lcate'] = strCate1;
			data['mcate'] = strCate2;
			data['scate'] = strCate3;
			data['fcate'] = strCate4;
			C_getAddLocationUrl(data);
		});
	}