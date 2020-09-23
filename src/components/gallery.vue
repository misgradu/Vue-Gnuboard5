
<template>
  <div class="mx-3">
    <t-card v-for="(row, i) in list" :key="i" class="w-1/2 md:w-1/3">
      <template v-slot:header>
        <div> {{row.subject}} </div>
      </template>
      <router-link :to="row.href">
      <div v-if="row.thumbnail">
      </div>
      <div v-else class="flex select-none items-center justify-center dark:text-gray-400 h-16 w-full">
        이미지가 없습니다
      </div>
      </router-link>
      <template v-slot:footer>
        <div class="text-xs flex justify-between"> 
          <div> <i class="far fa-eye"></i> {{row.wr_hit}} </div>
          <div> <i class="far fa-clock"></i> {{row.wr_datetime}} </div>
        </div>
      </template>
    </t-card>
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
</style>
