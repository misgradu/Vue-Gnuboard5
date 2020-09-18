<template>
  <div class="m-3" v-if="$store.state.isLogin == false && agree == false && c">
    <t-alert variant="danger" show :dismissible="false">
      <i class="fa fa-check-circle" aria-hidden="true"></i> 회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.
    </t-alert>
    <t-card class="border my-2" v-if="c.config.cf_social_login_use==1">
      <div v-for="(social, i) in c.config.cf_social_servicelist.split(',')" :key="i" class="inline-block px-1">
        <button :data-social="social" @click="social_popup(social)">
          <img :src="require('@/image/sns_'+social+'_s.png')" class="w-10 h-10">
        </button>
      </div>
    </t-card>
    <t-card class="border my-2">
      <template v-slot:header>
        <div class="flex"> 
          <label class="ml-2 flex items-center flex justify-between w-full">
            <div> 회원가입 약관 </div>
            <t-checkbox name="agree" ref="agree" value="1" />
          </label>
        </div>
      </template>
      <textarea class="dark:bg-gray-600 dark:text-gray-300 w-full h-20 p-3 text-sm" v-text="c.config.cf_stipulation"> </textarea>
    </t-card>
    <t-card class="border my-2">
      <template v-slot:header>
        <div class="flex"> 
          <label class="ml-2 flex items-center flex justify-between w-full">
            <div> 개인정보처리방침 안내 </div>
            <t-checkbox name="agree2" ref="agree2" value="1" />
          </label>
        </div>
      </template>
      <t-table class="my-1"
        :headers="['목적', '항목', '보유기간']"
        :data="[
          ['이용자 식별 및 본인여부 확인', '아이디, 이름, 비밀번호', '회원 탈퇴 시까지'],
          ['고객서비스 이용에 관한 통지,\r\n CS대응을 위한 이용자 식별', '연락처(이메일, 휴대전화번호)', '회원 탈퇴 시까지']
        ]"
      >
      </t-table>
      <textarea class="dark:bg-gray-600 dark:text-gray-300 w-full h-20 p-3 text-sm" v-text="c.config.cf_privacy"> </textarea>
    </t-card>
    <div class="border my-2 rounded mx-auto shadow bg-white p-4 dark:bg-gray-600 dark:text-gray-300 dark:border-gray-500">
      <label class="flex items-center flex justify-center w-full" @click="chkall">
        <div class="text-center flex justify-around mr-3"> 회원약관에 모두 동의 합니다</div>
        <t-checkbox name="chk_all" ref="chk_all" value="1" />
      </label>
    </div>
    <div class="w-full">
      <t-button class="w-1/2 text-center"> 취소 </t-button>
      <t-button class="w-1/2 text-center" variant="primary" @click="register"> 회원가입 </t-button>
    </div>
  </div>
  <div v-else-if="agree==true && r">
    <div v-append="r.POSTCODE"> </div>
    <form id="fregisterform" ref="fregisterform" name="fregisterform"  @submit.prevent="fregisterform_submit" class="m-3" method="post" enctype="multipart/form-data" autocomplete="off">
      <input type="hidden" name="w" :value="r.w">
      <input type="hidden" name="url" :value="r.urlencod">
      <input type="hidden" name="agree" :value="r.agree">
      <input type="hidden" name="agree2" :value="r.agree2">
      <input type="hidden" name="cert_type" :value="r.member.mb_certify">
      <input type="hidden" name="cert_no">
      <input type="hidden" v-if="r.member.mb_sex" name="mb_sex" :value="r.member_sex">
      <div v-if="r.member.mb_nick_date && r.member.mb_nick_date">
        <input type="hidden" name="mb_nick_default" :value="r.member.mb_nick">
        <input type="hidden" name="mb_nick" :value="r.member.mb_nick">
      </div>
      <t-card header="사이트 이용정보 입력" class="my-4">
        <t-input-group label="아이디" feedback="영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.">
          <t-input name="mb_id" id="reg_mb_id" :value="r.member.mb_id" type="text"/>
        </t-input-group>
        <div class="flex">
        <t-input-group label="비밀번호" class="w-1/2 pr-2">
          <t-input name="mb_password" required placeholder="비밀번호" type="password"/>
        </t-input-group>
        <t-input-group label="비밀번호 확인" class="w-1/2 pl-2">
          <t-input name="mb_password_re" placeholder="비밀번호 확인" type="password"/>
        </t-input-group>
        </div>
      </t-card>
      <t-card header="개인정보 입력" class="my-4">
        <t-input-group label="이름"> <t-input name="mb_name" size="10" :value="r.member.mb_name" :readonly="r.readonly" type="text"/> </t-input-group>
        <t-input-group v-if="r.req_nick" label="닉네임"> <t-input :value="r.member.mb_nick" id="reg_mb_nick" name="mb_nick" @change="reg_mb_nick_check" type="text"/> </t-input-group>
        <t-input-group label="E-mail"> 
          <input type="hidden" name="old_email" :value="r.member.mb_email">
          <t-input :value="r.member.mb_email" name="mb_email" id="reg_mb_email" size="70" maxlength="100" type="text"/> 
        </t-input-group>
        <!--이메일 인증 넣을 곳 v-if="r.config.cf_use_email_certify" -->
        <t-input-group v-if="r.config.cf_use_homepage" label="홈페이지">
          <t-input type="text" name="mb_homepage" :value="r.member.mb_homepage" size="70" maxlength="255" /> 
        </t-input-group>
        <t-input-group v-if="r.config.cf_use_tel" label="전화번호"> <t-input :value="r.member.mb_tel" name="mb_tel" type="text"/> </t-input-group>
        <t-input-group v-if="r.config.cf_use_hp" label="휴대폰번호"> <t-input :value="r.member.mb_hp" type="text"/> </t-input-group>
        <div v-if="r.config.cf_use_addr">
          <t-input-group > 
            <template v-slot:label>
              주소
              <t-button variant="primary" type="button" class="p-1 ml-3" @click="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon')"> 우편번호 </t-button>
            </template>
            <t-input :value="r.member.mb_id" name="mb_zip" type="text"/> 
          </t-input-group>
          <t-input-group> <t-input :value="r.member.mb_addr1" size="50" name="mb_addr1" placeholder="기본주소" type="text"/> </t-input-group>
          <t-input-group> <t-input :value="r.member.mb_addr2" size="50" name="mb_addr2" placeholder="상세주소" type="text"/> </t-input-group>
          <t-input-group> <t-input :value="r.member.mb_addr3" size="50" name="mb_addr3" placeholder="참고항목" type="text"/> </t-input-group>
          <input type="hidden" name="mb_addr_jibeon" :value="r.member.mb_addr_jibeon">
        </div>
      </t-card>
      <t-card header="기타 개인설정" class="my-4">
        <t-input-group v-if="r.config.cf_use_signature" label="서명"> <t-textarea name="mb_signature" placeholder="서명" type="text" class="dark:bg-gray-600 dark:text-gray-300 w-full bg-gray-100 border h-20 rounded p-3"> {{r.member.mb_signature}} </t-textarea> </t-input-group>
        <t-input-group v-if="r.config.cf_use_profile" label="자기소개"> <t-textarea name="mb_profile" placeholder="자기소개" type="text" class="dark:bg-gray-600 dark:text-gray-300 w-full bg-gray-100 border h-20 rounded p-3"> {{r.member.mb_profile}} </t-textarea> </t-input-group>
        <t-input-group v-if="r.config.cf_use_member_icon" label="회원아이콘" :feedback="r.config.cf_member_icon_height + '. gif, jpg, png파일만 가능하며 용량 '+ r.config.cf_member_icon_size + '바이트 이하'">
          <t-input name="mb_icon" type="file"/>
        </t-input-group>
        <t-input-group v-if="r.member.mb_level >= r.config.cf_icon_level && r.config.cf_member_img_size && r.config.cf_member_img_width && r.config.cf_member_img_height" label="회원이미지" feedback="60x60. gif, jpg, png파일만 가능하며 용량 5,0000바이트 이하">
          <t-input name="mb_img" type="file"/>
        </t-input-group>
        <label class="flex items-center my-1">
          <t-checkbox name="mb_mailling" value="a" />
          <span class="ml-2 text-sm">정보 메일을 받겠습니다.</span>
        </label>
        <label class="flex items-center my-1" v-if="r.config.cf_use_hp">
          <t-checkbox name="mb_sms" value="a" />
          <span class="ml-2 text-sm">휴대폰 문자메세지를 받겠습니다.</span>
        </label>
        <label class="flex items-center my-1">
          <t-checkbox name="mb_open" value="a" />
          <span class="ml-2 text-sm">다른분들이 나의 정보를 볼 수 있도록 합니다.</span>
        </label>
        <t-input-group v-if="r.w == 'none' && r.config.cf_use_recommend==1" class="w-48"> <t-input :value="r.member.mb_id" id="reg_mb_recommend" name="mb_recommend" placeholder="추천인 아이디" type="text"/> </t-input-group>
        <t-input-group label="캡차" >
          <div ref="captcha" class="flex">
            <div v-append="cf_captcha_html" v-if="cf_captcha != 'kcaptcha'"> </div>
          </div>
          <button @click="captcha" type="button"> 캡차 갱신 </button>
        </t-input-group>
      </t-card>
      <div class="w-full">
        <t-button class="w-1/2 text-center" type="button" @click="$router.push('/')"> 취소 </t-button>
        <t-button class="w-1/2 text-center" type="submit" variant="primary"> {{r.w ? '정보수정' : '회원가입'}} </t-button>
      </div>
    </form>
  </div>
  <div v-else class="m-5">
    <t-card>
      <template v-slot:header >
        비밀번호를 입력하세요
      </template>
      <form name="fboardpassword" ref="fboardpassword" method="post" @submit.prevent="regsiter_modify">
        <label for="pw_wr_password" class="sound_only">비밀번호<strong>필수</strong></label>
        <t-input placeholder="비밀번호" id="pw_wr_password" type="password" name="wr_password"/>
      </form>
      <template v-slot:footer>
        <div class="flex justify-between">
          <t-button type="submit" @click="regsiter_modify"> 확인 </t-button>
        </div>
      </template>
    </t-card>
  </div>
</template>

<script>
import captcha from '../../mixin/captcha.js'
export default {
  mixins : [captcha],
  props : ['isLogin'],
  name : 'register',
  data () {
    return {
      agree : false,
      c : null,
      r : null,
      valid : false,
    }
  },
  created () {
    let self = this;
    window.req_api({
      isLogin : true,
    }).then(function(json) {        
      if(json.mb_id != '') {
        self.$store.state.isLogin = true;
        self.$store.state.member = json;
      }else{
        window.req_api({
          register : true,
        }).then(function(json){
          self.c = json;
          document.title = json.g5.title;
          console.log('c', json);
        });
      }
    });
  },
  methods : {
    win_zip (frm_name, frm_zip, frm_addr1, frm_addr2, frm_addr3, frm_jibeon) {
      var g5_is_mobile = false;
      if(typeof daum === 'undefined'){
        alert("다음 우편번호 postcode.v2.js 파일이 로드되지 않았습니다.");
        return false;
      }
      var zip_case = 1;   //0이면 레이어, 1이면 페이지에 끼워 넣기, 2이면 새창
      var complete_fn = function(data){
        // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
        // 각 주소의 노출 규칙에 따라 주소를 조합한다.
        // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
        var fullAddr = ''; // 최종 주소 변수
        var extraAddr = ''; // 조합형 주소 변수
        // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
        if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
          fullAddr = data.roadAddress;
        } else { // 사용자가 지번 주소를 선택했을 경우(J)
          fullAddr = data.jibunAddress;
        }
        // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
        if(data.userSelectedType === 'R'){
            //법정동명이 있을 경우 추가한다.
            if(data.bname !== ''){
                extraAddr += data.bname;
            }
            // 건물명이 있을 경우 추가한다.
            if(data.buildingName !== ''){
                extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
            }
            // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
            extraAddr = (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
        }
        // 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
        var of = document[frm_name];
        of[frm_zip].value = data.zonecode;
        of[frm_addr1].value = fullAddr;
        of[frm_addr3].value = extraAddr;
        if(of[frm_jibeon] !== undefined){
            of[frm_jibeon].value = data.userSelectedType;
        }
        setTimeout(function(){
            of[frm_addr2].focus();
        } , 100);
      };
      switch(zip_case) {
        case 1 :    //iframe을 이용하여 페이지에 끼워 넣기
          var daum_pape_id = 'daum_juso_page'+frm_zip,
              element_wrap = document.getElementById(daum_pape_id),
              currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
          if (element_wrap == null) {
              element_wrap = document.createElement("div");
              element_wrap.setAttribute("id", daum_pape_id);
              element_wrap.style.cssText = 'display:none;border:1px solid;left:0;width:100%;height:300px;margin:5px 0;position:relative;-webkit-overflow-scrolling:touch;';
              element_wrap.innerHTML = '<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-21px;z-index:1" class="close_daum_juso" alt="접기 버튼">';
              // eslint-disable-next-line no-undef
              $('form[name="'+frm_name+'"]').find('input[name="'+frm_addr1+'"]').before(element_wrap);
              // eslint-disable-next-line no-undef
              $("#"+daum_pape_id).off("click", ".close_daum_juso").on("click", ".close_daum_juso", function(e){
                  e.preventDefault();
                  // eslint-disable-next-line no-undef
                  $(this).parent().hide();
              });
          }
          // eslint-disable-next-line no-undef
          // eslint-disable-next-line no-undef
          new daum.Postcode({
            oncomplete: function(data) {
                complete_fn(data);
                // iframe을 넣은 element를 안보이게 한다.
                element_wrap.style.display = 'none';
                // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
                document.body.scrollTop = currentScroll;
            },
            // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분.
            // iframe을 넣은 element의 높이값을 조정한다.
            onresize : function(size) {
                element_wrap.style.height = size.height + "px";
            },
            maxSuggestItems : g5_is_mobile ? 6 : 10,
            width : '100%',
            height : '100%'
          }).embed(element_wrap);
          // iframe을 넣은 element를 보이게 한다.
          element_wrap.style.display = 'block';
          break;
        case 2 :    //새창으로 띄우기
          // eslint-disable-next-line no-undef
          new daum.Postcode({
              oncomplete: function(data) {
                  complete_fn(data);
              }
          }).open();
          break;
        default :   //iframe을 이용하여 레이어 띄우기
          var rayer_id = 'daum_juso_rayer'+frm_zip,
              element_layer = document.getElementById(rayer_id);
          if (element_layer == null) {
              element_layer = document.createElement("div");
              element_layer.setAttribute("id", rayer_id);
              element_layer.style.cssText = 'display:none;border:5px solid;position:fixed;width:300px;height:460px;left:50%;margin-left:-155px;top:50%;margin-top:-235px;overflow:hidden;-webkit-overflow-scrolling:touch;z-index:10000';
              element_layer.innerHTML = '<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" class="close_daum_juso" alt="닫기 버튼">';
              document.body.appendChild(element_layer);
              // eslint-disable-next-line no-undef
              jQuery("#"+rayer_id).off("click", ".close_daum_juso").on("click", ".close_daum_juso", function(e){
                  e.preventDefault();
                  // eslint-disable-next-line no-undef
                  jQuery(this).parent().hide();
              });
          }
          // eslint-disable-next-line no-undef
          new daum.Postcode({
              oncomplete: function(data) {
                  complete_fn(data);
                  // iframe을 넣은 element를 안보이게 한다.
                  element_layer.style.display = 'none';
              },
              maxSuggestItems : g5_is_mobile ? 6 : 10,
              width : '100%',
              height : '100%'
          }).embed(element_layer);
          // iframe을 넣은 element를 보이게 한다.
          element_layer.style.display = 'block';
      }
    },
    social_popup(href) {
      var url = window.location.protocol + "//" + window.location.host;
      url = 'http://localhost/g5'
      var pop_url = url + "/plugin/social/popup.php?provider="+href+"&url=" + url
      var newWin = window.open(
        pop_url, 
        "social_sing_on", 
        "location=0,status=0,scrollbars=1,width=600,height=500"
      );
      if(!newWin || newWin.closed || typeof newWin.closed=='undefined')
      alert('브라우저에서 팝업이 차단되어 있습니다. 팝업 활성화 후 다시 시도해 주세요.');
    },
    regsiter_modify () {
      let self = this;
      console.log(self.$store.state.member.mb_id);
      this.agree = true;
      window.req_api({
        register_form : true,
        agree : "1",
        agree2 : "1",
        w : "u",
        mb_id : self.$store.state.member.mb_id,
        mb_password : document.getElementById('pw_wr_password').value,
      }).then(function(json){
        if(json.msg){
          alert(json.msg);
        }else{
          self.agree = true;
          self.r = json;
          document.title = json.g5.title;
          self.cf_captcha = json.config.cf_captcha;
          self.cf_captcha_text = json.captcha;
          self.cf_captcha_html = json.captcha_html;
          self.captcha_modify = true;
          self.captcha();
        }
      });
    },
    chkall() {
      if(this.$refs.chk_all.$el.checked) {
        this.$refs.agree.$el.checked = true;
        this.$refs.agree2.$el.checked = true;
      }else{
        this.$refs.agree.$el.checked = false;
        this.$refs.agree2.$el.checked = false;
      }
    },
    register() {
      var agree = this.$refs.agree.$el.checked;
      var agree2 = this.$refs.agree2.$el.checked;
      let self = this;
      if(agree && agree2) {
        this.agree = true;
        window.req_api({
          register_form : true,
          agree : "1",
          agree2 : "1",
        }).then(function(json){
          self.r = json;
          document.title = json.g5.title;
          self.cf_captcha = json.config.cf_captcha;
          self.cf_captcha_text = json.captcha;
          self.cf_captcha_html = json.captcha_html;
          self.captcha();
          console.log(json);
        });
      } else{
        alert('회원가입 약관에 동의해주십시오');
      }
    },
    async reg_mb_id_check () { //회원 ID 검사
      let self = this;
      var f = this.$refs.fregisterform;
      if (f.w.value == "none") {
        return window.req_api({
          register_form_valid : true,
          reg_mb_id_check : true,
          "reg_mb_id": encodeURIComponent(document.querySelector("#reg_mb_id").value)
        }).then(function(json){
          if(json.msg){
            alert(json.msg);
            f.mb_id.select();
            self.valid = false;
          }else{
            self.valid = true;
          }
        });
      }
    },
    async reg_mb_nick_check () {
      let self = this;
      var f = this.$refs.fregisterform;
      if ((f.w.value == "none") || (f.w.value == "u" && f.mb_nick_default.value != f.mb_nick.value)) {
        window.req_api({
          register_form_valid : true,
          reg_mb_nick_check : true,
          "reg_mb_nick": (document.querySelector("#reg_mb_nick").value),
          "reg_mb_id": encodeURIComponent(document.querySelector("#reg_mb_id").value)
        }).then(function(json){
          if(json.msg){
            alert(json.msg);
            f.reg_mb_nick.select();
            self.valid = false;
          }else{
            self.valid = true;
          }
        })
      }
    },
    async reg_mb_email_check () {
      let self = this;
      var f = this.$refs.fregisterform;
      if(this.r.config.cf_use_email_certify){
        if ((f.w.value == "none") || (f.w.value == "u" && f.old_email.value != f.mb_email.value)) {
          window.req_api({
            register_form_valid : true,
            reg_mb_email_check : true,
            "reg_mb_email": (document.querySelector("#reg_mb_email").value),
            "reg_mb_id": encodeURIComponent(document.querySelector("#reg_mb_id").value)
          }).then(function(json){
            if(json.msg){
              alert(json.msg);
              f.reg_mb_email.select();
              self.valid = false;
            }else{
              self.valid = true;
            }
          })
        }
      }
    },
    async reg_mb_hp_check () {
      let self = this;
      var f = this.$refs.fregisterform;
      window.req_api({
        register_form_valid : true,
        reg_mb_hp_check : true,
        "reg_mb_hp": (document.querySelector("#reg_mb_hp").value),
        "reg_mb_id": encodeURIComponent(document.querySelector("#reg_mb_id").value)
      }).then(function(json){
        if(json.msg){
          alert(json.msg);
          f.reg_mb_hp.select();
          self.valid = false;
        }else{
          self.valid = true;
        }
      })
    },
    async reg_mb_recommend_check () {
      let self = this;
      var f = this.$refs.fregisterform;
      if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
        if (f.mb_id.value == f.mb_recommend.value) {
          alert("본인을 추천할 수 없습니다.");
          f.mb_recommend.focus();
          self.valid = false;
        }
        window.req_api({
          register_form_valid : true,
          reg_mb_recommend_check : true,
          "reg_mb_recommend": encodeURIComponent(document.querySelector("#reg_mb_recommend").value)
        }).then(function(json){
          if(json.msg){
            alert(json.msg);
            f.mb_recommend.select();
            self.valid = false;
          }
        })
      }
    },
    async fregisterform_submit () {
      let self = this;
      var f = this.$refs.fregisterform;
      var formData = new FormData(f);
      await this.reg_mb_id_check();
      await this.reg_mb_nick_check();
      await this.reg_mb_email_check();
      //await this.reg_mb_recommend_check();
      if (f.w.value == "") {
        if (f.mb_password.value.length < 3) {
          alert("비밀번호를 3글자 이상 입력하십시오.");
          f.mb_password.focus();
          self.valid = false;
        }
      }
      if (f.mb_password.value != f.mb_password_re.value) {
        alert("비밀번호가 같지 않습니다.");
        f.mb_password_re.focus();
        self.valid = false;
      }
      if (f.mb_password.value.length > 0) {
        if (f.mb_password_re.value.length < 3) {
          alert("비밀번호를 3글자 이상 입력하십시오.");
          f.mb_password_re.focus();
          self.valid = false;
        }
      }
      // 이름 검사
      if (f.w.value=="") {
        if (f.mb_name.value.length < 1) {
          alert("이름을 입력하십시오.");
          f.mb_name.focus();
          self.valid = false;
        }
      }        
      if (typeof f.mb_icon != "undefined") {
        if (f.mb_icon.value) {
            if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                alert("회원아이콘이 이미지 파일이 아닙니다.");
                f.mb_icon.focus();
                self.valid = false;
            }
        }
      }
      if (typeof f.mb_img != "undefined") {
        if (f.mb_img.value) {
          if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
            alert("회원이미지가 이미지 파일이 아닙니다.");
            f.mb_img.focus();
            self.valid = false;
          }
        }
      }
      
      formData.append('register_form_update', true);
      await fetch(window.url, {
        method: "post",
        body: formData,
      })
      .then(function(response) {
        return response.json();
      })
      .then(function(data){
        if(data.msg) {
          alert(data.msg);
          self.captcha();
        }else{
          console.log(self);
          //self.$route.push('/');
        }
      });
    },
  }
}
</script>

<style lang="scss" scoped>

</style>