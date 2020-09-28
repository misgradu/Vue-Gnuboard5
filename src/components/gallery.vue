
<template>
  <div class="mx-3">
    <div v-masonry transition-duration="1s" item-selector=".item" class="masonry-container w-full mb-16 ">
      <div
      v-for="(row, i) in list" :key="i" 
      v-masonry-tile
      class="item bg-white dark:bg-gray-900 border-t border-r border-l mx-3 relative block my-3 dark:border-gray-400" style="max-height:30rem;max-width:200px;">
      <router-link :to="row.href">
        <div class="p-3 border-b dark:boder-gray-400"> {{row.subject}} </div>
        <img class="text-center w-full text-center flex justify-around bg-white dark:bg-gary-900 " :src="row.thumbnail.src" :width="row.thumbnail.width+'px'" :height="row.thumbnail.height+'px'">        
        <div class="p-3 text-gray-600 bg-white dark:bg-gray-900 border-b border-t">
          <div class="text-xs flex justify-between whitespace-no-wrap"> 
            <div class="pr-3"> <i class="far fa-eye"></i> {{row.wr_hit}} </div>
            <div class="pr-2"> <i class="far fa-clock"></i> {{row.wr_datetime}} </div>
          </div>
        </div>
      </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'gallery',
  props : ['list', 'g'],
  data () {
    return {
      maxWidth : window.innerWidth + (32 * 5)
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.thumb img {
  @apply w-full h-auto max-w-xs;
}
.thumb img {
  width:100%;
}
</style>
