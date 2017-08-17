
	// 슬라이딩 이미지 추가
	function goLayoutSliderBannerModifyImageAddEvent() {
		
		// 기본설정
		var objTarget =$('#tabSlideBanner');

		// 그리기
		var strHtml = '<tr class="sliderImageForm" idx="">' + 
							'<th><span id="trCnt" class="numberOrange_1 mr5"></span> 적용이미지<a href="javascript:goLayoutSliderBannerModifyImageDeleteEvent()" id="btnDelete">[삭제]</a> </th>' + 
							'<td>' + 
								'<dl class="tdListUl">' + 
									'<dd><span class="spanTitle">이미지</span><input type="file" name="si_img_" id="si_img" class="nbox"  style="height:22px;"/></dd>' + 
									'<dd><span class="spanTitle">링크</span><input type="text" name="si_link[]" id="si_link" class="nbox" style="width:400px;" value=""/></dd>' + 
									'<dd><span class="spanTitle">카피문구</span><input type="text" name="si_text[]" id="si_text" class="nbox" style="width:400px;" value=""/></dd>' + 
								'</dl>' + 
								'<input type="hidden" name="si_no_bak[]" value="-1"/>' + 
							'</td>' + 
						'</tr>';


		// 추가
		objTarget.append(strHtml);

		// 제정의
		goLayoutSliderBannerModifyImageIdxDraw();
	}

	// 슬라이딩 이미지 삭제
	function goLayoutSliderBannerModifyImageDeleteEvent(intIdx) {
		
		// 기본설정
		var objTarget =$('#tabSlideBanner');
		
		// 삭제
		objTarget.find('.sliderImageForm[idx=' + intIdx + ']').remove();

		// 제정의
		goLayoutSliderBannerModifyImageIdxDraw();
	}

	// 스라이딩 이미지 추가/삭제 이후, idx 정의
	function goLayoutSliderBannerModifyImageIdxDraw() {

		// 기본설정
		var objTarget =$('#tabSlideBanner');

		// 제정의
		objTarget.find(".sliderImageForm").each(function(i) {

			// 기본 설정
			var intIdx = i + 1;
			
			$(this).attr("idx", intIdx);
			$(this).find("#trCnt").attr('class', 'numberOrange_' + intIdx + ' mr5');
			$(this).find("#btnDelete").attr('href', 'javascript:goLayoutSliderBannerModifyImageDeleteEvent(\'' + intIdx + '\')');
			$(this).find("#si_img").attr('name' , 'si_img_' + i);

		});

		// 슬라이딩 이미지 수 설정
		var intImageCnt = objTarget.find(".sliderImageForm").length;
		objTarget.find("#sb_images_cnt").val(intImageCnt);
	}

	// 리스트 페이지로 이동
	function goLayoutSliderBannerModifyListMoveEvent() {

		var data =new Object();
		data['mode'] = 'sliderBannerList';
		data['sb_no'] = '';
		C_getAddLocationUrl(data);

	}

	// 수정
	function goLayoutSliderBannerModifyActEvent() {
		
		// 기본 설정
		var strLang		= $("input[name=lang]").val();

		// 체크
		if(!strLang) {
			alert("선택된 언어가 없습니다. 관리자에게 문의하세요.");
			return;
		}

		// 전달
		$('#formData').ajaxForm({
			beforeSubmit :	function() {
			},
			success		 :  function(data) {
					data =  $.parseJSON(data);
					if(data['__STATE__'] == "SUCCESS") {
						alert("수정되었습니다.");
						location.reload();
					} else {
						alert(data);
					}
			   }
		}); 

		$('#formData').submit();

	}