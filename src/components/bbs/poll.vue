<template>
  <t-card v-if="poll" class="dark:bg-gray-900">
      <template v-slot:header>
        <div class="flex justify-between items-center"> 
          설문조사
          <t-button variant="" class="dark:bg-gray-900 dark:border-gray-500" @click="poll_result"> 결과보기 </t-button>
        </div>
      </template>
      <form ref="fpoll" @submit.prevent="poll_submit">
        {{poll.po_subject}}
        <input type="hidden" name="po_id" :value="poll.po_id"/>
        <t-radio-group variant="buttons" name="gb_poll" class="w-full my-2 dark:bg-gray-900" :options="list"></t-radio-group>
        <t-button variant="primary" class="w-full"> 투표하기 </t-button>
      </form>
      <t-modal variant="clean" ref="poll_result" class="">
        <template v-slot:header>
          <div>
            설문조사 결과
          </div>
        </template>
        <div v-if="result">
          <div class="border rounded">
            <h2 class="text-center p-3 bg-blue-100 font-bold"> {{result.po_subject}} </h2>
            <div v-for="row in result.list" :key="row.num" class="my-4">
              <h2 class="flex justify-between px-3"> <span> {{row.num}}. {{row.content}} </span> <span> {{row.cnt}}표</span> </h2>
              <div class="flex my-1 mx-3">
                <div class="w-11/12">
                  <div class="w-full h-full rounded-full">
                    <div :style="{width : row.rate+'%'}" class="bg-blue-500 h-full rounded"> </div>
                  </div>
                </div>
                <div class="w-1/12 whitespace-no-wrap text-center"> {{row.rate}} % </div>
              </div>
            </div>
          </div>
          <div class="border mt-4">
            <h2 class="p-3 font-bold">
              <t-tag tag-name="span" variant="badge">기타의견</t-tag>
              {{result.po_etc}} 
            </h2>
            <t-input placeholder="의견을 입력해주세요" name="pc_idea" class="p-3 h-20 w-full" />
          </div>
          <t-input type="text" name="pc_name" id="pc_name" required="" class="mt-5" size="20" placeholder="이름" />
          <div class="flex justify-between mt-5 items-center">
            캡차
            <t-button variant="primary"> 의견 남기기 </t-button>
          </div>
          <div class="mt-5"> 
            <h2 class="font-bold"> 다른 투표 결과 보기 </h2>
            <div v-for="row in result.list3" :key="row.po_id" class="my-4 flex justify-between px-3 text-sm border py-3">
              <div> {{row.subject}} </div>
              <div> {{row.date}} </div>
            </div>
          </div>
        </div>
        <template v-slot:footer>
          <t-button type="button" variant="error" class="w-full" @click="$refs.poll_result.hide()">
            닫기
          </t-button>
        </template>
      </t-modal>
  </t-card>
</template>

<script>
export default {
  data () {
    return {
      poll : null,
      list : [],
      result : null,
    }
  },
  methods : {
    poll_submit () {
      let self = this;
      var f = this.$refs.fpoll;
      console.log(f);
      var formData = new FormData(f);
      formData.append('poll_update', true);
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
        }
        self.poll_result();
      });
    },
    poll_result () {
      let self = this;
      var f = this.$refs.fpoll;
      var formData = new FormData(f);
      formData.append('poll_result', true);
      fetch(window.url, {
        method: "post",
        body: formData,
      })
      .then(function(response) {
        return response.json();
      })
      .then(function(data){
        self.result = data;
        self.$refs.poll_result.show();
      });
    }
  },
  created () {
    let self = this;
    window.req_api({
      poll : true,
    }).then(function(json) {
      self.poll = json;
      if(json.po_poll1) self.list.push({label : json.po_poll1, value : 1});
      if(json.po_poll2) self.list.push({label : json.po_poll2, value : 2});
      if(json.po_poll3) self.list.push({label : json.po_poll3, value : 3});
      if(json.po_poll4) self.list.push({label : json.po_poll4, value : 4});
      if(json.po_poll5) self.list.push({label : json.po_poll5, value : 5});
      if(json.po_poll6) self.list.push({label : json.po_poll6, value : 6});
      if(json.po_poll7) self.list.push({label : json.po_poll7, value : 7});
      if(json.po_poll8) self.list.push({label : json.po_poll8, value : 8});
      if(json.po_poll9) self.list.push({label : json.po_poll9, value : 9});
      console.log(self.list);
    });
  } 
}
</script>

<style lang="scss" scoped>

</style>