<template>
  <div v-if="p" class="m-5">
    
    <t-card class="shadow bg-white" v-if="p.member.mb_nick"> 
      <template v-slot:header>
        <div> {{p.member.mb_nick}}님의 포인트 내역 </div>
      </template>
        <div class="p-3 border-2 border-blue-500 bg-blue-300 rounded flex justify-between dark:bg-blue-900"> 
          <div> 보유포인트 </div>
          <div> {{p.member.mb_point | number_format}} </div>
        </div>
        <div v-for="row in list" :key="row.po_id">
          <div class="flex justify-between items-center py-2 border-b dark:border-gray-600">
            <div class="inline-block"> 
              <p class="text-bold text-sm"> {{row.po_content}} </p>
              <p class="text-sm text-gray-500"> <i class="far fa-clock"></i> {{row.po_datetime}} </p>
            </div>
            <div class="text-blue-500 font-bold"> {{row.po_point}} </div>
          </div>
        </div>
        <div class="p-3 border-2 border-gray-500 bg-gray-300 rounded flex justify-between dark:bg-gray-700 mt-4"> 
          <div> 소계 </div>
          <div> {{p.member.mb_point | number_format}} </div>
        </div>
      <template v-slot:footer>
        <t-pagination
        :total-items="p.total_count"
        :per-page="p.rows"
        :limit="p.perPage"
        :disabled="false"
        v-model="p.page"
        @change="pageMove"
        />
      </template>
    </t-card>
  </div>
</template>

<script>
export default {
  data () {
    return {
      p : {
        member : {mb_nick : null}
      },
      list : [],
    }
  },
  created () {
    let self = this;
    window.req_api({
      point : true,
    }).then(function(json){
      self.p = json;
      self.list = json.list;
      console.log('point', json);
    })
  },
  methods : {
    async pageMove (page) {
      let self = this;
      window.req_api({
        point : true,
        page : page,
      }).then(function(json){
        self.p = json;
        self.list = json.list;
      })
    },
  }
}
</script>

<style lang="scss" scoped>

</style>