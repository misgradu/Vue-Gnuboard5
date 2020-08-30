<template>
  <div class="m-5">
    현재접속자
    <div v-if="list.length > 0">
      <div v-for="row in list" :key="row.num">
        <div class="grid grid-rows-2 grid-col-12 grid-flow-col border-b py-2 gap-1 bg-white shadow my-4">
          <div class="row-span-2 col-span-1 flex items-center justify-center text-2xl">{{row.num}}</div>
          <div class="row-span-1 col-span-11 text-sm" v-html="row.name"> </div>
          <div class="row-span-1 col-span-11 text-gray-500 text-sm"> {{row.lo_location}} </div>
        </div>
      </div>
    </div>
    <div v-else>
      <div class="p-5 text-center shadow bg-white"> 접속자가 없습니다 </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      list : [],
    }
  },
  created () {
    let self = this;
    window.req_api({
      current_connect : true,
    }).then(function(json){
      self.list = json;
      console.log(json);
    })
  }
}
</script>

<style lang="scss" scoped>

</style>