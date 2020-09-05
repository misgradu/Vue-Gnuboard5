<template>
  <div class="dark:bg-gray-700 h-full dark:text-gray-400">
    <div class="grid sm:grid-flow-row-dense md:grid-flow-row-dense lg:grid-flow-row-dense xl:grid-flow-col">
      <div class="my-3 mx-2" v-for="rows in list" :key="rows.wr_id">
        <t-card v-if="rows.length > 0"
          :classes="{
            wrapper: 'bg-white dark:bg-gray-900',
            body: 'flex-grow',
            close: {'text-teal-500 hover:bg-teal-200 ml-4 rounded': true},
            closeIcon: ['h-5', 'w-5', 'fill-current']
          }">
          <template v-slot:header>
            <div class="flex justify-between items-center">
              <router-link class="hover:text-teal-500" :to="'/'+rows[0].bo_table"> {{rows[0].bo_subject}} </router-link>
              <router-link class="text-xs hover:text-teal-500" :to="'/'+rows[0].bo_table"> 더보기 </router-link>
            </div>
          </template>
          <div v-for="row in rows" :key="row.wr_id">
            <ul class="flex justify-between items-center">
              <li> 
                <router-link class="hover:text-teal-500" :to=row.href> 
                  {{row.subject}} 
                  <span v-if="row.icon_new" class="bg-green-400 px-1 rounded text-white text-xs">N</span>
                  <i v-if="row.icon_hot" class="ml-1 text-red-700 fab fa-hotjar"></i>
                  <i v-if="row.icon_file" class="ml-1 text-gray-700 dark:text-gray-400 fas fa-download"></i>
                  <i v-if="row.icon_link" class="ml-1 text-gray-700 dark:text-gray-400 fas fa-link"></i>
                  <i v-if="row.icon_secret" class="ml-1 text-gray-700 dark:text-gray-400 fas fa-lock"></i>
                  <span v-if="row.comment_cnt" class="mx-1"> <span class="sound_only">댓글</span><span class="bg-blue-500 text-white text-xs px-1 rounded">{{row.wr_comment}}</span><span class="sound_only">개</span></span>
                </router-link> 
              </li>
              <li class="text-sm"> {{row.last2}} </li>
            </ul>
          </div>
        </t-card>
        <t-card v-else
        :classes="{
            wrapper: 'bg-white dark:bg-gray-900',
            body: 'flex-grow',
            close: {'text-teal-500 hover:bg-teal-200 ml-4 rounded': true},
            closeIcon: ['h-5', 'w-5', 'fill-current']
          }">
          <template v-slot:header>
            <div class="flex justify-between items-center">
              <router-link class="hover:text-teal-500" :to="'/'+rows.bo_table"> {{rows.bo_subject}} </router-link>
              <router-link class="text-xs hover:text-teal-500" :to="'/'+rows.bo_table"> 더보기 </router-link>
            </div>
          </template>
          <div>
            <ul class="flex justify-center items-center ">
              게시물이 없습니다.
            </ul>
          </div>
        </t-card>        
      </div>
    </div>
    <div class="flex">
      <div class="w-1/2 mx-2">
        <poll> </poll>
      </div>
      <div class="w-1/2 mx-2">
        <t-card v-if="$store.state.visit.today" header="접속자집계" class="dark:bg-gray-900" >
          <div class="grid grid-cols-2">
            <div> {{$store.state.visit.today}} </div>
            <div> {{$store.state.visit.yesterday}} </div>
            <div> {{$store.state.visit.max}} </div>
            <div> {{$store.state.visit.all}} </div>
          </div>
        </t-card>
      </div>
    </div>
  </div>
</template>

<script>
import latest from './mixin/latest.js'
import poll from './components/bbs/poll'
export default {
  mixins: [latest],
  name: 'index',
  components: {
    //'gnu-footer' : tail,
    'poll' : poll,
  },
  data () {
    return {
      list : [],
    }
  },
  created () {
    this.latest('free','10','40').then((rows) => this.list.push(rows))
    this.latest('notice','10','40').then((rows) => this.list.push(rows))
    console.log(this.list);
  }
}
</script>

<style>
</style>
