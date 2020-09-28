
<template>
  <div class="mx-3">
  <masonry
    :cols="{default: 3, 769: 2, 400: 1}"
    :gutter="{default: '30px', 700: '15px'}"
  >
    <div v-for="(row, i) in list" :key="i" class="bg-white dakr:bg-gray-900 border shadow-lg">
      <!--<header class="p-3 border-b dark:boder-gray-400"> {{row.subject}} </header>-->
      <router-link :to="row.href" class="max-w-xs relative">
        <div v-if="row.thumbnail" v-html="row.thumbnail" class="thumb w-full h-auto max-w-xs"> </div>
      </router-link>
      <!--
      <div v-if="row.thumbnail" v-html="row.thumbnail">
      </div>
      <div v-else class="flex select-none items-center justify-center dark:text-gray-400 h-16">
        {{row.subject}}
      </div>
      <footer class="p-3">
        <div class="text-xs flex justify-between whitespace-no-wrap"> 
          <div> <i class="far fa-eye"></i> {{row.wr_hit}} </div>
          <div> <i class="far fa-clock"></i> {{row.wr_datetime}} </div>
        </div>
      </footer>
      -->
    </div>
  </masonry>
  </div>
</template>

<script>
export default {
  name: 'gallery',
  props : ['list', 'g'],
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
