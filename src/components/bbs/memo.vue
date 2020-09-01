<template>
  <div>
    <div class="m-5" v-if="memo_form == false">
      <t-card>
        <template v-slot:header>
          <div class="-mx-4">
            <div class="pb-3 px-3 border-b"> {{$store.state.member.mb_nick}}님의 쪽지함 </div>
            <div class="px-2 pt-2 sm:px-3 flex">
              <router-link :to="{name : 'memo', query : { kind : 'recv'}}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-blue-900 focus:outline-none focus:text-white focus:bg-blue-700 transition duration-150 ease-in-out">받은쪽지</router-link>
              <router-link :to="{name : 'memo', query : { kind : 'send'}}" class="block px-3 py-2 rounded-md text-base font-medium text-blue-300 hover:text-white hover:bg-blue-700 focus:outline-none focus:text-white focus:bg-blue-700 transition duration-150 ease-in-out">보낸쪽지</router-link>
              <router-link :to="{name : 'memo', query : { kind : 'memo_form'}}" class="block px-3 py-2 rounded-md text-base font-medium text-blue-300 hover:text-white hover:bg-blue-700 focus:outline-none focus:text-white focus:bg-blue-700 transition duration-150 ease-in-out">쪽지쓰기</router-link>
            </div>
          </div>
        </template>
        <div v-if="list.length > 0">
          <div v-for="row in list" :key="row.me_id" class="pb-3">
            <div class="block border-b"> 
              <p class="my-3"> <span v-html="row.name"> </span> 님의 쪽지 </p>
              <p class="my-3 flex justify-between"> <router-link :to="row.view_href"> {{row.me_memo}} </router-link> <i class="far fa-trash-alt"></i> </p>
            </div>
            <div class="text-gray-500">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded bg-purple-100 text-purple-800"> {{row.bo_subject}} </span>
              <span class="text-xs ml-3"> {{row.ms_datetime}} </span>
            </div>
          </div>
        </div>
        <div class="p-5 text-center" v-if="list.length == 0">
          저장된 쪽지가 없습니다.
        </div>
        <t-alert variant="danger" show :dismissible="false">
          <i class="fa fa-info w-5 h-5"> </i> 쪽지 보관일수는 최장 180일 입니다.
        </t-alert>
      </t-card>
      <t-pagination
        :total-items="m.total_count"
        :per-page="m.perPage"
        :limit="5"
        :disabled="false"
        v-model="m.page"
        @change="page"
      />
    </div>
    <div class="m-5" v-if="memo_form == true">
      <t-card>
        <template v-slot:header>
          <div class="-mx-4">
            <div class="pb-3 px-3 border-b"> {{$store.state.member.mb_nick}}님의 쪽지함 </div>
            <div class="px-2 pt-2 sm:px-3 flex">
              <router-link :to="{name : 'memo', query : { kind : 'recv'}}" class="block px-3 py-2 rounded-md text-base font-medium text-blue-300 focus:outline-none focus:text-white focus:bg-blue-700 transition duration-150 ease-in-out">받은쪽지</router-link>
              <router-link :to="{name : 'memo', query : { kind : 'send'}}" class="block px-3 py-2 rounded-md text-base font-medium text-blue-300 hover:text-white hover:bg-blue-700 focus:outline-none focus:text-white focus:bg-blue-700 transition duration-150 ease-in-out">보낸쪽지</router-link>
              <router-link :to="{name : 'memo', query : { kind : 'memo_form'}}" class="block px-3 py-2 rounded-md text-base font-medium text-blue-300 hover:text-white hover:bg-blue-700 focus:outline-none focus:text-white focus:bg-blue-700 transition duration-150 ease-in-out">쪽지쓰기</router-link>
            </div>
          </div>
        </template>
        <form name="fmemoform" ref="fmemoform" @submit.prevent="fmemoform_submit" method="post" autocomplete="off">
          <label for="me_recv_mb_id" class="sound_only">받는 회원아이디<strong>필수</strong></label>
          <t-input name="me_recv_mb_id" class="mb-3" id="me_recv_mb_id" required size="47" placeholder="받는 회원아이디" />
          <p class="text-xs text-gray-500">여러 회원에게 보낼때는 컴마(,)로 구분하세요.</p>
          <p class="text-xs text-gray-500"  v-if="m.config.cf_memo_send_point">쪽지 보낼때 회원당 {{m.config.cf_memo_send_point}}점의 포인트를 차감합니다.</p>
          <label for="me_memo" class="sound_only">내용</label>
          <t-textarea v-model="m.content" class="w-full h-20 p-2 border rounded my-3" name="me_memo" id="me_memo" required />
          <span class="sound_only">자동등록방지</span>
          <div ref="captcha" class="flex mb-3"> </div>
          <t-button type="submit" variant="primary" id="btn_submit" class="btn btn_b02 reply_btn">보내기</t-button>
        </form>
      </t-card>
    </div>      
  </div>
</template>

<script>
import captcha from '../../mixin/captcha.js'
export default {
  mixins : [captcha],
  data () {
    return {
      m : {
        config : { cf_memo_send_point : null } ,
      },
      list : [],
      memo_form : false,
    }
  },
  created () {
    this.update();
  },
  methods : {
    page (page) {
      page = page ? page : 1;
      this.$router.push({name: 'memo', query : {page : page, kind : this.$route.query.kind}});
    },
    update () {
      let self = this;
      const kind = this.$route.query.kind ? this.$route.query.kind : 'recv';
      this.memo_form = false;
      if(kind == 'recv') {
        window.req_api({
          memo : true,
        }).then(function(json) {        
          self.m = json;
          self.list = json.list;
          if(json.g5.title) document.title = json.g5.title;
          self.captcha();
        });
      }else if(kind == 'send') {
        window.req_api({
          memo : true,
          kind : kind,
        }).then(function(json) {        
          self.m = json;
          self.list = json.list;
          if(json.g5.title) document.title = json.g5.title;
          self.captcha();
        });
      }else {
        this.memo_form = true;
        this.captcha_modify = true;
        window.req_api({
          memo : true,
          kind : kind,
        }).then(function(json) {
          self.cf_captcha_text = json.captcha;
          self.m = json;
          self.list = json.list;
          if(json.g5.title) document.title = json.g5.title;
          self.captcha();
        });
      }
    },
    fmemoform_submit () {
      let f = this.$refs.fmemoform;
      let formData = new FormData(f);
      console.log(formData);
      alert('보내기');
      formData.append('memo_form_update', true);
      fetch(window.url, {
        method: "post",
        body: formData,
      })
      .then(function(response) {
        return response.json();
      })
      .then(function(data){
        if(data.msg) {
          alert(data.msg);
        }else{
          console.log(self);
          self.$route.push('/');
        }
      });
    }
  }
}
</script>

<style scoped>
/*
.router-link-active{
  @apply text-white bg-blue-900
}
*/
</style>